<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>NPCS</title>
</head>
<body>
    <h1>NPCS</h1>
    <div class="container">
        <!-- Add New NPC Section -->
        <div class="box">
            <h2>Add a New NPC</h2>
            <form id="add-npc-form" action="add_npc.php" method="POST">
                <label for="npc_name">Nickname:</label>
                <input type="text" id="npc_name" name="npc_name" required>
                
                <label for="occupation">Occupation:</label>
                <select id="occupation" name="occupation" required>
                    <option value="Nurse">Nurse</option>
                    <option value="Trainer">Trainer</option>
                    <option value="Gym Leader">Gym Leader</option>
                    <option value="Merchant">Merchant</option>
                </select>
                
                <label for="location_id">Location:</label>
                <select id="location_id" name="location_id" required>
                    <?php
                    $conn = new mysqli("localhost", "root", "", "game");
                    $result = $conn->query("SELECT location_id, location_name FROM location");
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['location_id']}'>{$row['location_name']}</option>";
                        }
                    }
                    $conn->close();
                    ?>
                </select>
                
                <button type="submit" class="btn">Add NPC</button>
            </form>
        </div>

        <!-- Select and Delete NPC Section -->
        <div class="box">
            <h2>Select a NPC</h2>
            <select id="npc-select" class="btn">
                <option value="">Select NPC</option>
                <?php
                $conn = new mysqli("localhost", "root", "", "game");
                $result = $conn->query("SELECT npc_id, npc_name FROM NPCS");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['npc_id']}'>{$row['npc_name']}</option>";
                    }
                }
                $conn->close();
                ?>
            </select>
            <div id="npc-data-container" style="margin-top: 20px;">
                <!-- NPC data will be dynamically loaded here -->
            </div>
        </div>

        <!-- Add Pokémon Section -->
        <div class="box">
            <h2>Add Pokémon to NPC</h2>
            <form id="add-pokemon-form" action="add_npc_pokemon.php" method="POST">
                <label for="npc_id">Select NPC:</label>
                <select id="npc_id" name="npc_id" required>
                    <?php
                    $conn = new mysqli("localhost", "root", "", "game");
                    $result = $conn->query("SELECT npc_id, npc_name FROM NPCS");
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['npc_id']}'>{$row['npc_name']}</option>";
                        }
                    }
                    $conn->close();
                    ?>
                </select>

                <label for="pokemon_id">Select Pokémon:</label>
                <select id="pokemon_id" name="pokemon_id" required>
                    <?php
                    $conn = new mysqli("localhost", "root", "", "game");
                    $result = $conn->query("SELECT pokemon_id, pokemon_name FROM pokedex");
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['pokemon_id']}'>{$row['pokemon_name']}</option>";
                        }
                    }
                    $conn->close();
                    ?>
                </select>

                <label for="nickname">Nickname (Optional):</label>
                <input type="text" id="nickname" name="nickname">

                <label for="pokemon_lvl">Level:</label>
                <input type="number" id="pokemon_lvl" name="pokemon_lvl" min="1" max="100" required>

                <button type="submit" class="btn">Add Pokémon</button>
            </form>
        </div>

        <!-- Add Items Section -->
        <div class="box">
            <h2>Add Items to NPC</h2>
            <form id="add-item-form" action="add_npc_item.php" method="POST">
                <label for="npc_id">Select NPC:</label>
                <select id="npc_id" name="npc_id" required>
                    <?php
                    $conn = new mysqli("localhost", "root", "", "game");
                    $result = $conn->query("SELECT npc_id, npc_name FROM NPCS");
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['npc_id']}'>{$row['npc_name']}</option>";
                        }
                    }
                    $conn->close();
                    ?>
                </select>

                <label for="item_id">Select Item:</label>
                <select id="item_id" name="item_id" required>
                    <?php
                    $conn = new mysqli("localhost", "root", "", "game");
                    $result = $conn->query("SELECT item_id, item_name FROM items");
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['item_id']}'>{$row['item_name']}</option>";
                        }
                    }
                    $conn->close();
                    ?>
                </select>

                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" min="1" max="10" required>

                <button type="submit" class="btn">Add Item</button>
            </form>
        </div>
    </div>
    <a href="index.php" class="btn">Back to Home</a>

    <!-- JavaScript -->
    <script>
        const npcSelect = document.getElementById('npc-select');
        const npcDataContainer = document.getElementById('npc-data-container');

         // Fetch and display npc data
         npcSelect.addEventListener('change', function() {
            const npcId = this.value;
            if (npcId) {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', 'fetch_npc_data.php?npc_id=' + encodeURIComponent(npcId), true);
                xhr.onload = function() {
                    if (this.status === 200) {
                        npcDataContainer.innerHTML = this.responseText;

                        // Add dynamic Delete npc button
                        const deleteButton = document.createElement('button');
                        deleteButton.textContent = 'Delete NPC';
                        deleteButton.className = 'btn';
                        deleteButton.style.marginTop = '10px';
                        deleteButton.onclick = function() {
                            deletenpc(npcId);
                        };
                        npcDataContainer.appendChild(deleteButton);
                    } else {
                        npcDataContainer.innerHTML = '<p>Failed to load NPC data. Please try again.</p>';
                    }
                };
                xhr.send();
            } else {
                npcDataContainer.innerHTML = ''; // Clear data if no NPC is selected
            }
        });

        // Delete NPC
        function deletenpc() {
            const npcId = npcSelect.value;
            if (npcId && confirm('Are you sure you want to delete this NPC? This will also remove their Pokémon and items.')) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'delete_npc.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (this.status === 200) {
                        alert('NPC deleted successfully!');
                        location.reload(); // Reload page to update data
                    } else {
                        alert('Failed to delete NPC. Please try again.');
                    }
                };
                xhr.send('npc_id=' + encodeURIComponent(npcId));
            }
        }

        // Delete Pokémon
        function deletePokemon(entityId) {
            if (confirm('Are you sure you want to delete this Pokémon?')) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'delete_npc_pokemon.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (this.status === 200) {
                        alert('Pokémon deleted successfully!');
                        location.reload(); // Reload page to update data
                    } else {
                        alert('Failed to delete Pokémon. Please try again.');
                    }
                };
                xhr.send('entity_id=' + encodeURIComponent(entityId));
            }
        }

        // Delete Item
        function deleteItem(itemId, npcId) {
            if (confirm('Are you sure you want to delete this item?')) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'delete_npc_item.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (this.status === 200) {
                        alert('Item deleted successfully!');
                        location.reload(); // Reload page to update data
                    } else {
                        alert('Failed to delete item. Please try again.');
                    }
                };
                xhr.send('item_id=' + encodeURIComponent(itemId) + '&npc_id=' + encodeURIComponent(npcId));
            }
        }
    </script>
</body>
</html>
