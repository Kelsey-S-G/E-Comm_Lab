<?php
// classes/category_class.php
require_once(__DIR__ . "/../settings/db_class.php");

class Category extends db_connection {

    // CREATE: Add a new Venture Sector
    public function add_category($name) {
        // Escape string to prevent SQL injection (basic protection)
        $name = mysqli_real_escape_string($this->db_conn(), $name);
        
        // Check for duplicates
        $check_sql = "SELECT * FROM categories WHERE cat_name = '$name'";
        $existing = $this->db_fetch_one($check_sql);
        if ($existing) return false;

        $sql = "INSERT INTO categories (cat_name) VALUES ('$name')";
        return $this->db_query($sql);
    }

    // RETRIEVE: Get all Sectors
    public function get_all_categories() {
        $sql = "SELECT * FROM categories";
        return $this->db_fetch_all($sql);
    }

    // RETRIEVE: Get single Sector
    public function get_one_category($id) {
        $id = (int)$id;
        $sql = "SELECT * FROM categories WHERE cat_id = $id";
        return $this->db_fetch_one($sql);
    }

    // UPDATE: Edit Sector Name
    public function update_category($id, $name) {
        $id = (int)$id;
        $name = mysqli_real_escape_string($this->db_conn(), $name);
        
        $sql = "UPDATE categories SET cat_name = '$name' WHERE cat_id = $id";
        return $this->db_query($sql);
    }

    // DELETE: Remove Sector
    public function delete_category($id) {
        $id = (int)$id;
        $sql = "DELETE FROM categories WHERE cat_id = $id";
        return $this->db_query($sql);
    }
}
?>