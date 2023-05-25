<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Notes App</title>
	<link rel="stylesheet" href="search_notes.css">
</head>

<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "notes";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$searchTerm = $_GET["search"];

$sql = "SELECT * FROM notes WHERE title LIKE '%$searchTerm%' OR content LIKE '%$searchTerm%'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo '<table>';
    echo '<tr><th>ID</th><th>Title</th><th>Content</th><th>Image</th></tr>';
    
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $row["id"] . '</td>';
        echo '<td>' . $row["title"] . '</td>';
        echo '<td>' . $row["content"] . '</td>';
        
        if (!empty($row["image"])) {
            echo '<td><img src="uploads/' . $row["image"] . '" alt="Note Image" width="100"></td>';
        } else {
            echo '<td>No Image</td>';
        }
        
        echo '</tr>';
    }
    
    echo '</table>';
} else {
    echo 'No matching notes found';
}

mysqli_close($conn);
?>
</html>