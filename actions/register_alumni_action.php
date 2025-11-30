<?php
// actions/register_alumni_action.php
require_once("../controllers/alumni_controller.php");

// Set content type to JSON for clean AJAX handling
header('Content-Type: application/json');

// Check if POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Collect Inputs
    $fullname = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $contact = $_POST['contact_no'];
    
    // ReConnect Specifics
    $institution_id = $_POST['institution_id'];
    $matric_no = $_POST['matric_no'];
    $grad_year = $_POST['grad_year'];

    // 2. Basic Server-Side Validation (Backup to JS)
    if (empty($email) || empty($password) || empty($matric_no)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit();
    }

    // 3. Validate Email Domain
    $required_domain = get_institution_domain_ctr($institution_id);
    
    if ($required_domain) {
        // Check if email ends with the required domain
        // We use strtolower to ensure case-insensitive comparison
        if (substr(strtolower($email), -strlen($required_domain)) !== strtolower($required_domain)) {
            echo json_encode(['status' => 'error', 'message' => "Email must use the institutional domain: @$required_domain"]);
            exit();
        }
    }

    // 4. Check for Duplicates
    $existing = get_alumni_by_email_ctr($email);
    if ($existing) {
        echo json_encode(['status' => 'error', 'message' => 'Email already registered.']);
        exit();
    }

    // 5. Encrypt Password (Week 2 Requirement)
    $hash_password = password_hash($password, PASSWORD_DEFAULT);

    // 6. Register User
    $result = register_alumni_ctr($fullname, $email, $hash_password, $country, $city, $contact, $institution_id, $matric_no, $grad_year);

    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Registration successful! Please login.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error. Please try again.']);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>