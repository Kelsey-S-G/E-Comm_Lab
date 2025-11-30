<?php
require_once(__DIR__ . "/../settings/db_class.php");

class Venture extends db_connection {

    // ... (Previous methods add_venture, get_all_ventures, get_my_ventures remain) ...

    public function add_venture($name, $owner_id, $cat_id, $desc) {
        $name = mysqli_real_escape_string($this->db_conn(), $name);
        $desc = mysqli_real_escape_string($this->db_conn(), $desc);
        
        $check = "SELECT * FROM ventures WHERE venture_name = '$name' AND owner_id = '$owner_id'";
        if ($this->db_fetch_one($check)) return false;

        $sql = "INSERT INTO ventures (venture_name, owner_id, cat_id, description) VALUES ('$name', '$owner_id', '$cat_id', '$desc')";
        return $this->db_query($sql);
    }

    public function get_all_ventures() {
        $sql = "SELECT v.*, c.cat_name, a.full_name as owner_name 
                FROM ventures v 
                JOIN categories c ON v.cat_id = c.cat_id 
                JOIN alumni a ON v.owner_id = a.alumni_id";
        return $this->db_fetch_all($sql);
    }

    public function get_my_ventures($owner_id) {
        $sql = "SELECT v.*, c.cat_name 
                FROM ventures v 
                JOIN categories c ON v.cat_id = c.cat_id 
                WHERE owner_id = '$owner_id'";
        return $this->db_fetch_all($sql);
    }

    // NEW: Get Single Venture with Owner Info (For Permissions)
    public function get_one_venture($id) {
        $id = (int)$id;
        $sql = "SELECT v.*, a.institution_id as owner_institution_id 
                FROM ventures v 
                JOIN alumni a ON v.owner_id = a.alumni_id
                WHERE v.venture_id = '$id'";
        return $this->db_fetch_one($sql);
    }

    public function update_venture($id, $name, $cat_id, $desc) {
        $name = mysqli_real_escape_string($this->db_conn(), $name);
        $desc = mysqli_real_escape_string($this->db_conn(), $desc);
        $sql = "UPDATE ventures SET venture_name = '$name', cat_id = '$cat_id', description = '$desc' WHERE venture_id = '$id'";
        return $this->db_query($sql);
    }

    public function delete_venture($id) {
        $sql = "DELETE FROM ventures WHERE venture_id = '$id'";
        return $this->db_query($sql);
    }
}
?>