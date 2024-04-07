<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process sign-up form
    require_once 'db.php'; // Include database connection code
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    // Validate input
    if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($confirmPassword)) {
        echo "All fields are required";
    } elseif ($password !== $confirmPassword) {
        echo "Passwords do not match";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the user into the database
        $stmt = $pdo->prepare("INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$firstname, $lastname, $email, $hashedPassword]);

        echo "User registered successfully. Please <a href='signin.php'>Sign In</a>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
</head>
<body>
<div class="login-box" id="signin">
    <h1>Sign Up</h1>
    <form action="" method="post">
        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" required><br><br>
        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required><br><br>
        <input type="submit" value="Sign Up">
    </form>
    <p>Already have an account? <a href="signin.php">Sign In</a></p>
    </div>
</body>
<style>
body {
     display: flex;
      justify-content: center; 
      align-items: center; 
      height: 100vh; 
      background-image: linear-gradient(to left, black 0%, rgb(1, 34, 48) 51%, black 100%);
}
.login-box {
     background-color: #282c34; /* Obsidian color */ 
     padding: 55px; border-radius: 100px; 
     color: white; 
     width: 300px; 
     //box-shadow: inset 5px 5px 20px 20px #000000a8; 
    
} 
     
.login-box h2 { 
    text-align: center; 
} 

.login-box label {
     display: block;
      margin-bottom: 5px; 
} 
.login-box input[type="email"], .login-box input[type="password"], .login-box input[type="text"],
.login-box input[type="submit"] {
     width: 95%;
      padding: 10px;
       margin-bottom: 5px;
        border: none;
         border-radius: 5px; 
} 

</style>

</html>
