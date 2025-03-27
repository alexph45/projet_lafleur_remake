<?php 
// Inclure le fichier de connexion à la base de données
include('../php/connect.php');

// Variable pour les messages
$message = '';
$success = false;
$produit = null;

// Récupérer tous les produits pour la liste déroulante
try {
    $stmt = $pdo->query('SELECT id_produit, Libelle FROM produits ORDER BY Libelle ASC');
    $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des produits : " . $e->getMessage());
}

// Récupérer toutes les catégories
try {
    $stmt = $pdo->query('SELECT id_cat, nom_categorie FROM categories ORDER BY nom_categorie ASC');
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des catégories : " . $e->getMessage());
}

// Vérifier si l'ID du produit est passé
if (isset($_POST['id_produit']) && !empty($_POST['id_produit'])) {
    $id_produit = $_POST['id_produit'];

    // Récupérer les détails du produit sélectionné avec sa catégorie
    try {
        $stmt = $pdo->prepare('SELECT p.*, c.id_cat FROM produits p LEFT JOIN categories c ON p.id_cat = c.id_cat WHERE p.id_produit = ?');
        $stmt->execute([$id_produit]);
        $produit = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $message = "Erreur lors de la récupération des informations du produit : " . $e->getMessage();
    }
}

// Vérifier si le formulaire de modification a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($produit)) {
    if (isset($_POST['Libelle']) && isset($_POST['prix']) && isset($_POST['quantite']) && isset($_POST['id_cat'])) {
        $libelle = $_POST['Libelle'];
        $prix = $_POST['prix'];
        $quantite = $_POST['quantite'];
        $id_cat = $_POST['id_cat'];
        $image = isset($_FILES['image']['name']) && !empty($_FILES['image']['name']) ? $_FILES['image']['name'] : $produit['image'];

        // Si une nouvelle image a été téléchargée
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            move_uploaded_file($_FILES['image']['tmp_name'], '../images/' . $image);
        }

        try {
            // Mise à jour du produit avec la catégorie
            $stmt = $pdo->prepare('UPDATE produits SET Libelle = ?, prix = ?, quantite = ?, id_cat = ?, image = ? WHERE id_produit = ?');
            $stmt->execute([$libelle, $prix, $quantite, $id_cat, $image, $id_produit]);

            $message = "Le produit a été modifié avec succès!";
            $success = true;
        } catch (PDOException $e) {
            $message = "Erreur lors de la modification : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/modifier_produit.css">
    <title>Modifier un Produit</title>
</head>
<body>

<div class="container">
    <h1>Modifier un Produit</h1>

    <?php if ($success): ?>
        <p class="message"><?= htmlspecialchars($message) ?></p>
        <a href="administration.php" class="btn-return">Retour</a>
    <?php else: ?>
        <!-- Sélection du produit -->
        <form method="POST" action="" enctype="multipart/form-data">
            <label for="id_produit">Sélectionnez un Produit :</label>
            <select id="id_produit" name="id_produit" required>
                <option value="">-- Choisissez un produit --</option>
                <?php foreach ($produits as $prod): ?>
                    <option value="<?= htmlspecialchars($prod['id_produit']) ?>" <?= (isset($produit) && $produit['id_produit'] == $prod['id_produit']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($prod['Libelle']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn-submit">Choisir</button>
        </form>

        <?php if (isset($produit)): ?>
            <h2>Modifier le Produit : <?= htmlspecialchars($produit['Libelle']) ?></h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="id_produit" value="<?= $produit['id_produit'] ?>">

                <label for="Libelle">Nom du Produit :</label>
                <input type="text" id="Libelle" name="Libelle" value="<?= htmlspecialchars($produit['Libelle']) ?>" required>

                <label for="categorie">Catégorie :</label>
                <select id="categorie" name="id_cat" required>
                    <option value="">-- Choisissez une catégorie --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= htmlspecialchars($cat['id_cat']) ?>" <?= (isset($produit) && $produit['id_cat'] == $cat['id_cat']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['nom_categorie']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="prix">Prix :</label>
                <input type="number" id="prix" name="prix" value="<?= htmlspecialchars($produit['prix']) ?>" required>

                <label for="quantite">Quantité :</label>
                <input type="number" id="quantite" name="quantite" value="<?= htmlspecialchars($produit['quantite']) ?>" required>

                <label for="image">Image du Produit :</label>
                <input type="file" id="image" name="image">

                <button type="submit" class="btn-submit">Enregistrer les modifications</button>
            </form>
        <?php endif; ?>
    <?php endif; ?>
</div>

</body>
</html>
