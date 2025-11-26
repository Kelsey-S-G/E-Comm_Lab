<?php
// controllers/listing_controller.php
require_once(__DIR__ . "/../classes/listing_class.php");

function add_listing_ctr($venture_id, $title, $price, $desc, $type, $image, $keywords) {
    $listing = new Listing();
    return $listing->add_listing($venture_id, $title, $price, $desc, $type, $image, $keywords);
}

function get_all_listings_ctr() {
    $listing = new Listing();
    return $listing->get_all_listings();
}

function get_one_listing_ctr($id) {
    $listing = new Listing();
    return $listing->get_one_listing($id);
}

function update_listing_ctr($id, $title, $price, $desc, $type, $keywords, $image = null) {
    $listing = new Listing();
    return $listing->update_listing($id, $title, $price, $desc, $type, $keywords, $image);
}

function delete_listing_ctr($id) {
    $listing = new Listing();
    return $listing->delete_listing($id);
}
?>