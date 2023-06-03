<?php

// sql for return book (delete book from borrowedbooks table and add 1 to available book)

// Get the form data
$id = $_POST['id'];

// Perform the database insertion
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "perpus";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement
$stmt = $conn->prepare("DELETE FROM borrowedbooks WHERE id = ?");
$stmt->bind_param("i", $id);

// Execute the statement
if ($stmt->execute()) {
    // If the insertion is successful
    $response = array("success" => true);
} else {
    // If the insertion fails
    $response = array("success" => false);
}

// Close the statement and the connection
$stmt->close();

// set avaulable book to true
$sql = "UPDATE books SET available = 1 WHERE id = $id";
$result = $conn->query($sql);

// Close the connection
$conn->close();

// Send the response back to the client
header("Content-Type: application/json");
echo json_encode($response);
?>
