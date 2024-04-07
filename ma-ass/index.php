<?php

// Including the configuration file
include 'config.php';

// Starting the session
session_start();

// Getting the user ID from the session
$user_id = $_SESSION['user_id'];

// Redirecting to login page if user is not logged in
if(!isset($user_id)){
   header('location:login.php');
};

// Logging out user
if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:login.php');
};

// Adding product to cart
if(isset($_POST['add_to_cart'])){
   // Retrieving product details from form
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   // Checking if product already exists in cart
   $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($select_cart) > 0){
      $message[] = 'Le produit a déjà été ajouté au panier !';
   }else{
      // Adding product to cart
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, image, quantity) VALUES('$user_id', '$product_name', '$product_price', '$product_image', '$product_quantity')") or die('query failed');
      $message[] = 'Le produit est ajouté au panier !';
   }
};

// Updating cart
if(isset($_POST['update_cart'])){
   $update_quantity = $_POST['cart_quantity'];
   $update_id = $_POST['cart_id'];
   // Updating product quantity in cart
   mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_quantity' WHERE id = '$update_id'") or die('query failed');
   $message[] = 'La quantité du panier a été mise à jour avec succès !';
}

// Removing product from cart
if(isset($_GET['remove'])){
   $remove_id = $_GET['remove'];
   // Deleting product from cart
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'") or die('query failed');
   header('location:index.php');
}
  
// Deleting all products from cart
if(isset($_GET['delete_all'])){
   // Deleting all products from cart for a specific user
   mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   header('location:index.php');
}

?>

<!-- HTML document starts here -->
<!DOCTYPE html>
<html lang="en">
<head>
   <!-- Meta tags -->
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>panier</title>

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php
// Displaying messages
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
   }
}
?>

<!-- Main container starts -->
<div class="container">

<!-- User profile section -->
<div class="user-profile">

   <?php
      // Fetching user details
      $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select_user) > 0){
         $fetch_user = mysqli_fetch_assoc($select_user);
      };
   ?>

   <!-- Displaying user name -->
   <p>المستخدم الحالي : <span><?php echo $fetch_user['name']; ?></span> </p>
   <!-- Logout button -->
   <div class="flex">
      <a href="index.php?logout=<?php echo $user_id; ?>" onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter?');" class="delete-btn">تسجيل الخروج</a>
   </div>

</div>

<!-- Products section -->
<div class="products">

   <h1 class="heading">Derniers produits</h1>

   <div class="box-container">

   <?php
   // Fetching and displaying product information
   include('config.php');
   $result = mysqli_query($conn, "SELECT * FROM products");      
   while($row = mysqli_fetch_array($result)){
   ?>
      <form method="post" class="box" action="">
         <!-- Displaying product image -->
         <img src="admin/<?php echo $row['image']; ?>"  width="200">
         <!-- Displaying product name -->
         <div class="name"><?php echo $row['name']; ?></div>
         <!-- Displaying product price -->
         <div class="price"><?php echo $row['price']; ?></div>
         <!-- Form inputs for adding product to cart -->
         <input type="number" min="1" name="product_quantity" value="1">
         <input type="hidden" name="product_image" value="<?php echo $row['image']; ?>">
         <input type="hidden" name="product_name" value="<?php echo $row['name']; ?>">
         <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
         <input type="submit" value="add to cart" name="add_to_cart" class="btn">
      </form>
   <?php
      };
   ?>

   </div>

</div>

<!-- Shopping cart section -->
<div class="shopping-cart">

   <h1 class="heading">panier</h1>

   <!-- Cart table -->
   <table>
      <thead>
         <th>image</th>
         <th>nom</th>
         <th>prix</th>
         <th>nombre</th>
         <th>prix total</th>
         <th></th>
      </thead>
      <tbody>
      <?php
         // Fetching and displaying products in cart
         $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
         $grand_total = 0;
         if(mysqli_num_rows($cart_query) > 0){
            while($fetch_cart = mysqli_fetch_assoc($cart_query)){
      ?>
         <tr>
            <!-- Product image -->
            <td><img src="admin/<?php echo $fetch_cart['image']; ?>" height="75" alt=""></td>
            <!-- Product name -->
            <td><?php echo $fetch_cart['name']; ?></td>
            <!-- Product price -->
            <td><?php echo $fetch_cart['price']; ?>$ </td>
            <!-- Form inputs for updating product quantity -->
            <td>
               <form action="" method="post">
                  <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                  <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
                  <input type="submit" name="update_cart" value="modifier"class="option-btn">
               </form>
            </td>
            <!-- Subtotal of product -->
            <td><?php echo $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>$</td>
            <!-- Remove product from cart button -->
            <td><a href="index.php?remove=<?php echo $fetch_cart['id']; ?>" class="delete-btn" onclick="return confirm('إزالة العنصر من سلة التسوق؟');">حذف</a></td>
         </tr>
      <?php
         // Calculating grand total
         $grand_total += $sub_total;
            }
         }else{
            echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6">le panier est vide</td></tr>';
         }
      ?>
      <!-- Table row for displaying grand total -->
      <tr class="table-bottom">
         <td colspan="4">prix total:</td>
         <td><?php echo $grand_total; ?>$</td>
         <!-- Button to delete all products from cart -->
         <td><a href="index.php?delete_all" onclick="return confirm('supprimer tout les produits du panier');" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">supprimer tout </a></td>
      </tr>
   </tbody>
   </table>

</div>

<!-- Inline styles -->
<style>
.main{
    width: 40%;
    box-shadow: 1px 1px 10px silver;
    margin-top: 45px;
    padding: 10px;
}
h2{
    font-family: 'Cairo', sans-serif;
}
input{
    margin-bottom: 10px;
    width: 60%;
    padding: 5px;
    font-family: 'Cairo', sans-serif;
    font-size: 15px;
    font-weight: bold;
}
button{
    border:none;
    padding: 10px;
    width: 40%;
    font-weight: bold;
    font-size: 15px;
    background-color: #1AC15C;
    cursor: pointer;
    font-family: 'Cairo', sans-serif;
    margin-bottom: 15px;
}
label{
    padding: 10px;
    cursor: pointer;
    font-weight: bold;
    font-size: 15px;
    background-color: #1F87CF;
    font-family: 'Cairo', sans-serif;
    color:white;
}
a{
    text-decoration: none;
    font-size: 20px;
    color:tomato;
    font-family: 'Cairo', sans-serif;
    font-weight: bold;
}
</style>

</div>

</div>

</body>
</html>
