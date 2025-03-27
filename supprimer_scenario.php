<?php
// Inclure le fichier de connexion
include('connect.php');

// Vérifier si un scénario a été choisi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_scenario'])) {
    // Récupérer l'ID du scénario à supprimer
    $id_scenario = $_POST['id_scenario'];

    try {
        // Démarrer la transaction
        $pdo->beginTransaction();

        // Supprimer les étapes associées à ce scénario
        $sql_etapes = "DELETE FROM etape WHERE id_scenario = :id_scenario";
        $stmt_etapes = $pdo->prepare($sql_etapes);
        $stmt_etapes->bindParam(':id_scenario', $id_scenario, PDO::PARAM_INT);
        $stmt_etapes->execute();

        // Supprimer le scénario
        $sql_scenario = "DELETE FROM scenario WHERE id_scenario = :id_scenario";
        $stmt_scenario = $pdo->prepare($sql_scenario);
        $stmt_scenario->bindParam(':id_scenario', $id_scenario, PDO::PARAM_INT);
        $stmt_scenario->execute();

        // Valider la transaction
        $pdo->commit();

        echo "Le scénario et ses étapes ont été supprimés avec succès.";
        sleep(1);
        header('Location: ../crud.php');
    } catch (PDOException $e) {
        // Annuler la transaction en cas d'erreur
        $pdo->rollBack();
        echo "Erreur lors de la suppression du scénario: " . $e->getMessage();
    }
} else {
    echo "Aucun scénario n'a été sélectionné.";
}

// Fermer la connexion
$pdo = null;
?>
