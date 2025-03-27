<?php 
session_start();
require_once '../php/connect.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id_users'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: connexion.php');
    exit;
}

$id_user = $_SESSION['id_users']; // Récupérer l'ID de l'utilisateur connecté

// Requête SQL pour récupérer le nom de l'utilisateur
$sql_user = "SELECT nom FROM utilisateurs WHERE id_users = :id_user";
$stmt_user = $pdo->prepare($sql_user);
$stmt_user->bindParam(':id_user', $id_user, PDO::PARAM_INT);
$stmt_user->execute();
$user = $stmt_user->fetch(PDO::FETCH_ASSOC);

// Requête SQL pour récupérer les commandes de l'utilisateur
$sql_commande = "SELECT c.id_commande, c.date_commande, c.prix_total, c.statut 
                 FROM commandes c
                 WHERE c.id_user = :id_user";

// Préparer et exécuter la requête
$stmt_commande = $pdo->prepare($sql_commande);
$stmt_commande->bindParam(':id_user', $id_user, PDO::PARAM_INT);

if ($stmt_commande->execute()) {
    // Récupérer les résultats
    $result = $stmt_commande->fetchAll(PDO::FETCH_ASSOC);
} else {
    // En cas d'erreur d'exécution
    $errorInfo = $stmt_commande->errorInfo();
    echo "Erreur d'exécution : " . $errorInfo[2];
}
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/gif" href="../images/icons8-fleur-16.ico" />
</head>
<body>
<header>
    <h1><img src="../images/ACCUEIL.jpg" width="2%"> Société Lafleur</h1>

    <!-- Boutons en fonction de la connexion -->
    <?php if (isset($_SESSION['id_users'])): ?>
        <button onclick="window.location.href='../php/deconnexion.php'">Se déconnecter</button>
        
        <?php if ($_SESSION['role'] === "admin"): ?>
            <button onclick="window.location.href='backend/administration.php'">Administration</button>
        <?php else: ?>
            <button onclick="window.location.href='profil.php'">Mon Profil</button>
        <?php endif; ?>

    <?php else: ?>
        <button onclick="window.location.href='php/connexion.php'">Se connecter</button>
    <?php endif; ?>
</header>
<nav>
    <a href="../index.php">Accueil</a>
    <a href="../nos_produits.php">Nos produits</a>
    <a href="../Bulbes.php">Bulbes</a>
    <a href="../Rosiers.php">Rosiers</a>
    <a href="../plante_a_massif.php">Plantes à massif</a>
</nav>
<main>
    <h2>Bienvenue, <?php echo htmlspecialchars($user['nom']); ?></h2> <!-- Affichage du nom de l'utilisateur -->

    <h3>Mes Commandes</h3>
    
    <?php if ($result): ?>
        <table class="commande-table">
            <tr><th>Date Commande</th><th>Prix Total</th><th>Statut</th></tr> <!-- En-tête du tableau -->
            <?php foreach ($result as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['date_commande']); ?></td>
                    <td><?php echo htmlspecialchars($row['prix_total']) . " €"; ?></td>
                    <td><?php echo htmlspecialchars($row['statut']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Vous n'avez pas encore passé de commandes.</p>
    <?php endif; ?>
</main>
<footer>
    <p>® Copyrights 2025- Alexandre Pech--Rossell</p>
</footer>
</body>
</html>
