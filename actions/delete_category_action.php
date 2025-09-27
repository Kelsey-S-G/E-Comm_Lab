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
    // Retrieve the category ID from the POST request
    $cat_id = intval($_POST['cat_id']);
    $user_id = $_SESSION['user_id'];

    // Validate input
    if ($cat_id <= 0) {
        echo json_encode([
            "status" => "error", 
            "message" => "Invalid category ID."
        ]);
        exit();
    }

    // Call the controller function to delete the category
    $result = delete_category_ctr($cat_id, $user_id);

    // Return a JSON response based on the result
    if ($result === "Category deleted successfully!") {
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