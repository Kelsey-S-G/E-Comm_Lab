document.addEventListener("DOMContentLoaded", () => {
    const addCategoryForm = document.getElementById("addCategoryForm");
    const updateCategoryForm = document.getElementById("updateCategoryForm");
    const categoriesContainer = document.getElementById("categoriesContainer");

    // Load categories on page load
    loadCategories();

    // Add category form submission
    if (addCategoryForm) {
        addCategoryForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const catName = document.getElementById("cat_name").value.trim();
            
            // Enhanced client-side validation with type checking
            if (!validateCategoryInput(catName)) {
                return;
            }

            // Show loading state
            const submitButton = addCategoryForm.querySelector("button[type='submit']");
            submitButton.disabled = true;
            submitButton.textContent = "Adding...";

            // Prepare form data
            let formData = new FormData(addCategoryForm);

            // Asynchronously invoke add_category_action.php
            fetch("../actions/add_category_action.php", {
                method: "POST",
                body: formData
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error('Network response was not ok');
                }
                return res.json();
            })
            .then(data => {
                if (data.status === "success") {
                    showSuccessModal("Category Added Successfully!", data.message);
                    addCategoryForm.reset();
                    loadCategories(); // Reload categories
                } else {
                    showErrorModal("Error Adding Category", data.message);
                }
            })
            .catch(err => {
                showErrorModal("Network Error", "An error occurred while adding the category. Please check your connection and try again.");
                console.error('Add Category Error:', err);
            })
            .finally(() => {
                // Re-enable the submit button
                submitButton.disabled = false;
                submitButton.textContent = "Add Category";
            });
        });
    }

    // Update category form submission
    if (updateCategoryForm) {
        updateCategoryForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const catName = document.getElementById("update_cat_name").value.trim();
            const catId = document.getElementById("update_cat_id").value;
            
            // Enhanced client-side validation with type checking
            if (!validateCategoryInput(catName) || !validateCategoryId(catId)) {
                return;
            }

            // Show loading state
            const submitButton = updateCategoryForm.querySelector("button[type='submit']");
            submitButton.disabled = true;
            submitButton.textContent = "Updating...";

            // Prepare form data
            let formData = new FormData(updateCategoryForm);

            // Asynchronously invoke update_category_action.php
            fetch("../actions/update_category_action.php", {
                method: "POST",
                body: formData
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error('Network response was not ok');
                }
                return res.json();
            })
            .then(data => {
                if (data.status === "success") {
                    showSuccessModal("Category Updated Successfully!", data.message);
                    closeUpdateModal();
                    loadCategories(); // Reload categories
                } else {
                    showErrorModal("Error Updating Category", data.message);
                }
            })
            .catch(err => {
                showErrorModal("Network Error", "An error occurred while updating the category. Please check your connection and try again.");
                console.error('Update Category Error:', err);
            })
            .finally(() => {
                // Re-enable the submit button
                submitButton.disabled = false;
                submitButton.textContent = "Update Category";
            });
        });
    }

    // Enhanced validation function for category input with type checking
    function validateCategoryInput(catName) {
        // Type validation - ensure it's a string
        if (typeof catName !== 'string') {
            showErrorModal("Validation Error", "Category name must be a valid text string.");
            return false;
        }

        // Required validation
        if (!catName || catName.trim() === '') {
            showErrorModal("Validation Error", "Category name is required.");
            return false;
        }

        // Length validation
        if (catName.length < 2) {
            showErrorModal("Validation Error", "Category name must be at least 2 characters long.");
            return false;
        }

        if (catName.length > 100) {
            showErrorModal("Validation Error", "Category name must not exceed 100 characters.");
            return false;
        }

        // Pattern validation - only allow letters, numbers, spaces, hyphens, and apostrophes
        const validPattern = /^[a-zA-Z0-9\s\-'&]+$/;
        if (!validPattern.test(catName)) {
            showErrorModal("Validation Error", "Category name can only contain letters, numbers, spaces, hyphens, apostrophes, and ampersands.");
            return false;
        }

        // Check for excessive spaces
        if (catName.trim() !== catName || catName.includes('  ')) {
            showErrorModal("Validation Error", "Category name cannot start or end with spaces, and cannot contain consecutive spaces.");
            return false;
        }

        return true;
    }

    // Validation function for category ID
    function validateCategoryId(catId) {
        // Type validation - ensure it's a number or numeric string
        if (typeof catId !== 'string' && typeof catId !== 'number') {
            showErrorModal("Validation Error", "Invalid category ID format.");
            return false;
        }

        // Convert to number for validation
        const numId = Number(catId);
        
        // Check if it's a valid positive integer
        if (isNaN(numId) || numId <= 0 || !Number.isInteger(numId)) {
            showErrorModal("Validation Error", "Category ID must be a positive integer.");
            return false;
        }

        return true;
    }

    // Function to load categories (asynchronously invoke fetch_category_action.php)
    function loadCategories() {
        fetch("../actions/fetch_category_action.php", {
            method: "GET"
        })
        .then(res => {
            if (!res.ok) {
                throw new Error('Network response was not ok');
            }
            return res.json();
        })
        .then(data => {
            if (data.status === "success") {
                displayCategories(data.data);
            } else {
                showErrorModal("Error Loading Categories", data.message);
                console.error("Error loading categories:", data.message);
            }
        })
        .catch(err => {
            showErrorModal("Network Error", "An error occurred while loading categories. Please refresh the page and try again.");
            console.error("Error loading categories:", err);
        });
    }

    // Function to display categories
    function displayCategories(categories) {
        if (!categoriesContainer) return;

        if (categories.length === 0) {
            categoriesContainer.innerHTML = `
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <h5>No Categories Found</h5>
                        <p>You haven't created any categories yet. Add your first category using the form above.</p>
                    </div>
                </div>
            `;
            return;
        }

        let html = '';
        categories.forEach(category => {
            html += `
                <div class="col-md-4 mb-3">
                    <div class="card category-card">
                        <div class="card-body">
                            <h5 class="card-title">${escapeHtml(category.cat_name)}</h5>
                            <p class="card-text text-muted">Category ID: ${category.cat_id}</p>
                            <div class="btn-group w-100" role="group">
                                <button class="btn btn-outline-primary btn-sm" onclick="editCategory(${category.cat_id}, '${escapeHtml(category.cat_name)}')">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-outline-danger btn-sm" onclick="deleteCategory(${category.cat_id}, '${escapeHtml(category.cat_name)}')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        categoriesContainer.innerHTML = html;
    }

    // Function to escape HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Make functions globally available
    window.editCategory = function(catId, catName) {
        // Validate parameters
        if (!validateCategoryId(catId)) {
            return;
        }
        
        if (!validateCategoryInput(catName)) {
            return;
        }

        document.getElementById("update_cat_id").value = catId;
        document.getElementById("update_cat_name").value = catName;
        document.getElementById("updateModal").style.display = "block";
    };

    // Enhanced delete function (asynchronously invoke delete_category_action.php)
    window.deleteCategory = function(catId, catName) {
        // Validate parameters
        if (!validateCategoryId(catId)) {
            return;
        }
        
        if (!validateCategoryInput(catName)) {
            return;
        }

        showConfirmModal(
            "Confirm Deletion", 
            `Are you sure you want to delete the category "${escapeHtml(catName)}"? This action cannot be undone and may affect associated products.`,
            () => {
                // User confirmed deletion
                const formData = new FormData();
                formData.append('cat_id', catId);

                fetch("../actions/delete_category_action.php", {
                    method: "POST",
                    body: formData
                })
                .then(res => {
                    if (!res.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return res.json();
                })
                .then(data => {
                    if (data.status === "success") {
                        showSuccessModal("Category Deleted Successfully!", data.message);
                        loadCategories(); // Reload categories
                    } else {
                        showErrorModal("Error Deleting Category", data.message);
                    }
                })
                .catch(err => {
                    showErrorModal("Network Error", "An error occurred while deleting the category. Please check your connection and try again.");
                    console.error('Delete Category Error:', err);
                });
            }
        );
    };

    // Modal functions for better user feedback
    function showSuccessModal(title, message) {
        createModal(title, message, 'success');
    }

    function showErrorModal(title, message) {
        createModal(title, message, 'error');
    }

    function showConfirmModal(title, message, onConfirm) {
        createModal(title, message, 'confirm', onConfirm);
    }

    function createModal(title, message, type, onConfirm = null) {
        // Remove existing modal if any
        const existingModal = document.getElementById('dynamicModal');
        if (existingModal) {
            existingModal.remove();
        }

        // Create modal HTML
        const modal = document.createElement('div');
        modal.id = 'dynamicModal';
        modal.className = 'modal';
        modal.style.display = 'block';

        const iconClass = type === 'success' ? 'fa-check-circle text-success' : 
                         type === 'error' ? 'fa-exclamation-circle text-danger' : 
                         'fa-question-circle text-warning';

        const buttons = type === 'confirm' 
            ? `<button type="button" class="btn btn-secondary me-2" onclick="closeDynamicModal()">Cancel</button>
               <button type="button" class="btn btn-danger" onclick="confirmAction()">Delete</button>`
            : `<button type="button" class="btn btn-primary" onclick="closeDynamicModal()">OK</button>`;

        modal.innerHTML = `
            <div class="modal-content">
                <div class="modal-header">
                    <h5><i class="fas ${iconClass} me-2"></i>${escapeHtml(title)}</h5>
                    <span class="close" onclick="closeDynamicModal()">&times;</span>
                </div>
                <div class="modal-body">
                    <p>${escapeHtml(message)}</p>
                </div>
                <div class="modal-footer">
                    ${buttons}
                </div>
            </div>
        `;

        document.body.appendChild(modal);

        // Store confirm callback if provided
        if (onConfirm) {
            window.currentConfirmCallback = onConfirm;
        }

        // Auto-close success modals after 3 seconds
        if (type === 'success') {
            setTimeout(() => {
                closeDynamicModal();
            }, 3000);
        }
    }

    window.closeDynamicModal = function() {
        const modal = document.getElementById('dynamicModal');
        if (modal) {
            modal.remove();
        }
        window.currentConfirmCallback = null;
    };

    window.confirmAction = function() {
        if (window.currentConfirmCallback) {
            window.currentConfirmCallback();
        }
        closeDynamicModal();
    };

    window.closeUpdateModal = function() {
        document.getElementById("updateModal").style.display = "none";
    };

    // Close modal when clicking outside of it
    window.onclick = function(event) {
        const modal = document.getElementById("updateModal");
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };
});