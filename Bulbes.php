<?php 
session_start();
require_once 'php/connect.php';
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bulbes</title>
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
            <!-- Carte pour 3 bulbes de bégonias -->
            <div class="card">
                <img src="images/bulbes_begonia.jpg" alt="3 bulbes de bégonias">
                <h3 class="card-title">3 bulbes de bégonias</h3>
                <div class="card-content">
                    <p>Code: B01</p>
                    <p>Prix: 5 euros</p>
                </div>
                <button class="card-button">Acheter</button>
            </div>
            <!-- Carte pour 10 bulbes de dahlias -->
            <div class="card">
                <img src="images/bulbes_dahlia.jpg" alt="10 bulbes de dahlias">
                <h3 class="card-title">10 bulbes de dahlias</h3>
                <div class="card-content">
                    <p>Code: B02</p>
                    <p>Prix: 12 euros</p>
                </div>
                <button class="card-button">Acheter</button>
            </div>
            <!-- Carte pour 50 glaïeuls -->
            <div class="card">
                <img src="images/bulbes_glaieul.jpg" alt="50 glaïeuls">
                <h3 class="card-title">50 glaïeuls</h3>
                <div class="card-content">
                    <p>Code: B03</p>
                    <p>Prix: 9 euros</p>
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
