<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promotions</title>
    <link rel="stylesheet" href="/assets/css/style1.css">
</head>
<body>
    <div class="a">
        <div class="b">
            <div class="d">
                <div class="po">Promotion</div>
                <div>Gérer les promotions de l'école</div>
            </div>
            <div>
               <!-- Bouton pour ouvrir la modale -->
              <a href="index.php?page=ajoutpromo" class="bt">+ Ajouter une promotion</a>
            </div>
        </div>

        <div class="tb">
            <div class="tb1">
                <div class="car">
                    <div class="z"><?= $nombre_apprenants ?></div>
                    <div>Apprenants</div>
                </div>
                <div class="r">
                    <img src="/assets/images/a.png" alt="">
                </div>
            </div>

            <div class="tb1">
                <div class="car">
                    <div class="z"><?= $nombre_referentiel ?></div>
                    <div>Référentiels</div>
                </div>
                <div class="r">
                    <img src="/assets/images/b.png" alt="">
                </div>
            </div>

            <div class="tb1">
                <div class="car">
                    <div class="z"><?= $promotion_active_count ?></div>
                    <div>Promotions Actives</div>
                </div>
                <div class="r">
                    <img src="/assets/images/c.png" alt="">
                </div>
            </div>

            <div class="tb1">
                <div class="car">
                    <div class="z"><?= $promotion_total_count ?></div>
                    <div>Promotions Totales</div>
                </div>
                <div class="r">
                    <img src="/assets/images/d.png" alt="">
                </div>
            </div>
        </div>

        <div class="divs">
            <form action="index.php" method="GET">
                <input type="hidden" name="page" value="proms1">
                
                <input 
                    type="text" 
                    name="search" 
                    placeholder="    Rechercher une promotion..." 
                    value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"
                >
                
                <select name="select" id="pays">
                    <option value="tous" <?= (!isset($_GET['select']) || $_GET['select'] === 'tous') ? 'selected' : '' ?>>Tous</option>
                    <!-- Autres options ici si nécessaire -->
                </select>
                
                <button type="submit" style="visibility: hidden; position: absolute;"></button> <!-- bouton invisible -->
            </form>

            <a href="index.php?page=proms1" class="as"><div>grille</div></a>
            <a href="index.php?page=proms2" class="as1"><div>liste</div></a>
        </div>

        <!-- GRILLE DES PROMOTIONS -->
        <div class="grills2">
            <?php foreach ($promotions_paginated as $promo) : ?>
                <div class="gr">
                    <div class="fl1">
                        <a href="#" class="ins <?= $promo['active'] ? 'in' : 'int' ?>">
                            <?= $promo['active'] ? "Active" : "Inactive" ?>
                        </a>
                        <a href="index.php?page=activ&nom=<?= urlencode($promo['nom']) ?>" class="ints <?= $promo['active'] ? 'int' : 'in' ?>">
                            <svg class="svg1" xmlns="http://www.w3.org/2000/svg" width="4" height="4" viewBox="0 0 16 16">
                                <path fill="#000" d="M10 2.29v2.124c.566.247 1.086.6 1.536 1.05C12.48 6.408 13 7.664 13 9s-.52 2.591-1.464 3.536S9.336 14 8 14s-2.591-.52-3.536-1.464S3 10.336 3 9s.52-2.591 1.464-3.536c.45-.45.97-.803 1.536-1.05V2.29a7 7 0 1 0 4 0M7 0h2v8H7z"/>
                            </svg>
                        </a>
                    </div>
                    <div class="fl2">
                        <img class="im1s" src="<?= htmlspecialchars($promo['photo']) ?>" alt="">
                        <div class="txt">
                            <div class="txt1"><?= htmlspecialchars($promo['nom']) ?></div>
                            <div class="txt2">
                                <svg class="svg2" xmlns="http://www.w3.org/2000/svg" width="4" height="4" viewBox="0 0 24 24">
                                    <path fill="#b6bcbe" d="M19 4h-2V3a1 1 0 0 0-2 0v1H9V3a1 1 0 0 0-2 0v1H5a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3m1 15a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-7h16Zm0-9H4V7a1 1 0 0 1 1-1h2v1a1 1 0 0 0 2 0V6h6v1a1 1 0 0 0 2 0V6h2a1 1 0 0 1 1 1Z"/>
                                </svg>
                                <div class="dt"><?= htmlspecialchars($promo['date_debut']) ?> - <?= htmlspecialchars($promo['date_fin']) ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="apr">
                        <svg xmlns="http://www.w3.org/2000/svg" class="svg3" width="4" height="4" viewBox="0 0 24 24">
                            <circle cx="9" cy="8.5" r="1.5" fill="#a29c9c" opacity="0.15"/>
                            <path fill="#a29c9c" d="M4.34 17h9.32c-.84-.58-2.87-1.25-4.66-1.25s-3.82.67-4.66 1.25"/>
                            <path fill="#a29c9c" d="M9 12c1.93 0 3.5-1.57 3.5-3.5S10.93 5 9 5S5.5 6.57 5.5 8.5S7.07 12 9 12m0-5c.83 0 1.5.67 1.5 1.5S9.83 10 9 10s-1.5-.67-1.5-1.5S8.17 7 9 7m0 6.75c-2.34 0-7 1.17-7 3.5V19h14v-1.75c0-2.33-4.66-3.5-7-3.5M4.34 17c.84-.58 2.87-1.25 4.66-1.25s3.82.67 4.66 1.25zm11.7-3.19c1.16.84 1.96 1.96 1.96 3.44V19h4v-1.75c0-2.02-3.5-3.17-5.96-3.44M15 12c1.93 0 3.5-1.57 3.5-3.5S16.93 5 15 5c-.54 0-1.04.13-1.5.35c.63.89 1 1.98 1 3.15s-.37 2.26-1 3.15c.46.22.96.35 1.5.35"/>
                        </svg>
                        <div><?= $promo['nombre_apprenants'] ?> apprenant<?= $promo['nombre_apprenants'] > 1 ? 's' : '' ?></div>
                    </div>
                    <div class="trx1"></div>
                    <a href="#" class="det">Voir détails ></a>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="pagination">
            <?php if ($current_page > 1) : ?>
                <a class="page-link" href="?page=proms1&page_num=<?= $current_page - 1 ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?>">&laquo; Précédent</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                <a class="page-link <?= $i === $current_page ? 'active' : '' ?>" href="?page=proms1&page_num=<?= $i ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($current_page < $total_pages) : ?>
                <a class="page-link" href="?page=proms1&page_num=<?= $current_page + 1 ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?>">Suivant &raquo;</a>
            <?php endif; ?>
        </div>
    </div>
    <div class=""><img src="/assets/images/search.svg" alt=""></div>
</body>
</html>