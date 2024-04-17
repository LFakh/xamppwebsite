<?php
session_start();

// Retrieve user data from session
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="5;url=signout.php"> <!-- Redirect to signout.php after 5 seconds -->
    <title>Processing Purchase</title>
</head>
<style>
.a{display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;}
</style>
<body>
	<div class='a'>
    <h1>Processing Purchase...</h1>
    <p>Please wait while your purchase is being processed.</p>
    <p>If you are not redirected in 5 seconds, <a href="signout.php">click here</a>.</p>
    <div>
</body>
</html>
