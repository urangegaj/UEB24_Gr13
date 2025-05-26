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
    error_log("Login attempt started");
    
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    error_log("Received login data - Username: " . $username);
    
    if (empty($username) || empty($password)) {
        throw new Exception('Username and password are required');
    }
    
    error_log("Attempting to connect to database");
    $database = new Database();
    $conn = $database->getConnection();
    
    if (!$conn) {
        throw new Exception('Database connection failed');
    }
    
    error_log("Database connection successful");
    
    $user = new User($conn);
    error_log("User object created");
    
    $userData = $user->login($username, $password);
    error_log("Login attempt result: " . print_r($userData, true));
    
    if ($userData) {
        error_log("Login successful, setting session data");
        error_log("User data before setting session: " . print_r($userData, true));
        setSessionData($userData);
        
        session_regenerate_id(true);
        
        error_log("Session data after login: " . print_r($_SESSION, true));
        
        echo json_encode([
            'success' => true,
            'message' => 'Login successful',
            'user' => $userData
        ]);
    } else {
        error_log("Login failed - invalid credentials");
        echo json_encode([
            'success' => false,
            'message' => 'Invalid username or password'
        ]);
    }
} catch (Exception $e) {
    error_log("Login error: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

ob_end_flush();
?> 