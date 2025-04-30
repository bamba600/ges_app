<!-- app/views/vues/changer_pass.php -->
<
    <div class="form-container">
        <h2>Changer votre mot de passe</h2>

        <?php if (isset($_SESSION['error_general'])): ?>
            <div class="error-message">
                <?= htmlspecialchars($_SESSION['error_general']) ?>
                <?php unset($_SESSION['error_general']); ?> <!-- Supprimer le message d'erreur après affichage -->
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="success-message">
                <?= htmlspecialchars($_GET['success']) ?>
            </div>
        <?php endif; ?>

        <form action="index.php?page=changer_pass" method="post">
            <div class="form-group">
                <label for="password">Nouveau mot de passe :</label>
                <input type="password" name="password" id="password">
                <?php if (isset($_SESSION['error_password'])): ?>
                    <div class="error-message">
                        <?= htmlspecialchars($_SESSION['error_password']) ?>
                        <?php unset($_SESSION['error_password']); ?> <!-- Supprimer le message d'erreur après affichage -->
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirmer le mot de passe :</label>
                <input type="password" name="confirm_password" id="confirm_password">
                <?php if (isset($_SESSION['error_confirm_password'])): ?>
                    <div class="error-message">
                        <?= htmlspecialchars($_SESSION['error_confirm_password']) ?>
                        <?php unset($_SESSION['error_confirm_password']); ?> <!-- Supprimer le message d'erreur après affichage -->
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">Changer le mot de passe</button>
        </form>
    </div>

