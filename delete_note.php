<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "notes";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$noteId = $_GET["id"];

$sql = "DELETE FROM notes WHERE id = $noteId";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo "Note deleted successfully.";
} else {
    echo "Error deleting note: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
