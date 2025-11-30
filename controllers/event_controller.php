<?php
require_once(__DIR__ . "/../classes/event_class.php");

// ... (Keep existing controllers: add_event_ctr, get_upcoming_events_ctr, etc.) ...
function add_event_ctr($organizer_id, $title, $desc, $date, $start, $end, $location, $type, $image) {
    $event = new Event();
    return $event->add_event($organizer_id, $title, $desc, $date, $start, $end, $location, $type, $image);
}

function get_upcoming_events_ctr($institution_id) {
    $event = new Event();
    return $event->get_upcoming_events($institution_id);
}

function register_attendee_ctr($event_id, $attendee_id) {
    $event = new Event();
    return $event->register_attendee($event_id, $attendee_id);
}

function get_attendee_count_ctr($event_id) {
    $event = new Event();
    return $event->get_attendee_count($event_id);
}

// NEW: Get One
function get_one_event_ctr($id) {
    $event = new Event();
    return $event->get_one_event($id);
}

// UPDATED: Update
function update_event_ctr($id, $title, $desc, $date, $start, $end, $location, $type, $image = null) {
    $event = new Event();
    return $event->update_event($id, $title, $desc, $date, $start, $end, $location, $type, $image);
}

function delete_event_ctr($id) {
    $event = new Event();
    return $event->delete_event($id);
}
?>