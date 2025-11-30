<?php
require_once("../controllers/venture_controller.php");
require_once("../settings/core.php");

check_login();
header('Content-Type: application/json');

$action = $_POST['action'] ?? '';
$user_id = get_user_id();
$user_inst_id = $_SESSION['institution_id'];
$user_role = $_SESSION['user_role']; // 1 = Admin

switch ($action) {
    case 'add':
        // CHECK 1: Must be Verified
        if (!isVerified()) {
            echo json_encode(['status' => 'error', 'message' => 'Only verified alumni can create ventures.']);
            exit();
        }

        $name = $_POST['v_name'];
        $cat_id = $_POST['cat_id'];
        $desc = $_POST['v_desc'];

        $result = add_venture_ctr($name, $user_id, $cat_id, $desc);
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Venture registered successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add venture. Name might exist.']);
        }
        break;

    case 'update':
        $id = $_POST['v_id'];
        // FETCH to check permission
        $target = get_one_venture_ctr($id);
        
        if (!$target) {
            echo json_encode(['status' => 'error', 'message' => 'Venture not found']);
            exit();
        }

        // PERMISSION CHECK: Owner OR Same-Institution Admin
        $is_owner = ($target['owner_id'] == $user_id);
        $is_inst_admin = ($user_role == 1 && $target['owner_institution_id'] == $user_inst_id);

        if (!$is_owner && !$is_inst_admin) {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized. You can only manage your own ventures.']);
            exit();
        }

        $name = $_POST['v_name'];
        $cat_id = $_POST['cat_id'];
        $desc = $_POST['v_desc'];

        $result = update_venture_ctr($id, $name, $cat_id, $desc);
        if ($result) echo json_encode(['status' => 'success', 'message' => 'Venture updated']);
        else echo json_encode(['status' => 'error', 'message' => 'Update failed']);
        break;

    case 'delete':
        $id = $_POST['v_id'];
        $target = get_one_venture_ctr($id);

        if (!$target) { echo json_encode(['status' => 'error', 'message' => 'Not found']); exit(); }

        $is_owner = ($target['owner_id'] == $user_id);
        $is_inst_admin = ($user_role == 1 && $target['owner_institution_id'] == $user_inst_id);

        if (!$is_owner && !$is_inst_admin) {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized.']);
            exit();
        }

        $result = delete_venture_ctr($id);
        if ($result) echo json_encode(['status' => 'success', 'message' => 'Venture deleted']);
        else echo json_encode(['status' => 'error', 'message' => 'Delete failed']);
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
}
?>