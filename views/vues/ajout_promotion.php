<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/style5.css">
    <title>Ajout de promotion</title>
</head>
<body>
<div class="form_container">
    <h1>Créer une nouvelle promotion</h1>
    <p>Remplissez les informations ci-dessous pour créer une nouvelle promotion</p>
    
    <?php if ($succes) : ?>
        <div class="success">Promotion ajoutée avec succès !</div>
    <?php endif; ?>
    
    <form action="index.php?page=ajoutpromo" method="post" enctype="multipart/form-data">
        <div class="nia">
            <label for="nom">Nom de la promotion</label>
            <input type="text" name="nom" id="nom" value="<?= isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '' ?>">
            <?php if (isset($erreurs['nom'])) : ?>
                <span class="error-message"><?= htmlspecialchars($erreurs['nom']) ?></span>
            <?php endif; ?>
        </div>
        
        <div class="dat">
            <div>
                <label for="date_debut">Date de début</label>
                <input type="text" name="date_debut" id="date_debut" placeholder="JJ/MM/AAAA" value="<?= isset($_POST['date_debut']) ? htmlspecialchars($_POST['date_debut']) : '' ?>">
                <?php if (isset($erreurs['date_debut'])) : ?>
                    <span class="error-message"><?= htmlspecialchars($erreurs['date_debut']) ?></span>
                <?php endif; ?>
            </div>
            <div>
                <label for="date_fin">Date de fin</label>
                <input type="text" name="date_fin" id="date_fin" placeholder="JJ/MM/AAAA" value="<?= isset($_POST['date_fin']) ? htmlspecialchars($_POST['date_fin']) : '' ?>">
                <?php if (isset($erreurs['date_fin'])) : ?>
                    <span class="error-message"><?= htmlspecialchars($erreurs['date_fin']) ?></span>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="phot">
            <label for="photo">Photo de la promotion</label>
            <div class="phot1">
                <input type="file" name="photo" id="photo">
                <p>Format JPG, PNG, Taille max 2MB</p>
                <?php if (isset($erreurs['photo'])) : ?>
                    <span class="error-message"><?= htmlspecialchars($erreurs['photo']) ?></span>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="refl">
            <label>Référentiel :</label>
            <?php foreach ($referentielsActifs as $ref) : ?>
                <div class="checkbox_group">
                    <input type="checkbox" name="referentiels[]" value="<?= htmlspecialchars($ref) ?>" id="<?= htmlspecialchars($ref) ?>" <?= isset($_POST['referentiels']) && in_array($ref, $_POST['referentiels']) ? 'checked' : '' ?>>
                    <label for="<?= htmlspecialchars($ref) ?>"><?= htmlspecialchars($ref) ?></label>
                </div>
            <?php endforeach; ?>
            <?php if (isset($erreurs['referentiels'])) : ?>
                <span class="error-message"><?= htmlspecialchars($erreurs['referentiels']) ?></span>
            <?php endif; ?>
        </div>
        
        <div class="bton">
            <button type="submit" class="cr">Créer la promotion</button>
        </div>
    </form>
</div>
</body>
</html>