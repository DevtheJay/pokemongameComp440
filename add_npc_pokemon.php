<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $npcId = intval($_POST['npc_id']);
    $pokemonId = intval($_POST['pokemon_id']);
    $pokemonLvl = intval($_POST['pokemon_lvl']);

    $conn = new mysqli("localhost", "root", "", "game");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert Pokémon into NPC Pokémon inventory
    $stmt = $conn->prepare("INSERT INTO npc_pokemon_inventory (npc_id, pokemon_id, pokemon_lvl, pokemon_health, pokemon_status) VALUES (?, ?, ?, ?, 'Healthy')");
    $pokemonHealth = 100 + ($pokemonLvl * 10); // Example calculation for Pokémon health
    $stmt->bind_param("iiii", $npcId, $pokemonId, $pokemonLvl, $pokemonHealth);

    if ($stmt->execute()) {
        echo "Pokémon added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    header("Location: NPCS.php");
    exit();
}
?>
