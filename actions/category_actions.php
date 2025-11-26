<?php
// actions/category_actions.php
// Handles Add, Update, and Delete requests via AJAX
require_once("../controllers/category_controller.php");
require_once("../settings/core.php");

// Ensure only Admins can perform these actions
// Note: Using a simple check here. For strict API security, session checks are vital.
if (!is_admin()) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    exit();
}

header('Content-Type: application/json');

// Determine the action type
$action = $_POST['action'] ?? '';

switch ($action) {
    case 'add':
        $name = $_POST['cat_name'];
        if (empty($name)) {
            echo json_encode(['status' => 'error', 'message' => 'Sector name cannot be empty']);
            exit();
        }
        $result = add_category_ctr($name);
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Venture Sector added successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add sector (Duplicate name?)']);
        }
        break;

    case 'update':
        $id = $_POST['cat_id'];
        $name = $_POST['cat_name'];
        if (empty($name) || empty($id)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data provided']);
            exit();
        }
        $result = update_category_ctr($id, $name);
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Sector updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Update failed']);
        }
        break;

    case 'delete':
        $id = $_POST['cat_id'];
        if (empty($id)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
            exit();
        }
        $result = delete_category_ctr($id);
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Sector deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Delete failed']);
        }
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        break;
}
?>