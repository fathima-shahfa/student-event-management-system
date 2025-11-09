<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


echo "<!-- Debug: User ID: " . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'NOT SET') . " -->";
echo "<!-- Debug: Username: " . (isset($_SESSION['username']) ? $_SESSION['username'] : 'NOT SET') . " -->";
echo "<!-- Debug: User Type: " . (isset($_SESSION['user_type']) ? $_SESSION['user_type'] : 'NOT SET') . " -->";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventura</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital@0;1&family=Poppins&display=swap"
        rel="stylesheet">
</head>

<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <h2>Eventura</h2>
                </div>
                <div class="header-clock"><span id="clock"></span>
                </div>
                <nav>
                    <?php
                    $current_page = basename($_SERVER['PHP_SELF']);
                    ?>

                    <nav class="navbar">
                        <ul>
                            <li><a href="index.php"
                                    class="<?= ($current_page == 'index.php') ? 'active' : '' ?>">Home</a></li>
                            <li><a href="events.php"
                                    class="<?= ($current_page == 'events.php') ? 'active' : '' ?>">Events</a></li>
                            <li><a href="about.php"
                                    class="<?= ($current_page == 'about.php') ? 'active' : '' ?>">About</a></li>
                            <li>
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    
                                    <a href="dashboard.php"
                                        class="<?= ($current_page == 'dashboard.php') ? 'active' : '' ?>">Dashboard</a>
                                <?php endif; ?>
                            </li>
                            
                            <li>
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    
                                    <a href="logout.php" class="logout-btn"
                                        onclick="return confirm('Are you sure you want to logout?')">Logout</a>
                                <?php else: ?>
                                    
                                    <a href="login.php"
                                        class="<?= ($current_page == 'login.php') ? 'active' : '' ?>">Login</a>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </nav>

                </nav>

            </div>

        </div>

    </header>
</body>

</html>
<script>
    function updateClock() {
        const now = new Date();
        const options = {
            weekday: 'short', year: 'numeric', month: 'short',
            day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit'
        };
        document.getElementById('clock').textContent = now.toLocaleString('en-US', options);
    }

    setInterval(updateClock, 1000);
    updateClock(); 
</script>
