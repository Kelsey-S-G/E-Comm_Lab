<?php
require_once(__DIR__ . "/../settings/db_class.php");

class Listing extends db_connection {

// CREATE: Add Product/Service
public function add_listing($venture_id, $title, $price, $desc, $type, $image, $keywords) {
    $title = mysqli_real_escape_string($this->db_conn(), $title);
    $desc = mysqli_real_escape_string($this->db_conn(), $desc);
    $keywords = mysqli_real_escape_string($this->db_conn(), $keywords);

    $sql = "INSERT INTO listings (venture_id, title, price, description, listing_type, image, keywords) 
            VALUES ('$venture_id', '$title', '$price', '$desc', '$type', '$image', '$keywords')";
    return $this->db_query($sql);
}

// RETRIEVE: Get All (With Filters)
public function get_all_listings() {
    $sql = "SELECT l.*, v.venture_name, c.cat_name 
            FROM listings l
            JOIN ventures v ON l.venture_id = v.venture_id
            JOIN categories c ON v.cat_id = c.cat_id";
    return $this->db_fetch_all($sql);
}

// RETRIEVE: Get Single Listing
public function get_one_listing($id) {
    $sql = "SELECT * FROM listings WHERE listing_id = '$id'";
    return $this->db_fetch_one($sql);
}

// UPDATE
public function update_listing($id, $title, $price, $desc, $type, $keywords, $image = null) {
    $title = mysqli_real_escape_string($this->db_conn(), $title);
    $desc = mysqli_real_escape_string($this->db_conn(), $desc);
    
    if ($image) {
        // Update with new image
        $sql = "UPDATE listings SET title='$title', price='$price', description='$desc', listing_type='$type', keywords='$keywords', image='$image' WHERE listing_id='$id'";
    } else {
        // Keep old image
        $sql = "UPDATE listings SET title='$title', price='$price', description='$desc', listing_type='$type', keywords='$keywords' WHERE listing_id='$id'";
    }
    return $this->db_query($sql);
}

// DELETE
public function delete_listing($id) {
    $sql = "DELETE FROM listings WHERE listing_id = '$id'";
    return $this->db_query($sql);
}
}
?>