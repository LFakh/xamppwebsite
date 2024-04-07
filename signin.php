<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process sign-in form
    require_once 'db.php'; // Include database connection code
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate input
    if (empty($email) || empty($password)) {
        echo "Email and password are required";
    } else {
        // Query the database to check if the user exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Update sign-in time for the user
            $stmt = $pdo->prepare('UPDATE users SET signin_time = NOW() WHERE id = ?');
            $stmt->execute([$user['id']]);

            $_SESSION['user'] = $user; // Change the session variable to 'user'
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Invalid email or password";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign In</title>
</head>
<body>
<div class="login-box" id="signin">
    <h1>Sign In</h1>
    <form action="" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Sign In">
    </form>
    <p>New user? <a href="signup.php">Sign Up</a></p>
    </div>
    <style>
body {
     display: flex;
      justify-content: center; 
      align-items: center; 
      height: 100vh; 
      background-color: gray; 
}
.login-box {
     background-color: #282c34; /* Obsidian color */ 
     padding: 25px; border-radius: 10px; 
     color: white; 
     width: 300px; 
     box-shadow: inset 5px 5px 20px 20px #000000a8; 
    background-image: linear-gradient(to left, black 0%, rgb(1, 34, 48) 51%, black 100%);
} 
     
.login-box h2 { 
    text-align: center; 
} 

.login-box label {
     display: block;
      margin-bottom: 5px; 
} 
.login-box input[type="email"], .login-box input[type="password"],
.login-box input[type="submit"] {
     width: 95%;
      padding: 10px;
       margin-bottom: 10px;
        border: none;
         border-radius: 5px; 
} 

</style>

</body>
</html>
