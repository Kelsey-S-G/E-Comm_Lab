<?php
require_once('../settings/core.php');
require_once(__DIR__ . "/../controllers/brand_controller.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand_name = trim($_POST['brand_name'] ?? '');

    if (empty($brand_name)) {
        echo json_encode(["status" => "error", "message" => "Brand name is required."]);
        exit();
    }

    $result = add_brand_ctr($brand_name);

    if ($result === "Brand added successfully!") {
        echo json_encode(["status" => "success", "message" => $result]);
    } else {
        echo json_encode(["status" => "error", "message" => $result]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
