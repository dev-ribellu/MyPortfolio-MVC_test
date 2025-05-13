-- Création de la base et sélection
CREATE DATABASE IF NOT EXISTS portfolio;
USE portfolio;

-- Table principale pour l'accueil (anciennement utilisateur)
CREATE TABLE IF NOT EXISTS Accueil (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    bio TEXT,
    telephone VARCHAR(20),
    adresse VARCHAR(255),
    date_naissance DATE,
    experience INT,
    statut VARCHAR(50),
    linkedin VARCHAR(255),
    github VARCHAR(255),
    image_accueil VARCHAR(255),
    image_apropos VARCHAR(255),
    logo VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table emails (pas de référence à l'utilisateur)
CREATE TABLE IF NOT EXISTS emails (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    type ENUM('Personnel', 'Professionnel', 'Autre') DEFAULT 'Personnel'
);

-- Table des compétences intégrant directement le niveau
CREATE TABLE IF NOT EXISTS competences (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL UNIQUE,
    niveau ENUM('Débutant', 'Intermédiaire', 'Avancé', 'Expert') NOT NULL
);

-- Table des projets (tous les projets appartiennent directement à l'utilisateur)
CREATE TABLE IF NOT EXISTS projets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    description TEXT
);

-- Table des technologies utilisées dans les projets
CREATE TABLE IF NOT EXISTS technologies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL UNIQUE
);

-- Association entre projets et technologies
CREATE TABLE IF NOT EXISTS projet_technologies (
    projet_id INT,
    technologie_id INT,
    PRIMARY KEY (projet_id, technologie_id),
    FOREIGN KEY (projet_id) REFERENCES projets(id) ON DELETE CASCADE,
    FOREIGN KEY (technologie_id) REFERENCES technologies(id) ON DELETE CASCADE
);

-- Table des images associées aux projets
CREATE TABLE IF NOT EXISTS images_projets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    projet_id INT,
    image_url VARCHAR(255) NOT NULL,
    FOREIGN KEY (projet_id) REFERENCES projets(id) ON DELETE CASCADE
);

-- Table des métiers
CREATE TABLE IF NOT EXISTS metiers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL UNIQUE
);

-- Table pour stocker dynamiquement les contenus éditables (pour le back office CMS)
CREATE TABLE IF NOT EXISTS contenu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    section VARCHAR(100) NOT NULL,    -- ex : 'accueil', 'about', 'contact'
    param_key VARCHAR(100) NOT NULL,    -- ex : 'titre', 'texte', 'image'
    param_value TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE(section, param_key)
);

-- Insertion des données

-- Insertion de l'utilisateur (vous) dans la table Accueil
INSERT INTO Accueil (nom, bio, telephone, adresse, date_naissance, experience, statut, linkedin, github, image_accueil, image_apropos, logo)
VALUES 
('Robin Fligitter', 
 'Je suis un développeur front-end passionné avec une expérience en community management et en graphisme.', 
 '0123456789', 
 '123 Rue Exemple, Ville, Pays', 
 '1990-01-01', 
 5, 
 'Freelance', 
 'https://www.linkedin.com/in/robinfligitter', 
 'https://github.com/robinfligitter', 
 'images/Robin_edit.jpg', 
 'images/about.jpg',
 'images/dev-logo.png');

-- Insertion d'un email
INSERT INTO emails (email, type) VALUES 
('robin@example.com', 'Professionnel');

-- Insertion des compétences avec leur niveau
INSERT INTO competences (nom, niveau) VALUES 
('HTML', 'Expert'),
('CSS', 'Expert'),
('JavaScript', 'Avancé'),
('PHP', 'Intermédiaire'),
('MySQL', 'Intermédiaire');

-- Insertion d'un projet exemple
INSERT INTO projets (titre, description) VALUES 
('Site Portfolio', 'Transformation d’un site statique en CMS PHP afin de gérer dynamiquement le contenu.');

-- Insertion des technologies utilisées dans le projet
INSERT INTO technologies (nom) VALUES 
('Bootstrap'),
('jQuery'),
('PHP'),
('MySQL');

-- Liaison du projet et de ses technologies
INSERT INTO projet_technologies (projet_id, technologie_id) VALUES 
(1, 1),
(1, 2),
(1, 3),
(1, 4);

-- Insertion d'images associées au projet
INSERT INTO images_projets (projet_id, image_url) VALUES 
(1, 'images/projet-1.jpg'),
(1, 'images/projet-1-2.jpg');

-- Insertion des métiers
INSERT INTO metiers (nom) VALUES 
('Développeur Front-End'),
('Community Manager'),
('Graphiste');

-- Insertion de nouveaux projets dans la table projets
INSERT INTO projets (titre, description) VALUES 
('Court métrage Interview d\'un Enderman', 'Court métrage réalisé sur une interview fictive d\'un Enderman, explorant l\'univers de Minecraft et apportant une touche d\'humour et de fantaisie.'),
('Stratégie de communication du Festival Corsica Games Week', 'Développement d\'une stratégie de communication digitale et traditionnelle pour le Festival Corsica Games Week, incluant réseaux sociaux, partenariats et événements.'),
('Audit d\'ergonomie du site Naya.tech', 'Réalisation d\'un audit complet de l\'ergonomie du site Naya.tech afin d\'identifier les axes d\'amélioration de l\'expérience utilisateur.');






-- Ajout de la table pour les logins (application)
CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- pensez à stocker un hash et non le mot de passe en clair
    role ENUM('root', 'user') DEFAULT 'user'
);

-- Insertion des identifiants pour 'root' et 'user1'
INSERT INTO utilisateurs (username, password, role) VALUES
('root', MD5('your_root_password'), 'root'),
('user1', MD5('utilisateurs1'), 'user');







DROP USER IF EXISTS 'limited_user'@'localhost';
CREATE USER 'limited_user'@'localhost' IDENTIFIED BY 'limited_password';

-- Accord de privilèges sur toutes les tables sauf 'utilisateurs'
GRANT SELECT, INSERT, UPDATE, DELETE ON portfolio.Accueil TO 'limited_user'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON portfolio.emails TO 'limited_user'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON portfolio.competences TO 'limited_user'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON portfolio.projets TO 'limited_user'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON portfolio.technologies TO 'limited_user'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON portfolio.projet_technologies TO 'limited_user'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON portfolio.images_projets TO 'limited_user'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON portfolio.metiers TO 'limited_user'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON portfolio.contenu TO 'limited_user'@'localhost';



FLUSH PRIVILEGES;