
<?php
        session_start();
        include 'vendor/connect.php';
        if(isset($_POST['myArray'])){
        $myArray = $_POST['myArray'];
      
        // Подключение к базе данных (здесь предполагается использование MySQL)
        
      
        try {
          
          if (!isset($_SESSION['user'])) {
            echo 'Нужно войти в аккаунт';
          } else {
          $date = date('Y-m-d H:i:s');
          $stmt1 = $connection->prepare("INSERT INTO `orders`(`date_order`, `sum_order`, `users_id_user`) VALUES ('$date',". $_SESSION['orders']['LastOrder']['total_price'] .",".$_SESSION['user']['id_user'].")");
          $stmt1->execute();
          
          
          // Получение ID последней вставленной записи в таблицу orders
          $order_id = $connection->lastInsertId();

          // Подготовленный запрос для вставки массива в базу данных
          $stmt = $connection->prepare("INSERT INTO orders_has_dishes (`orders_id_order`, `dishes_id_dish`, `value`) VALUES ('$order_id' , :dishes_id_dish, :kolvo)");
          
          

        // Удаляем квадратные скобки из строки
        $myArray = str_replace(['{', '}', '"'], '', $myArray);
        // Разбиваем строку на массив
        $array = explode(',',$myArray);

        // Удаляем лишние пробелы у каждого элемента массива
        $array = array_map('trim', $array);
        

        for ($i=0; $i < count($array); $i++) {
          $str = $array[$i];
          $array1[$i]['id'] =  strstr($str, ':', true);
          $array1[$i]['value'] =  strstr($str, ':');
          $array1[$i]['value'] = mb_substr($array1[$i]['value'], 1);
        }
          $index = 0;
          foreach ($array1 as $value) {
            // Привязка значения к параметру запроса
            $stmt->bindParam(':dishes_id_dish', $_SESSION['dishes'][$index]);
            $stmt->bindParam(':kolvo', $array1[$index]['value']);
            $index++;
            // Выполнение запроса
            $stmt->execute();
          }
      
      
          // Возвращение ответа
          echo 'Заказ оформлен';
        }
        } catch(PDOException $e) {
          // Обработка ошибок подключения к базе данных
          echo 'Ошибка подключения к базе данных: ' . $e->getMessage();
        }
      }
      
?>