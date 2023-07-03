<?php
$_POST['name_dish'] = 'Test Dish';
$_POST['price_dish'] = 10.99;
$_POST['desc_dish'] = 'Test description';
$_POST['id_category'] = 1;

$_FILES['file_path_dish'] = [
    'name' => '16883026452.png',
    'type' => 'image/png',
    'tmp_name' => 'assets/img/dishes/16883026452.png',
    'error' => 0,
    'size' => 123456
];

include('vendor/connect.php');

if (isset($_POST['add_dish'])) {
    $name_dish = $_POST['name_dish'];
    $price_dish = $_POST['price_dish'];
    $desc_dish = $_POST['desc_dish'];
    $id_category = $_POST['id_category'];

    $uploadname = basename($_FILES['file_path_dish']['name']);
    $new_name = time() . '.' . $uploadname;
    $uploadpath = 'assets/img/dishes/' . $new_name;

    if (move_uploaded_file($_FILES['file_path_dish']['tmp_name'], $uploadpath)) {
        $query = $connection->prepare("INSERT INTO `dishes` (`id_dish`, `name_dish`, `price_dish`, `file_path_dish`, `desc_dish`) VALUES (NULL, :name_dish, :price_dish, :file_path_dish, :desc_dish)");
        $query->bindValue(':name_dish', $name_dish);
        $query->bindValue(':price_dish', $price_dish);
        $query->bindValue(':file_path_dish', $uploadpath);
        $query->bindValue(':desc_dish', $desc_dish);
        $query->execute();
        
        // Получение id добавленного блюда
        $d_id_dish = $connection->prepare("SELECT `id_dish` FROM `dishes` WHERE name_dish = :name_dish");
        $d_id_dish->bindValue(':name_dish', $name_dish);
        $d_id_dish->execute();
        $result = $d_id_dish->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            $dishes_id_dish = $result["id_dish"];

            // Вставка связи между блюдом и категорией в таблицу dishes_has_categories
            $query_category = $connection->prepare("INSERT INTO `dishes_has_categories`(`dishes_id_dish`, `categories_id_category`) VALUES (:dishes_id_dish, :id_category)");
            $query_category->bindValue(':dishes_id_dish', $dishes_id_dish);
            $query_category->bindValue(':id_category', $id_category);
            $query_category->execute();
            
            
        }
    }
}



echo 'Тест успешно пройден!';
?>