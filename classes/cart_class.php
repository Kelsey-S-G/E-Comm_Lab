<?php
// classes/cart_class.php
require_once(__DIR__ . "/../settings/db_class.php");

class Cart extends db_connection {

    // Add item to cart (or increment quantity if exists)
    public function add_to_cart($p_id, $ip_add, $c_id, $qty) {
        // Check if product already in cart
        $check_sql = "SELECT * FROM cart WHERE p_id = '$p_id' AND c_id = '$c_id'";
        $existing = $this->db_fetch_one($check_sql);

        if ($existing) {
            // Update quantity
            $new_qty = $existing['qty'] + $qty;
            $sql = "UPDATE cart SET qty = '$new_qty' WHERE p_id = '$p_id' AND c_id = '$c_id'";
            return $this->db_query($sql);
        } else {
            // Insert new
            $sql = "INSERT INTO cart (p_id, ip_add, c_id, qty) VALUES ('$p_id', '$ip_add', '$c_id', '$qty')";
            return $this->db_query($sql);
        }
    }

    // Remove item from cart
    public function remove_from_cart($p_id, $c_id) {
        $sql = "DELETE FROM cart WHERE p_id = '$p_id' AND c_id = '$c_id'";
        return $this->db_query($sql);
    }

    // Update quantity
    public function update_cart_qty($p_id, $c_id, $qty) {
        $sql = "UPDATE cart SET qty = '$qty' WHERE p_id = '$p_id' AND c_id = '$c_id'";
        return $this->db_query($sql);
    }

    // Get user cart items
    public function get_cart_items($c_id) {
        // Join with listings (products) table to get details
        $sql = "SELECT c.p_id, c.qty, l.title, l.price, l.image, l.listing_type 
                FROM cart c
                JOIN listings l ON c.p_id = l.listing_id
                WHERE c.c_id = '$c_id'";
        return $this->db_fetch_all($sql);
    }

    // Get cart total amount
    public function get_cart_total($c_id) {
        $sql = "SELECT SUM(c.qty * l.price) as total
                FROM cart c
                JOIN listings l ON c.p_id = l.listing_id
                WHERE c.c_id = '$c_id'";
        $result = $this->db_fetch_one($sql);
        return $result['total'] ?? 0;
    }

    // Empty cart
    public function empty_cart($c_id) {
        $sql = "DELETE FROM cart WHERE c_id = '$c_id'";
        return $this->db_query($sql);
    }
}
?>