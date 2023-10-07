<?php
$mysqli = new mysqli("localhost", "root", "", "notes");

if ($mysqli->connect_error) {
    die("Ошибка подключения к базе данных: " . $mysqli->connect_error);
}

// Проверяем, есть ли уже заметка в базе данных
$query = "SELECT * FROM notes";
$result = $mysqli->query($query);

if ($result && $result->num_rows === 0) {
    // Если заметки отсутствуют, создаем начальную заметку
    $initialNote = "Это начальная заметка. Добро пожаловать!";
    $stmt = $mysqli->prepare("INSERT INTO notes (content) VALUES (?)");
    $stmt->bind_param("s", $initialNote);
    $stmt->execute();
    $stmt->close();
}

$notes = [];
$result = $mysqli->query("SELECT * FROM notes ORDER BY created_at DESC");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $notes[] = $row;
    }
    $result->free();
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Заметки</title>
</head>
<body>
<div class="container">
    <h1>Заметки</h1>
    <ul>
        <?php foreach ($notes as $note) { ?>
            <li>
                <p><strong>Номер заметки: <?php echo $note['id']; ?></strong></p>
                <p><strong>Дата создания: <?php echo $note['created_at']; ?></strong></p>
                <br>
                <p><?php echo htmlspecialchars($note['content']); ?></p>
                <br>
                <a href="edit.php?id=<?php echo $note['id']; ?>">Редактировать</a>
                <a href="delete.php?id=<?php echo $note['id']; ?>">Удалить</a>
            </li>
        <?php } ?>
    </ul>
    <form method="post" action="create.php" onsubmit="return validateForm();">
        <h2>Добавить новую заметку</h2>
        <textarea name="content" id="content" placeholder="Введите текст заметки" required></textarea>
        <br>
        <button type="submit">Сохранить заметку</button>
        <p id="error-message" style="color: red;"></p>
    </form>
</div>
<script>
function validateForm() {
    var content = document.getElementById("content").value.trim();
    if (content === "") {
        var errorMessage = document.getElementById("error-message");
        errorMessage.textContent = "Пожалуйста, заполните текст заметки.";
        return false;
    }
    return true;
}
</script>
</body>
</html>
