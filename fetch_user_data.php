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

// Get the user ID
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

if ($user_id) {
    // Fetch basic user details including location
    $sql_user = "
        SELECT u.nickname, u.gender, l.location_name
        FROM users u
        INNER JOIN location l ON u.location_id = l.location_id
        WHERE u.user_id = $user_id
    ";
    $result_user = $conn->query($sql_user);

    if ($result_user->num_rows > 0) {
        $user = $result_user->fetch_assoc();
        echo "<h2>User Details</h2>";
        echo "<p><strong>Nickname:</strong> {$user['nickname']}</p>";
        echo "<p><strong>Gender:</strong> {$user['gender']}</p>";
        echo "<p><strong>Location:</strong> {$user['location_name']}</p>";

        // Fetches user's Pokémon, their types, and moves
        $sql_pokemon = "
            SELECT 
                up.entity_id,
                up.pokemon_nickname, 
                p.pokemon_name, 
                p.pokemon_type_1, 
                p.pokemon_type_2,
                m1.move_name AS move_1, 
                m2.move_name AS move_2, 
                m3.move_name AS move_3, 
                m4.move_name AS move_4
            FROM user_pokemon_inventory up
            INNER JOIN pokedex p ON up.pokemon_id = p.pokemon_id
            LEFT JOIN moves m1 ON up.pokemon_moves_1 = m1.move_id
            LEFT JOIN moves m2 ON up.pokemon_moves_2 = m2.move_id
            LEFT JOIN moves m3 ON up.pokemon_moves_3 = m3.move_id
            LEFT JOIN moves m4 ON up.pokemon_moves_4 = m4.move_id
            WHERE up.user_id = $user_id
        ";
        $result_pokemon = $conn->query($sql_pokemon);

        echo "<h2>Pokémon and Their Moves</h2>";
        if ($result_pokemon->num_rows > 0) {
            echo "<table border='1'>
                    <tr>
                        <th>Nickname</th>
                        <th>Pokémon Name</th>
                        <th>Type 1</th>
                        <th>Type 2</th>
                        <th>Move 1</th>
                        <th>Move 2</th>
                        <th>Move 3</th>
                        <th>Move 4</th>
                        <th>Action</th>
                    </tr>";
            while ($row = $result_pokemon->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['pokemon_nickname']}</td>
                        <td>{$row['pokemon_name']}</td>
                        <td>{$row['pokemon_type_1']}</td>
                        <td>" . ($row['pokemon_type_2'] ?: 'None') . "</td>
                        <td>" . ($row['move_1'] ?: 'None') . "</td>
                        <td>" . ($row['move_2'] ?: 'None') . "</td>
                        <td>" . ($row['move_3'] ?: 'None') . "</td>
                        <td>" . ($row['move_4'] ?: 'None') . "</td>
                        <td><button onclick='deletePokemon({$row['entity_id']})'>Delete Pokémon</button></td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No Pokémon found for this user.</p>";
        }

        // Fetch user's items
        $sql_items = "
            SELECT ui.item_id, i.item_name, ui.quantity
            FROM user_inventory ui
            INNER JOIN items i ON ui.item_id = i.item_id
            WHERE ui.user_id = $user_id
        ";
        $result_items = $conn->query($sql_items);

        echo "<h2>User Items</h2>";
        if ($result_items->num_rows > 0) {
            echo "<table border='1'>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>";
            while ($row = $result_items->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['item_name']}</td>
                        <td>{$row['quantity']}</td>
                        <td><button onclick='deleteItem({$row['item_id']}, $user_id)'>Delete Item</button></td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No items found for this user.</p>";
        }
    } else {
        echo "<p>User not found.</p>";
    }
} else {
    echo "<p>Invalid user ID.</p>";
}

$conn->close();
?>
