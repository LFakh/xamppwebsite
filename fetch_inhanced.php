<?php
$host = 'localhost';
$dbname = 'zbb'; 
$username = 'root'; 
$password = ''; 

$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_to_fix'])) {
		// tofix table data
    $machinename = $_POST["machinename"];
    $machentrydate = $_POST["machentrydate"];
    $machexpexteddate = $_POST["machexpexteddate"];
    $price = $_POST["price"];
    $clientname = $_POST["clientname"];
    $clientnumber = $_POST["clientnumber"];
    $clientadress = $_POST["clientadress"];
    $panne = $_POST["panne"];
    $comments = $_POST["comments"];

    // Insert the admin forum data into the database 
$stmt = $pdo->prepare("INSERT INTO tofix (machinename, machentrydate, machexpexteddate, price, clientname, clientnumber, clientadress, panne, comments) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$machinename, $machentrydate, $machexpexteddate, $price,$clientname,$clientnumber,$clientadress,$panne, $comments]);
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_market'])) {    
	    	// market table data 
	$machinebrand = $_POST["machinebrand"];
    $purchasedate = $_POST["purchasedate"];
    $purchaseprice = $_POST["purchaseprice"];
    $priceplan = $_POST["priceplan"];
    $sellerinfo = $_POST["sellerinfo"];
    $comment = $_POST["comment"];
	
    // Insert the admin Market forum data into the database
$stmt = $pdo->prepare("INSERT INTO market (machinebrand, purchasedate, purchaseprice, priceplan, sellerinfo, comment) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$machinebrand, $purchasedate, $purchaseprice, $priceplan,$sellerinfo, $comment]);
        
}

    
// Handling Edit Submissions
if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST['new_comment']) && isset($_POST['id_to_edit'])) {
    $editedComment = $_POST['edited_comment'];
    $idToEdit = $_POST['id_to_edit'];

    $stmt = $pdo->prepare("UPDATE tofix SET comments = ? WHERE id = ?");
    $stmt->execute([$editedComment, $idToEdit]);
}

// Handling Delete Submissions
if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST['delete_action'])) {
    $idToDelete = $_POST['id_to_delete'];

    $stmt = $pdo->prepare("DELETE FROM tofix WHERE id = ?");
    $stmt->execute([$idToDelete]);
}

// Fetch data from the users database
$stmt_users = $pdo->query('SELECT * FROM users'); 
$rows_users = $stmt_users->fetchAll();

// Fetch data from the tofix database
$stmt_tofix = $pdo->query('SELECT * FROM tofix'); 
$rows_tofix = $stmt_tofix->fetchAll();

// Fetch data from the purchase database
$stmt_clients = $pdo->query('SELECT * FROM purchase'); 
$rows_clients = $stmt_clients->fetchAll();

// Fetch data from the market database
$stmt_market = $pdo->query('SELECT * FROM market'); 
$rows_market = $stmt_market->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Forum</title>
    <style>
        /* tables of course */
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        /* container requirements */
        .container {
            display: flex; /* Use flexbox */
            justify-content: space-between; /* Items are evenly distributed in the container */
            align-items: flex-start; /* Items are aligned at the start of the cross axis */
            margin-bottom: 20px; /* Add some margin between forms */
        }
        /* some nice arts because why not */
        .zbda {
            padding: 10px;
            border: 1px solid #dddddd;
            border-radius: 5px;
            background-color: #f5f5f5;
            width: 45%; /* Set width to occupy 45% of the container */
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
        .zbda input[type="date"],
        .zbda input[type="number"],
        .zbda textarea {
            width: 100%; /* Make inputs fill the entire width */
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
            background-color: skyblue;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    .signout-button {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        
        .button,
        .btn input[type="submit"] {
            margin-top: 1px;
            padding: 10px 20px;
            background-color: red;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        h1{
        margin-top: 0;
        	display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-family: 'Roboto', sans-serif;
        }
    </style>
<body>
	<h1>The Admin Page</h1>
	<div class="signout-button">
	<a href="signout.php" class="button">Sign out</a>
	</div>
<div class="container">
    <div class="zbda">
        <h2>Admin Breakdown Forum</h2>
        <form action="" method="post">
            <label for="machinename">Machine Name:</label>
            <input type="text" id="machinename" name="machinename" required>
            <label for="machentrydate">Machine Entry Date:</label>
            <input type="date" id="machentrydate" name="machentrydate" required>
            <label for="machexpexteddate">Machine Expected Fix Date:</label>
            <input type="date" id="machexpexteddate" name="machexpexteddate" required>
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" required>
            <label for="panne">Panne:</label>
            <input type="text" id="panne" name="panne" required>
            <label for="clientname">Client Name:</label>
            <input type="text" id="clientname" name="clientname" required>
            <label for="clientnumber">Client Number:</label>
            <input type="number" id="clientnumber" name="clientnumber" required>
            <label for="clientadress">Client Adress:</label>
            <input type="text" id="clientadress" name="clientadress" required>
            <label for="comments">Comments:</label>
            <input type="text" id="comments" name="comments">
            <input type="submit" name="submit_to_fix" value="Add Machine">
        </form>
    </div>

    <div class="zbda">
        <h2>Admin Market Forum</h2>
        <form action="" method="post">
            <label for="machinebrand">Machine Brand:</label>
            <input type="text" id="machinebrand" name="machinebrand" required>
            <label for="purchasedate"> Date of Purchase:</label>
            <input type="date" id="purchasedate" name="purchasedate" required>
            <label for="purchaseprice">Purchase Price:</label>
            <input type="number" id="purchaseprice" name="purchaseprice" required>
            <label for="priceplan">Selling Price Plan:</label>
            <input type="number" id="priceplan" name="priceplan" required>
            <label for="sellerinfo">Seller info:</label>
            <input type="text" id="sellerinfo" name="sellerinfo" required>
            <label for="comment">Comments:</label>
            <input type="text" id="comment" name="comment">
            <input type="submit" name="submit_market" value="Add Machine">
        </form>
    </div>
</div>
<h2>User Records</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
        <th>Role</th>
        <th>logged in</th>
        <th>logged out</th>
    </tr>
    <?php foreach ($rows_users as $row) : ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['firstname']; ?></td>
        <td><?php echo $row['lastname']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['role']; ?></td>
        <td><?php echo $row['signin_time']; ?></td>
        <td><?php echo $row['signout_time']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<h2>Machines to Fix</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Machine Name</th>
        <th>Machine Entry Date</th>
        <th>Machine Expected Fix Date</th>
        <th>Price</th>
        <th>Client Name</th>
        <th>Client Number</th>
        <th>Client Adress</th>
        <th>Panne</th>
        <th>Comments</th>
        <th>to edit</th>
        <th>to delete</th>
    </tr>
    <?php foreach ($rows_tofix as $row) : ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['machinename']; ?></td>
        <td><?php echo $row['machentrydate']; ?></td>
        <td><?php echo $row['machexpexteddate']; ?></td>
        <td><?php echo $row['price']; ?></td>
        <td><?php echo $row['clientname']; ?></td>
        <td><?php echo $row['clientnumber']; ?></td>
        <td><?php echo $row['clientadress']; ?></td>
        <td><?php echo $row['panne']; ?></td>
        <td><?php echo $row['comments']; ?></td>
        <td>
    <form action="" method="post">
        <input type="hidden" name="id_to_edit" value="<?php echo $row['id']; ?>">
        <input type="hidden" name="edited_comment" value="<?php echo $row['comments']; ?>">
        <input type="text" name="edited_comment" placeholder="Enter edited comment">
        <div class="btn">
        <input type="submit" name="new_comment" value="Submit Edit">
        </div>
    </form>
</td>
<td>
	<div class="btn">
    <form action="" method="post" onsubmit="return confirm('Are you sure you want to delete this row?');">
    <input type="hidden" name="id_to_delete" value="<?php echo $row['id']; ?>">
    <input type="submit" name="delete_action" value="Delete">
    </div>
</form>
</td>
    </tr>
    <?php endforeach; ?>
</table>

<h2>Clients bought items</h2>
<table>
    <tr>
        <th>Client Name</th>
        <th>Adress</th>
        <th>Items Bought</th>
        <th>Phone Number</th>
        <th>Payment Method</th>
    </tr>
    <?php foreach ($rows_clients as $row) : ?>
    <tr>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['adress']; ?></td>
        <td><?php echo $row['items']; ?></td>
        <td><?php echo $row['number']; ?></td>
        <td><?php echo $row['pymentmethod']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<h2>Market Bought Machines</h2>
<table>
    <tr>
        <th>Machine Brand</th>
        <th>Purchase Date</th>
        <th>Purchase Price</th>
        <th>Price Plan</th>
        <th>Seller Info</th>
        <th>Comment</th>
    </tr>
    <?php foreach ($rows_market as $row) : ?>
    <tr>
        <td><?php echo $row['machinebrand']; ?></td>
        <td><?php echo $row['purchasedate']; ?></td>
        <td><?php echo $row['purchaseprice']; ?></td>
        <td><?php echo $row['priceplan']; ?></td>
        <td><?php echo $row['sellerinfo']; ?></td>
        <td><?php echo $row['comment']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
