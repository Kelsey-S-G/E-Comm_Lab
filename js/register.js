document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("registerForm");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const name = document.getElementById("name").value.trim();
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value;
        const country = document.getElementById("country").value.trim();
        const city = document.getElementById("city").value.trim();
        const contact = document.getElementById("contact").value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const phoneRegex = /^[0-9]{7,15}$/;
        
        // Client-side validation
        if (name.length < 3 || name.length > 50) {
            alert("Full name must be between 3 and 50 characters.");
            return;
        }

        if (!emailRegex.test(email)) {
            alert("Invalid email format.");
            return;
        }

        if (password.length < 6) {
            alert("Password must be at least 6 characters.");
            return;
        }

        if (country.length < 2 || country.length > 50) {
            alert("Country name must be between 2 and 50 characters.");
            return;
        }

        if (city.length < 2 || city.length > 50) {
            alert("City name must be between 2 and 50 characters.");
            return;
        }

        if (!phoneRegex.test(contact)) {
            alert("Invalid phone number. It must be between 7 and 15 digits.");
            return;
        }

        // Show loading spinner or disable the submit button
        const submitButton = form.querySelector("button[type='submit']");
        submitButton.disabled = true;
        submitButton.textContent = "Registering...";

        // Prepare form data
        let formData = new FormData(form);

        // Send the form data to the server
        fetch("../actions/register_customer_action.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                alert("Registration successful! Redirecting to the login page...");
                window.location.href = data.redirect;
            } else {
                alert(data.message);
            }
        })
        .catch(err => {
            alert("An error occurred while processing your registration. Please try again.");
            console.error(err);
        })
        .finally(() => {
            // Re-enable the submit button
            submitButton.disabled = false;
            submitButton.textContent = "Register";
        });
    });
});