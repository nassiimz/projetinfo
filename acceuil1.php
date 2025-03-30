<?php
// Démarre la session en haut de ton fichier
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alabasta Trek - Agence de Voyage</title>
  <link rel="stylesheet" href="acceuil.css">
  <style>
    /* Ajout d'un style personnalisé pour la bienvenue */
    .welcome-message {
      font-size: 28px;
      font-weight: bold;
      color: #E8871E;
      /* Couleur principale de ton projet */
      text-align: center;
      margin-top: 50px;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .welcome-container {
      background-color: rgba(255, 255, 255, 0.8);
      padding: 20px;
      border-radius: 10px;
      max-width: 500px;
      margin: 0 auto;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .welcome-message span {
      font-size: 32px;
      font-weight: 700;
      color: var(--primary);
      /* Couleur principale de ton projet */
    }

    .logout-link {
      display: block;
      text-align: center;
      color: var(--primary);
      font-size: 16px;
      text-decoration: none;
      padding: 10px;
      margin-top: 20px;
      border: 2px solid var(--primary);
      border-radius: 25px;
      transition: background-color 0.3s;
    }

    .logout-link:hover {
      background-color: var(--primary);
      color: white;
    }
  </style>
</head>

<body>

  <nav class="barre-navigation">
    <ul class="lien-navigation">
      <img src="logo2.webp" class="logoRA">
      <li><a href="presentation.php" align="left"> Rajjel Agency </a></li>
    </ul>
    <input class="input" placeholder="Rechercher" type="search" value="">
    <a href="connexion.php" class="inscription">Connexion</a>
    <div class="user-menu">
      <a href="profil.php">
        <img src="usericon.jpg" alt="Profil utilisateur" class="user-icon">
      </a>
    </div>
  </nav>

  <div class="fond">
    <div class="fond-titre">
      <h1 class="titre">Alabasta Trek</h1>
      <p class="sous-titre">Découvrez l'aventure unique à travers les dunes du Sahara.</p>
      <a href="aventure.php" class="btn">Découvrez nos aventures</a>
    </div>
  </div>

  <?php
  // Vérifie si l'utilisateur est connecté avant d'afficher les informations de bienvenue
  if (isset($_SESSION['user']) && isset($_SESSION['user']['prenom'])):
  ?>
    <div class="welcome-container">
      <h2 class="welcome-message">Bienvenue, <span><?php echo htmlspecialchars($_SESSION["user"]["prenom"]); ?></span> !</h2>
      <p class="welcome-subtitle">Nous sommes heureux de vous retrouver pour une nouvelle aventure.</p>
      <a href="deconnexion.php" class="logout-link">Déconnexion</a>
    </div>
  <?php
  else:
  ?>
    <div class="welcome-container">
      <h2 class="welcome-message">Accès refusé</h2>
      <p class="welcome-subtitle">Veuillez vous connecter pour accéder à cette page.</p>
      <a href="connexion.php" class="logout-link">Se connecter</a>
    </div>
  <?php endif; ?>

  <footer align="center">
    <div class="footer-container">
      <p>&copy; 2025 Rajjel Agency. Tous droits réservés.</p>
      <nav>
        <ul>
          <li><a href="presentation.php">Cliquez ici pour suivre notre présentation ou sur "Rajjel agency" en haut à gauche</a></li>
          <li>---------</li>
          <li><a href="/contact">Contact</a></li>
        </ul>
      </nav>
    </div>
    <a href="admin.php" class="btn">Page administrateur</a>
  </footer>

</body>

</html>