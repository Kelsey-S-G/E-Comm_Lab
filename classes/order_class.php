<?php
// classes/order_class.php
require_once(__DIR__ . "/../settings/db_class.php");

class Order extends db_connection {

    // 1. Create Order Record
    public function create_order($user_id, $invoice_no, $status = 'success') {
        $sql = "INSERT INTO orders (buyer_id, invoice_no, order_date, status) 
                VALUES ('$user_id', '$invoice_no', NOW(), '$status')";
        if ($this->db_query($sql)) {
            return $this->db_conn()->insert_id; // Return the new Order ID
        }
        return false;
    }

    // 2. Add Items to Order Details
    public function add_order_details($order_id, $listing_id, $qty) {
        $sql = "INSERT INTO order_details (order_id, listing_id, qty) 
                VALUES ('$order_id', '$listing_id', '$qty')";
        return $this->db_query($sql);
    }

    // 3. Record Payment (Simulated)
    public function record_payment($amount, $user_id, $order_id, $currency = 'GHS') {
        // Optional: Create a payments table if not in schema
        // CREATE TABLE payments (pay_id int auto_increment primary key, amt double, customer_id int, order_id int, currency text, payment_date date);
        $sql = "INSERT INTO payments (amt, customer_id, order_id, currency, payment_date) 
                VALUES ('$amount', '$user_id', '$order_id', '$currency', NOW())";
        return $this->db_query($sql);
    }
}
?>