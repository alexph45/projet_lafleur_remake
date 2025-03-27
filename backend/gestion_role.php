<?php
session_start();
require_once '../php/connect.php';

if (isset($_GET['id']) && isset($_GET['action'])) {
    $userId = $_GET['id'];
    $action = $_GET['action'];
    
    // Vérifier si l'action est soit "promouvoir" soit "retirer"
    if ($action === 'promouvoir') {
        // Requête pour mettre à jour le rôle à 'admin'
        $sql = "UPDATE utilisateurs SET role = 'admin' WHERE id_users = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            header("Location: gestion_utilisateurs.php"); // Rediriger après la mise à jour
            exit();
        } else {
            echo "Erreur lors de la promotion de l'utilisateur.";
        }
    } elseif ($action === 'retirer') {
        // Requête pour retirer le rôle 'admin'
        $sql = "UPDATE utilisateurs SET role = NULL WHERE id_users = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            header("Location: gestion_utilisateurs.php"); // Rediriger après la mise à jour
            exit();
        } else {
            echo "Erreur lors du retrait du rôle admin.";
        }
    }
} else {
    echo "Données manquantes.";
}
?>
