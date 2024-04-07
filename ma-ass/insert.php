<?php

// Including the configuration file
include('config.php');

// Checking if the form is submitted
if(isset($_POST['upload'])){
    // Retrieving form data
    $NAME  = $_POST['name'];
    $PRICE = $_POST['price'];
    $IMAGE = $_FILES['image'];

    // Getting the temporary location of the uploaded image
    $image_location = $_FILES['image']['tmp_name'];

    // Getting the name of the uploaded image
    $image_name = $_FILES['image']['name'];

    // Moving the uploaded image to the desired location
    move_uploaded_file($image_location,'images/'. $image_name);

    // Setting the path for the uploaded image
    $image_up = "images/".$image_name;

    // Inserting product details into the database
    $insert = "INSERT INTO  products (name, price ,image) VALUES ('$NAME','$PRICE','$image_up')";
    mysqli_query($con, $insert);

    // Redirecting to the index.php page after successful insertion
    header('location: index.php');
}

?>
