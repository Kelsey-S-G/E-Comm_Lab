<?php
require_once(__DIR__ . "/../controllers/customer_controller.php");

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data from the POST request
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $country  = trim($_POST['country']);
    $city     = trim($_POST['city']);
    $contact  = trim($_POST['contact']);
    $role     = 2; 

    // Server-side validation
    if (strlen($name) < 3 || strlen($name) > 50) {
        echo json_encode([
            "status" => "error", 
            "message" => "Full name must be between 3 and 50 characters."
        ]);
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            "status" => "error", 
            "message" => "Invalid email format."
        ]);
        exit();
    }

    if (strlen($password) < 6) {
        echo json_encode([
            "status" => "error", 
            "message" => "Password must be at least 6 characters."
        ]);
        exit();
    }

    // Call the controller function to register the customer
    $result = register_customer_ctr($name, $email, $password, $country, $city, $contact, $role);

    // Return a JSON response based on the result
    // Check for successful registration message
    if ($result === "Customer added successfully!") {
        echo json_encode([
            "status" => "success", 
            "message" => "Registration successful! Redirecting you to the login page...",
            "redirect" => "login.php"
        ]);
    } else {
        echo json_encode([
            "status" => "error", 
            "message" => $result
        ]);
    }
} else {
    echo json_encode([
        "status" => "error", 
        "message" => "Invalid request method."
    ]);
}
?>