-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Час створення: Гру 28 2025 р., 17:33
-- Версія сервера: 10.4.32-MariaDB
-- Версія PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `mojmagazyn`
--

-- --------------------------------------------------------

--
-- Структура таблиці `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('Dostarczono','W trakcie') NOT NULL DEFAULT 'W trakcie',
  `tracking_number` varchar(100) DEFAULT NULL,
  `shipping_address` text NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_date`, `total_price`, `status`, `tracking_number`, `shipping_address`, `phone_number`) VALUES
(9, 7, '2025-12-25 16:20:05', 1200.40, 'Dostarczono', 'TN620707', 'Cypriana Godebskiego 13, 10A, 20-045 Lublin', '+48510256427'),
(10, 5, '2025-12-25 17:22:29', 225.00, 'W trakcie', 'TN934956', 'Cypriana Godebskiego 13, 10A, 20-045 Lublin', '+48510256427'),
(11, 6, '2025-12-28 17:01:37', 1778.50, 'W trakcie', 'TN102792', 'Lutska 103, 20-045 Lublin', '+48510256427'),
(12, 5, '2025-12-28 17:20:08', 0.00, 'Dostarczono', 'TN624083', 'Cypriana Godebskiego 13, 20-045 Lublin', '+48510256427'),
(13, 5, '2025-12-28 17:22:37', 344.50, 'W trakcie', 'TN168195', 'Cypriana Godebskiego 13, 20-045 Lublin', '+48510256427'),
(14, 5, '2025-12-28 17:25:29', 344.50, 'W trakcie', 'TN457247', 'Cypriana Godebskiego 13, 20-045 Lublin', '+48510256427'),
(15, 5, '2025-12-28 17:29:45', 8.80, 'W trakcie', 'TN809424', 'Cypriana Godebskiego 13, 20-045 Lublin', '+48510256427');

-- --------------------------------------------------------

--
-- Структура таблиці `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_at_purchase` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `quantity`, `price_at_purchase`) VALUES
(4, 9, 8, 'Wiertarka udarowa', 4, 299.00),
(5, 9, 9, 'Cegła budowlana', 2, 2.20),
(7, 10, 11, 'Poziomica aluminiowa', 3, 75.00),
(8, 11, 11, 'Poziomica aluminiowa', 5, 75.00),
(9, 11, 13, 'Pianka montażowa', 9, 24.00),
(10, 11, 13, 'Pianka montażowa', 8, 24.00),
(11, 11, 7, 'Młotek ciesielski', 5, 45.50),
(12, 11, 7, 'Młotek ciesielski', 5, 45.50),
(13, 11, 7, 'Młotek ciesielski', 5, 45.50),
(14, 11, 7, 'Młotek ciesielski', 5, 45.50),
(15, 11, 7, 'Młotek ciesielski', 1, 45.50),
(16, 11, 9, 'Cegła budowlana', 1, 2.20),
(17, 11, 10, 'Cement portlandzki', 1, 18.90),
(18, 11, 10, 'Cement portlandzki', 1, 18.90),
(23, 13, 7, 'Młotek ciesielski', 1, 45.50),
(24, 13, 8, 'Wiertarka udarowa', 1, 299.00),
(26, 14, 7, 'Młotek ciesielski', 1, 45.50),
(27, 14, 8, 'Wiertarka udarowa', 1, 299.00),
(29, 15, 9, 'Cegła budowlana', 1, 2.20),
(30, 15, 9, 'Cegła budowlana', 1, 2.20),
(31, 15, 9, 'Cegła budowlana', 1, 2.20),
(32, 15, 9, 'Cegła budowlana', 1, 2.20);

-- --------------------------------------------------------

--
-- Структура таблиці `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `image_url`, `created_at`) VALUES
(7, 'Młotek ciesielski', 'Młotek stalowy 600g z magnetycznym uchwytem', 45.50, 42, 'https://i.imgur.com/TzZzmtf.jpeg', '2025-12-25 13:28:59'),
(8, 'Wiertarka udarowa', 'Wiertarka 850W z regulacją obrotów', 299.00, 19, 'https://i.imgur.com/Uit2E7N.jpeg', '2025-12-25 13:28:59'),
(9, 'Cegła budowlana', 'Cegła pełna klasa 15, cena za sztukę', 2.20, 1002, 'https://i.imgur.com/j9tzmGd.jpeg', '2025-12-25 13:28:59'),
(10, 'Cement portlandzki', 'Worek 25kg, idealny do zapraw i betonów', 18.90, 200, 'https://i.imgur.com/CjlWCru.jpeg', '2025-12-25 13:28:59'),
(11, 'Poziomica aluminiowa', 'Długość 100cm, 3 libelle, wysoka precyzja', 75.00, 25, 'https://i.imgur.com/rdQmj7p.jpeg', '2025-12-25 13:28:59'),
(12, 'Zestaw śrubokrętów', '6 elementów, stal chromowo-wanadowa', 55.00, 40, 'https://i.imgur.com/lKhdR6g.jpeg', '2025-12-25 13:28:59'),
(13, 'Pianka montażowa', 'Pianka pistoletowa całosezonowa 750ml', 24.00, 85, 'https://i.imgur.com/RyEivHL.jpeg', '2025-12-25 13:28:59'),
(14, 'Klej do glazury', 'Worek 25kg, elastyczny, do wewnątrz i na zewnątrz', 42.00, 150, 'https://i.imgur.com/Zlq14o4.jpeg', '2025-12-25 13:28:59'),
(15, 'Szlifierka kątowa', 'Moc 1200W, średnica tarczy 125mm', 185.00, 12, 'https://i.imgur.com/sZ1Knnj.jpeg', '2025-12-25 13:28:59'),
(16, 'Wkręty do drewna', 'Opakowanie 100 szt., rozmiar 4x50mm', 15.00, 500, 'https://i.imgur.com/kTPJKWj.jpeg', '2025-12-25 13:28:59'),
(17, 'Piła płatnica', 'Piła do drewna hartowana, 450mm', 38.00, 30, 'https://i.imgur.com/YQ5Ez1K.jpeg', '2025-12-25 13:28:59'),
(18, 'Kombinerki', 'Szczypce uniwersalne izolowane 180mm', 28.50, 45, 'https://i.imgur.com/F5d6fOc.jpeg', '2025-12-25 13:28:59'),
(19, 'Łopata piaskowa', 'Stalowa z drewnianym trzonkiem typu T', 49.00, 2, 'https://i.imgur.com/D1Sx6GG.png', '2025-12-25 13:28:59'),
(20, 'Betoniarka', 'Pojemność 120L, silnik 550W', 1150.00, 5, 'https://i.imgur.com/4ViDqqx.png', '2025-12-25 13:28:59'),
(21, 'Kask ochronny', 'Kolor żółty, regulacja obwodu', 22.00, 60, 'https://i.imgur.com/1LnBQZY.jpeg', '2025-12-25 13:28:59'),
(22, 'Rękawice robocze', 'Skórzane wzmacniane, para', 6.50, 300, 'https://i.imgur.com/0QKMzM4.jpeg', '2025-12-25 13:28:59'),
(23, 'Taśma miernicza', 'Długość 5m, stalowa z blokadą', 12.00, 100, 'https://i.imgur.com/BJH24O5.jpeg', '2025-12-25 13:28:59'),
(24, 'Wiadro budowlane', 'Pojemność 12 litrów, tworzywo sztuczne', 8.00, 120, 'https://i.imgur.com/c8zT52o.png', '2025-12-25 13:28:59'),
(25, 'Pędzel malarski', 'Szerokość 50mm, naturalne włosie', 9.50, 90, 'https://i.imgur.com/l2aQfZn.jpeg', '2025-12-25 13:28:59'),
(26, 'Klucz nastawny', 'Typ szwedzki, rozstaw do 32mm', 45.00, 4, 'https://i.imgur.com/63Nz0dL.png', '2025-12-25 13:28:59');

-- --------------------------------------------------------

--
-- Структура таблиці `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `age` int(5) NOT NULL,
  `phone` varchar(40) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `age`, `phone`, `password`, `email`, `date`, `status`) VALUES
(5, 'ytka', 'Nazar', 'Kravchenko', 23, '+48510256427', '$2y$10$uXJ5tLC9SIp/wC7mFHoqou4dSHFU2BZiy0p//j4cZIr3I1ThHSnu6', 'nazarkravchenko2006@icloud.com', '2025-12-20 00:00:00', 2),
(6, 'budanov', 'Kyrylo', 'Budanov', 45, '510238124', '$2y$10$7RcBAvGvUXc2/2vnah0FOe530tXy5YBaqy6xiXVxtT/wnZPh9zTSS', 's101737@pollub.edu.pl', '2025-12-22 00:00:00', 1),
(7, 'nastunbebrun', 'Kazimir', 'Molokov', 67, '+48228613732', '$2y$10$27g/6YAU4kLHlF2KSNGL8eFmlKxQYAFWAwcSISvXsIT6f/mrDeY.i', 'nastyasmile2007@gmail.com', '2025-12-22 00:00:00', 2);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Індекси таблиці `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Індекси таблиці `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT для таблиці `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблиці `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT для таблиці `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT для таблиці `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
