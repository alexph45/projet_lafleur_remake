<?php
session_start();

// Vérification si l'utilisateur est déjà connecté
if(isset($_SESSION['username'])) {
    // Rediriger l'utilisateur vers une page de profil par exemple
    header("Location: index.html");
    exit;
}

// Vérification si le formulaire de connexion est soumis
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Connexion à la base de données 
    $servername = "localhost";
    $usernameDB = "nom_utilisateur";
    $passwordDB = "mot_de_passe";
    $dbname = "lafleur_scrum";

    // Création de la connexion
    $conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Utilisation de requête préparée pour éviter les injections SQL
    $sql = "SELECT * FROM clients WHERE nom_cli = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Utilisateur trouvé, vérifier le mot de passe
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['motdepasse_cli'])) {
            // Mot de passe correct, initialiser la session et rediriger l'utilisateur
            $_SESSION['username'] = $username;
            header("Location: index.html");
            exit;
        } else {
            // Mot de passe incorrect
            $error = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } else {
        // Utilisateur non trouvé
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }

    // Fermer la connexion à la base de données
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>Connexion - Société Lafleur</title>
    <link rel="stylesheet" href="css/style1.css">
    <link rel="icon" type="image/gif" href="icons8-fleur-16.ico" /> 
</head>
<body>
    <div class="container">
        <img src="" alt="Logo Lafleur" width="100">
        <h1>Connexion - Société Lafleur</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label for="username">Nom d'utilisateur:</label><br>
            <input type="text" id="username" name="username"><br>
            <label for="password">Mot de passe:</label><br>
            <input type="password" id="password" name="password"><br><br>
            <input type="submit" value="Se connecter">
            <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        </form>
        <p>Vous n'avez pas encore de compte ?</p>
        <button onclick="window.location.href='inscription.html'">S'inscrire</button>
    </div>
</body>
</html>


