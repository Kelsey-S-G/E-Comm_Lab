function updateQty(id, qty) {
    if (qty < 1) {
        alert("Quantity must be at least 1");
        return;
    }

    const formData = new FormData();
    formData.append("action", "update_qty");
    formData.append("listing_id", id);
    formData.append("qty", qty);

    fetch("../actions/cart_actions.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            location.reload(); // Reload to update totals
        } else {
            alert(data.message);
        }
    })
    .catch(err => console.error(err));
}

function removeItem(id) {
    if (!confirm("Remove this item?")) return;

    const formData = new FormData();
    formData.append("action", "remove");
    formData.append("listing_id", id);

    fetch("../actions/cart_actions.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(err => console.error(err));
}