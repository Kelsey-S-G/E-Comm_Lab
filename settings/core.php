<?php
// Core initialization file
require_once(__DIR__ . "/db_class.php");

// Start the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if a user is logged in.
 *
 * @return bool True if the user is logged in, false otherwise.
 */
function isUserLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

/**
 * Check if a user has administrative privileges.
 *
 * @return bool True if the user has admin privileges, false otherwise.
 */
function isAdmin(): bool {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 1;
}
?>