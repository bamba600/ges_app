<?php
// Fichier : app/views/vues/ajt_appr.php
?>
<div class="apprenant-container">
    <div class="apprenant-card">
        <div class="apprenant-header">
            <h2>Ajout apprenant</h2>
        </div>
        <div class="apprenant-body">
            <?php if ($success): ?>
                <div class="alert alert-success" role="alert">
                    <strong>Succès!</strong> L'apprenant a été ajouté avec succès.
                    <?php if ($mailSent): ?>
                        Un email de confirmation a été envoyé à l'adresse indiquée.
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($errors['global'])): ?>
                <div class="alert alert-danger" role="alert">
                    <?= $errors['global'] ?>
                </div>
            <?php endif; ?>

            <?php if (isset($errors['mail'])): ?>
                <div class="alert alert-warning" role="alert">
                    <?= $errors['mail'] ?>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" class="apprenant-form">
                <div class="section-apprenant">
                    <div class="section-header">
                        <h3>Informations de l'apprenant</h3>
                    </div>

                    <div class="form-row">
                        <div class="form-group half">
                            <label for="prenom">Prénom(s)</label>
                            <input type="text" class="form-input <?= isset($errors['prenom']) ? 'is-invalid' : '' ?>"
                                id="prenom" name="prenom" value="<?= htmlspecialchars($prenom ?? '') ?>">
                            <?php if (isset($errors['prenom'])): ?>
                                <div class="invalid-feedback"><?= $errors['prenom'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group half">
                            <label for="nom">Nom</label>
                            <input type="text" class="form-input <?= isset($errors['nom']) ? 'is-invalid' : '' ?>"
                                id="nom" name="nom" value="<?= htmlspecialchars($nom ?? '') ?>">
                            <?php if (isset($errors['nom'])): ?>
                                <div class="invalid-feedback"><?= $errors['nom'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group half">
                            <label for="date_naissance">Date de naissance</label>
                            <input type="text" class="form-input <?= isset($errors['date_naissance']) ? 'is-invalid' : '' ?>"
                                id="date_naissance" name="date_naissance" value="<?= htmlspecialchars($date_naissance ?? '') ?>"
                                placeholder="AAAA-MM-JJ">
                            <?php if (isset($errors['date_naissance'])): ?>
                                <div class="invalid-feedback"><?= $errors['date_naissance'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group half">
                            <label for="lieu_naissance">Lieu de naissance</label>
                            <input type="text" class="form-input <?= isset($errors['lieu_naissance']) ? 'is-invalid' : '' ?>"
                                id="lieu_naissance" name="lieu_naissance" value="<?= htmlspecialchars($lieu_naissance ?? '') ?>">
                            <?php if (isset($errors['lieu_naissance'])): ?>
                                <div class="invalid-feedback"><?= $errors['lieu_naissance'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group half">
                            <label for="adresse">Adresse</label>
                            <input type="text" class="form-input <?= isset($errors['adresse']) ? 'is-invalid' : '' ?>"
                                id="adresse" name="adresse" value="<?= htmlspecialchars($adresse ?? '') ?>">
                            <?php if (isset($errors['adresse'])): ?>
                                <div class="invalid-feedback"><?= $errors['adresse'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group half">
                            <label for="email">Email</label>
                            <input type="email" class="form-input <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                                id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>">
                            <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback"><?= $errors['email'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group half">
                            <label for="telephone">Téléphone</label>
                            <input type="text" class="form-input <?= isset($errors['telephone']) ? 'is-invalid' : '' ?>"
                                id="telephone" name="telephone" value="<?= htmlspecialchars($telephone ?? '') ?>"
                                placeholder="+221 77 xxx xx xx">
                            <?php if (isset($errors['telephone'])): ?>
                                <div class="invalid-feedback"><?= $errors['telephone'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group half">
                            <label for="referentiel">Référentiel</label>
                            <select class="form-input <?= isset($errors['referentiel']) ? 'is-invalid' : '' ?>"
                                id="referentiel" name="referentiel">
                                <option value="">Sélectionner un référentiel</option>
                                <?php foreach ($referentiels as $ref): ?>
                                    <option value="<?= htmlspecialchars($ref) ?>"
                                        <?= isset($referentiel) && $referentiel === $ref ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($ref) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (isset($errors['referentiel'])): ?>
                                <div class="invalid-feedback"><?= $errors['referentiel'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-row document-upload">
                        <div class="form-group full">
                            <div class="document-upload-box">
                                <label for="photo" class="btn btn-document">
                                    <span class="document-icon"><i class="fas fa-file-upload"></i></span>
                                    Ajouter une photo
                                </label>
                                <input type="file" id="photo" name="photo" class="form-input" style="display: none;">
                            </div>
                            <?php if (isset($errors['photo'])): ?>
                                <div class="invalid-feedback"><?= $errors['photo'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="section-tuteur">
                    <div class="section-header">
                        <h3>Informations du tuteur</h3>
                    </div>

                    <div class="form-row">
                        <div class="form-group half">
                            <label for="tuteur_prenom_nom">Prénom(s) & nom</label>
                            <input type="text" class="form-input <?= isset($errors['tuteur_prenom_nom']) ? 'is-invalid' : '' ?>"
                                id="tuteur_prenom_nom" name="tuteur_prenom_nom" value="<?= htmlspecialchars($tuteur_prenom_nom ?? '') ?>">
                            <?php if (isset($errors['tuteur_prenom_nom'])): ?>
                                <div class="invalid-feedback"><?= $errors['tuteur_prenom_nom'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group half">
                            <label for="lien_parente">Lien de parenté</label>
                            <input type="text" class="form-input <?= isset($errors['lien_parente']) ? 'is-invalid' : '' ?>"
                                id="lien_parente" name="lien_parente" value="<?= htmlspecialchars($lien_parente ?? '') ?>">
                            <?php if (isset($errors['lien_parente'])): ?>
                                <div class="invalid-feedback"><?= $errors['lien_parente'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group half">
                            <label for="tuteur_adresse">Adresse</label>
                            <input type="text" class="form-input <?= isset($errors['tuteur_adresse']) ? 'is-invalid' : '' ?>"
                                id="tuteur_adresse" name="tuteur_adresse" value="<?= htmlspecialchars($tuteur_adresse ?? '') ?>">
                            <?php if (isset($errors['tuteur_adresse'])): ?>
                                <div class="invalid-feedback"><?= $errors['tuteur_adresse'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group half">
                            <label for="tuteur_telephone">Téléphone</label>
                            <input type="text" class="form-input <?= isset($errors['tuteur_telephone']) ? 'is-invalid' : '' ?>"
                                id="tuteur_telephone" name="tuteur_telephone" value="<?= htmlspecialchars($tuteur_telephone ?? '') ?>"
                                placeholder="+221 77 xxx xx xx">
                            <?php if (isset($errors['tuteur_telephone'])): ?>
                                <div class="invalid-feedback"><?= $errors['tuteur_telephone'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-cancel">Annuler</button>
                    <button type="submit" class="btn btn-save">Enregistrer</button>
                </div>
            </form>

            <!-- Lien de connexion -->
            <div class="connect-link">
                <a href="index.php?page=connect_detail">Se connecter</a>
            </div>
        </div>
    </div>
</div>
