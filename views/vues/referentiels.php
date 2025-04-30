<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Référentiels de la promotion en cours</title>
    <link rel="stylesheet" href="/assets/css/style3.css">
</head>
<body>
    <div class="refa">
        <div class="refa1">
            <div class="refa11">Référentiels de la promotion en cours</div>
            <div>Gérer les référentiels de la promotion en cours</div>
        </div>
        
        <div class="refa2">
            <form action="index.php?page=ref" method="post">
                <input type="text" name="search_ref" placeholder="         Rechercher un référentiel..." value="<?= isset($_POST['search_ref']) ? htmlspecialchars($_POST['search_ref']) : '' ?>">
            </form>
            
            <a href="index.php?page=ref2" class="rim">
                <div><img src="/assets/images/book.svg" alt=""></div>
                <div>Tous les référentiels</div>
            </a>
            <a href="index.php?page=ajoutref2" class="rim2">+ Ajouter à la promotion</a>
        </div>
        
        <div class="gril">
            <?php if (!isset($promotionEnCours)): ?>
                <p style="margin-left: 20px; color: red;">Aucune promotion en cours trouvée.</p>
            <?php elseif (empty($referentiels)): ?>
                <p style="margin-left: 20px; color: red;">Aucun référentiel trouvé pour la promotion en cours: <?= htmlspecialchars($promotionEnCours['nom']) ?>.</p>
            <?php else: ?>
                
                <?php foreach ($referentiels as $ref): ?>
                    <div class="elt">
                        <div><img src="<?= htmlspecialchars($ref['photo']) ?>" alt="Photo référentiel"></div>
                        <div class="de"><?= htmlspecialchars($ref['nom']) ?></div>
                        <div>
                            <?php if (isset($ref['nombre_modules'])): ?>
                                <?= $ref['nombre_modules'] ?> modules
                            <?php elseif (isset($ref['sessions'])): ?>
                                <?= $ref['sessions'] ?> modules
                            <?php else: ?>
                                0 modules
                            <?php endif; ?>
                        </div>
                        <div><?= htmlspecialchars($ref['description']) ?></div>
                        <div class="trv"></div>
                        <div class="deux">
                            <img src="/assets/images/tr.png" alt="">
                            <div class="vap">
                                <?php if (isset($ref['nombre_apprenants'])): ?>
                                    <?= $ref['nombre_apprenants'] ?> apprenants
                                <?php elseif (isset($ref['capacite'])): ?>
                                    <?= $ref['capacite'] ?> apprenants
                                <?php else: ?>
                                    0 apprenants
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="sa"><img src="/assets/images/search.svg" alt=""></div>
</body>
</html>