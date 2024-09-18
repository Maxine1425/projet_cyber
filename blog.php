<?php 
    include ("config.php");
    EstConnecte();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <h1> Blog Cyber</h1>
        <div class="onglets">
            <a href="blog.php">Home</a>
            <a href="creer_article.php">Créer un articles</a>
        </div>
    </nav>

    <section class="articles">
        <div class="article">
            <div class="left">
                <img src="">
            </div>
            <div class="right">
                <p class="date"></p>
                <p class="heure"></p>
                <h1></h1>
                <p class="description"></p>
                <p class="auteur"></p>
            </div>
        </div>
    </section>
</body>
</html>
