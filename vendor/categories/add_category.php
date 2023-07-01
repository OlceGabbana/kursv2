<?php
// Подключение к базе данных
include ('../connect.php');

try {
    // Получение значения категории из POST-запроса
    $categoryName = $_POST['categoryName'];

    // Подготовка SQL-запроса для добавления категории
    $stmt = $connection->prepare("INSERT INTO `categories` (name_category) VALUES (?)");
    $stmt->execute([$categoryName]);

    // Успешно добавлено
    echo json_encode(array('success' => true));
} catch (PDOException $e) {
    // Ошибка добавления
    echo json_encode(array('success' => false));
}
?>