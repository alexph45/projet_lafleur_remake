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
    if(isset($_POST['inscription'])) {
        // Récupérer les données du formulaire
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Hasher le mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Connexion à la base de données (à remplacer par vos propres informations)
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

        // Préparer et exécuter la requête pour insérer un nouvel utilisateur dans la table clients
        $sql = "INSERT INTO clients (nom_cli, adresse_cli, mail_cli, motdepasse_cli) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $fullname, $username, $email, $hashed_password);

        if ($stmt->execute()) {
            echo "Nouvel utilisateur créé avec succès.";
        } else {
            echo "Erreur lors de la création de l'utilisateur : " . $conn->error;
        }

        // Fermer la connexion à la base de données
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inscription - Société Lafleur</title>
    <link rel="stylesheet" href="style2.css">
    <link rel="icon" type="image/gif" href="icons8-fleur-16.ico" /> 
</head>
<body>
    <div class="container">
        <img src="flower_logo.png" alt="Logo Lafleur" width="100">
        <h1>Inscription - Société Lafleur</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label for="fullname">Nom complet :</label><br>
            <input type="text" id="fullname" name="fullname"><br>
            <label for="email">Adresse e-mail :</label><br>
            <input type="email" id="email" name="email"><br>
            <label for="username">Nom d'utilisateur :</label><br>
            <input type="text" id="username" name="username"><br>
            <label for="password">Mot de passe :</label><br>
            <input type="password" id="password" name="password"><br><br>
            <input type="submit" name="inscription" value="S'inscrire">
        </form>
    </div>
</body>
</html>
