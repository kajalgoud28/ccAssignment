<?php
session_start();

if ($_SESSION['role'] !== 'user') {
    header("Location: ../php/login.php");
    exit();
}

echo "Welcome to the User Dashboard, " . $_SESSION['username'];
?>
