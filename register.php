<?php
session_start();
include 'includes/db.inc.php';

$error = '';
$success = '';

if(isset($_POST['register'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $user_type = 'student';

    if(empty($name) || empty($email) || empty($student_id) || empty($password) || empty($confirm_password)){
        $error = "All fields are required!";
    } elseif($password !== $confirm_password){
        $error = "Passwords do not match!";
    } else {
        
        $check = "SELECT * FROM users WHERE email='$email' OR student_id='$student_id'";
        $res = mysqli_query($conn, $check);
        if(mysqli_num_rows($res) > 0){
            $error = "Email or Student ID already exists!";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (name, email, student_id, contact_number, password, user_type) 
                    VALUES ('$name', '$email', '$student_id', '$contact_number', '$hashedPassword', '$user_type')";
            if(mysqli_query($conn, $sql)){
                $success = "Registration successful! You can <a href='login.php'>login</a> now.";
            } else {
                $error = "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>
<link rel="stylesheet" href="style.css">
<style>
    .validation-message {
        font-size: 0.9rem;
        margin-top: 5px;
        padding: 5px;
        border-radius: 5px;
    }
    .valid {
        color: #00ff80;
        background: rgba(0, 255, 128, 0.1);
    }
    .invalid {
        color: #ff6b6b;
        background: rgba(255, 0, 0, 0.1);
    }
    .loading {
        color: #ffd700;
    }
</style>
</head>
<body>
<?php include 'header.php'; ?>

<div class="register-container">
    <form class="register-form" method="post" action="" id="registerForm">
        <h2>Register</h2>
        <?php 
        if($error) echo "<div class='error-message'>$error</div>"; 
        if($success) echo "<div class='success-message'>$success</div>"; 
        ?>
        
        <input type="text" name="name" placeholder="Full Name" required id="name">
        <div id="name-message" class="validation-message"></div>

        <input type="email" name="email" placeholder="Email" required id="email">
        <div id="email-message" class="validation-message"></div>

        <input type="text" name="student_id" placeholder="Student ID" required id="student_id">
        <div id="student-id-message" class="validation-message"></div>

        <input type="text" name="contact_number" placeholder="Contact Number" id="contact_number">
        <div id="contact-message" class="validation-message"></div>
        
        <input type="password" name="password" placeholder="Password" required id="password">
        <div id="password-message" class="validation-message"></div>

        <input type="password" name="confirm_password" placeholder="Confirm Password" required id="confirm_password">
        <div id="confirm-password-message" class="validation-message"></div>

        <input type="submit" name="register" value="Register" id="submitBtn">
        <p>Already have an account? <a href="login.php">Login</a></p>
    </form>
</div>

<?php include 'footer.php'; ?>

<script>

document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email');
    const studentIdInput = document.getElementById('student_id');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm_password');

    
    emailInput.addEventListener('blur', validateEmail);

    
    studentIdInput.addEventListener('blur', validateStudentId);

    
    passwordInput.addEventListener('input', validatePassword);
    confirmPasswordInput.addEventListener('input', validateConfirmPassword);

    function validateEmail() {
        const email = emailInput.value.trim();
        
        if (!email) {
            showValidation('email', 'Email is required', 'invalid');
            return;
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            showValidation('email', 'Please enter a valid email address', 'invalid');
            return;
        }

        showValidation('email', 'Checking email availability...', 'loading');
        
        fetch('check_email.php?email=' + encodeURIComponent(email))
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    showValidation('email', 'Email already registered', 'invalid');
                } else {
                    showValidation('email', 'Email is available', 'valid');
                }
            })
            .catch(error => {
                showValidation('email', 'Error checking email', 'invalid');
            });
    }

    function validateStudentId() {
        const studentId = studentIdInput.value.trim();
        
        if (!studentId) {
            showValidation('student_id', 'Student ID is required', 'invalid');
            return;
        }

        showValidation('student_id', 'Checking Student ID...', 'loading');
        
        fetch('check_student_id.php?student_id=' + encodeURIComponent(studentId))
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    showValidation('student_id', 'Student ID already registered', 'invalid');
                } else {
                    showValidation('student_id', 'Student ID is available', 'valid');
                }
            })
            .catch(error => {
                showValidation('student_id', 'Error checking Student ID', 'invalid');
            });
    }

    function validatePassword() {
        const password = passwordInput.value;
        
        if (!password) {
            showValidation('password', 'Password is required', 'invalid');
        } else if (password.length < 6) {
            showValidation('password', 'Password must be at least 6 characters', 'invalid');
        } else {
            showValidation('password', 'Password is strong', 'valid');
        }
        
        validateConfirmPassword();
    }

    function validateConfirmPassword() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        
        if (!confirmPassword) {
            showValidation('confirm_password', 'Please confirm your password', 'invalid');
        } else if (password !== confirmPassword) {
            showValidation('confirm_password', 'Passwords do not match', 'invalid');
        } else {
            showValidation('confirm_password', 'Passwords match', 'valid');
        }
    }

    function showValidation(field, message, type) {
        const messageElement = document.getElementById(field + '-message');
        messageElement.textContent = message;
        messageElement.className = 'validation-message ' + type;
    }
});
</script>
</body>
</html>