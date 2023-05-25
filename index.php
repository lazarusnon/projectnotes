<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Notes App</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style_2.css">
    <link rel="stylesheet" href="fontawesome-free-6.4.0-web/css/all.min.css">

</head>
<body>
<div class="head">
    <header>
        <div class="container">
            <div class="logo">
                <h1>Notes App</h1>
            </div>
            <div class="search-container">
                <form method="get" action="search_notes.php">
                    <input type="text" placeholder="Search..." id="search" name="search" required>
                    <button type="submit"><i class="fas fa-search"></i></button>

                </form>
            </div>
        </div>
    </header>
</div>


    <form method="post" action="add_note.php" enctype="multipart/form-data" id="addNoteForm">
        <div class="title">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="content">
            <label for="content">Content:</label>
            <textarea id="content" name="content" required></textarea>
        </div>
        <div class="image">
            <label for="image">Image:</label>
            <input type="file" id="image" name="image">
        </div>
        <div class="button1">
            <button type="button" id="addNoteButton">Add Note</button>
        </div>
    </form>

    <table id="notesTable">
        <div class="tables">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
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
        </div>
    </table>

    <script>
        document.getElementById("addNoteButton").addEventListener("click", function() {
            var form = document.getElementById("addNoteForm");
            var formData = new FormData(form);

            var xhr = new XMLHttpRequest();
            xhr.open("POST", form.action, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert(xhr.responseText); // Вывести сообщение с сервера
                    form.reset(); // Сбросить значения полей формы
                    updateNotesList(); // Обновить список заметок на странице
                } else {
                    alert("Error adding note");
                }
            };
            xhr.send(formData);
        });

        function updateNotesList() {
            var table = document.getElementById("notesTable");
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "get_posts.php", true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    table.innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        // Инициализация списка заметок при загрузке страницы
        updateNotesList();

        
    </script>

</body>
</html>
