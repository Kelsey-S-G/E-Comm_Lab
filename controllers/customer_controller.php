<?php
require_once(__DIR__ . "/../classes/customer_class.php");

function register_customer_ctr($name, $email, $password, $country, $city, $contact, $role = 2) {
    // Create an instance of the customer_class
    $customer = new customer_class();

    // Call the add_customer method and return its result
    return $customer->add_customer($name, $email, $password, $country, $city, $contact, $role);
}
?>