-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 02 nov. 2025 à 13:56
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
-- Base de données : `telegram_bot`
--

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `numero_passeport` varchar(20) NOT NULL,
  `type_centre` enum('VFS','TLS') NOT NULL,
  `pays` varchar(100) NOT NULL,
  `date_expiration_passeport` date NOT NULL,
  `date_delivrance_passeport` date NOT NULL,
  `lieu_naissance` varchar(100) NOT NULL,
  `date_rendez_vous` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `nom`, `prenom`, `numero_passeport`, `type_centre`, `pays`, `date_expiration_passeport`, `date_delivrance_passeport`, `lieu_naissance`, `date_rendez_vous`, `created_at`) VALUES
(1, 'yacine kheirddine ', 'kheirddine ', '546464684', 'VFS', 'Austria', '2025-11-28', '2025-11-03', 'oran', '2025-11-05', '2025-11-01 23:57:25'),
(2, 'yacine kheirddine ', 'kheirddine ', '646464864', 'VFS', 'Austria', '2025-12-31', '2025-10-26', '15s', '2025-11-06', '2025-11-02 00:01:26'),
(3, 'yacine kheirddine ', 'kheirddine ', '534654646', 'VFS', 'Austria', '2025-01-01', '2025-11-04', 'oran', '2025-11-06', '2025-11-02 00:02:08'),
(4, 'yacine kheirddine ', 'kheirddine ', '545454545', 'VFS', 'Austria', '2025-12-03', '2025-11-13', 'oran', '2025-11-09', '2025-11-02 12:17:13'),
(5, 'yacine kheirddine ', 'kheirddine ', '454545454', 'VFS', 'Austria', '2024-10-31', '2025-12-31', 'oran', '2025-11-10', '2025-11-02 12:17:56'),
(6, 'Boudaa walid', 'kheirddine ', '646846846', 'VFS', 'Austria', '2025-11-22', '2025-11-02', 'oran', '2025-11-02', '2025-11-02 12:50:31');

-- --------------------------------------------------------

--
-- Structure de la table `disponibilites_pays`
--

CREATE TABLE `disponibilites_pays` (
  `id` int(11) NOT NULL,
  `type_centre` enum('VFS','TLS') NOT NULL,
  `pays` varchar(100) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `type` enum('VFS','TLS') NOT NULL DEFAULT 'VFS',
  `mission` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `available_slot` date NOT NULL,
  `message_date` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `type`, `mission`, `location`, `available_slot`, `message_date`, `created_at`) VALUES
(1, 'VFS', 'France', 'Paris', '0000-00-00', '2025-01-27 00:00:00', '2025-11-18 23:58:38'),
(2, 'VFS', 'Austria', 'Algiers', '2025-11-02', '2025-11-01 08:00:32', '2025-11-01 23:18:58');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_passeport` (`numero_passeport`);

--
-- Index pour la table `disponibilites_pays`
--
ALTER TABLE `disponibilites_pays`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_message` (`type`,`mission`,`location`,`available_slot`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `disponibilites_pays`
--
ALTER TABLE `disponibilites_pays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
