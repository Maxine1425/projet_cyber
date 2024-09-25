<?php
    include ("config.php");
    EstConnecte();
    $id_compte=$_SESSION['id_compte'];
    
    if (isset($_POST["image"])) 
    {
        $image = QuoteStr($_POST["image"]);
        $nom_article = QuoteStr($_POST["nom_article"]);
        $contenu = QuoteStr($_POST["contenu"]);
    }

    

    $auteur=GetSQLValue("select pseudo from compte where id_compte ='$id_compte'");
    $sql = "insert into article (auteur,nom_article,contenu,image) values ('$auteur','$nom_article','$contenu','$image')";


    if (!empty($nom_article) || !empty($contenu)) 
    {
        ExecuteSQL($sql);
        
        //htmlspecialchars(header("location: blog.php"));
    }
     
?>

<?php 
    if (isset($_POST['upload'])) {
        // Vérification si un fichier est bien téléchargé
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            $image = $_FILES['image'];
            $image_name = $image['name'];
            $image_tmp_name = $image['tmp_name'];
            $image_size = $image['size'];
            $image_error = $image['error'];

            // Récupérer l'extension du fichier
            $image_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

            // Vérification de l'extension et de la taille du fichier (max 5MB)
            if (in_array($image_extension, $allowed_extensions) && $image_size <= 5 * 1024 * 1024) {
                // Chemin de destination
                $upload_directory = 'uploads/';
                // Génération d'un nom unique pour éviter les conflits
                $new_image_name = uniqid('', true) . '.' . $image_extension;
                $image_destination = $upload_directory . $new_image_name;

                // Déplacer l'image dans le dossier final
                if (!is_dir($upload_directory)) {
                    mkdir($upload_directory, 0755, true);
                }

                if (move_uploaded_file($image_tmp_name, $image_destination)) {
                    // Insertion dans la base de données
                    $stmt = $pdo->prepare("INSERT INTO images (image_path) VALUES (:image_path)");
                    $stmt->bindParam(':image_path', $image_destination);

                    if ($stmt->execute()) {
                        echo "Image uploadée et enregistrée dans la base de données avec succès.";
                    } else {
                        echo "Erreur lors de l'enregistrement dans la base de données.";
                    }
                } else {
                    echo "Erreur lors du téléchargement de l'image.";
                }
            } else {
                echo "Extension non autorisée ou fichier trop volumineux.";
            }
        } else {
            echo "Veuillez sélectionner une image à uploader.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création d'article</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <h1>Articles</h1>
        <div class="onglets">
            <a href="blog.php">Home</a>
            <a href="creer_article.php">Créer un article</a>
        </div>
    </nav>
    <form method="POST">
    <input type="text" name="nom_article" placeholder="Sans titre" > 
    <br>
    <input type="text" name="contenu" placeholder="Corps de l'article">
    <input type="submit" value="Valider">
    </form>
    <h2>Uploader une image</h2>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <label for="image">Choisissez une image :</label>
        <input type="file" name="image" id="image" accept="image/*" required>
        <button type="submit" name="upload">Uploader</button>
    </form>
</body>
</html>
<?php mysqli_close($link) ?>