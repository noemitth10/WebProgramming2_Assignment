-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1:3306
-- Létrehozás ideje: 2020. Jan 21. 09:55
-- Kiszolgáló verziója: 5.7.26
-- PHP verzió: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `beadando`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `comicbooks`
--

DROP TABLE IF EXISTS `comicbooks`;
CREATE TABLE IF NOT EXISTS `comicbooks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `writer` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `illustrator` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `year` int(11) NOT NULL,
  `cover` varchar(255) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `desc` text COLLATE utf8_hungarian_ci NOT NULL,
  `userId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `comicbooks`
--

INSERT INTO `comicbooks` (`id`, `title`, `writer`, `illustrator`, `year`, `cover`, `desc`, `userId`) VALUES
(2, 'Iron Man', 'Stan Lee', 'Don Heck', 1998, 'covers\\A1PoGOKAYOL._SY679_.jpg', 'Iron Man is a fictional superhero appearing in American comic books published by Marvel Comics. The character was co-created by writer and editor Stan Lee, developed by scripter Larry Lieber, and designed by artists Don Heck and Jack Kirby. ', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `birth_date` date NOT NULL,
  `registration_date` date DEFAULT NULL,
  `password` text COLLATE utf8_hungarian_ci NOT NULL,
  `profile_pic` text COLLATE utf8_hungarian_ci,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`userId`, `username`, `email`, `fullname`, `birth_date`, `registration_date`, `password`, `profile_pic`) VALUES
(1, 'Admin1', 'admin@gmail.com', 'Admin', '1998-01-01', '2019-12-16', '$2y$10$e0.cvFIIuwsKPilYRWiTSOU3pjqKMlzvsQpCcqI.2PNE..ilu563e', 'none');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
