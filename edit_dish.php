<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style/style.css">
    <title>Кафе здорового питания Olce&Gabbana</title>
</head>

<body>
    <?php
    include('vendor/connect.php');
    include 'left_panel.php';
    ?>
    <header class="for_menu">
        <div class="mobile_menu">
            <input class="side_menu" type="checkbox" id="side_menu" />
            <label class="hamb" for="side_menu"><span class="hamb_line"></span></label>
            <a href="index.php" class="side_menu_img"><img src="assets/img/logo.svg" alt="logo"></a>
            <nav>
                <ul>
                    <a href="menu.php?category=Завтраки">
                        <li>Меню</li>
                    </a>
                    <a href="login.php">
                        <li>Личный кабинет</li>
                    </a>
                    <a href="#contacts">
                        <li>Контакты</li>
                    </a>
                    <a href="booking.php">
                        <li class="highlight btn1">Бронь столика</li>
                    </a>
                </ul>
            </nav>
        </div>
    </header>

    <section class="landing_page">
        <section class="main_landing">
            <h2 class="maxi_header">Редактировать блюдо</h2>
            <form method="post" class="signup_form">
            <div class="form_element">
                <label>Выберите блюдо для редактирования: </label>
                <select name="select_dish" id="">
                    <?php
                    
                    $query = $connection->prepare("SELECT * FROM `dishes`");
                    $query->execute();
                    $dishes = $query->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($dishes as $dish) {
                        echo '<option value="' . $dish['id_dish'] . '">' . $dish['name_dish'] . '</option>';
                    }
                    ?>
                </select>
                <button class="btn highlight special_btn" type="submit">Отправить</button>
            </div>
            </form>

            <?php

            if (isset($_POST['edit_dish'])) {
                    $uploadname = basename($_FILES['file_path_dish']['name']);
                    $new_name = time() . $uploadname;
                    $uploadpath = 'assets/img/dishes/' . $new_name;
                    $desc_dish = $_POST['desc_dish'];
                    $id_dish = $_POST['id_dish'];
                    $dish_name = $_POST['name_dish'];
                    $price_dish = $_POST['price_dish'];
                    $id_category = $_POST['id_category'];
                    
                    if (move_uploaded_file($_FILES['file_path_dish']['tmp_name'], $uploadpath)) {
                        $query = $connection->prepare("UPDATE `dishes` SET `desc_dish`='$desc_dish', `name_dish`='$dish_name', `price_dish`='$price_dish', `file_path_dish`='$uploadpath' WHERE `id_dish`='$id_dish'");
                        $query->execute();
                    } else {
                        $query = $connection->prepare("UPDATE `dishes` SET `desc_dish`='$desc_dish', `name_dish`='$dish_name', `price_dish`='$price_dish' WHERE `id_dish`='$id_dish'");
                        $query->execute();
                    }
                    header('refresh:0');
                }
            
            if (isset($_POST['select_dish'])) {
                $selectedValue = $_POST['select_dish'];
                $query = $connection->prepare("SELECT * FROM `dishes` WHERE id_dish = :id_dish");
                $query->bindValue(':id_dish', $selectedValue);
                $query->execute();
                $dish = $query->fetch(PDO::FETCH_ASSOC);
                
            ?>
                <form method="post" class="signup_form" enctype="multipart/form-data">

                    <input type="hidden" name="id_dish" value="<?php echo $dish['id_dish']; ?>">
                    <div class="form_element">
                        <label>Название блюда: </label>
                        <input type="text" name="name_dish" value="<?php echo $dish['name_dish']; ?>">
                    </div>
                    
                    <div class="form_element">
                        <label>Цена блюда: </label>
                        <input type="text" name="price_dish" value="<?php echo $dish['price_dish']; ?>">
                    </div>
                    <div class="form_element">
                        <label>Описание блюда: </label>
                        <textarea name="desc_dish"><?php echo $dish['desc_dish']; ?></textarea>
                    </div>
                    <div class="form_element">
                        <label>Изображение блюда: </label>
                        <img src="<?php echo $dish['file_path_dish']; ?>" alt="img_dish">
                    </div>
                    <div class="form_element">
                        <label>Новое изображение блюда: </label>
                        <input type="file" name="file_path_dish"/>
                    </div>
                    
                    <button class="btn highlight" type="submit" name="edit_dish" value="edit_dish">Изменить блюдо</button>
                </form>
            <?php
            }
            ?>

            
                
            <?php
            
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

                        $_SESSION['msg'] = 'Блюдо успешно добавлено!';
                    }
                } else {
                    $_SESSION['msg'] = 'Ошибка загрузки!';
                }
            }
            ?>
            <?php
            if (isset($_SESSION['msg'])) {
                echo '<p class="msg">' . $_SESSION['msg'] . '</p>';
            }
            unset($_SESSION['msg']);
            ?>
        </section>
        <?php
        include 'contacts.php';
        include 'footer.php';
        ?>
    </section>

    <script src="assets/js/mask.js"></script>
</body>

</html>