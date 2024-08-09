<?php
// session_check.php
session_start();
$username=$_SESSION["username"]; 
$role=$_SESSION["role"];
// Check if user is logged in
if (!isset($_SESSION['id'])) {
    // Redirect to login page if not logged in
    header("Location: ../login.php");
    exit();
}

// Check if user is an admin
if ($_SESSION['role'] != 'admin') {
    // Redirect to unauthorized access page or home page
    header("Location: ../home.php");
    exit();
}
?>
