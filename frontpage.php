<!DOCTYPE html>
<h1> Wade's World </h1>

<?php
include 'connectdb.php';
?>

<p>Welcome to Wade's Restaurant</p>

<body>
    <form method="POST" action="inputDate.php">
      <label for="date">Enter Date:</label>
      <input type="date" id="date" name="date">
      <button type="submit">Submit</button>
    </form>

    <button onclick="showPopup()">Add Customer</button>
  </body>

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
    #popup {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 1;
    }

    #popup-content {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: white;
      padding: 20px;
      border-radius: 5px;
    }
  </style>
</head>
<body>

  
  <div id="popup">
    <div id="popup-content">
      <h2>Add Customer</h2>
      <form method="POST" action="addCustomer.php">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" required>

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" required>

        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" required>

        <label for="streetAddress">Street Address:</label>
        <input type="text" id="streetAddress" name="streetAddress" required>

        <label for="city">City:</label>
        <input type="text" id="city" name="city" required>

        <label for="pc">Postal Code:</label>
        <input type="text" id="pc" name="pc" required>

        <button type="submit">Add Customer</button>
      </form>
      <button onclick="hidePopup()">Close</button>
    </div>
  </div>
</body>
</html>