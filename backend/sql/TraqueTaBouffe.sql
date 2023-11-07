-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 06, 2023 at 08:33 AM
-- Server version: 11.1.2-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `TraqueTaBouffe`
--

-- --------------------------------------------------------

--
-- Table structure for table `ALIMENTS`
--

CREATE TABLE `ALIMENTS` (
  `ID_ALIMENT` int(11) NOT NULL,
  `INDICE_NOVA` int(11) DEFAULT NULL,
  `NOM_ALIMENT` varchar(1024) NOT NULL,
  `ISLIQUID` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ALIMENTS`
--

INSERT INTO `ALIMENTS` (`ID_ALIMENT`, `INDICE_NOVA`, `NOM_ALIMENT`, `ISLIQUID`) VALUES
(84, 1, 'eau cristaline', 1),
(85, 4, 'coca', 1),
(86, 4, 'IceTea', 1),
(87, 4, 'Fanta', 1),
(88, 4, 'Orangina', 1),
(89, 1, 'Hépar', 1),
(90, 1, 'Salveta', 1),
(91, 4, 'Oasis', 1),
(92, 1, 'Laitue', 0),
(93, 4, 'Pain de mie blanc', 0),
(94, 4, 'Pain de mie complet', 0),
(95, 4, 'Nutella', 0),
(96, 3, 'chocolat noir 70%', 0),
(97, 1, 'flocons d\'avoine', 0),
(98, 4, 'Oreo', 0),
(99, 4, 'velouté yahourt', 0),
(100, 1, 'jus d\'orange', 1),
(101, 3, 'Bière 1664', 1),
(102, 4, 'Desperados', 1),
(103, 3, 'leffe blonde', 1),
(104, 3, 'yahourt nature', 0),
(105, 4, 'pringles nature', 0),
(106, 4, 'chocolat milka', 0),
(107, 3, 'Chips nature lay\'s', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ALIMENT_CONSOMME`
--

CREATE TABLE `ALIMENT_CONSOMME` (
  `ID_REPAS` int(11) NOT NULL,
  `ID_ALIMENT_FK` int(11) NOT NULL,
  `ID_USER_FK` int(11) NOT NULL,
  `DATE` datetime NOT NULL,
  `QUANTITE` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `COMPOSITION`
--

CREATE TABLE `COMPOSITION` (
  `ID_COMPOSANT_FK` int(11) NOT NULL,
  `ID_ALIMENT_FK` int(11) NOT NULL,
  `POURCENTAGE` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `EST_COMPOSE`
--

CREATE TABLE `EST_COMPOSE` (
  `ID_NUTRIMENT_FK` int(11) NOT NULL,
  `ID_ALIMENT_FK` int(11) NOT NULL,
  `POUR_100G` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `EST_COMPOSE`
--

INSERT INTO `EST_COMPOSE` (`ID_NUTRIMENT_FK`, `ID_ALIMENT_FK`, `POUR_100G`) VALUES
(1, 84, 0),
(1, 85, 42),
(1, 86, 20),
(1, 87, 27),
(1, 88, 41),
(1, 89, 0),
(1, 90, 0),
(1, 91, 33),
(1, 92, 18),
(1, 93, 271),
(1, 94, 253),
(1, 95, 539),
(1, 96, 566),
(1, 97, 362),
(1, 98, 474),
(1, 99, 93),
(1, 100, 43),
(1, 101, 45),
(1, 102, 59),
(1, 103, 58),
(1, 104, 45),
(1, 105, 534),
(1, 106, 539),
(1, 107, 551),
(2, 84, 0.05),
(2, 85, 0),
(2, 86, 0.01),
(2, 87, 0),
(2, 88, 0.01),
(2, 89, 0),
(2, 90, 0),
(2, 91, 0),
(2, 92, 0.03),
(2, 93, 1.1),
(2, 94, 1.2),
(2, 95, 0.11),
(2, 96, 0.1),
(2, 97, 0.02),
(2, 98, 0.73),
(2, 99, 0.12),
(2, 100, 0),
(2, 101, 0.01),
(2, 102, 0.01),
(2, 103, 0.1),
(2, 104, 0.14),
(2, 105, 1.1),
(2, 106, 0.28),
(2, 107, 1.1),
(3, 84, 0),
(3, 85, 10.6),
(3, 86, 4.5),
(3, 87, 6.5),
(3, 88, 9.6),
(3, 89, 0),
(3, 90, 0),
(3, 91, 7.8),
(3, 92, 1.5),
(3, 93, 7.7),
(3, 94, 4.9),
(3, 95, 56.3),
(3, 96, 30),
(3, 97, 1.7),
(3, 98, 38),
(3, 99, 13.1),
(3, 100, 8.9),
(3, 101, 0.08),
(3, 102, 2.2),
(3, 103, 0.5),
(3, 104, 5.1),
(3, 105, 1.4),
(3, 106, 55),
(3, 107, 0.5),
(4, 84, 0),
(4, 85, 0),
(4, 86, 0),
(4, 87, 0),
(4, 88, 0.1),
(4, 89, 0),
(4, 90, 0),
(4, 91, 0.1),
(4, 92, 0.9),
(4, 93, 7.6),
(4, 94, 7.7),
(4, 95, 6.3),
(4, 96, 9.5),
(4, 97, 11),
(4, 98, 5.3),
(4, 99, 3.5),
(4, 100, 0.8),
(4, 101, 0.5),
(4, 102, 0),
(4, 103, 0.4),
(4, 104, 3.8),
(4, 105, 5.9),
(4, 106, 6.5),
(4, 107, 6.3),
(5, 84, 0),
(5, 85, 0),
(5, 86, 0),
(5, 87, 0),
(5, 88, 0),
(5, 89, 0),
(5, 90, 0),
(5, 91, 0),
(5, 92, 1.3),
(5, 93, 3.9),
(5, 94, 7.2),
(5, 95, 0),
(5, 96, 0),
(5, 97, 11),
(5, 98, 2.7),
(5, 99, 0),
(5, 100, 0.6),
(5, 101, 0),
(5, 102, 0),
(5, 103, 0),
(5, 104, 0),
(5, 105, 3.5),
(5, 106, 2.3),
(5, 107, 4.2),
(6, 84, 0),
(6, 85, 0),
(6, 86, 0),
(6, 87, 0),
(6, 88, 0),
(6, 89, 0),
(6, 90, 0),
(6, 91, 0),
(6, 92, 0.1),
(6, 93, 0.4),
(6, 94, 0.4),
(6, 95, 10.6),
(6, 96, 24),
(6, 97, 1.3),
(6, 98, 5.2),
(6, 99, 1.9),
(6, 100, 0),
(6, 101, 0),
(6, 102, 0),
(6, 103, 0),
(6, 104, 0.6),
(6, 105, 6.6),
(6, 106, 19),
(6, 107, 4.2),
(7, 84, 0),
(7, 85, 0),
(7, 86, 0),
(7, 87, 0),
(7, 88, 0),
(7, 89, 0),
(7, 90, 0),
(7, 91, 0),
(7, 92, 0),
(7, 93, 0),
(7, 94, 0),
(7, 95, 0),
(7, 96, 0),
(7, 97, 0),
(7, 98, 0),
(7, 99, 0),
(7, 100, 0),
(7, 101, 5.5),
(7, 102, 5.9),
(7, 103, 6.6),
(7, 104, 0),
(7, 105, 0),
(7, 106, 0),
(7, 107, 0);

-- --------------------------------------------------------

--
-- Table structure for table `NUTRIMENTS`
--

CREATE TABLE `NUTRIMENTS` (
  `ID_NUTRIMENT` int(11) NOT NULL,
  `NOM_NUTRIMENT` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `NUTRIMENTS`
--

INSERT INTO `NUTRIMENTS` (`ID_NUTRIMENT`, `NOM_NUTRIMENT`) VALUES
(1, 'energie_kcal'),
(2, 'sel'),
(3, 'sucre'),
(4, 'proteines'),
(5, 'fibre_alimentaire'),
(6, 'matiere_grasses'),
(7, 'alcool');

-- --------------------------------------------------------

--
-- Table structure for table `USER`
--

CREATE TABLE `USER` (
  `ID_USER` int(11) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `NOM` varchar(1024) NOT NULL,
  `PRENOM` varchar(1024) DEFAULT NULL,
  `AGE` int(11) NOT NULL,
  `ISMALE` tinyint(1) NOT NULL,
  `POIDS` float NOT NULL,
  `TAILLE` float NOT NULL,
  `SPORT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ALIMENTS`
--
ALTER TABLE `ALIMENTS`
  ADD PRIMARY KEY (`ID_ALIMENT`),
  ADD KEY `NOM_ALIMENT` (`NOM_ALIMENT`(768));

--
-- Indexes for table `ALIMENT_CONSOMME`
--
ALTER TABLE `ALIMENT_CONSOMME`
  ADD PRIMARY KEY (`ID_REPAS`),
  ADD KEY `FK_ALIMENT__CONSOMME_USER` (`ID_USER_FK`),
  ADD KEY `FK_ALIMENT__EST_ALIMENTS` (`ID_ALIMENT_FK`),
  ADD KEY `DATE` (`DATE`);

--
-- Indexes for table `COMPOSITION`
--
ALTER TABLE `COMPOSITION`
  ADD PRIMARY KEY (`ID_COMPOSANT_FK`,`ID_ALIMENT_FK`),
  ADD KEY `FK2_COMPOSIT_COMPOSITI_ALIMENTS` (`ID_ALIMENT_FK`);

--
-- Indexes for table `EST_COMPOSE`
--
ALTER TABLE `EST_COMPOSE`
  ADD PRIMARY KEY (`ID_NUTRIMENT_FK`,`ID_ALIMENT_FK`),
  ADD KEY `FK2_EST_COMP_EST_COMPO_ALIMENTS` (`ID_ALIMENT_FK`);

--
-- Indexes for table `NUTRIMENTS`
--
ALTER TABLE `NUTRIMENTS`
  ADD PRIMARY KEY (`ID_NUTRIMENT`);

--
-- Indexes for table `USER`
--
ALTER TABLE `USER`
  ADD PRIMARY KEY (`ID_USER`),
  ADD KEY `EMAIL` (`EMAIL`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ALIMENTS`
--
ALTER TABLE `ALIMENTS`
  MODIFY `ID_ALIMENT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `ALIMENT_CONSOMME`
--
ALTER TABLE `ALIMENT_CONSOMME`
  MODIFY `ID_REPAS` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `NUTRIMENTS`
--
ALTER TABLE `NUTRIMENTS`
  MODIFY `ID_NUTRIMENT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `USER`
--
ALTER TABLE `USER`
  MODIFY `ID_USER` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ALIMENT_CONSOMME`
--
ALTER TABLE `ALIMENT_CONSOMME`
  ADD CONSTRAINT `FK_ALIMENT_CONSOMME_USER` FOREIGN KEY (`ID_USER_FK`) REFERENCES `USER` (`ID_USER`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ALIMENT_EST_ALIMENTS` FOREIGN KEY (`ID_ALIMENT_FK`) REFERENCES `ALIMENTS` (`ID_ALIMENT`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `COMPOSITION`
--
ALTER TABLE `COMPOSITION`
  ADD CONSTRAINT `FK2_COMPOSIT_COMPOSITI_ALIMENTS` FOREIGN KEY (`ID_ALIMENT_FK`) REFERENCES `ALIMENTS` (`ID_ALIMENT`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_COMPOSIT_COMPOSITI_ALIMENTS` FOREIGN KEY (`ID_COMPOSANT_FK`) REFERENCES `ALIMENTS` (`ID_ALIMENT`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `EST_COMPOSE`
--
ALTER TABLE `EST_COMPOSE`
  ADD CONSTRAINT `FK2_EST_COMP_EST_COMPO_ALIMENTS` FOREIGN KEY (`ID_ALIMENT_FK`) REFERENCES `ALIMENTS` (`ID_ALIMENT`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_EST_COMP_EST_COMPO_NUTRIMEN` FOREIGN KEY (`ID_NUTRIMENT_FK`) REFERENCES `NUTRIMENTS` (`ID_NUTRIMENT`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
