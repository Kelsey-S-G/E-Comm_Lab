<?php
require_once(__DIR__ . "/../settings/db_class.php");

class Event extends db_connection {

    // Create Event
    public function add_event($organizer_id, $title, $desc, $date, $start, $end, $location, $type, $image) {
        $title = mysqli_real_escape_string($this->db_conn(), $title);
        $desc = mysqli_real_escape_string($this->db_conn(), $desc);
        $location = mysqli_real_escape_string($this->db_conn(), $location);

        $sql = "INSERT INTO events (organizer_id, title, description, event_date, start_time, end_time, location, type, image) 
                VALUES ('$organizer_id', '$title', '$desc', '$date', '$start', '$end', '$location', '$type', '$image')";
        return $this->db_query($sql);
    }

    // Get All Upcoming Events
    public function get_upcoming_events() {
        $sql = "SELECT e.*, a.full_name as organizer_name 
                FROM events e 
                JOIN alumni a ON e.organizer_id = a.alumni_id 
                WHERE e.event_date >= CURDATE() 
                ORDER BY e.event_date ASC";
        return $this->db_fetch_all($sql);
    }

    // Register for Event
    public function register_attendee($event_id, $attendee_id) {
        // Check if already registered
        $check = "SELECT * FROM event_registrations WHERE event_id='$event_id' AND attendee_id='$attendee_id'";
        if($this->db_fetch_one($check)) return false;

        $sql = "INSERT INTO event_registrations (event_id, attendee_id) VALUES ('$event_id', '$attendee_id')";
        return $this->db_query($sql);
    }

    // Get Attendee Count
    public function get_attendee_count($event_id) {
        $sql = "SELECT COUNT(*) as count FROM event_registrations WHERE event_id='$event_id'";
        $result = $this->db_fetch_one($sql);
        return $result['count'];
    }
}
?>