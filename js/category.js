// js/category.js

document.addEventListener("DOMContentLoaded", function() {
    
    // --- ADD CATEGORY ---
    const addBtn = document.getElementById("addCategoryBtn");
    if(addBtn) {
        addBtn.addEventListener("click", function() {
            const nameInput = document.getElementById("newCategoryName");
            const name = nameInput.value.trim();

            if (!name) {
                alert("Please enter a sector name.");
                return;
            }

            const formData = new FormData();
            formData.append("action", "add");
            formData.append("cat_name", name);

            fetch("../actions/category_actions.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    alert(data.message);
                    location.reload(); // Reload to show new item (Simple implementation)
                } else {
                    alert(data.message);
                }
            })
            .catch(err => console.error(err));
        });
    }
});

// --- EDIT UI TOGGLE ---
function enableEdit(id) {
    const row = document.getElementById(`row-${id}`);
    row.querySelector(".display-name").style.display = "none";
    row.querySelector(".edit-input").style.display = "inline-block";
    row.querySelector(".btn-edit").style.display = "none";
    row.querySelector(".btn-save").style.display = "inline-block";
}

// --- SAVE EDIT (UPDATE) ---
function saveEdit(id) {
    const row = document.getElementById(`row-${id}`);
    const newName = row.querySelector(".edit-input").value.trim();

    if (!newName) {
        alert("Name cannot be empty.");
        return;
    }

    const formData = new FormData();
    formData.append("action", "update");
    formData.append("cat_id", id);
    formData.append("cat_name", newName);

    fetch("../actions/category_actions.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(err => console.error(err));
}

// --- DELETE CATEGORY ---
function deleteCategory(id) {
    if (!confirm("Are you sure you want to delete this sector?")) return;

    const formData = new FormData();
    formData.append("action", "delete");
    formData.append("cat_id", id);

    fetch("../actions/category_actions.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            document.getElementById(`row-${id}`).remove(); // Remove row from DOM
        } else {
            alert(data.message);
        }
    })
    .catch(err => console.error(err));
}