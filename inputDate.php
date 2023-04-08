<?php
include 'connectdb.php';

// retrieve user inputted date from HTML form
$date = $_POST['date'];

// validate and sanitize user input
$date = filter_var($date, FILTER_SANITIZE_STRING);

// retrieve foodorder made on the specified date
$sql = "SELECT customeraccount.firstName, customeraccount.lastName, foodOrder.totalPrice, food.name, foodOrder.tip, employee.firstName AS deliveryFirstName, employee.lastName AS deliveryLastName
FROM CustomerAccount JOIN OrderPlacement on CustomerAccount.emailAddress = OrderPlacement.customerEmail
JOIN foodOrder on OrderPlacement.OrderID = foodOrder.orderID
JOIN foodItemsinOrder on foodOrder.orderID = foodItemsinOrder.orderID
JOIN food on foodItemsinOrder.food = food.name
JOIN delivery on foodOrder.OrderID = delivery.OrderID
JOIN employee on delivery.deliveryPerson = employee.ID
WHERE foodOrder.orderDate = :date";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':date', $date);
$stmt->execute();

// display results
if ($stmt->rowCount() > 0) {
    echo "<div style='margin: auto; width: 600px; font-family: Arial, sans-serif;'>";
    echo "<h1 style='text-align: center;'>Orders Made on ".$date."</h1>";
    echo "<table style='border-collapse: collapse; width: 100%;'>";
    echo "<thead><tr><th style='text-align: center;'>Customer Name</th><th style='text-align: center;'>Items Ordered</th><th style='text-align: center;'>Total Amount</th><th style='text-align: center;'>Tip</th><th style='text-align: center;'>Delivery Person</th></tr></thead>";
    echo "<tbody>";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>".$row["firstName"]." ".$row["lastName"]."</td><td>".$row["name"]."</td><td>$".$row["totalPrice"]."</td><td>$".$row["tip"]."</td><td>".$row["deliveryFirstName"]." ".$row["deliveryLastName"]."</td></tr>";
    }
    echo "</tbody></table>";
    echo "</div>";
} else {
    echo "<p>No food order found for this date</p>";
}
// close connection
$conn = null;
?>
<br>

<style>
  body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    text-align: center;
  }


  a:hover {
    background-color: #ff4500;
    color: white;
  }

  h1 {
    text-align: center;
    font-size: 36px;
    margin: 30px 0;
    color: #ff4500;
  }

  p {
    text-align: center;
    font-size: 18px;
    margin: 10px 0;
  }

  table {
    margin: auto;
    text-align: center;
    font-size: 18px;
    border-collapse: collapse;
    width: 80%;
  }

  td {
    padding: 10px;
    font-size: 18px;
    font-family: Arial, sans-serif;
    border: 1px solid #ddd;
  }

   td {

    padding: 10px;
    font-size: 18px;
    font-family: Arial, sans-serif;
    border: 1px solid #ddd;
  }

  th {
    background-color: #ff4500;
    color: white;
  }

  .center {
    text-align: center;
  }

  button {
			background-color: #c04e3f;
			color: #fff;
			padding: 15px 30px;
			font-size: 24px;
			border: none;
			border-radius: 5px;
			margin-top: 50px;
			text-align: center;
		}

		button:hover {
			background-color: #d35400;
			cursor: pointer;
		}

</style>

<body>
<button onclick="window.location.href='restaurant.php'">Return to Front Page</button>
</body>