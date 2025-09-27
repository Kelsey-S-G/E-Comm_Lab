<?php
session_start();
require_once('../settings/core.php');
require_once(__DIR__ . "/../controllers/category_controller.php");

// Check if the user is logged in and is an admin
if (!isUserLoggedIn()) {
    echo json_encode([
        "status" => "error", 
        "message" => "Access denied. Admin privileges required."
    ]);
    exit();
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data from the POST request
    $cat_name = trim($_POST['cat_name']);
    $user_id = $_SESSION['user_id'];

    // Validate input
    if (empty($cat_name)) {
        echo json_encode([
            "status" => "error", 
            "message" => "Category name is required."
        ]);
        exit();
    }

    if (strlen($cat_name) < 2 || strlen($cat_name) > 100) {
        echo json_encode([
            "status" => "error", 
            "message" => "Category name must be between 2 and 100 characters."
        ]);
        exit();
    }

    // Call the controller function to add the category
    $result = add_category_ctr($cat_name, $user_id);

    // Return a JSON response based on the result
    if ($result === "Category added successfully!") {
        echo json_encode([
            "status" => "success", 
            "message" => $result
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