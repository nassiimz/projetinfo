<?php
session_start();

// Debug activé
error_reporting(E_ALL);
ini_set('display_errors', 1);

$csvFile = "data/utilisateurs.csv";

// Création du dossier si inexistant
if (!file_exists('data')) {
    if (!mkdir('data', 0755, true)) {
        die("Erreur : Impossible de créer le dossier 'data'");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Validation requise
        $required = ['nom', 'prenom', 'email', 'password', 'password_confirm', 'date_naissance'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Le champ $field est requis");
            }
        }

        if ($_POST['password'] !== $_POST['password_confirm']) {
            throw new Exception("Les mots de passe ne correspondent pas");
        }

        // Vérification email
        if (file_exists($csvFile)) {
            $file = fopen($csvFile, 'r');
            while (($data = fgetcsv($file)) !== FALSE) {
                if (isset($data[3]) && strtolower($data[3]) === strtolower($_POST['email'])) {
                    throw new Exception("Cet email est déjà utilisé");
                }
            }
            fclose($file);
        }

        // Enregistrement
        $file = fopen($csvFile, 'a');
        if (!$file) {
            throw new Exception("Impossible d'ouvrir le fichier CSV");
        }

        $userData = [
            uniqid(),
            htmlspecialchars($_POST['nom']),
            htmlspecialchars($_POST['prenom']),
            $_POST['email'],
            password_hash($_POST['password'], PASSWORD_BCRYPT),
            $_POST['date_naissance'],
            date('Y-m-d H:i:s'),
            'user'
        ];

        fputcsv($file, $userData);
        fclose($file);

        // Connexion automatique
        $_SESSION['user'] = [
            'id' => $userData[0],
            'email' => $userData[3],
            'nom' => $userData[1],
            'prenom' => $userData[2],
            'role' => 'user'
        ];

        // Redirection VERIFIÉE
        header("Location: profil.php");
        exit();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<style>
    <?php include 'inscriptionv1.css'; ?>
</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>

    <link rel="stylesheet" href="inscriptionv1.css?v=<?= time() ?>">
</head>

<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Inscription</h1>
        </div>

        <div class="form-body">
            <?php if (!empty($error)): ?>
                <div class="alert error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="form-row double">
                    <div class="form-group">
                        <input type="text" name="nom" class="form-control" placeholder="Nom" required
                            value="<?= isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '' ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" name="prenom" class="form-control" placeholder="Prénom" required
                            value="<?= isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : '' ?>">
                    </div>
                </div>

                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" required
                        value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                </div>

                <div class="form-group">
                    <input type="password" name="password" class="form-control"
                        placeholder="Mot de passe (min. 8 caractères)" required>
                </div>

                <div class="form-group">
                    <input type="password" name="password_confirm" class="form-control"
                        placeholder="Confirmez le mot de passe" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Date de naissance</label>
                    <input type="date" name="date_naissance" class="form-control" required
                        value="<?= isset($_POST['date_naissance']) ? htmlspecialchars($_POST['date_naissance']) : '' ?>">
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
    </div>
</body>

</html>