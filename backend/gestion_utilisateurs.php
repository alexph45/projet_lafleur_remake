<?php 
session_start();
require_once '../php/connect.php';
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des utilisateurs</title>
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
            <button onclick="window.location.href='administration.php'">Administration</button>
        <?php else: ?>
            <button onclick="window.location.href='profil.php'">Mon Profil</button>
        <?php endif; ?>

    <?php else: ?>
        <button onclick="window.location.href='../php/connexion.php'">Se connecter</button>
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
<?php
// Requête SQL pour récupérer les utilisateurs
$sql = "SELECT id_users, nom, role FROM utilisateurs";

// Préparer et exécuter la requête
$stmt = $pdo->prepare($sql);

if ($stmt->execute()) {
    // Récupérer les résultats
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Affichage des résultats dans un tableau
    if ($result) {
        echo "<table class='user-table'>
                <tr><th>ID</th><th>Nom</th><th>Rôle</th><th>Actions</th></tr>"; // En-tête du tableau
        
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id_users'] ?? '') . "</td>"; // Vérification de null
            echo "<td>" . htmlspecialchars($row['nom'] ?? '') . "</td>"; // Vérification de null
            echo "<td>" . htmlspecialchars($row['role'] ?? '') . "</td>"; // Vérification de null
            
            // Si l'utilisateur est admin, afficher le bouton pour le retirer
            if ($row['role'] === 'admin') {
                echo "<td><a href='gestion_role.php?id=" . $row['id_users'] . "&action=retirer' class='btn-retirer'>Retirer Admin</a></td>";
            } else {
                // Si l'utilisateur n'est pas admin, afficher le bouton pour le promouvoir
                echo "<td><a href='gestion_role.php?id=" . $row['id_users'] . "&action=promouvoir' class='btn-promouvoir'>Promouvoir à Admin</a></td>";
            }
            
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "<p>Aucun utilisateur trouvé.</p>";
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
