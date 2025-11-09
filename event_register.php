<?php
session_start();
include 'includes/db.inc.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=" . urlencode($_SERVER['REQUEST_URI']));
    exit();
}

$user_id = $_SESSION['user_id'];
$error = '';
$success = '';


if (isset($_POST['register_event'])) {
    $event_id = (int)$_POST['event_id'];
    
    
    $event_check = $conn->query("SELECT * FROM events WHERE event_id = $event_id");
    if ($event_check->num_rows == 0) {
        $error = "Event not found!";
    } else {
        
        $check_sql = "SELECT * FROM registrations WHERE user_id = ? AND event_id = ?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("ii", $user_id, $event_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "You are already registered for this event!";
        } else {
           
            $insert_sql = "INSERT INTO registrations (user_id, event_id) VALUES (?, ?)";
            $stmt = $conn->prepare($insert_sql);
            $stmt->bind_param("ii", $user_id, $event_id);
            if ($stmt->execute()) {
                $success = "You have successfully registered for the event!";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
    
    
    if ($error || $success) {
        $_SESSION['registration_message'] = $error ?: $success;
        $_SESSION['message_type'] = $error ? 'error' : 'success';
        header("Location: event-details.php?id=$event_id");
        exit();
    }
} else {
    
    header("Location: events.php");
    exit();
}
?>