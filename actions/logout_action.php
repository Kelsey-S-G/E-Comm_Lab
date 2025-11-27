<?php
// actions/logout_action.php

// 1. Initialize the session
// If session is not started, we cannot destroy it
session_start();

// 2. Unset all of the session variables
$_SESSION = array();

// 3. Destroy the session cookie
// This is important to fully kill the session on the browser side too
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 4. Destroy the session
session_destroy();

// 5. Redirect to login page
header("Location: ../login/signin.php");
exit();
?>