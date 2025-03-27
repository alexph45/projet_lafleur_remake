<?php 
session_start();
require_once 'php/connect.php';

// Récupérer les produits de toute les catégories
try {
    $stmt = $pdo->prepare('SELECT * FROM produits');
    $stmt->execute();
    $produits_tous = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Récupérer le nom des catégories
    $cat_stmt = $pdo->prepare('SELECT nom_categorie FROM categories');
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
    <title>Nos Produits</title>
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
<div id="message-panier" class="hidden">Produit ajouté au panier !</div>
<main>
    <div class="card-container">
        <?php foreach ($produits_tous as $produit): ?>
            <div class="card">
                <img src="images/<?= htmlspecialchars($produit['image']) ?>" alt="<?= htmlspecialchars($produit['Libelle']) ?>" class="product-image">
                <h3 class="card-title"><?= htmlspecialchars($produit['Libelle']) ?></h3>
                    <div class="card-content">
                        <p>Quantité restante: <?= htmlspecialchars($produit['quantite']) ?></p>
                        <p>Prix: <?= htmlspecialchars($produit['prix']) ?> euros</p>
                        <p>Type: <?= htmlspecialchars($categorie['nom_categorie']) ?></p> <!-- Affiche le nom de la catégorie -->
                    </div>
                    <?php if ($produit['quantite'] > 0): ?>
                    <button class="ajouter-panier" data-id="<?= $produit['id_produit'] ?>">Ajouter au panier</button>
                <?php else: ?>
                    <button class="rupture-stock" disabled>Rupture de stock</button>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</main>
<footer>
    <p>® Copyrights 2025- Alexandre Pech--Rossell</p>
</footer>
<script>
document.querySelectorAll('.ajouter-panier').forEach(button => {
    button.addEventListener('click', function() {
        let idProduit = this.getAttribute('data-id');

        fetch('backend/ajouter_panier.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'id_produit=' + idProduit
        })
        .then(response => response.text())
        .then(data => {
            let messagePanier = document.getElementById('message-panier');
            messagePanier.style.display = 'block';

            setTimeout(() => {
                messagePanier.style.display = 'none';
            }, 3000);
        });
    });
});
</script>
</body>
</html>
