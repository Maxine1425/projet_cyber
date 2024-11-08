<?php
require 'config.php';
EstConnecte();

$id_compte = $_SESSION['user_id']; // ID du compte de l'utilisateur connecté
$taille_max = 50000;
$types_valides = ['image/jpeg', 'image/png', 'image/gif']; // Types de fichiers acceptés

if (isset($_POST["nom_article"])) 
{
    $nom_article = QuoteStr($_POST["nom_article"]);
    $contenu = QuoteStr($_POST["contenu"]);
    $auteur = GetSQLValue("SELECT pseudo FROM compte WHERE id_compte = $id_compte");
    $same_nom_article = GetSQLValue("SELECT COUNT(*) FROM article WHERE nom_article = $nom_article");

    // Vérifier si le titre est déjà utilisé
    if ($same_nom_article != 0) {
        echo "Titre déjà utilisé";
        exit();
    }

    // Vérification de l'image si elle est fournie
    if (is_uploaded_file($_FILES['image']['tmp_name'])) {
        $img_taille = $_FILES['image']['size'];
        $img_type = $_FILES['image']['type'];

        if ($img_taille > $taille_max) {
            echo "Fichier trop volumineux";
            exit();
        }

        if (!in_array($img_type, $types_valides)) {
            echo "Type de fichier non valide. Seuls les formats JPEG, PNG et GIF sont acceptés.";
            exit();
        }
    }

    // Insertion de l'article avec compte_id
    $sql = "INSERT INTO article (compte_id, auteur, nom_article, contenu) VALUES ($id_compte, '$auteur', $nom_article, $contenu)";
    $insert_result = mysqli_query($link, $sql);

    if (!$insert_result) {
        die("Erreur lors de l'insertion de l'article : " . mysqli_error($link));
    }

    // Récupération de l'ID de l'article
    $id_article = mysqli_insert_id($link);
    if (!$id_article) {
        die("Erreur : l'ID de l'article inséré n'a pas été récupéré.");
    }

    // Mise à jour de l'image si elle est fournie et respecte les critères
    if (is_uploaded_file($_FILES['image']['tmp_name'])) {
        $img_blob = file_get_contents($_FILES['image']['tmp_name']);
        $sql = "UPDATE article SET image='" . addslashes($img_blob) . "' WHERE id_article=$id_article";
        $ret = mysqli_query($link, $sql) or die("Erreur lors de l'ajout de l'image : " . mysqli_error($link));
    }

    header("Location: blog.php");
    exit();
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
            <a href="logout.php">Déconnexion</a>
        </div>
    </nav>
</body>
</html>
<?php mysqli_close($link); ?>
