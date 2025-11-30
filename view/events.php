<?php
require_once("../settings/core.php");
require_once("../controllers/event_controller.php");

$institution_id = $_SESSION['institution_id'] ?? 0;
$events = get_upcoming_events_ctr($institution_id);
$is_admin = is_admin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Events - ReConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="../css/events.css" />
</head>
<body>
    <div class="events-container">
        <?php include 'header.php'; ?>

        <section class="events-hero">
            <div class="events-hero-content">
                <h1 class="hero-title">Alumni Events</h1>
                <p class="hero-subtitle">Events happening at your institution.</p>
                <!-- Only Admin can create -->
                <?php if ($is_admin): ?>
                    <button class="btn btn-primary" onclick="document.getElementById('createEventModal').style.display='flex'">Create Event</button>
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
                            <img src="<?php echo $event['image']; ?>" alt="<?php echo $event['title']; ?>" class="event-img" />
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

        <?php include 'footer.php'; ?>
    </div>

    <div id="createEventModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:2000; align-items:center; justify-content:center;">
        <div style="background:var(--color-surface-elevated); padding:2rem; border-radius:12px; max-width:500px; width:90%; max-height:90vh; overflow-y:auto; border: 1px solid var(--color-border); box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);">
            <!-- Improved modal header styling to match page theme -->
            <h2 style="margin:0 0 1.5rem 0; color:var(--color-on-surface); font-size:1.5rem; font-weight:600; font-family:var(--font-family-heading); border-bottom:2px solid var(--color-primary); padding-bottom:1rem;">Host an Event</h2>
            <form id="createEventForm" enctype="multipart/form-data">
                <input type="hidden" name="action" value="create">
                <!-- Form fields (same as previous) -->
                <div class="form-group"><label style="color:var(--color-on-surface); font-weight:600;">Title</label><input type="text" name="title" class="form-input" required></div>
                <div class="form-group"><label style="color:var(--color-on-surface); font-weight:600;">Type</label>
                    <select name="type" class="form-input">
                        <option value="networking">Networking</option>
                        <option value="workshop">Workshop</option>
                        <option value="seminar">Seminar</option>
                        <option value="social">Social</option>
                    </select>
                </div>
                <div class="form-group"><label style="color:var(--color-on-surface); font-weight:600;">Date</label><input type="date" name="date" class="form-input" required></div>
                <div class="form-row" style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                    <div class="form-group" style="margin-bottom:0;"><label style="color:var(--color-on-surface); font-weight:600;">Start</label><input type="time" name="start" class="form-input" required></div>
                    <div class="form-group" style="margin-bottom:0;"><label style="color:var(--color-on-surface); font-weight:600;">End</label><input type="time" name="end" class="form-input" required></div>
                </div>
                <div class="form-group"><label style="color:var(--color-on-surface); font-weight:600;">Location</label><input type="text" name="location" class="form-input" placeholder="Zoom Link or Address" required></div>
                <div class="form-group"><label style="color:var(--color-on-surface); font-weight:600;">Description</label><textarea name="desc" class="form-input" rows="3" required></textarea></div>
                <div class="form-group"><label style="color:var(--color-on-surface); font-weight:600;">Cover Image</label><input type="file" name="image" class="form-input" accept="image/*"></div>

                <!-- Updated button styling to match page theme -->
                <div style="display:flex; gap:1rem; justify-content:flex-end; margin-top:2rem;">
                    <button type="button" class="btn btn-outline" onclick="document.getElementById('createEventModal').style.display='none'" style="border: 1px solid var(--color-border); color: var(--color-on-surface); background: transparent; padding: 0.75rem 1.5rem; border-radius: 8px; cursor: pointer; font-weight: 600; transition: all 0.2s ease;">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background: var(--color-primary); color: var(--color-on-primary); padding: 0.75rem 1.5rem; border-radius: 8px; border: none; cursor: pointer; font-weight: 600; transition: all 0.2s ease;">Publish Event</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../js/events.js"></script>
    <script>
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
</body>
</html>
