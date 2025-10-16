<?php
require_once('../settings/core.php');
require_once(__DIR__ . "/../controllers/brand_controller.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $brands = fetch_brands_ctr();
    echo json_encode(["status" => "success", "data" => $brands]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>