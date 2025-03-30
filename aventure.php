<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Aventures Désertiques</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <style>
        /* CSS intégré */
        body,
        html {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            height: 100%;
            overflow-x: hidden;
        }

        /* Fond flouté */
        .background-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .background-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: blur(4px) brightness(0.8);
            transform: scale(1.02);
        }

        .titre-principal {
            font-size: 2.8rem;
            margin: 50px 0 30px;
            color: #E8871E;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.6);
            padding: 20px;
            font-weight: 600;
        }

        .treks {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            padding: 20px 5%;
            max-width: 1400px;
            margin: 0 auto;
        }

        .trek-card {
            background: rgba(10, 10, 10, 0.6);
            /* Noir plus transparent */
            backdrop-filter: blur(8px);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.4);
            text-align: center;
            width: 280px;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #E8871E;
            /* Orange comme demandé */
            border: 1px solid rgba(232, 135, 30, 0.3);
        }

        .trek-card:hover {
            transform: translateY(-8px);
            background: rgba(20, 20, 20, 0.7);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            border-color: rgba(232, 135, 30, 0.6);
        }

        .trek-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid rgba(232, 135, 30, 0.2);
            transition: transform 0.3s ease;
        }

        .trek-card:hover .trek-img {
            transform: scale(1.03);
        }

        .flag-img {
            width: 30px;
            height: 20px;
            margin: 12px 0;
            border-radius: 3px;
            border: 1px solid #E8871E;
        }

        .titre-trek {
            font-size: 1.4rem;
            margin: 10px 0;
            color: #E8871E;
            font-weight: 500;
        }

        .trek-description {
            font-size: 0.9rem;
            color: rgba(232, 135, 30, 0.9);
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .btn1 {
            display: inline-block;
            margin: 40px auto;
            padding: 12px 30px;
            font-size: 1rem;
            color: #FFF;
            background: rgba(232, 135, 30, 0.8);
            border-radius: 25px;
            text-decoration: none;
            transition: all 0.3s;
            border: 1px solid rgba(232, 135, 30, 0.5);
        }

        .btn1:hover {
            background: rgba(232, 135, 30, 0.9);
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(232, 135, 30, 0.3);
        }

        @media (max-width: 768px) {
            .titre-principal {
                font-size: 2rem;
                margin: 30px 15px;
            }

            .treks {
                flex-direction: column;
                align-items: center;
                padding: 15px;
                gap: 20px;
            }

            .trek-card {
                width: 90%;
            }
        }
    </style>
</head>

<body>
    <!-- Fond d'écran -->
    <div class="background-container">
        <img src="https://images.unsplash.com/photo-1509316785289-025f5b846b35?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80" alt="Désert" class="background-image">
    </div>

    <h1 class="titre-principal">Nos Expéditions Sahariennes</h1>

    <section class="treks">
        <a href="trek-maroc.php" class="trek-card">
            <img src="trek-maroc.jpg" alt="Sahara marocain" class="trek-img">
            <img src="drapeau-maroc.jpg" alt="Maroc" class="flag-img">
            <h2 class="titre-trek">Sahara Marocain</h2>
            <p class="trek-description">Dunes dorées à perte de vue et nuits sous les étoiles dans le désert de Merzouga.</p>
        </a>

        <a href="trek-algerie.php" class="trek-card">
            <img src="trek-algerie.jpg" alt="Dunes algériennes" class="trek-img">
            <img src="drapeau-algerie.jpg" alt="Algerie" class="flag-img">
            <h2 class="titre-trek">Grand Erg Algérien</h2>
            <p class="trek-description">Explorez les immenses dunes du Tassili n'Ajjer et ses formations rocheuses uniques.</p>
        </a>

        <a href="trek-tunisie.php" class="trek-card">
            <img src="tunisie-trek.jpg" alt="Désert tunisien" class="trek-img">
            <img src="drapeau-tunisie.jpg" alt="Tunisie" class="flag-img">
            <h2 class="titre-trek">Désert Tunisien</h2>
            <p class="trek-description">Entre chotts et oasis, découvrez les paysages variés du sud tunisien.</p>
        </a>

        <a href="trek-mauritanie.php" class="trek-card">
            <img src="mauritanie-trek.jpg" alt="Paysages mauritaniens" class="trek-img">
            <img src="drapeau-mauritanie.jpg" alt="Mauritanie" class="flag-img">
            <h2 class="titre-trek">Désert Mauritanie</h2>
            <p class="trek-description">L'Adrar et ses canyons spectaculaires, une aventure hors des sentiers battus.</p>
        </a>

        <a href="trek-egypte.php" class="trek-card">
            <img src="egypte-trek.jpg" alt="Désert égyptien" class="trek-img">
            <img src="drapeau-egypte.jpg" alt="Egypte" class="flag-img">
            <h2 class="titre-trek">Désert Égyptien</h2>
            <p class="trek-description">Du Sinaï au désert Blanc, marchez sur les traces des anciennes caravanes.</p>
        </a>
    </section>

    <a href="acceuil1.php" class="btn1">Retour à l'accueil</a>
</body>

</html>