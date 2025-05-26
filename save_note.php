<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['note'])) {
    $note = trim($_POST['note']);
    $_SESSION['client_note'] = $note;

    echo json_encode(['note' => $note]);
    exit;
}
?>
