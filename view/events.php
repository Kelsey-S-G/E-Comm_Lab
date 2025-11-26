<?php
require_once("../settings/core.php");
require_once("../controllers/event_controller.php");

$events = get_upcoming_events_ctr();
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

        <!-- Hero Section -->
        <section class="events-hero">
            <div class="events-hero-content">
                <h1 class="hero-title">Alumni Events</h1>
                <p class="hero-subtitle">Network, learn, and celebrate with fellow alumni.</p>
                <?php if (is_verified()): ?>
                    <button class="btn btn-primary" onclick="document.getElementById('createEventModal').style.display='flex'">Create Event</button>
                <?php endif; ?>
            </div>
        </section>

        <!-- Events Grid -->
        <section class="events-list">
            <div class="events-timeline">
                <?php if (!empty($events)): ?>
                    <?php foreach ($events as $event): 
                        $attendees = get_attendee_count_ctr($event['event_id']);
                        $month = date('M', strtotime($event['event_date']));
                        $day = date('d', strtotime($event['event_date']));
                    ?>
                    <div class="event-card">
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
                            <div class="event-footer">
                                <button class="btn btn-primary" onclick="registerEvent(<?php echo $event['event_id']; ?>)">Register</button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align:center;">No upcoming events found.</p>
                <?php endif; ?>
            </div>
        </section>

        <?php include 'footer.php'; ?>
    </div>

    <!-- Create Event Modal -->
    <div id="createEventModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:2000; align-items:center; justify-content:center;">
        <div style="background:var(--color-surface-elevated); padding:2rem; border-radius:12px; max-width:500px; width:90%; max-height:90vh; overflow-y:auto;">
            <h2 style="margin-bottom:1rem;">Host an Event</h2>
            <form id="createEventForm" enctype="multipart/form-data">
                <input type="hidden" name="action" value="create">
                
                <div class="form-group"><label>Title</label><input type="text" name="title" class="form-input" required></div>
                <div class="form-group"><label>Type</label>
                    <select name="type" class="form-input">
                        <option value="networking">Networking</option>
                        <option value="workshop">Workshop</option>
                        <option value="seminar">Seminar</option>
                        <option value="social">Social</option>
                    </select>
                </div>
                <div class="form-group"><label>Date</label><input type="date" name="date" class="form-input" required></div>
                <div class="form-row" style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div class="form-group"><label>Start</label><input type="time" name="start" class="form-input" required></div>
                    <div class="form-group"><label>End</label><input type="time" name="end" class="form-input" required></div>
                </div>
                <div class="form-group"><label>Location</label><input type="text" name="location" class="form-input" placeholder="Zoom Link or Address" required></div>
                <div class="form-group"><label>Description</label><textarea name="desc" class="form-input" rows="3" required></textarea></div>
                <div class="form-group"><label>Cover Image</label><input type="file" name="image" class="form-input" accept="image/*"></div>

                <div style="display:flex; gap:1rem; justify-content:flex-end; margin-top:1rem;">
                    <button type="button" class="btn btn-outline" onclick="document.getElementById('createEventModal').style.display='none'">Cancel</button>
                    <button type="submit" class="btn btn-primary">Publish Event</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../js/events.js"></script>
</body>
</html>