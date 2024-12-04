<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "game";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['entity_id'])) {
    $entity_id = intval($_POST['entity_id']);

    $sql = "DELETE FROM user_pokemon_inventory WHERE entity_id = $entity_id";
    if ($conn->query($sql) === TRUE) {
        echo "Pokémon deleted successfully.";
    } else {
        echo "Error deleting Pokémon: " . $conn->error;
    }
}

$conn->close();
?>
