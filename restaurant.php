<!DOCTYPE html>
<h1> Wade's World </h1>

<h2>Welcome to Wade's Restaurant</h2>

<body>
  <div id = 'wrapper'>
    <form method="POST" action="inputDate.php">
      <body for="date" style='font-size:25px;'>Enter Date:</body><br>
      <input type="date" id="date" name="date"><br><br>
      <button  class="button"type="submit">Submit</button>
    </form><br>
    <h2>Add New Customer:</h2>
    <button  class="button" onclick="showPopup()">Add Customer</button>

    <h2>Order Information:</h2>
    <button class= "button" onclick="window.location.href='orderInformation.php'">View Orders</button>

<br>
<h2>View Employee Schedule:</h2>

<?php
include 'connectdb.php';
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
    color: white;
    font-family: Arial, sans-serif;
    background-image: url("wade.png");
    background-repeat: no-repeat;
    background-size: cover;
  }

  #wrapper {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}

  input {
    padding: 15px 25px;
  }

  h1 {
    font-family: Arial, sans-serif;
    font-size: 70px;
  }

  h2 {
    font-family: Arial, sans-serif;
    font-size: 40px;
  }

  table {
    style='margin: auto;
    text-align: center;
    font-family: Arial, sans-serif;
    font-size: 18px;
  }

  a {
    color: blue;
    font-weight: bold;
    font-size: 18px;
    background: white;
  }


  table th {
  padding: 10px;
  font-size: 18px;
}

    /* Popup box */
#popup {
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.5);
}

#popup-content {
  background-color: white;
  margin: 10% auto;
  padding: 20px;
  border-radius: 5px;
  max-width: 500px;
  box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.5);
  text-align: center;
}

#popup-content h2 {
  font-size: 25px;
  color: #ff4500;
}

#popup-content label {
  display: inline-block;
  text-align: left;
  font-size: 16px;
  margin-bottom: 5px;
  color: black;
}

#popup-content input[type="email"],
#popup-content input[type="text"],
#popup-content input[type="tel"] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border: 2px solid #ccc;
  border-radius: 4px;
  font-size: 16px;
}

#popup-content button.button {
  background-color: #ff4500;
  border: none;
  color: white;
  padding: 12px 28px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  border-radius: 4px;
  cursor: pointer;
  margin-top: 10px;
}

#popup-content button.button:hover {
  background-color: #dc3700;
}

#popup-content button:last-child {
  margin-top: 20px;
}

@media screen and (max-width: 600px) {
  #popup-content {
    margin: 20% auto;
    max-width: 80%;
  }
}

  .button {
  display: inline-block;
  background-color: #ff4500;
  border: none;
  color: white;
  padding: 15px 25px;
  text-align: center;
  text-decoration: none;
  font-size: 16px;
  border-radius: 5px;
  cursor: pointer;
  box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
}

.button:hover {
  background-color: #ff4500;
  box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.3);
}

  </style>


<div id="popup">
  <div id="popup-content">
    <h2 style='font-size:25px; color: black;'>Input Customer Information</h2>
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
</div>
</body>
</html>