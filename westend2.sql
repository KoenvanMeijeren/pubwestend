-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 29 mrt 2019 om 13:22
-- Serverversie: 10.1.37-MariaDB
-- PHP-versie: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `westend2`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `account`
--

CREATE TABLE `account` (
  `ID` int(11) NOT NULL,
  `account_name` text NOT NULL,
  `account_email` text NOT NULL,
  `account_password` text NOT NULL,
  `account_level` int(1) NOT NULL DEFAULT '0',
  `account_is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `account`
--

INSERT INTO `account` (`ID`, `account_name`, `account_email`, `account_password`, `account_level`, `account_is_deleted`) VALUES
(1, 'Koen van Meijeren', 'koenvanmeijeren@gmail.com', '$2y$10$LQiHTKDdIDbfRIoGzrrg2eEx3X2/UfBhJxy/n8OB94DZWqmHmCp4.', 5, 0),
(2, 'test', 'test@test.nl', '$2y$10$LoBL2tMelBIl.X8OwC4M1edW6LV4zZQta4bJspt.WgOwd7xmNbEm6', 1, 0),
(3, 'test', 'test2@test.nl', '$2y$10$Vg28ZrQbFgctyNB0MqaEDup3OZSaI.xoCfrV8RgC6CoBC2J4yMxJu', 2, 0),
(4, 'test', 'test3@test.nl', '$2y$10$XfrdNsKGshwpDY0Ko1vu9O/NOQmj0M0NNDWQfpP2Iua.1v0mHL45i', 3, 0),
(5, 'test4', 'test4@test.nl', '$2y$10$RwxPWOviIVXYFFpxlmsGS.GexHyNjFcC3W84QQjT4hTjvfcyYVTFa', 4, 0),
(6, 'Test5', 'test5@test.nl', '$2y$10$nwGG/iTLAVxYAJLwDI38zeyvXFuBqmJyZrgkxnmtNINs.nvHFukSy', 5, 1),
(7, 'test6', 'test6@test.nl', '$2y$10$u5K0UZut7giXs9RKI4l/huUEcXoBzr1MsZLn5v5mMFFmF8qFG6gZi', 1, 1),
(8, 'test', 'test1@test.nl', '$2y$10$W5Ru7z03zM3g/w9WWezSBuWfW0OupYzFdYxJuvUfaH1iJvkB5Wzk2', 1, 1),
(9, 'Koen van Meijeren', 'koenvanmeijeren@gmail.com', '$2y$10$EaMXidQ5ckWBQOk2VYpvLucpD3t746Z8nSsFLjanX4KQycLlQhm4C', 5, 1),
(10, 'Koen van Meijeren', 'koenvanmeijeren@gmail.com', '$2y$10$Uy9w4DLmviDcbqPSpTpA/OV.rsnQ/macUVwKFCikthT1x1OUn0n5e', 1, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `connection_table_invoice_orders`
--

CREATE TABLE `connection_table_invoice_orders` (
  `ID` int(11) NOT NULL,
  `Invoice_id` int(11) NOT NULL,
  `Order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `connection_table_invoice_orders`
--

INSERT INTO `connection_table_invoice_orders` (`ID`, `Invoice_id`, `Order_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 2, 4),
(5, 2, 5),
(6, 2, 6),
(7, 2, 7),
(8, 2, 8),
(9, 2, 9),
(10, 3, 19),
(11, 3, 20),
(12, 3, 21),
(13, 3, 22),
(14, 3, 23),
(15, 3, 24),
(16, 4, 10),
(17, 4, 11),
(18, 4, 12),
(19, 4, 13),
(20, 4, 15),
(21, 4, 17);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `connection_table_menu_ingr`
--

CREATE TABLE `connection_table_menu_ingr` (
  `ID` int(11) NOT NULL,
  `Menu_id` int(11) NOT NULL,
  `Ingredient_id` int(11) NOT NULL,
  `Aantal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `connection_table_menu_ingr`
--

INSERT INTO `connection_table_menu_ingr` (`ID`, `Menu_id`, `Ingredient_id`, `Aantal`) VALUES
(13, 5, 2, 1),
(14, 4, 2, 1),
(15, 4, 4, 2),
(19, 3, 6, 3),
(24, 6, 2, 1),
(26, 7, 2, 1),
(35, 2, 1, 1),
(36, 2, 2, 1),
(37, 2, 3, 10),
(38, 2, 4, 1),
(44, 1, 1, 1),
(45, 1, 3, 1),
(46, 8, 9, 1),
(47, 8, 10, 1),
(48, 9, 1, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `connection_table_tables_orders`
--

CREATE TABLE `connection_table_tables_orders` (
  `tables_orders_id` int(11) NOT NULL,
  `Table_id` int(11) NOT NULL,
  `Order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `connection_table_tables_orders`
--

INSERT INTO `connection_table_tables_orders` (`tables_orders_id`, `Table_id`, `Order_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 2, 4),
(5, 2, 5),
(6, 2, 6),
(7, 2, 7),
(8, 2, 8),
(9, 2, 9),
(10, 7, 10),
(11, 7, 11),
(12, 7, 12),
(13, 7, 13),
(14, 7, 15),
(15, 7, 17),
(17, 2, 19),
(18, 2, 20),
(19, 2, 21),
(20, 2, 22),
(21, 2, 23),
(22, 2, 24);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `files`
--

CREATE TABLE `files` (
  `ID` int(11) NOT NULL,
  `file_path` text NOT NULL,
  `file_is_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `file_is_deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `files`
--

INSERT INTO `files` (`ID`, `file_path`, `file_is_created_at`, `file_is_deleted`) VALUES
(1, 'C:\\xampp\\htdocs\\kvanmeijeren\\storage\\media\\56657268756973642d312e706e67.png', '2019-03-28 14:47:21', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ingredient`
--

CREATE TABLE `ingredient` (
  `ID` int(11) NOT NULL,
  `Ingredient_name` varchar(255) NOT NULL,
  `Ingredient_description` text NOT NULL,
  `Ingredient_quantity` int(30) NOT NULL,
  `ingredient_unit` text NOT NULL,
  `Ingredient_price` float(10,2) NOT NULL,
  `Ingredient_price_without_vat` float(10,2) NOT NULL,
  `Ingredient_btw` int(2) NOT NULL DEFAULT '6',
  `Ingredient_is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `ingredient`
--

INSERT INTO `ingredient` (`ID`, `Ingredient_name`, `Ingredient_description`, `Ingredient_quantity`, `ingredient_unit`, `Ingredient_price`, `Ingredient_price_without_vat`, `Ingredient_btw`, `Ingredient_is_deleted`) VALUES
(1, 'Brood', 'Boeren volkoren brood', 44, 'Stuks', 56.40, 47.00, 10, 0),
(2, 'Water', 'Waterloos', 36, 'L', 0.36, 0.00, 9, 0),
(3, 'Zout', 'Lekkere zoutige zout', 90, 'KG', 1.28, 0.00, 9, 0),
(4, 'Peper', 'Lekkere peperige peper', 79, 'G', 2.01, 0.00, 9, 0),
(5, 'Melk', 'Lekkere koeien melk', 68, 'L', 1.57, 0.00, 9, 0),
(6, 'Paprika', 'Lekkere paprika', 0, 'Stuks', 1.13, 0.00, 9, 0),
(7, 'Knoflook', 'Lekkere knoflook', 14, 'Stuks', 1.13, 0.00, 9, 0),
(8, 'Graan', '-', 42, 'KG', 0.40, 0.37, 9, 0),
(9, 'Meel', 'wit', 1, 'KG', 1.21, 1.11, 9, 0),
(10, 'Paddenstoelen', 'Lekkere paddenstoel', 1, 'Stuk', 0.17, 0.16, 9, 0),
(11, 'Siroop', 'Lekkere zoete siroop', 8, 'DL', 0.34, 31.00, 9, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `invoice`
--

CREATE TABLE `invoice` (
  `ID` int(11) NOT NULL,
  `Table_id` int(11) NOT NULL,
  `Invoice_paid` tinyint(1) NOT NULL DEFAULT '1',
  `Invoice_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Invoice_costs` double(100,2) NOT NULL,
  `Invoice_is_deleted` int(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `invoice`
--

INSERT INTO `invoice` (`ID`, `Table_id`, `Invoice_paid`, `Invoice_date`, `Invoice_costs`, `Invoice_is_deleted`) VALUES
(1, 1, 1, '2019-03-05 18:04:51', 1.91, 0),
(2, 2, 1, '2019-03-05 18:05:03', 4.91, 0),
(3, 2, 1, '2019-03-07 21:38:05', 5.96, 0),
(4, 7, 1, '2019-03-07 21:38:11', 11.36, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `menu`
--

CREATE TABLE `menu` (
  `ID` int(11) NOT NULL,
  `Menu_name` varchar(255) NOT NULL,
  `Menu_category` varchar(100) NOT NULL,
  `Menu_description` text NOT NULL,
  `Menu_price` float(10,2) NOT NULL,
  `Menu_price_without_vat` float(10,2) NOT NULL,
  `Menu_btw` int(2) NOT NULL DEFAULT '9',
  `Menu_created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `Menu_is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `menu`
--

INSERT INTO `menu` (`ID`, `Menu_name`, `Menu_category`, `Menu_description`, `Menu_price`, `Menu_price_without_vat`, `Menu_btw`, `Menu_created_at`, `Menu_is_deleted`) VALUES
(1, 'Kaasbol', '1.1', 'Lekkere gebakken bol met kaas', 1.23, 1.09, 6, '2019-03-06 14:03:03.286933', 0),
(2, 'Pizza Hawaï', '2.1', 'Lekkere pizza wat eigenlijk geen pizza is omdat het ananas bevat.', 0.53, 0.50, 6, '2019-03-04 15:27:31.981080', 0),
(3, 'Paprika taart', '1.2', 'Lekkere gebakken paprika taart', 0.45, 0.00, 6, '2019-03-01 10:16:23.744522', 0),
(4, 'Tomatensoep', '1.1', 'Lekkere soep met tomaten en gehaktballen', 0.52, 0.00, 9, '2019-03-01 09:03:39.736730', 0),
(5, 'Chocolademouse', '3.2', 'Lekkere chocolade mouse ', 0.29, 0.00, 9, '2019-03-01 09:02:31.846555', 0),
(6, 'IJS', '3.2', 'Lekker koud ijs', 0.49, 0.00, 9, '2019-03-01 10:36:52.400379', 0),
(7, 'Bier', '4.3', 'Lekker koud biertje', 0.64, 0.59, 9, '2019-03-01 11:05:39.766439', 0),
(8, 'Paddenstoelen pasta', '2.1', '', 18.35, 15.55, 9, '2019-03-07 21:34:42.720160', 0),
(9, 'test', '1.1', '', 0.01, 0.01, 9, '2019-03-07 21:34:54.999326', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `orders`
--

CREATE TABLE `orders` (
  `ID` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `Order_menu_item` varchar(255) NOT NULL,
  `Order_ammount` int(100) NOT NULL,
  `order_state` int(1) NOT NULL DEFAULT '0',
  `Order_paid` tinyint(1) NOT NULL DEFAULT '0',
  `Order_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Order_is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `orders`
--

INSERT INTO `orders` (`ID`, `menu_id`, `Order_menu_item`, `Order_ammount`, `order_state`, `Order_paid`, `Order_created_at`, `Order_is_deleted`) VALUES
(1, 1, 'Kaasbol', 1, 2, 1, '2019-03-05 18:02:42', 0),
(2, 4, 'Tomatensoep', 1, 2, 1, '2019-03-05 18:02:42', 0),
(3, 7, 'Bier', 1, 2, 1, '2019-03-05 18:02:42', 0),
(4, 1, 'Kaasbol', 1, 2, 1, '2019-03-05 18:03:30', 0),
(5, 4, 'Tomatensoep', 2, 2, 1, '2019-03-05 18:03:30', 0),
(6, 2, 'Pizza Hawaï', 2, 2, 1, '2019-03-05 18:03:30', 0),
(7, 5, 'Chocolademouse', 1, 2, 1, '2019-03-05 18:03:30', 0),
(8, 6, 'IJS', 1, 2, 1, '2019-03-05 18:03:30', 0),
(9, 7, 'Bier', 2, 2, 1, '2019-03-05 18:03:30', 0),
(10, 2, 'Pizza Hawaï', 1, 2, 1, '2019-03-06 08:39:57', 0),
(11, 5, 'Chocolademouse', 5, 2, 1, '2019-03-06 08:49:16', 0),
(12, 7, 'Bier', 10, 2, 1, '2019-03-06 08:49:16', 0),
(13, 4, 'Tomatensoep', 1, 2, 1, '2019-03-06 10:05:18', 0),
(14, 1, 'Kaasbol', 1, 0, 0, '2019-03-06 10:06:08', 0),
(15, 1, 'Kaasbol', 1, 2, 1, '2019-03-06 10:12:21', 0),
(16, 1, 'Kaasbol', 1, 0, 0, '2019-03-06 10:12:37', 0),
(17, 1, 'Kaasbol', 1, 2, 1, '2019-03-06 10:13:03', 0),
(18, 4, 'Tomatensoep', 1, 0, 0, '2019-03-06 12:51:41', 0),
(19, 1, 'Kaasbol', 1, 2, 1, '2019-03-06 13:08:06', 0),
(20, 1, 'Kaasbol', 1, 2, 1, '2019-03-06 13:58:49', 0),
(21, 4, 'Tomatensoep', 1, 2, 1, '2019-03-06 13:59:31', 0),
(22, 1, 'Kaasbol', 1, 2, 1, '2019-03-07 21:36:58', 0),
(23, 4, 'Tomatensoep', 1, 2, 1, '2019-03-07 21:36:58', 0),
(24, 1, 'Kaasbol', 1, 2, 1, '2019-03-07 21:37:46', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `page`
--

CREATE TABLE `page` (
  `ID` int(11) NOT NULL,
  `Page_slug` varchar(255) NOT NULL,
  `Page_titel` varchar(255) NOT NULL,
  `Page_description` text NOT NULL,
  `Page_is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `page`
--

INSERT INTO `page` (`ID`, `Page_slug`, `Page_titel`, `Page_description`, `Page_is_deleted`) VALUES
(1, 'our-story-left', 'Ons verhaal&amp;#39;s', 'Erg mooi restaurant waarin je lekker kan eten en drinken. lorem ipsum lorem ipsum lorem ipsum.', 0),
(2, 'our-story-right', 'Ons verhaal&amp;#39;s', 'Het restaurant is van Landstede voor studenten en door studenten lorem ipsum  lorem ipsum lorem ipsum.', 0),
(3, 'opening-hours', 'Openingstijden', '{&quot;sundayAfternoonOpeningTime&quot;:&quot;&quot;,&quot;sundayEveningOpeningTime&quot;:&quot;&quot;,&quot;sundayAfternoonClosingTime&quot;:&quot;&quot;,&quot;sundayEveningClosingTime&quot;:&quot;&quot;,&quot;mondayAfternoonOpeningTime&quot;:&quot;12:00&quot;,&quot;mondayEveningOpeningTime&quot;:&quot;18:00&quot;,&quot;mondayAfternoonClosingTime&quot;:&quot;13:00&quot;,&quot;mondayEveningClosingTime&quot;:&quot;20:00&quot;,&quot;tuesdayAfternoonOpeningTime&quot;:&quot;12:00&quot;,&quot;tuesdayEveningOpeningTime&quot;:&quot;19:00&quot;,&quot;tuesdayAfternoonClosingTime&quot;:&quot;14:00&quot;,&quot;tuesdayEveningClosingTime&quot;:&quot;20:00&quot;,&quot;wednesdayAfternoonOpeningTime&quot;:&quot;&quot;,&quot;wednesdayEveningOpeningTime&quot;:&quot;&quot;,&quot;wednesdayAfternoonClosingTime&quot;:&quot;&quot;,&quot;wednesdayEveningClosingTime&quot;:&quot;&quot;,&quot;thursdayAfternoonOpeningTime&quot;:&quot;&quot;,&quot;thursdayEveningOpeningTime&quot;:&quot;&quot;,&quot;thursdayAfternoonClosingTime&quot;:&quot;&quot;,&quot;thursdayEveningClosingTime&quot;:&quot;&quot;,&quot;fridayAfternoonOpeningTime&quot;:&quot;&quot;,&quot;fridayEveningOpeningTime&quot;:&quot;&quot;,&quot;fridayAfternoonClosingTime&quot;:&quot;&quot;,&quot;fridayEveningClosingTime&quot;:&quot;&quot;,&quot;saturdayAfternoonOpeningTime&quot;:&quot;&quot;,&quot;saturdayEveningOpeningTime&quot;:&quot;&quot;,&quot;saturdayAfternoonClosingTime&quot;:&quot;&quot;,&quot;saturdayEveningClosingTime&quot;:&quot;&quot;}', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `reservations`
--

CREATE TABLE `reservations` (
  `ID` int(11) NOT NULL,
  `Table_id` int(11) NOT NULL DEFAULT '0',
  `Reservation_customer_name` text NOT NULL,
  `Reservation_customer_email` text NOT NULL,
  `Reservation_customer_phone` text NOT NULL,
  `Reservation_date` date NOT NULL,
  `Reservation_time` text NOT NULL,
  `Reservation_quantity_persons` int(25) NOT NULL,
  `Reservation_customer_notes` text NOT NULL,
  `Reservation_state` int(1) NOT NULL DEFAULT '0',
  `Reservation_is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `reservations`
--

INSERT INTO `reservations` (`ID`, `Table_id`, `Reservation_customer_name`, `Reservation_customer_email`, `Reservation_customer_phone`, `Reservation_date`, `Reservation_time`, `Reservation_quantity_persons`, `Reservation_customer_notes`, `Reservation_state`, `Reservation_is_deleted`) VALUES
(1, 2, 'Koen van Meijeren', 'koenvanmeijeren@gmail.com', '622266796', '2019-03-05', '11:00', 10, '2 personen hebben een noten allergie.', 2, 0),
(2, 0, 'Koen van Meijeren', 'koenvanmeijeren@gmail.com', '0341-123456', '2019-03-06', '13:30', 10, '', 0, 0),
(3, 2, 'Koen van Meijeren', 'koenvanmeijeren@gmail.com', '622266796', '2019-03-06', '14:30', 10, '', 2, 1),
(4, 0, 'Koen van Meijeren', 'koenvanmeijeren@gmail.com', '622266796', '2019-03-07', '11:00', 10, '', 0, 1),
(5, 0, 'Koen van Meijeren', 'koenvanmeijeren@gmail.com', '622266796', '2019-03-07', '11:30', 40, '', 0, 1),
(6, 0, 'Koen van Meijeren', 'koenvanmeijeren@gmail.com', '622266796', '2019-03-07', '13:00', 40, '', 0, 1),
(7, 0, 'Koen van Meijeren', 'koenvanmeijeren@gmail.com', '622266796', '2019-03-07', '18:00', 40, '', 0, 0),
(8, 0, 'Koen van Meijeren', 'koenvanmeijeren@gmail.com', '622266796', '2019-03-07', '17:00', 40, '', 0, 1),
(9, 0, 'Koen van Meijeren', 'koenvanmeijeren@gmail.com', '622266796', '2019-03-08', '13:00', 30, '', 0, 0),
(10, 0, 'Koen van Meijeren', 'koenvanmeijeren@gmail.com', '0341-123456', '2019-03-08', '12:00', 40, '', 0, 0),
(11, 0, 'Koen van Meijeren', 'koenvanmeijeren@gmail.com', '0622266796', '2019-03-13', '20:00', 40, '', 0, 0),
(12, 0, 'Koen van Meijeren', 'koenvanmeijeren@gmail.com', '0622266796', '2019-03-13', '20:30', 40, '', 0, 1),
(13, 0, 'Koen van Meijeren', 'koenvanmeijeren@gmail.com', '0622266796', '2019-03-12', '20:00', 1, '', 0, 0),
(14, 0, 'Koen van Meijeren', 'koenvanmeijeren@gmail.com', '0622266796', '2019-03-12', '20:00', 1, '', 0, 0),
(15, 0, 'Koen van Meijeren', 'koenvanmeijeren@gmail.com', '0622266796', '2019-03-19', '18:00', 1, '', 0, 0),
(16, 0, 'Koen van Meijeren', 'koenvanmeijeren@gmail.com', '0622266796', '2019-03-20', '13:30', 1, '', 0, 0),
(17, 0, 'Koen van Meijeren', 'koenvanmeijeren@gmail.com', '0622266796', '2019-03-20', '18:30', 1, '', 0, 0),
(18, 0, 'Koen van Meijeren', 'koenvanmeijeren@gmail.com', '0622266796', '2019-03-21', '13:00', 1, '', 0, 0),
(19, 0, 'Koen van Meijeren', 'koenvanmeijeren@gmail.com', '0622266796', '2019-03-26', '19:00', 1, '', 0, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `settings`
--

CREATE TABLE `settings` (
  `ID` int(11) NOT NULL,
  `settings_name` varchar(255) NOT NULL,
  `settings_value` text NOT NULL,
  `settings_is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `settings`
--

INSERT INTO `settings` (`ID`, `settings_name`, `settings_value`, `settings_is_deleted`) VALUES
(1, 'companyName', 'CC Westeinde', 0),
(2, 'companyTel', '06123456789', 0),
(3, 'companyEmail', 'ccwesteinde@landstede.nl', 0),
(4, 'companyAddress', '123weg', 0),
(5, 'companyPostcode', '1234AB', 0),
(6, 'companyCity', 'Harderwijk', 0),
(7, 'companyBankNumber', '', 0),
(8, 'companyKVKNumber', '', 0),
(9, 'facebook', 'https://www.facebook.com', 0),
(10, 'instagram', 'https://www.instagram.com', 0),
(11, 'linkedin', 'https://www.linkedin.com', 0),
(12, 'youtube', 'https://www.youtube.com', 0),
(13, 'twitter', 'https://www.twitter.com', 0),
(14, 'capacityRestaurant', '40', 0),
(15, 'spendingTimeRestaurant', '2', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tables`
--

CREATE TABLE `tables` (
  `ID` int(11) NOT NULL,
  `Table_enabled` int(1) NOT NULL DEFAULT '0',
  `Table_occupied` int(1) NOT NULL DEFAULT '0',
  `Table_is_deleted` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `tables`
--

INSERT INTO `tables` (`ID`, `Table_enabled`, `Table_occupied`, `Table_is_deleted`) VALUES
(1, 1, 0, 0),
(2, 1, 0, 0),
(3, 1, 0, 0),
(4, 1, 0, 0),
(5, 1, 0, 0),
(6, 1, 0, 0),
(7, 1, 0, 0),
(8, 1, 0, 0),
(9, 1, 0, 0),
(10, 1, 0, 0),
(11, 1, 0, 0),
(12, 1, 0, 0),
(13, 1, 0, 0),
(14, 1, 0, 0),
(15, 1, 0, 0),
(16, 1, 0, 0),
(17, 1, 0, 0),
(18, 1, 0, 0),
(19, 1, 0, 0),
(20, 1, 0, 0),
(21, 1, 0, 0),
(22, 1, 0, 0),
(23, 1, 0, 0),
(24, 1, 0, 0),
(25, 1, 0, 0),
(26, 1, 0, 0),
(27, 1, 0, 0),
(28, 1, 0, 0),
(29, 1, 0, 0),
(30, 1, 0, 0),
(31, 1, 0, 0),
(32, 1, 0, 0),
(33, 1, 0, 0),
(34, 1, 0, 0),
(35, 1, 0, 0);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`ID`);

--
-- Indexen voor tabel `connection_table_invoice_orders`
--
ALTER TABLE `connection_table_invoice_orders`
  ADD PRIMARY KEY (`ID`);

--
-- Indexen voor tabel `connection_table_menu_ingr`
--
ALTER TABLE `connection_table_menu_ingr`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Ingredient_id` (`Ingredient_id`),
  ADD KEY `Menu_id` (`Menu_id`);

--
-- Indexen voor tabel `connection_table_tables_orders`
--
ALTER TABLE `connection_table_tables_orders`
  ADD PRIMARY KEY (`tables_orders_id`),
  ADD KEY `Table_id` (`Table_id`),
  ADD KEY `Order_id` (`Order_id`);

--
-- Indexen voor tabel `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`ID`);

--
-- Indexen voor tabel `ingredient`
--
ALTER TABLE `ingredient`
  ADD PRIMARY KEY (`ID`);

--
-- Indexen voor tabel `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`ID`);

--
-- Indexen voor tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`ID`);

--
-- Indexen voor tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexen voor tabel `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`ID`);

--
-- Indexen voor tabel `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`ID`);

--
-- Indexen voor tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`ID`);

--
-- Indexen voor tabel `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `account`
--
ALTER TABLE `account`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT voor een tabel `connection_table_invoice_orders`
--
ALTER TABLE `connection_table_invoice_orders`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT voor een tabel `connection_table_menu_ingr`
--
ALTER TABLE `connection_table_menu_ingr`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT voor een tabel `connection_table_tables_orders`
--
ALTER TABLE `connection_table_tables_orders`
  MODIFY `tables_orders_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT voor een tabel `files`
--
ALTER TABLE `files`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT voor een tabel `invoice`
--
ALTER TABLE `invoice`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT voor een tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT voor een tabel `page`
--
ALTER TABLE `page`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `reservations`
--
ALTER TABLE `reservations`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT voor een tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT voor een tabel `tables`
--
ALTER TABLE `tables`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `connection_table_menu_ingr`
--
ALTER TABLE `connection_table_menu_ingr`
  ADD CONSTRAINT `connection_table_menu_ingr_ibfk_1` FOREIGN KEY (`Ingredient_id`) REFERENCES `ingredient` (`ID`),
  ADD CONSTRAINT `connection_table_menu_ingr_ibfk_2` FOREIGN KEY (`Menu_id`) REFERENCES `menu` (`ID`);

--
-- Beperkingen voor tabel `connection_table_tables_orders`
--
ALTER TABLE `connection_table_tables_orders`
  ADD CONSTRAINT `connection_table_tables_orders_ibfk_1` FOREIGN KEY (`Table_id`) REFERENCES `tables` (`ID`),
  ADD CONSTRAINT `connection_table_tables_orders_ibfk_2` FOREIGN KEY (`Order_id`) REFERENCES `orders` (`ID`);

--
-- Beperkingen voor tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
