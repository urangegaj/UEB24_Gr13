<?php
// Start the session
session_start();

// Cookie management functions
function setUserPreferences($bgColor, $theme) {
    // Set cookies with 30 days expiry
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

// Session management functions
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

function clearSession() {
    session_unset();
    session_destroy();
}

// Theme management
function getThemeStyles() {
    $preferences = getUserPreferences();
    return [
        'theme' => $preferences['theme'],
        'background-color' => $preferences['bg_color'],
        'text-color' => $preferences['theme'] === 'dark' ? '#ffffff' : '#333333',
        'accent-color' => '#007bff'
    ];
}
?> 