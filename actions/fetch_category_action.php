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

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $user_id = $_SESSION['user_id'];

    // Call the controller function to fetch categories
    $categories = get_categories_by_user_ctr($user_id);

    // Return the categories as JSON
    echo json_encode([
        "status" => "success", 
        "data" => $categories
    ]);
} else {
    echo json_encode([
        "status" => "error", 
        "message" => "Invalid request method."
    ]);
}
?>