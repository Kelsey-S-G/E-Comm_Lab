<?php
require_once("../settings/core.php");
require_once("../controllers/event_controller.php");

$institution_id = $_SESSION['institution_id'] ?? 0;
$events = get_upcoming_events_ctr($institution_id);
$is_admin = is_admin();
?>
<?php include 'header.php'; ?>

<link rel="stylesheet" href="../css/events.css" />

<div class="events-container">
    <section class="events-hero">
        <div class="events-hero-content">
            <h1 class="hero-title">Alumni Events</h1>
            <p class="hero-subtitle">Events happening at your institution.</p>
            
            <?php if ($is_admin): ?>
                <button class="btn btn-primary" onclick="openCreateModal()">Create Event</button>
            <?php endif; ?>
        </div>
    </section>

    <section class="events-list">
        <div class="events-timeline">
            <?php if (!empty($events)): ?>
                <?php foreach ($events as $event): 
                    $attendees = get_attendee_count_ctr($event['event_id']);
                    $month = date('M', strtotime($event['event_date']));
                    $day = date('d', strtotime($event['event_date']));
                ?>
                <div class="event-card" id="event-<?php echo $event['event_id']; ?>">
                    <div class="event-image">
                        <img src="<?php echo $event['image'] ? $event['image'] : '../assets/event_placeholder.jpg'; ?>" alt="<?php echo $event['title']; ?>" class="event-img" />
                        <span class="event-badge"><?php echo ucfirst($event['type']); ?></span>
                    </div>
                    <div class="event-content">
                        <div class="event-date">
                            <div class="date-box">
                                <div class="date-month"><?php echo $month; ?></div>
                                <div class="date-day"><?php echo $day; ?></div>
                            </div>
                            <div class="event-meta">
                                <p class="event-time"><?php echo date('g:i A', strtotime($event['start_time'])); ?> - <?php echo date('g:i A', strtotime($event['end_time'])); ?></p>
                                <p class="event-location"><?php echo $event['location']; ?></p>
                            </div>
                        </div>
                        <h3 class="event-title"><?php echo $event['title']; ?></h3>
                        <p class="event-description"><?php echo substr($event['description'], 0, 100) . '...'; ?></p>
                        <div class="event-details">
                            <span class="detail-item">👥 <?php echo $attendees; ?> Attendees</span>
                            <span class="detail-item">🎤 By <?php echo $event['organizer_name']; ?></span>
                        </div>
                        <div class="event-footer" style="display: flex; gap: 10px; flex-wrap: wrap;">
                            <button class="btn btn-primary" onclick="registerEvent(<?php echo $event['event_id']; ?>)">Register</button>
                            <?php if ($is_admin): ?>
                                <button class="btn btn-sm btn-outline" onclick="openEditModal(<?php echo $event['event_id']; ?>)">Edit</button>
                                <button class="btn btn-sm btn-outline" style="border-color: red; color: red;" onclick="deleteEvent(<?php echo $event['event_id']; ?>)">Delete</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align:center;">No upcoming events found for your institution.</p>
            <?php endif; ?>
        </div>
    </section>
</div>

<div id="eventModal" class="modal-overlay" style="display:none;">
    <div class="modal-content">
        <h2 id="modalTitle" class="modal-title">Host an Event</h2>
        
        <form id="eventForm" enctype="multipart/form-data">
            <input type="hidden" id="formAction" name="action" value="create">
            <input type="hidden" id="eventId" name="event_id" value="">

            <div class="form-group">
                <label>Title</label>
                <input type="text" id="eTitle" name="title" class="form-input" required>
            </div>
            
            <div class="form-group">
                <label>Type</label>
                <select id="eType" name="type" class="form-input">
                    <option value="networking">Networking</option>
                    <option value="workshop">Workshop</option>
                    <option value="seminar">Seminar</option>
                    <option value="social">Social</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Date</label>
                <input type="date" id="eDate" name="date" class="form-input" required>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Start</label>
                    <input type="time" id="eStart" name="start" class="form-input" required>
                </div>
                <div class="form-group">
                    <label>End</label>
                    <input type="time" id="eEnd" name="end" class="form-input" required>
                </div>
            </div>
            
            <div class="form-group">
                <label>Location</label>
                <input type="text" id="eLocation" name="location" class="form-input" placeholder="Zoom Link or Address" required>
            </div>
            
            <div class="form-group">
                <label>Description</label>
                <textarea id="eDesc" name="desc" class="form-input" rows="3" required></textarea>
            </div>
            
            <div class="form-group">
                <label>Cover Image (Optional)</label>
                <input type="file" name="image" class="form-input" accept="image/*">
            </div>
            
            <div class="modal-actions">
                <button type="button" class="btn btn-outline" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn btn-primary" id="saveBtn">Publish Event</button>
            </div>
        </form>
    </div>
</div>

<script src="../js/events.js"></script>
<script>
function closeModal() {
    const modal = document.getElementById('eventModal');
    modal.classList.remove('active');
    setTimeout(() => { modal.style.display = 'none'; }, 300);
}

function openCreateModal() {
    document.getElementById('eventForm').reset();
    document.getElementById('formAction').value = 'create';
    document.getElementById('eventId').value = '';
    document.getElementById('modalTitle').innerText = 'Host an Event';
    document.getElementById('saveBtn').innerText = 'Publish Event';
    
    const modal = document.getElementById('eventModal');
    modal.style.display = 'flex';
    setTimeout(() => modal.classList.add('active'), 10);
}

function openEditModal(id) {
    const formData = new FormData();
    formData.append('action', 'fetch_details');
    formData.append('event_id', id);

    fetch('../actions/event_actions.php', { method: 'POST', body: formData })
    .then(res => res.json())
    .then(resp => {
        if(resp.status === 'success') {
            const data = resp.data;
            document.getElementById('eTitle').value = data.title;
            document.getElementById('eType').value = data.type;
            document.getElementById('eDate').value = data.event_date;
            document.getElementById('eStart').value = data.start_time;
            document.getElementById('eEnd').value = data.end_time;
            document.getElementById('eLocation').value = data.location;
            document.getElementById('eDesc').value = data.description;
            
            document.getElementById('formAction').value = 'update';
            document.getElementById('eventId').value = data.event_id;
            document.getElementById('modalTitle').innerText = 'Edit Event';
            document.getElementById('saveBtn').innerText = 'Save Changes';
            
            const modal = document.getElementById('eventModal');
            modal.style.display = 'flex';
            setTimeout(() => modal.classList.add('active'), 10);
        } else {
            alert(resp.message);
        }
    });
}

document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("eventForm");
    if (form) {
        form.addEventListener("submit", function(e) {
            e.preventDefault();
            const formData = new FormData(form);
            fetch("../actions/event_actions.php", { method: "POST", body: formData })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            });
        });
    }
});

function deleteEvent(id) {
    if(!confirm("Are you sure you want to delete this event?")) return;
    const formData = new FormData();
    formData.append("action", "delete");
    formData.append("event_id", id);
    fetch("../actions/event_actions.php", { method: "POST", body: formData })
    .then(res => res.json())
    .then(data => {
        if(data.status === "success") {
            document.getElementById("event-"+id).remove();
        } else {
            alert(data.message);
        }
    });
}
</script>

<?php include 'footer.php'; ?>