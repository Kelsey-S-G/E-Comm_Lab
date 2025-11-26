document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("listingForm");
    
    if (form) {
        form.addEventListener("submit", function(e) {
            e.preventDefault();
            
            const formData = new FormData(form); // Handles File Upload Automatically
            
            fetch("../actions/listing_actions.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    alert(data.message);
                    // Ideally redirect to listing view or clear form
                    form.reset();
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(err => console.error(err));
        });
    }
});