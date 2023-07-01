<?php
// Подключение к базе данных
include ('../connect.php');

try {
    // Получение выбранной категории из POST-запроса
    $selectedCategory = $_POST['selectedCategory'];

    // Запрос на удаление категории из базы данных
    $stmt = $connection->prepare("DELETE FROM categories WHERE id_category = :id");
    $stmt->bindParam(':id', $selectedCategory);
    $stmt->execute();
    
    // Возвращаем успешный результат
    echo json_encode(array('success' => true));
} catch (PDOException $e) {
    // Ошибка подключения к базе данных или удаления категории
    echo json_encode(array('error' => $e->getMessage()));
}
