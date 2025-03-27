<?php 
session_start();
require_once 'php/connect.php';

// Récupérer les produits de la catégorie "Rosiers" (ID = 2)
try {
    $stmt = $pdo->prepare('SELECT * FROM produits WHERE id_cat = 2');
    $stmt->execute();
    $produits_rosiers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Récupérer le nom de la catégorie "Rosiers" (ID = 2)
    $cat_stmt = $pdo->prepare('SELECT nom_categorie FROM categories WHERE id_cat = 2');
    $cat_stmt->execute();
    $categorie = $cat_stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des produits ou des catégories : " . $e->getMessage());
}
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
        <?php foreach ($produits_rosiers as $produit): ?>
            <div class="card">
                <img src="images/<?= htmlspecialchars($produit['image']) ?>" alt="<?= htmlspecialchars($produit['Libelle']) ?>" class="product-image">
                <h3 class="card-title"><?= htmlspecialchars($produit['Libelle']) ?></h3>
                    <div class="card-content">
                        <p>Quantité restante: <?= htmlspecialchars($produit['quantite']) ?></p>
                        <p>Prix: <?= htmlspecialchars($produit['prix']) ?> euros</p>
                        <p>Type: <?= htmlspecialchars($categorie['nom_categorie']) ?></p> <!-- Affiche le nom de la catégorie -->
                    </div>
                <button class="card-button">Acheter</button>
            </div>
        <?php endforeach; ?>
    </div>
</main>
<footer>
    <p>® Copyrights 2025- Alexandre Pech--Rossell</p>
</footer>
</body>
</html>
