<?php
require_once(__DIR__ . "/../classes/event_class.php");

function add_event_ctr($organizer_id, $title, $desc, $date, $start, $end, $location, $type, $image) {
    $event = new Event();
    return $event->add_event($organizer_id, $title, $desc, $date, $start, $end, $location, $type, $image);
}

function get_upcoming_events_ctr() {
    $event = new Event();
    return $event->get_upcoming_events();
}

function register_attendee_ctr($event_id, $attendee_id) {
    $event = new Event();
    return $event->register_attendee($event_id, $attendee_id);
}

function get_attendee_count_ctr($event_id) {
    $event = new Event();
    return $event->get_attendee_count($event_id);
}
?>