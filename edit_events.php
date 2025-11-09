<?php
session_start();
include 'includes/db.inc.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit();
}

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}

if(!isset($_GET['id'])) {
    header("Location: manage_events.php");
    exit();
}

$event_id = (int)$_GET['id'];
$error = '';
$success = '';


$event_result = $conn->query("SELECT * FROM events WHERE event_id = '$event_id'");
if($event_result->num_rows == 0) {
    header("Location: manage_events.php");
    exit();
}
$event = $event_result->fetch_assoc();

if(isset($_POST['update_event'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);
    $venue = mysqli_real_escape_string($conn, $_POST['venue']);
    $organizer = mysqli_real_escape_string($conn, $_POST['organizer']);
    $max_participants = (int)$_POST['max_participants'];
    $event_type = mysqli_real_escape_string($conn, $_POST['event_type']);
    $image_url = mysqli_real_escape_string($conn, $_POST['image_url']);

    if(empty($title) || empty($event_date) || empty($venue)) {
        $error = "Please fill in all required fields!";
    } else {
        $sql = "UPDATE events SET 
                title = '$title',
                description = '$description',
                event_date = '$event_date',
                venue = '$venue',
                organizer = '$organizer',
                max_participants = '$max_participants',
                event_type = '$event_type',
                image_url = '$image_url'
                WHERE event_id = '$event_id'";
        
        if(mysqli_query($conn, $sql)) {
            $success = "Event updated successfully!";
            
            $event_result = $conn->query("SELECT * FROM events WHERE event_id = '$event_id'");
            $event = $event_result->fetch_assoc();
        } else {
            $error = "Error updating event: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event - Admin</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            color: white;
        }
        .event-form {
            background: rgba(113, 67, 149, 0.8);
            padding: 30px;
            border-radius: 10px;
            color: white;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #ffccff;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 2px solid #b637c9;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }
        .form-group textarea {
            height: 100px;
            resize: vertical;
        }
        .form-group select option {
        color: black;
        background: white;
    }
    
        
        .submit-btn {
            background: #630a75;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .submit-btn:hover {
            background: #7a0db0;
        }
        .back-btn-edit{
            color: #dacdcd;
            text-decoration: none;
            padding: 12px 20px;
            border: 1px solid #dacdcd;
            border-radius: 5px;
        }
        .back-btn-edit:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="admin-container">
        <h1>Edit Event</h1>
        
        <?php 
        if($error) echo "<div class='message error'>$error</div>";
        if($success) echo "<div class='message success'>$success</div>";
        ?>

        <form method="post" class="event-form">
            <div class="form-group">
                <label>Event Title *</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($event['title']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Description</label>
                <textarea name="description"><?php echo htmlspecialchars($event['description']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Event Date and Time *</label>
                <input type="datetime-local" name="event_date" value="<?php echo date('Y-m-d\TH:i', strtotime($event['event_date'])); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Venue *</label>
                <input type="text" name="venue" value="<?php echo htmlspecialchars($event['venue']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Organizer</label>
                <input type="text" name="organizer" value="<?php echo htmlspecialchars($event['organizer']); ?>">
            </div>
            
            <div class="form-group">
                <label>Max Participants</label>
                <input type="number" name="max_participants" value="<?php echo $event['max_participants']; ?>">
            </div>
            
            <div class="form-group">
                <label>Event Type</label>
                <select name="event_type" >
                    <option value="workshop" <?php echo ($event['event_type'] == 'workshop') ? 'selected' : ''; ?>>Workshop</option>
                    <option value="seminar" <?php echo ($event['event_type'] == 'seminar') ? 'selected' : ''; ?>>Seminar</option>
                    <option value="hackathon" <?php echo ($event['event_type'] == 'hackathon') ? 'selected' : ''; ?>>Hackathon</option>
                    <option value="social" <?php echo ($event['event_type'] == 'social') ? 'selected' : ''; ?>>Social</option>
                    <option value="sports" <?php echo ($event['event_type'] == 'sports') ? 'selected' : ''; ?>>Sports</option>
                    <option value="academic" <?php echo ($event['event_type'] == 'academic') ? 'selected' : ''; ?>>Academic</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Image URL</label>
                <input type="text" name="image_url" value="<?php echo htmlspecialchars($event['image_url']); ?>" placeholder="images/event.jpg">
            </div>
            
            <button type="submit" name="update_event" class="submit-btn">Update Event</button>
            <a href="manage_events.php" class="back-btn-edit">Back to Events</a>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>