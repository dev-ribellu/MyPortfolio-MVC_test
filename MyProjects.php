<?php
    require_once 'model/connect.php'; // Retourne l'instance PDO dans $pdo
    require_once 'model/homeModel.php';
    require_once 'controler/homeControler.php';

    $homeModel = new HomeModel($pdo);
    $homeController = new HomeController($homeModel);

    $projects = $homeController->getProjets();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Projets - Portfolio</title>
    <link rel="icon" href="images/dev-logo.png" type="image/png">
    <link rel="stylesheet" href="style/MyProjects/modal.css">
    <link rel="stylesheet" href="style/MyProjects/myProjects.css">
    <link rel="stylesheet" href="style/header.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/header.css">
    <link rel="stylesheet" href="style/body.css">
    <link rel="stylesheet" href="style/section/section.css">
    <link rel="stylesheet" href="style/section/acceuil.css">
    <link rel="stylesheet" href="style/section/about.css">
    <link rel="stylesheet" href="style/section/skills.css">
    <link rel="stylesheet" href="style/section/contact.css">

    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script src="script/particles.js"></script>
    <script src="script/modal.js"></script>
    
</head>
<body>
    <!-- Effet de particules en arrière plan -->
    <div id="particles-js"></div>

    <header>
        <a href="index.php" style="padding-left: 2%;">
            <img src="<?= htmlspecialchars($homeController->getLogo()) ?>" alt="Logo" class="logo">
        </a>
    </header>

    <main>
        <div class="project-container">
            <?php foreach ($projects as $project): 
                $images = $homeController->getImagesProjet($project['id']);
                $technologies = $homeController->getTechnologiesByProjet($project['id']);
                // Prépare la chaîne de technologies sous forme de hashtags
                $techStr = '';
                if(!empty($technologies)){
                    $techArr = array_map(function($tech) {
                        return '#' . htmlspecialchars($tech['nom']);
                    }, $technologies);
                    $techStr = implode(' ', $techArr);
                } else {
                    $techStr = '#Pas de technologies';
                }
            ?>
                <div class="project-card" 
                     data-title="<?= htmlspecialchars($project['titre']) ?>" 
                     data-image="<?= ($images && count($images) > 0) ? htmlspecialchars($images[0]['image_url']) : '' ?>"
                     data-description="<?= htmlspecialchars($project['description']) ?>"
                     data-technologies="<?= $techStr ?>"
                     data-files="<?= htmlspecialchars($project['annexes'] ?? '') ?>">
                    <h2><?= htmlspecialchars($project['titre']) ?></h2>
                    <?php if($images && count($images) > 0): ?>
                        <img src="<?= htmlspecialchars($images[0]['image_url']) ?>" alt="<?= htmlspecialchars($project['titre']) ?>">
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    
    <!-- Fenêtre modale -->
    <div id="projectModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitle"></h2>
            <p id="modalDescription" style="color:#fff;"></p>
            <div id="modalLabels" style="color:#fff;"></div>
            
            <img id="modalImage" src="" alt="" style="max-width:100%; display:none; padding: 3%;">
            <div style="align-items:center; border-radius: 10px; border: 1px solid gray;  padding: 10px; ;">
                <img id="fileIcon" src="" alt="File Icon" style="width:40px;height:40px; display:inline-block; vertical-align: middle;">
                <a id="modalFiles" href=""  download> Télécharger le(s) annexe(s)</a>
            </div>
        </div>
    </div>
</body>
</html>