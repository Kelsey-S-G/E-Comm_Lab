<?php
// actions/venture_actions.php
require_once("../controllers/venture_controller.php");
require_once("../settings/core.php");

// Ensure user is logged in (Any verified alumni can create a venture)
check_login();

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';
$user_id = get_user_id();

switch ($action) {
    case 'add':
        $name = $_POST['v_name'];
        $cat_id = $_POST['cat_id'];
        $desc = $_POST['v_desc'];

        if (empty($name) || empty($cat_id)) {
            echo json_encode(['status' => 'error', 'message' => 'Name and Sector are required']);
            exit();
        }

        $result = add_venture_ctr($name, $user_id, $cat_id, $desc);
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Venture registered successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add venture (Duplicate name?)']);
        }
        break;

    case 'update':
        $id = $_POST['v_id'];
        $name = $_POST['v_name'];
        $cat_id = $_POST['cat_id'];
        $desc = $_POST['v_desc'];

        // Add logic here to verify ownership before update if needed
        $result = update_venture_ctr($id, $name, $cat_id, $desc);
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Venture updated']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Update failed']);
        }
        break;

    case 'delete':
        $id = $_POST['v_id'];
        $result = delete_venture_ctr($id);
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Venture deleted']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Delete failed']);
        }
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
}
?>