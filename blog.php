<?php 
require 'config.php';
EstConnecte();

// Récupérer tous les articles de la base de données
$sql = "SELECT * FROM article ORDER BY date_creation DESC";
$result = mysqli_query($link, $sql);

/*$pdf = "SELECT id_pdf, name FROM pdf";
$result2 = mysqli_query($link, $pdf);*/
?>

<?php

/*if (isset($_GET['id_article'])) {
    $id = intval($_GET['id_article']);

    // Récupérer le fichier
    $sql_pdf = prepare("SELECT pdf FROM article WHERE id_article = ?");
    mysqli_bind_param($sql_pdf,"i", $id);
    GetSQLValue($sql_pdf);
    mysqli_bind_result($sql_pdf);
    mysqli_fetch($sql_pdf);

    if ($file) {
        // Envoyer les en-têtes pour télécharger le fichier
        header('Content-Type: application/pdf');
        //header('Content-Disposition: attachment; filename="' . $name . '"');
        echo $sql_pdf;
    } else {
        echo "Fichier non trouvé.";
    }
}*/
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
                <div class="liste des pdf">
                    <?php
                        /*if ($result2 > 0) 
                        {
                            while ($row = mysqli_fetch_assoc($result2)) {
                                echo '<li><a href="download.php?id=' . $row['id_pdf'] . '">' . htmlspecialchars($row['name']) . '</a></li>';
                            }
                        } 
                        else 
                        {
                            echo "<li>Aucun fichier trouvé.</li>";
                        }*/
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
