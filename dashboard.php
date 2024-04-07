<?php
session_start();
require_once 'db.php';
if (!isset($_SESSION['user'])) {
    header("Location: signin.php");
    exit();
}

$user = $_SESSION['user'];

if ($user['role'] === 'admin') {
    header("Location: fetch.php");
    exit();
} else {
    header("Location: hi.php"); // Redirect normal users to hi.php
    exit();
}
?>
