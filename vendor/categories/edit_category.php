<?php
// Подключение к базе данных
include ('../connect.php');

try {
    // Получение значений из POST-запроса
    $selectedCategory = $_POST['selectedCategory'];
    $newCategoryName = $_POST['newCategoryName'];

    // Подготовка SQL-запроса для изменения категории
    $stmt = $connection->prepare("UPDATE categories SET name_category = :newCategoryName WHERE id_category = :selectedCategory");
    $stmt->bindParam(':newCategoryName', $newCategoryName);
    $stmt->bindParam(':selectedCategory', $selectedCategory);

    // Выполнение запроса
    $stmt->execute();

    // Успешно изменено
    echo json_encode(array('success' => true));
} catch (PDOException $e) {
    // Ошибка изменения
    echo json_encode(array('success' => false));
}
?>