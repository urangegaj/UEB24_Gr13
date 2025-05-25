<?php
require_once 'session_handler.php';
require_once '../config/db.php';
require_once 'models/User.php';

// Check if user is logged in
if (!isLoggedIn()) {
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
        // Get current user data
        $currentUser = getCurrentUser();
        
        // Validate required fields
        $required_fields = ['name', 'lastname', 'username', 'email'];
        foreach ($required_fields as $field) {
            if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
                throw new Exception("All fields are required");
            }
        }

        // Validate email format
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }

        // Update user data
        $updateData = [
            'first_name' => $_POST['name'],
            'last_name' => $_POST['lastname'],
            'username' => $_POST['username'],
            'email' => $_POST['email']
        ];

        // Only update password if provided
        if (!empty($_POST['password'])) {
            if (strlen($_POST['password']) < 8) {
                throw new Exception("Password must be at least 8 characters long");
            }
            $updateData['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        // Update user in database
        if ($user->update($currentUser['user_id'], $updateData)) {
            // Update session data
            $_SESSION['username'] = $updateData['username'];
            $_SESSION['first_name'] = $updateData['first_name'];
            $_SESSION['last_name'] = $updateData['last_name'];
            $_SESSION['email'] = $updateData['email'];

            $response['success'] = true;
            $response['message'] = "Profile updated successfully!";
        } else {
            throw new Exception("Failed to update profile");
        }
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response); 