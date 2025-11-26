<?php
// classes/venture_class.php
require_once(__DIR__ . "/../settings/db_class.php");

class Venture extends db_connection {

    // CREATE: Add a new Venture (Business/Brand)
    public function add_venture($name, $owner_id, $cat_id, $desc) {
        $name = mysqli_real_escape_string($this->db_conn(), $name);
        $desc = mysqli_real_escape_string($this->db_conn(), $desc);
        
        // Check duplicate for this owner (Owner can't have 2 ventures with same name)
        $check = "SELECT * FROM ventures WHERE venture_name = '$name' AND owner_id = '$owner_id'";
        if ($this->db_fetch_one($check)) return false;

        $sql = "INSERT INTO ventures (venture_name, owner_id, cat_id, description) VALUES ('$name', '$owner_id', '$cat_id', '$desc')";
        return $this->db_query($sql);
    }

    // RETRIEVE: Get All Ventures (For Admin/Marketplace)
    public function get_all_ventures() {
        $sql = "SELECT v.*, c.cat_name, a.full_name as owner_name 
                FROM ventures v 
                JOIN categories c ON v.cat_id = c.cat_id 
                JOIN alumni a ON v.owner_id = a.alumni_id";
        return $this->db_fetch_all($sql);
    }

    // RETRIEVE: Get Ventures by Owner (For "My Ventures" dashboard)
    public function get_my_ventures($owner_id) {
        $sql = "SELECT v.*, c.cat_name 
                FROM ventures v 
                JOIN categories c ON v.cat_id = c.cat_id 
                WHERE owner_id = '$owner_id'";
        return $this->db_fetch_all($sql);
    }

    // UPDATE
    public function update_venture($id, $name, $cat_id, $desc) {
        $name = mysqli_real_escape_string($this->db_conn(), $name);
        $desc = mysqli_real_escape_string($this->db_conn(), $desc);
        
        $sql = "UPDATE ventures SET venture_name = '$name', cat_id = '$cat_id', description = '$desc' WHERE venture_id = '$id'";
        return $this->db_query($sql);
    }

    // DELETE
    public function delete_venture($id) {
        $sql = "DELETE FROM ventures WHERE venture_id = '$id'";
        return $this->db_query($sql);
    }
}
?>