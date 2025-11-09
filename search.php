<?php
include 'includes/db.inc.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <style>
        .empty-empty {
            color: white;
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
            background-color: rgba(233, 8, 139, 0.44);
            padding: 15px;
            border-radius: 10px;
        }
        .search-page-container {
            display: flex;
            flex-direction: column;
            min-height: calc(100vh - 160px);
        }
        .search-results {
             flex: 1;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="search-page-container">
        <div class="search-results">
            <?php
            if (isset($_GET['q']) && !empty($_GET['q'])) {
                $search = mysqli_real_escape_string($conn, $_GET['q']);
                $sql = "SELECT * FROM events 
                WHERE title LIKE '%$search%' 
                OR description LIKE '%$search%' 
                OR organizer LIKE '%$search%' 
                ORDER BY event_date ASC";
                $result = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($result);

                if ($count > 0) {
                    echo "<div class='event-grid'>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "
                <div class='event-card search-card'>
                    <img src='{$row['image_url']}' alt='{$row['title']}' class='event-image'>
                    <div class='event-info'>
                        <h3>{$row['title']}</h3>
                        <p class='event-type'><strong>Type:</strong> {$row['event_type']}</p>
                        <p><strong>Date:</strong> " . date('F j, Y g:i A', strtotime($row['event_date'])) . "</p>
                        <p><strong>Venue:</strong> {$row['venue']}</p>
                        <p><strong>Organizer:</strong> {$row['organizer']}</p>
                        <a href='event-details.php?id={$row['event_id']}' class='view-btn'>View Details</a>
                    </div>
                </div>
                ";
                    }
                } else {
                    echo "<div class='empty-empty'>
                        <p>No events found for '<strong>$search</strong>'.</p>
                    </div>";
                }

            } else {
                echo "<div class='empty-empty'>
                        <p>Please enter a search term.</p>
                    </div>";
            }
            ?>
        </div>
    </div>

        <?php include 'footer.php'; ?>
</body>

</html>