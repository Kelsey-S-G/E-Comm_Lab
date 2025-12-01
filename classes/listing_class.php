<?php
require_once(__DIR__ . "/../settings/db_class.php");

class Listing extends db_connection {

    public function add_listing($venture_id, $title, $price, $desc, $type, $image, $keywords) {
        $title = mysqli_real_escape_string($this->db_conn(), $title);
        $desc = mysqli_real_escape_string($this->db_conn(), $desc);
        $keywords = mysqli_real_escape_string($this->db_conn(), $keywords);
    
        $sql = "INSERT INTO listings (venture_id, title, price, description, listing_type, image, keywords) 
                VALUES ('$venture_id', '$title', '$price', '$desc', '$type', '$image', '$keywords')";
        return $this->db_query($sql);
    }
    
    // Kept for legacy/admin use if needed, but not used in user view anymore
    public function get_all_listings() {
        $sql = "SELECT l.*, v.venture_name, c.cat_name 
                FROM listings l
                JOIN ventures v ON l.venture_id = v.venture_id
                JOIN categories c ON v.cat_id = c.cat_id";
        return $this->db_fetch_all($sql);
    }

    public function get_my_listings($owner_id) {
        $sql = "SELECT l.*, v.venture_name, c.cat_name 
                FROM listings l
                JOIN ventures v ON l.venture_id = v.venture_id
                JOIN categories c ON v.cat_id = c.cat_id
                WHERE v.owner_id = '$owner_id'";
        return $this->db_fetch_all($sql);
    }

    public function get_listings_by_institution($inst_id) {
        $inst_id = (int)$inst_id;
        $sql = "SELECT l.*, v.venture_name, c.cat_name, a.full_name as owner_name 
                FROM listings l
                JOIN ventures v ON l.venture_id = v.venture_id
                JOIN categories c ON v.cat_id = c.cat_id
                JOIN alumni a ON v.owner_id = a.alumni_id
                WHERE a.institution_id = '$inst_id'";
        return $this->db_fetch_all($sql);
    }

    // --- UPDATED FILTER METHODS (Now with Institution Check) ---

    public function get_listings_by_category($cat_id, $inst_id) {
        $cat_id = (int)$cat_id;
        $inst_id = (int)$inst_id;
        $sql = "SELECT l.*, v.venture_name, c.cat_name 
                FROM listings l
                JOIN ventures v ON l.venture_id = v.venture_id
                JOIN categories c ON v.cat_id = c.cat_id
                JOIN alumni a ON v.owner_id = a.alumni_id
                WHERE v.cat_id = '$cat_id' AND a.institution_id = '$inst_id'";
        return $this->db_fetch_all($sql);
    }

    public function get_listings_by_venture($ven_id, $inst_id) {
        $ven_id = (int)$ven_id;
        $inst_id = (int)$inst_id;
        $sql = "SELECT l.*, v.venture_name, c.cat_name 
                FROM listings l
                JOIN ventures v ON l.venture_id = v.venture_id
                JOIN categories c ON v.cat_id = c.cat_id
                JOIN alumni a ON v.owner_id = a.alumni_id
                WHERE l.venture_id = '$ven_id' AND a.institution_id = '$inst_id'";
        return $this->db_fetch_all($sql);
    }

    public function search_listings($term, $inst_id) {
        $term = mysqli_real_escape_string($this->db_conn(), $term);
        $inst_id = (int)$inst_id;
        $sql = "SELECT l.*, v.venture_name, c.cat_name 
                FROM listings l
                JOIN ventures v ON l.venture_id = v.venture_id
                JOIN categories c ON v.cat_id = c.cat_id
                JOIN alumni a ON v.owner_id = a.alumni_id
                WHERE a.institution_id = '$inst_id' 
                AND (l.title LIKE '%$term%' OR l.description LIKE '%$term%' OR l.keywords LIKE '%$term%')";
        return $this->db_fetch_all($sql);
    }

    // ... (Keep get_one_listing, update, delete) ...
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