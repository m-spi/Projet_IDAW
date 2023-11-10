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

-- --------------------------------------------------------

--
-- Table structure for table `NUTRIMENTS`
--

CREATE TABLE `NUTRIMENTS` (
  `ID_NUTRIMENT` int(11) NOT NULL,
  `NOM_NUTRIMENT` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- /!\/!\/!\/!\/!\/!\/!\/!\/!\/!\/!\/!\/!\/!\/!\
-- /!\ Indices et contraintes dans data.sql. /!\
-- /!\/!\/!\/!\/!\/!\/!\/!\/!\/!\/!\/!\/!\/!\/!\

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;