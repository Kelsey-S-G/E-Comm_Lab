<?php
require_once(__DIR__ . "/../settings/core.php");

class brand_class extends db_connection {
    // Method to add a new brand to the database
    public function add_brand($brand_name) {
        // Check if the brand name already exists
        $stmt = $this->conn->prepare("SELECT brand_id FROM brands WHERE brand_name = ?");
        $stmt->bind_param("s", $brand_name);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            return "This brand name already exists. Please use a different name.";
        }
        $stmt->close();

        // Insert the new brand into the database
        $stmt = $this->conn->prepare("INSERT INTO brands (brand_name) VALUES (?)");
        $stmt->bind_param("s", $brand_name);

        // Execute the query and return the appropriate message
        if ($stmt->execute()) {
            return "Brand added successfully!";
        } else {
            return "An error occurred while adding the brand: " . $stmt->error;
        }
    }

    // Method to fetch all brands
    public function fetch_brands() {
        $stmt = $this->conn->prepare("SELECT brand_id, brand_name FROM brands ORDER BY brand_name ASC");
        $stmt->execute();
        $result = $stmt->get_result();

        $brands = [];
        while ($row = $result->fetch_assoc()) {
            $brands[] = $row;
        }

        return $brands;
    }

    // Method to delete a brand
    public function delete_brand($brand_id) {
        $stmt = $this->conn->prepare("DELETE FROM brands WHERE brand_id = ?");
        $stmt->bind_param("i", $brand_id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                return "Brand deleted successfully!";
            } else {
                return "No brand found with the provided ID.";
            }
        } else {
            return "An error occurred while deleting the brand: " . $stmt->error;
        }
    }

    // Method to update a brand's name
    public function update_brand($brand_id, $brand_name) {
        // Check if the new brand name already exists
        $stmt = $this->conn->prepare("SELECT brand_id FROM brands WHERE brand_name = ? AND brand_id != ?");
        $stmt->bind_param("si", $brand_name, $brand_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            return "This brand name already exists. Please use a different name.";
        }
        $stmt->close();

        // Update the brand name
        $stmt = $this->conn->prepare("UPDATE brands SET brand_name = ? WHERE brand_id = ?");
        $stmt->bind_param("si", $brand_name, $brand_id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                return "Brand updated successfully!";
            } else {
                return "No brand found or no changes were made.";
            }
        } else {
            return "An error occurred while updating the brand: " . $stmt->error;
        }
    }
}
