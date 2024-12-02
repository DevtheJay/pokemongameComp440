<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <div class="box form-box">
    <?php
        include("php/config.php");

        if(isset($_POST['submit'])){
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Check if username exists
            $query = mysqli_query($con, "SELECT * FROM users WHERE Username='$username'");
            if(mysqli_num_rows($query) > 0){
                $row = mysqli_fetch_assoc($query);
                // Verify password
                if($password = $row['PASSWORD']){
                    // Start session and set session variables
                    session_start();
                    $_SESSION['username'] = $username;
                    $timesloggedin = $row['timesloggedin'] + 1; // Increment login count
                    $lastLogin = date("Y-m-d H:i:s"); // Get current date and time
                    $update_query =  "UPDATE users SET timesloggedin='$timesloggedin', lastlogin='$lastLogin' WHERE Username='$username'";
                    mysqli_query($con, $update_query);
                    header("Location: home.php"); // Redirect to welcome page
                    exit();
                } else {
                    echo "<div class='message'>
                    <p>Incorrect password!</p>
                    </div><br>";
                }
            } else {
                echo "<div class='message'>
                <p>Username does not exist!</p>
                </div><br>";
            }
        }
    ?>
        <header>Login</header>
        <form action="" method="post">
            <div class="field input">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="field input">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="links">
                Forgot Username or Password? <a href="forgot.php">Click Here!</a>
            <div class="field input">
                <input type="submit" name="submit" class='btn' value="login" required>
            </div>
            <div class="links">
                Don't have an account? <a href="register.php">Register now</a>
            </div>
        </form>
    </div>
  </div>
</body>
</html>
