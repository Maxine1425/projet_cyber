<?php
require 'config.php';
EstConnecte();

$id_compte = $_SESSION['user_id']; // ID du compte de l'utilisateur connecté
$taille_max = 100000; // Taille max du fichier image en octets
$types_valides = ['image/jpeg', 'image/png', 'image/gif']; // Types de fichiers acceptés pour les images

if (isset($_POST["nom_article"])) {
    // Utiliser mysqli_real_escape_string pour échapper les données de l'utilisateur
    $nom_article = mysqli_real_escape_string($link, $_POST["nom_article"]);
    $contenu = mysqli_real_escape_string($link, $_POST["contenu"]);
    $auteur = GetSQLValue("SELECT pseudo FROM compte WHERE id_compte = $id_compte");
    $same_nom_article = GetSQLValue("SELECT COUNT(*) FROM article WHERE nom_article = '$nom_article'");

    // Vérification si le titre est déjà utilisé
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
    $sql = "INSERT INTO article (compte_id, auteur, nom_article, contenu) VALUES ($id_compte, '$auteur', '$nom_article', '$contenu')";
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

    // Traitement du fichier PDF
    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
        $pdfTmpPath = $_FILES['pdf']['tmp_name'];
        $pdfType = $_FILES['pdf']['type'];
        $pdfsize = $_FILES['pdf']['size'];

        if ($pdfsize > $taille_max) {
            echo "Fichier trop volumineux";
            exit();
        }

        // Vérifier que le fichier est un PDF
        if ($pdfType === 'application/pdf') {
            $pdfContent = file_get_contents($pdfTmpPath);

            // Préparer la requête pour insérer le PDF dans la base de données
            $sql = "UPDATE article SET pdf='" . addslashes($pdfContent) . "' WHERE id_article=$id_article";
            $ret = mysqli_query($link, $sql) or die("Erreur lors de l'ajout du pdf : " . mysqli_error($link));
        } else {
            echo "Erreur : Veuillez importer uniquement des fichiers PDF.";
            exit();
        }
    }

    // Rediriger vers la page du blog après l'ajout
    header("Location: blog.php");
    exit();
}
?>
