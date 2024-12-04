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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_POST['user_id']);
    $pokemon_id = intval($_POST['pokemon_id']);
    $nickname = $conn->real_escape_string($_POST['nickname']);
    $pokemon_lvl = intval($_POST['pokemon_lvl']);

    // Fetch Pokémon's type(s)
    $sql = "SELECT pokemon_type_1, pokemon_type_2 FROM pokedex WHERE pokemon_id = $pokemon_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $type1 = $row['pokemon_type_1'];
        $type2 = $row['pokemon_type_2'];

        // Fetch moves matching the Pokémon's type(s) or "Normal"
        $moveQuery = "
            SELECT move_id FROM moves
            WHERE move_type IN ('$type1', '$type2', 'Normal')
            ORDER BY RAND() LIMIT 4";
        $moveResult = $conn->query($moveQuery);

        $moves = [];
        while ($move = $moveResult->fetch_assoc()) {
            $moves[] = $move['move_id'];
        }

        // Ensure 4 slots (fill empty slots with NULL)
        for ($i = count($moves); $i < 4; $i++) {
            $moves[] = null;
        }

        // Insert into user_pokemon_inventory
        $sqlInsert = "
            INSERT INTO user_pokemon_inventory (
                user_id, pokemon_id, pokemon_nickname, pokemon_lvl, 
                pokemon_moves_1, pokemon_moves_2, pokemon_moves_3, pokemon_moves_4
            ) VALUES (
                $user_id, $pokemon_id, 
                '" . ($nickname ?: "NULL") . "', 
                $pokemon_lvl, 
                " . ($moves[0] ?: "NULL") . ", 
                " . ($moves[1] ?: "NULL") . ", 
                " . ($moves[2] ?: "NULL") . ", 
                " . ($moves[3] ?: "NULL") . "
            )";

        if ($conn->query($sqlInsert) === TRUE) {
            // Redirect to the users page
            header("Location: user.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

$conn->close();
?>
