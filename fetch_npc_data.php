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

// Get the NPC ID
$npc_id = isset($_GET['npc_id']) ? intval($_GET['npc_id']) : 0;

if ($npc_id) {
    // Fetch NPC's Pokémon with moves
    $sql_pokemon = "
        SELECT 
            pi.pokemon_nickname, 
            p.pokemon_name, 
            p.pokemon_type_1, 
            p.pokemon_type_2, 
            pi.pokemon_lvl,
            m1.move_name AS move_1,
            m2.move_name AS move_2,
            m3.move_name AS move_3,
            m4.move_name AS move_4
        FROM npc_pokemon_inventory pi
        INNER JOIN pokedex p ON pi.pokemon_id = p.pokemon_id
        LEFT JOIN moves m1 ON pi.pokemon_moves_1 = m1.move_id
        LEFT JOIN moves m2 ON pi.pokemon_moves_2 = m2.move_id
        LEFT JOIN moves m3 ON pi.pokemon_moves_3 = m3.move_id
        LEFT JOIN moves m4 ON pi.pokemon_moves_4 = m4.move_id
        WHERE pi.npc_id = $npc_id";
    $result_pokemon = $conn->query($sql_pokemon);

    echo "<h2>Pokémon</h2>";
    if ($result_pokemon->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Nickname</th>
                    <th>Name</th>
                    <th>Type 1</th>
                    <th>Type 2</th>
                    <th>Level</th>
                    <th>Move 1</th>
                    <th>Move 2</th>
                    <th>Move 3</th>
                    <th>Move 4</th>
                </tr>";
        while ($row = $result_pokemon->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['pokemon_nickname']}</td>
                    <td>{$row['pokemon_name']}</td>
                    <td>{$row['pokemon_type_1']}</td>
                    <td>{$row['pokemon_type_2']}</td>
                    <td>{$row['pokemon_lvl']}</td>
                    <td>{$row['move_1']}</td>
                    <td>{$row['move_2']}</td>
                    <td>{$row['move_3']}</td>
                    <td>{$row['move_4']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No Pokémon found for this NPC.</p>";
    }

    // Fetch NPC's items
    $sql_items = "
        SELECT i.item_name, ni.quantity
        FROM npc_inventory ni
        INNER JOIN items i ON ni.item_id = i.item_id
        WHERE ni.npc_id = $npc_id";
    $result_items = $conn->query($sql_items);

    echo "<h2>Items</h2>";
    if ($result_items->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                </tr>";
        while ($row = $result_items->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['item_name']}</td>
                    <td>{$row['quantity']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No items found for this NPC.</p>";
    }
} else {
    echo "<p>Invalid NPC ID.</p>";
}

$conn->close();
?>
