<?php
// settings/core.php
// Ensure no output before session_start

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define DB constants if missing (Safety check)
if (!defined('DB_HOST')) {
    // Attempt to load credentials if not defined
    $cred_path = __DIR__ . "/db_cred.php";
    if (file_exists($cred_path)) {
        require_once($cred_path);
    }
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function is_admin() {
    return is_logged_in() && isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1;
}

// Helper to check verification status
function isVerified() {
    if (!is_logged_in()) return false;
    return isset($_SESSION['verification_status']) && $_SESSION['verification_status'] === 'verified';
}

function check_login() {
    if (!is_logged_in()) {
        header("Location: ../login/signin.php");
        exit();
    }
}

function check_admin_privilege() {
    check_login();
    if (!is_admin()) {
        header("Location: ../view/profile.php");
        exit();
    }
}

function get_user_id() {
    return $_SESSION['user_id'] ?? null;
}
?>