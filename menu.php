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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <title>Кафе здорового питания Olce&Gabbana</title>
</head>

<body>
    <script src="assets/js/sweetalert2.all.min.js"></script>
    <script>
        function swalfunc() {
            Swal.fire({
                icon: 'error',
                title: 'wsdwds',
                text: 'Something went wrong!',
                footer: '<a href="register.php">Why do I have this issue?</a>',
            })
        }
    </script>
    <?php
    include 'left_panel.php';
    include('vendor/connect.php');
    ?>
    <header class="for_menu">
        <div class="mobile_menu">
            <input class="side_menu" type="checkbox" id="side_menu" />
            <label class="hamb" for="side_menu"><span class="hamb_line"></span></label>
            <a href="index.php" class="side_menu_img"><img src="assets/img/logo.svg" alt="logo"></a>
            <nav>
                <ul>
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


    <div id="modal" class="modal">
        <div class="modal_content">
            <span class="close">&times;</span>
            <h2>Корзина</h2>
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
                <div id="delBuscket"></div>
                <div class="foot_modal_form">
                    <p>Итоговая сумма заказа: <input type="text" readonly="readonly" id="total-price" name="total_price" value="" /> &#8381;</p>
                    <?php
                    if (isset($_SESSION['user'])) echo '<a href="make_order.php"><button id="checkout_button" class="checkout_button" onclick="swalfunc2();" name="checkout_button">Перейти к оформлению заказа</button></a>';
                    else echo '<button id="checkout_button" class="checkout_button" onclick="swalfunc();" name="checkout_button">Перейти к оформлению заказа</button>';
                    ?>
                </div>
            </div>
        </div>
        <p id="cart-info"></p>
    </div>
    <div class='shopping_busket'>
        <div id="openModalBtn" onclick="OpenModalBtn('openModalBtn')" class='shopping_busket_back'>
            <div id="allsum1"></div>
            <img src="assets/img/shopping-basket.svg" alt="">
        </div>
    </div>

    <section class="landing_page">
        <section class="main_landing">
            <h2 class="maxi_header">Меню</h2>
            <div class="categories">
                <ul>
                    <?php
                    $query = $connection->prepare("SELECT * FROM `categories`");
                    $query->execute();
                    $category = $query->fetchAll(PDO::FETCH_ASSOC);
                    $name_category;
                    for ($i = 0; $i < count($category); $i++) {
                        $name_category = 'menu.php?category=' . $category[$i]['name_category'];
                        echo '<li>' . '<a href="' . $name_category . '"><button>' . $category[$i]['name_category'] . '</button></a>' . '</li>';
                        parse_url($name_category);
                    }
                    if (isset($_SESSION['user'])) {
                        if ($_SESSION['user']['role_user'] == "Администратор") {
                            echo '<div class="categories_btn">
                                    <button id="addCategoryButton"><i class="fas fa-plus"></i></button>
                                    <button id="editCategoryButton"><i class="fas fa-edit"></i></button>
                                    <button id="deleteCategoryButton"><i class="fas fa-trash"></i></button>
                                </div>
                                
                                <!-- Модальное окно добавить категорию -->
                                <div id="addCategoryModal" style="display: none;">
                                    <form id="addCategoryForm">
                                    <input type="text" id="categoryName" placeholder="Название категории" required>
                                    </form>
                                </div>
                                
                                <!-- Модальное окно -->
                                <div id="editCategoryModal" style="display: none;">
                                    <form id="editCategoryForm">
                                    <select id="categorySelect">
                                        <!-- Опции для выбора категории будут добавлены через AJAX -->
                                    </select>
                                    <br>
                                    <input type="text" id="newCategoryName" placeholder="Новое название категории" required>
                                    </form>
                                </div>
                                
                                <!-- Модальное окно -->
                                <div id="deleteCategoryModal" style="display: none;">
                                    <form id="deleteCategoryForm">
                                    <select id="categorySelect">
                                        <!-- Опции для выбора категории будут добавлены через AJAX -->
                                    </select>
                                    </form>
                                </div>    
                            ';
                        }
                    }
                    ?>
                </ul>
            </div>
            <?php
            if (isset($_GET['category'])) {
                $category = $_GET['category'];
                echo '<section class="main_landing"><h3 class="mini_header category">' . $category . '</h3></section>';
                if (isset($_SESSION['user'])) {
                    if ($_SESSION['user']['role_user'] == "Администратор") {
                        echo '<div class="add_dish">
                                <div>
                                    <a href="add_dish.php">
                                    <i class="fas fa-plus"></i>
                                        <p>Добавить блюдо в меню</p>
                                    </a>
                                    <a href="edit_dish.php">
                                    <i class="fas fa-edit"></i>
                                        <p>Редактировать блюдо</p>
                                    </a>
                                </div>
                                <div>
                                    <a href="add_category_to_dish.php">
                                    <i class="fas fa-plus"></i>
                                        <p>Добавить категорию товара</p>
                                    </a>
                                    <a href="del_category_to_dish.php">
                                    <i class="fas fa-minus"></i>
                                        <p>Удалить категорию товара</p>
                                    </a>
                                </div>
                                </div>';
                    }
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
                    if ($dish[$i]['name_category'] == $category) {
                        echo '<div class="dish">
                                <div class="ud">';
                        if (isset($_SESSION['user'])) {
                            if ($_SESSION['user']['role_user'] == "Администратор") {
                                echo '<form method="POST" name="delete_dish">
                                    <button class="delete_dish" name="delete_dish" value="' . $dish[$i]['id_dish'] . '"><img src="assets/img/delete.svg" class="delete_img"></button>
                                    </form>
                                ';
                            }
                        }
                        echo '</div>
                                <img src="' . $dish[$i]['file_path_dish'] . '" alt="">
                                <div class="dish_info">
                                    <h2 class="name_dish" id_db="' . $dish[$i]['id_dish'] . '">' . $dish[$i]['name_dish'] . '</h2>
                                    <div class="price_and_btn">
                                        <h3 class="price_dish">' . $dish[$i]['price_dish'] . ' &#8381;</h3>
                                        <button class="btn btn_small" onclick="addProduct(' . $sravn[$dish[$i]['id_dish']] . ')">В корзину</button>
                                    </div>
                                </div>
                            </div>';
                    } else {
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
                }

                if (isset($_POST['delete_dish'])) {
                    $id = $_POST['delete_dish'];
                    $query = $connection->prepare("DELETE FROM `dishes` WHERE `id_dish` = :id");
                    $query->bindParam(":id", $id, PDO::PARAM_STR);
                    $query->execute();
                    echo '<meta http-equiv="refresh" content="0">';
                    echo '<script>localStorage.clear();</script>';
                }
            }
            echo '</div>';

            ?>
        </section>
        <?php
        include 'contacts.php';
        include 'footer.php';
        ?>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/category.js"></script>
    <script src="assets/js/dishes.js"></script>
</body>

</html>