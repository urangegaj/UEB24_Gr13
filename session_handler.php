<?php
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_secure', 0); // Set to 1 if using HTTPS
    ini_set('session.cookie_samesite', 'Lax');
    ini_set('session.gc_maxlifetime', 3600); // 1 hour
    ini_set('session.cookie_lifetime', 3600); // 1 hour
    ini_set('session.cookie_path', '/');
    
    session_start();
}

function setUserPreferences($bgColor, $theme) {
    setcookie('bg_color', $bgColor, time() + (86400 * 30), '/');
    setcookie('theme', $theme, time() + (86400 * 30), '/');
}

function getUserPreferences() {
    if (!isset($_SESSION['preferences'])) {
        $_SESSION['preferences'] = [
            'theme' => 'light',
            'bg_color' => '#f8f9fa'
        ];
    }
    return $_SESSION['preferences'];
}

function deleteUserPreferences() {
    setcookie('bg_color', '', time() - 3600, '/');
    setcookie('theme', '', time() - 3600, '/');
}

function incrementVisitCount() {
    if (!isset($_SESSION['visit_count'])) {
        $_SESSION['visit_count'] = 0;
    }
    $_SESSION['visit_count']++;
    return $_SESSION['visit_count'];
}

function getVisitCount() {
    return isset($_SESSION['visit_count']) ? $_SESSION['visit_count'] : 0;
}

function storeUserData($name, $email) {
    $_SESSION['user_data'] = [
        'name' => $name,
        'email' => $email,
        'last_visit' => date('Y-m-d H:i:s')
    ];
}

function getUserData() {
    return $_SESSION['user_data'] ?? null;
}

function getThemeStyles() {
    $preferences = getUserPreferences();
    return [
        'theme' => $preferences['theme'],
        'background-color' => $preferences['bg_color'],
        'text-color' => $preferences['theme'] === 'dark' ? '#ffffff' : '#333333',
        'accent-color' => '#007bff'
    ];
}

function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['username']) && isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function getCurrentUser() {
    if (isLoggedIn()) {
        return [
            'user_id' => $_SESSION['user_id'],
            'username' => $_SESSION['username'],
            'email' => $_SESSION['email'] ?? null,
            'first_name' => $_SESSION['first_name'] ?? null,
            'last_name' => $_SESSION['last_name'] ?? null
        ];
    }
    return null;
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: index.html');
        exit();
    }
}

function clearSession() {
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }
    session_destroy();
}

function updateSessionData($data) {
    foreach ($data as $key => $value) {
        $_SESSION[$key] = $value;
    }
}

function validateSession() {
    if (!isLoggedIn()) {
        clearSession();
        return false;
    }
    return true;
}

validateSession();
?> 