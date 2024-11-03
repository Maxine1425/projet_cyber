<?php
    include ("config.php");
    EstConnecte();
/* 
    $id_compte=$_SESSION['id_compte'];
    
    if (isset($_POST["nom_article"])) 
    {
        //$image = QuoteStr($_POST["image"]);
        $nom_article = QuoteStr($_POST["nom_article"]);
        $contenu = QuoteStr($_POST["contenu"]);
        $auteur=GetSQLValue("select pseudo from compte where id_compte ='$id_compte'");
        $sql = "insert into article (auteur, nom_article, contenu) values ('$auteur', $nom_article, $contenu)";

        echo $sql;  // Débogage
        echo 'coucou';
        ExecuteSQL($sql);
    }*/
 
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
    <form action="upload.php" method="POST" enctype="multipart/form-data">
    <input type="text" name="nom_article" placeholder="Sans titre" required > 
    <br>
    <input type="text" name="contenu" placeholder="Corps de l'article" required>
    <!-- <form action="upload.php" method="POST" enctype="multipart/form-data">
        <label for="image">Choisissez une image :</label>
        <input type="file" name="image">    
    </form>-->
    <br>
    <label for="image">Choisissez une image :</label>
    <input type="file" name="image"> 
    <br>
    <input type="submit" value="Valider">
    </form>
    
   <!-- <form action="upload.php" method="POST" enctype="multipart/form-data">
        <label for="image">Choisissez une image :</label>
        <input type="file" name="image">    
    </form>-->

</body>
</html>
<?php mysqli_close($link) ?>
