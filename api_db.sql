-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 17. Apr 2019 um 15:45
-- Server-Version: 10.1.38-MariaDB
-- PHP-Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `api_db`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created`, `modified`) VALUES
(1, 'Parkett', 'Category for anything related to Parkett.', '2019-04-15 00:00:00', '2019-04-15 15:34:33'),
(2, 'Teppich', 'Category for anything related to Teppich', '2019-04-15 00:35:07', '2019-04-15 15:34:33'),
(3, 'Designböden', 'Category for anything related to Designböden', '2019-04-15 00:35:07', '2019-04-15 15:34:54'),
(4, 'Laminat', 'Category for anything related to Laminat', '2019-04-15 00:00:00', '2019-04-15 11:27:26'),
(5, 'Terrasse', 'Category for anything related to Terrasse', '2019-04-15 00:00:00', '2019-04-15 11:27:47'),
(6, 'Werkzeuge', 'Category for anything related to Werkzeuge', '2019-04-15 02:24:24', '2019-04-14 23:24:24'),
(7, 'Zubehör', 'Category for anything related to Zubehör', '0000-00-00 00:00:00', '2019-04-15 09:08:31');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `collection`
--

CREATE TABLE `collection` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_german2_ci NOT NULL,
  `category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `collection`
--

INSERT INTO `collection` (`id`, `name`, `category`) VALUES
(1, 'Skyline LD', 1),
(2, 'Deluxe', 1),
(3, 'Classic', 1),
(4, 'Kingston', 1),
(5, 'Plastik', 2),
(6, 'Kunststoff', 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_german2_ci NOT NULL,
  `type` varchar(32) CHARACTER SET utf8 COLLATE utf8_german2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `images`
--

INSERT INTO `images` (`id`, `productId`, `name`, `type`) VALUES
(45, 6, '\\big\\6_45.jpg', ''),
(46, 6, '\\middle\\6_46.jpg', ''),
(47, 6, '\\thumbnail\\6_47.jpg', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `category_id` int(11) NOT NULL,
  `eanNo` varchar(13) NOT NULL,
  `collection` int(11) NOT NULL,
  `nameId` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `category_id`, `eanNo`, `collection`, `nameId`, `created`, `modified`) VALUES
(1, 'Parkett, Eiche geölt', '', '125', 1, '123456789', 1, '', '2019-04-15 01:12:26', '2019-04-15 15:12:26'),
(2, 'Parkett, Eiche geölt (dunkel)', '', '89', 1, '123456789', 1, '', '2019-04-15 01:12:26', '2019-04-15 15:12:26'),
(3, 'Parkett, Eiche geölt (hell)', '', '95', 1, '123456789', 1, '', '2019-04-15 01:12:26', '2019-04-15 15:12:26'),
(6, 'Parkett, Eiche geölt (honig)', '', '189', 1, '123456789', 1, '', '2019-04-15 01:12:26', '2019-04-15 00:12:21'),
(7, 'Parkett, Nussbaum', '', '78', 1, '123456789', 1, '', '2019-04-15 01:13:45', '2019-04-15 00:13:39'),
(8, 'Teppich, Beige', '', '25', 2, '123456789', 2, '', '2019-04-15 01:14:13', '2019-04-15 00:14:08'),
(9, 'Teppich, robust', '', '39', 2, '123456789', 2, '', '2019-04-15 01:18:36', '2019-04-15 00:18:31'),
(10, 'Teppich, dunkel', '', '19', 2, '123456789', 2, '', '2019-04-15 17:10:01', '2019-04-15 16:09:51'),
(11, 'Designboden, wasserfest', '', '49', 3, '123456789', 0, '', '2019-04-15 17:11:04', '2019-04-15 16:10:54'),
(12, 'Designboden, Marmor', '', '58', 3, '123456789', 0, '', '2019-04-15 17:12:21', '2019-04-15 16:12:11'),
(13, 'Laminat, Buche', '', '29', 4, '123456789', 0, '', '2019-04-15 17:12:59', '2019-04-15 16:12:49'),
(26, 'Laminat, Esche', '', '34', 4, '123456789', 0, '', '2019-04-15 19:07:34', '2019-04-15 18:07:34'),
(28, 'Terrasse, WPC (Schoko)', '', '78', 5, '123456789', 0, '', '2019-04-15 21:12:03', '2019-04-15 20:12:03'),
(31, 'Werkzeug, Hammer', '', '39', 6, '123456789', 0, '', '2019-04-15 00:52:54', '2019-04-14 23:52:54'),
(42, 'Werkzeug, Schlageisen', '', '19', 6, '123456789', 0, '', '2019-04-15 06:47:08', '2019-04-15 03:47:08'),
(48, 'Zubehör, Leim', '', '8', 7, '123456789', 0, '', '2019-04-15 06:36:37', '2019-04-15 03:36:37'),
(60, 'Zubehör, Kleber', '', '15', 7, '123456789', 0, '', '2019-04-15 15:46:02', '2019-04-15 12:46:02'),
(61, 'Parkett, Eiche geölt (hell)', '', '95', 1, '123456789', 2, '', '2019-04-15 01:12:26', '2019-04-15 15:12:26');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `collection`
--
ALTER TABLE `collection`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT für Tabelle `collection`
--
ALTER TABLE `collection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT für Tabelle `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
