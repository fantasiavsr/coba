<?php

// Get the form data
$id = $_POST['id'];


// Perform the database update
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

// Get the books_id from borrowedbooks table
$stmtSelect = $conn->prepare("SELECT books_id FROM borrowedbooks WHERE id = ?");
$stmtSelect->bind_param("i", $id);
$stmtSelect->execute();
$stmtSelect->bind_result($booksId);
$stmtSelect->fetch();
$stmtSelect->close();

// Prepare the SQL statement to delete from borrowedbooks table
$stmtDelete = $conn->prepare("DELETE FROM borrowedbooks WHERE id = ?");
$stmtDelete->bind_param("i", $id);

// Execute the delete statement
if ($stmtDelete->execute()) {
    

    // Update the available status in books table
    $stmtUpdate = $conn->prepare("UPDATE books SET available = 1 WHERE id = ?");
    $stmtUpdate->bind_param("i", $booksId);

    // Execute the update statement
    if ($stmtUpdate->execute()) {
        // If the update is successful
        $response = array("success" => true);
    } else {
        // If the update fails
        $response = array("success" => false);
    }

    // Close the update statement
    $stmtUpdate->close();
} else {
    // If the deletion fails
    $response = array("success" => false);
}

// Close the delete statement and the connection
$stmtDelete->close();
$conn->close();

// Send the response back to the client
header("Content-Type: application/json");
echo json_encode($response);
?>
