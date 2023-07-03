<?php
session_start();
if(isset($_SESSION['user'])){
    header('Location: accountUser.php');
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
    <header class="register">
            <div class="mobile_menu">
                <input class="side_menu" type="checkbox" id="side_menu"/>
                <label class="hamb" for="side_menu"><span class="hamb_line"></span></label>
                <a href="#" class="side_menu_img"><img src="assets/img/logo.svg" alt="logo"></a>
            
            <nav>
                <ul>
                    <a href="menu.php?category=Завтраки"><li>Меню</li></a>
                    <a href="#contacts"><li>Контакты</li></a>
                    <a href=""><li class="highlight btn1">Бронь столика</li></a>
                </ul>
            </nav>
            </div>
        </header>
        
        <section class="landing_page">
        <section class="main_landing">
        <h2 class="maxi_header">Регистрация</h2>
        
            <form method="post" action="" name="signup_form" class="signup_form">
                <div class="form_element">
                    <label>Ваше имя</label>
                    <input type="text" name="name_user" pattern="[а-яА-Я0-9]+" required placeholder="Иван"/>
                </div>
                <div class="form_element">
                    <label>Ваша фамилия</label>
                    <input type="text" name="surn_user" pattern="[а-яА-Я0-9]+" required placeholder="Сергеев"/>
                </div>
                <div class="form_element">
                    <label>Ваше отчество</label>
                    <input type="text" name="fname_user" pattern="[а-яА-Я0-9]+" required placeholder="Иванович"/>
                </div>
                <div class="form_element">
                    <label>Ваш номер телефона</label>
                    <input type="tel" name="phone_user" data-phone-pattern required/>
                </div>
                
                <div class="form_element">
                    <label>E-mail</label>
                    <input type="email" name="email_user" required  placeholder="email@email.com"/>
                </div>
                <div class="form_element">
                    <label>Пароль</label>
                    <input type="password" name="password" required />
                </div>
                <div class="form_element">
                    <label>Повторите пароль</label>
                    <input type="password" name="password_confirm" required />
                </div>
                <button class="btn highlight" type="submit" name="register" value="register">Зарегистрироваться</button>
                <p>Уже есть аккаунт? - <a href="login.php">Войдите</a>.</p>
            </form>
            <?php
                include('vendor/connect.php');
                if (isset($_POST['register'])) {
                    $name_user = $_POST['name_user']; 
                    $surn_user = $_POST['surn_user']; 
                    $fname_user = $_POST['fname_user'];  
                    $phone_user = $_POST['phone_user'];
                    $email_user = $_POST['email_user']; 
                    $password = $_POST['password'];
                    $password_confirm = $_POST['password_confirm'];
                    $hash_pw_user = password_hash($password, PASSWORD_BCRYPT);
                    $query = $connection->prepare("SELECT * FROM `users` WHERE email_user=:email_user"); 
                    $query->bindParam("email_user", $email_user, PDO::PARAM_STR); 
                    $query->execute(); 
                    if ($query->rowCount() > 0) { 
                        $_SESSION['msg'] = 'Этот адрес уже зарегистрирован!';
                    } else {
                        if ($_REQUEST['password'] !== $_REQUEST['password_confirm']){
                            $_SESSION['msg'] = 'Введенные пароли не совпадают!'; 
                    } else {
                            if ($query->rowCount() == 0) { 
                            $query = $connection->prepare("INSERT INTO `users`(name_user,surn_user,fname_user,phone_user,email_user,hash_pw_user) 
                            VALUES ('${name_user}','${surn_user}','${fname_user}','${phone_user}','${email_user}','${hash_pw_user}')"); 
                            $user = $query->execute(); 
                            if ($user) { 
                                $_SESSION['msg'] = 'Регистрация прошла успешно!';
                                $query = $connection->prepare("SELECT * FROM `users` WHERE email_user=:email_user"); 
                                $query->bindParam("email_user", $email_user, PDO::PARAM_STR); 
                                $query->execute(); 
                                $user = $query->fetch(PDO::FETCH_ASSOC);
                                $_SESSION['user'] = [
                                    "id_user" => $user['id_user'],
                                    "name_user" => $user['name_user'],
                                    "surn_user" => $user['surn_user'],
                                    "fname_user" => $user['fname_user'],
                                    "phone_user" => $user['phone_user'],
                                    "role_user" => $user['role_user'],
                                    "email_user" => $user['email_user']
                                ];
                                
                                $_SESSION['msg'] = ' green_msg">Регистрация прошла успешно!';
                                echo '<script>window.location = "login.php";</script>'; 
                            } else { 
                                $_SESSION['msg'] = '">Неверные данные!';
                            } 
                                
                        } 
                    }
                        
                }
                    
            }
            ?>
            <?php
                if(isset($_SESSION['msg'])) {
                    echo '<p class="msg'.$_SESSION['msg'].'</p>';
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