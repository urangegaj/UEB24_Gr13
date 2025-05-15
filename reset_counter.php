<?php
session_start();

// Reset the visit count to 0
$_SESSION['visit_count'] = 0;

// Return success response
header('Content-Type: application/json');
echo json_encode(['success' => true]);
?> 