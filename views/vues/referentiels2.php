<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/style4.css">
    <title>Référentiels</title>
</head>
<body>
    <div class="div1">
        <a href="index?page=ref" class="dir">
            <img src="/assets/images/arrow.svg" alt="">
            <div>Retour aux référentiels actifs</div>
        </a>

        <div class="l">
            <div class="l1">Tous les Référentiels</div>
            <div>Liste complète des référentiels de formation</div>
        </div>

        <div class="refa2s">
            <form action="" method="get">
                <input type="text" name="search" placeholder="     Rechercher un référentiel..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <input type="hidden" name="page" value="ref2">
            </form>
            <a href="index.php?page=ajoutref" class="rim2s">+ Créer un référentiel</a>
        </div>

        <div class="grills">
            <?php if (count($referentiels) > 0): ?>
                <?php foreach ($referentiels as $ref): ?>
                    <div class="elts">
                        <img src="<?= htmlspecialchars($ref['photo']) ?>" alt="<?= htmlspecialchars($ref['nom']) ?>">
                        <div class="des"><?= htmlspecialchars($ref['nom']) ?></div>
                        <div><?= htmlspecialchars($ref['description']) ?></div>
                        <div class="trvs"></div>
                        <div>Capacité : <?= htmlspecialchars($ref['nombre_apprenants']) ?> places</div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun référentiel trouvé.</p>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="index?page=ref2&page_num=<?= $i ?>&search=<?= urlencode($search) ?>" class="<?= $i === $currentPage ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    </div>
    <div class="sas"><img src="/assets/images/search.svg" alt=""></div>
</body>
</html>
