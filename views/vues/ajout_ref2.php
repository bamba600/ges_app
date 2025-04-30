<!-- Fichier: views/vues/ajout_ref2.php -->
<div class="container mt-4">
    <h1 class="mb-4">Gestion des référentiels pour la promotion en cours</h1>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>

    <?php if ($promo_en_cours): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h2>Ajouter un référentiel à la promotion en cours</h2>
            </div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="ref_add">Sélectionnez un référentiel à ajouter</label>
                        <select class="form-control" id="ref_add" name="ref_add" <?php echo empty($referentiels_non_associes) ? 'disabled' : ''; ?>>
                            <?php if (empty($referentiels_non_associes)): ?>
                                <option>Tous les référentiels sont déjà associés</option>
                            <?php else: ?>
                                <?php foreach ($referentiels_non_associes as $ref): ?>
                                    <option value="<?php echo htmlspecialchars($ref['nom']); ?>"><?php echo htmlspecialchars($ref['nom']); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <input type="hidden" name="promo_add" value="<?php echo htmlspecialchars($promo_en_cours['nom']); ?>">
                    <input type="hidden" name="action" value="add">
                    <button type="submit" class="btn btn-primary" <?php echo empty($referentiels_non_associes) ? 'disabled' : ''; ?>>Ajouter à la promotion</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Retirer un référentiel de la promotion en cours</h2>
            </div>
            <div class="card-body">
                <?php if (isset($promo_en_cours['apprenants']) && count($promo_en_cours['apprenants']) > 0): ?>
                    <div class="alert alert-warning">
                        Attention: Vous ne pourrez retirer que les référentiels qui n'ont pas d'apprenants associés.
                    </div>
                <?php endif; ?>
                
                <form method="post" action="">
                    <div class="form-group">
                        <label for="ref_remove">Sélectionnez un référentiel à retirer</label>
                        <select class="form-control" id="ref_remove" name="ref_remove" <?php echo !isset($promo_en_cours['referentiels']) || empty($promo_en_cours['referentiels']) ? 'disabled' : ''; ?>>
                            <?php if (!isset($promo_en_cours['referentiels']) || empty($promo_en_cours['referentiels'])): ?>
                                <option>Aucun référentiel associé</option>
                            <?php else: ?>
                                <?php foreach ($promo_en_cours['referentiels'] as $ref_nom): ?>
                                    <option value="<?php echo htmlspecialchars($ref_nom); ?>"><?php echo htmlspecialchars($ref_nom); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <input type="hidden" name="promo_remove" value="<?php echo htmlspecialchars($promo_en_cours['nom']); ?>">
                    <input type="hidden" name="action" value="remove">
                    <button type="submit" class="btn btn-danger" <?php echo !isset($promo_en_cours['referentiels']) || empty($promo_en_cours['referentiels']) ? 'disabled' : ''; ?>>Retirer de la promotion</button>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            Aucune promotion en cours n'est disponible.
        </div>
    <?php endif; ?>
</div>