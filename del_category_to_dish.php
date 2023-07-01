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
            <h2 class="maxi_header">Удалить категорию товара</h2>
            <form method="post" class="signup_form">
                <div class="form_element">
                    <label>Выберите блюдо для удаления категории: </label>
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
                <button class="btn highlight special_btn" type="submit">Отправить</button>
            </form>

            <?php 
            if (isset($_POST['select_dish'])) {
                
                $selectedValue = $_POST['select_dish'];
                
                $query = $connection->prepare("SELECT c.name_category, c.id_category
                    FROM dishes d
                    JOIN dishes_has_categories dhc ON d.id_dish = dhc.dishes_id_dish
                    JOIN categories c ON dhc.categories_id_category = c.id_category
                    WHERE d.id_dish = :id_dish;");
                $query->bindValue(':id_dish', $selectedValue);
                $query->execute();
                $categories = $query->fetchAll(PDO::FETCH_ASSOC);
                
                if (!empty($categories)) {
                    echo '<form method="post" class="signup_form">
                        <div class="form_element">
                        <p>';
                            if (isset($_POST['select_dish'])) {
                            $selectedValue = $_POST['select_dish'];
                            echo 'Выбранное блюдо: ';
                            $query_dish = $connection->prepare("SELECT name_dish FROM dishes WHERE id_dish = :selected_dish");
                            $query_dish->bindValue(':selected_dish', $selectedValue);
                            $query_dish->execute();
                            $dish = $query_dish->fetch(PDO::FETCH_ASSOC);
                            if ($dish) {
                                echo $dish['name_dish'];
                            }
                    }
                    
                            echo '</p>
                            <label>Категория блюда</label>
                            <select name="id_category" id="id_category">';
                    
                    foreach ($categories as $category) {
                        echo '<option value="'.$category['id_category'].'">'.$category['name_category'].'</option>';
                    }
                    
                    echo '</select>
                        </div>
                        <input type="hidden" name="select_dish" value="'.$selectedValue.'">
                        <button class="btn highlight" type="submit" name="delete_cat">Удалить категорию</button>
                    </form>';
                } else {
                    echo '<p class="msg">Выбранное блюдо не имеет категорий.</p>';
                }
            }
            ?>

            <?php
            if (isset($_POST['delete_cat'])) {
                $select_dish = $_POST['select_dish'];
                $id_category = $_POST['id_category'];
                $query_category = $connection->prepare("DELETE FROM `dishes_has_categories` WHERE dishes_id_dish = :select_dish AND categories_id_category = :id_category");
                $query_category->bindValue(':select_dish', $select_dish);
                $query_category->bindValue(':id_category', $id_category);
                $res = $query_category->execute();

                if ($res) {
                    $_SESSION['msg'] = 'Категория успешно удалена!';
                } else {
                    $_SESSION['msg'] = 'Ошибка удаления!';
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
