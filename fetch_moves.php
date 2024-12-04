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

// Get the filter parameter
$type = isset($_GET['type']) ? $_GET['type'] : '';

// Query the database with filtering
$sql = "SELECT move_id, move_name, move_damage, move_accuracy, move_type FROM moves";

if (!empty($type)) {
    $sql .= " WHERE move_type = '$type'";
}

$result = $conn->query($sql);

// Generate the table if there are results
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Damage</th>
                <th>Accuracy</th>
                <th>Type</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['move_id']}</td>
                <td>{$row['move_name']}</td>
                <td>{$row['move_damage']}</td>
                <td>{$row['move_accuracy']}</td>
                <td>{$row['move_type']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No moves found for the selected type.</p>";
}

$conn->close();
?>
