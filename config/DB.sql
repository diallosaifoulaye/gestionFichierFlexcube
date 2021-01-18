-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  mar. 06 nov. 2018 à 09:47
-- Version du serveur :  5.6.38
-- Version de PHP :  7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `sunuframework`
--

-- --------------------------------------------------------

--
-- Structure de la table `affectation_droit`
--

CREATE TABLE `meczy_affectation_droit` (
  `id` int(11) NOT NULL,
  `fk_profil` int(11) NOT NULL,
  `fk_droit` int(11) NOT NULL,
  `etat` tinyint(4) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `affectation_droit_user`
--

CREATE TABLE `meczy_affectation_droit_user` (
  `id` int(11) NOT NULL,
  `fk_affectation_droit` int(11) NOT NULL,
  `fk_user` int(11) NOT NULL,
  `etat` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `droit`
--

CREATE TABLE `meczy_droit` (
  `id` int(11) NOT NULL,
  `droit` varchar(254) DEFAULT NULL,
  `fk_sous_module` int(11) NOT NULL,
  `controller` varchar(50) NOT NULL,
  `action` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `logs`
--

CREATE TABLE `meczy_logs` (
  `id` int(11) NOT NULL,
  `action` enum('insert','update','delete','') NOT NULL,
  `currenttable` varchar(50) NOT NULL,
  `currentid` int(11) NOT NULL,
  `description` text NOT NULL,
  `datecreation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `result` enum('Reussie','Echoue') NOT NULL,
  `fk_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `module`
--

CREATE TABLE `meczy_module` (
  `id` int(11) NOT NULL,
  `module` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

CREATE TABLE `meczy_profil` (
  `id` int(11) NOT NULL,
  `etat` enum('Activer','Désactiver') DEFAULT 'Activer',
  `profil` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `sous_module`
--

CREATE TABLE `meczy_sous_module` (
  `id` int(11) NOT NULL,
  `sous_module` varchar(100) NOT NULL,
  `fk_module` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `meczy_user` (
  `id` int(11) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `nom` varchar(75) NOT NULL,
  `email` varchar(150) NOT NULL,
  `login` varchar(25) NOT NULL,
  `password` varchar(256) NOT NULL,
  `fk_profil` int(11) DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `connect` tinyint(1) NOT NULL DEFAULT '0',
  `etat` enum('Activer','Désactiver') NOT NULL DEFAULT 'Activer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `meczy_user` (`id`, `prenom`, `nom`, `email`, `login`, `password`, `fk_profil`, `admin`, `connect`, `etat`) VALUES
(1, 'admin', 'admin', 'admin@numherit.com', 'admin', '$2y$09$9QeNB/EanrJ4J6Gc1lBzvu5UyLW4hoRG0Zn6PqSU/6ROVRoMa6zEu', 1, 1, 0, 'Activer');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `affectation_droit`
--
ALTER TABLE `meczy_affectation_droit`
  ADD PRIMARY KEY (`fk_profil`,`fk_droit`),
  ADD KEY `affectation_droit_fk_profil_profil_id` (`fk_profil`),
  ADD KEY `affectation_droit_fk_droit_droit_id` (`fk_droit`),
  ADD KEY `id` (`id`);

--
-- Index pour la table `affectation_droit_user`
--
ALTER TABLE `meczy_affectation_droit_user`
  ADD PRIMARY KEY (`fk_affectation_droit`,`fk_user`),
  ADD KEY `affectation_droit_user_fk_affectation_droit_affectation_droit_id` (`fk_affectation_droit`),
  ADD KEY `affectation_droit_user_fk_user_user_id` (`fk_user`),
  ADD KEY `id` (`id`);

--
-- Index pour la table `droit`
--
ALTER TABLE `meczy_droit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `droit_fk_sous_module_sous_module_id_fk` (`fk_sous_module`);

--
-- Index pour la table `logs`
--
ALTER TABLE `meczy_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `logs_fk_user_user_id_fk` (`fk_user`);

--
-- Index pour la table `module`
--
ALTER TABLE `meczy_module`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `module` (`module`);

--
-- Index pour la table `profil`
--
ALTER TABLE `meczy_profil`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `profil` (`profil`);

--
-- Index pour la table `sous_module`
--
ALTER TABLE `meczy_sous_module`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sous_module_fk_module_module_id_fk` (`fk_module`);

--
-- Index pour la table `user`
--
ALTER TABLE `meczy_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `user_fk_profil_profil_id_fk` (`fk_profil`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `affectation_droit`
--
ALTER TABLE `meczy_affectation_droit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `affectation_droit_user`
--
ALTER TABLE `meczy_affectation_droit_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `droit`
--
ALTER TABLE `meczy_droit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `logs`
--
ALTER TABLE `meczy_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `module`
--
ALTER TABLE `meczy_module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `profil`
--
ALTER TABLE `meczy_profil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `sous_module`
--
ALTER TABLE `meczy_sous_module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `meczy_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `affectation_droit`
--
ALTER TABLE `meczy_affectation_droit`
  ADD CONSTRAINT `affectation_droit_fk_droit_droit_id_fk` FOREIGN KEY (`fk_droit`) REFERENCES `droit` (`id`),
  ADD CONSTRAINT `affectation_droit_fk_profil_profil_id_fk` FOREIGN KEY (`fk_profil`) REFERENCES `profil` (`id`);

--
-- Contraintes pour la table `affectation_droit_user`
--
ALTER TABLE `meczy_affectation_droit_user`
  ADD CONSTRAINT `affect_droit_user_fk_affect_droit_affec_droit_id__fk` FOREIGN KEY (`fk_affectation_droit`) REFERENCES `affectation_droit` (`id`),
  ADD CONSTRAINT `affectation_droit_user_fk_user_user_id_fk` FOREIGN KEY (`fk_user`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `droit`
--
ALTER TABLE `meczy_droit`
  ADD CONSTRAINT `droit_fk_sous_module_sous_module_id_fk` FOREIGN KEY (`fk_sous_module`) REFERENCES `sous_module` (`id`);

--
-- Contraintes pour la table `logs`
--
ALTER TABLE `meczy_logs`
  ADD CONSTRAINT `logs_fk_user_user_id_fk` FOREIGN KEY (`fk_user`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `sous_module`
--
ALTER TABLE `meczy_sous_module`
  ADD CONSTRAINT `sous_module_fk_module_module_id_fk` FOREIGN KEY (`fk_module`) REFERENCES `sous_module` (`id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `meczy_user`
  ADD CONSTRAINT `user_fk_profil_profil_id_fk` FOREIGN KEY (`fk_profil`) REFERENCES `profil` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
