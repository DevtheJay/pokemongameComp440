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

// Get the filter parameter
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

// Base SQL query for inventory
$sql = "";

if ($filter === 'users') {
    // Fetch user inventory sorted alphabetically by owner name
    $sql = "
        SELECT i.item_name, ui.quantity, u.nickname AS owner
        FROM user_inventory ui
        INNER JOIN items i ON ui.item_id = i.item_id
        INNER JOIN users u ON ui.user_id = u.user_id
        ORDER BY u.nickname ASC";
} elseif ($filter === 'npcs') {
    // Fetch NPC inventory sorted alphabetically by owner name
    $sql = "
        SELECT i.item_name, ni.quantity, n.npc_name AS owner
        FROM npc_inventory ni
        INNER JOIN items i ON ni.item_id = i.item_id
        INNER JOIN NPCS n ON ni.npc_id = n.npc_id
        ORDER BY n.npc_name ASC";
} elseif ($filter === 'all') {
    // Fetch all inventory sorted alphabetically by owner name, separating users and NPCs
    $sql = "
        SELECT i.item_name, ui.quantity, u.nickname AS owner, 'User' AS entity_type
        FROM user_inventory ui
        INNER JOIN items i ON ui.item_id = i.item_id
        INNER JOIN users u ON ui.user_id = u.user_id
        UNION ALL
        SELECT i.item_name, ni.quantity, n.npc_name AS owner, 'NPC' AS entity_type
        FROM npc_inventory ni
        INNER JOIN items i ON ni.item_id = i.item_id
        INNER JOIN NPCS n ON ni.npc_id = n.npc_id
        ORDER BY owner ASC";
}

$result = $conn->query($sql);

// Generate the table if there are results
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Owner</th>";
    if ($filter === 'all') {
        echo "<th>Entity Type</th>";
    }
    echo "</tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['item_name']}</td>
                <td>{$row['quantity']}</td>
                <td>{$row['owner']}</td>";
        if ($filter === 'all') {
            echo "<td>{$row['entity_type']}</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No inventory data found.</p>";
}

$conn->close();
?>
