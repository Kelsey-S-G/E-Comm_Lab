<?php
// classes/alumni_class.php
require_once(__DIR__ . "/../settings/db_class.php");

class Alumni extends db_connection {

    public function add_alumni($fullname, $email, $password, $country, $city, $contact, $institution_id, $matric_no, $grad_year, $role = 2) {
        // 1. Check if email already exists
        if ($this->get_alumni_by_email($email)) {
            return false; 
        }

        $sql = "INSERT INTO alumni (
                    full_name, email, password, 
                    country, city, contact_no, 
                    institution_id, matriculation_no, grad_year, 
                    user_role, verification_status
                ) VALUES (
                    '$fullname', '$email', '$password', 
                    '$country', '$city', '$contact', 
                    '$institution_id', '$matric_no', '$grad_year', 
                    '$role', 'pending'
                )";
        
        return $this->db_query($sql);
    }

    public function get_alumni_by_email($email) {
        $sql = "SELECT * FROM alumni WHERE email = '$email'";
        return $this->db_fetch_one($sql);
    }

    public function get_all_institutions() {
        $sql = "SELECT * FROM institutions";
        return $this->db_fetch_all($sql);
    }

    // NEW: Get Domain for Validation
    public function get_institution_domain($institution_id) {
        $id = (int)$institution_id;
        $sql = "SELECT domain FROM institutions WHERE institution_id = $id";
        $result = $this->db_fetch_one($sql);
        return $result ? $result['domain'] : null;
    }

    // NEW: Fetch all verified alumni for directory
    public function get_all_alumni() {
        // Join with institutions to get school name
        $sql = "SELECT a.*, i.name as institution_name 
                FROM alumni a 
                JOIN institutions i ON a.institution_id = i.institution_id
                WHERE a.verification_status = 'verified' OR a.verification_status = 'pending'"; 
        return $this->db_fetch_all($sql);
    }
    
    // NEW: Get full details by ID
    public function get_alumni_details($id) {
        $sql = "SELECT * FROM alumni WHERE alumni_id = '$id'";
        return $this->db_fetch_one($sql);
    }

    // NEW: Update Profile
    public function update_profile($id, $fullname, $position, $country, $city, $contact) {
        // Sanitize inputs
        $fullname = mysqli_real_escape_string($this->db_conn(), $fullname);
        $position = mysqli_real_escape_string($this->db_conn(), $position);
        $country = mysqli_real_escape_string($this->db_conn(), $country);
        $city = mysqli_real_escape_string($this->db_conn(), $city);
        $contact = mysqli_real_escape_string($this->db_conn(), $contact);

        $sql = "UPDATE alumni SET 
                full_name = '$fullname',
                current_position = '$position',
                country = '$country',
                city = '$city',
                contact_no = '$contact'
                WHERE alumni_id = '$id'";
        
        return $this->db_query($sql);
    }
}