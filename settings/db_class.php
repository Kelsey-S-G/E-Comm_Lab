<?php
// settings/db_class.php
// Ensure no whitespace before this tag
require_once(__DIR__ . "/db_cred.php");

class db_connection {
    public $db = null;
    public $results = null;

    public function db_connect() {
        // Create connection
        $this->db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        // Check connection
        if (mysqli_connect_errno()) {
            // Log error instead of echoing to avoid breaking JSON responses
            error_log("Database connection failed: " . mysqli_connect_error());
            return false;
        }
        return true;
    }

    public function db_query($sqlQuery) {
        if (!$this->db_connect()) {
            return false;
        }
        $this->results = mysqli_query($this->db, $sqlQuery);
        if ($this->results == false) {
            // Log SQL error
            error_log("Query failed: " . mysqli_error($this->db));
            return false;
        }
        return true;
    }

    public function db_fetch_one($sql) {
        if (!$this->db_query($sql)) {
            return false;
        }
        return mysqli_fetch_assoc($this->results);
    }

    public function db_fetch_all($sql) {
        if (!$this->db_query($sql)) {
            return false;
        }
        $data = [];
        while ($row = mysqli_fetch_assoc($this->results)) {
            $data[] = $row;
        }
        return $data;
    }

    public function db_conn() {
        if ($this->db == null) {
            $this->db_connect();
        }
        return $this->db;
    }
}
?>