<?php
require_once '../config/db.php';
require_once 'models/User.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate required fields
        $required_fields = ['first_name', 'last_name', 'username', 'password', 'email', 'birthdate', 'gender'];
        foreach ($required_fields as $field) {
            if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
                throw new Exception("All fields are required");
            }
        }

        // Validate email format
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }

        // Validate password strength (minimum 8 characters)
        if (strlen($_POST['password']) < 8) {
            throw new Exception("Password must be at least 8 characters long");
        }

        // Validate gender
        $valid_genders = ['male', 'female', 'other'];
        if (!in_array($_POST['gender'], $valid_genders)) {
            throw new Exception("Invalid gender selection");
        }

        // Create user
        if ($user->create(
            $_POST['first_name'],
            $_POST['last_name'],
            $_POST['username'],
            $_POST['password'],
            $_POST['email'],
            $_POST['birthdate'],
            $_POST['gender']
        )) {
            $response['success'] = true;
            $response['message'] = "Registration successful! You can now login.";
        } else {
            throw new Exception("Registration failed. Username or email may already exist.");
        }
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response); 