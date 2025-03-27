<?php 
session_start();
require_once '../php/connect.php';
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil Société Lafleur</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/gif" href="images/icons8-fleur-16.ico" /> 
</head>
<body>

    <header>
        <h1><img src="../images/ACCUEIL.jpg" width="2%"> Société Lafleur</h1>

        <!-- Boutons en fonction de la connexion -->
        <?php if (isset($_SESSION['id_users'])): ?>
            <button onclick="window.location.href='../php/deconnexion.php'">Se déconnecter</button>
            
            <?php if ($_SESSION['role'] === "admin"): ?>
                <button onclick="window.location.href='ajout_produits.php'">Ajouter un produits</button>
                <button onclick="window.location.href='modifier_produits.php'">Modifier un produits</button>
                <button onclick="window.location.href='supprimer_produits.php'">Supprimer un produits</button>
                <button onclick="window.location.href='gestion_utilisateurs.php'">Liste des utilisateurs</button>
                <button onclick="window.location.href='gestion_commande.php'">Liste des commandes</button>
                <button onclick="window.location.href='../index.php'">retour à l'accueil</button>
            <?php else: ?>
                <button onclick="window.location.href='backend/profil.php'">Mon Profil</button>
            <?php endif; ?>
        
        <?php else: ?>
            he
        <?php endif; ?>
    </header>

    <main>

    </main>

    <footer>
        <p>© 2025 - Alexandre Pech</p>
    </footer>

</body>
</html>
