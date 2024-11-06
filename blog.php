<?php 
require 'config.php';
EstConnecte();

// Récupérer tous les articles de la base de données
$sql = "SELECT * FROM article ORDER BY date_creation DESC";
$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Cyber</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <h1>Blog Cyber</h1>
        <div class="onglets">
            <a href="blog.php">Home</a>
            <a href="creer_article.php">Créer un article</a>
            <a href="logout.php">Déconnexion</a>
        </div>
    </nav>

    <section class="articles">
        <?php
        // Vérifier si des articles ont été trouvés
        if (mysqli_num_rows($result) > 0) {
            while ($article = mysqli_fetch_assoc($result)) {
                $image = $article['image'] ? 'data:image/jpeg;base64,' . base64_encode($article['image']) : 'default_image.jpg';
                $date = date('d/m/Y', strtotime($article['date_creation']));
                $heure = date('H:i', strtotime($article['date_creation']));
        ?>
        <div class="article">
        <div class="left">
                <?php if (!empty($article['image'])): ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($article['image']); ?>" alt="Image de l'article">
                <?php endif; ?>
            </div>
            <div class="right">
                <p class="date"><?php echo $date; ?> à <?php echo $heure; ?></p>
                <h1><?php echo htmlspecialchars($article['nom_article']); ?></h1>
                <p class="description"><?php echo htmlspecialchars($article['contenu']); ?></p>
                <p class="auteur">Par : <?php echo htmlspecialchars($article['auteur']); ?></p>

                <!-- Formulaire de commentaire -->
                <form action="ajouter_commentaire.php" method="POST">
                    <input type="hidden" name="article_id" value="<?php echo $article['id_article']; ?>">
                    <textarea name="commentaire" required placeholder="Écrire un commentaire..."></textarea>
                    <button type="submit">Envoyer</button>
                </form>

                <!-- Affichage des commentaires -->
                <div class="commentaire">
                    <?php
                    // Récupérer les commentaires de l'article actuel en utilisant mysqli
                    $article_id = $article['id_article'];
                    $comment_sql = "SELECT commentaire.commentaire, commentaire.date, compte.pseudo 
                                    FROM commentaire
                                    JOIN compte ON commentaire.user_id = compte.id_compte 
                                    WHERE article_id = $article_id 
                                    ORDER BY date DESC";
                    $comment_result = mysqli_query($link, $comment_sql);

                    while ($commentaire = mysqli_fetch_assoc($comment_result)) {
                        echo "<p><strong>" . htmlspecialchars($commentaire['pseudo']) . "</strong> : " . htmlspecialchars($commentaire['commentaire']) . " <em>(" . $commentaire['date'] . ")</em></p>";
                    }
                    ?>
                </div>
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
