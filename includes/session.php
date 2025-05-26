<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); 
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.gc_maxlifetime', 3600); 
ini_set('session.cookie_lifetime', 3600); 
ini_set('session.cookie_path', '/'); 
ini_set('session.save_handler', 'files');
ini_set('session.save_path', __DIR__ . '/../tmp/sessions');

if (!file_exists(__DIR__ . '/../tmp/sessions')) {
    mkdir(__DIR__ . '/../tmp/sessions', 0777, true);
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
    error_log("Session started in includes/session.php with ID: " . session_id());
    error_log("Session data: " . print_r($_SESSION, true));
}

function isLoggedIn() {
    error_log("Checking login status in includes/session.php. Session ID: " . session_id());
    error_log("Session data: " . print_r($_SESSION, true));
    
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        error_log("User is not marked as logged in");
        return false;
    }
    
    if (!isset($_SESSION['user_id']) || !is_numeric($_SESSION['user_id'])) {
        error_log("Invalid or missing user_id");
        return false;
    }
    
    if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
        error_log("Missing username");
        return false;
    }
    
    error_log("User is logged in with ID: " . $_SESSION['user_id']);
    return true;
}

function requireLogin() {
    if (!isLoggedIn()) {
        error_log("User not logged in, redirecting to index.php");
        error_log("Session data at redirect: " . print_r($_SESSION, true));
        header('Location: index.php');
        exit();
    }
}

function getCurrentUser() {
    if (isLoggedIn()) {
        return [
            'user_id' => $_SESSION['user_id'],
            'username' => $_SESSION['username'],
            'first_name' => $_SESSION['first_name'],
            'last_name' => $_SESSION['last_name'],
            'email' => $_SESSION['email'],
            'birthdate' => $_SESSION['birthdate'] ?? null,
            'gender' => $_SESSION['gender'] ?? null,
            'profile_picture' => $_SESSION['profile_picture'] ?? null,
            'logged_in' => true
        ];
    }
    return null;
}

function logout() {
    error_log("Logging out user. Session ID: " . session_id());
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

function setSessionData($userData) {
    $_SESSION = array();
    
    $_SESSION['user_id'] = $userData['user_id'];
    $_SESSION['username'] = $userData['username'];
    $_SESSION['first_name'] = $userData['first_name'];
    $_SESSION['last_name'] = $userData['last_name'];
    $_SESSION['email'] = $userData['email'];
    $_SESSION['birthdate'] = $userData['birthdate'] ?? null;
    $_SESSION['gender'] = $userData['gender'] ?? null;
    $_SESSION['profile_picture'] = $userData['profile_picture'] ?? null;
    $_SESSION['logged_in'] = true;
    $_SESSION['last_activity'] = time();
    
    error_log("Session data set: " . print_r($_SESSION, true));
}
?>
