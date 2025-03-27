<?php 
session_start();
require_once 'php/connect.php';
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rosiers</title>
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
            <!-- Carte pour 1 pied spécial "grandes fleurs" -->
            <div class="card">
                <img src="images/rosiers_gdefleur.jpg" alt="1 pied spécial 'grandes fleurs'">
                <h3 class="card-title">1 pied spécial "grandes fleurs"</h3>
                <div class="card-content">
                    <p>Code: R01</p>
                    <p>Prix: 20 euros</p>
                </div>
                <button class="card-button">Acheter</button>
            </div>
            <!-- Carte pour Variété sélectionnée pour son parfum -->
            <div class="card">
                <img src="images/rosiers_parfum.jpg" alt="Variété sélectionnée pour son parfum">
                <h3 class="card-title">Variété sélectionnée pour son parfum</h3>
                <div class="card-content">
                    <p>Code: R02</p>
                    <p>Prix: 9 euros</p>
                </div>
                <button class="card-button">Acheter</button>
            </div>
            <!-- Carte pour Rosier arbuste -->
            <div class="card">
                <img src="images/rosiers_arbuste.jpg" alt="Rosier arbuste">
                <h3 class="card-title">Rosier arbuste</h3>
                <div class="card-content">
                    <p>Code: R03</p>
                    <p>Prix: 8 euros</p>
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
