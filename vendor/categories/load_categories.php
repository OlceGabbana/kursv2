<?php
// Подключение к базе данных
include ('../connect.php');

try {
    
    // Запрос для получения списка категорий
    $stmt = $connection->prepare("SELECT id_category, name_category FROM categories");

    // Выполнение запроса
    $stmt->execute();

    // Получение результатов
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Отправка результатов в формате JSON
    echo json_encode(array('categories' => $categories));
} catch (PDOException $e) {
    // Ошибка подключения к базе данных
    echo json_encode(array('error' => 'Ошибка подключения к базе данных'));
}
?>
