<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mot de passe oublié</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 80px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        p {
            color: red;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 15px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            margin-top: 20px;
            padding: 10px;
            background-color: orange;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background-color: darkorange;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Mot de passe oublié</h2>
        <p><?= $message ?></p>

        <?php if (!$showPasswordChangeForm): ?>
            <form method="POST" action="index.php?page=mdp_oublie">
                <label for="login">Nom d'utilisateur :</label>
                <input type="text" name="login" id="login" required value="<?= htmlspecialchars($login) ?>">
                <button type="submit">Valider</button>
            </form>
        <?php else: ?>
            <form method="POST" action="index.php?page=mdp_oublie">
                <input type="hidden" name="login" value="<?= htmlspecialchars($login) ?>">

                <label for="new_password">Nouveau mot de passe :</label>
                <input type="password" name="new_password" id="new_password" required>

                <label for="confirm_password">Confirmer le mot de passe :</label>
                <input type="password" name="confirm_password" id="confirm_password" required>

                <button type="submit">Changer le mot de passe</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
