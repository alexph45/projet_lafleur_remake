<?php
session_start();
require_once '../php/connect.php';

if (!isset($_SESSION['id_users'])) {
    header("Location: ../connexion.php");
    exit;
}

$panier = $_SESSION['panier'] ?? [];
if (empty($panier)) {
    header("Location: ../panier.php?error=empty");
    exit;
}

$id_user = $_SESSION['id_users'];
$prix_total = 0;
$adresse_livraison = $_POST['adresse_livraison'] ?? ''; // Récupère l'adresse de livraison

if (empty($adresse_livraison)) {
    echo "Veuillez entrer une adresse de livraison.";
    exit;
}

try {
    $pdo->beginTransaction();

    // Créer la commande avec l'adresse de livraison
    $stmt = $pdo->prepare("INSERT INTO commandes (id_user, prix_total, adresse_livraison, statut) VALUES (?, ?, ?, ?)");
    $stmt->execute([$id_user, 0, $adresse_livraison, 'En attente']);
    $id_commande = $pdo->lastInsertId();

    // Ajouter les produits et mettre à jour le stock
    foreach ($panier as $id_produit => $quantite) {
        $stmt = $pdo->prepare("SELECT prix, quantite FROM produits WHERE id_produit = ?");
        $stmt->execute([$id_produit]);
        $produit = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($produit && $produit['quantite'] >= $quantite) {
            $prix_total += $produit['prix'] * $quantite;

            // Ajouter le produit à la commande
            $stmt = $pdo->prepare("INSERT INTO commande_produit (id_commande, id_produit, quantite) VALUES (?, ?, ?)");
            $stmt->execute([$id_commande, $id_produit, $quantite]);

            // Réduire le stock
            $stmt = $pdo->prepare("UPDATE produits SET quantite = quantite - ? WHERE id_produit = ?");
            $stmt->execute([$quantite, $id_produit]);
        } else {
            // Gérer l'erreur si la quantité demandée dépasse le stock
            echo "Stock insuffisant pour le produit ID: $id_produit.";
            $pdo->rollBack();
            exit;
        }
    }

    // Mettre à jour le prix total dans la commande
    $stmt = $pdo->prepare("UPDATE commandes SET prix_total = ? WHERE id_commande = ?");
    $stmt->execute([$prix_total, $id_commande]);

    // Commit de la transaction
    $pdo->commit();

    // Supprimer le panier de la session
    unset($_SESSION['panier']);

    // Rediriger l'utilisateur après validation de la commande
    header("Location: ../index.php");
    exit;
} catch (Exception $e) {
    // Rollback en cas d'erreur
    $pdo->rollBack();
    die("Erreur lors de la validation de la commande : " . $e->getMessage());
}
?>
