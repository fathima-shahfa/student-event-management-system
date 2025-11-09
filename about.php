<?php
session_start();

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
    <body>
    <?php include 'header.php'; ?>

    <section class="about-section">
        <h1>About Us</h1>
        <p class="abt-us">
            The Student Event Management System is designed to simplify event coordination within the university —
            from tech workshops to cultural nights — making it easy for students to explore, register, and manage
            campus activities in one place.
        </p>

        <h2>Mission</h2>
        <p class="mission">
            To connect students, organizers, and clubs through a digital platform that promotes
            participation and collaboration.
        </p>

        <h2>Vision</h2>
        <p class="vision">
            To build a vibrant and interactive student community powered by technology.
        </p>

        <a href="mailto:info@eventhub.com?subject=Event Inquiry&body=Hello, I’d like to know more about your events." class="email-link">
    Contact Us
</a>

    </section>

    <?php include 'footer.php'; ?>
</body>

</body>
</html>