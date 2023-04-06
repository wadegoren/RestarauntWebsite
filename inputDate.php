<?php
include 'connectdb.php';

// retrieve user inputted date from HTML form
$date = $_POST['date'];

// validate and sanitize user input
$date = filter_var($date, FILTER_SANITIZE_STRING);

// retrieve foodorder made on the specified date
$sql = "SELECT customeraccount.firstName, customeraccount.lastName, food.name, foodOrder.tip, employee.firstName AS deliveryFirstName, employee.lastName AS deliveryLastName
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
    echo "<table><tr><th>First Name</th><th>Last Name</th><th>Items Ordered</th><th>Total Amount</th><th>Tip</th><th>Delivery Person</th></tr>";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>".$row["firstName"]."</td><td>".$row["lastName"]."</td><td>".$row["name"]."</td><td>".$row["tip"]."</td><td>".$row["tip"]."</td><td>".$row["deliveryFirstName"]." ".$row["deliveryLastName"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "No food order found for this date";
}

// close connection
$conn = null;
?>

<a  href="frontpage.php">Return to homepage</a>