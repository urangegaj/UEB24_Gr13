<?php
// Include session handler
require_once 'session_handler.php';

header('Content-Type: application/json');

try {
    clearSession();
    
    echo json_encode([
        'success' => true,
        'message' => 'Logged out successfully'
    ]);
} catch (Exception $e) {
    error_log("Logout error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred during logout'
    ]);
}
?> 