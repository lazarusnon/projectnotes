<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "notes";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$title = $_POST['title'];
$content = $_POST['content'];

// Обработка загруженного изображения
$imageName = $_FILES['image']['name'];
$imageTmpName = $_FILES['image']['tmp_name'];
$imageSize = $_FILES['image']['size'];
$imageError = $_FILES['image']['error'];

if ($imageSize > 0) {
    // Генерация уникального имени для изображения
    $imageExtension = pathinfo($imageName, PATHINFO_EXTENSION);
    $newImageName = uniqid('image_') . '.' . $imageExtension;

    // Путь, где будет сохранено изображение
    $imageDestination = 'uploads/' . $newImageName;

    // Сохранение изображения на сервере
    move_uploaded_file($imageTmpName, $imageDestination);
} else {
    $newImageName = null;
}

$sql = "INSERT INTO notes (title, content, image) VALUES ('$title', '$content', '$newImageName')";

if (mysqli_query($conn, $sql)) {
    echo "Note added successfully";
} else {
    echo "Error adding note: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
