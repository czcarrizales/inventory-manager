<?php
include 'database.php';
include 'database.class.php';

class Session {
    private $db;
    public function __construct() {
        $this->db = new Database;
        session_set_save_handler(
            [$this, "_open"],
            [$this, "_close"],
            [$this, "_read"],
            [$this, "_write"],
            [$this, "_destroy"],
            [$this, "_gc"]
        );
        session_start();
    }
    public function _open() {
        // If successful
        if ($this->db) {
            // Return True
            return true;
        }
        // Return False
        return false;
    }
    public function _close() {
        // // Close the database connection
        // // If successful
        // if ($this->db->close()) {
        //     // Return True
        //     return true;
        // }
        // Return False
        return false;
    }
    public function _read($id) {
        // Set query
        $this->db->query("SELECT session_data FROM sessions WHERE session_id = :id");
    
        // Bind the Id
        $this->db->bind(":id", $id);
    
        // Attempt execution
        // If successful
        if ($this->db->execute()) {
            // Save returned row
            $row = $this->db->single();
            // Return the data
            echo 'authenticated';
            return $row['data'] ?? '';
        }else{
            // Return an empty string
            echo 'not authenticated';
            return "";
        }
    }
    public function _write($id, $data) {
        // Create time stamp
        $access = time();
    
        // Set query
        $this->db->query("REPLACE INTO sessions VALUES (:id, :access, :data)");
    
        // Bind data
        $this->db->bind(":id", $id);
        $this->db->bind(":access", $access);
        $this->db->bind(":data", $data);
    
        // Attempt Execution
        // If successful
        if ($this->db->execute()) {
            // Return True
            return true;
        }
    
        // Return False
        return false;
    }
    public function _destroy($id) {
        // Set query
        $this->db->query("DELETE FROM sessions WHERE id = :id");
    
        // Bind data
        $this->db->bind(":id", $id);
    
        // Attempt execution
        // If successful
        if ($this->db->execute()) {
            // Return True
            return true;
        }
    
        // Return False
        return false;
    }
    public function _gc($max) {
        // Calculate what is to be deemed old
        $old = time() - $max;
    
        // Set query
        $this->db->query("DELETE * FROM sessions WHERE access < :old");
    
        // Bind data
        $this->db->bind(":old", $old);
    
        // Attempt execution
        if ($this->db->execute()) {
            // Return True
            return true;
        }
    
        // Return False
        return false;
    }
}