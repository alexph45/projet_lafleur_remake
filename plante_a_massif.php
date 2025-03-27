<?php 
session_start();
require_once 'php/connect.php';
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>Plantes à massif</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/gif" href="images/icons8-fleur-16.ico" />
</head>
<body>
<header>
        <h1><img src="images/ACCUEIL.jpg" width="2%"> Société Lafleur</h1>

        <!-- Boutons en fonction de la connexion -->
        <?php if (isset($_SESSION['id_users'])): ?>
            <button onclick="window.location.href='php/deconnexion.php'">Se déconnecter</button>
            
            <?php if ($_SESSION['role'] === "admin"): ?>
                <button onclick="window.location.href='backend/administration.php'">Administration</button>
            <?php else: ?>
                <button onclick="window.location.href='backend/profil.php'">Mon Profil</button>
            <?php endif; ?>
        
        <?php else: ?>
            <button onclick="window.location.href='php/connexion.php'">Se connecter</button>
        <?php endif; ?>
    </header>
    <nav>
        <a href="index.php">Accueil</a>
        <a href="nos_produits.php">Nos produits</a>
        <a href="Bulbes.php">Bulbes</a>
        <a href="Rosiers.php">Rosiers</a>
        <a href="plante_a_massif.php">Plantes à massif</a>
    </nav>
    <main>
        <div class="card-container">
            <!-- Carte pour Lot de 3 marguerites -->
            <div class="card">
                <img src="images/massif_marguerite.jpg" alt="Lot de 3 marguerites">
                <h3 class="card-title">Lot de 3 marguerites</h3>
                <div class="card-content">
                    <p>Code: M01</p>
                    <p>Prix: 5 euros</p>
                </div>
                <button class="card-button">Acheter</button>
            </div>
            <!-- Carte pour Bouquet de 6 pensées -->
            <div class="card">
                <img src="images/massif_pensee.jpg" alt="Bouquet de 6 pensées">
                <h3 class="card-title">Bouquet de 6 pensées</h3>
                <div class="card-content">
                    <p>Code: M02</p>
                    <p>Prix: 6 euros</p>
                </div>
                <button class="card-button">Acheter</button>
            </div>
            <!-- Carte pour Mélange varié de 10 plantes à massifs -->
            <div class="card">
                <img src="images/massif_melange.jpg" alt="Mélange varié de 10 plantes à massifs">
                <h3 class="card-title">Mélange varié de 10 plantes à massifs</h3>
                <div class="card-content">
                    <p>Code: M03</p>
                    <p>Prix: 15 euros</p>
                </div>
                <button class="card-button">Acheter</button>
            </div>
        </div>
    </main>
    <footer>
    <p>® Copyrights 2025- Alexandre Pech--Rossell</p>
    </footer>
</body>
</html>
