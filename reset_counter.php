<?php

ob_start();

require_once 'session_handler.php';


ob_clean();


header('Content-Type: application/json');

try {

    $count = resetVisitCount();
    

    session_write_close();
    

    ob_clean();
    

    echo json_encode([
        'success' => true,
        'count' => $count,
        'message' => 'Visit count reset successfully'
    ]);
} catch (Exception $e) {

    ob_clean();
    
    error_log('Reset counter error: ' . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Failed to reset visit count: ' . $e->getMessage()
    ]);
}


ob_end_flush();
exit;
?> 