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
JOIN foodItemsinOrder on foodOrder.orderID = foodItemsinOrder. orderID
JOIN food on foodItemsinOrder.food = food.name
JOIN delivery on foodOrder.OrderID = delivery.OrderID
JOIN employee on delivery.deliveryPerson = employee.ID
WHERE foodOrder.orderDate = :date";


$stmt = $conn->prepare($sql);
$stmt->bindParam(':date', $date);
$stmt->execute();

// display results
if ($stmt->rowCount() > 0) {
    echo "<div style='margin: auto; width: 300px; font-family: Arial, sans-serif;'>";
    echo "<h1 style='text-align: center;'>Receipt</h1>";
    echo "<p style='text-align: center;'>Date: " . date('Y-m-d') . "</p>";
    echo "<table style='border-collapse: collapse; width: 100%;'>";
    echo "<thead><tr><th style='text-align: center;'>Item</th><th style='text-align: center;'>Total Price</th></tr></thead>";
    echo "<tbody>";
    $total = 0;
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td style='text-align: center;'>".$row["name"]."</td><td style='text-align: center;'>$".$row["totalPrice"]."</td></tr>";
        $total += $row["totalPrice"];
        $tip = $row["tip"];
    }
    echo "<tr><td style='text-align: center;'>Tip</td><td style='text-align: center;'>$".$tip."</td></tr>";
    $total += $tip;
    echo "<tr><td style='text-align: center; font-weight: bold;'>Total</td><td style='text-align: center; font-weight: bold;'>$".$total."</td></tr>";
    echo "</tbody></table>";
    echo "<p style='text-align: center;'>Thank you for your order!</p>";
    echo "</div>";
} else {
    echo "<p>No food order found for this date</p>";
}



// close connection
$conn = null;
?><br>

<style>
    a {
        display: block;
        margin: auto;
        font-family: Arial, sans-serif;
        font-size: 18px;
        text-align: center;
    }

    
  table {
    style='margin: auto;
    text-align: center;
    font-family: Arial, sans-serif;
    font-size: 18px;
  }

    table th {
  padding: 10px;
  font-size: 18px;
  font-family: Arial, sans-serif;
  
}

table tb {
  padding: 10px;
  font-size: 18px;
  font-family: Arial, sans-serif;
}
</style>

<a href="frontpage.php">Return to homepage</a>