<?php
    require_once 'model/connect.php'; // Retourne l'instance PDO dans $pdo
    require_once 'model/homeModel.php';
    require_once 'controler/homeControler.php';

    // Initialisation du modèle et du contrôleur
    $homeModel = new HomeModel($pdo);
    $homeController = new HomeController($homeModel);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyPortfolio by dev-ribellu</title>
    <link rel="icon" href="images/dev-logo.png" type="image/png">
    
    <link rel="stylesheet" href="style/body.css">
    <link rel="stylesheet" href="style/section/section.css">
    <link rel="stylesheet" href="style/section/acceuil.css">
    <link rel="stylesheet" href="style/section/about.css">
    <link rel="stylesheet" href="style/section/skills.css">
    <link rel="stylesheet" href="style/section/projects.css">
    <link rel="stylesheet" href="style/section/contact.css">
    <link rel="stylesheet" href="style/header.css">


    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script src="script/scriptAccueil.js"></script>
    <script src="script/skills.js"></script>
    <script src="script/particles.js"></script>
    <script src="script/header.js"></script>
    <script src="script/contact.js"></script>
    <script src="script/border_about.js"></script>
</head>

<body>
    <div id="particles-js"></div>
    <header>
        <img src="<?= htmlspecialchars($homeController->getLogo()) ?>" alt="Logo" class="logo">
        <a id="login_button" href="login.php">LOGIN</a>
        <button class="menu-toggle" aria-label="Toggle navigation">
            <span class="menu-icon"></span>
        </button>
        <nav>
            <ul>
                <li><a href="#accueil" id="nav-accueil">Accueil</a></li>
                <li><a href="#aboutme" id="nav-aboutme">A propos</a></li>
                <li><a href="#competences" id="nav-competences">Compétences</a></li>
                <li><a href="#Projets" id="nav-Projets">Réalisations</a></li>
                <li><a href="#contact" id="nav-contact">Contact</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <!-- Section Accueil -->
        <section id="accueil" >
            <div class="container-acceuil">
                <div class="image-cercle">
                    <img src="<?= htmlspecialchars($homeController->getImageAccueil()) ?>" alt="Image de profil" id="profile-image">
                </div>
                <div class="texte">
                    <p class="ligne1">Je suis</p>
                    <p class="ligne2"><?= htmlspecialchars($homeController->getNom()) ?></p>
                    <p class="ligne3" id="ligne3">Front-end développeur</p>
                </div>
            </div>
        </section>

        <!-- Section À propos -->
        <section id="aboutme" class="border-change">
            <div class="titre">
                <p class="sous-titre">A Propos</p>
                <p class="grand-titre">A Propos</p>
            </div>
            <div class="contenu">
                <div class="image-carre">
                    <img src="<?= htmlspecialchars($homeController->getImageApropos()) ?>" alt="Image de profil">
                </div>
                <div class="texte">
                    <p class="nom"><?= htmlspecialchars($homeController->getNom()) ?></p>
                    <p class="description"><?= htmlspecialchars($homeController->getBio()) ?></p>
                    <div class="infos">
                        <p><strong>Nom :</strong> <?= htmlspecialchars($homeController->getNom()) ?></p>
                        <p><strong>Téléphone :</strong> <?= htmlspecialchars($homeController->getTelephone()) ?></p>
                        <p><strong>Adresse :</strong> <?= htmlspecialchars($homeController->getAdresse()) ?></p>
                        <p><strong>Date de naissance :</strong> <?= htmlspecialchars($homeController->getDateNaissance()) ?></p>
                        <p><strong>Expérience :</strong> <?= htmlspecialchars($homeController->getExperience()) ?></p>
                        <p><strong>Email :</strong> robin@example.com</p>
                        <p><strong>Statut :</strong> <?= htmlspecialchars($homeController->getStatut()) ?></p>
                    </div>
                    <div class="boutons" id="boutonsCV">
                        <button class="btn">CV</button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Compétences (généré dynamiquement) -->
        <section id="competences" class="border-change">
            <div class="content-wrapper">
                <div class="titre">
                    <p class="sous-titre">Compétences</p>
                    <p class="grand-titre">Skills</p>
                </div>
                <div class="center">
                    
                    <?php
                    $competences = $homeController->getCompetences();
                    foreach ($competences as $competence) {
                        $skillName = $competence['nom'];
                        $niveau = $competence['niveau'];
                        // Mapping des niveaux en pourcentage
                        switch ($niveau) {
                            case 'Débutant':
                                $pourcentage = 25;
                                break;
                            case 'Intermédiaire':
                                $pourcentage = 50;
                                break;
                            case 'Avancé':
                                $pourcentage = 75;
                                break;
                            case 'Expert':
                                $pourcentage = 90;
                                break;
                            default:
                                $pourcentage = 0;
                                break;
                        }
                        ?>
                        <div class="skillbox">
                            <p><?= htmlspecialchars($skillName) ?></p>
                            <p><?= $pourcentage ?>%</p>
                            <div class="skill">
                                <div class="skill_level" data-skill="<?= $pourcentage ?>"></div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>

        <!-- Section Projets (exemple statique) -->
        <section id="Projets" class="border-change">
            <div class="content-wrapper">
                <div class="titre">
                    <p class="sous-titre">Projets</p>
                    <p class="grand-titre">Projets</p>
                </div>
                <div class="cards">
                    <div class="card">
                        <a href="MyProjects.php">
                            <p class="card-text">Voir Projets</p>
                            <p class="card-plus">+</p>
                            <img src="images/informatique.jpg" alt="Site Web" class="card-image">
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Contact -->
        <section id="contact" class="border-change">
            <div class="content-wrapper">
                <div class="titre">
                    <p class="sous-titre">Contactez-moi</p>
                    <p class="grand-titre">Contact</p>
                </div>
                <div class="formulaire-contact">
                    <form action="controler/submit_form.php" method="post">
                        <div class="form-group">
                            <label for="nom">Nom</label>
                            <input type="text" id="nom" name="nom" placeholder="John Doe" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="votre.email@example.com" required>
                        </div>
                        <div class="form-group">
                            <label for="sujet">Sujet</label>
                            <input type="text" id="sujet" name="sujet" placeholder="Sujet de votre message" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" rows="5" placeholder="Lorem Ipsum" required></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn" style="display: block; margin: 0 auto;">Envoyer message</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
    
</body>
</html>