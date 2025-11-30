<?php
require_once(__DIR__ . "/../settings/db_class.php");

class Event extends db_connection {

    // ... (Previous methods: add_event, get_upcoming_events, register_attendee, get_attendee_count) ...
    public function add_event($organizer_id, $title, $desc, $date, $start, $end, $location, $type, $image) {
        $title = mysqli_real_escape_string($this->db_conn(), $title);
        $desc = mysqli_real_escape_string($this->db_conn(), $desc);
        $location = mysqli_real_escape_string($this->db_conn(), $location);

        $sql = "INSERT INTO events (organizer_id, title, description, event_date, start_time, end_time, location, type, image) 
                VALUES ('$organizer_id', '$title', '$desc', '$date', '$start', '$end', '$location', '$type', '$image')";
        return $this->db_query($sql);
    }

    public function get_upcoming_events($institution_id) {
        $id = (int)$institution_id;
        $sql = "SELECT e.*, a.full_name as organizer_name, a.institution_id 
                FROM events e 
                JOIN alumni a ON e.organizer_id = a.alumni_id 
                WHERE e.event_date >= CURDATE() 
                AND a.institution_id = '$id'
                ORDER BY e.event_date ASC";
        return $this->db_fetch_all($sql);
    }

    public function register_attendee($event_id, $attendee_id) {
        $check = "SELECT * FROM event_registrations WHERE event_id='$event_id' AND attendee_id='$attendee_id'";
        if($this->db_fetch_one($check)) return false;

        $sql = "INSERT INTO event_registrations (event_id, attendee_id) VALUES ('$event_id', '$attendee_id')";
        return $this->db_query($sql);
    }

    public function get_attendee_count($event_id) {
        $sql = "SELECT COUNT(*) as count FROM event_registrations WHERE event_id='$event_id'";
        $result = $this->db_fetch_one($sql);
        return $result['count'];
    }

    // NEW: Update Event
    public function update_event($id, $title, $desc, $date, $start, $end, $location, $type) {
        $title = mysqli_real_escape_string($this->db_conn(), $title);
        $desc = mysqli_real_escape_string($this->db_conn(), $desc);
        $location = mysqli_real_escape_string($this->db_conn(), $location);
        
        $sql = "UPDATE events SET title='$title', description='$desc', event_date='$date', start_time='$start', end_time='$end', location='$location', type='$type' WHERE event_id='$id'";
        return $this->db_query($sql);
    }

    // NEW: Delete Event
    public function delete_event($id) {
        // Delete registrations first
        $this->db_query("DELETE FROM event_registrations WHERE event_id='$id'");
        $sql = "DELETE FROM events WHERE event_id='$id'";
        return $this->db_query($sql);
    }
}
?>