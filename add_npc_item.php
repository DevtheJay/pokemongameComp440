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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $npc_id = intval($_POST['npc_id']);
    $item_id = intval($_POST['item_id']);
    $quantity = intval($_POST['quantity']);

    // Check if the item already exists in the npc's inventory
    $sql = "SELECT quantity FROM npc_inventory WHERE npc_id = $npc_id AND item_id = $item_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Update the existing quantity
        $row = $result->fetch_assoc();
        $new_quantity = $row['quantity'] + $quantity;

        // Ensure the total quantity does not exceed 10
        if ($new_quantity > 10) {
            $new_quantity = 10;
        }

        $sql_update = "UPDATE npc_inventory SET quantity = $new_quantity WHERE npc_id = $npc_id AND item_id = $item_id";
        if ($conn->query($sql_update) === TRUE) {
            header("Location: NPCS.php");
            exit();
        } else {
            echo "Error updating inventory: " . $conn->error;
        }
    } else {
        // Insert a new row if the item doesn't already exist in the inventory
        $sql_insert = "INSERT INTO npc_inventory (npc_id, item_id, quantity) VALUES ($npc_id, $item_id, $quantity)";
        if ($conn->query($sql_insert) === TRUE) {
            header("Location: NPCS.php");
            exit();
        } else {
            echo "Error adding item: " . $conn->error;
        }
    }
}

$conn->close();
?>
