<?php
// Core initialization file
require_once(__DIR__ . "/db_class.php");

// Start the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn()
{
    if (isset($_SESSION['user_id'])) {
        return true;
    }
    return false;
}

function isAdmin()
{
    if (is_logged_in() && isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1) {
        return true;
    }
    return false;
}
?>