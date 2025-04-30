
    <div class="form-container">
        <h2>Connexion</h2>

        <?php if (isset($_SESSION['error_general'])): ?>
            <div class="error-message">
                <?= htmlspecialchars($_SESSION['error_general']) ?>
                <?php unset($_SESSION['error_general']); ?> <!-- Supprimer le message d'erreur après affichage -->
            </div>
        <?php endif; ?>

        <form action="index.php?page=connect_detail" method="post">
            <div class="form-group">
                <label for="login">Identifiant ou Email :</label>
                <input type="text" name="login" id="login" value="<?= htmlspecialchars($_POST['login'] ?? '') ?>">
                <?php if (isset($_SESSION['error_login'])): ?>
                    <div class="error-message">
                        <?= htmlspecialchars($_SESSION['error_login']) ?>
                        <?php unset($_SESSION['error_login']); ?> <!-- Supprimer le message d'erreur après affichage -->
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" id="password">
                <?php if (isset($_SESSION['error_password'])): ?>
                    <div class="error-message">
                        <?= htmlspecialchars($_SESSION['error_password']) ?>
                        <?php unset($_SESSION['error_password']); ?> <!-- Supprimer le message d'erreur après affichage -->
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </div>

