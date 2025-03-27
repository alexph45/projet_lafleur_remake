<?php 
// Inclure le fichier de connexion à la base de données
include('../php/connect.php');

// Variable pour les messages
$message = '';

// Récupérer la liste des catégories pour la liste déroulante
try {
    $stmt = $pdo->query("SELECT id_cat, nom_categorie FROM categories");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $message = '<div class="error-message">Erreur lors du chargement des catégories : ' . $e->getMessage() . '</div>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupérer les données du formulaire
    $libelle = $_POST['libelle'];
    $prix = $_POST['prix'];
    $quantite = $_POST['quantite'];
    $id_cat = $_POST['id_cat'];

    // Vérifier si une image a été téléchargée
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_name = $_FILES['image']['name'];
        $image_type = $_FILES['image']['type'];
        $image_size = $_FILES['image']['size'];

        // Définir un répertoire pour enregistrer les images
        $target_dir = "../images/";
        $target_file = $target_dir . basename($image_name);

        // Vérifier si le fichier est une image valide
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($image_type, $allowed_types)) {
            if (move_uploaded_file($image_tmp_name, $target_file)) {
                $image_path = $target_file;
            } else {
                $message = '<div class="error-message">Erreur lors du téléchargement de l\'image.</div>';
            }
        } else {
            $message = '<div class="error-message">Le fichier téléchargé n\'est pas une image valide.</div>';
        }
    } else {
        $message = '<div class="error-message">Aucune image téléchargée ou erreur lors du téléchargement.</div>';
    }

    if (empty($message)) {
        try {
            // Insérer le produit avec la catégorie sélectionnée
            $sql = "INSERT INTO produits (Libelle, prix, quantite, image, id_cat) VALUES (:Libelle, :prix, :quantite, :image, :id_cat)";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':Libelle', $libelle, PDO::PARAM_STR);
            $stmt->bindParam(':prix', $prix, PDO::PARAM_STR);
            $stmt->bindParam(':quantite', $quantite, PDO::PARAM_INT);
            $stmt->bindParam(':image', $image_path, PDO::PARAM_STR);
            $stmt->bindParam(':id_cat', $id_cat, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $message = '<div class="success-message">Le produit a été ajouté avec succès !</div>';
                header('Location: ajout_produits.php');
                exit();
            } else {
                $message = '<div class="error-message">Erreur lors de l\'ajout du produit.</div>';
            }
        } catch (PDOException $e) {
            $message = '<div class="error-message">Erreur SQL : ' . $e->getMessage() . '</div>';
        }
    }

    $pdo = null;
}
?>

<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Produit - Société Lafleur</title>
    <link rel="stylesheet" href="../css/ajout_produit.css">
</head>
<body>
    <main>
        <section>
            <?php if ($message): ?>
                <div class="message"><?= $message ?></div>
            <?php endif; ?>

            <form action="" method="POST" enctype="multipart/form-data">
                <label for="libelle">Nom du Produit:</label>
                <input type="text" id="libelle" name="libelle" required>

                <label for="prix">Prix:</label>
                <input type="text" id="prix" name="prix" required>

                <label for="quantite">Quantité:</label>
                <input type="number" id="quantite" name="quantite" required>

                <label for="id_cat">Catégorie:</label>
                <select id="id_cat" name="id_cat" required>
                    <option value="">Sélectionnez une catégorie</option>
                    <?php foreach ($categories as $categorie): ?>
                        <option value="<?= $categorie['id_cat'] ?>"><?= htmlspecialchars($categorie['nom_categorie']) ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="image">Image du Produit:</label>
                <input type="file" id="image" name="image" accept="image/*" required>
                <div id="image-preview-container">
                    <img id="image-preview" style="display: none; max-width: 150px; margin-top: 10px;" />
                    <span id="image-name" style="display: none; margin-top: 10px; color: #333;"></span>
                </div>

                <button type="submit">Ajouter le Produit</button>
            </form>
        </section>
    </main>

    <footer>
        <p>© 2025 - Société Lafleur</p>
    </footer>

    <script>
        const fileInput = document.getElementById('image');
        const imagePreview = document.getElementById('image-preview');
        const imageName = document.getElementById('image-name');

        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];

            if (file) {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block';
                        imageName.style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.style.display = 'none';
                    imageName.textContent = file.name;
                    imageName.style.display = 'block';
                }
            } else {
                imagePreview.style.display = 'none';
                imageName.style.display = 'none';
            }
        });
    </script>
</body>
</html>
