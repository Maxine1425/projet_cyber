<?php
require 'config.php';
EstConnecte();

// Diagnostic des données reçues
if (!isset($_POST['commentaire'])) {
    echo "Le champ 'commentaire' n'a pas été reçu.";
    exit();
}

if (!isset($_POST['article_id'])) {
    echo "Le champ 'article_id' n'a pas été reçu.";
    exit();
}

if (!isset($_SESSION['user_id'])) {
    echo "La session 'user_id' n'est pas définie.";
    exit();
}

$commentaire = mysqli_real_escape_string($link, $_POST['commentaire']);
$article_id = (int)$_POST['article_id']; // int pour convertir pour etre sur que article_id est bien un entier 
$user_id = $_SESSION['user_id'];

// Insertion du commentaire dans la base de données
$sql = "INSERT INTO commentaire (article_id, user_id, commentaire) VALUES ($article_id, $user_id, '$commentaire')";
$insert_result = mysqli_query($link, $sql);

if (!$insert_result) {
    die("Erreur lors de l'insertion du commentaire : " . mysqli_error($link));
}

// Redirection après ajout du commentaire
header("Location: blog.php");
exit();
?>
