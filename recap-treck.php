<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récapitulatif de votre réservation</title>
    <link rel="stylesheet" href="trek-tunisie.css">
    <style>
        .recap-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .recap-item {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .recap-item strong {
            display: inline-block;
            width: 200px;
        }

        .total {
            font-size: 1.2em;
            font-weight: bold;
            color: #d35400;
            margin-top: 20px;
        }

        .confirmation-btn {
            display: inline-block;
            background-color: #27ae60;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="recap-container">
        <h1>Récapitulatif de votre réservation</h1>

        <?php
        // Vérification des données soumises
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération des données du formulaire
            $trek_type = isset($_POST['choix-trek']) ? $_POST['choix-trek'] : '';
            $date_depart = isset($_POST['date-depart']) ? $_POST['date-depart'] : '';
            $billet_avion = isset($_POST['billet']) ? $_POST['billet'] : '';
            $nb_personnes = isset($_POST['nb-personnes']) ? (int)$_POST['nb-personnes'] : 1;

            // Définition des prix
            $prix_trek = 0;
            $prix_billet = 0;

            switch ($trek_type) {
                case 'standard':
                    $prix_trek = 300;
                    $type_trek = "Trek standard (4 jours)";
                    break;
                case 'premium':
                    $prix_trek = 645;
                    $type_trek = "Trek premium avec guide privé";
                    break;
                case 'luxe':
                    $prix_trek = 750;
                    $type_trek = "Trek luxe avec campement tout confort";
                    break;
                default:
                    $prix_trek = 0;
                    $type_trek = "Non spécifié";
            }

            if ($billet_avion === 'avec_agence') {
                $prix_billet = 300;
                $option_billet = "Billet d'avion avec l'agence";
            } else {
                $prix_billet = 0;
                $option_billet = "Billet acheté indépendamment";
            }

            // Calcul du prix total
            $prix_total = ($prix_trek + $prix_billet) * $nb_personnes;

            // Affichage du récapitulatif
            echo '<div class="recap-item"><strong>Type de trek:</strong> ' . htmlspecialchars($type_trek) . '</div>';
            echo '<div class="recap-item"><strong>Date de départ:</strong> ' . htmlspecialchars($date_depart) . '</div>';
            echo '<div class="recap-item"><strong>Option billet d\'avion:</strong> ' . htmlspecialchars($option_billet) . '</div>';
            echo '<div class="recap-item"><strong>Nombre de personnes:</strong> ' . $nb_personnes . '</div>';
            echo '<div class="recap-item"><strong>Prix par personne:</strong> ' . ($prix_trek + $prix_billet) . '€</div>';
            echo '<div class="total">Prix total: ' . $prix_total . '€</div>';

            // Stockage dans un fichier CSV
            $csv_file = 'reservations.csv';
            $file_exists = file_exists($csv_file);

            $file = fopen($csv_file, 'a');

            // Si le fichier est vide, on ajoute l'en-tête
            if (!$file_exists || filesize($csv_file) == 0) {
                fputcsv($file, ['Type de trek', 'Date de départ', 'Option billet', 'Nombre de personnes', 'Prix total', 'Date de réservation']);
            }

            // Ajout des données
            fputcsv($file, [
                $type_trek,
                $date_depart,
                $option_billet,
                $nb_personnes,
                $prix_total,
                date('Y-m-d H:i:s')
            ]);

            fclose($file);

            // Bouton de confirmation
            echo '<a href="aventure.php" class="confirmation-btn">Confirmer la réservation</a>';
        } else {
            echo '<p>Aucune donnée de réservation reçue. Veuillez remplir le formulaire de réservation.</p>';
            echo '<a href="trek-maroc.php" class="btn">Retour au formulaire</a>';
        }
        ?>
    </div>
</body>

</html>