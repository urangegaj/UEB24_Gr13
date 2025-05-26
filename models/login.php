<?php
ob_start();

error_reporting(E_ALL);
ini_set('display_errors', 0); // Disable display errors
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

require_once 'session_handler.php';

require_once 'config/database.php';
require_once 'models/User.php';

header('Content-Type: application/json');

try {
    error_log("Login attempt started");
    
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    error_log("Login attempt for username: " . $username);
    
    if (empty($username) || empty($password)) {
        throw new Exception('Username and password are required');
    }
    
    $database = new Database();
    $db = $database->getConnection();
    
    if (!$db) {
        throw new Exception("Database connection failed");
    }
    
    error_log("Database connection successful");
    
    $user = new User($db);

    if ($user->login($username, $password)) {
        error_log("Login successful for user: " . $username);
        
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
        
        updateSessionData([
            'user_id' => $user->id,
            'username' => $username,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'logged_in' => true,
            'last_activity' => time()
        ]);
        
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

ob_end_flush();
?> 