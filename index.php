<?php
session_start();
include 'includes/db.inc.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    include 'header.php';
    ?>
    <div class="search-box">
        <form action="search.php" method="get">
            <input type="text" name="q" placeholder="Search here..." class="search-input">
            <input type="submit" name="submit"  class="search-submit">
        </form>
    </div>
    <div class="event-grid">
    </div>
    
    <div class="welcome-page">
        <div class="title">
            <h1>Welcome to the Student Event Hub!</h1>
            <div id="typing-text" class="typing-container"></div>
            <span class="typing-cursor"></span>
            <a href="events.php" class="welcome-event-btn">View Events</a>
        </div>
    </div>
    <div class="upcoming-events">
        <h2>Upcoming Events</h2>
        <div class="event-grid">
            <?php
            $sql = "SELECT * FROM events WHERE event_date > NOW() ORDER BY event_date ASC LIMIT 4;";
            $event = mysqli_query($conn, $sql);
            $eventcheck = mysqli_num_rows($event);
            if ($eventcheck > 0) {
                while ($row = mysqli_fetch_assoc($event)) {
                    echo "
                       <div class='event-card'>
                            <img src='{$row['image_url']}' alt='{$row['title']}' class='event-image'>
                            <div class='event-info'>
                                <h3>{$row['title']}</h3>
                                <p class='event-type'><strong></strong> {$row['event_type']}</p>
                                <p><strong>Date:</strong> " . date('F j, Y g:i A', strtotime($row['event_date'])) . "</p>
                                <p><strong>Venue:</strong> {$row['venue']}</p>
                                <p><strong>Organizer:</strong> {$row['organizer']}</p>
                                <a href='event-details.php?id={$row['event_id']}' class='view-btn'>View Details</a>
                            </div>
                        </div>
                    ";
                }
            }
            ?>
        </div>
    </div>

    <?php
    include 'footer.php';
    ?>
    <script src="script.js"></script>
</body>

</html>