<?php
    include ("config.php");
    EstConnecte();
    $id_compte=$_SESSION['id_compte'];
    $ret        = false;
    $img_blob   = '';
    $img_taille = 0;
    $img_type   = '';
    $img_nom    = '';
    $taille_max = 250000;
    $ret        = is_uploaded_file($_FILES['image']['tmp_name']);
        
    if (!$ret)
    {
        echo "Problème de transfert";
        return false;
    } 
    else 
    {
        // Le fichier a bien été reçu
        $img_taille = $_FILES['image']['size'];
            
        if ($img_taille > $taille_max) 
        {
            echo "Fichier trop volumineux";
            return false;
        }

        $img_type = $_FILES['image']['type'];
        $img_nom  = $_FILES['image']['name'];
        $auteur=GetSQLValue("select pseudo from compte where id_compte ='$id_compte'");
        $img_blob = file_get_contents ($_FILES['name']['tmp_name']);
        $sql = "INSERT INTO article WHERE auteur ='$auteur' ('image') VALUES ("addslashes ($img_blob)") ";
        $ret = mysql_query ($sql) or die (mysql_error ());
        return true;
        }
    
    if (isset($_POST["image"])) 
    {
        $image = QuoteStr($_POST["image"]);
        $nom_article = QuoteStr($_POST["nom_article"]);
        $contenu = QuoteStr($_POST["contenu"]);
        $auteur=GetSQLValue("select pseudo from compte where id_compte ='$id_compte'");
        $sql = "insert into article (auteur,nom_article,contenu,image) values ('$auteur','$nom_article','$contenu','$image')";

        ExecuteSQL($sql);
    }

    

    //$auteur=GetSQLValue("select pseudo from compte where id_compte ='$id_compte'");
    //$sql = "insert into article (auteur,nom_article,contenu,image) values ('$auteur','$nom_article','$contenu','$image')";


    /*if (!empty($nom_article) && !empty($contenu)) 
    {
        ExecuteSQL($sql);
        
        //htmlspecialchars(header("location: blog.php"));
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
    <form method="POST">
    <input type="text" name="nom_article" placeholder="Sans titre" required > 
    <br>
    <input type="text" name="contenu" placeholder="Corps de l'article" required>
    <input type="submit" value="Valider">
    </form>
    <h2>Uploader une image</h2>
    <form action="creer_article.php" method="POST" enctype="multipart/form-data">
        <label for="image">Choisissez une image :</label>
        <input type="file" name="image">
        <button type="submit" name="upload">Uploader</button>
    </form>
</body>
</html>
<?php mysqli_close($link) ?>