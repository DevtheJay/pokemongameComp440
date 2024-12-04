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
    // Fetch NPC details
    $sql_npc = "
        SELECT n.npc_name, n.occupation, l.location_name 
        FROM npcs n 
        INNER JOIN location l ON n.location_id = l.location_id 
        WHERE n.npc_id = $npc_id
    ";
    $result_npc = $conn->query($sql_npc);

    if ($result_npc->num_rows > 0) {
        $npc = $result_npc->fetch_assoc();
        echo "<h2>NPC Details</h2>";
        echo "<p><strong>NPC Name:</strong> {$npc['npc_name']}</p>";
        echo "<p><strong>Occupation:</strong> {$npc['occupation']}</p>";
        echo "<p><strong>Location:</strong> {$npc['location_name']}</p>";
    } else {
        echo "<p>NPC not found.</p>";
    }

    // Fetch NPC's Pokémon
    $sql_pokemon = "
        SELECT 
            up.entity_id,
            up.pokemon_nickname,
            p.pokemon_name,
            p.pokemon_type_1,
            p.pokemon_type_2,
            m1.move_name AS move_1,
            m2.move_name AS move_2,
            m3.move_name AS move_3,
            m4.move_name AS move_4
        FROM npc_pokemon_inventory up
        INNER JOIN pokedex p ON up.pokemon_id = p.pokemon_id
        LEFT JOIN moves m1 ON up.pokemon_moves_1 = m1.move_id
        LEFT JOIN moves m2 ON up.pokemon_moves_2 = m2.move_id
        LEFT JOIN moves m3 ON up.pokemon_moves_3 = m3.move_id
        LEFT JOIN moves m4 ON up.pokemon_moves_4 = m4.move_id
        WHERE up.npc_id = $npc_id
    ";
    $result_pokemon = $conn->query($sql_pokemon);

    echo "<h2>Pokémon and Their Moves</h2>";
    if ($result_pokemon->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Nickname</th>
                    <th>Pokémon Name</th>
                    <th>Type 1</th>
                    <th>Type 2</th>
                    <th>Move 1</th>
                    <th>Move 2</th>
                    <th>Move 3</th>
                    <th>Move 4</th>
                    <th>Action</th>
                </tr>";
        while ($row = $result_pokemon->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['pokemon_nickname']}</td>
                    <td>{$row['pokemon_name']}</td>
                    <td>{$row['pokemon_type_1']}</td>
                    <td>" . ($row['pokemon_type_2'] ?: 'None') . "</td>
                    <td>" . ($row['move_1'] ?: 'None') . "</td>
                    <td>" . ($row['move_2'] ?: 'None') . "</td>
                    <td>" . ($row['move_3'] ?: 'None') . "</td>
                    <td>" . ($row['move_4'] ?: 'None') . "</td>
                    <td><button onclick='deletePokemon({$row['entity_id']})'>Delete Pokémon</button></td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No Pokémon found for this NPC.</p>";
    }

    // Fetch NPC's items
    $sql_items = "
        SELECT ui.item_id, i.item_name, ui.quantity 
        FROM npc_inventory ui 
        INNER JOIN items i ON ui.item_id = i.item_id 
        WHERE ui.npc_id = $npc_id
    ";
    $result_items = $conn->query($sql_items);

    echo "<h2>Items</h2>";
    if ($result_items->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>";
        while ($row = $result_items->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['item_name']}</td>
                    <td>{$row['quantity']}</td>
                    <td><button onclick='deleteItem({$row['item_id']}, $npc_id)'>Delete Item</button></td>
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
