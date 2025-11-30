<?php
require_once("../controllers/event_controller.php");
require_once("../settings/core.php");
require_once("../settings/file_upload_handler.php");

check_login();
header('Content-Type: application/json');

$action = $_POST['action'] ?? '';
$user_id = get_user_id();
$user_role = $_SESSION['user_role'] ?? 2; // 1 = Admin

switch ($action) {
    case 'create':
        // Admin Only Check
        if ($user_role != 1) {
            echo json_encode(['status' => 'error', 'message' => 'Only admins can create events.']);
            exit();
        }
        
        $title = $_POST['title'];
        $desc = $_POST['desc'];
        $date = $_POST['date'];
        $start = $_POST['start'];
        $end = $_POST['end'];
        $location = $_POST['location'];
        $type = $_POST['type'];
        
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = uploadFile($_FILES['image'], 'events');
        }
        if (!$imagePath) $imagePath = "../assets/event_placeholder.jpg";

        $result = add_event_ctr($user_id, $title, $desc, $date, $start, $end, $location, $type, $imagePath);
        
        if ($result) echo json_encode(['status' => 'success', 'message' => 'Event created successfully']);
        else echo json_encode(['status' => 'error', 'message' => 'Failed to create event']);
        break;

    case 'delete':
        if ($user_role != 1) {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            exit();
        }
        $id = $_POST['event_id'];
        $result = delete_event_ctr($id);
        if ($result) echo json_encode(['status' => 'success', 'message' => 'Event deleted']);
        else echo json_encode(['status' => 'error', 'message' => 'Delete failed']);
        break;

    case 'register':
        $event_id = $_POST['event_id'];
        $result = register_attendee_ctr($event_id, $user_id);
        if ($result) echo json_encode(['status' => 'success', 'message' => 'Registered successfully!']);
        else echo json_encode(['status' => 'error', 'message' => 'Already registered or error']);
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
}
?>