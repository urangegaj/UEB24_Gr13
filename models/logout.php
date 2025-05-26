<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

try {
    error_log("Starting logout process. Session ID: " . session_id());
    error_log("Session data before logout: " . print_r($_SESSION, true));
    
    $_SESSION = array();
    
    if (session_id()) {
        session_destroy();
    }
    
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }
    
    error_log("Logout successful. Session cleared.");
    
    echo json_encode([
        'success' => true,
        'message' => 'Logged out successfully'
    ]);
} catch (Exception $e) {
    error_log("Logout error: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred during logout'
    ]);
}
?> 