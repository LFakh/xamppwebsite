<?php

// Including the configuration file
include 'config.php';

// Starting the session
session_start();

// Checking if the login form is submitted
if(isset($_POST['submit'])){
   
   // Sanitizing and retrieving form data
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   // Querying the database to check user credentials
   $select = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   // If user exists, set session and redirect to index.php
   if(mysqli_num_rows($select) > 0){
      $row = mysqli_fetch_assoc($select);
      $_SESSION['user_id'] = $row['id'];
      header('location:index.php');
   }else{
      // If user doesn't exist, display error message
      $message[] = 'Mot de passe ou e-mail incorrect !';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/style.css">
   <style>
      /* Additional style for input alignment */
      input{
         text-align: center;
      }
   </style>
</head>
<body>

<?php
// Displaying error message if exists
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
   }
}
?>
   
<div class="form-container">

   <form action="" method="post">
      <h3>Se connecter</h3>
      <input type="email" name="email" required placeholder="Email" class="box">
      <input type="password" name="password" required placeholder="Mot de passe" class="box">
      <input type="submit" name="submit" class="btn" value="Se connecter">
      <p>Vous n'avez pas encore de compte ? <a href="register.php">Nouveau compte</a></p>
   </form>

</div>

</body>
</html>
