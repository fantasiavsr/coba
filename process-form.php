<?php
// Get the form data
$title = $_POST['title'];
$author = $_POST['author'];
$available = 0;

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
$stmt = $conn->prepare("INSERT INTO books (title, author, available) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $title, $author, $available);

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
$conn->close();

// Send the response back to the client
header("Content-Type: application/json");
echo json_encode($response);
?>
