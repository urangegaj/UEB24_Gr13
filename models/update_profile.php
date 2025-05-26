<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/User.php';

// Check if user is logged in
if (!isLoggedIn()) {
    error_log("Update profile attempt without login. Session data: " . print_r($_SESSION, true));
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        error_log("Update profile request received: " . print_r($_POST, true));
        error_log("Files received: " . print_r($_FILES, true));
        
        $currentUser = getCurrentUser();
        if (!$currentUser) {
            throw new Exception("Could not retrieve current user data");
        }
        
        $required_fields = ['name', 'lastname', 'username', 'email'];
        foreach ($required_fields as $field) {
            if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
                throw new Exception("All fields are required");
            }
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }

        $updateData = [
            'first_name' => trim($_POST['name']),
            'last_name' => trim($_POST['lastname']),
            'username' => trim($_POST['username']),
            'email' => trim($_POST['email'])
        ];

        // Handle password update
        if (!empty($_POST['password'])) {
            if (strlen($_POST['password']) < 8) {
                throw new Exception("Password must be at least 8 characters long");
            }
            if (!preg_match('/[A-Z]/', $_POST['password'])) {
                throw new Exception("Password must contain at least one uppercase letter");
            }
            if (!preg_match('/[a-z]/', $_POST['password'])) {
                throw new Exception("Password must contain at least one lowercase letter");
            }
            if (!preg_match('/[0-9]/', $_POST['password'])) {
                throw new Exception("Password must contain at least one number");
            }
            $updateData['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        // Handle profile picture upload
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            error_log("Processing profile picture upload");
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $max_size = 5 * 1024 * 1024; // 5MB

            if (!in_array($_FILES['profile_picture']['type'], $allowed_types)) {
                throw new Exception("Invalid file type. Only JPG, PNG and GIF are allowed.");
            }

            if ($_FILES['profile_picture']['size'] > $max_size) {
                throw new Exception("File size too large. Maximum size is 5MB.");
            }

            $upload_dir = __DIR__ . '/../uploads/profile_pictures/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_extension = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
            $new_filename = 'profile_' . $currentUser['user_id'] . '_' . time() . '.' . $file_extension;
            $upload_path = $upload_dir . $new_filename;
            $relative_path = 'uploads/profile_pictures/' . $new_filename;

            error_log("Attempting to move uploaded file to: " . $upload_path);
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $upload_path)) {
                error_log("File uploaded successfully. Relative path: " . $relative_path);
                $updateData['profile_picture'] = $relative_path;
            } else {
                error_log("Failed to move uploaded file. Upload error: " . $_FILES['profile_picture']['error']);
                throw new Exception("Failed to upload profile picture");
            }
        }

        error_log("Attempting to update user profile for ID: " . $currentUser['user_id']);
        error_log("Update data with profile picture: " . print_r($updateData, true));
        if ($user->update($currentUser['user_id'], $updateData)) {
            error_log("Profile update successful");
            
            // Update session data
            $_SESSION['username'] = $updateData['username'];
            $_SESSION['first_name'] = $updateData['first_name'];
            $_SESSION['last_name'] = $updateData['last_name'];
            $_SESSION['email'] = $updateData['email'];
            if (isset($updateData['profile_picture'])) {
                $_SESSION['profile_picture'] = $updateData['profile_picture'];
                error_log("Updated session with profile picture: " . $updateData['profile_picture']);
            }

            $response['success'] = true;
            $response['message'] = "Profile updated successfully!";
        } else {
            error_log("Profile update failed");
            throw new Exception("Failed to update profile");
        }
    } catch (Exception $e) {
        error_log("Profile update error: " . $e->getMessage());
        $response['message'] = $e->getMessage();
    }
}

header('Content-Type: application/json');
echo json_encode($response); 