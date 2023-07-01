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
            <h2 class="maxi_header">Добавить категорию товара</h2>
            <form method="post" class="signup_form">
            <div class="form_element">
                <label>Выберите блюдо для добавления категории: </label>
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
            </div>
            <div class="form_element">
                    <label>Категория блюда</label>
                    <select name="id_category" id="">
                        <?php
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
            <button class="btn highlight" type="submit" name="add_cat_to_dish">Добавить</button>
            </form>

            <?php

            if (isset($_POST['add_cat_to_dish'])) {
                    $select_dish = $_POST['select_dish'];
                    $id_category = $_POST['id_category'];
                    $query_category = $connection->prepare("INSERT INTO `dishes_has_categories`(`dishes_id_dish`, `categories_id_category`) VALUES (:select_dish, :id_category)");
                            $query_category->bindValue(':select_dish', $select_dish);
                            $query_category->bindValue(':id_category', $id_category);
                            $res =  $query_category->execute();
                            if ($res){
                                $_SESSION['msg'] = 'Категория успешно добавлена!';
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
</body>

</html>