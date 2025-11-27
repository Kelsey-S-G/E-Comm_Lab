function showPaymentModal() {
    // Instead of showing a local modal, we now initiate the Paystack flow
    const btn = document.querySelector(".checkout-form .btn-primary");
    const originalText = btn.innerText;
    
    btn.disabled = true;
    btn.innerText = "Initializing Payment...";

    fetch("../actions/initialize_payment_action.php", {
        method: "POST"
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            // Redirect user to Paystack Checkout Page
            window.location.href = data.authorization_url;
        } else {
            alert("Payment Error: " + data.message);
            btn.disabled = false;
            btn.innerText = originalText;
        }
    })
    .catch(err => {
        console.error(err);
        alert("Network error occurred.");
        btn.disabled = false;
        btn.innerText = originalText;
    });
}