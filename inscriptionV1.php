<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Validation des champs requis
        $required = ['nom', 'prenom', 'email', 'password', 'password_confirm', 'date_naissance', 'conditions'];
        foreach ($required as $field) {
            if (empty(trim($_POST[$field]))) {
                throw new Exception("Le champ " . ucfirst($field) . " est requis");
            }
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email invalide");
        }

        if ($_POST['password'] !== $_POST['password_confirm']) {
            throw new Exception("Les mots de passe ne correspondent pas");
        }

        if (strlen($_POST['password']) < 8) {
            throw new Exception("Le mot de passe doit contenir au moins 8 caractères");
        }

        // Vérification et création du fichier CSV si inexistant
        if (!file_exists(USER_CSV)) {
            $file = fopen(USER_CSV, 'w');
            fputcsv($file, CSV_HEADER);
            fclose($file);
            chmod(USER_CSV, 0666); // Permissions en écriture
        }

        // Vérification si l'email existe déjà
        $file = fopen(USER_CSV, 'r');
        while (($data = fgetcsv($file)) !== FALSE) {
            if (isset($data[3]) && strtolower(trim($data[3])) === strtolower(trim($_POST['email']))) {
                fclose($file);
                throw new Exception("Cet email est déjà utilisé");
            }
        }
        fclose($file);

        // Préparation des données utilisateur
        $userData = [
            uniqid(),
            htmlspecialchars(trim($_POST['nom']), ENT_QUOTES),
            htmlspecialchars(trim($_POST['prenom']), ENT_QUOTES),
            strtolower(trim($_POST['email'])),
            password_hash(trim($_POST['password']), PASSWORD_BCRYPT),
            $_POST['date_naissance'],
            date('Y-m-d H:i:s'),
            in_array(strtolower($_POST['email']), ADMIN_EMAILS) ? 'admin' : 'user'
        ];

        // Ajout de l'utilisateur dans le fichier CSV
        $file = fopen(USER_CSV, 'a');
        if (fputcsv($file, $userData) === false) {
            throw new Exception("Erreur lors de l'écriture dans le fichier");
        }
        fclose($file);

        // Connexion automatique après l'inscription
        $_SESSION['user'] = [
            'id' => $userData[0],
            'nom' => $userData[1],
            'prenom' => $userData[2],
            'email' => $userData[3],
            'role' => $userData[7]
        ];

        header("Location: profil.php");
        exit();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .form-header h1 {
            color: #E8871E;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-row.double {
            display: flex;
            gap: 15px;
        }

        .form-row.double .form-group {
            flex: 1;
        }

        .checkbox-container {
            margin: 20px 0;
            display: flex;
            align-items: center;
        }

        .checkbox-container input {
            margin-right: 10px;
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background: #E8871E;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .submit-btn:hover {
            background: #d67a1a;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: #E8871E;
            text-decoration: none;
        }

        .alert.error {
            color: #d32f2f;
            background: #ffebee;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Inscription</h1>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" class="form-body">
            <div class="form-row double">
                <div class="form-group">
                    <label class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control" required
                        value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Prénom</label>
                    <input type="text" name="prenom" class="form-control" required
                        value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>

            <div class="form-row double">
                <div class="form-group">
                    <label class="form-label">Mot de passe (8 caractères min)</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Confirmation</label>
                    <input type="password" name="password_confirm" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Date de naissance</label>
                <input type="date" name="date_naissance" class="form-control" required
                    value="<?= htmlspecialchars($_POST['date_naissance'] ?? '') ?>">
            </div>

            <div class="checkbox-container">
                <input type="checkbox" id="conditions" name="conditions" required>
                <label for="conditions">J'accepte les conditions d'utilisation</label>
            </div>

            <button type="submit" class="submit-btn">S'INSCRIRE</button>
        </form>

        <div class="login-link">
            Déjà inscrit ? <a href="connexion.php">Connectez-vous</a>
        </div>
    </div>
</body>

</html>