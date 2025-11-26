// js/login.js
document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.getElementById("loginForm");
    const loginBtn = document.getElementById("loginBtn");
    const msgContainer = document.getElementById("msgContainer");

    loginForm.addEventListener("submit", function(e) {
        e.preventDefault();

        // 1. Loading State
        const originalBtnText = loginBtn.innerText;
        loginBtn.innerText = "Authenticating...";
        loginBtn.disabled = true;

        // 2. AJAX Request
        const formData = new FormData(loginForm);

        fetch("../actions/login_alumni_action.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                showMessage("Login successful! Redirecting...", "success");
                setTimeout(() => {
                    window.location.href = "../index.php"; // Redirect to landing page
                }, 1500);
            } else {
                showMessage(data.message, "error");
                loginBtn.innerText = originalBtnText;
                loginBtn.disabled = false;
            }
        })
        .catch(error => {
            console.error("Error:", error);
            showMessage("Connection error. Please try again.", "error");
            loginBtn.innerText = originalBtnText;
            loginBtn.disabled = false;
        });
    });

    function showMessage(msg, type) {
        msgContainer.textContent = msg;
        msgContainer.className = type === "success" ? "alert alert-success" : "alert alert-danger";
        msgContainer.style.display = "block";
    }
});