<?php
session_start();
if (!$_SESSION['user']) {
    header('Location: login.php');
}
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
    include 'left_panel.php';
    ?>
    <header class="for_menu">
        <div class="mobile_menu">
            <input class="side_menu" type="checkbox" id="side_menu" />
            <label class="hamb" for="side_menu"><span class="hamb_line"></span></label>
            <a href="#" class="side_menu_img"><img src="assets/img/logo.svg" alt="logo"></a>
            <nav>
                <ul>
                    <a href="menu.php?category=Завтраки">
                        <li>Меню</li>
                    </a>
                    <a href="#contacts">
                        <li>Контакты</li>
                    </a>
                    <a href="vendor/logout.php">
                        <li>Выход</li>
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
            <h2 class="maxi_header">Здравствуйте, <?= $_SESSION['user']['name_user'] ?></h2>
            <div class="info_user">

                <p><span>Ваше ФИО:</span> <?php echo $_SESSION['user']['surn_user'] . ' ';
                                            echo $_SESSION['user']['name_user'] . ' ';
                                            echo $_SESSION['user']['fname_user'];
                                            ?></p>
                <p><span> Ваш номер телефона:</span> <?= $_SESSION['user']['phone_user'] ?></p>
                <p><span>Ваш e-mail адрес:</span> <?= $_SESSION['user']['email_user'] ?></p>
            </div>
        </section>
        <?php
        include 'vendor/connect.php';
        if (isset($_POST['delete_reservation'])) {
            $query = $connection->prepare("DELETE FROM `reservations` WHERE id_reservation=:id_reservation");
            $query->bindParam("id_reservation", $_POST['delete_reservation'], PDO::PARAM_STR);
            $query->execute();
            echo '<meta http-equiv="refresh" content="0">';
        }
        ?>
        <br><br><br><br><br>

        <form action="" method="post">
            <div class="page_bookings">

                <div class="container_bookings">
                    <?php
                    $query = $connection->prepare("SELECT reservations.*, tables.*, users.*
                                                FROM reservations
                                                JOIN tables ON reservations.has_id_table = tables.id_table
                                                JOIN users ON reservations.has_id_user = id_user;");
                    $result = $query->execute();
                    $reservations = $query->fetchAll(PDO::FETCH_ASSOC);
                    for ($i = 0; $i < count($reservations); $i++) {
                        if ($reservations[$i]['id_user'] == $_SESSION['user']['id_user']) {
                            $barcode = 100000000000 + strtotime($reservations[$i]['date_reservation']) + $reservations[$i]['id_reservation'] + $reservations[$i]['id_user'];
                            echo '
                         <div class="bookings_block">
                            <div class="bookings_item"> 
                                <span style="text-align: center;">OOO «GRADIENT»</span>
                                <p>Кассовый чек № ' . $reservations[$i]['id_reservation'] . '</p>
                                <hr>
                                <p>Дата бронирования: <br> ' . $reservations[$i]['date_reservation'] . '</p>
                                <p>Начало действия брони: <br> <strong>' . $reservations[$i]['time_begin_reservation'] . '</strong></p>
                                <div class="check_between"> <span>Компьютер №</span><span>' . $reservations[$i]['has_id_table'] . '</span> </div>
                                <div class="check_between"> <span>Длительность:</span><span>1 ЧАС</span> </div>
                                <div class="check_between"> <span>ИТОГО К ОПЛАТЕ</span><span>= ' . $reservations[$i]['price_hour_table'] . '&#8381;</span></div>
                            </div>
                            <div class="check_between">
                                <button class="delete_reservation" name="delete_reservation" type="submit" value="' . $reservations[$i]['id_reservation'] . '">Редактировать</button>
                                <button class="delete_reservation" name="delete_reservation" type="submit" value="' . $reservations[$i]['id_reservation'] . '">Удалить</button>
                            </div>
                            
                        </div>
                        ';
                        }
                    } ?>

                </div>
        </form>
        </div>
        >
        <div class="page_bookings">

            <div class="container_bookings">

                <?php



                try {
                    // SQL-запрос для выборки новостей из базы данных
                    // Предполагается, что у вас есть таблица "news" с колонками "title", "content" и "date"

                    // Выполнение SQL-запроса
                    $query = $connection->prepare("SELECT dishes.*, orders.*, users.name_user, users.phone_user ,orders_has_dishes.value FROM orders_has_dishes
                                                JOIN dishes ON orders_has_dishes.dishes_id_dish = dishes.id_dish
                                                JOIN orders ON orders_has_dishes.orders_id_order = orders.id_order
                                                JOIN users ON users.id_user = orders.users_id_user;");
                    $query->execute();
                    $result = $query->fetchAll(PDO::FETCH_ASSOC);
                    for ($i_orders = 0; $i_orders < count($result); $i_orders++) {
                        $id_order = $result[$i_orders]['id_order'];
                        $_FILES['orders'][$id_order]['name'] = $result[$i_orders]['name_user'];
                        $_FILES['orders'][$id_order]['phone'] = $result[$i_orders]['phone_user'];
                        $_FILES['orders'][$id_order]['sum_order'] = $result[$i_orders]['value'];
                        $_FILES['orders'][$id_order]['dishes'][0] = 'Товары:';
                        $_FILES['orders'][$id_order]['prices'][0] = 0;
                        $_FILES['orders'][$id_order]['kolvo'][0] = '';
                        array_push($_FILES['orders'][$id_order]['dishes'], $result[$i_orders]['name_dish']);
                        array_push($_FILES['orders'][$id_order]['prices'], $result[$i_orders]['price_dish']);
                        $_FILES['orders'][$id_order]['itog'] = $_FILES['orders'][$id_order]['prices'];
                        array_push($_FILES['orders'][$id_order]['kolvo'], $result[$i_orders]['value']);
                    }
                    // Перебор результатов и вывод новостей

                    foreach ($_FILES['orders'] as $key => $value) {
                        $name = $_FILES['orders'][$key]['name'];
                        $id_order = $key;
                        $phone = $_FILES['orders'][$key]['phone'];
                        $sum_order = $phone = $_FILES['orders'][$key]['sum_order'];
                        $dishes = $_FILES['orders'][$key]['dishes'];
                        $kolvo = $_FILES['orders'][$key]['kolvo'];
                        if ($_SESSION['user']['name_user'] == $name) {
                            echo "<div class='bookings_block'><br><br>" . $id_order . "<br>" . $phone;
                            for ($i = 0; $i < count($dishes); $i++) echo '<br>' . $dishes[$i] . ' - ' . $kolvo[$i] . ' шт.';
                            echo "<br>Заказчик - " . $name . '<br>' . $sum_order . '</div>';
                        }
                    }
                } catch (PDOException $e) {
                    echo "Ошибка: " . $e->getMessage();
                }
                ?>
            </div>
        </div>


        <?php
        include 'contacts.php';
        include 'footer.php';
        ?>
    </section>
</body>

</html>