<?php
require_once 'model/connect.php';
require_once 'model/homeModel.php';
require_once 'controler/homeControler.php';

$homeModel = new HomeModel($pdo);
$homeController = new HomeController($homeModel);

session_start();
if (!isset($_SESSION['isUserLoggedIn']) || $_SESSION['isUserLoggedIn'] !== true) {
    header('Location: login.php');
    exit;
}

// Récupération des données pour l'affichage
$accueil = $homeController->getInfo();
$competences = $homeController->getCompetences();
$stmt = $pdo->query("SELECT * FROM emails");
$mails = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <link rel="icon" href="images/dev-logo.png" type="image/png">
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="style/admin/dashboard.css">
  <link rel="stylesheet" href="AdminLTE/dist/css/adminlte.css">
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Section : Modifier Accueil -->
    <section class="content">
      <div class="container-fluid">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">Modifier Accueil</h3>
          </div>
          <form action="controler/upload.php" method="post" enctype="multipart/form-data">
            <div class="card-body">
              <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" placeholder="Entrez votre Nom" value="<?= htmlspecialchars($accueil['nom'] ?? '') ?>">
              </div>
              <div class="form-group">
                <label for="image">Upload Image</label>
                <div class="drop-zone" id="drop-zone">
                  <span class="drop-zone__prompt">Déposez votre image ici ou cliquez pour sélectionner</span>
                  <input type="file" name="image" id="image-upload" accept="image/*" style="display: none;">
                  <img id="preview" alt="Aperçu de l'image" style="display: none;">
                </div>
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Envoyer</button>
            </div>
          </form>
        </div>
      </div>
    </section>
    <!-- /Section Modifier Accueil -->
      
   
    
    <!-- Section : Gérer les Métiers -->
    <section class="content">
      <div class="container-fluid">
        <div class="card card-secondary">
          <div class="card-header">
            <h3 class="card-title">Gérer les Métiers</h3>
          </div>
          <div class="card-body">
            <!-- Formulaire d'ajout d'un métier -->
            <form action="controler/manage_job.php" method="post" class="mb-4">
              <div class="form-group">
                <label for="new_job">Ajouter un Métier</label>
                <input type="text" class="form-control" id="new_job" name="job_name" placeholder="Entrez le nom du métier">
              </div>
              <input type="hidden" name="action" value="add">
              <button type="submit" class="btn btn-success">Ajouter</button>
            </form>
          
            <!-- Affichage des métiers existants -->
            <?php
              $jobsStmt = $pdo->query("SELECT * FROM metiers ORDER BY id ASC");
              $jobs = $jobsStmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Métier</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($jobs as $job): ?>
                  <tr>
                    <td><?= htmlspecialchars($job['id']) ?></td>
                    <td>
                      <form action="controler/manage_job.php" method="post" class="form-inline">
                        <input type="text" name="job_name" value="<?= htmlspecialchars($job['nom']) ?>" class="form-control">
                        <input type="hidden" name="job_id" value="<?= htmlspecialchars($job['id']) ?>">
                        <input type="hidden" name="action" value="edit">
                        <button type="submit" class="btn btn-primary btn-sm">Modifier</button>
                      </form>
                    </td>
                    <td>
                      <form action="controler/manage_job.php" method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce métier ?');">
                        <input type="hidden" name="job_id" value="<?= htmlspecialchars($job['id']) ?>">
                        <input type="hidden" name="action" value="delete">
                        <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                      </form>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
    
   
    <!-- Section : Modifier A Propos -->
    <section class="content">
      <div class="container-fluid">
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">Modifier "A Propos"</h3>
          </div>
          <form action="controler/upload_a_propos.php" method="post" enctype="multipart/form-data">
            <div class="card-body">
              <div class="form-group">
                <label for="photo_a_propos">Photo</label>
                <input type="file" class="form-control" id="photo_a_propos" name="photo_a_propos" accept="image/*">
              </div>
              <div class="form-group">
                <label for="prenom_nom">Prénom Nom</label>
                <input type="text" class="form-control" id="prenom_nom" name="prenom_nom" placeholder="Entrez prénom et nom" value="<?= htmlspecialchars($accueil['nom'] ?? '') ?>">
              </div>
              <div class="form-group">
                <label for="description">Petite Description</label>
                <textarea class="form-control" id="description" name="description" placeholder="Entrez la description"><?= htmlspecialchars($accueil['bio'] ?? '') ?></textarea>
              </div>
              <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" id="nom_a_propos" name="nom" placeholder="Entrez le nom" value="<?= htmlspecialchars($accueil['nom'] ?? '') ?>">
              </div>
              <div class="form-group">
                <label for="telephone">Téléphone</label>
                <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Entrez le téléphone" value="<?= htmlspecialchars($accueil['telephone'] ?? '') ?>">
              </div>
              <div class="form-group">
                <label for="adresse">Adresse</label>
                <input type="text" class="form-control" id="adresse" name="adresse" placeholder="Entrez l'adresse" value="<?= htmlspecialchars($accueil['adresse'] ?? '') ?>">
              </div>
              <div class="form-group">
                <label for="date_naissance">Date de Naissance</label>
                <input type="date" class="form-control" id="date_naissance" name="date_naissance" value="<?= htmlspecialchars($accueil['date_naissance'] ?? '') ?>">
              </div>
              <div class="form-group">
                <label for="experience">Expérience</label>
                <textarea class="form-control" id="experience" name="experience" placeholder="Décrivez votre expérience"><?= htmlspecialchars($accueil['experience'] ?? '') ?></textarea>
              </div>
              <div class="form-group">
                <label for="statut">Statut</label>
                <input type="text" class="form-control" id="statut" name="statut" placeholder="Entrez le statut" value="<?= htmlspecialchars($accueil['statut'] ?? '') ?>">
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-info">Enregistrer</button>
            </div>
          </form>
        </div>
      </div>
    </section>
    <!-- /Section Modifier A Propos -->

    <!-- Section : Gestion des Compétences -->
    <section class="content">
      <div class="container-fluid">
        <div class="card card-warning">
          <div class="card-header">
            <h3 class="card-title">Ajoutez Compétences</h3>
            
            
          </div>
          <form action="controler/upload_competences.php" method="post">
            <div class="card-body">
              <div id="competence-list">
                <?php if(!empty($competences)) : ?>
                  <?php foreach($competences as $competence): ?>
                    <div class="form-group d-flex align-items-center mb-2">
                      <input type="text" name="competence_name[]" class="form-control me-2" placeholder="Nom de la compétence" value="<?= htmlspecialchars($competence['nom']) ?>">
                      <select name="competence_level[]" class="form-select me-2">
                        <option value="Expert" <?= ($competence['niveau'] == 'Expert')?'selected':'' ?>>Expert</option>
                        <option value="Avancé" <?= ($competence['niveau'] == 'Avancé')?'selected':'' ?>>Avancé</option>
                        <option value="Intermédiaire" <?= ($competence['niveau'] == 'Intermédiaire')?'selected':'' ?>>Intermédiaire</option>
                        <option value="Débutant" <?= ($competence['niveau'] == 'Débutant')?'selected':'' ?>>Débutant</option>
                      </select>
                      <button type="button" class="btn btn-danger btn-sm remove-competence">Supprimer</button>
                    </div>
                  <?php endforeach; ?>
                <?php else: ?>
                  <div class="form-group d-flex align-items-center mb-2">
                    <input type="text" name="competence_name[]" class="form-control me-2" placeholder="Nom de la compétence">
                    <select name="competence_level[]" class="form-select me-2">
                      <option value="Expert">Expert</option>
                      <option value="Avancé">Avancé</option>
                      <option value="Intermédiaire">Intermédiaire</option>
                      <option value="Débutant">Débutant</option>
                    </select>
                    <button type="button" class="btn btn-danger btn-sm remove-competence">Supprimer</button>
                  </div>
                <?php endif; ?>
              </div>
              <button type="button" class="btn btn-primary" id="add-competence">Ajouter Compétence</button>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-warning">Enregistrer les Compétences</button>
            </div>
          </form>
        </div>
      </div>
    </section>
    <!-- /Section Gestion des Compétences -->

    <!-- Section : Liste des Mails -->
    <section class="content">
      <div class="container-fluid">
        <div class="card card-secondary">
          <div class="card-header">
            <h3 class="card-title">Liste des Mails</h3>
          </div>
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Email</th>
                  <th>Personne</th>
                  <th>Sujet</th>
                  <th>Contenu</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($mails)) : ?>
                  <?php foreach($mails as $mail): ?>
                    <tr>
                      <td><?= htmlspecialchars($mail['id']) ?></td>
                      <td><?= htmlspecialchars($mail['email']) ?></td>
                      <td><?= htmlspecialchars($mail['personne']) ?></td>
                      <td><?= htmlspecialchars($mail['sujet']) ?></td>
                      <td><?= htmlspecialchars($mail['contenu']) ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="5">Aucun mail trouvé</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>

    <!-- Section : Ajouter / Modifier un Projet -->
    <section class="content">
      <div class="container-fluid">
        <div class="card card-success card-outline">
          <div class="card-header">
            <h3 class="card-title">Ajouter / Modifier un Projet</h3>
          </div>
          <form action="controler/upload_projet.php" method="post" enctype="multipart/form-data" id="project-form">
            <div class="card-body">
              <!-- Choix du projet à modifier ou création d'un nouveau -->
              <div class="form-group">
                <label for="existing_project">
                  Choisir un Projet à Modifier (laisser "Nouveau projet" pour en créer un nouveau)
                </label>
                <select class="form-control" id="existing_project" name="project_id">
                  <option value="">Nouveau projet</option>
                  <?php
                  $projets = $homeController->getProjets();
                  if(!empty($projets)){
                    foreach($projets as $proj){
                      echo '<option value="'.htmlspecialchars($proj['id']).'">'
                           .htmlspecialchars($proj['titre'])
                           .'</option>';
                    }
                  }
                  ?>
                </select>
              </div>
              <!-- Champs pour le titre du projet -->
              <div class="form-group">
                <label for="titre_projet">Titre du Projet</label>
                <input type="text" class="form-control" id="titre_projet" name="titre_projet" placeholder="Entrez le titre du projet" required>
              </div>
              <!-- Champs pour la description du projet -->
              <div class="form-group">
                <label for="description_projet">Description du Projet</label>
                <textarea class="form-control" id="description_projet" name="description_projet" placeholder="Décrivez le projet" rows="4" required></textarea>
              </div>
              <!-- Zone de drag & drop pour l'image -->
              <div class="form-group">
                <label>Image du Projet (laisser vide en modification si aucune mise à jour)</label>
                <div class="drop-zone" id="drop-zone-projet">
                  <span class="drop-zone__prompt">Déposez l'image ici ou cliquez pour sélectionner</span>
                  <input type="file" name="image_projet" id="image-projet" class="drop-zone__input" accept="image/*">
                </div>
                <!-- Prévisualisation de l'image existante -->
                <div id="image-preview-container" style="margin-top:10px; display:none;">
                  <label>Prévisualisation de l'image :</label>
                  <img id="project-preview" src="" alt="Prévisualisation" style="max-width:100px;">
                </div>
              </div>
              <!-- Liste des technologies existantes -->
              <div class="form-group">
                <label>Affecter des Technologies existantes</label>
                <div id="tech-checkboxes">
                  <?php
                  $techList = $homeController->getTechnologies();
                  if(!empty($techList)){
                    foreach($techList as $tech){
                      echo '<div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="technologies[]" id="tech_'.$tech['id'].'" value="'.htmlspecialchars($tech['id']).'">
                              <label class="form-check-label" for="tech_'.$tech['id'].'">'.htmlspecialchars($tech['nom']).'</label>
                            </div>';
                    }
                  }
                  ?>
                </div>
              </div>
              <!-- Bouton dédié pour ajouter une nouvelle technologie -->
              
            <div class="card-footer">
              <button type="submit" class="btn btn-success">Valider</button>
            </div>
          </form>
        </div>
      </div>
    </section>
        <!-- Section : Ajouter une Technologie Individuelle -->
    <section class="content">
      <div class="container-fluid">
        <div class="card card-secondary">
          <div class="card-header">
            <h3 class="card-title">Ajouter une Technologie</h3>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="tech_name">Nom de la Technologie</label>
              <input type="text" class="form-control" id="tech_name" placeholder="Entrez le nom de la technologie">
            </div>
            <button type="button" class="btn btn-info" id="submit-tech-btn">Ajouter Technologie</button>
          </div>
          <div class="card-footer" id="tech-result"></div>
        </div>
      </div>
    </section>
  </div>
    
  <section class="content" id="project-list-section">
    <div class="container-fluid">
      <div class="card card-danger">
        <div class="card-header">
          <h3 class="card-title">Liste des Projets</h3>
        </div>
        <div class="card-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $projets = $homeController->getProjets();
                if (!empty($projets)) {
                  foreach ($projets as $proj) {
                    ?>
                    <tr>
                      <td><?= htmlspecialchars($proj['id']) ?></td>
                      <td><?= htmlspecialchars($proj['titre']) ?></td>
                      <td>
                        <form action="controler/manage_projet.php" method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?');">
                          <input type="hidden" name="project_id" value="<?= htmlspecialchars($proj['id']) ?>">
                          <input type="hidden" name="action" value="delete">
                          <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                      </td>
                    </tr>
                    <?php
                  }
                } else {
                  echo '<tr><td colspan="3">Aucun projet trouvé</td></tr>';
                }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
  <!-- Inclusion des scripts externalisés -->
  <script src="script/drop.js"></script>
  <script src="script/tech_admin.js"></script>
  <script src="script/skill_admin.js"></script>
  <script src="script/project_form.js"></script>
  
</body>
</html>