<?php
session_start();
include 'includes/db.inc.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit();
}

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}

$error = '';
$success = '';

if (isset($_POST['add_event'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);
    $venue = mysqli_real_escape_string($conn, $_POST['venue']);
    $organizer = mysqli_real_escape_string($conn, $_POST['organizer']);
    $max_participants = (int)$_POST['max_participants'];
    $event_type = mysqli_real_escape_string($conn, $_POST['event_type']);
    $image_url = mysqli_real_escape_string($conn, $_POST['image_url']);
    $created_by = $_SESSION['user_id'];

    if (empty($title) || empty($event_date) || empty($venue)) {
        $error = "Please fill in all required fields!";
    } else {
        $sql = "INSERT INTO events (title, description, event_date, venue, organizer, max_participants, event_type, image_url, created_by) 
                VALUES ('$title', '$description', '$event_date', '$venue', '$organizer', '$max_participants', '$event_type', '$image_url', '$created_by')";
        
        if (mysqli_query($conn, $sql)) {
            $success = "Event added successfully!";
            // Clear form
            $_POST['title'] = '';
            $_POST['description'] = '';
            $_POST['event_date'] = '';
            $_POST['venue'] = '';
            $_POST['organizer'] = '';
            $_POST['max_participants'] = '100';
            $_POST['image_url'] = '';
        } else {
            $error = "Error adding event: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Event - Admin</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
        }
        .admin-container h1 {
            color: white;
            text-align: center;
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
            font-weight: bold;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 2px solid #b637c9;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 16px;
        }
        .form-group input::placeholder, .form-group textarea::placeholder {
            color: #cccccc;
        }
        .form-group textarea {
            height: 100px;
            resize: vertical;
        }
        .submit-btn {
            background: #630a75;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
        }
        .submit-btn:hover {
            background: #7a0db0;
        }
        .back-btn {
            color: #dacdcd;
            text-decoration: none;
            padding: 12px 20px;
            border: 1px solid #dacdcd;
            border-radius: 5px;
        }
        .back-btn:hover {
            background: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="admin-container">
        <h1>Add New Event</h1>
        
        <?php 
        if($error) echo "<div class='message error' style='background: rgba(255,0,0,0.3); color: #ff8c8c; padding: 10px; border-radius: 5px; margin-bottom: 20px;'>$error</div>";
        if($success) echo "<div class='message success' style='background: rgba(0,255,0,0.3); color: #a0ff9e; padding: 10px; border-radius: 5px; margin-bottom: 20px;'>$success</div>";
        ?>

        <form method="post" class="event-form">
            <div class="form-group">
                <label>Event Title *</label>
                <input type="text" name="title" value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>" placeholder="Enter event title" required>
            </div>
            
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" placeholder="Enter event description"><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Event Date and Time *</label>
                <input type="datetime-local" name="event_date" value="<?php echo isset($_POST['event_date']) ? $_POST['event_date'] : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Venue *</label>
                <input type="text" name="venue" value="<?php echo isset($_POST['venue']) ? htmlspecialchars($_POST['venue']) : ''; ?>" placeholder="Enter venue" required>
            </div>
            
            <div class="form-group">
                <label>Organizer</label>
                <input type="text" name="organizer" value="<?php echo isset($_POST['organizer']) ? htmlspecialchars($_POST['organizer']) : ''; ?>" placeholder="Enter organizer name">
            </div>
            
            <div class="form-group">
                <label>Max Participants</label>
                <input type="number" name="max_participants" value="<?php echo isset($_POST['max_participants']) ? $_POST['max_participants'] : '100'; ?>" min="1">
            </div>
            
            <div class="form-group">
                <label>Event Type</label>
                <select name="event_type">
                    <option value="workshop" <?php echo (isset($_POST['event_type']) && $_POST['event_type'] == 'workshop') ? 'selected' : ''; ?>>Workshop</option>
                    <option value="seminar" <?php echo (isset($_POST['event_type']) && $_POST['event_type'] == 'seminar') ? 'selected' : ''; ?>>Seminar</option>
                    <option value="hackathon" <?php echo (isset($_POST['event_type']) && $_POST['event_type'] == 'hackathon') ? 'selected' : ''; ?>>Hackathon</option>
                    <option value="social" <?php echo (isset($_POST['event_type']) && $_POST['event_type'] == 'social') ? 'selected' : ''; ?>>Social</option>
                    <option value="sports" <?php echo (isset($_POST['event_type']) && $_POST['event_type'] == 'sports') ? 'selected' : ''; ?>>Sports</option>
                    <option value="academic" <?php echo (isset($_POST['event_type']) && $_POST['event_type'] == 'academic') ? 'selected' : ''; ?>>Academic</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Image URL</label>
                <input type="text" name="image_url" value="<?php echo isset($_POST['image_url']) ? htmlspecialchars($_POST['image_url']) : ''; ?>" placeholder="images/event.jpg">
                <small style="color: #cccccc; font-size: 12px;">Example: images/tech_event.jpg</small>
            </div>
            
            <div style="margin-top: 30px;">
                <button type="submit" name="add_event" class="submit-btn">Add Event</button>
                <a href="manage_events.php" class="back-btn">Back to Events</a>
            </div>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>