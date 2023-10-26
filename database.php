<?php

define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_NAME", "inventory_manager");
$server = "localhost";     // Your MySQL server
$username = "root";        // Your MySQL username
$password = "";            // Your MySQL password
$database = "inventory_manager";  // Your MySQL database name

// Create a connection function
function connectToDatabase() {
    global $server, $username, $password, $database;
    $conn = new mysqli($server, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
?>