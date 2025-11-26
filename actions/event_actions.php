<?php
require_once("../controllers/event_controller.php");
require_once("../settings/core.php");

check_login(); // Ensure user is logged in

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';
$user_id = get_user_id();

// Helper for Image Upload (Reused)
function uploadEventImage($file) {
    $target_dir = "../uploads/events/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0755, true);
    $target_file = $target_dir . basename($file["name"]);
    if(move_uploaded_file($file["tmp_name"], $target_file)) return $target_file;
    return false;
}

switch ($action) {
    case 'create':
        $title = $_POST['title'];
        $desc = $_POST['desc'];
        $date = $_POST['date'];
        $start = $_POST['start'];
        $end = $_POST['end'];
        $location = $_POST['location'];
        $type = $_POST['type'];
        
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $imagePath = uploadEventImage($_FILES['image']);
        }

        if (!$imagePath) $imagePath = "../assets/event_placeholder.jpg"; // Fallback

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
            echo json_encode(['status' => 'error', 'message' => 'Already registered or error occurred']);
        }
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
}
?>