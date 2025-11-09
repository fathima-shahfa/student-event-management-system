<?php
session_start();

function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location:auth.php?redirect=" . urlencode($_SERVER['REQUEST_URI']));
        exit();
    }
}

function isAdmin() {
    return isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin';
}

function isStudent() {
    return isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'student';
}
?>