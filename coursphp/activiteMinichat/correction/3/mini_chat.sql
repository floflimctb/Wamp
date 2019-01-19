-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 19 jan. 2019 à 10:51
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `mini_chat`
--

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pseudo` varchar(20) NOT NULL,
  `contenu` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `date_creation`, `pseudo`, `contenu`) VALUES
(1, '2019-01-19 11:48:41', 'Mike', 'Philippe ! Je sais oÃ¹ tu te caches ! Viens ici que je te bute enculÃ©'),
(2, '2019-01-19 11:49:40', 'Philippe', 'TA GUEULE !'),
(3, '2019-01-19 11:49:50', 'Philippe', 'Viens ici sale enculÃ© !'),
(4, '2019-01-19 11:50:01', 'Mike', 'Salaud !'),
(5, '2019-01-19 11:50:59', 'Admin', 'Il est interdit de regarder Hitman le Cobra en cours ! Vous me ferez 10 tutoriels sur le PHP pour demain !');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
