<?php
// controllers/alumni_controller.php
require_once(__DIR__ . "/../classes/alumni_class.php");

// ... (Previous functions register_alumni_ctr, get_alumni_by_email_ctr remain) ...

function register_alumni_ctr($fullname, $email, $password, $country, $city, $contact, $institution_id, $matric_no, $grad_year) {
    $alumni = new Alumni();
    return $alumni->add_alumni($fullname, $email, $password, $country, $city, $contact, $institution_id, $matric_no, $grad_year);
}

function get_alumni_by_email_ctr($email) {
    $alumni = new Alumni();
    return $alumni->get_alumni_by_email($email);
}

function get_all_institutions_ctr() {
    $alumni = new Alumni();
    return $alumni->get_all_institutions();
}

// NEW: For Community Page
function get_all_alumni_ctr() {
    $alumni = new Alumni();
    return $alumni->get_all_alumni(); // Need to add this method to class below
}
?>