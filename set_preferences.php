<?php
require_once 'session_handler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $theme = $_POST['theme'] ?? 'light';
    $bgColor = $_POST['bg_color'] ?? '#f8f9fa';
    
    setUserPreferences($bgColor, $theme);
    
    // Send success response
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
} else {
    // Send error response
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['error' => 'Method not allowed']);
}
?> 