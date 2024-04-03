-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 10 avr. 2023 à 00:48
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `exam`
--

-- --------------------------------------------------------

--
-- Structure de la table `tj_etudiantmatiere`
--

DROP TABLE IF EXISTS `tj_etudiantmatiere`;
CREATE TABLE IF NOT EXISTS `tj_etudiantmatiere` (
  `etudiant_id` int(11) NOT NULL,
  `mat_id` int(11) NOT NULL,
  PRIMARY KEY (`etudiant_id`,`mat_id`),
  KEY `fk_t_etudiant_etd_has_t_matiere_mat_t_matiere_mat1_idx` (`mat_id`),
  KEY `fk_t_etudiant_etd_has_t_matiere_mat_t_etudiant_etd1_idx` (`etudiant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tj_examsujets`
--

DROP TABLE IF EXISTS `tj_examsujets`;
CREATE TABLE IF NOT EXISTS `tj_examsujets` (
  `exam_id` int(11) NOT NULL,
  `suj_id` int(11) NOT NULL,
  PRIMARY KEY (`exam_id`,`suj_id`),
  KEY `fk_t_examen_exam_has_t_sujets_suj_t_sujets_suj1_idx` (`suj_id`),
  KEY `fk_t_examen_exam_has_t_sujets_suj_t_examen_exam1_idx` (`exam_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tj_matierecursus`
--

DROP TABLE IF EXISTS `tj_matierecursus`;
CREATE TABLE IF NOT EXISTS `tj_matierecursus` (
  `cur_id` int(11) NOT NULL,
  `mat_id` int(11) NOT NULL,
  PRIMARY KEY (`cur_id`,`mat_id`),
  KEY `fk_t_cursus_cur_has_t_matiere_mat_t_matiere_mat1_idx` (`mat_id`),
  KEY `fk_t_cursus_cur_has_t_matiere_mat_t_cursus_cur1_idx` (`cur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `t_administrateur_admin`
--

DROP TABLE IF EXISTS `t_administrateur_admin`;
CREATE TABLE IF NOT EXISTS `t_administrateur_admin` (
  `pfl_id` int(11) NOT NULL,
  PRIMARY KEY (`pfl_id`),
  KEY `fk_t_administrateur_admin_t_profile_pfl2_idx` (`pfl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `t_anneescolaire_ann`
--

DROP TABLE IF EXISTS `t_anneescolaire_ann`;
CREATE TABLE IF NOT EXISTS `t_anneescolaire_ann` (
  `ann_id` int(11) NOT NULL AUTO_INCREMENT,
  `ann_annee` varchar(255) NOT NULL,
  PRIMARY KEY (`ann_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_anneescolaire_ann`
--

INSERT INTO `t_anneescolaire_ann` (`ann_id`, `ann_annee`) VALUES
(1, '2020 - 2021'),
(2, '2021 - 2022'),
(3, '2022 - 2023');

-- --------------------------------------------------------

--
-- Structure de la table `t_class_cla`
--

DROP TABLE IF EXISTS `t_class_cla`;
CREATE TABLE IF NOT EXISTS `t_class_cla` (
  `cla_id` int(11) NOT NULL AUTO_INCREMENT,
  `cla_nom` varchar(45) NOT NULL,
  PRIMARY KEY (`cla_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_class_cla`
--

INSERT INTO `t_class_cla` (`cla_id`, `cla_nom`) VALUES
(1, 'groupe A'),
(2, 'groupe B'),
(3, 'groupe C'),
(4, 'groupe D');

-- --------------------------------------------------------

--
-- Structure de la table `t_compte_cpt`
--

DROP TABLE IF EXISTS `t_compte_cpt`;
CREATE TABLE IF NOT EXISTS `t_compte_cpt` (
  `cpt_pseudo` varchar(45) NOT NULL,
  `cpt_mdp` varchar(255) NOT NULL,
  `cpt_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`cpt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_compte_cpt`
--

INSERT INTO `t_compte_cpt` (`cpt_pseudo`, `cpt_mdp`, `cpt_id`) VALUES
('prof', 'prof', 11),
('eleve', 'eleve', 12),
('L', 'Eleve', 41),
('A', 'Admin', 42),
('B', 'Admin', 43),
('C', 'Prof', 44),
('D', 'Eleve', 45),
('E', 'Eleve', 46),
('F', 'Eleve', 47),
('G', 'Prof', 48),
('H', 'Admin', 49),
('I', 'Eleve', 50),
('J', 'Eleve', 51),
('K', 'Eleve', 52);

--
-- Déclencheurs `t_compte_cpt`
--
DROP TRIGGER IF EXISTS `beforeCompteDelete`;
DELIMITER $$
CREATE TRIGGER `beforeCompteDelete` BEFORE DELETE ON `t_compte_cpt` FOR EACH ROW BEGIN
DELETE FROM tj_etudiantMatiere WHERE tj_etudiantMatiere.etudiant_id in (SELECT pfl_id FROM t_profile_pfl WHERE cpt_id = old.cpt_id);
 DELETE from t_etudiant_etd WHERE t_etudiant_etd.pfl_id in (SELECT pfl_id FROM t_profile_pfl WHERE cpt_id = old.cpt_id);
    DELETE FROM t_administrateur_admin WHERE t_administrateur_admin.pfl_id in (SELECT pfl_id FROM t_profile_pfl WHERE cpt_id = old.cpt_id);
    DELETE FROM t_matiere_mat WHERE t_matiere_mat.pfl_id in (SELECT pfl_id FROM t_profile_pfl WHERE cpt_id = old.cpt_id);
    DELETE FROM tj_examsujets WHERE tj_examsujets.suj_id in (SELECT suj_id FROM t_sujets_suj where t_sujets_suj.pfl_id in(SELECT pfl_id FROM t_profile_pfl WHERE cpt_id = old.cpt_id));
    DELETE FROM t_question_ques WHERE t_question_ques.suj_id in (SELECT suj_id FROM t_sujets_suj where t_sujets_suj.pfl_id in(SELECT pfl_id FROM t_profile_pfl WHERE cpt_id = old.cpt_id));
    DELETE FROM t_sujets_suj WHERE t_sujets_suj.pfl_id in (SELECT pfl_id FROM t_profile_pfl WHERE cpt_id = old.cpt_id);
    DELETE FROM t_professeur_prof WHERE t_professeur_prof.pfl_id in (SELECT pfl_id FROM t_profile_pfl WHERE cpt_id = old.cpt_id);
    DELETE FROM t_profile_pfl WHERE t_profile_pfl.cpt_id= old.cpt_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `t_cursus_cur`
--

DROP TABLE IF EXISTS `t_cursus_cur`;
CREATE TABLE IF NOT EXISTS `t_cursus_cur` (
  `cur_id` int(11) NOT NULL AUTO_INCREMENT,
  `cur_nom` varchar(45) NOT NULL,
  PRIMARY KEY (`cur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_cursus_cur`
--

INSERT INTO `t_cursus_cur` (`cur_id`, `cur_nom`) VALUES
(2, 'Miage'),
(3, 'IM'),
(4, 'option');

-- --------------------------------------------------------

--
-- Structure de la table `t_etudiant_etd`
--

DROP TABLE IF EXISTS `t_etudiant_etd`;
CREATE TABLE IF NOT EXISTS `t_etudiant_etd` (
  `pfl_id` int(11) NOT NULL,
  `cur_id` int(11) NOT NULL,
  `ann_id` int(11) NOT NULL,
  `cla_id` int(11) NOT NULL,
  PRIMARY KEY (`pfl_id`,`cur_id`,`ann_id`,`cla_id`),
  KEY `fk_t_etudiant_etd_t_profile_pfl2_idx` (`pfl_id`),
  KEY `fk_t_etudiant_etd_t_cursus_cur2_idx` (`cur_id`),
  KEY `fk_t_etudiant_etd_t_class_cla1_idx` (`cla_id`),
  KEY `fk_t_etudiant_etd_t_anneeScolaire_ann1_idx` (`ann_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_etudiant_etd`
--

INSERT INTO `t_etudiant_etd` (`pfl_id`, `cur_id`, `ann_id`, `cla_id`) VALUES
(12, 2, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `t_examen_exam`
--

DROP TABLE IF EXISTS `t_examen_exam`;
CREATE TABLE IF NOT EXISTS `t_examen_exam` (
  `exam_id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_titre` varchar(45) NOT NULL,
  `mat_id` int(11) NOT NULL,
  PRIMARY KEY (`exam_id`,`mat_id`),
  KEY `fk_t_examen_exam_t_matiere_mat1_idx` (`mat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `t_matiere_mat`
--

DROP TABLE IF EXISTS `t_matiere_mat`;
CREATE TABLE IF NOT EXISTS `t_matiere_mat` (
  `mat_id` int(11) NOT NULL AUTO_INCREMENT,
  `mat_nom` varchar(45) NOT NULL,
  `pfl_id` int(11) NOT NULL,
  PRIMARY KEY (`mat_id`,`pfl_id`),
  KEY `fk_t_matiere_mat_t_professeur_prof2_idx` (`pfl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_matiere_mat`
--

INSERT INTO `t_matiere_mat` (`mat_id`, `mat_nom`, `pfl_id`) VALUES
(5, 'Francais5', 11),
(6, 'Anglais', 11);

-- --------------------------------------------------------

--
-- Structure de la table `t_professeur_prof`
--

DROP TABLE IF EXISTS `t_professeur_prof`;
CREATE TABLE IF NOT EXISTS `t_professeur_prof` (
  `pfl_id` int(11) NOT NULL,
  PRIMARY KEY (`pfl_id`),
  KEY `fk_t_professeur_prof_t_profile_pfl2_idx` (`pfl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_professeur_prof`
--

INSERT INTO `t_professeur_prof` (`pfl_id`) VALUES
(11);

-- --------------------------------------------------------

--
-- Structure de la table `t_profile_pfl`
--

DROP TABLE IF EXISTS `t_profile_pfl`;
CREATE TABLE IF NOT EXISTS `t_profile_pfl` (
  `pfl_id` int(11) NOT NULL AUTO_INCREMENT,
  `pfl_nom` varchar(45) NOT NULL,
  `pfl_prenom` varchar(45) NOT NULL,
  `pfl_dateNaissance` datetime NOT NULL,
  `pfl_mail` varchar(45) NOT NULL,
  `cpt_id` int(11) NOT NULL,
  PRIMARY KEY (`pfl_id`,`cpt_id`),
  KEY `fk_t_profile_pfl_t_compte_cpt1_idx` (`cpt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_profile_pfl`
--

INSERT INTO `t_profile_pfl` (`pfl_id`, `pfl_nom`, `pfl_prenom`, `pfl_dateNaissance`, `pfl_mail`, `cpt_id`) VALUES
(11, 'prof', 'prof', '1970-01-01 00:00:00', 'prof', 11),
(12, 'eleve', 'eleve', '1970-01-01 00:00:00', 'eleve', 12);

-- --------------------------------------------------------

--
-- Structure de la table `t_question_ques`
--

DROP TABLE IF EXISTS `t_question_ques`;
CREATE TABLE IF NOT EXISTS `t_question_ques` (
  `ques_id` int(11) NOT NULL AUTO_INCREMENT,
  `ques_text` varchar(500) NOT NULL,
  `ques_reponse` varchar(500) NOT NULL,
  `ques_point` double DEFAULT NULL,
  `suj_id` int(11) NOT NULL,
  PRIMARY KEY (`ques_id`,`suj_id`),
  KEY `fk_t_question_ques_t_sujets_suj1_idx` (`suj_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `t_sujets_suj`
--

DROP TABLE IF EXISTS `t_sujets_suj`;
CREATE TABLE IF NOT EXISTS `t_sujets_suj` (
  `suj_id` int(11) NOT NULL AUTO_INCREMENT,
  `suj_titre` varchar(45) NOT NULL,
  `pfl_id` int(11) NOT NULL,
  PRIMARY KEY (`suj_id`,`pfl_id`),
  KEY `fk_t_sujets_suj_t_professeur_prof1_idx` (`pfl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_sujets_suj`
--

INSERT INTO `t_sujets_suj` (`suj_id`, `suj_titre`, `pfl_id`) VALUES
(1, 'probabilité', 11),
(2, 'suite arithmetique', 11);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `tj_etudiantmatiere`
--
ALTER TABLE `tj_etudiantmatiere`
  ADD CONSTRAINT `fk_t_etudiant_etd_has_t_matiere_mat_t_etudiant_etd1` FOREIGN KEY (`etudiant_id`) REFERENCES `t_etudiant_etd` (`pfl_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_t_etudiant_etd_has_t_matiere_mat_t_matiere_mat1` FOREIGN KEY (`mat_id`) REFERENCES `t_matiere_mat` (`mat_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `tj_examsujets`
--
ALTER TABLE `tj_examsujets`
  ADD CONSTRAINT `fk_t_examen_exam_has_t_sujets_suj_t_examen_exam1` FOREIGN KEY (`exam_id`) REFERENCES `t_examen_exam` (`exam_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_t_examen_exam_has_t_sujets_suj_t_sujets_suj1` FOREIGN KEY (`suj_id`) REFERENCES `t_sujets_suj` (`suj_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `tj_matierecursus`
--
ALTER TABLE `tj_matierecursus`
  ADD CONSTRAINT `fk_t_cursus_cur_has_t_matiere_mat_t_cursus_cur1` FOREIGN KEY (`cur_id`) REFERENCES `t_cursus_cur` (`cur_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_t_cursus_cur_has_t_matiere_mat_t_matiere_mat1` FOREIGN KEY (`mat_id`) REFERENCES `t_matiere_mat` (`mat_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `t_administrateur_admin`
--
ALTER TABLE `t_administrateur_admin`
  ADD CONSTRAINT `fk_t_administrateur_admin_t_profile_pfl2` FOREIGN KEY (`pfl_id`) REFERENCES `t_profile_pfl` (`pfl_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `t_etudiant_etd`
--
ALTER TABLE `t_etudiant_etd`
  ADD CONSTRAINT `fk_t_etudiant_etd_t_anneeScolaire_ann1` FOREIGN KEY (`ann_id`) REFERENCES `t_anneescolaire_ann` (`ann_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_t_etudiant_etd_t_class_cla1` FOREIGN KEY (`cla_id`) REFERENCES `t_class_cla` (`cla_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_t_etudiant_etd_t_cursus_cur2` FOREIGN KEY (`cur_id`) REFERENCES `t_cursus_cur` (`cur_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_t_etudiant_etd_t_profile_pfl2` FOREIGN KEY (`pfl_id`) REFERENCES `t_profile_pfl` (`pfl_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `t_examen_exam`
--
ALTER TABLE `t_examen_exam`
  ADD CONSTRAINT `fk_t_examen_exam_t_matiere_mat1` FOREIGN KEY (`mat_id`) REFERENCES `t_matiere_mat` (`mat_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `t_matiere_mat`
--
ALTER TABLE `t_matiere_mat`
  ADD CONSTRAINT `fk_t_matiere_mat_t_professeur_prof2` FOREIGN KEY (`pfl_id`) REFERENCES `t_professeur_prof` (`pfl_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `t_professeur_prof`
--
ALTER TABLE `t_professeur_prof`
  ADD CONSTRAINT `fk_t_professeur_prof_t_profile_pfl2` FOREIGN KEY (`pfl_id`) REFERENCES `t_profile_pfl` (`pfl_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `t_profile_pfl`
--
ALTER TABLE `t_profile_pfl`
  ADD CONSTRAINT `fk_t_profile_pfl_t_compte_cpt1` FOREIGN KEY (`cpt_id`) REFERENCES `t_compte_cpt` (`cpt_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `t_question_ques`
--
ALTER TABLE `t_question_ques`
  ADD CONSTRAINT `fk_t_question_ques_t_sujets_suj1` FOREIGN KEY (`suj_id`) REFERENCES `t_sujets_suj` (`suj_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `t_sujets_suj`
--
ALTER TABLE `t_sujets_suj`
  ADD CONSTRAINT `fk_t_sujets_suj_t_professeur_prof1` FOREIGN KEY (`pfl_id`) REFERENCES `t_professeur_prof` (`pfl_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
