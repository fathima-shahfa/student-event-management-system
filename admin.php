<?php
include 'includes/db.inc.php';


$name = "Admin User";
$email = "admin@example.com";
$password = "admin123"; 
$student_id = "ADM001";
$contact_number = "0771234567";
$user_type = "admin";


$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (name, email, password, student_id, contact_number, user_type) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $name, $email, $hashedPassword, $student_id, $contact_number, $user_type);

if($stmt->execute()) {
    echo "Admin user created successfully!<br>";
    echo "Email: admin@example.com<br>";
    echo "Password: admin123<br>";
    echo "Username: Admin User<br>";
} else {
    echo "Error creating admin user: " . $conn->error;
}
?>