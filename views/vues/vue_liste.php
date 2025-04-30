<div class="parto">
    <div class="part1">
       <div class="pm">Promotion</div>
       <div class="nant"><?= $stats['nombre_apprenants'] ?>  apprenants</div>
    </div>
    <div class="slt0">
    <form method="GET" action="index.php" class="slt">
    <input type="hidden" name="page" value="proms2">
    <input type="text" placeholder="Rechercher..." name="search" id="search" value="<?= htmlspecialchars($search ?? '') ?>">
    
    <select name="referentiel" id="referentiel" onchange="this.form.submit()">
        <option value="">Tous les référentiels</option>
        <?php foreach ($referentiels as $ref): ?>
            <option value="<?= htmlspecialchars($ref['nom']) ?>" <?= ($referentiel_filter == $ref['nom']) ? 'selected' : '' ?>><?= htmlspecialchars($ref['nom']) ?></option>
        <?php endforeach; ?>
    </select>
    
    <select name="status" id="status" onchange="this.form.submit()">
        <option value="">Tous les statuts</option>
        <option value="active" <?= ($status_filter == 'active') ? 'selected' : '' ?>>Active</option>
        <option value="inactive" <?= ($status_filter == 'inactive') ? 'selected' : '' ?>>Inactive</option>
    </select>
</form>

          <a href=""  class="aj"><img src="/assets/images/add.svg" alt="" srcset=""><div class="ajt">+  Ajouter une promotion</div></a>
    </div>
    <div class="or">
       <div class="or1">
            <div class="rd6">
                  <img src="/assets/images/grad.svg" alt="" srcset="">  
            </div>
            <div class="rd1">
                <div class="cts">180</div>
                <div>Apprenants</div>
            </div>
       </div>
       <div class="or1">
            <div class="rd6">
                  <img src="/assets/images/fold.svg" alt="" srcset="">  
            </div>
            <div class="rd1">
                <div class="cts">5</div>
                <div>Référentiels</div>
            </div>
       </div>
       <div class="or1">
            <div class="rd6">
                  <img src="/assets/images/cube.svg" alt="" srcset="">  
            </div>
            <div class="rd1">
                <div class="cts">5</div>
                <div>Stagiaires</div>
            </div>
       </div>
       <div class="or1">
            <div class="rd6">
                  <img src="/assets/images/grad.svg" alt="" srcset="">  
            </div>
            <div class="rd1">
                <div class="cts">13</div>
                <div>Permanant</div>
            </div>
       </div>
       
    </div>
    <table>
        <thead>
            <tr>
                <th>Photo</th>
                <th>Promotion</th>
                <th>Date de début</th>
                <th>Date de fin</th>
                <th>Référentiel</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
    <?php if ($active_promotion && ($status_filter == '' || $status_filter == 'active')): ?>
    <tr>
        <td class="photo-cell">
            <img src="<?= htmlspecialchars($active_promotion['photo']) ?>" class="avatar" alt="Photo">
        </td>
        <td><?= htmlspecialchars($active_promotion['nom']) ?></td>
        <td><?= $active_promotion['date_debut_formatted'] ?></td>
        <td><?= $active_promotion['date_fin_formatted'] ?></td>
        <td>
            <?php foreach ($active_promotion['referentiels'] as $referentiel): ?>
                <span class="tech-badge tech-web"><?= htmlspecialchars($referentiel) ?></span>
            <?php endforeach; ?>
        </td>
        <td>
            <span class="badge badge-active">
                 Active
            </span>
        </td>
        <td class="actions">
            <div class="dropdown">
                <span class="action-menu">•••</span>
            </div>
        </td>
    </tr>
    <?php endif; ?>

    <?php foreach ($pagination_data['promotions'] as $promotion): ?>
    <tr>
        <td class="photo-cell">
            <img src="<?= htmlspecialchars($promotion['photo']) ?>" class="avatar" alt="Photo">
        </td>
        <td><?= htmlspecialchars($promotion['nom']) ?></td>
        <td><?= $promotion['date_debut_formatted'] ?></td>
        <td><?= $promotion['date_fin_formatted'] ?></td>
        <td>
            <?php foreach ($promotion['referentiels'] as $referentiel): ?>
                <span class="tech-badge tech-web"><?= htmlspecialchars($referentiel) ?></span>
            <?php endforeach; ?>
        </td>
        <td>
            <span class="badge badge-inactive">
                 Inactive
            </span>
        </td>
        <td class="actions">
            <div class="dropdown">
                <span class="action-menu">•••</span>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>

    </table>
    
    <!-- ... -->

<div class="pagination-controls">
    <!-- Bouton précédent -->
<a href="index.php?page=proms2&p=<?= max(1, $current_page - 1) ?>&search=<?= urlencode($search) ?>&referentiel=<?= urlencode($referentiel_filter) ?>&status=<?= urlencode($status_filter) ?>">
    <button class="page-btn">❮</button>
</a>

<!-- Numéros de pages -->
<?php for ($i = 1; $i <= $total_pages; $i++): ?>
    <a href="index.php?page=proms2&p=<?= $i ?>&search=<?= urlencode($search) ?>&referentiel=<?= urlencode($referentiel_filter) ?>&status=<?= urlencode($status_filter) ?>">
        <button class="page-btn <?= $i == $current_page ? 'active' : '' ?>"><?= $i ?></button>
    </a>
<?php endfor; ?>

<!-- Bouton suivant -->
<a href="index.php?page=proms2&p=<?= min($total_pages, $current_page + 1) ?>&search=<?= urlencode($search) ?>&referentiel=<?= urlencode($referentiel_filter) ?>&status=<?= urlencode($status_filter) ?>">
    <button class="page-btn">❯</button>
</a>

</div>
</div>