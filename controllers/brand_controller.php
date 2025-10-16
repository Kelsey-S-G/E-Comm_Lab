<?php
require_once(__DIR__ . "/../classes/brand_class.php");

function add_brand_ctr($brand_name) {
    $brand = new brand_class();
    return $brand->add_brand($brand_name);
}

function fetch_brands_ctr() {
    $brand = new brand_class();
    return $brand->fetch_brands();
}

function delete_brand_ctr($brand_id) {
    $brand = new brand_class();
    return $brand->delete_brand($brand_id);
}

function update_brand_ctr($brand_id, $brand_name) {
    $brand = new brand_class();
    return $brand->update_brand($brand_id, $brand_name);
}
?>