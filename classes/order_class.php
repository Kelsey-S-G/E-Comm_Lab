<?php
// classes/order_class.php
require_once(__DIR__ . "/../settings/db_class.php");

class Order extends db_connection {

    // Create Order
    public function create_order($user_id, $invoice_no, $status = 'pending') {
        $invoice_no = mysqli_real_escape_string($this->db_conn(), $invoice_no);
        $sql = "INSERT INTO orders (buyer_id, invoice_no, order_date, status) 
                VALUES ('$user_id', '$invoice_no', NOW(), '$status')";
        if ($this->db_query($sql)) {
            return $this->db_conn()->insert_id;
        }
        return false;
    }

    // Add Order Details
    public function add_order_details($order_id, $listing_id, $qty) {
        $sql = "INSERT INTO order_details (order_id, listing_id, qty) 
                VALUES ('$order_id', '$listing_id', '$qty')";
        return $this->db_query($sql);
    }

    // Record Payment
    public function record_payment($amount, $user_id, $order_id, $currency = 'GHS') {
        $sql = "INSERT INTO payments (amt, customer_id, order_id, currency, payment_date) 
                VALUES ('$amount', '$user_id', '$order_id', '$currency', NOW())";
        return $this->db_query($sql);
    }

    // --- NEW METHODS FOR PAYSTACK ---

    // Get Order by Invoice (Reference)
    public function get_order_by_invoice($invoice_no) {
        $invoice_no = mysqli_real_escape_string($this->db_conn(), $invoice_no);
        $sql = "SELECT * FROM orders WHERE invoice_no = '$invoice_no'";
        return $this->db_fetch_one($sql);
    }

    // Update Order Status
    public function update_order_status($order_id, $status) {
        $status = mysqli_real_escape_string($this->db_conn(), $status);
        $sql = "UPDATE orders SET status='$status' WHERE order_id='$order_id'";
        return $this->db_query($sql);
    }
}
?>