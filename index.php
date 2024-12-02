<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .grid-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px; /* This adds spacing between boxes */
            margin-top: 20px;
        }
        .grid-box {
            background: rgba(97, 120, 93, 0.808);
            color: white;
            padding: 15px;
            width: 200px;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }
        .grid-box:hover {
            opacity: 0.82;
        }
    </style>
</head>
<body>
  <div class="container">
    <div class="box form-box">
      <?php
          include("php/config.php");
      ?>
      <header>Main</header>
      <form action="" method="post">
        <!-- Login form elements go here -->
      </form>
    </div>

    <!-- Add boxes to link to respective pages -->
    <div class="grid-container">
        <a href="user.php" class="grid-box">User</a>
        <a href="pokemon.php" class="grid-box">Pokemon</a>
        <a href="moves.php" class="grid-box">Moves</a>
        <a href="inventory.php" class="grid-box">Inventory</a>
        <a href="battles.php" class="grid-box">Battles</a>
    </div>
  </div>
</body>
</html>
