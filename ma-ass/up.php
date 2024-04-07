<?php

// Including the configuration file
include('config.php');

// Checking if the form is submitted for updating product details
if(isset($_POST['update'])){
    // Retrieving data from the form
    $ID = $_POST['id'];
    $NAME  = $_POST['name'];
    $PRICE = $_POST['price'];
    $IMAGE = $_FILES['image'];
    
    // Getting temporary location and name of the uploaded image
    $image_location = $_FILES['image']['tmp_name'];
    $image_name = $_FILES['image']['name'];
    
    // Moving the uploaded image to the desired directory
    move_uploaded_file($image_location,'images/'.$image_name);
    
    // Generating the image path for database storage
    $image_up = "images/".$image_name;
    
    // Updating the product details in the database
    $update = "UPDATE products SET name='$NAME' , price='$PRICE', image='$image_up' WHERE id=$ID";
    mysqli_query($con, $update);

    // Redirecting back to the index.php page after updating
    header('location: index.php');
}
?>
