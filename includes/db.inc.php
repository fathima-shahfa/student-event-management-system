<?php
    $host="localhost";
    $user="root";
    $password= "";
    $database= "event_management_system";

    $conn = new mysqli("localhost", "root", "", "event_management_system", 3307);
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>