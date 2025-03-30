<?php
// Démarre la session pour vérifier l'utilisateur connecté
session_start();

// Vérifie si l'utilisateur est connecté et si son rôle est admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    // Redirige l'utilisateur vers une autre page (par exemple, la page d'accueil ou la page de connexion)
    header("Location: acceuil1.php"); // ou connexion.php
    exit();
}

require_once 'config.php';

$users = [];

// Vérifie si le fichier CSV existe et le lit
if (file_exists(USER_CSV)) {
    $file = fopen(USER_CSV, 'r');
    $header = fgetcsv($file); // Récupère la première ligne (les titres des colonnes)

    while (($data = fgetcsv($file)) !== FALSE) {
        if (count($data) >= 5) { // Vérifie que les données sont complètes
            $users[] = [
                'id' => $data[0],
                'nom' => $data[1],
                'prenom' => $data[2],
                'email' => $data[3],
                'role' => $data[7]
            ];
        }
    }
    fclose($file);
}

// Suppression d'un utilisateur
if (isset($_GET['delete'])) {
    $emailToDelete = trim($_GET['delete']);
    $updatedUsers = [];

    $file = fopen(USER_CSV, 'r');
    $header = fgetcsv($file);
    while (($data = fgetcsv($file)) !== FALSE) {
        if (count($data) >= 5 && strtolower($data[3]) !== strtolower($emailToDelete)) {
            $updatedUsers[] = $data;
        }
    }
    fclose($file);

    // Réécriture du fichier CSV avec l'utilisateur supprimé
    $file = fopen(USER_CSV, 'w');
    fputcsv($file, $header); // Réécriture de l'en-tête
    foreach ($updatedUsers as $user) {
        fputcsv($file, $user);
    }
    fclose($file);

    header("Location: admin.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Administrateur</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #E8871E;
            --secondary: #2c3e50;
            --light: #f8f9fa;
            --danger: #dc3545;
            --success: #28a745;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .admin-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--secondary);
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
        }

        .admin-title {
            margin: 0;
            font-size: 24px;
        }

        .btn {
            padding: 10px 15px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            color: white;
        }

        .btn-danger {
            background: var(--danger);
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .btn-success {
            background: var(--success);
        }

        .btn-success:hover {
            background: #218838;
        }

        .table-container {
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: var(--light);
        }

        tr:hover {
            background-color: rgba(232, 135, 30, 0.1);
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-admin {
            background: var(--primary);
            color: white;
        }

        .badge-user {
            background: #6c757d;
            color: white;
        }
    </style>
</head>

<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1 class="admin-title">Tableau de bord Administrateur</h1>
            <a href="deconnexion.php" class="btn btn-danger">Déconnexion</a>
        </div>

        <div class="table-container">
            <h2>Liste des utilisateurs</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['nom']) ?></td>
                            <td><?= htmlspecialchars($user['prenom']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td>
                                <span class="badge badge-<?= $user['role'] === 'admin' ? 'admin' : 'user' ?>">
                                    <?= htmlspecialchars($user['role']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($user['role'] !== 'admin'): ?>
                                    <a href="?delete=<?= urlencode($user['email']) ?>"
                                        class="btn btn-danger"
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </a>
                                <?php else: ?>
                                    <span style="color:#999;">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="5" style="text-align:center; color: #999;">Aucun utilisateur inscrit</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>