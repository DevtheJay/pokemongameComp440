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
        <div class="box">
            <!-- Dropdown for selecting a user -->
            <label for="user-select">Select a User:</label>
            <select id="user-select" class="btn">
                <option value="">Select User</option>
                <!-- Dynamic user options will be loaded here -->
            </select>

            <!-- Container for user data -->
            <div id="user-data-container" style="margin-top: 20px;"></div>
        </div>
    </div>
    <a href="index.php" class="btn">Back to Home</a>

    <!-- JavaScript for fetching and displaying user data -->
    <script>
        const userSelect = document.getElementById('user-select');
        const userDataContainer = document.getElementById('user-data-container');

        // Fetch users and populate the dropdown
        function loadUsers() {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_users.php', true);
            xhr.onload = function() {
                if (this.status === 200) {
                    const users = JSON.parse(this.responseText);
                    users.forEach(user => {
                        const option = document.createElement('option');
                        option.value = user.user_id;
                        option.textContent = `${user.nickname} (${user.gender})`;
                        userSelect.appendChild(option);
                    });
                } else {
                    alert('Failed to load users.');
                }
            };
            xhr.send();
        }

        // Fetch and display user data (Pokémon and items)
        userSelect.addEventListener('change', function() {
            const userId = this.value;
            if (userId) {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', 'fetch_user_data.php?user_id=' + encodeURIComponent(userId), true);
                xhr.onload = function() {
                    if (this.status === 200) {
                        userDataContainer.innerHTML = this.responseText;
                    } else {
                        userDataContainer.innerHTML = '<p>Failed to load user data. Please try again.</p>';
                    }
                };
                xhr.send();
            } else {
                userDataContainer.innerHTML = ''; // Clear data if no user is selected
            }
        });

        // Load users on page load
        window.onload = loadUsers;
    </script>
</body>
</html>
