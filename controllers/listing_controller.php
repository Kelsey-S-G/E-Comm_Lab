<?php
require_once(__DIR__ . "/../classes/listing_class.php");

function add_listing_ctr($venture_id, $title, $price, $desc, $type, $image, $keywords) {
    $listing = new Listing();
    return $listing->add_listing($venture_id, $title, $price, $desc, $type, $image, $keywords);
}

function get_all_listings_ctr() {
    $listing = new Listing();
    return $listing->get_all_listings();
}

function get_my_listings_ctr($owner_id) {
    $listing = new Listing();
    return $listing->get_my_listings($owner_id);
}

function get_listings_by_institution_ctr($inst_id) {
    $listing = new Listing();
    return $listing->get_listings_by_institution($inst_id);
}

// --- UPDATED CONTROLLERS FOR FILTERS ---

function filter_listings_by_category_ctr($cat_id, $inst_id) {
    $listing = new Listing();
    return $listing->get_listings_by_category($cat_id, $inst_id);
}

function filter_listings_by_venture_ctr($ven_id, $inst_id) {
    $listing = new Listing();
    return $listing->get_listings_by_venture($ven_id, $inst_id);
}

function search_listings_ctr($term, $inst_id) {
    $listing = new Listing();
    return $listing->search_listings($term, $inst_id);
}

// -----------------------------------

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