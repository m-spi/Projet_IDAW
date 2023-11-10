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
                                                                                    (1, 1, 'eau cristaline', 1),
                                                                                    (2, 4, 'coca', 1),
                                                                                    (3, 4, 'IceTea', 1),
                                                                                    (4, 4, 'Fanta', 1),
                                                                                    (5, 4, 'Orangina', 1),
                                                                                    (6, 1, 'Hépar', 1),
                                                                                    (7, 1, 'Salveta', 1),
                                                                                    (8, 4, 'Oasis', 1),
                                                                                    (9, 1, 'Laitue', 0),
                                                                                    (10, 4, 'Pain de mie blanc', 0),
                                                                                    (11, 4, 'Pain de mie complet', 0),
                                                                                    (12, 4, 'Nutella', 0),
                                                                                    (13, 3, 'chocolat noir 70%', 0),
                                                                                    (14, 1, 'flocons d\'avoine', 0),
                                                                                    (15, 4, 'Oreo', 0),
                                                                                    (16, 4, 'velouté yahourt', 0),
                                                                                    (17, 1, 'jus d\'orange', 1),
                                                                                    (18, 3, 'Bière 1664', 1),
                                                                                    (19, 4, 'Desperados', 1),
                                                                                    (20, 3, 'leffe blonde', 1),
                                                                                    (21, 3, 'yahourt nature', 0),
                                                                                    (22, 4, 'pringles nature', 0),
                                                                                    (23, 4, 'chocolat milka', 0),
                                                                                    (24, 3, 'Chips nature lay\'s', 0);

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
(1, 1, 0),
(1, 2, 42),
(1, 3, 20),
(1, 4, 27),
(1, 5, 41),
(1, 6, 0),
(1, 7, 0),
(1, 8, 33),
(1, 9, 18),
(1, 10, 271),
(1, 11, 253),
(1, 12, 539),
(1, 13, 566),
(1, 14, 362),
(1, 15, 474),
(1, 16, 10),
(1, 17, 43),
(1, 18, 45),
(1, 19, 59),
(1, 20, 58),
(1, 21, 45),
(1, 22, 534),
(1, 23, 539),
(1, 24, 551),
(2, 1, 0.05),
(2, 2, 0),
(2, 3, 0.01),
(2, 4, 0),
(2, 5, 0.01),
(2, 6, 0),
(2, 7, 0),
(2, 8, 0),
(2, 9, 0.03),
(2, 10, 1.1),
(2, 11, 1.2),
(2, 12, 0.11),
(2, 13, 0.1),
(2, 14, 0.02),
(2, 15, 0.73),
(2, 16, 0.12),
(2, 17, 0),
(2, 18, 0.01),
(2, 19, 0.01),
(2, 20, 0.1),
(2, 21, 0.14),
(2, 22, 1.1),
(2, 23, 0.28),
(2, 24, 1.1),
(3, 1, 0),
(3, 2, 10.6),
(3, 3, 4.5),
(3, 4, 6.5),
(3, 5, 9.6),
(3, 6, 0),
(3, 7, 0),
(3, 8, 7.8),
(3, 9, 1.5),
(3, 10, 7.7),
(3, 11, 4.9),
(3, 12, 56.3),
(3, 13, 30),
(3, 14, 1.7),
(3, 15, 38),
(3, 16, 13.1),
(3, 17, 8.9),
(3, 18, 0.08),
(3, 19, 2.2),
(3, 20, 0.5),
(3, 21, 5.1),
(3, 22, 1.4),
(3, 23, 55),
(3, 24, 0.5),
(4, 1, 0),
(4, 2, 0),
(4, 3, 0),
(4, 4, 0),
(4, 5, 0.1),
(4, 6, 0),
(4, 7, 0),
(4, 8, 0.1),
(4, 9, 0.9),
(4, 10, 7.6),
(4, 11, 7.7),
(4, 12, 6.3),
(4, 13, 9.5),
(4, 14, 11),
(4, 15, 5.3),
(4, 16, 3.5),
(4, 17, 0.8),
(4, 18, 0.5),
(4, 19, 0),
(4, 20, 0.4),
(4, 21, 3.8),
(4, 22, 5.9),
(4, 23, 6.5),
(4, 24, 6.3),
(5, 1, 0),
(5, 2, 0),
(5, 3, 0),
(5, 4, 0),
(5, 5, 0),
(5, 6, 0),
(5, 7, 0),
(5, 8, 0),
(5, 9, 1.3),
(5, 10, 3.9),
(5, 11, 7.2),
(5, 12, 0),
(5, 13, 0),
(5, 14, 11),
(5, 15, 2.7),
(5, 16, 0),
(5, 17, 0.6),
(5, 18, 0),
(5, 19, 0),
(5, 20, 0),
(5, 21, 0),
(5, 22, 3.5),
(5, 23, 2.3),
(5, 24, 4.2),
(6, 1, 0),
(6, 2, 0),
(6, 3, 0),
(6, 4, 0),
(6, 5, 0),
(6, 6, 0),
(6, 7, 0),
(6, 8, 0),
(6, 9, 0.1),
(6, 10, 0.4),
(6, 11, 0.4),
(6, 12, 10.6),
(6, 13, 24),
(6, 14, 1.3),
(6, 15, 5.2),
(6, 16, 1.9),
(6, 17, 0),
(6, 18, 0),
(6, 19, 0),
(6, 20, 0),
(6, 21, 0.6),
(6, 22, 6.6),
(6, 23, 19),
(6, 24, 4.2),
(7, 1, 0),
(7, 2, 0),
(7, 3, 0),
(7, 4, 0),
(7, 5, 0),
(7, 6, 0),
(7, 7, 0),
(7, 8, 0),
(7, 9, 0),
(7, 10, 0),
(7, 11, 0),
(7, 12, 0),
(7, 13, 0),
(7, 14, 0),
(7, 15, 0),
(7, 16, 0),
(7, 17, 0),
(7, 18, 5.5),
(7, 19, 5.9),
(7, 20, 6.6),
(7, 21, 0),
(7, 22, 0),
(7, 23, 0),
(7, 24, 0);

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
  `PASSWORD` varchar(255) NOT NULL,
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
  MODIFY `ID_ALIMENT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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