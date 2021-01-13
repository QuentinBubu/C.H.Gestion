-- --------------------------------------------------------
-- Hôte :                        localhost
-- Version du serveur:           5.7.24 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Listage de la structure de la base pour c.h.gestion
CREATE DATABASE IF NOT EXISTS `c.h.gestion` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `c.h.gestion`;

-- Listage de la structure de la table c.h.gestion. lyon
CREATE TABLE IF NOT EXISTS `lyon` (
  `service` text,
  `personnel` text,
  `lits_total` int(11) DEFAULT NULL,
  `lits_occupes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Listage des données de la table c.h.gestion.lyon : ~2 rows (environ)
DELETE FROM `lyon`;
/*!40000 ALTER TABLE `lyon` DISABLE KEYS */;
INSERT INTO `lyon` (`service`, `personnel`, `lits_total`, `lits_occupes`) VALUES
	('neurologie', '[4]', 30, 10),
	('pédiatrique', '[5]', 25, 25);
/*!40000 ALTER TABLE `lyon` ENABLE KEYS */;

-- Listage de la structure de la table c.h.gestion. paris
CREATE TABLE IF NOT EXISTS `paris` (
  `service` text,
  `personnel` text,
  `lits_total` int(11) DEFAULT NULL,
  `lits_occupes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Listage des données de la table c.h.gestion.paris : ~0 rows (environ)
DELETE FROM `paris`;
/*!40000 ALTER TABLE `paris` DISABLE KEYS */;
INSERT INTO `paris` (`service`, `personnel`, `lits_total`, `lits_occupes`) VALUES
	('pédiatrique', '[2]', 15, 6);
/*!40000 ALTER TABLE `paris` ENABLE KEYS */;

-- Listage de la structure de la table c.h.gestion. patients
CREATE TABLE IF NOT EXISTS `patients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `firstName` text NOT NULL,
  `informations` json NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Listage des données de la table c.h.gestion.patients : ~0 rows (environ)
DELETE FROM `patients`;
/*!40000 ALTER TABLE `patients` DISABLE KEYS */;
INSERT INTO `patients` (`id`, `name`, `firstName`, `informations`) VALUES
	(1, 'Dupont', 'Jean', '{"visites": [{"jour": "15-02-2020", "cause": "forte toux", "vu par": "2", "traitement": "Sirop"}], "incidents": {"Autre": [], "Degradation": [{"2021-01-13 10:01:54": "Dégradation des murs"}, {"2021-01-13 10:07:29": "Enleve les rideaux"}], "Violences verbales": [], "Violences physiques": []}, "informations": {"nom": "Dupont", "âge": "40", "adresse": "25 rue du chandelier, 75000, Paris", "prénom": "Jean", "numéro fixe": "0123456789", "numéro portable": "0123456789", "personne de confiance": "Dupont Jeannette"}, "hospitalisation": [{"au": "19-06-2018", "du": "17-06-2018", "raison": "Pose d\'implants", "service": "neurologie", "17-06-2018": {"13h54": {"douleur": "4", "tension": "16", "température": "39", "taux d\'oxygène": "94"}, "20h54": {"douleur": "3", "tension": "15", "température": "37", "taux d\'oxygène": "98"}}, "18-06-2018": {"12h02": {"douleur": "3", "tension": "14", "température": "36.5", "taux d\'oxygène": "99"}, "20h54": {"douleur": "2", "tension": "13", "température": "36.4", "taux d\'oxygène": "99"}}, "traitement": "Anti douleurs"}]}');
/*!40000 ALTER TABLE `patients` ENABLE KEYS */;

-- Listage de la structure de la table c.h.gestion. users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `location` text NOT NULL,
  `service` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Listage des données de la table c.h.gestion.users : ~5 rows (environ)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `location`, `service`) VALUES
	(1, 'quentin.bubu', '$argon2id$v=19$m=65536,t=4,p=1$OFdhLmpYNlhRNEZlbFllOA$s1Xqvqy1La/vPAqNVnVr1RBNn6nfjb6o+cXo95e2r94', 'paris', 'administration'),
	(2, 'personnel.service', '$argon2id$v=19$m=65536,t=4,p=1$OFdhLmpYNlhRNEZlbFllOA$s1Xqvqy1La/vPAqNVnVr1RBNn6nfjb6o+cXo95e2r94', 'paris', 'pediatrique'),
	(3, 'personnel2.service', '$argon2id$v=19$m=65536,t=4,p=1$OFdhLmpYNlhRNEZlbFllOA$s1Xqvqy1La/vPAqNVnVr1RBNn6nfjb6o+cXo95e2r94', 'valence', 'urgence'),
	(4, 'personnel3.service', '$argon2id$v=19$m=65536,t=4,p=1$OFdhLmpYNlhRNEZlbFllOA$s1Xqvqy1La/vPAqNVnVr1RBNn6nfjb6o+cXo95e2r94', 'lyon', 'neurologie'),
	(5, 'personnel4.service', '$argon2id$v=19$m=65536,t=4,p=1$OFdhLmpYNlhRNEZlbFllOA$s1Xqvqy1La/vPAqNVnVr1RBNn6nfjb6o+cXo95e2r94', 'lyon', 'pediatrique');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Listage de la structure de la table c.h.gestion. valence
CREATE TABLE IF NOT EXISTS `valence` (
  `service` text,
  `personnel` text,
  `lits_total` int(11) DEFAULT NULL,
  `lits_occupes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Listage des données de la table c.h.gestion.valence : ~0 rows (environ)
DELETE FROM `valence`;
/*!40000 ALTER TABLE `valence` DISABLE KEYS */;
INSERT INTO `valence` (`service`, `personnel`, `lits_total`, `lits_occupes`) VALUES
	('urgence', '[3]', 20, 17);
/*!40000 ALTER TABLE `valence` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
