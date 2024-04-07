<?php

session_start();
// Take in the opened session
$user = $_SESSION['user'];
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');
//error_log(print_r($_POST['cartItems'], true));
//error_log(print_r($_POST, true));
if ($_SERVER["REQUEST_METHOD"] == "POST") {
require_once 'db.php';
    //$items = isset($_POST['cartItems']) ? $_POST['cartItems'] : '';
    //$items = isset($_POST['cartItems']) ? (is_array($_POST['cartItems']) ? implode(',', $_POST['cartItems']) : $_POST['cartItems']) : '';
    $name = $_POST['name'];
    $address = $_POST['address'];
    $paymentMethod = $_POST['paymentmethod'];
    $phoneNumber = $_POST['number'];

    if (empty($name) || empty($address) || empty($paymentMethod) || empty($phoneNumber)) {
        echo "Please don't leave any of the fields empty.";
        exit();
    }

    try {
        // No need to implode $items, it's already a string
        /*$stmt = $pdo->prepare("INSERT INTO purchase (items, name, address, paymentmethod, number) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$items, $name, $address, $paymentMethod, $phoneNumber]);
		*/
		$stmt = $pdo->prepare("UPDATE purchase SET name = ?, address = ?, paymentmethod = ?, number = ? ORDER BY id DESC LIMIT 1");
        $stmt->execute([$name, $address, $paymentMethod, $phoneNumber]);

        // Redirect or inform the user of success
        header("Location: processing.php");
        exit();
    } catch (PDOException $e) {
        error_log('Insert Error: ' . $e->getMessage());
        echo "An error occurred.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Purchase</title>
</head>
<body>
    <h1>Thank you for your purchase <!--?php echo $user['firstname']; ?-->!</h1>
    <div class="container">
<div class="zbda">
<h2>More Details</h2>
<form action="" method="post">

    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>
   
    <label for="address">address to deliver to:</label>
    <input type="text" id="address" name="address" required>
    
    <label for="paymentmethod">payment Method:</label>
    <input type="text" id="paymentmethod" name="paymentmethod">
  
	<label for="number">Phone Number:</label>
    <input type="number" id="number" name="number" required>
  
        <input id="toggle" type="submit" value="Confirm Payement">
</form>
<style>       
 //fk it some nice arts
        .zbda {
  padding: 10px;
  border: 1px solid #dddddd;
  border-radius: 5px;
  background-color: #f5f5f5;
}

.zbda h2 {
  margin-top: 0;
}

.zbda label {
  display: block;
  margin-bottom: 10px;
  font-weight: bold;
}

.zbda input[type="text"],
.zbda textarea {
  width: 30%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-bottom: 10px;
}

.zbda textarea {
  height: 80px;
}

.zbda input[type="submit"] {
  padding: 10px 20px;
  background-color: green;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
 
</style>
</body>
</html>
