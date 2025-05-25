<?php
require_once '../config/db.php';
require_once 'models/User.php';
require_once 'includes/session.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate input
        $required_fields = ['first_name', 'last_name', 'username', 'password', 'email', 'birthdate', 'gender'];
        foreach ($required_fields as $field) {
            if (!isset($_POST[$field]) || empty($_POST[$field])) {
                throw new Exception("All fields are required");
            }
        }

        // Validate email
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }

        // Validate password strength
        if (strlen($_POST['password']) < 8) {
            throw new Exception("Password must be at least 8 characters long");
        }

        // Check if username or email is already taken
        if ($user->isUsernameTaken($_POST['username'])) {
            throw new Exception("Username already exists");
        }
        if ($user->isEmailTaken($_POST['email'])) {
            throw new Exception("Email already exists");
        }

        // Set user properties
        $user->first_name = $_POST['first_name'];
        $user->last_name = $_POST['last_name'];
        $user->username = $_POST['username'];
        $user->password = $_POST['password'];
        $user->email = $_POST['email'];
        $user->birthdate = $_POST['birthdate'];
        $user->gender = $_POST['gender'];

        // Create the user
        if ($user->create()) {
            $response['success'] = true;
            $response['message'] = "Registration successful! Please login.";
        } else {
            throw new Exception("Unable to create user");
        }
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?> 