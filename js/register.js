// js/register.js
document.addEventListener("DOMContentLoaded", function() {
    const registerForm = document.getElementById("registerForm");
    const submitBtn = document.getElementById("submitBtn");
    const msgContainer = document.getElementById("msgContainer");

    registerForm.addEventListener("submit", function(e) {
        e.preventDefault(); // Prevent default form submission

        // 1. Client-Side Validation (Regex)
        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;
        const contact = document.getElementById("contact").value;
        
        // Email Regex
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            showMessage("Please enter a valid email address.", "error");
            return;
        }

        // Password Length Check
        if (password.length < 6) {
            showMessage("Password must be at least 6 characters long.", "error");
            return;
        }

        // Phone Number Regex (Basic digit check)
        const phonePattern = /^\d{10,15}$/;
        if (!phonePattern.test(contact)) {
            showMessage("Please enter a valid contact number (10-15 digits).", "error");
            return;
        }

        // 2. Loading State
        const originalBtnText = submitBtn.innerText;
        submitBtn.innerText = "Verifying...";
        submitBtn.disabled = true;

        // 3. Collect Data
        const formData = new FormData(registerForm);

        // 4. AJAX Request
        fetch("../actions/register_alumni_action.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                showMessage(data.message, "success");
                setTimeout(() => {
                    window.location.href = "signin.php"; // Redirect to login
                }, 2000);
            } else {
                showMessage(data.message, "error");
                submitBtn.innerText = originalBtnText;
                submitBtn.disabled = false;
            }
        })
        .catch(error => {
            console.error("Error:", error);
            showMessage("An unexpected error occurred.", "error");
            submitBtn.innerText = originalBtnText;
            submitBtn.disabled = false;
        });
    });

    function showMessage(msg, type) {
        msgContainer.textContent = msg;
        msgContainer.className = type === "success" ? "alert alert-success" : "alert alert-danger";
        msgContainer.style.display = "block";
    }
});