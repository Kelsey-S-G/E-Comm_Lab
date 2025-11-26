<?php
// settings/db_class.php
require_once(__DIR__ . "/db_cred.php");

class db_connection {
    public $db = null;
    public $results = null;

    // Connect to database
    public function db_connect() {
        $this->db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (mysqli_connect_errno()) {
            return false;
        }
        return true;
    }

    // Execute a query
    public function db_query($sqlQuery) {
        if (!$this->db_connect()) {
            return false;
        }
        $this->results = mysqli_query($this->db, $sqlQuery);
        if ($this->results == false) {
            return false;
        }
        return true;
    }

    // Fetch one row
    public function db_fetch_one($sql) {
        if (!$this->db_query($sql)) {
            return false;
        }
        return mysqli_fetch_assoc($this->results);
    }

    // Fetch all rows
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

    // Get the connection object (for escaping strings)
    public function db_conn() {
        if ($this->db == null) {
            $this->db_connect();
        }
        return $this->db;
    }
}
?>