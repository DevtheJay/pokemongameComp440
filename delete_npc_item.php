<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "game";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id']) && isset($_POST['npc_id'])) {
    $item_id = intval($_POST['item_id']);
    $npc_id = intval($_POST['npc_id']);

    $sql = "DELETE FROM npc_inventory WHERE item_id = $item_id AND npc_id = $npc_id";
    if ($conn->query($sql) === TRUE) {
        echo "Item deleted successfully.";
    } else {
        echo "Error deleting item: " . $conn->error;
    }
}

$conn->close();
?>
