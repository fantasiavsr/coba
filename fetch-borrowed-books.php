<?php
// Perform the database retrieval
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

// Retrieve the borrowed book data 
$sql = "SELECT * FROM borrowedbooks";
$result = $conn->query($sql);

$books = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books[] = array(
            "id" => $row["id"],
            "title" => $row["title"],
            "author" => $row["author"]
        );
    }
}

// Close the connection
$conn->close();

// Send the book data as a JSON response
header("Content-Type: application/json");
echo json_encode(array("books" => $books));
?>
