<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "game";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id']) && isset($_POST['user_id'])) {
    $item_id = intval($_POST['item_id']);
    $user_id = intval($_POST['user_id']);

    $sql = "DELETE FROM user_inventory WHERE item_id = $item_id AND user_id = $user_id";
    if ($conn->query($sql) === TRUE) {
        echo "Item deleted successfully.";
    } else {
        echo "Error deleting item: " . $conn->error;
    }
}

$conn->close();
?>
