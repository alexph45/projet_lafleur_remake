<?php 
session_start();
require_once 'php/connect.php';
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nos produits</title>
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
    <br><br>
    <main>
        <div class="card-container">
            <!-- Carte pour 3 bulbes de bégonias -->
            <div class="card">
                <img src="images/bulbes_begonia.jpg" alt="3 bulbes de bégonias">
                <h3 class="card-title">3 bulbes de bégonias</h3>
                <p class="card-content">Code: B01</p>
                <p class="card-content">Prix: 5 euros</p>
                <button class="card-button">Acheter</button>
            </div>
            <!-- Répétez pour chaque produit -->
            <div class="card">
                <img src="images/bulbes_dahlia.jpg" alt="10 bulbes de dahlias">
                <h3 class="card-title">10 bulbes de dahlias</h3>
                <p class="card-content">Code: B02</p>
                <p class="card-content">Prix: 12 euros</p>
                <button class="card-button">Acheter</button>
            </div>
            <div class="card">
                <img src="images/bulbes_glaieul.jpg" alt="50 glaïeuls">
                <h3 class="card-title">50 glaïeuls</h3>
                <p class="card-content">Code: B03</p>
                <p class="card-content">Prix: 9 euros</p>
                <button class="card-button">Acheter</button>
            </div>
            <div class="card">
                <img src="images/massif_marguerite.jpg" alt="Lot de 3 marguerites">
                <h3 class="card-title">Lot de 3 marguerites</h3>
                <p class="card-content">Code: M01</p>
                <p class="card-content">Prix: 5 euros</p>
                <button class="card-button">Acheter</button>
            </div>
            <div class="card">
                <img src="images/massif_pensee.jpg" alt="Bouquet de 6 pensées">
                <h3 class="card-title">Bouquet de 6 pensées</h3>
                <p class="card-content">Code: M02</p>
                <p class="card-content">Prix: 6 euros</p>
                <button class="card-button">Acheter</button>
            </div>
            <div class="card">
                <img src="images/massif_melange.jpg" alt="Mélange varié de 10 plantes à massifs">
                <h3 class="card-title">Mélange varié de 10 plantes à massifs</h3>
                <p class="card-content">Code: M03</p>
                <p class="card-content">Prix: 15 euros</p>
                <button class="card-button">Acheter</button>
            </div>
            <div class="card">
                <img src="images/rosiers_gdefleur.jpg" alt="1 pied spécial 'grandes fleurs'">
                <h3 class="card-title">1 pied spécial 'grandes fleurs'</h3>
                <p class="card-content">Code: R01</p>
                <p class="card-content">Prix: 20 euros</p>
                <button class="card-button">Acheter</button>
            </div>
            <div class="card">
                <img src="images/rosiers_parfum.jpg" alt="Variété sélectionnée pour son parfum">
                <h3 class="card-title">Variété sélectionnée pour son parfum</h3>
                <p class="card-content">Code: R02</p>
                <p class="card-content">Prix: 9 euros</p>
                <button class="card-button">Acheter</button>
            </div>
            <div class="card">
                <img src="images/rosiers_arbuste.jpg" alt="Rosier arbuste">
                <h3 class="card-title">Rosier arbuste</h3>
                <p class="card-content">Code: R03</p>
                <p class="card-content">Prix: 8 euros</p>
                <button class="card-button">Acheter</button>
            </div>
        </div>
    </main>
    <footer>
        <p>® Copyrights 2025- Alexandre Pech--Rossell</p>
    </footer>
</body>
</html>
