<?php
// Подключение к базе данных и другие необходимые настройки
include('../connect.php');
// Получение данных из POST-запроса
$dishId = $_POST['dishId'];
$dishName = $_POST['dishName'];
$dishPrice = $_POST['dishPrice'];
$dishImagePath = $_POST['dishImagePath'];
$dishDescription = $_POST['dishDescription'];
$dishCategory = $_POST['dishCategory'];

// Обновление данных товара в базе данных
// Замените нижестоящий код соответствующей логикой обновления данных в вашей базе данных

// Пример кода для обновления данных в MySQL с использованием подготовленных запросов

// Подготовка SQL-запроса
$sql = "UPDATE dishes SET name_dish = :name, price_dish = :price, file_path_dish = :image, desc_dish = :description WHERE id_dish = :id";

// Подготовка и выполнение подготовленного запроса
$stmt = $connection->prepare($sql);
$stmt->bindParam(':name', $dishName);
$stmt->bindParam(':price', $dishPrice);
$stmt->bindParam(':image', $dishImagePath);
$stmt->bindParam(':description', $dishDescription);
$stmt->bindParam(':id', $dishId);

if ($stmt->execute()) {
  // Успешное выполнение запроса
  echo "success";
} else {
  // Ошибка при выполнении запроса
  echo "error";
}
?>
