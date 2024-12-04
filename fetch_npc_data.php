<?php
if (isset($_GET['npc_id'])) {
    $npcId = intval($_GET['npc_id']);
    $conn = new mysqli("localhost", "root", "", "game");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch NPC Details
    $npcQuery = $conn->prepare("SELECT npc_name, occupation FROM NPCS WHERE npc_id = ?");
    $npcQuery->bind_param("i", $npcId);
    $npcQuery->execute();
    $npcResult = $npcQuery->get_result()->fetch_assoc();

    echo "<h3>Details</h3>";
    echo "<p><strong>Name:</strong> " . htmlspecialchars($npcResult['npc_name']) . "</p>";
    echo "<p><strong>Occupation:</strong> " . htmlspecialchars($npcResult['occupation']) . "</p>";

    // Fetch NPC Pokémon
    echo "<h3>Pokémon</h3>";
    $pokemonQuery = $conn->prepare("
        SELECT entity_id, pokemon_nickname, pokemon_lvl, pokemon_health, pokemon_status 
        FROM npc_pokemon_inventory 
        WHERE npc_id = ?
    ");
    $pokemonQuery->bind_param("i", $npcId);
    $pokemonQuery->execute();
    $pokemonResult = $pokemonQuery->get_result();

    echo "<table>";
    echo "<tr><th>Nickname</th><th>Level</th><th>Health</th><th>Status</th><th>Actions</th></tr>";
    while ($pokemon = $pokemonResult->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($pokemon['pokemon_nickname']) . "</td>";
        echo "<td>" . htmlspecialchars($pokemon['pokemon_lvl']) . "</td>";
        echo "<td>" . htmlspecialchars($pokemon['pokemon_health']) . "</td>";
        echo "<td>" . htmlspecialchars($pokemon['pokemon_status']) . "</td>";
        echo "<td>
                <button onclick='deletePokemon(" . $pokemon['entity_id'] . ")'>Delete</button>
              </td>";
        echo "</tr>";
    }
    echo "</table>";

    // Fetch NPC Items
    echo "<h3>Items</h3>";
    $itemQuery = $conn->prepare("
        SELECT items.item_name, npc_inventory.quantity, items.item_id 
        FROM npc_inventory 
        JOIN items ON npc_inventory.item_id = items.item_id 
        WHERE npc_inventory.npc_id = ?
    ");
    $itemQuery->bind_param("i", $npcId);
    $itemQuery->execute();
    $itemResult = $itemQuery->get_result();

    echo "<table>";
    echo "<tr><th>Item</th><th>Quantity</th><th>Actions</th></tr>";
    while ($item = $itemResult->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($item['item_name']) . "</td>";
        echo "<td>" . htmlspecialchars($item['quantity']) . "</td>";
        echo "<td>
                <button onclick='deleteItem(" . $item['item_id'] . ", $npcId)'>Delete</button>
              </td>";
        echo "</tr>";
    }
    echo "</table>";

    $conn->close();
}
?>
