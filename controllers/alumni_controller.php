<?php
// controllers/alumni_controller.php
require_once(__DIR__ . "/../classes/alumni_class.php");

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

function get_institution_domain_ctr($institution_id) {
    $alumni = new Alumni();
    return $alumni->get_institution_domain($institution_id);
}

// NEW: For Community Page
function get_all_alumni_ctr() {
    $alumni = new Alumni();
    return $alumni->get_all_alumni(); // Need to add this method to class below
}

// NEW: Get Details
function get_alumni_details_ctr($id) {
    $alumni = new Alumni();
    return $alumni->get_alumni_details($id);
}

// NEW: Update Profile
function update_profile_ctr($id, $fullname, $position, $country, $city, $contact) {
    $alumni = new Alumni();
    return $alumni->update_profile($id, $fullname, $position, $country, $city, $contact);
}
?>