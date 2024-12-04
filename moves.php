<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Moves</title>
</head>
<body>
    <h1>Moves</h1>
    <div class="container">
        <div class="box">
            <!-- Dropdown for filtering Moves -->
            <label for="type-filter">Filter by Type:</label>
            <select id="type-filter" class="btn">
                <option value="">All Types</option>
                <option value="Grass">Grass</option>
                <option value="Fire">Fire</option>
                <option value="Water">Water</option>
                <option value="Electric">Electric</option>
                <option value="Bug">Bug</option>
                <option value="Poison">Poison</option>
                <option value="Normal">Normal</option>
                <option value="Flying">Flying</option>
                <option value="Rock">Rock</option>
                <option value="Ground">Ground</option>
                <option value="Psychic">Psychic</option>
                <option value="Fighting">Fighting</option>
                <option value="Dragon">Dragon</option>
                <option value="Ice">Ice</option>
                <option value="Ghost">Ghost</option>
                <option value="Steel">Steel</option>
            </select>
            
            <!-- Table container for dynamic data -->
            <div id="moves-container" style="margin-top: 20px;"></div>
        </div>
    </div>
    <a href="index.php" class="btn">Back to Home</a>

    <!-- JavaScript for fetching and displaying Moves data -->
    <script>
        const movesContainer = document.getElementById('moves-container');
        const typeFilter = document.getElementById('type-filter');

        // Event listener for dropdown filter
        typeFilter.addEventListener('change', function() {
            const selectedType = this.value;
            const xhr = new XMLHttpRequest();

            xhr.open('GET', 'fetch_moves.php?type=' + encodeURIComponent(selectedType), true);
            xhr.onload = function() {
                if (this.status === 200) {
                    movesContainer.innerHTML = this.responseText;
                } else {
                    movesContainer.innerHTML = '<p>Failed to load data. Please try again.</p>';
                }
            };
            xhr.send();
        });
    </script>
</body>
</html>
