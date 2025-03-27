<?php
session_start();
require_once '../php/connect.php';

// Nombre de commandes par page
$commandes_par_page = 10;

// Récupérer la page actuelle depuis l'URL, par défaut page 1
$page_actuelle = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculer l'offset pour la requête SQL
$offset = ($page_actuelle - 1) * $commandes_par_page;

// Gestion de l'action de mise à jour du statut de la commande
if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] === 'livrer') {
    $id_commande = $_GET['id'];

    // Requête pour mettre à jour le statut de la commande
    $sql = "UPDATE commandes SET statut = 'Livrée' WHERE id_commande = :id_commande";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_commande', $id_commande, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Rediriger vers la même page après l'action
        header('Location: gestion_commande.php?page=' . $page_actuelle);
        exit;
    } else {
        echo "<p>Erreur lors de la mise à jour du statut de la commande.</p>";
    }
}
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des commandes</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/gif" href="../images/icons8-fleur-16.ico" />
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
<?php
// Requête SQL pour récupérer le nombre total de commandes
$sql_total = "SELECT COUNT(*) AS total FROM commandes";
$stmt_total = $pdo->query($sql_total);
$total_commandes = $stmt_total->fetch()['total'];

// Affichage du nombre total de commandes
echo "<p>Nombre total de commandes : " . $total_commandes . "</p>";

// Calculer le nombre total de pages
$total_pages = ceil($total_commandes / $commandes_par_page);

// Requête SQL pour récupérer les commandes de la page actuelle
$sql = "SELECT c.id_commande, u.nom, c.date_commande, c.prix_total, c.statut
        FROM commandes c
        LEFT JOIN utilisateurs u ON c.id_user = u.id_users
        LIMIT :limite OFFSET :offset";

// Préparer et exécuter la requête
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':limite', $commandes_par_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

if ($stmt->execute()) {
    // Récupérer les résultats
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Affichage des résultats dans un tableau
    if ($result) {
        echo "<table class='commande-table'>
                <tr><th>ID Commande</th><th>Nom de l'utilisateur</th><th>Date Commande</th><th>Prix Total</th><th>Statut</th><th>Actions</th></tr>"; // En-tête du tableau

        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id_commande'] ?? '') . "</td>"; // Vérification de null
            echo "<td>" . htmlspecialchars($row['nom'] ?? 'Utilisateur inconnu') . "</td>"; // Vérification de null
            echo "<td>" . htmlspecialchars($row['date_commande'] ?? '') . "</td>"; // Vérification de null
            echo "<td>" . htmlspecialchars($row['prix_total'] ?? '') . " €</td>"; // Vérification de null
            echo "<td>" . htmlspecialchars($row['statut'] ?? '') . "</td>"; // Vérification de null

            // Si la commande n'est pas encore livrée, afficher le bouton pour la marquer comme livrée
            if ($row['statut'] !== 'Livrée') {
                echo "<td><a href='gestion_commande.php?id=" . $row['id_commande'] . "&action=livrer&page=" . $page_actuelle . "' class='btn-livrer'>Marquer comme Livrée</a></td>";
            } else {
                echo "<td><span class='livree'>Commande livrée</span></td>";
            }

            echo "</tr>";
        }

        echo "</table>";

        // Affichage des liens de pagination
        echo "<div class='pagination'>";
        if ($page_actuelle > 1) {
            echo "<a href='gestion_commande.php?page=" . ($page_actuelle - 1) . "'>Précédent</a>";
        }
        for ($i = 1; $i <= $total_pages; $i++) {
            echo "<a href='gestion_commande.php?page=" . $i . "'>" . $i . "</a>";
        }
        if ($page_actuelle < $total_pages) {
            echo "<a href='gestion_commande.php?page=" . ($page_actuelle + 1) . "'>Suivant</a>";
        }
        echo "</div>";
    } else {
        echo "<p>Aucune commande trouvée.</p>";
    }
} else {
    // Si l'exécution échoue, afficher l'erreur
    $errorInfo = $stmt->errorInfo();
    echo "Erreur d'exécution : " . $errorInfo[2];
}
?>
</main>
<footer>
    <p>® Copyrights 2025- Alexandre Pech--Rossell</p>
</footer>

</body>
</html>
