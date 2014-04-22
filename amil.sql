-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Jeu 03 Avril 2014 à 16:14
-- Version du serveur: 5.6.12-log
-- Version de PHP: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `amil`
--
CREATE DATABASE IF NOT EXISTS `amil` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `amil`;

-- --------------------------------------------------------

--
-- Structure de la table `act`
--

CREATE TABLE IF NOT EXISTS `act` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(250) NOT NULL,
  `presentation` varchar(1000) NOT NULL,
  `date_fin_inscription` date NOT NULL,
  `ville_act` varchar(45) NOT NULL,
  `departement_act` varchar(45) NOT NULL,
  `lieu_act` varchar(250) NOT NULL,
  `lieu_rdv` varchar(1000) NOT NULL,
  `date_act` date NOT NULL,
  `heure_act` varchar(5) NOT NULL,
  `heure_rdv` varchar(5) NOT NULL,
  `heure_fin` varchar(5) NOT NULL,
  `photo` blob NOT NULL,
  `plan` blob NOT NULL,
  `date_parution` date NOT NULL,
  `id_organisation` int(11) NOT NULL,
  `id_type_act` int(11) NOT NULL,
  `id_public_vise` int(11) NOT NULL,
  `id_notification` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_activites_organisateur1_idx` (`id_organisation`),
  KEY `fk_activite_type_activites1_idx` (`id_type_act`),
  KEY `fk_activite_public_vise1_idx` (`id_public_vise`),
  KEY `fk_activite_notification1_idx` (`id_notification`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `act`
--

INSERT INTO `act` (`id`, `titre`, `presentation`, `date_fin_inscription`, `ville_act`, `departement_act`, `lieu_act`, `lieu_rdv`, `date_act`, `heure_act`, `heure_rdv`, `heure_fin`, `photo`, `plan`, `date_parution`, `id_organisation`, `id_type_act`, `id_public_vise`, `id_notification`) VALUES
(3, 'une petite sortie au cine', '', '0000-00-00', '', '', '', '', '2014-07-10', '', '', '', '', '', '0000-00-00', 1, 2, 1, 1),
(4, 'resto', '', '0000-00-00', '', '', '', '', '2014-07-10', '', '', '', '', '', '0000-00-00', 2, 4, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `commentaire_membre` text NOT NULL,
  `heure_commentaire` datetime NOT NULL,
  `id_act` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_commentaires_activites1_idx` (`id_act`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE IF NOT EXISTS `membre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(100) NOT NULL,
  `pseudo` varchar(250) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `prenom` varchar(250) NOT NULL,
  `nom` varchar(250) NOT NULL,
  `age` tinyint(4) NOT NULL,
  `autorisation` tinyint(4) NOT NULL,
  `activites` varchar(250) NOT NULL,
  `photo` blob,
  `mdp` varchar(255) NOT NULL,
  `fiches_lues` text NOT NULL,
  `sexe` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_envoi` varchar(45) NOT NULL,
  `envoye` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `notification`
--

INSERT INTO `notification` (`id`, `date_envoi`, `envoye`) VALUES
(1, 'sdfsq', '0');

-- --------------------------------------------------------

--
-- Structure de la table `organisation`
--

CREATE TABLE IF NOT EXISTS `organisation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_orga` varchar(250) NOT NULL,
  `mail_president` varchar(100) NOT NULL,
  `tel_president` varchar(45) NOT NULL,
  `mail_webmaster` varchar(100) NOT NULL,
  `adresse` varchar(250) NOT NULL,
  `presentation` text NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `login` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `organisation`
--

INSERT INTO `organisation` (`id`, `nom_orga`, `mail_president`, `tel_president`, `mail_webmaster`, `adresse`, `presentation`, `mdp`, `login`) VALUES
(1, 'fsju', '', '', '', '', '', 'az', 'az1'),
(2, 'bne brit\r\n', '', '', '', '', '', 'az', 'az2');

-- --------------------------------------------------------

--
-- Structure de la table `participant`
--

CREATE TABLE IF NOT EXISTS `participant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_act` int(11) NOT NULL,
  `id_membre` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_participants_activites1_idx` (`id_act`),
  KEY `fk_participants_membres1_idx` (`id_membre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `public_vise`
--

CREATE TABLE IF NOT EXISTS `public_vise` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `public` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `public_vise`
--

INSERT INTO `public_vise` (`id`, `public`) VALUES
(1, 'Enfants/Ados'),
(2, 'Adultes'),
(3, 'Seniors'),
(4, 'Famille');

-- --------------------------------------------------------

--
-- Structure de la table `type_act`
--

CREATE TABLE IF NOT EXISTS `type_act` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `type_act`
--

INSERT INTO `type_act` (`id`, `type`) VALUES
(1, 'resto'),
(2, 'culture'),
(3, 'conference'),
(4, 'sport'),
(5, 'tous');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `act`
--
ALTER TABLE `act`
  ADD CONSTRAINT `fk_activites_organisateur1` FOREIGN KEY (`id_organisation`) REFERENCES `organisation` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_activite_notification1` FOREIGN KEY (`id_notification`) REFERENCES `notification` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_activite_public_vise1` FOREIGN KEY (`id_public_vise`) REFERENCES `public_vise` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_activite_type_activites1` FOREIGN KEY (`id_type_act`) REFERENCES `type_act` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `fk_commentaires_activites1` FOREIGN KEY (`id_act`) REFERENCES `act` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `participant`
--
ALTER TABLE `participant`
  ADD CONSTRAINT `fk_participants_activites1` FOREIGN KEY (`id_act`) REFERENCES `act` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_participants_membres1` FOREIGN KEY (`id_membre`) REFERENCES `membre` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
