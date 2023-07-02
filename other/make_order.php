<?php
session_start();
include('vendor/connect.php');
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style/style.css">
    <link rel="stylesheet" href="assets/style/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="assets/js/main.js"></script>
    <title>Кафе здорового питания Olce&Gabbana</title>
</head>

<body>
    <script src="assets/js/sweetalert2.all.min.js"></script>
    <?php
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
        <div id="allsum1"></div>

        <form action="" method="post">
            <table id="cart-table">
                <thead>
                    <tr>
                        <th>Название блюда</th>
                        <th>Цена</th>
                        <th>Количество</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody id="modal_content_table">
                </tbody>
            </table>
            <div class="foot_modal">
                <div id="delBuscket" style="display:none;"></div>
                <div class="foot_modal_form">
                    <p>Итоговая сумма заказа: <input type="text" readonly="readonly" id="total-price" name="total_price" value="" /> &#8381;</p>
                    <?php
                    if (isset($_SESSION['user'])) echo '<button id="checkout_button" class="checkout_button" type="submit" name="checkout_button">Оформить заказ</button>';
                    else echo '<button id="checkout_button" class="checkout_button" name="checkout_button">Оформить заказ</button>';
                    ?>
                </div>
            </div>
        </form>
        <?php
        if (isset($_POST['checkout_button'])) {
            $_SESSION['orders']['LastOrder']['total_price'] = $_POST['total_price'];
            echo $_SESSION['orders']['LastOrder']['total_price'];
            // echo '<script>addDB()</script>';
        }
        echo '<div class="dishes">';
        $query_dish = $connection->prepare("SELECT * FROM dishes JOIN dishes_has_categories ON id_dish = dishes_has_categories.dishes_id_dish JOIN categories ON id_category = dishes_has_categories.categories_id_category;");
        $result_dish = $query_dish->execute();
        $dish = $query_dish->fetchAll(PDO::FETCH_ASSOC);
        for ($i = 0; $i < count($dish); $i++) {
            for ($ind = 0; $ind < count($dish); $ind++) {
                $sravn[$dish[$i]['id_dish']] = $i;
            }
        }
        for ($i = 0; $i < count($dish); $i++) {
            echo '<div class="dish" style="display: none;">
                                <div class="ud">';
            if ($_SESSION['user']['role_user'] == "Администратор") {
                echo '<img src="assets/img/pencil.svg">
                                    <img src="assets/img/delete.svg">';
            }
            echo '</div>
                                <img src="' . $dish[$i]['file_path_dish'] . '" alt="">
                                <div class="dish_info">
                                    <h2 class="name_dish" id_db="' . $dish[$i]['id_dish'] . '">' . $dish[$i]['name_dish'] . '</h2>
                                    <div class="price_and_btn">
                                        <h3 class="price_dish">' . $dish[$i]['price_dish'] . ' &#8381;</h3>
                                        <button class="btn btn_small" onclick="addProduct(' . $dish[$i]['id_dish'] . ')">В корзину</button>
                                    </div>
                                </div>
                            </div>';
        }

        include 'contacts.php';
        include 'footer.php';
        ?>
    </section>
    
</body>

</html>