<?php
include 'includes/db.inc.php';

header('Content-Type: application/json');

if(isset($_GET['student_id'])) {
    $student_id = mysqli_real_escape_string($conn, $_GET['student_id']);
    
    $sql = "SELECT * FROM users WHERE student_id = '$student_id'";
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