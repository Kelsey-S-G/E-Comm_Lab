<?php
// controllers/cart_controller.php
require_once(__DIR__ . "/../classes/cart_class.php");

function add_to_cart_ctr($p_id, $ip_add, $c_id, $qty) {
    $cart = new Cart();
    return $cart->add_to_cart($p_id, $ip_add, $c_id, $qty);
}

function remove_from_cart_ctr($p_id, $c_id) {
    $cart = new Cart();
    return $cart->remove_from_cart($p_id, $c_id);
}

function update_cart_qty_ctr($p_id, $c_id, $qty) {
    $cart = new Cart();
    return $cart->update_cart_qty($p_id, $c_id, $qty);
}

function get_cart_items_ctr($c_id) {
    $cart = new Cart();
    return $cart->get_cart_items($c_id);
}

function get_cart_total_ctr($c_id) {
    $cart = new Cart();
    return $cart->get_cart_total($c_id);
}

function empty_cart_ctr($c_id) {
    $cart = new Cart();
    return $cart->empty_cart($c_id);
}
?>