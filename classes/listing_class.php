<?php
require_once(__DIR__ . "/../settings/db_class.php");

class Listing extends db_connection {

    // ... (Keep add_listing and get_all_listings as they are) ...
    public function add_listing($venture_id, $title, $price, $desc, $type, $image, $keywords) {
        $title = mysqli_real_escape_string($this->db_conn(), $title);
        $desc = mysqli_real_escape_string($this->db_conn(), $desc);
        $keywords = mysqli_real_escape_string($this->db_conn(), $keywords);
    
        $sql = "INSERT INTO listings (venture_id, title, price, description, listing_type, image, keywords) 
                VALUES ('$venture_id', '$title', '$price', '$desc', '$type', '$image', '$keywords')";
        return $this->db_query($sql);
    }
    
    public function get_all_listings() {
        $sql = "SELECT l.*, v.venture_name, c.cat_name 
                FROM listings l
                JOIN ventures v ON l.venture_id = v.venture_id
                JOIN categories c ON v.cat_id = c.cat_id";
        return $this->db_fetch_all($sql);
    }

    // FIXED: Updated query to fetch venture, category, and owner details
    public function get_one_listing($id) {
        $id = mysqli_real_escape_string($this->db_conn(), $id);
        $sql = "SELECT l.*, v.venture_name, c.cat_name, a.full_name as owner_name, a.alumni_id as owner_id, a.institution_id
                FROM listings l
                JOIN ventures v ON l.venture_id = v.venture_id
                JOIN categories c ON v.cat_id = c.cat_id
                JOIN alumni a ON v.owner_id = a.alumni_id
                WHERE l.listing_id = '$id'";
        return $this->db_fetch_one($sql);
    }

    // ... (Keep update_listing and delete_listing as they are) ...
    public function update_listing($id, $title, $price, $desc, $type, $keywords, $image = null) {
        $title = mysqli_real_escape_string($this->db_conn(), $title);
        $desc = mysqli_real_escape_string($this->db_conn(), $desc);
        
        if ($image) {
            $sql = "UPDATE listings SET title='$title', price='$price', description='$desc', listing_type='$type', keywords='$keywords', image='$image' WHERE listing_id='$id'";
        } else {
            $sql = "UPDATE listings SET title='$title', price='$price', description='$desc', listing_type='$type', keywords='$keywords' WHERE listing_id='$id'";
        }
        return $this->db_query($sql);
    }
    
    public function delete_listing($id) {
        $sql = "DELETE FROM listings WHERE listing_id = '$id'";
        return $this->db_query($sql);
    }
}
?>