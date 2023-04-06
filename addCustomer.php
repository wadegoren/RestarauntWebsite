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
    echo "Error: Customer with this email already exists";
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
?>
