-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Mer 05 Mai 2021 à 14:33
-- Version du serveur :  10.1.41-MariaDB-0+deb9u1
-- Version de PHP :  7.0.33-0+deb9u6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `medecin`
--

DELIMITER $$
--
-- Fonctions
--
CREATE DEFINER=`phpmyadmin`@`localhost` FUNCTION `getIdPatient` (`login` VARCHAR(500), `mdp` VARCHAR(500)) RETURNS INT(11) BEGIN  

RETURN (Select idPatient from patient where loginPatient = login AND mdpPatient = mdp);
END$$

CREATE DEFINER=`phpmyadmin`@`localhost` FUNCTION `getIdWithToken` (`tokens` VARCHAR(500), `ip` VARCHAR(500)) RETURNS INT(11) BEGIN
DECLARE id INT;
SET id = (SELECT idPatient FROM authentification WHERE authentification.token = tokens AND ipAppareil = ip);
RETURN id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `authentification`
--

CREATE TABLE `authentification` (
  `token` varchar(500) NOT NULL,
  `idPatient` int(11) NOT NULL,
  `ipAppareil` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `authentification`
--

INSERT INTO `authentification` (`token`, `idPatient`, `ipAppareil`) VALUES
('sloUp6wNiwZLGIPP7YjZPDNnu124V1Sk', 68, '172.18.204.14'),
('3f8Utcqa5hBy7XsN1PXVeEHzrmXDJUZN', 69, '172.18.204.13'),
('KfwCrHFPKlmzV7hY7wDLWbUYn4iNNJlK', 70, '172.18.204.13'),
('ntuBhtLB2iDqHutDEUt97WJQvgObD28R', 70, '172.18.204.13'),
('nz4Ht7nF9BA4pBaqqcsDvvGGY5NHWm4y', 68, '172.18.204.14'),
('kwSpzAIGF2JOR7lUIDGZEW5ig6EQxLwL', 68, '172.18.204.14'),
('mSsbGuVm6olW3LEyIyBleT6GHa9eYZa8', 68, '172.18.204.14'),
('NudTLjY7N2Bxv45nI7x7AdkuRMuKzYkk', 68, '172.18.204.14'),
('kcu836fjzVbULQ0BgCmUrSszS5cjFWNd', 66, '172.18.204.14'),
('8ZaKymYU4bIYXZGMkJiQdKvq2kTxqmFK', 68, '172.18.204.14'),
('pT8vcvxIvIk2r5pcjZbttuhpUREplzYJ', 68, '172.18.204.14'),
('VyPkzTaosqgd93CXpbpK76lczFrbP8FN', 68, '172.18.204.14'),
('MMs0xRVmrTEpvTs74DY5sCp2IyC4dr2v', 66, '172.18.204.14'),
('FpOGxqS1R9UijP3272VdvoOAHjIWy1yu', 66, '172.18.204.14'),
('CKCvRhyKUk7qUkIrX7qE6ZnTlQrDhsHC', 66, '172.18.204.14'),
('EcofyvirQOeVvDr3B8i7vlTuYugleADK', 66, '172.18.204.14'),
('jG8LyfydNNWGvVJ5aS9hvHKuQjLfkSks', 69, '172.18.204.14'),
('8J1t9wuWFEYYhZ8YMu9jBdiWJ5ATQeIV', 66, '172.18.204.14'),
('xnsCn7Qxj76ITTCzenViQDWZhQgFbpvQ', 66, '172.18.204.14'),
('FzU95gu8qRXnN8lyb9nZ83ASnOyp6Bz9', 71, '172.18.204.14'),
('7iUocd3miNxtwWKnrZiTgUS9CU1TJltw', 72, '172.18.204.11'),
('d8Jb7IMLiisntGZOuIFqCjSGqcpktWPW', 72, '172.18.204.11'),
('B8ugIhX7SVd0mByfAEG0xA7r2R4xZEpN', 72, '172.18.204.11'),
('dx2BTc5tYSTPAp3XVmGVNlCXYE9ES6pS', 72, '172.18.204.11'),
('sAKLbaz8CJoEZ81nLUAlWcEQCVfHkovQ', 72, '172.18.204.11');

-- --------------------------------------------------------

--
-- Structure de la table `patient`
--

CREATE TABLE `patient` (
  `idPatient` int(11) NOT NULL,
  `nomPatient` varchar(500) NOT NULL,
  `prenomPatient` varchar(500) NOT NULL,
  `ruePatient` varchar(500) NOT NULL,
  `cpPatient` varchar(6) DEFAULT NULL,
  `villePatient` varchar(500) NOT NULL,
  `telPatient` varchar(12) NOT NULL,
  `loginPatient` varchar(100) NOT NULL,
  `mdpPatient` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `patient`
--

INSERT INTO `patient` (`idPatient`, `nomPatient`, `prenomPatient`, `ruePatient`, `cpPatient`, `villePatient`, `telPatient`, `loginPatient`, `mdpPatient`) VALUES
(66, 'azer', 'azer', '48 arrazr ', '25855', 'qdea', '0544646546', 'log4', '$2y$10$wOK5Pne.iQOHsC.jEe5XkuVcvaP5Wx2mTK9aFjYwkyPb7Re6XJwa.'),
(68, 'Voila', 'Voila', '8 rue voila', '98989', 'ouuuuiiii', '0102030405', 'log6', '$2y$10$9ljvRfgDu5R2.nXDaFCT2OOPu71WVHfTDmQFGBAn39okBJTKobMYe'),
(69, 'JACKSON', 'FBI', '555', '555', '555', '555', 'PRO', '$2y$10$DMLK7VnXVcUQKGi8AroIgejDmnaXwnzw0qxwpZV8rOVKnmvMIFPw.'),
(70, 'Galaud', 'Cyril', '25 Avenue de Domremy', '55140', 'Vaucouleurs', '0633917004', 'CGalaud', '$2y$10$kemS4Ki6GulJ.JYoKjRG9u8TShOCniJMY71G2L8H4CeXxj7TCCezm'),
(71, 'E4', 'E4', '1 place Paul LeMagny', '55012', 'Bar-le-Duc', '0355000012', 'E4', '$2y$10$SmUCLdkCho/zBaTlG2fUOubPk61DQ0CM4soEZk66/kO3N27PUBTu6'),
(72, 'Gobeaux', 'Louis', '4 rue de la petite Chardogne', '55000', 'Chardogne', '0698653274', 'lou1', '$2y$10$LyWD/C.JWVEfWoBeOWGpv.BI4ynLAAA9muBNcnsdEkf..vOjqPXcy');

-- --------------------------------------------------------

--
-- Structure de la table `rdv`
--

CREATE TABLE `rdv` (
  `idRdv` int(11) NOT NULL,
  `dateHeureRdv` datetime NOT NULL,
  `idMedecin` varchar(500) NOT NULL,
  `idPatient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `rdv`
--

INSERT INTO `rdv` (`idRdv`, `dateHeureRdv`, `idMedecin`, `idPatient`) VALUES
(75, '2021-04-01 13:30:00', '96ac9f3dd86058c7ad2f75d0168d5d8d107407dd', 70),
(78, '2021-03-04 19:02:00', '995edf24872c38b1241a81acabfaef172ddf8e7c', 68),
(79, '2021-03-19 19:05:00', '96ac9f3dd86058c7ad2f75d0168d5d8d107407dd', 68),
(83, '2021-04-10 12:00:00', 'bbe793e7dd6e7e41b9321438471c697b9c3d72cd', 69),
(84, '2021-04-08 18:05:00', 'd0084bea9049e11e0cb060dcef340c97d8f3e113', 66),
(85, '2021-06-05 14:00:00', '16e3cbd02663ea1d89c06efeca5bbdb1d683f490', 71),
(86, '2021-07-20 16:00:00', '14689463cbdd909ad54994594017ed8a5092aeb6', 71);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`idPatient`),
  ADD UNIQUE KEY `loginPatient` (`loginPatient`);

--
-- Index pour la table `rdv`
--
ALTER TABLE `rdv`
  ADD PRIMARY KEY (`idRdv`),
  ADD KEY `idPatient` (`idPatient`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `patient`
--
ALTER TABLE `patient`
  MODIFY `idPatient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT pour la table `rdv`
--
ALTER TABLE `rdv`
  MODIFY `idRdv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `rdv`
--
ALTER TABLE `rdv`
  ADD CONSTRAINT `rdv_ibfk_1` FOREIGN KEY (`idPatient`) REFERENCES `patient` (`idPatient`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
