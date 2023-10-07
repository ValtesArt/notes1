<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $content = $_POST["content"];

    $mysqli = new mysqli("localhost", "root", "", "notes");

    if ($mysqli->connect_error) {
        die("Ошибка подключения к базе данных: " . $mysqli->connect_error);
    }

    $stmt = $mysqli->prepare("UPDATE notes SET content = ? WHERE id = ?");
    $stmt->bind_param("si", $content, $id);
    $stmt->execute();
    $stmt->close();
    $mysqli->close();
}

header("Location: index.php");
exit;
?>
