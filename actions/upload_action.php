<?php
// actions/upload_action.php
require_once("../classes/file_handler_class.php");
require_once("../settings/core.php");

check_login(); // Ensure only logged-in users can upload

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (!isset($_FILES['uploadedFile'])) {
        echo json_encode(['status' => 'error', 'message' => 'No file selected']);
        exit();
    }

    $category = $_POST['category'] ?? 'misc'; // e.g., 'listings', 'events'
    
    $handler = new FileHandler();
    $result = $handler->upload_file($_FILES['uploadedFile'], $category);

    if ($result['status']) {
        echo json_encode([
            'status' => 'success', 
            'message' => $result['message'], 
            'path' => $result['path']
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => $result['message']]);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>