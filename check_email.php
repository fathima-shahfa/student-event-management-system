<?php
include 'includes/db.inc.php';

header('Content-Type: application/json');

if(isset($_GET['email'])) {
    $email = mysqli_real_escape_string($conn, $_GET['email']);
    
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) > 0) {
        echo json_encode(['exists' => true]);
    } else {
        echo json_encode(['exists' => false]);
    }
} else {
    echo json_encode(['exists' => false]);
}
?>