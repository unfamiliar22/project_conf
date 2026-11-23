-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 23 2026 г., 00:15
-- Версия сервера: 8.0.30
-- Версия PHP: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `conferences`
--

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `tour_id` int NOT NULL,
  `start_date` date NOT NULL,
  `payment` enum('card','cash','transfer') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'card',
  `status` enum('new','assigned','done') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `tour_id`, `start_date`, `payment`, `status`, `created_at`) VALUES
(1, 4, 4, '2077-12-12', 'cash', 'new', '2026-11-18 00:00:08'),
(2, 6, 6, '1212-12-12', 'card', 'new', '2026-11-23 00:15:15');

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tours`
--

CREATE TABLE `tours` (
  `id` int NOT NULL,
  `title` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `duration` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `tours`
--

INSERT INTO `tours` (`id`, `title`, `country`, `description`, `price`, `duration`, `image`, `created_at`) VALUES
(1, 'Конференц-зал «Премьер»', 'Москва', 'Вместимость до 150 человек, проектор 4K, звук, кофе-брейк.', '45000.00', '1 день', 'hall-1.jpg', '2026-09-29 01:58:45'),
(2, 'Зал «Форум»', 'Санкт-Петербург', 'Вместимость до 300 человек, сцена, микрофоны, трансляция.', '62000.00', '1 день', 'hall-2.jpg', '2026-09-29 01:58:45'),
(3, 'Зал «Бизнес»', 'Москва', 'Вместимость до 80 человек, экран, флипчарт, Wi-Fi.', '58000.00', '1 день', 'hall-3.jpg', '2026-09-29 01:58:45'),
(4, 'Зал «Саммит»', 'Сочи', 'Вместимость до 200 человек, панорамный вид, оборудование.', '71000.00', '1 день', 'hall-4.jpg', '2026-09-29 01:58:45'),
(5, 'Зал «Инновация»', 'Казань', 'Вместимость до 120 человек, интерактивные панели, кофе-брейк.', '52000.00', '1 день', 'hall-5.jpg', '2026-09-29 01:58:45'),
(6, 'Зал «Академия»', 'Екатеринбург', 'Вместимость до 100 человек, проектор, звук, парковка.', '49000.00', '1 день', 'hall-6.jpg', '2026-09-29 01:58:45');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `login` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fio` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('user','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `fio`, `phone`, `email`, `role`, `created_at`) VALUES
(1, 'admin1', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe1HlCS4bZJ18mH3kL4Q5T6U7V8W9X0Y1', 'Администратор', '+7 (495) 000-00-00', 'admin@конференции.рф', 'admin', '2026-09-29 01:58:45'),
(4, 'user01', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe1HlCS4bZJ18mH3kL4Q5T6U7V8W9X0Y1', 'Иванов Иван Иванович', '+7 (900) 123-45-67', 'user01@mail.ru', 'user', '2026-09-29 01:58:45'),
(6, 'Niger123', '$2y$10$LCuvGmx6kmYzjKyWXO1oTedBrYiByf5R9VjrzIcDxWQo/Lrcg/BSO', 'Niger123', '3123131232131231', 'Niger123@gmail.com', 'user', '2026-11-22 23:20:57'),
(8, 'Niger1234', '$2y$10$NyJ46VfWXdv0qycER35e1.IJKGNSgXboJN5o.vYW0f5oe.RY0kZVe', 'Niger1234', '354345345435345', 'Niger123@gmail.com', 'admin', '2026-11-22 23:44:07');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_id` (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tours`
--
ALTER TABLE `tours`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
