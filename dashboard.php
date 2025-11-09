<?php
session_start();
include 'includes/db.inc.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Student Event Management</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .dashboard-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        .dashboard-header {
            text-align: center;
            margin-bottom: 30px;
            color: white;
        }
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .dashboard-card {
            background: rgba(116, 67, 149, 0.8);
            padding: 25px;
            border-radius: 10px;
            color: white;
            text-align: center;
        }
        .dashboard-card.admin {
            background: rgba(149, 67, 134, 0.8);
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #630a75;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px;
        }
        .btn:hover {
            background: #7a0db0;
        }
        .my-events {
            background: rgba(113, 67, 149, 0.8);
            padding: 25px;
            border-radius: 10px;
            color: white;
        }
        .event-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .no-events {
            text-align: center;
            font-style: italic;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <p>User Type: <?php echo isset($_SESSION['user_type']) ? ucfirst($_SESSION['user_type']) : 'Student'; ?></p>
        </div>

        <div class="dashboard-grid">
            <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin'): ?>
            <div class="dashboard-card admin">
                <h3>Admin Panel</h3>
                <p>Manage events and view analytics</p>
                <a href="manage_events.php" class="btn">Manage Events</a>
            </div>
            <?php endif; ?>

            
            <div class="dashboard-card">
                <h3>Upcoming Events</h3>
                <?php
                $upcoming_sql = "SELECT COUNT(*) as count FROM events WHERE event_date > NOW()";
                $upcoming_result = $conn->query($upcoming_sql);
                $upcoming_count = $upcoming_result->fetch_assoc()['count'];
                ?>
                <p>There are <?php echo $upcoming_count; ?> upcoming events</p>
                <a href="events.php" class="btn">View All Events</a>
            </div>
        </div>
        
        <section class="my-events">
            <h2>My Registered Events</h2>
            <?php
            $events_sql = "SELECT e.*, r.registration_date 
                          FROM events e 
                          JOIN registrations r ON e.event_id = r.event_id 
                          WHERE r.user_id = ? 
                          ORDER BY e.event_date DESC";
            $stmt = $conn->prepare($events_sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $registered_events = $stmt->get_result();
            
            if ($registered_events->num_rows == 0): ?>
                <p class="no-events">You haven't registered for any events yet.</p>
            <?php else: ?>
                <div class="events-list">
                    <?php while($event = $registered_events->fetch_assoc()): ?>
                    <div class="event-item">
                        <div class="event-info">
                            <h4><?php echo htmlspecialchars($event['title']); ?></h4>
                            <p class="event-meta">
                                <?php echo date('M j, Y g:i A', strtotime($event['event_date'])); ?> | 
                                <?php echo htmlspecialchars($event['venue']); ?>
                            </p>
                            <p class="registration-date">
                                Registered on: <?php echo date('M j, Y', strtotime($event['registration_date'])); ?>
                            </p>
                        </div>
                        <div class="event-actions">
                            <a href="event-details.php?id=<?php echo $event['event_id']; ?>" class="btn">View Details</a>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </section>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>