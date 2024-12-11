-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Дек 11 2024 г., 15:13
-- Версия сервера: 10.4.27-MariaDB
-- Версия PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `betting`
--

-- --------------------------------------------------------

--
-- Структура таблицы `balances`
--

CREATE TABLE `balances` (
  `id` int(11) NOT NULL,
  `currency` varchar(3) NOT NULL,
  `userId` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `balances`
--

INSERT INTO `balances` (`id`, `currency`, `userId`, `amount`) VALUES
(1, 'EUR', 1, '15.00'),
(22, 'EUR', 2, '100.50'),
(23, 'USD', 3, '250.75'),
(24, 'RUB', 4, '3000.00'),
(25, 'EUR', 5, '75.25'),
(26, 'USD', 6, '150.60'),
(27, 'RUB', 7, '4500.90'),
(28, 'EUR', 8, '180.30'),
(29, 'USD', 9, '95.80'),
(30, 'RUB', 10, '3500.00'),
(31, 'EUR', 11, '120.40');

-- --------------------------------------------------------

--
-- Структура таблицы `bets`
--

CREATE TABLE `bets` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `eventId` int(11) NOT NULL,
  `outcome` varchar(16) NOT NULL,
  `currency` varchar(3) NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `rate` decimal(6,2) NOT NULL DEFAULT 1.00,
  `status` enum('Pending','Won','Lost','Service','Refunded') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `bets`
--

INSERT INTO `bets` (`id`, `userId`, `eventId`, `outcome`, `currency`, `amount`, `rate`, `status`) VALUES
(1, 1, 1, 'Win1', 'EUR', '1.00', '1.00', 'Service'),
(2, 1, 1, 'Draw', 'EUR', '1.00', '1.00', 'Service'),
(3, 1, 1, 'Win2', 'EUR', '1.00', '1.00', 'Service'),
(4, 1, 2, 'Win1', 'EUR', '1.00', '1.00', 'Service'),
(5, 1, 2, 'Draw', 'EUR', '1.00', '1.00', 'Service'),
(6, 1, 2, 'Win2', 'EUR', '1.00', '1.00', 'Service'),
(7, 1, 3, 'Win1', 'EUR', '1.00', '1.00', 'Service'),
(8, 1, 3, 'Draw', 'EUR', '1.00', '1.00', 'Service'),
(9, 1, 3, 'Win2', 'EUR', '1.00', '1.00', 'Service'),
(10, 1, 4, 'Win1', 'EUR', '1.00', '1.00', 'Service'),
(11, 1, 4, 'Draw', 'EUR', '1.00', '1.00', 'Service'),
(12, 1, 4, 'Win2', 'EUR', '1.00', '1.00', 'Service'),
(84, 2, 1, 'Win1', 'EUR', '20.00', '2.50', 'Pending'),
(85, 2, 2, 'Draw', 'EUR', '25.00', '3.10', 'Pending'),
(86, 2, 3, 'Win2', 'EUR', '30.00', '2.80', 'Pending'),
(87, 2, 4, 'Win1', 'EUR', '25.50', '2.20', 'Pending'),
(88, 3, 1, 'Win1', 'USD', '50.00', '2.90', 'Pending'),
(89, 3, 2, 'Draw', 'USD', '45.00', '3.40', 'Pending'),
(90, 3, 3, 'Win2', 'USD', '55.00', '2.70', 'Pending'),
(91, 3, 4, 'Win1', 'USD', '60.00', '2.20', 'Pending'),
(92, 4, 1, 'Win2', 'RUB', '500.00', '3.80', 'Pending'),
(93, 4, 2, 'Draw', 'RUB', '800.00', '2.50', 'Pending'),
(94, 4, 3, 'Win1', 'RUB', '1000.00', '2.20', 'Pending'),
(95, 4, 4, 'Win2', 'RUB', '700.00', '3.10', 'Pending'),
(96, 5, 1, 'Win1', 'EUR', '15.00', '4.20', 'Pending'),
(97, 5, 2, 'Win2', 'EUR', '10.00', '3.90', 'Pending'),
(98, 5, 3, 'Draw', 'EUR', '20.00', '3.00', 'Pending'),
(99, 5, 4, 'Win1', 'EUR', '12.00', '2.50', 'Pending'),
(100, 6, 1, 'Draw', 'USD', '40.00', '3.60', 'Pending'),
(101, 6, 2, 'Win1', 'USD', '35.00', '2.80', 'Pending'),
(102, 6, 3, 'Win2', 'USD', '50.00', '3.00', 'Pending'),
(103, 6, 4, 'Win1', 'USD', '30.00', '2.10', 'Pending'),
(104, 7, 1, 'Win2', 'RUB', '1500.00', '3.50', 'Pending'),
(105, 7, 2, 'Draw', 'RUB', '2000.00', '2.90', 'Pending'),
(106, 7, 3, 'Win1', 'RUB', '1000.00', '2.60', 'Pending'),
(107, 7, 4, 'Win2', 'RUB', '800.00', '3.20', 'Pending'),
(108, 8, 1, 'Win1', 'EUR', '50.00', '2.80', 'Pending'),
(109, 8, 2, 'Draw', 'EUR', '60.00', '3.40', 'Pending'),
(110, 8, 3, 'Win2', 'EUR', '70.00', '2.90', 'Pending'),
(111, 8, 4, 'Win1', 'EUR', '55.00', '2.20', 'Pending'),
(112, 9, 1, 'Win1', 'USD', '30.00', '3.00', 'Pending'),
(113, 9, 2, 'Win2', 'USD', '25.00', '3.40', 'Pending'),
(114, 9, 3, 'Draw', 'USD', '40.00', '3.10', 'Pending'),
(115, 9, 4, 'Win1', 'USD', '20.00', '2.80', 'Pending'),
(116, 10, 1, 'Draw', 'RUB', '700.00', '2.60', 'Pending'),
(117, 10, 2, 'Win1', 'RUB', '800.00', '3.10', 'Pending'),
(118, 10, 3, 'Win2', 'RUB', '900.00', '3.30', 'Pending'),
(119, 10, 4, 'Win1', 'RUB', '600.00', '2.50', 'Pending'),
(120, 11, 1, 'Win1', 'EUR', '40.00', '2.90', 'Pending'),
(121, 11, 2, 'Win2', 'EUR', '35.00', '3.10', 'Pending'),
(122, 11, 3, 'Draw', 'EUR', '50.00', '3.40', 'Pending'),
(123, 11, 4, 'Win1', 'EUR', '45.00', '2.80', 'Pending');

-- --------------------------------------------------------

--
-- Структура таблицы `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `type` enum('Telephone','Email') NOT NULL,
  `contact` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `contacts`
--

INSERT INTO `contacts` (`id`, `userId`, `type`, `contact`) VALUES
(1, 2, 'Email', 'user1@example.com'),
(2, 2, 'Telephone', '+12345678901'),
(3, 3, 'Email', 'user2@example.com'),
(4, 4, 'Email', 'user3@example.com'),
(5, 4, 'Telephone', '+12345678902'),
(6, 5, 'Email', 'user4@example.com'),
(7, 6, 'Telephone', '+12345678903'),
(8, 7, 'Email', 'user6@example.com'),
(9, 7, 'Telephone', '+12345678904'),
(10, 8, 'Email', 'user7@example.com'),
(11, 9, 'Email', 'user8@example.com'),
(12, 9, 'Telephone', '+12345678905'),
(13, 10, 'Telephone', '+12345678906'),
(14, 11, 'Email', 'user10@example.com'),
(15, 11, 'Telephone', '+12345678907');

-- --------------------------------------------------------

--
-- Структура таблицы `currencies`
--

CREATE TABLE `currencies` (
  `id` int(11) NOT NULL,
  `code` varchar(3) NOT NULL,
  `name` varchar(48) NOT NULL,
  `tag` varchar(3) NOT NULL,
  `rate` decimal(5,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `currencies`
--

INSERT INTO `currencies` (`id`, `code`, `name`, `tag`, `rate`) VALUES
(1, 'EUR', 'Euro', '€', '1.0000'),
(2, 'RUB', 'Russian ruble', '₽', '0.0096'),
(3, 'USD', 'United States dollar', '$', '0.9500');

-- --------------------------------------------------------

--
-- Структура таблицы `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `teamOne` int(11) NOT NULL,
  `teamTwo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `events`
--

INSERT INTO `events` (`id`, `teamOne`, `teamTwo`) VALUES
(1, 1, 2),
(2, 3, 4),
(3, 2, 4),
(4, 1, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `outcometypes`
--

CREATE TABLE `outcometypes` (
  `id` int(11) NOT NULL,
  `name` varchar(16) NOT NULL,
  `label` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `outcometypes`
--

INSERT INTO `outcometypes` (`id`, `name`, `label`) VALUES
(1, 'Win1', 'Победа 1 команды'),
(2, 'Draw', 'Ничья'),
(3, 'Win2', 'Победа 2 команды');

-- --------------------------------------------------------

--
-- Структура таблицы `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `teams`
--

INSERT INTO `teams` (`id`, `name`) VALUES
(1, 'Team Alpha'),
(2, 'Team Beta'),
(3, 'Team Delta'),
(4, 'Team Gamma');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `status` enum('Active','Banned') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `gender`, `birthday`, `status`) VALUES
(1, 'Service', '', 'Service', 'Male', '1990-01-01', 'Active'),
(2, 'user1', '$2y$10$tFm9/8hmPvex4otvKNbE7OwfXyn/pCCxTkGr6TkOB.QdsUOD.JBS6', 'John Doe', 'Male', '1990-01-01', 'Banned'),
(3, 'user2', '$2y$10$tFm9/8hmPvex4otvKNbE7OwfXyn/pCCxTkGr6TkOB.QdsUOD.JBS6', 'Jane Smith', 'Female', '1992-02-02', 'Active'),
(4, 'user3', '$2y$10$tFm9/8hmPvex4otvKNbE7OwfXyn/pCCxTkGr6TkOB.QdsUOD.JBS6', 'Alice Brown', 'Female', '1994-03-03', 'Active'),
(5, 'user4', '$2y$10$tFm9/8hmPvex4otvKNbE7OwfXyn/pCCxTkGr6TkOB.QdsUOD.JBS6', 'Bob White', 'Male', '1988-04-04', 'Active'),
(6, 'user5', '$2y$10$tFm9/8hmPvex4otvKNbE7OwfXyn/pCCxTkGr6TkOB.QdsUOD.JBS6', 'Charlie Green', 'Male', '1985-05-05', 'Active'),
(7, 'user6', '$2y$10$tFm9/8hmPvex4otvKNbE7OwfXyn/pCCxTkGr6TkOB.QdsUOD.JBS6', 'Diana Blue', 'Female', '1996-06-06', 'Active'),
(8, 'user7', '$2y$10$tFm9/8hmPvex4otvKNbE7OwfXyn/pCCxTkGr6TkOB.QdsUOD.JBS6', 'Edward Black', 'Male', '1993-07-07', 'Active'),
(9, 'user8', '$2y$10$tFm9/8hmPvex4otvKNbE7OwfXyn/pCCxTkGr6TkOB.QdsUOD.JBS6', 'Fiona Pink', 'Female', '1991-08-08', 'Active'),
(10, 'user9', '$2y$10$tFm9/8hmPvex4otvKNbE7OwfXyn/pCCxTkGr6TkOB.QdsUOD.JBS6', 'George Gray', 'Male', '1987-09-09', 'Active'),
(11, 'user10', '$2y$10$tFm9/8hmPvex4otvKNbE7OwfXyn/pCCxTkGr6TkOB.QdsUOD.JBS6', 'Helen Violet', 'Female', '1995-10-10', 'Active');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `balances`
--
ALTER TABLE `balances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_balance` (`userId`,`currency`),
  ADD KEY `balances_curency` (`currency`),
  ADD KEY `balances_userId` (`userId`);

--
-- Индексы таблицы `bets`
--
ALTER TABLE `bets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bets_userId` (`userId`),
  ADD KEY `bets_currency` (`currency`),
  ADD KEY `bets_eventId` (`eventId`),
  ADD KEY `bets_outcomeType` (`outcome`) USING BTREE;

--
-- Индексы таблицы `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contacts_userId` (`userId`) USING BTREE;

--
-- Индексы таблицы `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `currencies_code` (`code`);

--
-- Индексы таблицы `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_teamOne` (`teamOne`) USING BTREE,
  ADD KEY `events_teamTwo` (`teamTwo`) USING BTREE;

--
-- Индексы таблицы `outcometypes`
--
ALTER TABLE `outcometypes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `outcomeTypes_name` (`name`);

--
-- Индексы таблицы `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username` (`username`) USING BTREE;

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `balances`
--
ALTER TABLE `balances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT для таблицы `bets`
--
ALTER TABLE `bets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT для таблицы `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `outcometypes`
--
ALTER TABLE `outcometypes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `balances`
--
ALTER TABLE `balances`
  ADD CONSTRAINT `balances_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `balances_ibfk_2` FOREIGN KEY (`currency`) REFERENCES `currencies` (`code`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `bets`
--
ALTER TABLE `bets`
  ADD CONSTRAINT `bets_ibfk_1` FOREIGN KEY (`outcome`) REFERENCES `outcometypes` (`name`) ON DELETE CASCADE,
  ADD CONSTRAINT `bets_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bets_ibfk_3` FOREIGN KEY (`currency`) REFERENCES `currencies` (`code`) ON DELETE CASCADE,
  ADD CONSTRAINT `bets_ibfk_4` FOREIGN KEY (`eventId`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bets_ibfk_5` FOREIGN KEY (`outcome`) REFERENCES `outcometypes` (`name`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`teamOne`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`teamTwo`) REFERENCES `teams` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
