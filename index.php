<?php 
session_start();
require_once 'php/connect.php';
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil Société Lafleur</title>
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
                <button onclick="window.location.href='panier.php'">Panier</button>
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
        <section>
            <h4>"LaFleur, le meilleur Fleuriste du Loiret"</h4>
            <img src="images/ACCUEIL.jpg" alt="Image d'accueil de LaFleur">
            <p>Pour recevoir un devis</p>
            <p>Appelez notre service commercial au 03.22.84.65.74</p>
        </section>
    </main>

    <footer>
        <p>© 2025 - Alexandre Pech</p>
    </footer>

</body>
</html>
