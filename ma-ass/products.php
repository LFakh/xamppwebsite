<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Linking Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Linking Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri&family=Cairo:wght@200&family=Poppins:wght@100;200;300&family=Tajawal:wght@300&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits</title>
    <!-- Custom CSS -->
    <style>
        /* Styling for heading */
        h3{
            font-family: 'Cairo', sans-serif;
            font-weight: bold;
        }
        /* Styling for cards */
        .card{
            float: right; /* Aligning cards to the right */
            margin-top: 20px;
            margin-left: 10px;
            margin-right: 10px;
        }
        /* Styling for card images */
        .card img{
            width: 100%;
            height: 200px;
        }
        /* Setting width for main content area */
        main{
            width: 60%;
        }
    </style>
</head>
<body>
    <center>
        <h3>Admin configuration Panel</h3>
    </center>
    <?php
    // Including the configuration file
    include('config.php');
    // Fetching products from database
    $result = mysqli_query($con, "SELECT * FROM products");
    // Looping through each product
    while($row = mysqli_fetch_array($result)){
        echo "
        <center>
        <main>
            <div class='card' style='width: 15rem;'>
                <img src='$row[image]' class='card-img-top'>
                <div class='card-body'>
                    <h5 class='card-title'>$row[name]</h5>
                    <p class='card-text'>$row[price]</p>
                    <!-- Link to delete product with product ID -->
                    <a href='delete.php?id=$row[id]' class='btn btn-danger'>Delete the product</a>
                    <!-- Link to update product with product ID -->
                    <a href='update.php?id=$row[id]' class='btn btn-primary'>Modify the product</a>
                </div>
            </div>
        </main>
        <center>
        ";
    }
    ?>
</body>
</html>
