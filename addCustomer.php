<!DOCTYPE html>
<html>
<head>
	<title>Customer Registration</title>
	<style>
		body {
			background-color: #F8F8F8;
			font-family: Arial, sans-serif;
			font-size: 16px;
			margin: 0;
			padding: 0;
			text-align: center;
		}
		.container {
			max-width: 600px;
			margin: 0 auto;
			padding: 20px;
			background-color: #FFFFFF;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
			border-radius: 10px;
			text-align: center;
		}
		h1 {
			margin-top: 0;
			color: #444444;
			font-size: 36px;
			font-weight: bold;
			text-transform: uppercase;
			letter-spacing: 2px;
		}
		form {
			display: inline-block;
			text-align: left;
		}
		label {
			display: block;
			margin-bottom: 5px;
			color: #444444;
			font-weight: bold;
		}
		input[type=text], input[type=email], input[type=tel] {
			width: 100%;
			padding: 10px;
			border: 1px solid #CCCCCC;
			border-radius: 5px;
			margin-bottom: 20px;
			font-size: 16px;
		}
		input[type=submit] {
			background-color: #2D6FB1;
			color: #FFFFFF;
			font-size: 16px;
			font-weight: bold;
			border: none;
			border-radius: 5px;
			padding: 10px 20px;
			cursor: pointer;
			margin-top: 10px;
		}
		input[type=submit]:hover {
			background-color: #1A476F;
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
</head>
	<?php
	include 'connectdb.php';

	// retrieve user inputted data from HTML form
	$emailAddress = $_POST['email'];
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$cellNum = $_POST['phone'];
	$streetAddress = $_POST['streetAddress'];
	$city = $_POST['city'];
	$pc = $_POST['pc'];
	$creditAmt = 5.0;

	// validate and sanitize user input
	$firstName = filter_var($firstName, FILTER_SANITIZE_STRING);
	$lastName = filter_var($lastName, FILTER_SANITIZE_STRING);
	$emailAddress = filter_var($emailAddress, FILTER_SANITIZE_EMAIL);
	$cellNum = filter_var($cellNum, FILTER_SANITIZE_NUMBER_INT);
	$pc = filter_var($pc, FILTER_SANITIZE_STRING);

	// check if customer already exists in database
	$sql = "SELECT * FROM CustomerAccount WHERE emailAddress = :emailAddress";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':emailAddress', $emailAddress);
	$stmt->execute();

	if ($stmt->rowCount() > 0) {
	    echo "<p style='text-align:center; color:red;'>Error: Customer with this email already exists</p>";
	} else {
	    // add customer to database with $5.00 credit
	    $sql = "INSERT INTO CustomerAccount (emailAddress, firstName, lastName, cellNum, streetAddress, city, pc, creditAmt) VALUES (:emailAddress, :firstName, :lastName, :cellNum, :streetAddress, :city, :pc, :creditAmt)";
	    $stmt = $conn->prepare($sql);

	    $stmt->bindParam(':emailAddress', $emailAddress);
	    $stmt->bindParam(':firstName', $firstName);
	    $stmt->bindParam(':lastName', $lastName);
	    $stmt->bindParam(':cellNum', $cellNum);
	    $stmt->bindParam(':streetAddress', $streetAddress);
	    $stmt->bindParam(':city', $city);
	    $stmt->bindParam(':pc', $pc);
	    $stmt->bindParam(':creditAmt', $creditAmt);

    if ($stmt->execute()) {
        echo "Customer added successfully!";
    } else {
        echo "Error adding customer to database";
    }
}

// close connection
$conn = null;
?><br>
<body>
<button onclick="window.location.href='restaurant.php'">Return to Front Page</button>
</body>
