<!DOCTYPE html>
<html>
<head>
	<title>Restaurant Orders</title>
	<style>
		body {
			background-color: #f5cda9;
			font-family: Arial, sans-serif;
			text-align: center;
		}

		h1 {
			font-size: 48px;
			color: #c04e3f;
			margin-top: 50px;
		}

		table {
			border-collapse: collapse;
			margin: auto;
			margin-top: 50px;
			font-size: 24px;
		}

		th, td {
			padding: 10px;
			border: 1px solid #c04e3f;
			color: #c04e3f;
		}

		th {
			background-color: #f7e1d7;
		}

		td {
			background-color: #fff3ea;
		}

		button {
			background-color: #c04e3f;
			color: #fff;
			padding: 15px 30px;
			font-size: 24px;
			border: none;
			border-radius: 5px;
			margin-top: 50px;
		}

		button:hover {
			background-color: #d35400;
			cursor: pointer;
		}

	</style>
</head>
<body>
	<h1>Restaurant Orders</h1>

	<?php 
	include 'connectdb.php';
	$sql = "SELECT DISTINCT orderDate as dateOrder, count(orderDate) AS numOrders
	FROM foodOrder 
	GROUP BY dateOrder
	";

	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$results = $stmt->fetchAll(); 
	// display results
	if ($stmt->rowCount() > 0) {
	  echo "<table>";
	  echo "<tr><th>Order Date</th><th>Number of Orders</th></tr>";
	  foreach ($results as $row) {
	      echo "<tr><td>" . $row["dateOrder"] . "</td><td>" . $row["numOrders"] . "</td></tr>";
	  }
	  echo "</table>";
	} else {
	  echo "No food orders found";
	}
	?>

	<button onclick="window.location.href='restaurant.php'">Return to Front Page</button>

</body>
</html>
