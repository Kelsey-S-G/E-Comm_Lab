function showPaymentModal() {
    document.getElementById("paymentModal").style.display = "flex";
}

function closePaymentModal() {
    document.getElementById("paymentModal").style.display = "none";
}

function processPayment() {
    // Disable buttons to prevent double clicks
    const btns = document.querySelectorAll("#paymentModal button");
    btns.forEach(b => b.disabled = true);
    btns[1].innerText = "Processing...";

    fetch("../actions/process_checkout_action.php", {
        method: "POST"
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            alert("Payment Successful! Invoice: " + data.invoice);
            window.location.href = "listings.php"; // Or a success page
        } else {
            alert("Payment Failed: " + data.message);
            closePaymentModal();
            btns.forEach(b => b.disabled = false);
        }
    })
    .catch(err => {
        console.error(err);
        alert("Network error");
        closePaymentModal();
    });
}