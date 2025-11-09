<?php
session_start();
include 'includes/db.inc.php';

$error = '';
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (!empty($username) && !empty($password)) {
        
        $sql = "SELECT * FROM users WHERE name = '$username' OR email = '$username'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['name'];
                $_SESSION['user_type'] = $user['user_type'];
                $_SESSION['student_id'] = $user['student_id'];
                
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Incorrect password!";
            }
        } else {
            $error = "Username or email not found!";
        }
    } else {
        $error = "Please fill in all fields!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="login-container">
    <form class="login-form" method="post" action="">
        <h2>Login</h2>
        <?php if($error) echo "<div class='error-message'>$error</div>"; ?>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" name="login" value="Login">
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
