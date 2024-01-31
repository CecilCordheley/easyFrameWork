-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 31 jan. 2024 à 14:53
-- Version du serveur : 5.7.36
-- Version de PHP : 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `eval`
--

DELIMITER $$
--
-- Procédures
--
DROP PROCEDURE IF EXISTS `getEvalByMatiere`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getEvalByMatiere` (IN `IdMatiere` INT)  BEGIN
	SELECT * FROM eval_tbl WHERE eval_tbl.ID_MATIERE_MATIERE_TBL=IdMatiere;
END$$

--
-- Fonctions
--
DROP FUNCTION IF EXISTS `has_participant`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `has_participant` (`eval` INT) RETURNS INT(11) BEGIN
DECLARE p INTEGER;
SELECT COUNT(*) into p from participer WHERE participer.ID_EVAL_EVAL_TBL=eval;
return p>0;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `academie_tbl`
--

DROP TABLE IF EXISTS `academie_tbl`;
CREATE TABLE IF NOT EXISTS `academie_tbl` (
  `ID_ACADEMIE` int(11) NOT NULL AUTO_INCREMENT,
  `NOM_ACADEMIE` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID_ACADEMIE`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `academie_tbl`
--

INSERT INTO `academie_tbl` (`ID_ACADEMIE`, `NOM_ACADEMIE`) VALUES
(1, 'LILLE'),
(2, 'ARRAS');

-- --------------------------------------------------------

--
-- Structure de la table `ecole_tbl`
--

DROP TABLE IF EXISTS `ecole_tbl`;
CREATE TABLE IF NOT EXISTS `ecole_tbl` (
  `ID_ECOLE` int(11) NOT NULL AUTO_INCREMENT,
  `NOM_ECOLE` varchar(20) DEFAULT NULL,
  `CP_ECOLE` char(5) DEFAULT NULL,
  `VILLE_ECOLE` varchar(20) DEFAULT NULL,
  `ID_ACADEMIE` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_ECOLE`),
  KEY `FK_ECOLE_TBL_ID_ACADEMIE_ACADEMIE_TBL` (`ID_ACADEMIE`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ecole_tbl`
--

INSERT INTO `ecole_tbl` (`ID_ECOLE`, `NOM_ECOLE`, `CP_ECOLE`, `VILLE_ECOLE`, `ID_ACADEMIE`) VALUES
(1, 'SAINT MARTIN', '59200', 'TOURCOING', 1),
(2, 'LYCEE MARIE CURIE', '62000', 'ARRAS', 2);

-- --------------------------------------------------------

--
-- Structure de la table `eleve_tbl`
--

DROP TABLE IF EXISTS `eleve_tbl`;
CREATE TABLE IF NOT EXISTS `eleve_tbl` (
  `ID_ELEVE` int(11) NOT NULL AUTO_INCREMENT,
  `NOM_ELEVE` varchar(20) DEFAULT NULL,
  `PRENOM_ELEVE` varchar(45) DEFAULT NULL,
  `DATE_NAISSANCE` date DEFAULT NULL,
  `ID_ECOLE` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_ELEVE`),
  KEY `FK_ELEVE_TBL_ID_ECOLE_ECOLE_TBL` (`ID_ECOLE`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `eleve_tbl`
--

INSERT INTO `eleve_tbl` (`ID_ELEVE`, `NOM_ELEVE`, `PRENOM_ELEVE`, `DATE_NAISSANCE`, `ID_ECOLE`) VALUES
(1, 'ETIENNE', 'LUCAS', '2005-07-29', 2),
(2, 'SHITHERIE', 'MARIE', '2012-07-17', 2),
(3, 'ARMAND', 'PAUL', '2007-09-19', 2),
(4, 'MCCURLY', 'SAOIRSE', '2022-11-01', 1),
(5, 'ISPKYLE', 'YOUSEFF', '2007-11-07', 1);

-- --------------------------------------------------------

--
-- Structure de la table `eval_tbl`
--

DROP TABLE IF EXISTS `eval_tbl`;
CREATE TABLE IF NOT EXISTS `eval_tbl` (
  `ID_EVAL_EVAL_TBL` int(11) NOT NULL AUTO_INCREMENT,
  `DATE_EVAL_EVAL_TBL` date DEFAULT NULL,
  `ID_MATIERE_MATIERE_TBL` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_EVAL_EVAL_TBL`),
  KEY `FK_EVAL_TBL_ID_MATIERE_MATIERE_TBL` (`ID_MATIERE_MATIERE_TBL`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `eval_tbl`
--

INSERT INTO `eval_tbl` (`ID_EVAL_EVAL_TBL`, `DATE_EVAL_EVAL_TBL`, `ID_MATIERE_MATIERE_TBL`) VALUES
(1, '2022-11-09', 4),
(2, '2022-11-16', 5),
(3, '2022-11-08', 1),
(4, '2022-11-14', 3),
(5, '2022-11-16', 2),
(6, '2023-11-01', 1),
(7, '2023-11-15', 5);

-- --------------------------------------------------------

--
-- Structure de la table `matiere_tbl`
--

DROP TABLE IF EXISTS `matiere_tbl`;
CREATE TABLE IF NOT EXISTS `matiere_tbl` (
  `ID_MATIERE_MATIERE_TBL` int(11) NOT NULL AUTO_INCREMENT,
  `NOM_MATIERE_MATIERE_TBL` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID_MATIERE_MATIERE_TBL`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `matiere_tbl`
--

INSERT INTO `matiere_tbl` (`ID_MATIERE_MATIERE_TBL`, `NOM_MATIERE_MATIERE_TBL`) VALUES
(1, 'FRANCAIS'),
(2, 'MATHEMATIQUES'),
(3, 'HISTOIRES'),
(4, 'ALGORITHMIQUE'),
(5, 'ARLE');

-- --------------------------------------------------------

--
-- Structure de la table `participer`
--

DROP TABLE IF EXISTS `participer`;
CREATE TABLE IF NOT EXISTS `participer` (
  `ID_ELEVE` int(11) NOT NULL AUTO_INCREMENT,
  `ID_EVAL` int(11) NOT NULL,
  `NOTE_PARTICIPER` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_ELEVE`,`ID_EVAL`),
  KEY `FK_participer_ID_EVAL_EVAL_TBL` (`ID_EVAL`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `participer`
--

INSERT INTO `participer` (`ID_ELEVE`, `ID_EVAL`, `NOTE_PARTICIPER`) VALUES
(1, 1, 6),
(1, 2, 12),
(1, 3, 6),
(1, 4, 16),
(2, 1, 15),
(2, 2, 9),
(2, 3, 9),
(2, 4, 10),
(3, 1, 12),
(3, 2, 5),
(3, 3, 13),
(3, 4, 15),
(4, 1, 13),
(4, 2, 13),
(4, 3, 15),
(4, 4, 12),
(5, 1, 15),
(5, 2, 6),
(5, 3, 3),
(5, 4, 12);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vue_1`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `vue_1`;
CREATE TABLE IF NOT EXISTS `vue_1` (
`ID_EVAL_EVAL_TBL` int(11)
,`DATE_EVAL_EVAL_TBL` date
,`ID_MATIERE_MATIERE_TBL` int(11)
);

-- --------------------------------------------------------

--
-- Structure de la vue `vue_1`
--
DROP TABLE IF EXISTS `vue_1`;

DROP VIEW IF EXISTS `vue_1`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_1`  AS SELECT `eval_tbl`.`ID_EVAL_EVAL_TBL` AS `ID_EVAL_EVAL_TBL`, `eval_tbl`.`DATE_EVAL_EVAL_TBL` AS `DATE_EVAL_EVAL_TBL`, `eval_tbl`.`ID_MATIERE_MATIERE_TBL` AS `ID_MATIERE_MATIERE_TBL` FROM `eval_tbl` WHERE (`eval_tbl`.`ID_MATIERE_MATIERE_TBL` = 1) ;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `ecole_tbl`
--
ALTER TABLE `ecole_tbl`
  ADD CONSTRAINT `FK_ECOLE_TBL_ID_ACADEMIE_ACADEMIE_TBL` FOREIGN KEY (`ID_ACADEMIE`) REFERENCES `academie_tbl` (`ID_ACADEMIE`);

--
-- Contraintes pour la table `eleve_tbl`
--
ALTER TABLE `eleve_tbl`
  ADD CONSTRAINT `FK_ELEVE_TBL_ID_ECOLE_ECOLE_TBL` FOREIGN KEY (`ID_ECOLE`) REFERENCES `ecole_tbl` (`ID_ECOLE`);

--
-- Contraintes pour la table `eval_tbl`
--
ALTER TABLE `eval_tbl`
  ADD CONSTRAINT `FK_EVAL_TBL_ID_MATIERE_MATIERE_TBL` FOREIGN KEY (`ID_MATIERE_MATIERE_TBL`) REFERENCES `matiere_tbl` (`ID_MATIERE_MATIERE_TBL`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
