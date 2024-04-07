<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Including Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri&family=Cairo:wght@200&family=Poppins:wght@100;200;300&family=Tajawal:wght@300&display=swap" rel="stylesheet">
    
    <!-- Meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Title of the page -->
    <title>modifier le produit</title>
    
    <!-- Linking external CSS file -->
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <?php
    // Including the configuration file
    include('config.php');
    
    // Getting the product ID from the URL parameter
    $ID=$_GET['id'];
    
    // Fetching product details from the database based on the ID
    $up = mysqli_query($con, "select * from products where id =$ID");
    $data = mysqli_fetch_array($up);
    ?>
    
    <center>
        <div class="main">
            <!-- Form for updating product details -->
            <form action="up.php" method="post" enctype="multipart/form-data">
                <h2>modifications des produits</h2>
                
                <!-- Hidden input field for passing the product ID -->
                <input type="text" name='id' value='<?php echo $data['id']?>'  style='display:none;'>
                
                <!-- Input field for updating product name -->
                <input type="text" name='name' value='<?php echo $data['name']?>'>
                
                <!-- Input field for updating product price -->
                <input type="text" name='price' value='<?php echo $data['price']?>'>
                
                <!-- File input for updating product image -->
                <input type="file" id="file" name='image' style='display:none;'>
                <label for="file"> Mettre à jour l'image du produit</label>
                
                <!-- Button to submit the form for updating product -->
                <button name='update' type='submit'>modifier le produit</button>
                <br><br>
                
                <!-- Link to view all products -->
                <a href="products.php">afficher tout les produits</a>
            </form>
        </div>
        <!-- Developer's information -->
        <p>Developer By Ma-ASs</p>
    </center>
</body>
</html>
