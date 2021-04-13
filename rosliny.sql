-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Czas generowania: 17 Sty 2017, 21:40
-- Wersja serwera: 10.1.19-MariaDB
-- Wersja PHP: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `eksperymenty`
--
CREATE DATABASE IF NOT EXISTS `eksperymenty` DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci;
USE `eksperymenty`;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `doswiadczenie`
--

CREATE TABLE `doswiadczenie10` (
  `id` int(11) NOT NULL,
  `ilosc_dni` int(11) NOT NULL,
  `LABORANT_id` int(11) DEFAULT NULL,
  `opis` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `laborant`
--

CREATE TABLE `laborant10` (
  `id` int(11) NOT NULL,
  `imie` varchar(45) DEFAULT NULL,
  `nazwisko` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `laborant`
--

INSERT INTO `laborant10` (`id`, `imie`, `nazwisko`) VALUES
(1, 'Mariusz', 'Prawdziwy'),
(2, 'Tomek', 'Nowy');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `nawoz`
--

CREATE TABLE `nawoz10` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(255) NOT NULL,
  `wspolczynnik_wzrostu` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `nawoz`
--

INSERT INTO `nawoz10` (`id`, `nazwa`, `wspolczynnik_wzrostu`) VALUES
(1, 'Brak nawozu', 1),
(2, 'Wapniowy', 1.8),
(3, 'Naturalny', 1.3),
(4, 'Organiczny', 1.1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `obszar`
--

CREATE TABLE `obszar10` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(255) CHARACTER SET utf8 NOT NULL,
  `wielkosc` int(11) NOT NULL,
  `POWIERZCHNIA_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `obszar`
--

INSERT INTO `obszar10` (`id`, `nazwa`, `wielkosc`, `POWIERZCHNIA_id`) VALUES
(1, 'północ', 10, 1),
(2, 'południe', 20, 1),
(3, 'wschód', 5, 1),
(4, 'zachód', 5, 1),
(5, 'północ', 10, 2),
(6, 'południe', 20, 2),
(7, 'wschód', 5, 2),
(8, 'zachód', 5, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `obszar_has_roslina`
--

CREATE TABLE `obszar_has_roslina10` (
  `id` int(11) NOT NULL,
  `OBSZAR_id` int(11) NOT NULL,
  `ROSLINA_id` int(11) NOT NULL,
  `DOSWIADCZENIE_id` int(11) NOT NULL,
  `ilosc_przy_pomiarze` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `powierzchnia`
--

CREATE TABLE `powierzchnia10` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `powierzchnia`
--

INSERT INTO `powierzchnia10` (`id`, `nazwa`) VALUES
(1, 'Pole Mateusza'),
(2, 'Pole Konrada');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `powierzchnia_has_nawoz`
--

CREATE TABLE `powierzchnia_has_nawoz10` (
  `id` int(11) NOT NULL,
  `POWIERZCHNIA_id` int(11) NOT NULL,
  `NAWOZ_id` int(11) NOT NULL,
  `DOSWIADCZENIE_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `roslina`
--

CREATE TABLE `roslina10` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(45) DEFAULT NULL,
  `jednostka_wzrostu` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `roslina`
--

INSERT INTO `roslina10` (`id`, `nazwa`, `jednostka_wzrostu`) VALUES
(1, 'Brak rośliny', 0),
(2, 'Pomidor', 1),
(3, 'Tulipan', 1.7),
(4, 'Owies', 1.3);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `doswiadczenie`
--
ALTER TABLE `doswiadczenie10`
  ADD PRIMARY KEY (`id`),
  ADD KEY `LABORANT_id` (`LABORANT_id`);

--
-- Indexes for table `laborant`
--
ALTER TABLE `laborant10`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nawoz`
--
ALTER TABLE `nawoz10`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `obszar`
--
ALTER TABLE `obszar10`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_OBSZAR_POWIERZCHNIA_idx` (`POWIERZCHNIA_id`);

--
-- Indexes for table `obszar_has_roslina`
--
ALTER TABLE `obszar_has_roslina10`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_OBSZAR_has_ROSLINA_ROSLINA1_idx` (`ROSLINA_id`),
  ADD KEY `fk_OBSZAR_has_ROSLINA_OBSZAR1_idx` (`OBSZAR_id`),
  ADD KEY `fk_OBSZAR_has_ROSLINA_DOSWIADCZENIE1_idx` (`DOSWIADCZENIE_id`);

--
-- Indexes for table `powierzchnia`
--
ALTER TABLE `powierzchnia10`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `powierzchnia_has_nawoz`
--
ALTER TABLE `powierzchnia_has_nawoz10`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_POWIERZCHNIA_has_NAWOZ_NAWOZ1_idx` (`NAWOZ_id`),
  ADD KEY `fk_POWIERZCHNIA_has_NAWOZ_POWIERZCHNIA1_idx` (`POWIERZCHNIA_id`),
  ADD KEY `fk_POWIERZCHNIA_has_NAWOZ_DOSWIADCZENIE1_idx` (`DOSWIADCZENIE_id`);

--
-- Indexes for table `roslina`
--
ALTER TABLE `roslina10`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `doswiadczenie`
--
ALTER TABLE `doswiadczenie10`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `laborant`
--
ALTER TABLE `laborant10`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT dla tabeli `nawoz`
--
ALTER TABLE `nawoz10`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT dla tabeli `obszar`
--
ALTER TABLE `obszar10`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT dla tabeli `obszar_has_roslina`
--
ALTER TABLE `obszar_has_roslina10`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `powierzchnia`
--
ALTER TABLE `powierzchnia10`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT dla tabeli `powierzchnia_has_nawoz`
--
ALTER TABLE `powierzchnia_has_nawoz10`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `roslina`
--
ALTER TABLE `roslina10`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `doswiadczenie`
--
ALTER TABLE `doswiadczenie10`
  ADD CONSTRAINT `doswiadczenie_ibfk_1` FOREIGN KEY (`LABORANT_id`) REFERENCES `laborant10` (`id`) ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `obszar`
--
ALTER TABLE `obszar10`
  ADD CONSTRAINT `obszar_ibfk_1` FOREIGN KEY (`POWIERZCHNIA_id`) REFERENCES `powierzchnia10` (`id`) ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `obszar_has_roslina`
--
ALTER TABLE `obszar_has_roslina10`
  ADD CONSTRAINT `obszar_has_roslina_ibfk_1` FOREIGN KEY (`DOSWIADCZENIE_id`) REFERENCES `doswiadczenie` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `obszar_has_roslina_ibfk_2` FOREIGN KEY (`ROSLINA_id`) REFERENCES `roslina10` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `obszar_has_roslina_ibfk_3` FOREIGN KEY (`OBSZAR_id`) REFERENCES `obszar10` (`id`) ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `powierzchnia_has_nawoz`
--
ALTER TABLE `powierzchnia_has_nawoz10`
  ADD CONSTRAINT `powierzchnia_has_nawoz_ibfk_1` FOREIGN KEY (`POWIERZCHNIA_id`) REFERENCES `powierzchnia10` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `powierzchnia_has_nawoz_ibfk_2` FOREIGN KEY (`NAWOZ_id`) REFERENCES `nawoz10` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `powierzchnia_has_nawoz_ibfk_3` FOREIGN KEY (`DOSWIADCZENIE_id`) REFERENCES `doswiadczenie` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
