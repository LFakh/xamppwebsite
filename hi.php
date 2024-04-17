<?php

session_start();

// Take in errors if existed
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');

// Take in the opened session
$user = $_SESSION['user'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    require_once 'db.php';

    // Combine first name and last name for the username column
    //$username = $user['firstname'] . ' ' . $user['lastname'];
	//$username = $user['id'];
    // Convert cart items array to a string for the items column
    //$items = implode(', ', $_SESSION['cartItems']);
	$items = isset($_POST['cartItems']) ? $_POST['cartItems'] : '';
    // Prepare and execute SQL statement to insert user name and cart items into the database
   /* $stmt = $pdo->prepare("INSERT INTO purchase (username, items) VALUES (?, ?)");
    $stmt->execute([$username, $items]);*/
    try {
    $stmt = $pdo->prepare("INSERT INTO purchase (items) VALUES ( ?)");
    $stmt->execute([$items]);
    header("Location: purchase.php");
    exit();
} catch (PDOException $e) {
    error_log('Insert Error: ' . $e->getMessage());
    // Handle error appropriately
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"/>
    </head>
    <title>Gamer Shop</title>
    <style>
       
       body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }
        .image-container {
            display: inline-block;
            margin: 20px;
        }
        .image-container img {
            width: 200px;
            height: 200px;
            border-radius: 10px;
            cursor: pointer;
        }
             .image-container:hover {
  background-color: #888888;
  box-shadow: 2px 2px 12px #05d5fc; 
    -webkit-transition: all 0.2s ease-out;
    -moz-transition: all 0.2s ease-out;
    transition: all 0.2s ease-out;
}

        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .popup-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        .popup-buttons {
            margin-top: 20px;
        }
        .popup-buttons button {
            margin: 0 10px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .navbar {
            text-align: right;
            padding: 10px;
        }
        .cart-container {
            position: relative;
        }
        .icon {
            position: absolute;
            top: 1px; /* Adjust the top value as needed */
            right: 0;
            display: inline-block;
            background-color: #007bff;
            color: white;
            width: 30px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            border-radius: 50%;
            cursor: pointer;
        }
        /**/
        .icons-social{
    padding: 5px;
    }
    
    .list-social{
    text-align: center;
    padding: 0;
    }
    
    .icons-social__item{
    display: inline-block;
    }
    
    .icons-social__link{
    cursor: pointer;
    display: flex;
    text-decoration: none;
    justify-content: center;
    align-items: center;
    color: #000;
    height: 40px;
    width: 40px;
    border-radius: 50%;
    margin: 0px 5px;
    font-size: 20px;
    box-shadow: 0 5px 4px rgba(73, 55, 235, 0.8); 
    -webkit-transition: .2s linear;
    transition: .2s linear; 
    }
    
    .icons-social__link:hover{
    box-shadow: 0 0 0 rgba(37, 40, 45, 0); 
    }
    .icons-social__i {
  color: grey;
}

    /**/
    .footer{
    color: #444;
    padding: 40px 0;
    text-align: center; 
    z-index: -99;
    }
    
    .container-footer__link{
    color: #444;
    text-decoration: none;
    }
    
    .container-footer__link:hover{
    color: #333;
    }
    .note{
    font-size: 18px;
    line-height: 1.33;
    font-weight: 300;
    font-style: normal;
    margin-bottom: 40px;
    max-width: 1000px;}
    </style>

<body>
    <div class="navbar">
    <!--style="display: block; margin: 0 auto 0 -80px;"-->
    <img src="https://i.ibb.co/bmD4CZY/img-09.png"/>
        <div class="cart-container">
            <img class="cart" src="https://dl.dropbox.com/scl/fi/o6wr3adxebe9buo173s7v/cart.png?rlkey=5iftghnaliuwmt3kpesbltv2x"/>
            <div class="icon" id="cart-icon">0</div>
        </div>
        <p><a href="signout.php">Sign out</a></p>
<p class="note">Thank you for making an account please click on the item that you wish to buy so it be added to the cart. <!--?php echo $username; ?--></p>
    </div>
    <div class="container">
        <div class="image-container" data-item="Laptop" data-price="1500">
            <img src="https://i.ibb.co/yqJLmNQ/img-11.png" alt="Laptop">
            <p>Laptop -1500$</p>	
        </div>
        <div class="image-container" data-item="Keyboard" data-price="50">
            <img src="https://i.ibb.co/9wq0zRY/img-05.png" alt="Keyboard">
            <p>Keyboard -50$</p>
        </div>
        <div class="image-container" data-item="Monitor" data-price="150">
            <img src="https://i.ibb.co/MnCqnTB/img-07.png" alt="Monitor">
            <p>Monitor -150$</p>
        </div>
        <div class="image-container" data-item="Mouse" data-price="100">
            <img src="https://i.ibb.co/Dfxg1pB/img-06.png" alt="Mouse">
            <p>Mouse -100$</p>
        </div>
        <div class="image-container" data-item="Case" data-price="90">
            <img src="https://i.ibb.co/HDhN6M5/img-04.png" alt="Case">
            <p>Case -90$</p>
        </div>
        <div class="image-container" data-item="Notebook" data-price="200">
            <img src="https://i.ibb.co/d5zn25B/img-08.png" alt="Notebook">
            <p>Notebook -200$</p>
        </div>
        <div class="image-container" data-item="Alienware" data-price="3500">
            <img src="https://dl.dropbox.com/scl/fi/8qz86e01abaoedd87xovo/187-1876762_weve-already-seen-alienwares-new-area-51-gaming.png?rlkey=na8m7oqlaozlsfx54b3miu3o4" alt="Alienware">
            <p>Alienware Full Set -3500$</p>
        </div>
        <div class="image-container" data-item="Pc" data-price="3000">
            <img src="https://dl.dropbox.com/scl/fi/bnkjvf7i9yskee2vxgc5l/downloadfile.jpg?rlkey=m40pnm222h6kctbjad5s23z3k" alt="Pc">
            <p>Desktop PC Central Unit -3000$</p>
        </div>
    </div>

    <div class="popup" id="purchase-popup">
        <div class="popup-content">
            <p>Are you sure you want to purchase?</p>
            <div class="popup-buttons">
                <button id="purchase-yes">Yes</button>
                <button id="purchase-no">No</button>
            </div>
        </div>
    </div>

    <div class="popup" id="confirmation-popup">
        <div class="popup-content">
            <p>Are you sure?</p>
            <div class="popup-buttons">
                <button id="confirmation-yes">Yes</button>
                <button id="confirmation-no">No</button>
            </div>
        </div>
    </div>
    <footer class="footer">
      <div class="icons-social">
        <ul class="list-social">
          <li class="icons-social__item"><a class="icons-social__link" href="#"><i class="icons-social__i fab fa-codepen"></i></a></li>              
          <li class="icons-social__item"><a class="icons-social__link" href="#"><i class="icons-social__i fab fa-instagram"></i></a></li>
          <li class="icons-social__item"><a class="icons-social__link" href="#"><i class="icons-social__i fab fa-facebook"></i></a></li>
          <li class="icons-social__item"><a class="icons-social__link" href="#"><i class="icons-social__i fab fa-twitter"></i></a></li>
          <li class="icons-social__item"><a class="icons-social__link" href="#"><i class="icons-social__i fab fa-linkedin"></i></a></li>
        </ul>
      </div>
      <div class="container-footer">
        <p>Developed by <a class="container-footer__link" href="" target="_blank">LFakh</a> | Copyright &copy; 2024</p>
      </div>
    </footer>  
    <script>
    
    const cartIcon = document.getElementById('cart-icon');
    const confirmationPopup = document.getElementById('confirmation-popup');
    const confirmationYesBtn = document.getElementById('confirmation-yes');
    const confirmationNoBtn = document.getElementById('confirmation-no');

    let cartItems = []; // Array to store the items added to the cart
	let cartTotal = 0; // Initialize cart total
    // Add click event listener to all image containers
    const imageContainers = document.querySelectorAll('.image-container');
    imageContainers.forEach(container => {
        container.addEventListener('click', () => {
            const item = container.getAttribute('data-item');
            const price = container.getAttribute('data-price');
            addToCart(item); // Add item to cart
            incrementCart(); // Increment cart icon number
        });
    });
    
    

    // Add click event listener to cart icon
    cartIcon.addEventListener('click', () => {
        if(cartItems.length > 0) { // Check if there are items in the cart
            showConfirmationPopup(); // Show items in confirmation popup
        }
    });

    // Add click event listener to confirmation yes button
    confirmationYesBtn.addEventListener('click', () => {
    // Create a FormData object
    let formData = new FormData();
    // Append the cartItems array joined by commas as a single string
    formData.append('cartItems', cartItems.join(','));
//it sends the data to purchase right now, change it to this files name if you want it to send the data from this file instead
    fetch('hi.php', {
        method: 'POST',
        body: formData // Use FormData object
    })
    .then(response => response.text())
    .then(result => {
        console.log(result);
        window.location.href = 'purchase.php'; // Redirect after successful operation
    })
    .catch(error => console.error('Error:', error));
});

    // Add click event listener to confirmation no button
    confirmationNoBtn.addEventListener('click', () => {
        hidePopup(confirmationPopup); // Hide confirmation popup
        resetCart(); // Reset cart
    });

    // Function to add item to cart
    function addToCart(item) {
        cartItems.push(item); // Add the item to the cartItems array
        cartTotal += price;
    }

	// Function to update the cart total display
function updateCartTotal() {
    cartIcon.textContent = `$${cartTotal}`;  // Update the text content of the cart icon
}

    // Function to show confirmation popup
    function showConfirmationPopup() {
        const popupContent = confirmationPopup.querySelector('.popup-content p');
   popupContent.innerHTML = `Are you sure you want to purchase: ${cartItems.join(", ")}? Total Price is = $${cartTotal}`; // List all items in popup
        confirmationPopup.style.display = 'block'; // Show popup
    }

    // Function to hide popup
    function hidePopup(popup) {
        popup.style.display = 'none';
    }

    // Function to increment cart
    function incrementCart() {
        cartIcon.innerText = parseInt(cartIcon.innerText) + 1;
    }

    // Function to reset cart
    function resetCart() {
        cartItems = []; // Clear the cartItems array
        cartIcon.innerText = '0'; // Reset cart icon number
        cartTotal = 0;  // Reset the total to 0
    updateCartTotal(); // Update the display
     hidePopup(confirmationPopup);
    }
</script>

</body>
</html>
