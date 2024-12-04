<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "game";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check for POST data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nickname = $conn->real_escape_string($_POST['nickname']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $location_id = intval($_POST['location_id']);

    // Insert new user into the database
    $sql = "INSERT INTO users (nickname, gender, location_id) VALUES ('$nickname', '$gender', $location_id)";
    if ($conn->query($sql) === TRUE) {
        // Redirect back to the users page
        header("Location: user.php");
        exit();
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}

$conn->close();
?>
