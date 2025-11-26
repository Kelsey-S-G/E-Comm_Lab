<?php
// settings/core.php
// Core logic for Session, Auth, and Permissions

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define root path constants if not already defined
if (!defined('DB_HOST')) {
    require_once(__DIR__ . "/db_class.php");
}

/**
 * Check if user is logged in.
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * Check if the logged-in user is an Admin.
 * Role 1 = Admin, Role 2 = Alumni
 */
function is_admin() {
    return is_logged_in() && isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1;
}

/**
 * Enforce Login: Redirects if not logged in.
 */
function check_login() {
    if (!is_logged_in()) {
        // Adjust path based on where this function is called from
        // Assuming standard depth (e.g., inside /admin/ or /view/)
        header("Location: ../login/signin.php");
        exit();
    }
}

/**
 * Enforce Admin: Redirects if not admin.
 */
function check_admin_privilege() {
    check_login(); // First ensure they are logged in
    if (!is_admin()) {
        // Redirect non-admins to the main profile
        header("Location: ../views/profile.php");
        exit();
    }
}

/**
 * Get current user ID
 */
function get_user_id() {
    return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
}

/**
 * Get User Name (For display)
 */
function get_user_name() {
    return isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest';
}
?>