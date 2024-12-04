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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']);

    // Delete the user's Pokémon inventory
    $deletePokemon = $conn->query("DELETE FROM user_pokemon_inventory 
                                   WHERE user_id = $user_id");

    // Delete the user's item inventory
    $deleteItems = $conn->query("DELETE FROM user_inventory 
                                WHERE user_id = $user_id");

    // Delete the user
    $deleteUser = $conn->query("DELETE FROM users 
                                WHERE user_id = $user_id");

    if ($deletePokemon && $deleteItems && $deleteUser) {
        echo "User and associated data deleted successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
