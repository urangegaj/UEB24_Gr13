<?php
// Prevent any output before headers
ob_start();

// Set error handling
error_reporting(E_ALL);
ini_set('display_errors', 0); // Disable display errors
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

// Include session handler
require_once 'session_handler.php';

// Include database connection
require_once '../config/db.php';

// Include required files
require_once 'models/User.php';

// Set headers
header('Content-Type: application/json');

try {
    error_log("Login attempt started");
    
    // Get POST data
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    error_log("Login attempt for username: " . $username);
    
    // Validate input
    if (empty($username) || empty($password)) {
        throw new Exception('Username and password are required');
    }
    
    // Create database connection
    $database = new Database();
    $db = $database->getConnection();
    
    if (!$db) {
        throw new Exception("Database connection failed");
    }
    
    error_log("Database connection successful");
    
    // Create User instance
    $user = new User($db);

    // Attempt login
    if ($user->login($username, $password)) {
        error_log("Login successful for user: " . $username);
        
        // Regenerate session ID for security
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
        
        // Update session data
        updateSessionData([
            'user_id' => $user->id,
            'username' => $username,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'logged_in' => true,
            'last_activity' => time()
        ]);
        
        // Log session data
        error_log("Session data after login: " . print_r($_SESSION, true));
        
        echo json_encode([
            'success' => true,
            'message' => 'Login successful',
            'user' => getCurrentUser()
        ]);
    } else {
        error_log("Login failed for user: " . $username);
        throw new Exception('Invalid username or password');
    }
} catch (Exception $e) {
    error_log("Login error: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

// Clear any output buffer
ob_end_flush();
?> 