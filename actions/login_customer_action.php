<?php
session_start();
require_once(__DIR__ . "/../controllers/customer_controller.php");

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data from the POST request
    $email    = $_POST['email'];
    $password = $_POST['password'];

    // Call the controller function to login the customer
    $result = login_customer_ctr($email, $password);

    // Check if login was successful and result contains customer data
    if (is_array($result) && isset($result['customer_id'])) {
        // Set session variables for user authentication
        $_SESSION['user_id'] = $result['customer_id'];
        $_SESSION['user_role'] = $result['user_role'];
        $_SESSION['user_name'] = $result['customer_name'];
        $_SESSION['user_email'] = $result['customer_email'];
        $_SESSION['user_country'] = $result['customer_country'];
        $_SESSION['user_city'] = $result['customer_city'];
        $_SESSION['user_contact'] = $result['customer_contact'];
        
        echo json_encode([
            "status" => "success", 
            "message" => "Login successful! Redirecting you to the home page...",
            "redirect" => "../index.php"
        ]);
    } else {
        echo json_encode([
            "status" => "error", 
            "message" => "Login failed: " . $result
        ]);
    }
}
?>