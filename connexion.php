<?php
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $csvFile = "data/utilisateurs.csv"; // Chemin corrigé

    if (!file_exists($csvFile)) {
        $error = "Erreur système. Veuillez réessayer plus tard.";
    } else {
        $handle = fopen($csvFile, "r");
        if ($handle !== FALSE) {
            $loggedIn = false;

            // Passer la première ligne si c'est l'en-tête
            $isFirstLine = true;

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($isFirstLine) {
                    $isFirstLine = false;
                    continue;
                }

                if (count($data) >= 8) { // Vérification du nombre de colonnes
                    $csv_email = trim($data[3]);
                    $csv_password_hash = trim($data[4]);
                    $csv_role = trim($data[7] ?? 'user'); // Avec valeur par défaut

                    // Vérification sécurisée
                    if ($csv_email === $email && password_verify($password, $csv_password_hash)) {
                        $_SESSION["user"] = [
                            "id" => trim($data[0]),
                            "nom" => trim($data[1]),
                            "prenom" => trim($data[2]),
                            "email" => $csv_email,
                            "role" => $csv_role
                        ];
                        $loggedIn = true;
                        break;
                    }
                }
            }
            fclose($handle);

            if ($loggedIn) {
                // Redirection sécurisée
                $redirect = ($_SESSION["user"]["role"] === "admin") ? "admin.php" : "acceuil1.php";
                header("Location: " . $redirect);
                exit();
            } else {
                $error = "Identifiants incorrects";
            }
        } else {
            $error = "Erreur de lecture du fichier";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="connexion.css?v=<?php echo time(); ?>">
    <title>Connexion | Click-journeY</title>

</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Connexion</h1>

            <?php if (!empty($error)): ?>
                <div class="alert error">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
        </div>

        <form method="POST" class="login-form">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required
                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>

            <div class="input-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="options">
                <label class="remember-me">
                    <input type="checkbox" name="remember"> Se souvenir de moi
                </label>
                <a href="#" class="forgot-password">Mot de passe oublié ?</a>
            </div>

            <button type="submit" class="login-btn">Se connecter</button>
        </form>

        <div class="register-link">
            <p>Pas encore inscrit ? <a href="inscriptionV1.php">Créer un compte</a></p>
        </div>
    </div>

    <div class="bottom-links">
        <a href="acceuil1.php" class="home-link">Retour à l'accueil</a>
    </div>
</body>

</html>