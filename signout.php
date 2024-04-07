<?php
session_start();

// Check if the user is signed in
if (isset($_SESSION['user'])) {
    // Include database connection code
    require_once 'db.php';

    // Get the user's ID
    $user_id = $_SESSION['user']['id'];

    // Update sign-out time when user signs out
    $stmt = $pdo->prepare('UPDATE users SET signout_time = NOW() WHERE id = ?');
    $stmt->execute([$user_id]);
}

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the main page
header("Location: index.html");
exit();
?>
