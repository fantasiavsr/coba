<?php
// Get the form data
$id = $_POST['id'];
$title = $_POST['title'];
$author = $_POST['author'];

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
$stmt = $conn->prepare("INSERT INTO borrowedbooks (title, author) VALUES (?, ?)");
$stmt->bind_param("ss", $title, $author);

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

// set avaulable book to false
$sql = "UPDATE books SET available = 0 WHERE id = $id";
$result = $conn->query($sql);

// Close the connection
$conn->close();

// Send the response back to the client
header("Content-Type: application/json");
echo json_encode($response);
?>
