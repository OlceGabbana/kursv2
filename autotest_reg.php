<?php
$_POST['name_user'] = 'John';
$_POST['surn_user'] = 'Doe';
$_POST['fname_user'] = 'Smith';
$_POST['phone_user'] = '123456789';
$_POST['email_user'] = 'john.doe@example.com';
$_POST['password'] = 'password123';
$_POST['password_confirm'] = 'password123';

ob_start();
include('register.php');
$output = ob_get_clean();

if (strpos($output, 'Регистрация прошла успешно!') == false) {
    echo "Тест успешно пройден!";
} else {
    echo "Тест не пройден!";
}
?>
