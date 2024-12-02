<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Edit Profile</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php"> Back</a></p>
        </div>

        <div class="right-links">
            <a href="#">Edit Profile</a>
            <a href="php/logout.php"> <button class="btn">Log Out</button> </a>
        </div>
    </div>
    <div class="container">
        <div class="box form-box">
            <header>Edit Profile</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" required>
                </div>
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" required>
                </div>
                <div class="field input">
                    <label for="birth-date">Birth Date - (mm/dd/yyyy)</label>
                    <input type="text" name="birth-date" id="birth-date" required>
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <div class="field input">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="confirm_password" name="confirm_password" id="confirm_password" required>
                </div>
                <div class="field input">
                    <input type="submit" name="submit" class='btn' value="Update" required>
                </div>
            </form>
        </div>
      </div>
    
</body>
</html>