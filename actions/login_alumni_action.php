<?php
// actions/login_alumni_action.php
// Turn off error display for API calls to prevent HTML mixing with JSON
ini_set('display_errors', 0);
error_reporting(E_ALL); 

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("../controllers/alumni_controller.php");

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            echo json_encode(['status' => 'error', 'message' => 'Email and Password are required.']);
            exit();
        }

        $alumni = get_alumni_by_email_ctr($email);

        if ($alumni) {
            if (password_verify($password, $alumni['password'])) {
                // Set Session Variables
                $_SESSION['user_id'] = $alumni['alumni_id'];
                $_SESSION['user_role'] = $alumni['user_role'];
                $_SESSION['user_name'] = $alumni['full_name'];
                $_SESSION['verification_status'] = $alumni['verification_status'];
                $_SESSION['institution_id'] = $alumni['institution_id'];
                $_SESSION['user_email'] = $alumni['email'];

                echo json_encode(['status' => 'success', 'message' => 'Login successful']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Incorrect password.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'User not found.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    }
} catch (Exception $e) {
    // Catch any unexpected server errors and return JSON
    echo json_encode(['status' => 'error', 'message' => 'Server Error: ' . $e->getMessage()]);
}
?>