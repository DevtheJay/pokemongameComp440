<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Inventory</title>
</head>
<body>
    <h1>Inventory</h1>
    <div class="container">
        <div class="box">
            <!-- Dropdown for inventory view -->
            <label for="inventory-filter">View Inventory:</label>
            <select id="inventory-filter" class="btn">
                <option value="">Select</option>
                <option value="users">Users</option>
                <option value="npcs">NPCs</option>
                <option value="all">All Entities</option>
            </select>

            <!-- Container for inventory data -->
            <div id="inventory-container" style="margin-top: 20px;"></div>
        </div>
    </div>
    <a href="index.php" class="btn">Back to Home</a>

    <!-- JavaScript for fetching and displaying inventory -->
    <script>
        const inventoryFilter = document.getElementById('inventory-filter');
        const inventoryContainer = document.getElementById('inventory-container');

        // Fetch and display inventory based on filter selection
        inventoryFilter.addEventListener('change', function() {
            const filter = this.value;
            if (filter) {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', 'fetch_inventory.php?filter=' + encodeURIComponent(filter), true);
                xhr.onload = function() {
                    if (this.status === 200) {
                        inventoryContainer.innerHTML = this.responseText;
                    } else {
                        inventoryContainer.innerHTML = '<p>Failed to load inventory data. Please try again.</p>';
                    }
                };
                xhr.send();
            } else {
                inventoryContainer.innerHTML = ''; // Clear data if no filter is selected
            }
        });
    </script>
</body>
</html>
