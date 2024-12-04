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

// Fetch all NPCs
$sql = "SELECT npc_id, npc_name, occupation FROM NPCS";
$result = $conn->query($sql);

$npcs = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $npcs[] = $row;
    }
}
echo json_encode($npcs);

$conn->close();
?>
