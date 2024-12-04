<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>NPCs</title>
</head>
<body>
    <h1>NPCs</h1>
    <div class="container">
        <div class="box">
            <!-- Dropdown for selecting an NPC -->
            <label for="npc-select">Select an NPC:</label>
            <select id="npc-select" class="btn">
                <option value="">Select NPC</option>
                <!-- Dynamic NPC options will be loaded here -->
            </select>

            <!-- Container for NPC data -->
            <div id="npc-data-container" style="margin-top: 20px;"></div>
        </div>
    </div>
    <a href="index.php" class="btn">Back to Home</a>

    <!-- JavaScript for fetching and displaying NPC data -->
    <script>
        const npcSelect = document.getElementById('npc-select');
        const npcDataContainer = document.getElementById('npc-data-container');

        // Fetch NPCs and populate the dropdown
        function loadNPCs() {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_npcs.php', true);
            xhr.onload = function() {
                if (this.status === 200) {
                    const npcs = JSON.parse(this.responseText);
                    npcs.forEach(npc => {
                        const option = document.createElement('option');
                        option.value = npc.npc_id;
                        option.textContent = `${npc.npc_name} (${npc.occupation})`;
                        npcSelect.appendChild(option);
                    });
                } else {
                    alert('Failed to load NPCs.');
                }
            };
            xhr.send();
        }

        // Fetch and display NPC data (Pokémon and items)
        npcSelect.addEventListener('change', function() {
            const npcId = this.value;
            if (npcId) {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', 'fetch_npc_data.php?npc_id=' + encodeURIComponent(npcId), true);
                xhr.onload = function() {
                    if (this.status === 200) {
                        npcDataContainer.innerHTML = this.responseText;
                    } else {
                        npcDataContainer.innerHTML = '<p>Failed to load NPC data. Please try again.</p>';
                    }
                };
                xhr.send();
            } else {
                npcDataContainer.innerHTML = ''; // Clear data if no NPC is selected
            }
        });

        // Load NPCs on page load
        window.onload = loadNPCs;
    </script>
</body>
</html>
