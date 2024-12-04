<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $npcName = $_POST['npc_name'];
    $occupation = $_POST['occupation'];
    $locationId = intval($_POST['location_id']);

    $conn = new mysqli("localhost", "root", "", "game");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO NPCS (npc_name, occupation, location_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $npcName, $occupation, $locationId);

    if ($stmt->execute()) {
        echo "NPC added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    header("Location: NPCS.php");
    exit();
}
?>
