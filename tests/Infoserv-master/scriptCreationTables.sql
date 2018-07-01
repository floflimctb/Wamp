-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Ven 15 Juillet 2016 à 20:23
-- Version du serveur :  5.5.46-0+deb8u1
-- Version de PHP :  5.6.14-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `Infoserv`
--
DROP DATABASE `Infoserv`;
CREATE DATABASE IF NOT EXISTS `Infoserv` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `Infoserv`;

-- --------------------------------------------------------

--
-- Structure de la table `adresse`
--

CREATE TABLE IF NOT EXISTS `adresse` (
  `adresse` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `complAdress` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `codePostal` varchar(5) COLLATE utf8_bin DEFAULT NULL,
  `ville` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `id` int(11) NOT NULL DEFAULT '0',
  `client` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Structure de la table `adresseEmploye`
--

CREATE TABLE IF NOT EXISTS `adresseEmploye` (
  `adresse` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `complAdress` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `codePostal` varchar(5) COLLATE utf8_bin DEFAULT NULL,
  `ville` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `id` int(11) NOT NULL DEFAULT '0',
  `employe` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Structure de la table `apteA`
--

CREATE TABLE IF NOT EXISTS `apteA` (
  `employe` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `service` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Structure de la table `commande`
--

CREATE TABLE IF NOT EXISTS `commande` (
  `id` int(11) NOT NULL DEFAULT '0',
  `client` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `adresse` int(11) DEFAULT NULL,
  `employe` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `adresseEmploye` int(11) DEFAULT NULL,
  `service` int(11) DEFAULT NULL,
  `heureDeb` time DEFAULT NULL,
  `heureFin` time DEFAULT NULL,
  `dateCommande` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Structure de la table `employe`
--

CREATE TABLE IF NOT EXISTS `employe` (
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `nom` varchar(255) COLLATE utf8_bin NOT NULL,
  `prenom` varchar(255) COLLATE utf8_bin NOT NULL,
  `telephone` varchar(10) COLLATE utf8_bin NOT NULL,
  `vacance` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Structure de la table `facture`
--

CREATE TABLE IF NOT EXISTS `facture` (
`id` int(11) NOT NULL,
  `client` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `adresseFacturation` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Structure de la table `factureServices`
--

CREATE TABLE IF NOT EXISTS `factureServices` (
  `facture` int(11) NOT NULL DEFAULT '0',
  `service` int(11) NOT NULL DEFAULT '0',
  `nbService` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

CREATE TABLE IF NOT EXISTS `service` (
`id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` varchar(9000) COLLATE utf8_bin DEFAULT NULL,
  `prix` float NOT NULL,
  `duree` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `civilite` varchar(4) COLLATE utf8_bin NOT NULL,
  `nom` varchar(255) COLLATE utf8_bin NOT NULL,
  `prenom` varchar(255) COLLATE utf8_bin NOT NULL,
  `dateNaiss` date NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `mdp` varchar(32) COLLATE utf8_bin NOT NULL,
  `telephone` varchar(10) COLLATE utf8_bin NOT NULL,
  `md5` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `estValide` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `adresse`
--
ALTER TABLE `adresse`
 ADD PRIMARY KEY (`client`,`id`);

--
-- Index pour la table `adresseEmploye`
--
ALTER TABLE `adresseEmploye`
 ADD PRIMARY KEY (`employe`,`id`);

--
-- Index pour la table `apteA`
--
ALTER TABLE `apteA`
 ADD PRIMARY KEY (`employe`,`service`), ADD KEY `fk_saa` (`service`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
 ADD PRIMARY KEY (`id`,`client`), ADD KEY `fk_auc` (`client`,`adresse`), ADD KEY `fk_aec` (`employe`,`adresseEmploye`), ADD KEY `fk_sc` (`service`);

--
-- Index pour la table `employe`
--
ALTER TABLE `employe`
 ADD PRIMARY KEY (`email`);

--
-- Index pour la table `facture`
--
ALTER TABLE `facture`
 ADD PRIMARY KEY (`id`), ADD KEY `client` (`client`,`adresseFacturation`);

--
-- Index pour la table `factureServices`
--
ALTER TABLE `factureServices`
 ADD PRIMARY KEY (`facture`,`service`,`nbService`), ADD KEY `fk_service_factureService` (`service`);

--
-- Index pour la table `service`
--
ALTER TABLE `service`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
 ADD PRIMARY KEY (`email`);

--
-- Contraintes pour la table `adresse`
--
ALTER TABLE `adresse`
ADD CONSTRAINT `fk_u` FOREIGN KEY (`client`) REFERENCES `utilisateur` (`email`);

--
-- Contraintes pour la table `adresseEmploye`
--
ALTER TABLE `adresseEmploye`
ADD CONSTRAINT `fk_e` FOREIGN KEY (`employe`) REFERENCES `employe` (`email`);

--
-- Contraintes pour la table `apteA`
--
ALTER TABLE `apteA`
ADD CONSTRAINT `fk_eaa` FOREIGN KEY (`employe`) REFERENCES `employe` (`email`),
ADD CONSTRAINT `fk_saa` FOREIGN KEY (`service`) REFERENCES `service` (`id`);

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
ADD CONSTRAINT `fk_aec` FOREIGN KEY (`employe`, `adresseEmploye`) REFERENCES `adresseEmploye` (`employe`, `id`),
ADD CONSTRAINT `fk_auc` FOREIGN KEY (`client`, `adresse`) REFERENCES `adresse` (`client`, `id`),
ADD CONSTRAINT `fk_sc` FOREIGN KEY (`service`) REFERENCES `service` (`id`);

--
-- Contraintes pour la table `facture`
--
ALTER TABLE `facture`
ADD CONSTRAINT `facture_ibfk_1` FOREIGN KEY (`client`, `adresseFacturation`) REFERENCES `adresse` (`client`, `id`);

--
-- Contraintes pour la table `factureServices`
--
ALTER TABLE `factureServices`
ADD CONSTRAINT `fk_facture_factureService` FOREIGN KEY (`facture`) REFERENCES `facture` (`id`),
ADD CONSTRAINT `fk_service_factureService` FOREIGN KEY (`service`) REFERENCES `service` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
