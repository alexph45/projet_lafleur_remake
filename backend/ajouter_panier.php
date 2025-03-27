<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_produit'])) {
    $id_produit = intval($_POST['id_produit']);

    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }

    // Vérifier si le produit est déjà dans le panier
    if (isset($_SESSION['panier'][$id_produit])) {
        $_SESSION['panier'][$id_produit] += 1;
    } else {
        $_SESSION['panier'][$id_produit] = 1;
    }

    echo json_encode(["success" => true, "message" => "Article ajouté au panier"]);
    exit;
}

// Si la requête est incorrecte
echo json_encode(["success" => false, "message" => "Erreur lors de l'ajout au panier"]);
exit;
?>
