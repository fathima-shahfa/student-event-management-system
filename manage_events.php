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


if (isset($_GET['delete_id'])) {
    $event_id = (int)$_GET['delete_id'];
    
    
    $delete_reg_sql = "DELETE FROM registrations WHERE event_id = ?";
    $stmt = $conn->prepare($delete_reg_sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    
    
    $delete_event_sql = "DELETE FROM events WHERE event_id = ?";
    $stmt = $conn->prepare($delete_event_sql);
    $stmt->bind_param("i", $event_id);
    
    if ($stmt->execute()) {
        $success = "Event deleted successfully!";
    } else {
        $error = "Error deleting event: " . $conn->error;
    }
}


$events_sql = "SELECT * FROM events ORDER BY event_date DESC";
$events_result = $conn->query($events_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events - Admin</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            color: white;
        }
        .events-table {
            width: 100%;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
            border-collapse: collapse;
        }
        .events-table th, .events-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }
        .events-table th {
            background: rgba(113, 67, 149, 0.8);
            color: #ffccff;
        }
        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 2px;
            font-size: 14px;
        }
        .btn-edit {
            background: #4CAF50;
            color: white;
        }
        .btn-delete {
            background: #f44336;
            color: white;
        }
        .btn-add {
            background: #2196F3;
            color: white;
            padding: 10px 20px;
        }
        .btn-back {
            background: #666;
            color: white;
            padding: 10px 20px;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="admin-container">
        <div class="admin-header">
            <h1>Manage Events</h1>
            <div>
                <a href="add_event.php" class="btn btn-add">Add New Event</a>
                <a href="dashboard.php" class="btn btn-back">Back to Dashboard</a>
            </div>
        </div>

        <?php 
        if(isset($success)) echo "<div class='message success'>$success</div>";
        if(isset($error)) echo "<div class='message error'>$error</div>";
        ?>

        <table class="events-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Venue</th>
                    <th>Type</th>
                    <th>Max Participants</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($events_result->num_rows == 0): ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">No events found.</td>
                    </tr>
                <?php else: ?>
                    <?php while($event = $events_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($event['title']); ?></td>
                        <td><?php echo date('M j, Y g:i A', strtotime($event['event_date'])); ?></td>
                        <td><?php echo htmlspecialchars($event['venue']); ?></td>
                        <td><?php echo ucfirst($event['event_type']); ?></td>
                        <td><?php echo $event['max_participants']; ?></td>
                        <td>
                            <a href="edit_events.php?id=<?php echo $event['event_id']; ?>" class="btn btn-edit">Edit</a>
                            <a href="?delete_id=<?php echo $event['event_id']; ?>" class="btn btn-delete" 
                               onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>