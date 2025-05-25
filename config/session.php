<?php
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); 
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.gc_maxlifetime', 3600); 
ini_set('session.cookie_lifetime', 3600); 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function regenerate_session() {
    if (!isset($_SESSION['last_regeneration'])) {
        $_SESSION['last_regeneration'] = time();
    } else {
        $interval = 300; 
        if (time() - $_SESSION['last_regeneration'] >= $interval) {
            session_regenerate_id(true);
            $_SESSION['last_regeneration'] = time();
        }
    }
}

regenerate_session(); 