<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $npcId = intval($_POST['npc_id']);
    $itemId = intval($_POST['item_id']);
    $quantity = intval($_POST['quantity']);

    $conn = new mysqli("localhost", "root", "", "game");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the NPC already has the item
    $stmtCheck = $conn->prepare("SELECT quantity FROM npc_inventory WHERE npc_id = ? AND item_id = ?");
    $stmtCheck->bind_param("ii", $npcId, $itemId);
    $stmtCheck->execute();
    $result = $stmtCheck->get_result();

    if ($result->num_rows > 0) {
        // Update quantity if item exists
        $row = $result->fetch_assoc();
        $newQuantity = min(10, $row['quantity'] + $quantity); // Limit quantity to 10
        $stmtUpdate = $conn->prepare("UPDATE npc_inventory SET quantity = ? WHERE npc_id = ? AND item_id = ?");
        $stmtUpdate->bind_param("iii", $newQuantity, $npcId, $itemId);

        if ($stmtUpdate->execute()) {
            echo "Item quantity updated successfully!";
        } else {
            echo "Error: " . $stmtUpdate->error;
        }
        $stmtUpdate->close();
    } else {
        // Insert new item
        $stmtInsert = $conn->prepare("INSERT INTO npc_inventory (npc_id, item_id, quantity) VALUES (?, ?, ?)");
        $stmtInsert->bind_param("iii", $npcId, $itemId, $quantity);

        if ($stmtInsert->execute()) {
            echo "Item added successfully!";
        } else {
            echo "Error: " . $stmtInsert->error;
        }
        $stmtInsert->close();
    }

    $stmtCheck->close();
    $conn->close();
    header("Location: NPCS.php");
    exit();
}
?>
