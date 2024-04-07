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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    	// market table data 
	$machinebrand = $_POST["machinebrand"];
    $purchasedate = $_POST["purchasedate"];
    $purchaseprice = $_POST["purchaseprice"];
    $priceplan = $_POST["priceplan"];
    $sellerinfo = $_POST["sellerinfo"];
    $comments = $_POST["comments"];
    
    // Insert the admin Breakdown forum data into the database 
$stmt = $pdo->prepare("INSERT INTO tofix (machinename, machentrydate, machexpexteddate, price, clientname, clientnumber, clientadress, panne, comments) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$machinename, $machentrydate, $machexpexteddate, $price,$clientname,$clientnumber,$clientadress,$panne, $comments]);
    
    // Insert the admin Market forum data into the database
    $stmt = $pdo->prepare("INSERT INTO market (machinebrand, purchasedate, purchaseprice, priceplan, sellerinfo, comments) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$machinebrand, $purchasedate, $purchaseprice, $priceplan,$sellerinfo, $comments]);
    
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
    </style>
</head>
<body>
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
            <input type="submit" value="Add Machine">
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
            <label for="comments">Comments:</label>
            <input type="text" id="comments" name="comments">
            <input type="submit" value="Add Machine">
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
    <form action="edit_comment.php" method="post">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <input type="hidden" name="comment" value="<?php echo $row['comments']; ?>">
        <input type="text" name="edited_comment" placeholder="Enter edited comment">
        <input type="submit" value="Submit Edit">
    </form>
</td>
<td>
    <button onclick="confirmDelete(<?php echo $row['id']; ?>)">Delete Row</button>
</td>
    </tr>
    <?php endforeach; ?>
</table>

<h2>Clients bought items</h2>
<table>
    <tr>
        
        <th>Client UserName</th>
        <th>Client Submitted Name</th>
        <th>Adress</th>
        <th>Items Bought</th>
        <th>Phone Number</th>
        <th>Payment Method</th>
    </tr>
    <?php foreach ($rows_clients as $row) : ?>
    <tr>
        
        <td><?php echo $row['ussername']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['adress']; ?></td>
        <td><?php echo $row['items']; ?></td>
        <td><?php echo $row['number']; ?></td>
        <td><?php echo $row['pymentmethod']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>

	<!--deletion code, my head literally started aching here-->
<script>
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this row?')) {
            // AJAX request to delete the row
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Reload the page or update the table after successful deletion
                    location.reload();
                }
            };
            xhr.open('POST', 'delete_row.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('id=' + id);
        }
    }
</script>
</body>
</html>
