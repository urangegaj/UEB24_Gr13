<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

require_once __DIR__ . '/../includes/session.php';

function updateSessionData($data) {
    error_log("Updating session data with: " . print_r($data, true));
    foreach ($data as $key => $value) {
        $_SESSION[$key] = $value;
    }
    error_log("Session data after update: " . print_r($_SESSION, true));
}

function clearSession() {
    error_log("Clearing session data");
    session_unset();
    session_destroy();
    error_log("Session cleared");
}

if (isLoggedIn()) {
    error_log("Setting window.isLoggedIn to true");
    echo "<script>window.isLoggedIn = true;</script>";
} else {
    error_log("Setting window.isLoggedIn to false");
    echo "<script>window.isLoggedIn = false;</script>";
}
?> 