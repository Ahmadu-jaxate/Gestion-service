-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 19 juil. 2025 à 15:27
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestionservice`
--

-- --------------------------------------------------------

--
-- Structure de la table `personnel`
--

CREATE TABLE `personnel` (
  `numero` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `adresse` varchar(200) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `num_mobile` varchar(20) DEFAULT NULL,
  `date_recrutement` date NOT NULL,
  `numero_service` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `personnel`
--

INSERT INTO `personnel` (`numero`, `nom`, `prenom`, `adresse`, `email`, `num_mobile`, `date_recrutement`, `numero_service`) VALUES
(30, 'diallo', 'boubacar', '123 Rue des Services', 'mourtada.diop@example.com', '771234567', '2025-06-30', 2),
(41, 'mbacké', 'saliou', NULL, 'salioumbacke@gmail.com', '7737473737', '2025-07-19', 2),
(42, 'ba', 'amadou woury', NULL, 'amadouwoury.ba@gmail.com', '78957823', '2025-07-19', 1),
(43, 'diop', 'diery', NULL, 'salioiu.niane@gmail.com', '7737473737', '2025-07-19', 1),
(45, 'diop', 'amadou woury', 'FIMELA', 'lzmothm@gmail.com', '78957823', '2025-07-19', 1),
(46, 'diop', 'mourtada', 'FIMELA', 'ahmadoudiakhatekala@gmail.com', '78957823', '2025-07-19', 1),
(47, 'ben', 'elamin', 'FIMELA', 'mourtada.diop@gmail.com', '78957823', '2025-07-19', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

CREATE TABLE `service` (
  `numero_service` int(11) NOT NULL,
  `nom_service` varchar(100) NOT NULL,
  `nombre_employe` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `service`
--

INSERT INTO `service` (`numero_service`, `nom_service`, `nombre_employe`) VALUES
(1, 'service informatique', 4),
(2, 'service RH', 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `personnel`
--
ALTER TABLE `personnel`
  ADD PRIMARY KEY (`numero`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`numero_service`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `personnel`
--
ALTER TABLE `personnel`
  MODIFY `numero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `service`
--
ALTER TABLE `service`
  MODIFY `numero_service` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
