-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Pát 19. úno 2021, 10:40
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

-- --------------------------------------------------------

--
-- Struktura tabulky `radekfaktury`
--

CREATE TABLE `radekfaktury` (
  `id` int(11) NOT NULL,
  `idFaktury` int(11) NOT NULL,
  `idZbozi` int(11) NOT NULL,
  `cena` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

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
(3, 'admin', '$2y$10$PZ9/2rxTafBAcpNqAx/e1uu5Br50nFZ.hZelnyiDULt4zc5DgLfeS', '', 1, 1),
(4, 'Jaroslav', '$2y$10$Zrab8navEOCP6snnxxnKCeQc2Iaq9EaFEGtmO3kk4iL.2M9EPjSz.', '', 0, 1),
(5, 'jan', '$2y$10$90zaZu0t4PWaMpsgzep6gOFFig0sVr/vq41K2ItVQSwA.ZAxQR4ca', '', 0, 1),
(6, 'Alena', '$2y$10$vv5V96ENLUeAp2tc/GJPMediQuWTDhoe21829JRuzCrKPtTIjoGjS', '', 0, 1),
(7, 'Tomáš', '$2y$10$Pj66KpEgFilPvakhxm9FJe5bJp9BnifIqtjvcUxG8skYNJUDi8qCm', '', 0, 1),
(8, 'tom', '$2y$10$gtAqJWHCgK.RuQNjPHKDK.Tjp8zUVdN.2TXItf4C93IYHdWcjpXKC', '', 0, 1),
(9, 'lola', '$2y$10$TfmaacGmO9Li7C3X0NKRi.WvfxiOBSDe4VIDLtAcfiWOkj0M5.g0y', '', 0, 1);

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
(1, 'ponožky', 50, 10, '', 1),
(2, 'svetr', 600, 10, '', 1),
(3, 'košile', 1000, 10, '', 1),
(4, 'kalhoty', 800, 10, '', 1),
(5, 'ondra', 10, 10, '', 1),
(6, 'párek', 20, 10, '', 1),
(7, 'kečup', 35, 10, '', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pro tabulku `komentare`
--
ALTER TABLE `komentare`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `kosik`
--
ALTER TABLE `kosik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `radekfaktury`
--
ALTER TABLE `radekfaktury`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pro tabulku `uzivatel`
--
ALTER TABLE `uzivatel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pro tabulku `zbozi`
--
ALTER TABLE `zbozi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
