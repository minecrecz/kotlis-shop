-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Úte 20. dub 2021, 10:51
-- Verze serveru: 10.4.14-MariaDB
-- Verze PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `obchodit3`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `faktury`
--

CREATE TABLE `faktury` (
  `id` int(11) NOT NULL,
  `idUzivatele` int(11) NOT NULL,
  `datum` date NOT NULL,
  `stav` enum('založeno','vyřizuje se','na cestě','dokončeno') COLLATE utf8_czech_ci NOT NULL DEFAULT 'založeno',
  `poznamka` text COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `faktury`
--

INSERT INTO `faktury` (`id`, `idUzivatele`, `datum`, `stav`, `poznamka`) VALUES
(28, 18, '2021-04-15', 'založeno', ''),
(29, 18, '2021-04-15', 'založeno', ''),
(30, 18, '2021-04-15', 'založeno', ''),
(31, 18, '2021-04-15', 'založeno', ''),
(32, 18, '2021-04-15', 'založeno', ''),
(33, 18, '2021-04-15', 'založeno', ''),
(34, 12, '2021-04-15', 'založeno', ''),
(35, 12, '2021-04-15', 'založeno', ''),
(36, 18, '2021-04-15', 'založeno', ''),
(37, 18, '2021-04-15', 'založeno', ''),
(38, 18, '2021-04-15', 'založeno', '');

-- --------------------------------------------------------

--
-- Struktura tabulky `komentare`
--

CREATE TABLE `komentare` (
  `id` int(11) NOT NULL,
  `idUzivatele` int(11) NOT NULL,
  `idZbozi` int(11) NOT NULL,
  `text` text COLLATE utf8_czech_ci NOT NULL,
  `aktivni` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `kosik`
--

CREATE TABLE `kosik` (
  `id` int(11) NOT NULL,
  `idUzivatele` int(11) NOT NULL,
  `idZbozi` int(11) NOT NULL,
  `ks` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `kosik`
--

INSERT INTO `kosik` (`id`, `idUzivatele`, `idZbozi`, `ks`) VALUES
(8, 17, 3, 6),
(9, 17, 7, 4),
(10, 17, 6, 5),
(11, 19, 1, 1),
(12, 19, 4, 6),
(13, 19, 6, 6);

-- --------------------------------------------------------

--
-- Struktura tabulky `radekfaktury`
--

CREATE TABLE `radekfaktury` (
  `id` int(11) NOT NULL,
  `idFaktury` int(11) NOT NULL,
  `idZbozi` int(11) NOT NULL,
  `cena` int(11) NOT NULL,
  `ks` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `radekfaktury`
--

INSERT INTO `radekfaktury` (`id`, `idFaktury`, `idZbozi`, `cena`, `ks`) VALUES
(35, 33, 11, 5000, 1),
(36, 33, 3, 1500, 3),
(37, 33, 9, 20, 8),
(38, 33, 4, 400, 4),
(39, 34, 4, 400, 2),
(40, 34, 7, 35, 1),
(41, 35, 4, 400, 2),
(42, 35, 7, 35, 1),
(43, 36, 10, 230, 3),
(44, 37, 1, 100, 1),
(45, 38, 3, 1500, 10),
(46, 38, 4, 400, 9);

-- --------------------------------------------------------

--
-- Struktura tabulky `uzivatel`
--

CREATE TABLE `uzivatel` (
  `id` int(11) NOT NULL,
  `jmeno` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `heslo` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `adresa` varchar(155) COLLATE utf8_czech_ci NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `aktivni` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `uzivatel`
--

INSERT INTO `uzivatel` (`id`, `jmeno`, `heslo`, `adresa`, `admin`, `aktivni`) VALUES
(10, 'admin', '$2y$10$RwiJxggHCaW/2l2KsQNgp.PCXCd1DcOvK5cSRuirPTFhY2tXSDEdi', '', 1, 1),
(11, 'Jaroslav', '$2y$10$SlC/3MWwqKICvzH15uMswevXsRY2eJz/DC.GFMHeH6bRJQ2FGMu/O', '', 0, 1),
(12, 'w', '$2y$10$YCjlv0ZrlLe/LWnc0xnmoeltDh2m8SOQGMQCnuKmflqa3lt5FbyBe', '', 0, 1),
(13, 'o', '$2y$10$jQ1gyD3d955K3oiMkUddFu7PvUIKCFy3dyq9/cHT70dTF1ooyu21O', '', 0, 1),
(14, 'q', '$2y$10$pf1l/saKsxGJy4QyZ.dTr.LmFc2sS/FSFg2dS2jYrJp5nSvZtfdre', '', 0, 1),
(15, 'rew', '$2y$10$j8TJv6lA2yfe.kOOPjT5ju89u1wPq.xauV.N5QsZ239hLgzVg9h66', '', 0, 1),
(16, 'Matouš', '$2y$10$iX2qPGmtnbTkF78xBl6beeD4GiYhUU/Z5ZOBnoEedPtdjaSNqSJgm', '', 1, 1),
(17, 'p', '$2y$10$ZkMi6tUb6l/zPJsz76JYBesZgILibytg4Aruf94LeUgXT5ekhGkOS', '', 0, 1),
(18, 'Jara', '$2y$10$UfFAPA6MiIgqbIVU0NgyZu8.2Wc1uHEdp/sdKAjncooBaEYNxEAwu', '', 0, 1),
(19, 'a', '$2y$10$6BKibyevYN3TQGdnyFgTs.2V9YzvehDt54uPFWDhRdwRJ3iy2ENbG', '', 0, 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `zbozi`
--

CREATE TABLE `zbozi` (
  `id` int(11) NOT NULL,
  `nazev` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `cena` int(11) NOT NULL,
  `ks` int(11) NOT NULL DEFAULT 10,
  `obrazek` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `aktivni` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `zbozi`
--

INSERT INTO `zbozi` (`id`, `nazev`, `cena`, `ks`, `obrazek`, `aktivni`) VALUES
(1, 'ponožky', 100, 3, '', 1),
(3, 'košile', 1500, 5, '', 1),
(4, 'kalhoty', 400, 1, '', 1),
(5, 'ondra', 10, 10, '', 0),
(6, 'párek', 20, 10, '', 1),
(7, 'kečup', 35, 10, '', 1),
(9, 'deli', 20, 56, '', 1),
(10, 'kleště', 230, 14, '', 1),
(11, 'tiskárna', 5000, 3, '', 1);

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `faktury`
--
ALTER TABLE `faktury`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUzivatele` (`idUzivatele`);

--
-- Klíče pro tabulku `komentare`
--
ALTER TABLE `komentare`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUzivatele` (`idUzivatele`,`idZbozi`),
  ADD KEY `idZbozi` (`idZbozi`);

--
-- Klíče pro tabulku `kosik`
--
ALTER TABLE `kosik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUzivatele` (`idUzivatele`,`idZbozi`),
  ADD KEY `idZbozi` (`idZbozi`);

--
-- Klíče pro tabulku `radekfaktury`
--
ALTER TABLE `radekfaktury`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idFaktury` (`idFaktury`,`idZbozi`),
  ADD KEY `idZbozi` (`idZbozi`);

--
-- Klíče pro tabulku `uzivatel`
--
ALTER TABLE `uzivatel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `id_2` (`id`);

--
-- Klíče pro tabulku `zbozi`
--
ALTER TABLE `zbozi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `faktury`
--
ALTER TABLE `faktury`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT pro tabulku `komentare`
--
ALTER TABLE `komentare`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `kosik`
--
ALTER TABLE `kosik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pro tabulku `radekfaktury`
--
ALTER TABLE `radekfaktury`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT pro tabulku `uzivatel`
--
ALTER TABLE `uzivatel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pro tabulku `zbozi`
--
ALTER TABLE `zbozi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `faktury`
--
ALTER TABLE `faktury`
  ADD CONSTRAINT `faktury_ibfk_1` FOREIGN KEY (`idUzivatele`) REFERENCES `uzivatel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `komentare`
--
ALTER TABLE `komentare`
  ADD CONSTRAINT `komentare_ibfk_1` FOREIGN KEY (`idUzivatele`) REFERENCES `uzivatel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `komentare_ibfk_2` FOREIGN KEY (`idZbozi`) REFERENCES `zbozi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `kosik`
--
ALTER TABLE `kosik`
  ADD CONSTRAINT `kosik_ibfk_1` FOREIGN KEY (`idUzivatele`) REFERENCES `uzivatel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kosik_ibfk_2` FOREIGN KEY (`idZbozi`) REFERENCES `zbozi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `radekfaktury`
--
ALTER TABLE `radekfaktury`
  ADD CONSTRAINT `radekfaktury_ibfk_1` FOREIGN KEY (`idZbozi`) REFERENCES `zbozi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `radekfaktury_ibfk_2` FOREIGN KEY (`idFaktury`) REFERENCES `faktury` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
