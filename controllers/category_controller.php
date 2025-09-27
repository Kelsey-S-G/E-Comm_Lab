<?php
require_once(__DIR__ . "/../classes/category_class.php");

function add_category_ctr($cat_name, $user_id) {
    // Create an instance of the category_class
    $category = new category_class();

    // Call the add_category method and return its result
    return $category->add_category($cat_name, $user_id);
}

function get_categories_by_user_ctr($user_id) {
    // Create an instance of the category_class
    $category = new category_class();

    // Call the get_categories_by_user method and return its result
    return $category->get_categories_by_user($user_id);
}

function get_category_ctr($cat_id, $user_id) {
    // Create an instance of the category_class
    $category = new category_class();

    // Call the get_category method and return its result
    return $category->get_category($cat_id, $user_id);
}

function edit_category_ctr($cat_id, $cat_name, $user_id) {
    // Create an instance of the category_class
    $category = new category_class();

    // Call the edit_category method and return its result
    return $category->edit_category($cat_id, $cat_name, $user_id);
}

function delete_category_ctr($cat_id, $user_id) {
    // Create an instance of the category_class
    $category = new category_class();

    // Call the delete_category method and return its result
    return $category->delete_category($cat_id, $user_id);
}
?>