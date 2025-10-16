<?php
require_once('../settings/core.php');
require_once(__DIR__ . "/../controllers/brand_controller.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand_id = intval($_POST['brand_id'] ?? 0);
    $brand_name = trim($_POST['brand_name'] ?? '');

    if ($brand_id <= 0 || empty($brand_name)) {
        echo json_encode(["status" => "error", "message" => "Brand ID and name are required."]);
        exit();
    }

    $result = update_brand_ctr($brand_id, $brand_name);

    if ($result === "Brand updated successfully!") {
        echo json_encode(["status" => "success", "message" => $result]);
    } else {
        echo json_encode(["status" => "error", "message" => $result]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>