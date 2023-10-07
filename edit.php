<?php
$mysqli = new mysqli("localhost", "root", "", "notes");

if ($mysqli->connect_error) {
    die("Ошибка подключения к базе данных: " . $mysqli->connect_error);
}

$id = $_GET["id"];
$note = null;
$stmt = $mysqli->prepare("SELECT content FROM notes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($content);

if ($stmt->fetch()) {
    $note = $content;
}

$stmt->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Редактировать заметку</title>
</head>
<body>
<div class="container">
    <h1>Редактировать заметку</h1>
    <a href="index.php">Назад к списку заметок</a>
    <form action="update.php" method="post">
        <textarea name="content" rows="4" cols="50"><?php echo htmlspecialchars($note); ?></textarea>
        <br>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <button type="submit">Сохранить заметку</button>
    </form>
    
</div>
</body>
</html>
