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

// Get the npc ID
$npc_id = isset($_GET['npc_id']) ? intval($_GET['npc_id']) : 0;

if ($npc_id) {
    // Fetch npc details
    $sql_npc = "SELECT n.npc_name, n.occupation, l.location_name FROM NPCS n INNER JOIN location l ON n.location_id = l.location_id WHERE n.npc_id = $npc_id";
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

    // Fetch npc's Pokémon
    $sql_pokemon = "SELECT up.entity_id, up.pokemon_nickname, p.pokemon_name, p.pokemon_type_1, p.pokemon_type_2, up.pokemon_lvl FROM npc_pokemon_inventory up INNER JOIN pokedex p ON up.pokemon_id = p.pokemon_id WHERE up.npc_id = $npc_id";
    $result_pokemon = $conn->query($sql_pokemon);

    echo "<h2>Pokémon</h2>";
    if ($result_pokemon->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Nickname</th>
                    <th>Pokemon Name</th>
                    <th>Type 1</th>
                    <th>Type 2</th>
                    <th>Level</th>
                    <th>Action</th>
                </tr>";
        while ($row = $result_pokemon->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['pokemon_nickname']}</td>
                    <td>{$row['pokemon_name']}</td>
                    <td>{$row['pokemon_type_1']}</td>
                    <td>{$row['pokemon_type_2']}</td>
                    <td>{$row['pokemon_lvl']}</td>
                    <td><button onclick='deletePokemon({$row['entity_id']})'>Delete Pokémon</button></td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No Pokémon found for this npc.</p>";
    }

    // Fetch npc's items
    $sql_items = "SELECT ui.item_id, i.item_name, ui.quantity FROM npc_inventory ui INNER JOIN items i ON ui.item_id = i.item_id WHERE ui.npc_id = $npc_id";
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
        echo "<p>No items found for this npc.</p>";
    }
} else {
    echo "<p>Invalid npc ID.</p>";
}

$conn->close();
?>
