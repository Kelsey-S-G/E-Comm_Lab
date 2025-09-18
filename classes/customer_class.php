<?php
require_once(__DIR__ . "/../settings/core.php");

class customer_class extends db_connection {
    // Method to add a new customer to the database
    public function add_customer($name, $email, $password, $country, $city, $contact, $role = 2) {
        // Hash the password for security
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        // Check if the email already exists in the database
        $stmt = $this->conn->prepare("SELECT customer_id FROM customer WHERE customer_email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            return "This email is already registered. Please use a different email.";
        }
        $stmt->close();

        // Insert the new customer into the database
        $stmt = $this->conn->prepare("INSERT INTO customer 
            (customer_name, customer_email, customer_pass, customer_country, customer_city, customer_contact, user_role) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssi", $name, $email, $hashed, $country, $city, $contact, $role);

        // Execute the query and return the appropriate message
        if ($stmt->execute()) {
            return "Customer added successfully!";
        } else {
            return "An error occurred while adding the customer: " . $stmt->error;
        }
    }

    // Method to edit an existing customer's details
    public function edit_customer($customer_id, $name, $email, $country, $city, $contact) {
        // Update the customer's details in the database
        $stmt = $this->conn->prepare("UPDATE customer 
            SET customer_name = ?, customer_email = ?, customer_country = ?, customer_city = ?, customer_contact = ? 
            WHERE customer_id = ?");
        $stmt->bind_param("sssssi", $name, $email, $country, $city, $contact, $customer_id);

        // Execute the query and return the appropriate message
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                return "Customer details updated successfully!";
            } else {
                return "No changes were made to the customer details.";
            }
        } else {
            return "An error occurred while updating the customer: " . $stmt->error;
        }
    }

        // Method to delete a customer from the database
    public function delete_customer($customer_id) {
        // Delete the customer from the database
        $stmt = $this->conn->prepare("DELETE FROM customer WHERE customer_id = ?");
        $stmt->bind_param("i", $customer_id);

        // Execute the query and return the appropriate message
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                return "Customer deleted successfully!";
            } else {
                return "No customer found with the provided ID.";
            }
        } else {
            return "An error occurred while deleting the customer: " . $stmt->error;
        }
    }
}
?>