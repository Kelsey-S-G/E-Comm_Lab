<?php
// controllers/order_controller.php
require_once(__DIR__ . "/../classes/order_class.php");

function create_order_ctr($user_id, $invoice_no) {
    $order = new Order();
    return $order->create_order($user_id, $invoice_no);
}

function add_order_details_ctr($order_id, $listing_id, $qty) {
    $order = new Order();
    return $order->add_order_details($order_id, $listing_id, $qty);
}

function record_payment_ctr($amount, $user_id, $order_id) {
    $order = new Order();
    return $order->record_payment($amount, $user_id, $order_id);
}
?>