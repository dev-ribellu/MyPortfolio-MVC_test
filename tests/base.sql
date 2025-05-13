CREATE DATABASE portfolio;
USE portfolio;

CREATE TABLE utilisateur (
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
    logo VARCHAR(255)
);

CREATE TABLE emails (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT,
    email VARCHAR(255) NOT NULL UNIQUE,
    type ENUM('Personnel', 'Professionnel', 'Autre') DEFAULT 'Personnel',
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id) ON DELETE CASCADE
);

CREATE TABLE competences (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE utilisateur_competences (
    utilisateur_id INT,
    competence_id INT,
    niveau ENUM('Débutant', 'Intermédiaire', 'Avancé', 'Expert'),
    PRIMARY KEY (utilisateur_id, competence_id),
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id) ON DELETE CASCADE,
    FOREIGN KEY (competence_id) REFERENCES competences(id) ON DELETE CASCADE
);

CREATE TABLE projets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    description TEXT
);

CREATE TABLE utilisateur_projets (
    utilisateur_id INT,
    projet_id INT,
    PRIMARY KEY (utilisateur_id, projet_id),
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id) ON DELETE CASCADE,
    FOREIGN KEY (projet_id) REFERENCES projets(id) ON DELETE CASCADE
);

CREATE TABLE technologies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE projet_technologies (
    projet_id INT,
    technologie_id INT,
    PRIMARY KEY (projet_id, technologie_id),
    FOREIGN KEY (projet_id) REFERENCES projets(id) ON DELETE CASCADE,
    FOREIGN KEY (technologie_id) REFERENCES technologies(id) ON DELETE CASCADE
);

CREATE TABLE images_projets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    projet_id INT,
    image_url VARCHAR(255) NOT NULL,
    FOREIGN KEY (projet_id) REFERENCES projets(id) ON DELETE CASCADE
);

CREATE TABLE metiers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE utilisateur_metiers (
    utilisateur_id INT,
    metier_id INT,
    PRIMARY KEY (utilisateur_id, metier_id),
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id) ON DELETE CASCADE,
    FOREIGN KEY (metier_id) REFERENCES metiers(id) ON DELETE CASCADE
);

INSERT INTO utilisateur (nom, bio, telephone, adresse, date_naissance, experience, statut, linkedin, github, image_accueil, image_apropos, logo) VALUES 
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
 'images/dev-logo.png'        -- logo choisi
);

INSERT INTO emails (utilisateur_id, email, type) VALUES 
(1, 'robin@example.com', 'Professionnel');

-- Insertion de quelques compétences extraites de vos pages HTML
INSERT INTO competences (nom) VALUES 
('HTML'),
('CSS'),
('JavaScript'),
('PHP'),
('MySQL');

INSERT INTO utilisateur_competences (utilisateur_id, competence_id, niveau) VALUES 
(1, 1, 'Expert'),
(1, 2, 'Expert'),
(1, 3, 'Avancé'),
(1, 4, 'Intermédiaire'),
(1, 5, 'Intermédiaire');

-- Insertion d'un projet exemple (vos pages projet en HTML)
INSERT INTO projets (titre, description) VALUES 
('Site Portfolio', 'Transformation d’un site statique en CMS PHP afin de gérer dynamiquement le contenu.');

-- Association du projet à l'utilisateur
INSERT INTO utilisateur_projets (utilisateur_id, projet_id) VALUES 
(1, 1);

-- Insertion de quelques technologies utilisées dans le projet
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

INSERT INTO metiers (nom) VALUES 
('Développeur Front-End'),
('Community Manager'),
('Graphiste');

-- Association du métier à l'utilisateur
INSERT INTO utilisateur_metiers (utilisateur_id, metier_id) VALUES 
(1, 1),
(1, 2),
(1, 3);