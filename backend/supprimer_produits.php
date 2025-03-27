<?php
// Inclure le fichier de connexion
include('../php/connect.php');

// Variable pour les messages
$message = '';
$success = false;

// Vérifier si un produit a été choisi pour suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_produit'])) {
    // Récupérer l'ID du produit à supprimer
    $id_produit = $_POST['id_produit'];

    try {
        // Démarrer la transaction
        $pdo->beginTransaction();

        // Supprimer le produit
        $sql_produit = "DELETE FROM produits WHERE id_produit = :id_produit";
        $stmt_produit = $pdo->prepare($sql_produit);
        $stmt_produit->bindParam(':id_produit', $id_produit, PDO::PARAM_INT);
        $stmt_produit->execute();

        // Valider la transaction
        $pdo->commit();

        $message = "Le produit a été supprimé avec succès.";
        $success = true;
    } catch (PDOException $e) {
        // Annuler la transaction en cas d'erreur
        $pdo->rollBack();
        $message = "Erreur lors de la suppression du produit: " . $e->getMessage();
    }
}

// Récupérer tous les produits pour la liste déroulante
try {
    $stmt = $pdo->query('SELECT id_produit, Libelle FROM produits ORDER BY Libelle ASC');
    $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des produits : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/supprimer_produit.css">
    <title>Supprimer un Produit</title>
</head>
<body>

<div class="container">
    <h1>Supprimer un Produit</h1>

    <?php if ($success): ?>
        <p class="message success"><?= htmlspecialchars($message) ?></p>
        <a href="administration.php" class="btn-return">Retour</a>
    <?php elseif ($message): ?>
        <p class="message error"><?= htmlspecialchars($message) ?></p>
    <?php else: ?>
        <!-- Formulaire pour choisir un produit à supprimer -->
        <form method="POST" action="">
            <label for="id_produit">Sélectionnez un Produit à supprimer :</label>
            <select id="id_produit" name="id_produit" required>
                <option value="">-- Choisissez un produit --</option>
                <?php foreach ($produits as $prod): ?>
                    <option value="<?= htmlspecialchars($prod['id_produit']) ?>">
                        <?= htmlspecialchars($prod['Libelle']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn-submit">Supprimer</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
