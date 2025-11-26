document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("ventureForm");
    
    if (form) {
        form.addEventListener("submit", function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            
            fetch("../actions/venture_actions.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    alert(data.message);
                    location.reload();
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(err => console.error(err));
        });
    }
});