<?php
session_start();

// Vérifie si les données sont envoyées via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['quantite'])) {
        // Mettez à jour les quantités dans le panier
        foreach ($_POST['quantite'] as $id_produit => $quantite) {
            // Vérifie que la quantité est valide
            if ($quantite > 0) {
                $_SESSION['panier'][$id_produit] = $quantite;
            } else {
                unset($_SESSION['panier'][$id_produit]);
            }
        }

        // Renvoie une réponse JSON
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Aucune donnée reçue']);
    }
}
?>
