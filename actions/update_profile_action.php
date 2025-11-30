<?php
// actions/update_profile_action.php
require_once("../controllers/alumni_controller.php");
require_once("../settings/core.php");

check_login();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $user_id = get_user_id();
    $fullname = $_POST['full_name'];
    $position = $_POST['current_position'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $contact = $_POST['contact_no'];

    // Basic Validation
    if (empty($fullname) || empty($contact)) {
        echo json_encode(['status' => 'error', 'message' => 'Name and Contact are required.']);
        exit();
    }

    $result = update_profile_ctr($user_id, $fullname, $position, $country, $city, $contact);

    if ($result) {
        // Update Session Name if changed
        $_SESSION['user_name'] = $fullname;
        echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database update failed.']);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>