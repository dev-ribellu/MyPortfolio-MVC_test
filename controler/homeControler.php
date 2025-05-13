<?php
require_once __DIR__ . '/../model/homeModel.php';
class HomeController {
    private $homeModel;
    private $utilisateur; // cache les infos utilisateur

    public function __construct(HomeModel $homeModel) {
        $this->homeModel = $homeModel;
        $this->utilisateur = $this->homeModel->getInfo();
    }

    // Méthode interne pour récupérer les infos utilisateur mises en cache
    public function getInfo() {
        return $this->utilisateur;
    }

    // Getters pour la table utilisateur
    public function getNom() {
        return $this->getInfo()['nom'];
    }

    public function getBio() {
        return $this->getInfo()['bio'];
    }

    public function getTelephone() {
        return $this->getInfo()['telephone'];
    }

    public function getAdresse() {
        return $this->getInfo()['adresse'];
    }

    public function getDateNaissance() {
        return $this->getInfo()['date_naissance'];
    }

    public function getExperience() {
        return $this->getInfo()['experience'];
    }

    public function getStatut() {
        return $this->getInfo()['statut'];
    }

    public function getLinkedin() {
        return $this->getInfo()['linkedin'];
    }

    public function getGithub() {
        return $this->getInfo()['github'];
    }

    public function getImageAccueil() {
        return $this->getInfo()['image_accueil'];
    }

    public function getImageApropos() {
        return $this->getInfo()['image_apropos'];
    }

    public function getLogo() {
        return $this->getInfo()['logo'];
    }

    // Getters pour les tables associées

    // Retourne un tableau d'emails
    public function getEmails() {
        return $this->homeModel->getEmails();
    }

    // Retourne un tableau de compétences avec leur niveau
    public function getCompetences() {
        return $this->homeModel->getCompetences();
    }

    // Retourne un tableau de projets
    public function getProjets() {
        return $this->homeModel->getProjets();
    }

    // Pour un projet donné, retourne les technologies associées
    public function getTechnologiesByProjet($projet_id) {
        return $this->homeModel->getTechnologiesByProjet($projet_id);
    }

    // Pour un projet donné, retourne les images associées
    public function getImagesProjet($projet_id) {
        return $this->homeModel->getImagesProjet($projet_id);
    }

    // Retourne un tableau des métiers
    public function getMetiers() {
        return $this->homeModel->getMetiers();
    }
    public function getTechnologies() {
        return $this->homeModel->getTechnologies();
    }
}
?>