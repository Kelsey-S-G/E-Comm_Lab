<?php
require_once(__DIR__ . "/../controllers/customer_controller.php");

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data from the POST request
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $country  = $_POST['country'];
    $city     = $_POST['city'];
    $contact  = $_POST['contact'];
    $role     = 2; 

    // Call the controller function to register the customer
    $result = register_customer_ctr($name, $email, $password, $country, $city, $contact, $role);

    // Return a JSON response based on the result
    if ($result === "success") {
        echo json_encode([
            "status" => "success", 
            "message" => "Registration successful! Redirecting you to the login page...",
            "redirect" => "login/login.php"
        ]);
    } else {
        echo json_encode([
            "status" => "error", 
            "message" => "Registration failed: " . $result
        ]);
    }
}
?>