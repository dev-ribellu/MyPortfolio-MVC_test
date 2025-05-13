<?php
class HomeModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Récupère les informations de l'utilisateur (on suppose un seul utilisateur)
    public function getInfo() {
        $sql = 'SELECT * FROM Accueil LIMIT 1'; 
        $statement = $this->pdo->query($sql);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }


    // Récupère tous les emails
    public function getEmails() {
        $sql = 'SELECT * FROM emails';
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupère toutes les compétences avec leur niveau
    public function getCompetences() {
        $sql = 'SELECT nom, niveau FROM competences';
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupère tous les projets
    public function getProjets() {
        $sql = 'SELECT * FROM projets';
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupère les technologies associées à un projet donné
    public function getTechnologiesByProjet($projet_id) {
        $sql = "SELECT t.nom 
                FROM technologies t 
                JOIN projet_technologies pt ON t.id = pt.technologie_id 
                WHERE pt.projet_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $projet_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupère les images associées à un projet
    public function getImagesProjet($projet_id) {
        $sql = "SELECT image_url FROM projets WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $projet_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupère tous les métiers
    public function getMetiers() {
        $sql = "SELECT * FROM metiers";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // ------------------ Fonctions Insert / Update ------------------

    // Met à jour la section Accueil
    public function updateAccueil($nom, $image = null) {
        $sql = "UPDATE Accueil SET nom = :nom";
        if ($image !== null) {
            $sql .= ", image_accueil = :image";
        }
        $sql .= " WHERE id = 1";
        $stmt = $this->pdo->prepare($sql);
        $params = ['nom' => $nom];
        if ($image !== null) {
            $params['image'] = $image;
        }
        return $stmt->execute($params);
    }

    // Met à jour la section "A Propos"
    // Expects keys: prenom_nom, description, telephone, adresse, date_naissance, experience, email, statut [, photo_a_propos]
    public function updateAPropos(array $data) {
        $sql = "UPDATE Accueil SET nom = :prenom_nom, bio = :description, telephone = :telephone, adresse = :adresse, date_naissance = :date_naissance, experience = :experience, statut = :statut";
        if (isset($data['photo_a_propos']) && !empty($data['photo_a_propos'])) {
            $sql .= ", image_apropos = :photo_a_propos";
        }
        $sql .= " WHERE id = 1";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    // Met à jour les compétences en vidant la table et en insérant la nouvelle liste
    // Expects $competences comme tableau de tableaux avec clés 'nom' et 'niveau'
    public function updateCompetences(array $competences) {
        // Supprime les compétences existantes
        $this->pdo->exec("TRUNCATE TABLE competences");
        $sql = "INSERT INTO competences (nom, niveau) VALUES (:nom, :niveau)";
        $stmt = $this->pdo->prepare($sql);
        foreach ($competences as $comp) {
            if (!empty($comp['nom'])) {
                $stmt->execute([
                    'nom' => $comp['nom'],
                    'niveau' => $comp['niveau']
                ]);
            }
        }
        return true;
    }

    // Insère un nouvel email dans la table emails
    public function insertMail($email, $type = 'Personnel') {
        $sql = "INSERT INTO emails (email, type) VALUES (:email, :type)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['email' => $email, 'type' => $type]);
    }

    // Met à jour un projet donné (titre et description)
    public function updateProjet($projet_id, $titre, $description) {
        $sql = "UPDATE projets SET titre = :titre, description = :description WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['titre' => $titre, 'description' => $description, 'id' => $projet_id]);
    }

    // Insère un nouveau projet
    public function insertProjet($titre, $description) {
        $sql = "INSERT INTO projets (titre, description) VALUES (:titre, :description)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['titre' => $titre, 'description' => $description]);
    }
    
    // Insère une nouvelle image pour un projet donné
    public function insertImageProjet($projet_id, $image_url) {
        $sql = "INSERT INTO images_projets (projet_id, image_url) VALUES (:projet_id, :image_url)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['projet_id' => $projet_id, 'image_url' => $image_url]);
    }
    public function getTechnologies() {
        $stmt = $this->pdo->query("SELECT * FROM technologies");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




}
?>