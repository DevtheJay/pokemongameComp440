<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Users</title>
</head>
<body>
    <h1>Users</h1>
    <div class="container">
        <!-- Add New User Section -->
        <div class="box">
            <h2>Add a New User</h2>
            <form id="add-user-form" action="add_user.php" method="POST">
                <label for="nickname">Nickname:</label>
                <input type="text" id="nickname" name="nickname" required>
                
    <h1>Users</h1>
    <div class="container">
        <!-- Add New User Section -->
        <div class="box">
            <h2>Add a New User</h2>
            <form id="add-user-form" action="add_user.php" method="POST">
                <label for="nickname">Nickname:</label>
                <input type="text" id="nickname" name="nickname" required>
                
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
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
                
                <button type="submit" class="btn">Add User</button>
            </form>
        </div>

        <!-- Select and Delete User Section -->
        <div class="box">
            <h2>Select a User</h2>
            <select id="user-select" class="btn">
                <option value="">Select User</option>
                <?php
                $conn = new mysqli("localhost", "root", "", "game");
                $result = $conn->query("SELECT user_id, nickname FROM users");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['user_id']}'>{$row['nickname']}</option>";
                    }
                }
                $conn->close();
                ?>
            </select>
            <div id="user-data-container" style="margin-top: 20px;">
                <!-- User data will be dynamically loaded here -->
                <select id="gender" name="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
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
                
                <button type="submit" class="btn">Add User</button>
            </form>
        </div>

        <!-- Select and Delete User Section -->
        <div class="box">
            <h2>Select a User</h2>
            <select id="user-select" class="btn">
                <option value="">Select User</option>
                <?php
                $conn = new mysqli("localhost", "root", "", "game");
                $result = $conn->query("SELECT user_id, nickname FROM users");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['user_id']}'>{$row['nickname']}</option>";
                    }
                }
                $conn->close();
                ?>
            </select>
            <div id="user-data-container" style="margin-top: 20px;">
                <!-- User data will be dynamically loaded here -->
            </div>
        </div>

        <!-- Add Pokémon Section -->
        <div class="box">
            <h2>Add Pokémon to User</h2>
            <form id="add-pokemon-form" action="add_pokemon.php" method="POST">
                <label for="user_id">Select User:</label>
                <select id="user_id" name="user_id" required>
                    <?php
                    $conn = new mysqli("localhost", "root", "", "game");
                    $result = $conn->query("SELECT user_id, nickname FROM users");
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['user_id']}'>{$row['nickname']}</option>";
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
            <h2>Add Items to User</h2>
            <form id="add-item-form" action="add_item.php" method="POST">
                <label for="user_id">Select User:</label>
                <select id="user_id" name="user_id" required>
                    <?php
                    $conn = new mysqli("localhost", "root", "", "game");
                    $result = $conn->query("SELECT user_id, nickname FROM users");
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['user_id']}'>{$row['nickname']}</option>";
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

        <!-- Add Pokémon Section -->
        <div class="box">
            <h2>Add Pokémon to User</h2>
            <form id="add-pokemon-form" action="add_pokemon.php" method="POST">
                <label for="user_id">Select User:</label>
                <select id="user_id" name="user_id" required>
                    <?php
                    $conn = new mysqli("localhost", "root", "", "game");
                    $result = $conn->query("SELECT user_id, nickname FROM users");
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['user_id']}'>{$row['nickname']}</option>";
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
            <h2>Add Items to User</h2>
            <form id="add-item-form" action="add_item.php" method="POST">
                <label for="user_id">Select User:</label>
                <select id="user_id" name="user_id" required>
                    <?php
                    $conn = new mysqli("localhost", "root", "", "game");
                    $result = $conn->query("SELECT user_id, nickname FROM users");
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['user_id']}'>{$row['nickname']}</option>";
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
        const userSelect = document.getElementById('user-select');
        const userDataContainer = document.getElementById('user-data-container');

         // Fetch and display user data
         userSelect.addEventListener('change', function() {
            const userId = this.value;
            if (userId) {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', 'fetch_user_data.php?user_id=' + encodeURIComponent(userId), true);
                xhr.onload = function() {
                    if (this.status === 200) {
                        userDataContainer.innerHTML = this.responseText;

                        // Add dynamic Delete User button
                        const deleteButton = document.createElement('button');
                        deleteButton.textContent = 'Delete User';
                        deleteButton.className = 'btn';
                        deleteButton.style.marginTop = '10px';
                        deleteButton.onclick = function() {
                            deleteUser(userId);
                        };
                        userDataContainer.appendChild(deleteButton);
                    } else {
                        userDataContainer.innerHTML = '<p>Failed to load user data. Please try again.</p>';
                    }
                };
                xhr.send();
            } else {
                userDataContainer.innerHTML = ''; // Clear data if no user is selected
            }
        });

        // Delete User
        function deleteUser() {
            const userId = userSelect.value;
            if (userId && confirm('Are you sure you want to delete this user? This will also remove their Pokémon and items.')) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'delete_user.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (this.status === 200) {
                        alert('User deleted successfully!');
                        location.reload(); // Reload page to update data
                    } else {
                        alert('Failed to delete user. Please try again.');
                    }
                };
                xhr.send('user_id=' + encodeURIComponent(userId));
            }
        }

        // Delete Pokémon
        function deletePokemon(entityId) {
            if (confirm('Are you sure you want to delete this Pokémon?')) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'delete_pokemon.php', true);
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
        function deleteItem(itemId, userId) {
            if (confirm('Are you sure you want to delete this item?')) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'delete_item.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (this.status === 200) {
                        alert('Item deleted successfully!');
                        location.reload(); // Reload page to update data
                    } else {
                        alert('Failed to delete item. Please try again.');
                    }
                };
                xhr.send('item_id=' + encodeURIComponent(itemId) + '&user_id=' + encodeURIComponent(userId));
            }
        }
    </script>
    <a href="index.php" class="btn">Back to Home</a>

    <!-- JavaScript -->
    <script>
        const userSelect = document.getElementById('user-select');
        const userDataContainer = document.getElementById('user-data-container');

         // Fetch and display user data
         userSelect.addEventListener('change', function() {
            const userId = this.value;
            if (userId) {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', 'fetch_user_data.php?user_id=' + encodeURIComponent(userId), true);
                xhr.onload = function() {
                    if (this.status === 200) {
                        userDataContainer.innerHTML = this.responseText;

                        // Add dynamic Delete User button
                        const deleteButton = document.createElement('button');
                        deleteButton.textContent = 'Delete User';
                        deleteButton.className = 'btn';
                        deleteButton.style.marginTop = '10px';
                        deleteButton.onclick = function() {
                            deleteUser(userId);
                        };
                        userDataContainer.appendChild(deleteButton);
                    } else {
                        userDataContainer.innerHTML = '<p>Failed to load user data. Please try again.</p>';
                    }
                };
                xhr.send();
            } else {
                userDataContainer.innerHTML = ''; // Clear data if no user is selected
            }
        });

        // Delete User
        function deleteUser() {
            const userId = userSelect.value;
            if (userId && confirm('Are you sure you want to delete this user? This will also remove their Pokémon and items.')) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'delete_user.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (this.status === 200) {
                        alert('User deleted successfully!');
                        location.reload(); // Reload page to update data
                    } else {
                        alert('Failed to delete user. Please try again.');
                    }
                };
                xhr.send('user_id=' + encodeURIComponent(userId));
            }
        }

        // Delete Pokémon
        function deletePokemon(entityId) {
            if (confirm('Are you sure you want to delete this Pokémon?')) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'delete_pokemon.php', true);
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
        function deleteItem(itemId, userId) {
            if (confirm('Are you sure you want to delete this item?')) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'delete_item.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (this.status === 200) {
                        alert('Item deleted successfully!');
                        location.reload(); // Reload page to update data
                    } else {
                        alert('Failed to delete item. Please try again.');
                    }
                };
                xhr.send('item_id=' + encodeURIComponent(itemId) + '&user_id=' + encodeURIComponent(userId));
            }
        }
    </script>
</body>
</html>
