<?php
require_once __DIR__ . '/session.php';

header('Content-Type: application/json');

$sessionState = [
    'isLoggedIn' => isLoggedIn(),
    'user' => getCurrentUser()
];

echo json_encode($sessionState); 