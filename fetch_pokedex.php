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
$sql = "SELECT pokemon_id, pokemon_name, pokemon_type_1, pokemon_type_2, evolution_lvl FROM pokedex";

if (!empty($type)) {
    $sql .= " WHERE pokemon_type_1 = '$type' OR pokemon_type_2 = '$type'";
}

$result = $conn->query($sql);

// Generate the table if there are results
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Type 1</th>
                <th>Type 2</th>
                <th>Evolution Level</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['pokemon_id']}</td>
                <td>{$row['pokemon_name']}</td>
                <td>{$row['pokemon_type_1']}</td>
                <td>{$row['pokemon_type_2']}</td>
                <td>{$row['evolution_lvl']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No Pokémon found for the selected type.</p>";
}

$conn->close();
?>
