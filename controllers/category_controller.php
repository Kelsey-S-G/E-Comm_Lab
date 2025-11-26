<?php
// controllers/category_controller.php
require_once(__DIR__ . "/../classes/category_class.php");

function add_category_ctr($name) {
    $cat = new Category();
    return $cat->add_category($name);
}

function get_all_categories_ctr() {
    $cat = new Category();
    return $cat->get_all_categories();
}

function get_one_category_ctr($id) {
    $cat = new Category();
    return $cat->get_one_category($id);
}

function update_category_ctr($id, $name) {
    $cat = new Category();
    return $cat->update_category($id, $name);
}

function delete_category_ctr($id) {
    $cat = new Category();
    return $cat->delete_category($id);
}
?>