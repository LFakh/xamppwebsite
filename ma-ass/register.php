<?php

// Including the configuration file
include 'config.php';

// Checking if the form is submitted
if(isset($_POST['submit'])){

   // Escaping and sanitizing form inputs
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));

   // Query to check if the user already exists
   $select = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   // If user already exists, display message
   if(mysqli_num_rows($select) > 0){
      $message[] = 'user already exist!';
   }else{
      // If user doesn't exist, insert into database
      mysqli_query($conn, "INSERT INTO `users`(name, email, password) VALUES('$name', '$email', '$pass')") or die('query failed');
      $message[] = 'registered successfully!';
      // Redirecting to login page after successful registration
      header('location:login.php');
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <!-- Inline CSS -->
   <style>
      input{
         text-align: center; /* Centering text in input fields */
      }
   </style>
</head>
<body>

<?php
// Displaying messages if any
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
   }
}
?>
   
<div class="form-container">

   <form action="" method="post">
      <h3> Create an account </h3>
      <!-- Input fields for user registration -->
      <input type="text" name="name" required placeholder="username" class="box">
      <input type="email" name="email" required placeholder="Email " class="box">
      <input type="password" name="password" required placeholder="password" class="box">
      <input type="password" name="cpassword" required placeholder="Confirm password" class="box">
      <input type="submit" name="submit" class="btn" value="Créer un compte">
      <!-- Link to login page -->
      <p>No account yet?<a href="login.php"> Connect </a></p>
   </form>

</div>

</body>
</html>
