<?php
session_start();
include 'includes/db.inc.php';
include 'header.php';

if (isset($_GET['id'])) {
    $event_id = intval($_GET['id']);

    $sql = "SELECT e.*, ed.description, ed.objectives, ed.highlights, ed.schedule, ed.speakers
            FROM events e
            LEFT JOIN event_details ed ON e.event_id = ed.event_id
            WHERE e.event_id = $event_id";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $event = mysqli_fetch_assoc($result);
    } else {
        echo "Event not found!";
        exit;
    }
} else {
    echo "No event selected!";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo $event['title']; ?> - Event Details</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="event-container">
        <h1><?php echo $event['title']; ?></h1>
        <img src="<?php echo $event['image_url']; ?>" alt="<?php echo $event['title']; ?>" class="event-image">

        <div class="section">
            <h3>Description:</h3>
            <p><?php echo $event['description']; ?></p>
        </div>

        <div class="section">
            <h3>Objectives:</h3>
            <p><?php echo $event['objectives']; ?></p>
        </div>

        <div class="section">
            <h3>Highlights:</h3>
            <p><?php echo $event['highlights']; ?></p>
        </div>

        <div class="section schedule">
            <h3>Schedule:</h3>
            <pre><?php echo $event['schedule']; ?></pre>
        </div>

        <div class="section">
            <h3>Speakers / Mentors:</h3>
            <p><?php echo $event['speakers']; ?></p>
        </div>

        <div class="section">
            <h3>Event Info:</h3>
            <p><strong>Date:</strong> <?php echo date('F j, Y g:i A', strtotime($event['event_date'])); ?></p>
            <p><strong>Venue:</strong> <?php echo $event['venue']; ?></p>
            <p><strong>Organizer:</strong> <?php echo $event['organizer']; ?></p>
            <p><strong>Max Participants:</strong> <?php echo $event['max_participants']; ?></p>
            <p><strong>Type:</strong> <?php echo ucfirst($event['event_type']); ?></p>
        </div>
        
<?php 
if (isset($_SESSION['registration_message'])) {
    $message = $_SESSION['registration_message'];
    $type = $_SESSION['message_type'];
    echo "<div class='message $type'>$message</div>";
    
    
    unset($_SESSION['registration_message']);
    unset($_SESSION['message_type']);
}
?>
        
        <div class="register">
            <?php if (isset($_SESSION['user_id'])): ?>
                
                <form method="post" action="event_register.php">
                    <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                    <a href="event_register.php">
<button type="submit" name="register_event">Register </button>
                    </a>
                    
            
                </form>
            <?php else: ?>
                
                <a href="login.php?redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">
                    <button>Login to Register</button>
                </a>
            <?php endif; ?>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
</body>
</html>