-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 27 avr. 2025 à 20:19
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `portfolio`
--
USE `portfolio`;
-- --------------------------------------------------------

--
-- Structure de la table `accueil`
--

CREATE TABLE `accueil` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  `statut` varchar(50) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `github` varchar(255) DEFAULT NULL,
  `image_accueil` varchar(255) DEFAULT NULL,
  `image_apropos` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `accueil`
--

INSERT INTO `accueil` (`id`, `nom`, `bio`, `telephone`, `adresse`, `date_naissance`, `experience`, `statut`, `linkedin`, `github`, `image_accueil`, `image_apropos`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'Robin Fligitter', 'Je suis un développeur front-end passionné avec une expérience en community management et en graphisme.', '0123456789', '123 Rue Exemple, Ville, Pays', '1990-01-01', 5, 'Freelance', 'https://www.linkedin.com/in/robinfligitter', 'https://github.com/robinfligitter', 'images/1745759535_Robin_edit.jpg', 'images/1745760718_communication.jpg', 'images/dev-logo.png', '2025-04-16 10:50:00', '2025-04-27 13:31:58');

-- --------------------------------------------------------

--
-- Structure de la table `competences`
--

CREATE TABLE `competences` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `niveau` enum('Débutant','Intermédiaire','Avancé','Expert') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `competences`
--

INSERT INTO `competences` (`id`, `nom`, `niveau`) VALUES
(1, 'HTML', 'Expert'),
(2, 'CSS', 'Expert'),
(3, 'JavaScript', 'Avancé'),
(4, 'PHP', 'Intermédiaire'),
(5, 'MySQL', 'Intermédiaire');

-- --------------------------------------------------------

--
-- Structure de la table `contenu`
--

CREATE TABLE `contenu` (
  `id` int(11) NOT NULL,
  `section` varchar(100) NOT NULL,
  `param_key` varchar(100) NOT NULL,
  `param_value` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `emails`
--

CREATE TABLE `emails` (
  `id` int(11) NOT NULL,
  `personne` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `sujet` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `date_envoi` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `emails`
--

INSERT INTO `emails` (`id`, `personne`, `email`, `sujet`, `contenu`, `date_envoi`) VALUES
(1, 'Alice Dupont', 'alice.dupont@example.com', 'Demande d\'information', 'Bonjour, je souhaite avoir plus d\'informations sur votre service.', '2025-04-27 15:31:59'),
(2, 'Bob Martin', 'bob.martin@example.com', 'Feedback', 'Votre site est très bien fait, continuez comme ça !', '2025-04-27 15:31:59'),
(3, 'Claire Durand', 'claire.durand@example.com', 'Problème technique', 'J\'ai rencontré un problème lors de l\'utilisation de votre site.', '2025-04-27 15:31:59');

-- --------------------------------------------------------

--
-- Structure de la table `metiers`
--

CREATE TABLE `metiers` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `metiers`
--

INSERT INTO `metiers` (`id`, `nom`) VALUES
(2, 'Community Manager'),
(1, 'Développeur Front-End'),
(3, 'Graphiste');

-- --------------------------------------------------------

--
-- Structure de la table `projets`
--

  CREATE TABLE `projets` (
    `id` int(11) NOT NULL,
    `titre` varchar(255) NOT NULL,
    `description` text DEFAULT NULL,
    `image_url` varchar(255) DEFAULT '',
    `annexes` varchar(255) DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `projets`
--

INSERT INTO `projets` (`id`, `titre`, `description`, `image_url`) VALUES
(1, 'Site Portfolio', 'Transformation d’un site statique en CMS PHP afin de gérer dynamiquement le contenu.', 'images/projects/lol.jpg'),
(2, 'Court métrage Interview d\'un Enderman', 'Court métrage réalisé sur une interview Kombini fictive d\'un Enderman, explorant l\'univers de Minecraft et apportant une touche d\'humour et de fantaisie. 1er essaie de vidéo + montage', 'images/projects/1745775851_4698f49ba7e2fe0b15c25ccab1c8ea58.png'),
(3, 'Stratégie de communication du Festival Corsica Games Week', 'Développement d\'une stratégie de communication digitale et traditionnelle pour le Festival Corsica Games Week, incluant réseaux sociaux, production Graphique et événements.', 'images/projects/1745776119_c3c2e4b702d04ac9829d283cd7401266.png','images/files/CGW.docx'),
(4, 'Audit d\'ergonomie du site Naya.tech', 'Réalisation d\'un audit complet de l\'ergonomie du site Naya.tech afin d\'identifier les axes d\'amélioration de l\'expérience utilisateur.', 'images/projects/1745776218_bcd16865625aafafd63fba590a4d718c.png');

-- --------------------------------------------------------

--
-- Structure de la table `projet_technologies`
--

CREATE TABLE `projet_technologies` (
  `projet_id` int(11) NOT NULL,
  `technologie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `projet_technologies`
--

INSERT INTO `projet_technologies` (`projet_id`, `technologie_id`) VALUES
(1, 1),
(1, 3),
(1, 4),
(2, 7),
(2, 8),
(2, 9),
(3, 5),
(3, 6),
(4, 3),
(4, 10),
(4, 11),
(4, 12);

-- --------------------------------------------------------

--
-- Structure de la table `technologies`
--

CREATE TABLE `technologies` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `technologies`
--

INSERT INTO `technologies` (`id`, `nom`) VALUES
(11, 'Accessibilité'),
(6, 'AdobeIllustrator'),
(7, 'AdobePremiere'),
(1, 'Bootstrap'),
(12, 'Dev'),
(10, 'Ergonomie'),
(8, 'Film'),
(2, 'jQuery'),
(9, 'Montage'),
(4, 'MySQL'),
(5, 'photoshop'),
(3, 'PHP');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('root','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `username`, `password`, `role`) VALUES
(1, 'root', '13d3bd276e2bed5ec51b3e2b0d968371', 'root'),
(2, 'user1', '6ae24d2bc97cf7f0a72d665786b524be', 'user');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `accueil`
--
ALTER TABLE `accueil`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `competences`
--
ALTER TABLE `competences`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`);

--
-- Index pour la table `contenu`
--
ALTER TABLE `contenu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `section` (`section`,`param_key`);

--
-- Index pour la table `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `metiers`
--
ALTER TABLE `metiers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`);

--
-- Index pour la table `projets`
--
ALTER TABLE `projets`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `projet_technologies`
--
ALTER TABLE `projet_technologies`
  ADD PRIMARY KEY (`projet_id`,`technologie_id`),
  ADD KEY `technologie_id` (`technologie_id`);

--
-- Index pour la table `technologies`
--
ALTER TABLE `technologies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `accueil`
--
ALTER TABLE `accueil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `competences`
--
ALTER TABLE `competences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `contenu`
--
ALTER TABLE `contenu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `emails`
--
ALTER TABLE `emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `metiers`
--
ALTER TABLE `metiers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `projets`
--
ALTER TABLE `projets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `technologies`
--
ALTER TABLE `technologies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `projet_technologies`
--
ALTER TABLE `projet_technologies`
  ADD CONSTRAINT `projet_technologies_ibfk_1` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `projet_technologies_ibfk_2` FOREIGN KEY (`technologie_id`) REFERENCES `technologies` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
