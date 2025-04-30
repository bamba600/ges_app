<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Référentiel</title>
    <link rel="stylesheet" href="/assets/css/style6.css">
</head>
<body style="background-color: white;">
    <div class="f">
        <p>Créer un nouveau référentiel</p>
        <?php if (!empty($erreurs)) : ?>
            <ul style="color: red;">
                <?php foreach ($erreurs as $err) : ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form action="index.php?page=ajoutref" method="post" enctype="multipart/form-data">
            <div>
                <label for="photo">Photo (JPG/PNG, max 2MB)</label>
                <input type="file" name="photo" id="photo" accept=".jpg,.jpeg,.png">
            </div>

            <div>
                <label for="nom">Nom*</label>
                <input type="text" name="nom" id="nom" value="<?= $_POST['nom'] ?? '' ?>">
            </div>

            <div>
                <label for="description">Description*</label>
                <textarea name="description" id="description"><?= $_POST['description'] ?? '' ?></textarea>
            </div>

            <div>
                <label for="capacite">Capacité*</label>
                <input type="text" name="capacite" id="capacite" value="<?= $_POST['capacite'] ?? '' ?>">
            </div>

            <div>
                <label for="sessions">Nombre de sessions*</label>
                <input type="text" name="sessions" id="sessions" value="<?= $_POST['sessions'] ?? '' ?>">
            </div>

            <div class="buttons">
                <button type="submit" class="create">Créer</button>
                <a href="index.php?page=ref"><div class="cancel">Annuler</div></a>
            </div>
        </form>
    </div>
</body>
</html>
