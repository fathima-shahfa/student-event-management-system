<?php
session_start();
include 'includes/db.inc.php';
include 'header.php';
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
    <div class="events-page">
    <h1 class="events-page">All Events</h1>
    <div class="event-grid">
        <?php
        $sql = "SELECT * FROM events ORDER BY event_date DESC;";
        $result = mysqli_query($conn, $sql);
        $eventCount = mysqli_num_rows($result);

        if ($eventCount > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "
                <div class='event-card'>
                    <img src='{$row['image_url']}' alt='{$row['title']}' class='event-image'>
                    <div class='event-info'>
                        <h3>{$row['title']}</h3>
                        <p><strong></strong> {$row['event_type']}</p>
                        <p><strong>Date:</strong> " . date('F j, Y g:i A', strtotime($row['event_date'])) . "</p>
                        <p><strong>Venue:</strong> {$row['venue']}</p>
                        <p><strong>Organizer:</strong> {$row['organizer']}</p>
                        <a href='event-details.php?id={$row['event_id']}' class='view-btn'>View Details</a>
                    </div>
                </div>
                ";
            }
        } else {
            echo "<p class='no-events'>No events found.</p>";
        }
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>

