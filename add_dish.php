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
    <link rel="stylesheet" href="assets/style/sweetalert2.min.css">
    <title>Кафе здорового питания Olce&Gabbana</title>
</head>
<body>
    <?php
        include 'left_panel.php';
    ?>
        <header class="for_menu">
            <div class="mobile_menu">
                    <input class="side_menu" type="checkbox" id="side_menu"/>
                    <label class="hamb" for="side_menu"><span class="hamb_line"></span></label>
                    <a href="index.php" class="side_menu_img"><img src="assets/img/logo.svg" alt="logo"></a>
                <nav>
                    <ul>
                        <a href="menu.php?category=Завтраки"><li>Меню</li></a>
                        <a href="login.php"><li>Личный кабинет</li></a>
                        <a href="#contacts"><li>Контакты</li></a>
                        <a href="booking.php"><li class="highlight btn1">Бронь столика</li></a>
                    </ul>
                </nav>
            </div>
        </header>
        
        <section class="landing_page">
        <section class="main_landing">
        <h2 class="maxi_header">Добавить блюдо в меню</h2>
        
            <form method="post" action="" name="add_dish" class="signup_form" enctype="multipart/form-data">
                <div class="form_element">
                    <label>Название блюда</label>
                    <input type="text" name="name_dish" required placeholder="Скрэмбл"/>
                </div>
                <div class="form_element">
                    <label>Цена</label>
                    <input type="number" name="price_dish" step="0.01" required/>
                </div>
                <div class="form_element">
                    <label>Изображение блюда</label>
                    <input type="file" name="file_path_dish" required/>
                    
                </div>
                <div class="form_element">
                    <label>Описание блюда</label>
                    <textarea name="desc_dish"></textarea>
                </div>
                <div class="form_element">
                    <label>Категория блюда</label>
                    <select name="id_category" id="">
                        <?php
                            include('vendor/connect.php');
                            $query = $connection->prepare("SELECT * FROM `categories`");
                            $query->execute();
                            $category = $query->fetchAll(PDO::FETCH_ASSOC);
                            var_dump($category);
                            for ($i=0; $i < count($category); $i++) {
                                echo '<option value="'.$category[$i]['id_category'].'">'.$category[$i]['name_category'].'</option>';
                            };
                        ?>
                    </select>
                </div>
                <button class="btn highlight" type="submit" name="add_dish" value="add_dish">Добавить блюдо</button>
            </form>
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
                if(isset($_SESSION['msg'])) {
                    echo '<p class="msg">'.$_SESSION['msg'].'</p>';
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
        <script src="assets/js/sweetalert2.all.min.js"></script>
    </body>
</html>