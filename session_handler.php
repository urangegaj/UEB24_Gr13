<?php
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_secure', 0); // Set to 1 if using HTTPS
    ini_set('session.cookie_samesite', 'Lax');
    ini_set('session.gc_maxlifetime', 3600); // 1 hour
    ini_set('session.cookie_lifetime', 3600); // 1 hour
    ini_set('session.cookie_path', '/ueb24__gr13/'); // Update this to match your project path
    
    session_start();
}

// Initialize session variables if they don't exist
if (!isset($_SESSION['visit_count'])) {
    $_SESSION['visit_count'] = 1;
}

function setUserPreferences($bgColor, $theme) {
    $_SESSION['preferences'] = [
        'theme' => $theme,
        'bg_color' => $bgColor
    ];
    
    // Set cookies that expire in 30 days
    setcookie('bg_color', $bgColor, time() + (86400 * 30), '/');
    setcookie('theme', $theme, time() + (86400 * 30), '/');
}

function getUserPreferences() {
    if (!isset($_SESSION['preferences'])) {
        $theme = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'light';
        $bgColor = isset($_COOKIE['bg_color']) ? $_COOKIE['bg_color'] : '#f8f9fa';
        
        $_SESSION['preferences'] = [
            'theme' => $theme,
            'bg_color' => $bgColor
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
        $_SESSION['visit_count'] = 1;
    } else {
        $_SESSION['visit_count'] = intval($_SESSION['visit_count']) + 1;
    }
    return $_SESSION['visit_count'];
}

function resetVisitCount() {
    $_SESSION['visit_count'] = 1;
    return $_SESSION['visit_count'];
}

function getVisitCount() {
    if (!isset($_SESSION['visit_count'])) {
        $_SESSION['visit_count'] = 1;
    }
    return $_SESSION['visit_count'];
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
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) && isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    
    return [
        'user_id' => $_SESSION['user_id'] ?? null,
        'username' => $_SESSION['username'] ?? null,
        'first_name' => $_SESSION['first_name'] ?? null,
        'last_name' => $_SESSION['last_name'] ?? null,
        'email' => $_SESSION['email'] ?? null,
        'logged_in' => true
    ];
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: index.php');
        exit();
    }
}

function clearSession() {
    session_unset();
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

// Check if user is logged in and set JavaScript variable
if (isLoggedIn()) {
    echo "<script>window.isLoggedIn = true;</script>";
} else {
    echo "<script>window.isLoggedIn = false;</script>";
}

// Handle theme switching via AJAX or form submission
if (isset($_POST['action']) && $_POST['action'] === 'switch_theme') {
    try {
        $newTheme = $_POST['theme'] ?? 'light';
        $newBgColor = $newTheme === 'dark' ? '#1a1a1a' : '#f8f9fa';
        
        // Update session preferences
        $_SESSION['preferences'] = [
            'theme' => $newTheme,
            'bg_color' => $newBgColor
        ];
        
        // Update cookies with proper path and domain
        $cookiePath = '/';
        $cookieDomain = '';
        $secure = false;
        $httponly = true;
        
        setcookie('theme', $newTheme, time() + (86400 * 30), $cookiePath, $cookieDomain, $secure, $httponly);
        setcookie('bg_color', $newBgColor, time() + (86400 * 30), $cookiePath, $cookieDomain, $secure, $httponly);
        
        // Force session write
        session_write_close();
        
        // If it's an AJAX request, return JSON
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'theme' => $newTheme,
                'bg_color' => $newBgColor,
                'message' => 'Theme updated successfully'
            ]);
        } else {
            // If it's a form submission, redirect back to contact page
            header('Location: contact.php');
        }
    } catch (Exception $e) {
        error_log('Theme switching error: ' . $e->getMessage());
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Failed to switch theme: ' . $e->getMessage()
            ]);
        } else {
            header('Location: contact.php?error=theme_switch_failed');
        }
    }
    exit;
}

validateSession();
?> 