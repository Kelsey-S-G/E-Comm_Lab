document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("loginForm");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value;
        
        // Email validation regex
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        // Client-side validation
        if (!email) {
            alert("Email is required.");
            return;
        }

        if (!emailRegex.test(email)) {
            alert("Invalid email format.");
            return;
        }

        if (!password) {
            alert("Password is required.");
            return;
        }

        if (password.length < 6) {
            alert("Password must be at least 6 characters.");
            return;
        }

        // Show loading spinner or disable the submit button
        const submitButton = form.querySelector("button[type='submit']");
        submitButton.disabled = true;
        submitButton.textContent = "Logging in...";

        // Prepare form data
        let formData = new FormData(form);

        // Send the form data to the server
        fetch("../actions/login_customer_action.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                alert(data.message);
                window.location.href = data.redirect;
            } else {
                alert(data.message);
            }
        })
        .catch(err => {
            alert("An error occurred while processing your login. Please try again.");
            console.error(err);
        })
        .finally(() => {
            // Re-enable the submit button
            submitButton.disabled = false;
            submitButton.textContent = "Login";
        });
    });
});