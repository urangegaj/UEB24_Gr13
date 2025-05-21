<?php
require_once 'session_handler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($data['theme'])) {
        $theme = $data['theme'];
        $bgColor = $theme === 'dark' ? '#333333' : '#f8f9fa';
        
        // Update session preferences
        $_SESSION['preferences'] = [
            'theme' => $theme,
            'bg_color' => $bgColor
        ];
        
        // Set cookies for persistence
        setUserPreferences($bgColor, $theme);
        
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid request']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?> 