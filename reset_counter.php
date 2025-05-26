<?php
// Prevent any output before headers
ob_start();

require_once 'session_handler.php';

// Clear any previous output
ob_clean();

// Set JSON header
header('Content-Type: application/json');

try {
    // Reset the visit count using the session handler function
    $newCount = resetVisitCount();
    
    // Force session write
    session_write_close();
    
    // Clear any output buffer
    ob_clean();
    
    // Send JSON response
    echo json_encode([
        'success' => true,
        'message' => 'Visit counter reset successfully',
        'count' => $newCount
    ]);
} catch (Exception $e) {
    // Clear any output buffer
    ob_clean();
    
    error_log('Reset counter error: ' . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Failed to reset visit counter: ' . $e->getMessage()
    ]);
}

// End output buffering and send
ob_end_flush();
exit;
?> 