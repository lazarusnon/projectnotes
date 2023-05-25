<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "notes";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM notes";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
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
        echo '<td><a href="delete_note.php?id=' . $row["id"] . '">Delete</a></td>';

        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="4">No notes found</td></tr>';
}

mysqli_close($conn);
?>
