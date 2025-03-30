<?php
// Activer la gestion des erreurs
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $email = strtolower(trim($_POST['email']));
        $password = $_POST['password'];

        if (!file_exists(USER_CSV)) {
            throw new Exception("Base utilisateurs non trouvée");
        }

        $file = fopen(USER_CSV, 'r');
        fgetcsv($file); // Ignorer l'en-tête

        while (($data = fgetcsv($file)) !== FALSE) {
            if (isset($data[3]) && strtolower(trim($data[3])) === $email) {
                if (password_verify($password, $data[4])) {
                    $_SESSION['user'] = [
                        'id' => $data[0],
                        'nom' => $data[1],
                        'prenom' => $data[2],
                        'email' => $data[3],
                        'role' => $data[7]
                    ];

                    fclose($file);
                    header("Location: profil.php");
                    exit();
                }
            }
        }
        fclose($file);
        throw new Exception("Identifiants incorrects");
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Connexion</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .error {
            color: #dc3545;
            margin: 10px 0;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #E8871E;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #c76b15;
        }

        .register-link {
            margin-top: 15px;
            display: block;
            color: #2c3e50;
            text-decoration: none;
        }

        .register-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Connexion</h2>
        <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>

        <form method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>
        <p style="text-align: center; margin-top: 20px;">
            Pas encore inscrit ? <a href="inscriptionV1.php" class="register-link">Créer un compte</a>
        </p>
    </div>
</body>

</html>