<?php
require_once('../settings/core.php');
require_once(__DIR__ . "/../controllers/brand_controller.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand_id = intval($_POST['brand_id'] ?? 0);

    if ($brand_id <= 0) {
        echo json_encode(["status" => "error", "message" => "Invalid brand ID."]);
        exit();
    }

    $result = delete_brand_ctr($brand_id);

    if ($result === "Brand deleted successfully!") {
        echo json_encode(["status" => "success", "message" => $result]);
    } else {
        echo json_encode(["status" => "error", "message" => $result]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
