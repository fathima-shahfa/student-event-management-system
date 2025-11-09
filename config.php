<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'event_management_system');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_PORT', '3307');


try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>