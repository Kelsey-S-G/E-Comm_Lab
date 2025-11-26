<?php
// actions/login_alumni_action.php
session_start();
require_once("../controllers/alumni_controller.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 1. Fetch User
    $alumni = get_alumni_by_email_ctr($email);

    if ($alumni) {
        // 2. Verify Password
        if (password_verify($password, $alumni['password'])) {
            
            // 3. Set Session Variables (Activity Requirement)
            $_SESSION['user_id'] = $alumni['alumni_id'];
            $_SESSION['user_role'] = $alumni['user_role'];
            $_SESSION['user_name'] = $alumni['full_name'];
            
            // ReConnect Specific: Identity Lock
            $_SESSION['verification_status'] = $alumni['verification_status'];
            $_SESSION['institution_id'] = $alumni['institution_id'];

            echo json_encode(['status' => 'success', 'message' => 'Login successful']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Incorrect password.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not found.']);
    }
}
?>