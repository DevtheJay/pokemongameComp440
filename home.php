<?php
session_start();
include("php/config.php");

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];
$query = mysqli_query($con, "SELECT Fname, Lname, lastlogin, timesloggedin, Email FROM users WHERE Username='$username'");
$user = mysqli_fetch_assoc($query);

$fname = $user['Fname'];
$lname = $user['Lname'];
$login_count = $user['timesloggedin'];
$last_login = $user['lastlogin'];
$email = $user['Email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Home</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p>Logo</p>
        </div>
        <div class="right-links">
            <a href="edit.php">Edit Profile</a>
            <a href="index.php"> <button class="btn">Log Out</button></a>
        </div>
    </div>
    <main>
        <div class="main-box top">
            <div class="top">
                <div class="box">
                    <p>Hello <b><?php echo $fname . ' ' . $lname; ?></b></p>
                    <p>You have logged in <b><?php echo $login_count; ?></b> times</p>
                    <p>Last Log in: <b><?php echo $last_login; ?></b></p>
                </div>
                <div class="box">
                <p>Your email is <b><?php echo $email; ?></b>, Welcome</p>
                </div>
            </div>
            <div class="bottom">
                <div class="box">
                    <p>Click here to download confidential information.</p>

                </div>
        </div>
    </main>
</body>
</html>