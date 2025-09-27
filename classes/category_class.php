<?php
require_once(__DIR__ . "/../settings/core.php");

class category_class extends db_connection {
    // Method to add a new category to the database
    public function add_category($cat_name, $user_id) {
        // Check if the category name already exists for this user
        $stmt = $this->conn->prepare("SELECT cat_id FROM categories WHERE cat_name = ? AND created_by = ?");
        $stmt->bind_param("si", $cat_name, $user_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            return "This category name already exists. Please use a different name.";
        }
        $stmt->close();

        // Insert the new category into the database
        $stmt = $this->conn->prepare("INSERT INTO categories (cat_name, created_by) VALUES (?, ?)");
        $stmt->bind_param("si", $cat_name, $user_id);

        // Execute the query and return the appropriate message
        if ($stmt->execute()) {
            return "Category added successfully!";
        } else {
            return "An error occurred while adding the category: " . $stmt->error;
        }
    }

    // Method to get all categories created by a specific user
    public function get_categories_by_user($user_id) {
        $stmt = $this->conn->prepare("SELECT cat_id, cat_name FROM categories WHERE created_by = ? ORDER BY cat_name ASC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }

        return $categories;
    }

    // Method to get a specific category by ID and user
    public function get_category($cat_id, $user_id) {
        $stmt = $this->conn->prepare("SELECT cat_id, cat_name FROM categories WHERE cat_id = ? AND created_by = ?");
        $stmt->bind_param("ii", $cat_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            return "Category not found.";
        }

        return $result->fetch_assoc();
    }

    // Method to edit an existing category's name
    public function edit_category($cat_id, $cat_name, $user_id) {
        // Check if the new category name already exists for this user (excluding current category)
        $stmt = $this->conn->prepare("SELECT cat_id FROM categories WHERE cat_name = ? AND created_by = ? AND cat_id != ?");
        $stmt->bind_param("sii", $cat_name, $user_id, $cat_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            return "This category name already exists. Please use a different name.";
        }
        $stmt->close();

        // Update the category's name in the database
        $stmt = $this->conn->prepare("UPDATE categories SET cat_name = ? WHERE cat_id = ? AND created_by = ?");
        $stmt->bind_param("sii", $cat_name, $cat_id, $user_id);

        // Execute the query and return the appropriate message
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                return "Category updated successfully!";
            } else {
                return "No category found or no changes were made.";
            }
        } else {
            return "An error occurred while updating the category: " . $stmt->error;
        }
    }

    // Method to delete a category from the database
    public function delete_category($cat_id, $user_id) {
        // Check if the category has associated products
        $stmt = $this->conn->prepare("SELECT COUNT(*) as product_count FROM products WHERE product_cat = ?");
        $stmt->bind_param("i", $cat_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        if ($row['product_count'] > 0) {
            return "Cannot delete category. It has " . $row['product_count'] . " associated product(s).";
        }
        $stmt->close();

        // Delete the category from the database
        $stmt = $this->conn->prepare("DELETE FROM categories WHERE cat_id = ? AND created_by = ?");
        $stmt->bind_param("ii", $cat_id, $user_id);

        // Execute the query and return the appropriate message
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                return "Category deleted successfully!";
            } else {
                return "No category found with the provided ID.";
            }
        } else {
            return "An error occurred while deleting the category: " . $stmt->error;
        }
    }
}
?>