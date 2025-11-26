function registerEvent(eventId) {
    if (!confirm("Confirm registration for this event?")) return;

    const formData = new FormData();
    formData.append("action", "register");
    formData.append("event_id", eventId);

    fetch("../actions/event_actions.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
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

document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("createEventForm");
    if (form) {
        form.addEventListener("submit", function(e) {
            e.preventDefault();
            const formData = new FormData(form);

            fetch("../actions/event_actions.php", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
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