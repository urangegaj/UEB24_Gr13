<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/User.php';

header('Content-Type: application/json');

try {
    error_log("Signup attempt started");
    
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $birthdate = $_POST['birthdate'] ?? '';
    $gender = $_POST['gender'] ?? '';
    
    error_log("Signup data received: " . print_r($_POST, true));
    
    if (empty($username) || empty($password) || empty($first_name) || empty($last_name) || empty($email) || empty($birthdate) || empty($gender)) {
        throw new Exception('All fields are required');
    }
    
    $database = new Database();
    $db = $database->getConnection();
    
    if (!$db) {
        throw new Exception("Database connection failed");
    }
    
    error_log("Database connection successful");
    
    $user = new User($db);
    
    if ($user->create($first_name, $last_name, $username, $password, $email, $birthdate, $gender)) {
        error_log("User registration successful for username: " . $username);
        echo json_encode([
            'success' => true,
            'message' => 'Registration successful'
        ]);
    } else {
        error_log("User registration failed for username: " . $username);
        throw new Exception('Registration failed. Username or email may already exist.');
    }
} catch (Exception $e) {
    error_log("Signup error: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

ob_end_flush();
?> 