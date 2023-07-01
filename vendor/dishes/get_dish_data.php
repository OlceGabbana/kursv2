<?php
// Подключение к базе данных и другие необходимые настройки
include('../connect.php');
// Проверка, получен ли идентификатор товара
if (isset($_POST['dishId'])) {
  $dishId = $_POST['dishId'];

  
  $query = "
  SELECT dishes.id_dish, dishes.name_dish, dishes.price_dish, dishes.file_path_dish, dishes.desc_dish, categories.id_category, categories.name_category 
  FROM dishes JOIN dishes_has_categories ON dishes.id_dish = dishes_has_categories.dishes_id_dish 
  JOIN categories ON dishes_has_categories.categories_id_category = categories.id_category WHERE dishes.id_dish = 60;
  ";
  $statement = $connection->prepare($query);
  $statement->bindParam(':dishId', $dishId);
  $statement->execute();

  // Получение данных о товаре и его категории
  $dishData = $statement->fetch(PDO::FETCH_ASSOC);

  // Отправка данных о товаре в формате JSON
  echo json_encode($dishData);
} else {
  // Если идентификатор товара не был получен, вы можете вернуть сообщение об ошибке или выполнить другие действия
  echo "Error: Dish ID not provided.";
}
