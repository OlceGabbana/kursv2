<?php
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <link rel="stylesheet" href="assets/style/style.css">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Компьютерный клуб "GRADIENT"</title>
</head>

<body>
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
        <a href="menu.php?category=Завтраки"><li>Меню</li></a>
          <a href="login.php">
            <li>Личный кабинет</li>
          </a>
          <a href="menu.php#contacts">
            <li>Контакты</li>
          </a>
          <a href="booking.php"><li class="highlight btn1">Бронь столика</li></a>
        </ul>
      </nav>
    </div>
  </header>

  <section class="landing_page">
    <section class="main_landing">
      
  <?php
  include 'vendor/connect.php';

  //Проверка свободного места для бронирования
  $query = $connection->prepare("SELECT reservations.*, tables.*, users.*
                                    FROM reservations
                                    JOIN tables ON reservations.has_id_table = tables.id_table
                                    JOIN users ON reservations.has_id_user = id_user
                                    WHERE reservations.time_begin_reservation > '" . date("y-m-d H:i:s") . "';");
  $result = $query->execute();
  $reservations = $query->fetchAll(PDO::FETCH_ASSOC);

  //вывод количества столов
  $query = $connection->prepare("SELECT * FROM  tables;");
  $result = $query->execute();
  $tables = $query->fetchAll(PDO::FETCH_ASSOC);


  for ($i = 0; $i < Count($reservations); $i++) {
    for ($i2 = 1; $i2 <= count($tables); $i2++) {
      if ($reservations[$i]['has_id_table'] == $i2) {
        for ($i3 = 0; $i3 < $reservations[$i]['duration_reservation']; $i3++) {
          $convert = (string)$reservations[$i]['time_begin_reservation'];
          $_FILES['table_' . $i2][date("y-m-d", strtotime($convert) + 3600 * ($i3))][date("G", strtotime($convert) + 3600 * ($i3))] = 1; //date("H:i:s", strtotime($convert) + 3600 * ($i3))
          asort($_FILES['table_' . $i2][date("y-m-d", strtotime($convert) + 3600 * ($i3))]);
          asort($_FILES['table_' . $i2]);
        }
      }
    }
  }
  ?>

  <?php
  $_SERVER['ValueDaysForBooking'] = 7; //на какое количество дней вперед пользователь может сделать бронь

  if (isset($_POST['button_booking'])) { //Обработка формы бронирования
    $date_booking = $_POST['date_booking'];
    $time_booking = $_POST['time_booking'];
    $duration_booking = 1;
    $datetime_booking = "$date_booking $time_booking";
    for ($i = 1; $i <= count($tables); $i++) {
      if (isset($_FILES['table_' . $i][$date_booking])) {
        for ($i1 = 0; $i1 < $_SERVER['ValueDaysForBooking']; $i1++) {
          if (isset($_FILES['table_' . $i][date("y-m-d", strtotime(date("y-m-d"))  + 3600 * 24 * ($i1))])) {
            $date_sravn = date("y-m-d", strtotime(date("y-m-d"))  + 3600 * 24 * ($i1));
            if ($date_sravn == $date_booking) {
              $time_booking = $_POST['time_booking'];
              for ($i2 = 0; $i2 < 24; $i2++) {
                if (isset($_FILES['table_' . $i][date("y-m-d", strtotime(date("y-m-d"))  + 3600 * 24 * ($i1))][$i2]) && ($time_booking < ($_POST['time_booking'] * 1 + 1))) {
                  if ($i2 == $time_booking) {
                    if (!isset($numb[$time_booking])) {
                      $numb[$time_booking][$i] = true;
                    } else {
                      $numb[$time_booking][$i] = true;
                    }
                  }
                }
                if ($i2 == $time_booking) {
                  $time_booking++;
                }
              }
            }
          }
        }
      }
    }

    if (isset($numb[$_POST['time_booking']])) {
      if (Count($numb[$_POST['time_booking']]) !== count($tables)) {
        for ($i = 1; $i <= count($tables); $i++) {
          for ($i1 = 0; $i1 < 24; $i1++) {
            if (!isset($numb[$_POST['time_booking']][$i])) {
              $query = $connection->prepare("INSERT INTO `reservations` (`date_reservation`, `time_begin_reservation`, `duration_reservation`, `has_id_user`, `has_id_table`) VALUES ('" . date("y-m-d H:i:s") . "', '$datetime_booking', '$duration_booking', '" . $_SESSION['user']['id_user'] . "', $i);");
              $result = $query->execute();
              echo 'Успешно! ---- ваш столик под номером - ' . $i . '<br>';
              break 2;
            }
          }
        }
      } else {
        echo 'На это время все столики заняты';
      }
    } else {
      $query = $connection->prepare("INSERT INTO `reservations` (`date_reservation`, `time_begin_reservation`, `duration_reservation`, `has_id_user`, `has_id_table`) VALUES ('" . date("y-m-d H:i:s") . "', '$datetime_booking', '$duration_booking', '" . $_SESSION['user']['id_user'] . "', '1');
                ");
      $result = $query->execute();
      echo 'Успешно! ---- ваш столик под номером - 1<br>';
    }
  }
  ?>

  <section class="form_inputs">
    <form action="" method="post">
      <div class="form_row">
        <label for="date_booking">Выберите дату</label>
        <select name="date_booking" id="date_booking"> <!-- Дата бронирования -->
          <?php
          //Вывод доступных дат для бронирования
          $date = date("y-m-d");
          for ($i = 0; $i < $_SERVER['ValueDaysForBooking']; $i++) {
            $week = date('w', time() + 86400 * ($i + 1)); // Определение дня недели
            $days = array(0 => "Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"); // Массив для перевода дня недели из числа в слово
            $week = $days[$week];
            echo "<option value=\"" . date('y-m-d', time() + 86400 * ($i + 1)) . "\">" . date('d.m.20y', time() + 86400 * ($i + 1)) . " - " . $week . "</option>"; // Ввывод на сайт
          }
          ?>
        </select>
      </div>
      <div class="form_row">
        <label for="time_booking">Выберите время</label> <!-- Даты для бронирования -->
        <select name="time_booking" id="time_booking">
          <?php
          for ($i = 0; $i < 24; $i++) {
            if (isset($numb[$i]) == $i) {
              echo "<option style='color: yellow;' value='$i'>$i:00</option>";
            } else {
              echo "<option style='color: black;' value='$i'>$i:00</option>";
            }
          }
          ?>
        </select>
      </div>
      <button type="submit" id="button_booking" value="button_booking" name="button_booking">Забронировать</button>
    </form>
  </section>
</section>
  <?php
    include 'footer.php';  
  ?>
 
  
  </section>
 
</body>

</html>