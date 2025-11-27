<?php
// actions/event_actions.php
require_once("../controllers/event_controller.php");
require_once("../settings/core.php");
require_once("../settings/file_upload_handler.php"); // Include Helper

check_login();

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';
$user_id = get_user_id();

switch ($action) {
    case 'create':
        $title = $_POST['title'];
        $desc = $_POST['desc'];
        $date = $_POST['date'];
        $start = $_POST['start'];
        $end = $_POST['end'];
        $location = $_POST['location'];
        $type = $_POST['type'];
        
        // CLEANER IMAGE HANDLING
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = uploadFile($_FILES['image'], 'events'); // Save to 'events' subfolder
        }

        // Fallback image if upload fails or none provided
        if (!$imagePath) $imagePath = "../assets/event_placeholder.jpg";

        $result = add_event_ctr($user_id, $title, $desc, $date, $start, $end, $location, $type, $imagePath);
        
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Event created successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to create event']);
        }
        break;

    case 'register':
        $event_id = $_POST['event_id'];
        $result = register_attendee_ctr($event_id, $user_id);
        
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Registered successfully!']);
        } else {
            // This likely means a duplicate entry (already registered) or DB error
            echo json_encode(['status' => 'error', 'message' => 'Already registered or error occurred']);
        }
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
}
?>