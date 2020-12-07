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
	('pédiatrique', '[5]', 25, 13);
/*!40000 ALTER TABLE `lyon` ENABLE KEYS */;

-- Listage de la structure de la table c.h.gestion. patients
CREATE TABLE IF NOT EXISTS `patients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  `date_naissance` text NOT NULL,
  `telephone` int(11) NOT NULL DEFAULT '0',
  `adresse` text NOT NULL,
  `dossier` json NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Listage des données de la table c.h.gestion.patients : ~0 rows (environ)
DELETE FROM `patients`;
/*!40000 ALTER TABLE `patients` DISABLE KEYS */;
/*!40000 ALTER TABLE `patients` ENABLE KEYS */;

-- Listage de la structure de la table c.h.gestion. romans
CREATE TABLE IF NOT EXISTS `romans` (
  `service` text,
  `personnel` text,
  `lits_total` int(11) DEFAULT NULL,
  `lits_occupes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Listage des données de la table c.h.gestion.romans : ~0 rows (environ)
DELETE FROM `romans`;
/*!40000 ALTER TABLE `romans` DISABLE KEYS */;
INSERT INTO `romans` (`service`, `personnel`, `lits_total`, `lits_occupes`) VALUES
	('pédiatrique', '[2]', 15, 6);
/*!40000 ALTER TABLE `romans` ENABLE KEYS */;

-- Listage de la structure de la table c.h.gestion. users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `location` text NOT NULL,
  `service` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Listage des données de la table c.h.gestion.users : ~4 rows (environ)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `location`, `service`) VALUES
	(1, 'quentin.buffard', '$argon2id$v=19$m=65536,t=4,p=1$OFdhLmpYNlhRNEZlbFllOA$s1Xqvqy1La/vPAqNVnVr1RBNn6nfjb6o+cXo95e2r94', 'romans', 'administration'),
	(2, 'personnel.service', '$argon2id$v=19$m=65536,t=4,p=1$OFdhLmpYNlhRNEZlbFllOA$s1Xqvqy1La/vPAqNVnVr1RBNn6nfjb6o+cXo95e2r94', 'romans', 'pediatrique'),
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
