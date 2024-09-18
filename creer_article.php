<?php
    include ("config.php");
    $link = mysqli_connect("127.0.0.1", "root", "l'ec'efmtnc'ePD33", "projet_cybermaco");
    EstConnecte();
    $id_compte=$_SESSION['id_compte'];
    
    if (isset($_POST["image"])) 
    {
        $image = QuoteStr($_POST["image"]);
        $nom_article = QuoteStr($_POST["nom_article"])
        $contenu = QuoteStr($_POST["contenu"])
    }

    $auteur=GetSQLValue("select pseudo from `compte` where id_compte ='$id_compte'");
    $sql = "insert into `article` (`auteur`,`nom_article`) values ('$auteur','$nom_article','$contenu','$image')";
    ExecuteSQL($sql);
    //htmlspecialchars(header("location: blog.php")); 
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
            <a href="#">Home</a>
            <a href="#">Articles</a>
        </div>
    </nav>
    <form method="POST">
    <input type="text" name="nom_article" placeholder="Sans titre" > 
    <br>
    <input type="text" name="contenu" placeholder="Corps de l'article">
    <input type="submit" value="Connexion">

    </form>
</body>
</html>
<?php mysqli_close($link) ?>
