<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "game";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check for POST data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $npc_name = $conn->real_escape_string($_POST['npc_name']);
    $occupation = $conn->real_escape_string($_POST['occupation']);
    $location_id = intval($_POST['location_id']);

    // Insert new user into the database
    $sql = "INSERT INTO NPCS (npc_name, occupation, location_id) VALUES ('$npc_name', '$occupation', $location_id)";
    if ($conn->query($sql) === TRUE) {
        // Redirect back to the users page
        header("Location: NPCS.php");
        exit();
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}

$conn->close();
?>
