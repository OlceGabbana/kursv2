<?php
session_start();
if (isset($_SESSION['user'])) {
    if(($_SESSION['user']['role_user']) == "Пользователь"){
        header('Location: accountUser.php');
    } else if(($_SESSION['user']['role_user']) == "Администратор"){
        header('Location: accountAdmin.php');
    } else if(($_SESSION['user']['role_user']) == "Модератор"){
        header('Location: accountModer.php');
    }
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
                    <a href="booking.php"><li class="highlight btn1">Бронь столика</li></a>
                </ul>
            </nav>
            </div>
    </header>

        <section class="landing_page">
        <section class="main_landing">
        <h2 class="maxi_header ">Вход в аккаунт</h2>
            <form method="post" action="" name="signup_form" class="signup_form">
                <div class="form_element">
                    <label>E-mail</label>
                    <input type="email" name="email_user" required />
                </div>
                <div class="form_element">
                    <label>Пароль</label>
                    <input type="password" name="password" required />
                </div>
                <button class="btn highlight" type="submit" name="login" value="login">Войти</button>
                <p>Нет аккаунта? - <a href="register.php">Зарегистрируйтесь</a>.</p>
            </form>
            <?php 
                session_start();
                include('vendor/connect.php'); 
                if (isset($_POST['login'])) { 
                    $email_user = $_POST['email_user']; 
                    $password = $_POST['password']; 
                    $query = $connection->prepare("SELECT * FROM `users` WHERE email_user=:email_user"); 
                    $query->bindParam("email_user", $email_user, PDO::PARAM_STR); 
                    $query->execute(); 
                    $user = $query->fetch(PDO::FETCH_ASSOC); 
                    if (!$user) {
                        $_SESSION['msg'] = 'Неверный логин или пароль!';
                    } else { 
                        if (password_verify($password, $user['hash_pw_user'])) {
                            
                            $_SESSION['user'] = [
                                "id_user" => $user['id_user'],
                                "name_user" => $user['name_user'],
                                "surn_user" => $user['surn_user'],
                                "fname_user" => $user['fname_user'],
                                "phone_user" => $user['phone_user'],
                                "role_user" => $user['role_user'],
                                "email_user" => $user['email_user']
                            ];
                            
                            switch ($_SESSION['user']['role_user']){ 
                            case "Пользователь": $redirect_url = "accountUser.php"; break;  
                            case "Администратор": $redirect_url = "accountAdmin.php"; break; 
                            default: $redirect_url = "accountUser.php"; 
                            }
                            $_SESSION['msg'] = 'Поздравляем, вы прошли авторизацию!';
                            echo "<script>window.location = \" ${redirect_url} \";</script>"; 
                            
                        } else {
                            $_SESSION['msg'] = 'Неверный пароль!';
                        } 
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
    </body>
</html>