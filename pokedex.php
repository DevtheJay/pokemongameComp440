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

// Query the database
$sql = "SELECT pokemon_id, pokemon_name, pokemon_type_1, pokemon_type_2, evolution_lvl FROM pokedex";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Pokédex</title>
</head>
<body>
<h1>Pokédex</h1>
    <div class="container">
        
        <?php
        if ($result->num_rows > 0) {
            echo "<table border='1'>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Type 1</th>
                        <th>Type 2</th>
                        <th>Evolution Level</th>
                    </tr>";
            // Output data of each row
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
            echo "<p>No Pokémon found in the database.</p>";
        }
        ?>
    </div>
    <a href="index.php" class="btn">Back to Home</a>
</body>
</html>
<?php
$conn->close();
?>