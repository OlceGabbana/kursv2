<?php
session_start();
if(!$_SESSION['user']){
    header('Location: login.php');
} else if ($_SESSION['user']['role_user'] !== "Администратор"){
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
                <input class="side_menu" type="checkbox" id="side_menu"/>
                <label class="hamb" for="side_menu"><span class="hamb_line"></span></label>
                <a href="#" class="side_menu_img"><img src="assets/img/logo.svg" alt="logo"></a>
            <nav>
                <ul>
                    <a href="menu.php?category=Завтраки"><li>Меню</li></a>
                    <a href="#contacts"><li>Контакты</li></a>
                    <a href="vendor/logout.php"><li>Выход</li></a>
                    <a href="booking.php"><li class="highlight btn1">Бронь столика</li></a>
                </ul>
            </nav>
        </div>
    </header>
    
    <section class="landing_page">
        <section class="main_landing">
            <h2  class="maxi_header">Здравствуйте, администратор <?= $_SESSION['user']['name_user']?></h2>
            <div class="info_user">
                <p><span>Ваше ФИО:</span> <?php echo $_SESSION['user']['surn_user'].' ';
                    echo $_SESSION['user']['name_user'].' ';
                    echo $_SESSION['user']['fname_user'];
                ?></p>
                <p><span> Ваш номер телефона:</span> <?= $_SESSION['user']['phone_user']?></p>
                <p><span>Ваш e-mail адрес:</span> <?= $_SESSION['user']['email_user']?></p>
                <p>Что будем делать?</p>
                <div class="func_admin">
                    <a href="menu.php?category=Завтраки"><button class="highlight">Перейти в редактор меню</button></a>
                    <button  class="highlight">Управлять бронированием</button>
                </div>
            </div>
        </section>
        
    <?php 
        include 'contacts.php';
        include 'footer.php';
    ?>
    </section>
</body>
</html>