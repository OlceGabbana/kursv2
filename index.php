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
    <section class="landing_page">
        <section class="main_fs">
            <!--main-fs - главная страница первый экран(first screen)-->
            <header class="main-header">

                <div class="mobile_menu">
                    <input class="side_menu" type="checkbox" id="side_menu"/>
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
                        <a href="login.php">
                            <li>Личный кабинет</li>
                        </a>
                        <a href="booking.php">
                            <li class="highlight btn1">Бронь столика</li>
                        </a>
                    </ul>
                </nav>
                </div>
                </div>
            </header>
            <h1>Здоровая пища? Это про нас! <br>
                Кафе Olce&Gabbana</h1>
        </section>
        <section class="main_landing">
            <div class="blocks">
                <h3 class="mini_header">О ресторане</h3>
                <section class="block">
                    <div class="text_col">
                        <h2 class="maxi_header">Olce <br>& <br> Gabbana</h2>
                    </div>
                    <div class="text_col">
                        <p>Sed vel ornare ut rhoncus, ac ut nibh. Amet at sit et nibh. In lectus phasellus non ornare eget velit. Facilisi urna, tristique dui, rhoncus, dolor. Tincidunt enim gravida dignissim leo pulvinar sit volutpat nulla vestibulum. </p>
                        <p>Morbi pellentesque enim massa laoreet vel id. Lectus ac, facilisis neque turpis. Morbi massa enim nullam sem vehicula. Amet quis pellentesque enim porttitor lectus interdum. Nisi, faucibus pharetra at porttitor. Fringilla luctus pretium in viverra. In adipiscing tempor amet malesuada ullamcorper ut sagittis. Dui, scelerisque vulputate risus massa dictum. Cras at quis in eu, faucibus feugiat vel. At.</p>
                    </div>
                </section>
                <h3 class="mini_header">Меню</h3>
                <section class="block">
                    <div class="text_col">
                        <h2 class="maxi_header">Меню</h2>
                    </div>
                    <div class="text_col">
                        <p>At faucibus nullam mauris vitae ut non. Augue libero non nibh nec, et eget erat. Nascetur nunc neque, varius massa aliquam interdum turpis massa. Ac tortor aliquam risus, interdum nisl mauris sit. Ut placerat fermentum pellentesque ac at. Vitae venenatis faucibus urna mi eget vitae quam eu. Euismod sed mauris id turpis iaculis. Erat rutrum dolor, vitae morbi.</p>
                        <p>Nunc cras cras aliquet blandit faucibus massa sagittis semper. </p>
                    </div>
                </section>
                <section class="block">
                    <div class="text_col">
                        <a href="menu.php?category=Завтраки">
                            <img src="assets/img/mainmenu.png" alt="main-menu">
                            <p>Основное меню</p>
                        </a>

                    </div>
                    <div class="text_col">
                        <a href="menu.php?category=Напитки">
                            <img src="assets/img/barmenu.png" alt="bar-menu">
                            <p>Меню напитков</p>
                        </a>
                    </div>
                </section>
                <h3 class="mini_header">Заказ</h3>
                <section class="block">
                    <div class="text_col">
                        <h2 class="maxi_header">Заказ блюд на самовывоз</h2>
                    </div>
                    <div class="text_col">
                        <p>Sed vel ornare ut rhoncus, ac ut nibh. Amet at sit et nibh. In lectus phasellus non ornare eget velit. Facilisi urna, tristique dui, rhoncus, dolor. Tincidunt enim gravida dignissim leo pulvinar sit volutpat nulla vestibulum. </p>
                        <p>Morbi pellentesque enim massa laoreet vel id. Lectus ac, facilisis neque turpis. Morbi massa enim nullam sem vehicula. Amet quis pellentesque enim porttitor lectus interdum. Nisi, faucibus pharetra at porttitor. Fringilla luctus pretium in viverra. In adipiscing tempor amet malesuada ullamcorper ut sagittis. Dui, scelerisque vulputate risus massa dictum. Cras at quis in eu, faucibus feugiat vel. At.</p>

                    </div>
                </section>
                <?php
                include 'contacts.php'
                ?>

        </section>
        </div>
    </section>
    <?php
    include 'footer.php'
    ?>
    </section>

</body>

</html>