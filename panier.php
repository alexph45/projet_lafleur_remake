<?php
session_start();
require_once 'php/connect.php';

$panier = $_SESSION['panier'] ?? [];

// Si le panier est vide, afficher un message correctement structuré avec du CSS
if (empty($panier)) {
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Panier Vide</title>
    <link rel="stylesheet" href="css/panier.css">
</head>
<body>
    <p class="panier_vide">Votre panier est vide.</p>
    <a href="index.php" class="btn-retour">Retour à l'accueil</a>
</body>
</html>
<?php
    exit;
}

// Récupérer les produits du panier
$ids_produits = implode(",", array_keys($panier));
$stmt = $pdo->query("SELECT * FROM produits WHERE id_produit IN ($ids_produits)");
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculer le prix total initial de la commande
$prix_total = 0;
foreach ($produits as $produit) {
    $prix_total += $produit['prix'] * $panier[$produit['id_produit']];
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Votre Panier</title>
    <link rel="stylesheet" href="css/panier.css">
</head>
<body>
<h1>Votre Panier</h1>

<form id="form-panier">
    <table>
        <tr>
            <th>Produit</th>
            <th>Prix</th>
            <th>Quantité</th>
            <th>Stock</th>
            <th>Total</th>
        </tr>
        <?php foreach ($produits as $produit): ?>
            <tr>
                <td><?= htmlspecialchars($produit['Libelle']) ?></td>
                <td><?= htmlspecialchars($produit['prix']) ?>€</td>
                <td>
                    <input type="number" name="quantite[<?= $produit['id_produit'] ?>]" 
                           value="<?= $panier[$produit['id_produit']] ?>" 
                           min="1" max="<?= $produit['quantite'] ?>"
                           class="quantite-produit"
                           data-id="<?= $produit['id_produit'] ?>" 
                           data-prix="<?= $produit['prix'] ?>"
                           onchange="updateTotal()">
                </td>
                <td><?= htmlspecialchars($produit['quantite']) ?></td>
                <td class="total-produit" data-id="<?= $produit['id_produit'] ?>">
                    <?= $produit['prix'] * $panier[$produit['id_produit']] ?>€
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</form>



<!-- Ajouter un champ pour l'adresse de livraison -->
<h2>Adresse de Livraison</h2>
<form id="form-livraison" method="POST" action="backend/valider_commande.php">
    <label for="adresse_livraison"></label>
    <textarea name="adresse_livraison" id="adresse_livraison" rows="4" cols="50" placeholder="Entrez votre adresse de livraison"></textarea><br>
</form>
<!-- Afficher le prix total de la commande -->
<p><strong>Prix total de la commande: <span id="prix-total"><?= $prix_total ?>€</span></strong></p>
<!-- Lien pour valider la commande -->
<button id="btn-valider-commande" class="btn-valider">Valider la commande</button>

<script>
// Fonction pour mettre à jour le total du panier en temps réel
function updateTotal() {
    let total = 0;

    // Parcours de chaque produit
    document.querySelectorAll('.quantite-produit').forEach(input => {
        let prix = parseFloat(input.getAttribute('data-prix'));
        let quantite = parseInt(input.value);
        let totalProduit = prix * quantite;

        // Mettre à jour le total du produit
        document.querySelector('.total-produit[data-id="' + input.getAttribute('data-id') + '"]').textContent = totalProduit + "€";

        // Ajouter au total général
        total += totalProduit;
    });

    // Mettre à jour le prix total dans le panier
    document.getElementById('prix-total').textContent = total.toFixed(2) + "€";

    // Envoyer la nouvelle quantité au serveur via AJAX
    let formData = new FormData(document.getElementById('form-panier'));
    fetch('backend/modifier_panier.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            console.log("Panier mis à jour");
        } else {
            console.log("Erreur lors de la mise à jour du panier");
        }
    });
}

// Soumettre les deux formulaires (panier et adresse) lorsque l'utilisateur clique sur le bouton "Valider la commande"
document.getElementById('btn-valider-commande').addEventListener('click', function(e) {
    e.preventDefault(); // Empêcher le comportement par défaut du bouton

    // Soumettre les deux formulaires en même temps
    const formPanier = document.getElementById('form-panier');
    const formLivraison = document.getElementById('form-livraison');

    // Créer un objet FormData pour les deux formulaires
    let formDataPanier = new FormData(formPanier);
    let formDataLivraison = new FormData(formLivraison);

    // Fusionner les données des deux formulaires
    for (let [key, value] of formDataLivraison.entries()) {
        formDataPanier.append(key, value);
    }

    // Envoyer les données fusionnées via fetch
    fetch('backend/valider_commande.php', {
        method: 'POST',
        body: formDataPanier
    })
    .then(response => response.text())
    .then(data => {
        // Rediriger ou afficher un message de confirmation selon la réponse du serveur
        window.location.href = 'index.php'; // Redirection après validation
    })
    .catch(error => {
        console.log("Erreur lors de la soumission de la commande", error);
    });
});
</script>

</body>
</html>
