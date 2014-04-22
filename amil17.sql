-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Jeu 17 Avril 2014 à 10:49
-- Version du serveur: 5.6.12-log
-- Version de PHP: 5.4.16

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
  `id_act` int(11) NOT NULL AUTO_INCREMENT,
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
  `photo_act` varchar(255) NOT NULL,
  `plan` varchar(255) NOT NULL,
  `date_parution` date NOT NULL,
  `id_act_orga` int(11) NOT NULL,
  `id_act_typeact` int(11) NOT NULL,
  `id_act_publicvise` int(11) NOT NULL,
  `id_act_notification` int(11) NOT NULL,
  PRIMARY KEY (`id_act`),
  KEY `fk_activites_organisateur1_idx` (`id_act_orga`),
  KEY `fk_activite_type_activites1_idx` (`id_act_typeact`),
  KEY `fk_activite_public_vise1_idx` (`id_act_publicvise`),
  KEY `fk_activite_notification1_idx` (`id_act_notification`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `act`
--

INSERT INTO `act` (`id_act`, `titre`, `presentation`, `date_fin_inscription`, `ville_act`, `departement_act`, `lieu_act`, `lieu_rdv`, `date_act`, `heure_act`, `heure_rdv`, `heure_fin`, `photo_act`, `plan`, `date_parution`, `id_act_orga`, `id_act_typeact`, `id_act_publicvise`, `id_act_notification`) VALUES
(3, 'une petite sortie au cine', '', '0000-00-00', '', '', '', '', '2014-07-10', '', '', '', '', '', '0000-00-00', 1, 3, 3, 1),
(4, 'resto', '', '0000-00-00', '', '', '', '', '2014-08-14', '', '', '', '', '', '0000-00-00', 2, 2, 2, 1),
(8, 'un autres sortie au cinema', '', '0000-00-00', '', '', '', '', '2014-06-06', '', '', '', '', '', '0000-00-00', 1, 3, 2, 1),
(9, 'concours d''ortografe', '', '0000-00-00', '', '', '', '', '2014-08-22', '', '', '', '', '', '0000-00-00', 1, 3, 4, 1),
(10, 'tennis', 'un petit double', '0000-00-00', '', '', '', '', '2014-06-13', '', '', '', '', '', '0000-00-00', 2, 5, 5, 1),
(11, 'test conference', '', '0000-00-00', '', '', '', '', '2014-07-17', '', '', '', '', '', '0000-00-00', 1, 4, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE IF NOT EXISTS `commentaire` (
  `id_commentaire` int(11) NOT NULL AUTO_INCREMENT,
  `commentaire_membre` text NOT NULL,
  `heure_commentaire` datetime NOT NULL,
  `id_commentaire_act` int(11) NOT NULL,
  PRIMARY KEY (`id_commentaire`),
  KEY `fk_commentaires_activites1_idx` (`id_commentaire_act`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE IF NOT EXISTS `membre` (
  `id_membre` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(100) NOT NULL,
  `pseudo` varchar(250) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `prenom` varchar(250) NOT NULL,
  `nom` varchar(250) NOT NULL,
  `age` tinyint(4) NOT NULL,
  `autorisation` tinyint(4) NOT NULL,
  `activites` varchar(250) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `login` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `fiches_lues` text NOT NULL,
  `sexe` smallint(6) NOT NULL,
  PRIMARY KEY (`id_membre`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `mail`, `pseudo`, `ip`, `prenom`, `nom`, `age`, `autorisation`, `activites`, `photo`, `login`, `mdp`, `fiches_lues`, `sexe`) VALUES
(1, '', 'ps_franck1', '', '', 'franck1', 0, 0, '', NULL, 'AZER', 'AQ1', '', 0),
(2, '', 'ps_franck2', '', '', 'franck2', 0, 0, '', NULL, 'AZERT', 'AQ2', '', 0);

-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `id_notification` int(11) NOT NULL AUTO_INCREMENT,
  `date_envoi` varchar(45) NOT NULL,
  `envoye` enum('0','1') NOT NULL,
  PRIMARY KEY (`id_notification`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `notification`
--

INSERT INTO `notification` (`id_notification`, `date_envoi`, `envoye`) VALUES
(1, 'sdfsq', '0');

-- --------------------------------------------------------

--
-- Structure de la table `organisation`
--

CREATE TABLE IF NOT EXISTS `organisation` (
  `id_orga` int(11) NOT NULL AUTO_INCREMENT,
  `nom_orga` varchar(250) NOT NULL,
  `mail_president` varchar(100) NOT NULL,
  `tel_president` varchar(45) NOT NULL,
  `mail_webmaster` varchar(100) NOT NULL,
  `adresse` varchar(250) NOT NULL,
  `presentation` text NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `login` varchar(200) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `departement` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `nom_president` varchar(255) NOT NULL,
  PRIMARY KEY (`id_orga`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `organisation`
--

INSERT INTO `organisation` (`id_orga`, `nom_orga`, `mail_president`, `tel_president`, `mail_webmaster`, `adresse`, `presentation`, `mdp`, `login`, `ville`, `departement`, `logo`, `nom_president`) VALUES
(1, 'fsju', '', '', '', '', '', 'az', 'az1', '', '', '', ''),
(2, 'bne brit\r\n', '', '', '', '', '', 'az', 'az2', '', '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `participant`
--

CREATE TABLE IF NOT EXISTS `participant` (
  `id_participant` int(11) NOT NULL AUTO_INCREMENT,
  `id_participant_act` int(11) NOT NULL,
  `id_participant_membre` int(11) NOT NULL,
  PRIMARY KEY (`id_participant`),
  KEY `fk_participants_activites1_idx` (`id_participant_act`),
  KEY `fk_participants_membres1_idx` (`id_participant_membre`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `participant`
--

INSERT INTO `participant` (`id_participant`, `id_participant_act`, `id_participant_membre`) VALUES
(3, 3, 1),
(4, 4, 1),
(5, 8, 1),
(6, 9, 1),
(7, 10, 1);

-- --------------------------------------------------------

--
-- Structure de la table `public_vise`
--

CREATE TABLE IF NOT EXISTS `public_vise` (
  `id_publicvise` int(11) NOT NULL AUTO_INCREMENT,
  `public` varchar(100) NOT NULL,
  `public_affich` varchar(100) NOT NULL,
  PRIMARY KEY (`id_publicvise`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `public_vise`
--

INSERT INTO `public_vise` (`id_publicvise`, `public`, `public_affich`) VALUES
(2, 'enfants', 'Enfants / ados'),
(3, '40', '20-40'),
(4, '60', '40-60'),
(5, 'seniors', 'Seniors');

-- --------------------------------------------------------

--
-- Structure de la table `textes`
--

CREATE TABLE IF NOT EXISTS `textes` (
  `id_textes` int(11) NOT NULL AUTO_INCREMENT,
  `use` varchar(255) NOT NULL,
  `texte` text NOT NULL,
  `langue` enum('fr','en') NOT NULL,
  PRIMARY KEY (`id_textes`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `textes`
--

INSERT INTO `textes` (`id_textes`, `use`, `texte`, `langue`) VALUES
(1, 'presentation', 'Bienvnue sur am-il.fr\r\n\r\n\r\nVous voulez connaitre les organisations juives de la région PACA, ce site est fait pour vous.\r\n\r\nVous voulez être au courant de tout ce qu''elles organisent, là encore ce site est fait pour vous!\r\n\r\nVous voulez également rencontrer de nouvelles personnes dans la communauté, ces activités sont aussi faites pour çà. \r\n\r\nCe site ne fait pas que répertorier les organisations et les activités qu''elles proposent, il permet également de s''y inscrire.\r\n\r\nC''est donc un couteau suisse pour ces organisations qui périclitent car elles ne sont pas connues. \r\nC''est à vous, à nous tous de les faire vivre grâce à ce nouvel outil.\r\n\r\n\r\nA bientôt, j''espère, sur nos pages et dans les différentes manifestations qu''elles proposent.\r\n\r\n', 'fr'),
(2, 'presentation', 'Welcome on am-il.fr\r\n\r\n\r\nYou want to know the Jewish organizations of the region of Provence-Alpes-Côte d''Azur, this site is made for you.\r\n\r\nYou want to know about all that they organize, even there this site is made for you!\r\n\r\nYou also want to meet new people in the community, these activities are also made for that.\r\n\r\nThis site does not make that to list organizations and activities which they propose, he also allows to join it.\r\n\r\nIt is thus a Swiss army knife for these organizations which decay because they are not known.\r\nIt belongs to you, to all of us to make them live thanks to this new tool.\r\n\r\n\r\nSee you soon, I hope, on our pages and in the various events which are proposed on.\r\n\r\n', 'en');

-- --------------------------------------------------------

--
-- Structure de la table `type_act`
--

CREATE TABLE IF NOT EXISTS `type_act` (
  `id_typeact` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) NOT NULL,
  `type_affich` varchar(100) NOT NULL,
  PRIMARY KEY (`id_typeact`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `type_act`
--

INSERT INTO `type_act` (`id_typeact`, `type`, `type_affich`) VALUES
(2, 'resto', 'Restaurant'),
(3, 'culture', 'Culture'),
(4, 'conference', 'Conférences'),
(5, 'sport', 'Plein air / Sport');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `act`
--
ALTER TABLE `act`
  ADD CONSTRAINT `fk_activites_organisateur1` FOREIGN KEY (`id_act_orga`) REFERENCES `organisation` (`id_orga`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_activite_notification1` FOREIGN KEY (`id_act_notification`) REFERENCES `notification` (`id_notification`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_activite_public_vise1` FOREIGN KEY (`id_act_publicvise`) REFERENCES `public_vise` (`id_publicvise`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_activite_type_activites1` FOREIGN KEY (`id_act_typeact`) REFERENCES `type_act` (`id_typeact`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `fk_commentaires_activites1` FOREIGN KEY (`id_commentaire_act`) REFERENCES `act` (`id_act`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `participant`
--
ALTER TABLE `participant`
  ADD CONSTRAINT `fk_participants_activites1` FOREIGN KEY (`id_participant_act`) REFERENCES `act` (`id_act`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_participants_membres1` FOREIGN KEY (`id_participant_membre`) REFERENCES `membre` (`id_membre`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
