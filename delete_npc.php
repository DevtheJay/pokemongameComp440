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

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['npc_id'])) {
    $npc_id = intval($_POST['npc_id']);

    // Delete the npc's Pokémon inventory
    $deletePokemon = $conn->query("DELETE FROM npc_pokemon_inventory WHERE npc_id = $npc_id");

    // Delete the npc's item inventory
    $deleteItems = $conn->query("DELETE FROM npc_inventory WHERE npc_id = $npc_id");

    // Delete the npc
    $deletenpc = $conn->query("DELETE FROM NPCS WHERE npc_id = $npc_id");

    if ($deletePokemon && $deleteItems && $deletenpc) {
        echo "npc and associated data deleted successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
