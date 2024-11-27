<?php
    require 'config.php';
    EstConnecte(); 
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
            <a href="logout.php">Déconnexion</a>
        </div>
    </nav>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="nom_article" placeholder="Sans titre" required > 
    <br>
        <input type="text" name="contenu" placeholder="Corps de l'article" required>
    <br>
        <label for="image">Choisissez une image :</label>
        <input type="file" name="image"> 
    <br>
        <label for="pdf_file">Choisir un fichier PDF :</label>
        <input type="file" name="pdf_file" id="pdf_file" accept="application/pdf" required>
    </br>
        <input type="submit" value="Valider">
    </form>
    <br>
</body>
</html>
<?php mysqli_close($link) ?>


