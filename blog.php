<?php 
    include ("config.php");
    EstConnecte();

    // Récupérer tous les articles de la base de données
    $sql = "SELECT * FROM article ORDER BY date_creation DESC";
    $result = mysqli_query($link, $sql);
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
            <a href="creer_article.php">Créer un article</a>
        </div>
    </nav>

    <section class="articles">
        <?php
        // Vérifier si des articles ont été trouvés
        if (mysqli_num_rows($result) > 0) {
            // Parcourir chaque article
            while ($article = mysqli_fetch_assoc($result)) {
                // Si une image est présente, la convertir en base64 pour l'affichage
                $image = $article['image'] ? 'data:image/jpeg;base64,' . base64_encode($article['image']) : 'default_image.jpg'; // Remplacez par l'image par défaut si pas d'image
                $date = date('d/m/Y', strtotime($article['date_creation']));
                $heure = date('H:i', strtotime($article['date_creation']));
        ?>
        <div class="article">
            <div class="left">
                <img src="<?php echo $image; ?>" alt="Image de l'article">
            </div>
            <div class="right">
                <p class="date"><?php echo $date; ?></p>
                <p class="heure"><?php echo $heure; ?></p>
                <h1><?php echo htmlspecialchars($article['nom_article']); ?></h1>
                <p class="description"><?php echo htmlspecialchars($article['contenu']); ?></p>
                <p class="auteur"><?php echo htmlspecialchars($article['auteur']); ?></p>
            </div>
        </div>
        <?php
            }
        } else {
            echo "<p>Aucun article n'a été trouvé.</p>";
        }
        ?>
    </section>
</body>
</html>

<?php mysqli_close($link); ?>
