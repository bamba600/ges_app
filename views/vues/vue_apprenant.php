<?php
// views/vues/vue_apprenant.php
// Les variables $apprenants, $referentiels et $total_apprenants sont passées depuis le contrôleur
?>

<div class="container">
    <div class="header">
        <h1 class="title">Apprenants</h1>
        <span class="count-badge"><?= $total_apprenants ?> apprenants</span>
    </div>
    
    <form id="searchForm" action="" method="GET">
        <input type="hidden" name="page" value="appr">
        <input type="hidden" name="page_num" value="1">
        
        <div class="search-bar">
            <div class="search-filters">
                <div class="search-input">
                    <input type="text" name="search" placeholder="Rechercher..." value="<?= htmlspecialchars($searchTerm ?? '') ?>">
                </div>
                <select class="filter-select" name="referentiel" onchange="this.form.submit()">
                    <option value="">Filtre par référentiel</option>
                    <?php if (!empty($referentiels)): ?>
                        <?php foreach ($referentiels as $referentiel): ?>
                            <option value="<?= htmlspecialchars($referentiel['nom']) ?>" <?= ($referentielFilter == $referentiel['nom']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($referentiel['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <select class="filter-select" name="statut" onchange="this.form.submit()">
                    <option value="">Filtre par status</option>
                    <option value="actif" <?= ($statutFilter == 'actif') ? 'selected' : '' ?>>Actif</option>
                    <option value="remplacé" <?= ($statutFilter == 'remplacé') ? 'selected' : '' ?>>Remplacé</option>
                </select>
            </div>
            
            <div class="action-buttons">
                <button type="button" class="btn2 btn-download2">
                    <svg class="btn-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    Télécharger la liste
                </button>
                <a href="index.php?page=ajt">
                    <button type="button" class="btn2 btn-add2">
                    <svg class="btn-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                        Ajouter apprenant
                    </button>
                </a>
            </div>
        </div>
    </form>
    
    <div class="tabs">
        <div class="tab active">Liste des retenus</div>
        <div class="tab">Liste d'attente</div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Photo</th>
                <th>Matricule</th>
                <th>Nom Complet</th>
                <th>Adresse</th>
                <th>Téléphone</th>
                <th>Référentiel</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($apprenants)): ?>
                <?php foreach ($apprenants as $apprenant): ?>
                    <tr>
                        <td><img src="<?= htmlspecialchars($apprenant['photo'] ?? 'assets/img/default-avatar.png') ?>" class="avatar" alt="Photo"></td>
                        <td><?= htmlspecialchars($apprenant['matricule']) ?></td>
                        <td><?= htmlspecialchars($apprenant['prenom']) . ' ' . htmlspecialchars($apprenant['nom']) ?></td>
                        <td><?= htmlspecialchars($apprenant['adresse']) ?></td>
                        <td><?= htmlspecialchars($apprenant['telephone']) ?></td>
                        <td><span class="referentiel-badge ref-<?= strtolower(str_replace(' ', '-', $apprenant['referentiel'])) ?>"><?= htmlspecialchars($apprenant['referentiel']) ?></span></td>
                        <td><span class="badge badge-<?= strtolower($apprenant['statut']) ?>"><?= ucfirst(htmlspecialchars($apprenant['statut'])) ?></span></td>
                        <td>
                            <a href="?page=appr&action=edit&matricule=<?= $apprenant['matricule'] ?>">Détails</a>
                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align: center;">Aucun apprenant trouvé</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <div class="pagination">
        <div class="page-info">
            <span>Apprenants/page:</span>
            <form method="GET" style="display:inline;">
                <input type="hidden" name="page" value="appr">
                <input type="hidden" name="search" value="<?= htmlspecialchars($searchTerm ?? '') ?>">
                <input type="hidden" name="referentiel" value="<?= htmlspecialchars($referentielFilter ?? '') ?>">
                <input type="hidden" name="statut" value="<?= htmlspecialchars($statutFilter ?? '') ?>">
                <select name="per_page" onchange="this.form.submit()" style="width: 60px; padding: 5px;">
                    <option value="10" <?= ($perPage == 10) ? 'selected' : '' ?>>10</option>
                    <option value="20" <?= ($perPage == 20) ? 'selected' : '' ?>>20</option>
                    <option value="50" <?= ($perPage == 50) ? 'selected' : '' ?>>50</option>
                </select>
            </form>
        </div>
        
        <div class="pagination-info">
            <?php 
            if ($total_apprenants > 0) {
                echo "$pageStart à $pageEnd apprenants sur $total_apprenants";
            } else {
                echo "0 apprenant";
            }
            ?>
        </div>
        
        <div class="pagination-controls">
            <?php if ($page > 1): ?>
                <a href="?page=appr&page_num=<?= $page-1 ?>&search=<?= urlencode($searchTerm ?? '') ?>&referentiel=<?= urlencode($referentielFilter ?? '') ?>&statut=<?= urlencode($statutFilter ?? '') ?>&per_page=<?= $perPage ?>" class="page-btn">❮</a>
            <?php else: ?>
                <span class="page-btn disabled">❮</span>
            <?php endif; ?>
            
            <?php
            // Affichage des liens de pagination
            $startPage = max(1, min($page - 2, $totalPages - 4));
            $endPage = min($totalPages, max(5, $page + 2));
            
            for ($i = $startPage; $i <= $endPage; $i++):
                $activeClass = ($i == $page) ? 'active' : '';
            ?>
                <a href="?page=appr&page_num=<?= $i ?>&search=<?= urlencode($searchTerm ?? '') ?>&referentiel=<?= urlencode($referentielFilter ?? '') ?>&statut=<?= urlencode($statutFilter ?? '') ?>&per_page=<?= $perPage ?>" class="page-btn <?= $activeClass ?>"><?= $i ?></a>
            <?php endfor; ?>
            
            <?php if ($page < $totalPages): ?>
                <a href="?page=appr&page_num=<?= $page+1 ?>&search=<?= urlencode($searchTerm ?? '') ?>&referentiel=<?= urlencode($referentielFilter ?? '') ?>&statut=<?= urlencode($statutFilter ?? '') ?>&per_page=<?= $perPage ?>" class="page-btn">❯</a>
            <?php else: ?>
                <span class="page-btn disabled">❯</span>
            <?php endif; ?>
        </div>
    </div>
</div>