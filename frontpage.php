<!DOCTYPE html>
<h1> Wade's World </h1>

<h2>Welcome to Wade's Restaurant</h2>

<body>
    <form method="POST" action="inputDate.php">
      <body for="date">Enter Date:</body>
      <input type="date" id="date" name="date"><br><br>
      <button  class="button"type="submit">Submit</button>
    </form><br>
    <h2>Add New Customer:</h2>
    <button  class="button" onclick="showPopup()">Add Customer</button>

    <h2>Order Information:</h2>


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
  echo "<table style='margin: auto;'>";
  echo "<tr><th>Order Date</th><th>Number of Orders</th></tr>";
  foreach ($results as $row) {
      echo "<tr><td>" . $row["dateOrder"] . "</td><td>" . $row["numOrders"] . "</td></tr>";
  }
  echo "</table>";
} else {
  echo "No food orders found";
}
?><br>
<h2>View Employee Schedule:</h2>

<?php
$query = "SELECT firstName, lastName FROM employee";

// Execute the query
$random = $conn->prepare($query);
$random->execute();
$employees = $random->fetchAll(); 


// Create a dropdown menu with the list of employees
echo "<form method='POST' placeholder='Select'>";
echo "<select name='employee_name' style='width: 200px; height: 30px'>";
foreach ($employees as $row) {
  $employee_name = $row['firstName'] . ' ' . $row['lastName'];
  $selected = '';
  if (isset($_POST['employee_name']) && $_POST['employee_name'] == $employee_name) {
      $selected = 'selected';
  }
  echo "<option value='" . $employee_name . "' " . $selected . ">" . $employee_name . "</option>";
}
echo "</select><br>";
echo "<input  class='button' type='submit' name='submit' value='View Schedule'>";
echo "</form>";

// Handle form submission
if(isset($_POST['submit'])) {
    // Retrieve the selected employee name from the dropdown menu
    $selected_employee_name = $_POST['employee_name'];
    // Retrieve the employee ID based on their name
    $query = "SELECT ID FROM employee WHERE firstName = :firstName AND lastName = :lastName";
    $stmt = $conn->prepare($query);
    $names = explode(' ', $selected_employee_name);
    $stmt->bindParam(':firstName', $names[0]);
    $stmt->bindParam(':lastName', $names[1]);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $employee_id = $result['ID'];
  
    // Retrieve the employee's schedule for Monday to Friday
    $query = "SELECT employee.firstName, employee.lastName, shift.day, shift.startTime, shift.endTime
    FROM employee
    INNER JOIN shift ON employee.ID = shift.empID
    WHERE employee.ID = :employee_id AND shift.day NOT IN ('Saturday', 'Sunday')
    ORDER BY shift.day ASC";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':employee_id', $employee_id);
    $stmt->execute();
    $schedule = $stmt->fetchAll();
  
    // Display the schedule in a table format
    echo "<br><table style='margin: auto;'>";
    echo "<tr><th>Day</th><th style='padding-right: 20px;'>Start Time</th><th>End Time</th></tr>";
    foreach ($schedule as $row) {
      echo "<tr><td>" . $row['day'] . "</td><td>" . $row['startTime'] . "</td><td>" . $row['endTime'] . "</td></tr>";
}
echo "</table>";

}
?>


  <script>
    function showPopup() {
      var popup = document.getElementById("popup");
      popup.style.display = "block";
    }

    function hidePopup() {
      var popup = document.getElementById("popup");
      popup.style.display = "none";
    }
  </script>
  <style>
  body {
    text-align: center;
    font-family: Arial, sans-serif;
  }

  h1 {
    font-family: Arial, sans-serif;
  }

  h2 {
    font-family: Arial, sans-serif;
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
}

    #popup {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 1;
      border-radius: 8px;
    }

    #popup-content {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: white;
      padding: 100px;
      border-radius: 5px;
    }

    #popup-content label {
    font-size: 18px;
    margin-bottom: 10px;
    display: block;
    padding: 10px;
  }

  #popup-content input {
    font-size: 18px;
    padding: 10px;
    border-radius: 10px;
    width: 500px;
    box-sizing: border-box;
  }

  .button {
  display: inline-block;
  background-color: #4CAF50;
  border: none;
  color: white;
  padding: 8px 10px;
  text-align: center;
  text-decoration: none;
  font-size: 16px;
  border-radius: 5px;
  cursor: pointer;
  box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
}

.button:hover {
  background-color: #3e8e41;
  box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.3);
}

  </style>


<div id="popup">
  <div id="popup-content">
    <h2 style='font-size:25px;'>Input Customer Information</h2>
    <form method="POST" action="addCustomer.php">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required style="display: block;"><br>

      <label for="firstName">First Name:</label>
      <input type="text" id="firstName" name="firstName" required style="display: block;"><br>

      <label for="lastName">Last Name:</label>
      <input type="text" id="lastName" name="lastName" required style="display: block;"><br>

      <label for="phone">Phone:</label>
      <input type="tel" id="phone" name="phone" required style="display: block;"><br>

      <label for="streetAddress">Street Address:</label>
      <input type="text" id="streetAddress" name="streetAddress" required style="display: block;"><br>

      <label for="city">City:</label>
      <input type="text" id="city" name="city" required style="display: block;"><br>

      <label for="pc">Postal Code:</label>
      <input type="text" id="pc" name="pc" required style="display: block;">
      <br>
      <button class="button" type="submit">Add Customer</button> 
    </form>
    <br>
    <button class="button" onclick="hidePopup()">Close</button>
  </div>
</div>
</body>
</html>