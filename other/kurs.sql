-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 23 2023 г., 09:11
-- Версия сервера: 8.0.30
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `kurs`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id_category` int NOT NULL,
  `name_category` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id_category`, `name_category`) VALUES
(1, 'Завтраки'),
(2, 'Салаты'),
(3, 'Супы'),
(4, 'Гарниры'),
(5, 'Мясо'),
(6, 'Рыба'),
(12, 'Детское меню'),
(14, 'Напитки'),
(34, 'Максим');

-- --------------------------------------------------------

--
-- Структура таблицы `dishes`
--

CREATE TABLE `dishes` (
  `id_dish` int NOT NULL,
  `name_dish` varchar(100) DEFAULT NULL,
  `price_dish` decimal(9,2) DEFAULT NULL,
  `file_path_dish` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `desc_dish` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `dishes`
--

INSERT INTO `dishes` (`id_dish`, `name_dish`, `price_dish`, `file_path_dish`, `desc_dish`) VALUES
(98, 'Лобстер АЛисон', '5500.00', 'assets/img/dishes/16873265717.png', 'лоукслутдстдуьь'),
(99, 'алнрнл', '35663.00', 'assets/img/dishes/1687282603.4.png', 'кгекне'),
(100, 'Скрэмбл', '1039.00', 'assets/img/dishes/1687335705.1.png', 'пекпекпек'),
(101, 'МАУС', '555.00', 'assets/img/dishes/1687337293.6.png', 'liervgnglel'),
(102, 'Максим', '5000.00', 'assets/img/dishes/16874228952.png', 'Максим'),
(103, 'Крем-брюле', '423853.00', 'assets/img/dishes/1687424463.1.png', 'ерекр');

-- --------------------------------------------------------

--
-- Структура таблицы `dishes_has_categories`
--

CREATE TABLE `dishes_has_categories` (
  `dishes_id_dish` int NOT NULL,
  `categories_id_category` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `dishes_has_categories`
--

INSERT INTO `dishes_has_categories` (`dishes_id_dish`, `categories_id_category`) VALUES
(100, 1),
(101, 1),
(103, 1),
(100, 2),
(101, 2),
(100, 3),
(101, 3),
(100, 5),
(103, 12),
(102, 34);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id_order` int NOT NULL,
  `date_order` datetime(6) DEFAULT NULL,
  `sum_order` decimal(9,2) DEFAULT NULL,
  `users_id_user` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id_order`, `date_order`, `sum_order`, `users_id_user`) VALUES
(199, '2023-06-17 09:00:45.000000', '2473.44', NULL),
(200, '2023-06-17 09:00:49.000000', '2473.44', NULL),
(201, '2023-06-17 09:01:02.000000', '2473.44', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `orders_has_dishes`
--

CREATE TABLE `orders_has_dishes` (
  `orders_id_order` int NOT NULL,
  `dishes_id_dish` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `reservations`
--

CREATE TABLE `reservations` (
  `id_reservation` int NOT NULL,
  `date_reservation` datetime DEFAULT NULL,
  `time_begin_reservation` datetime DEFAULT NULL,
  `duration_reservation` int DEFAULT NULL,
  `has_id_user` int NOT NULL,
  `has_id_table` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `reservations`
--

INSERT INTO `reservations` (`id_reservation`, `date_reservation`, `time_begin_reservation`, `duration_reservation`, `has_id_user`, `has_id_table`) VALUES
(172, '2023-05-30 00:09:52', '2023-06-02 06:00:00', 5, 3, 1),
(175, '2023-05-30 00:44:34', '2023-06-03 06:00:00', 11, 3, 2),
(176, '2023-06-01 19:35:51', '2023-06-02 06:00:00', 1, 3, 3),
(177, '2023-06-01 19:36:02', '2023-06-02 06:00:00', 1, 3, 7),
(178, '2023-06-02 19:58:16', '2023-06-05 05:00:00', 1, 3, 2),
(189, '2023-06-16 22:39:33', '2023-06-19 12:00:00', 1, 4, 1),
(190, '2023-06-16 22:40:07', '2023-06-18 06:00:00', 1, 5, 1),
(191, '2023-06-18 14:02:24', '2023-06-22 14:00:00', 1, 5, 1),
(192, '2023-06-18 14:03:29', '2023-06-20 16:00:00', 1, 5, 1),
(193, '2023-06-20 20:32:20', '2023-06-24 17:00:00', 1, 4, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `tables`
--

CREATE TABLE `tables` (
  `id_table` int NOT NULL,
  `sits_table` int DEFAULT NULL,
  `price_hour_table` decimal(9,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `tables`
--

INSERT INTO `tables` (`id_table`, `sits_table`, `price_hour_table`) VALUES
(1, 3, '100.00'),
(2, 5, '150.00'),
(3, 5, '150.00'),
(4, 3, '100.00'),
(5, 3, '100.00'),
(6, 8, '500.00'),
(7, 3, '100.00');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `name_user` varchar(45) DEFAULT NULL,
  `surn_user` varchar(80) DEFAULT NULL,
  `fname_user` varchar(80) DEFAULT NULL,
  `phone_user` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `email_user` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `hash_pw_user` varchar(150) DEFAULT NULL,
  `score_user` int DEFAULT '0',
  `role_user` enum('Администратор','Пользователь','Модератор') DEFAULT 'Пользователь'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id_user`, `name_user`, `surn_user`, `fname_user`, `phone_user`, `email_user`, `hash_pw_user`, `score_user`, `role_user`) VALUES
(1, 'admin', 'Канаев', 'Александрович', NULL, 'admin@admin', NULL, 0, 'Пользователь'),
(2, 'Максим', 'fdsfsd', 'fsdsfd', 'dssds', 'kakaxa.1@ichto.com', NULL, 312, 'Пользователь'),
(3, 'Оля', 'fdsfsd', 'fsdsfd', 'dssds', 'kakaxa.2@ichto.com', NULL, 312, 'Пользователь'),
(4, 'Ольга', 'Соколова', 'Евгеньевна', '+7-953-651-01-89', 'email@email.com', '$2y$10$XTnmeQwt9GtLwft0aojfQO8OpxeMMpTziDINFOokZaM8B8C3z1BkK', 0, 'Администратор'),
(5, 'Ольга', 'Соколова', 'Евгеньевна', '+7-953-651-01-89', 'user@email.com', '$2y$10$C.UvRYsa72TDeLZLTFmV0Os0Onj5dINWGXtGSVTOQsjY/mUoDgjr6', 0, 'Пользователь'),
(6, 'Даниил', 'Корпуков', 'Владиславович', '+7(910) 192-95-73', 'korp@email.com', '$2y$10$OjXWPCrwFX11npL6gIWwx.fHK3TZEZ1u8SU7EEXjVqG5YKrFQ3gS2', 0, 'Пользователь'),
(7, 'максим', 'Канаев', 'Алекс', '+7(950) 240-51-04', '1@1', '$2y$10$AqG8Yftkcltmk4A.zYi2qe0UMnID1ExS2CRCKSSUcsHIFnlSO5cee', 0, 'Пользователь');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_category`);

--
-- Индексы таблицы `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`id_dish`);

--
-- Индексы таблицы `dishes_has_categories`
--
ALTER TABLE `dishes_has_categories`
  ADD PRIMARY KEY (`dishes_id_dish`,`categories_id_category`),
  ADD KEY `fk_dishes_has_categories_categories1_idx` (`categories_id_category`),
  ADD KEY `fk_dishes_has_categories_dishes_idx` (`dishes_id_dish`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`) USING BTREE,
  ADD KEY `fk_orders_users1_idx` (`users_id_user`);

--
-- Индексы таблицы `orders_has_dishes`
--
ALTER TABLE `orders_has_dishes`
  ADD PRIMARY KEY (`orders_id_order`,`dishes_id_dish`),
  ADD KEY `fk_orders_has_dishes_dishes1_idx` (`dishes_id_dish`),
  ADD KEY `fk_orders_has_dishes_orders1_idx` (`orders_id_order`);

--
-- Индексы таблицы `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id_reservation`),
  ADD KEY `INDEX` (`has_id_user`),
  ADD KEY `INDEX_TABLE` (`has_id_table`);

--
-- Индексы таблицы `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id_table`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id_category` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT для таблицы `dishes`
--
ALTER TABLE `dishes`
  MODIFY `id_dish` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT для таблицы `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id_reservation` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- AUTO_INCREMENT для таблицы `tables`
--
ALTER TABLE `tables`
  MODIFY `id_table` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `dishes_has_categories`
--
ALTER TABLE `dishes_has_categories`
  ADD CONSTRAINT `fk_dishes_has_categories_categories1` FOREIGN KEY (`categories_id_category`) REFERENCES `categories` (`id_category`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_dishes_has_categories_dishes` FOREIGN KEY (`dishes_id_dish`) REFERENCES `dishes` (`id_dish`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_users1` FOREIGN KEY (`users_id_user`) REFERENCES `users` (`id_user`);

--
-- Ограничения внешнего ключа таблицы `orders_has_dishes`
--
ALTER TABLE `orders_has_dishes`
  ADD CONSTRAINT `fk_orders_has_dishes_dishes1` FOREIGN KEY (`dishes_id_dish`) REFERENCES `dishes` (`id_dish`),
  ADD CONSTRAINT `fk_orders_has_dishes_orders1` FOREIGN KEY (`orders_id_order`) REFERENCES `orders` (`id_order`);

--
-- Ограничения внешнего ключа таблицы `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`has_id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`has_id_table`) REFERENCES `tables` (`id_table`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
