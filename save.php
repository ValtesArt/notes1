<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mysqli = new mysqli("localhost", "root", "", "notes");

    if ($mysqli->connect_error) {
        die("Ошибка подключения к базе данных: " . $mysqli->connect_error);
    }

    $content = $_POST["content"];
    $stmt = $mysqli->prepare("INSERT INTO notes (content) VALUES (?)");
    $stmt->bind_param("s", $content);
    $stmt->execute();
    $stmt->close();
    $mysqli->close();
}

header("Location: index.php");
exit;
?>
