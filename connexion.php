<?php 
require 'config.php';
//session_start(); // Démarre la session mais deja mi dans config

$mauvaislogin = false;
$_SESSION['isConnected'] = false;

if (isset($_POST["pseudo"]) && isset($_POST["password"])) {
    
    $pseudo = QuoteStr($_POST["pseudo"]);
    $password = QuoteStr($_POST["password"]);
    $password_hashed = hash('sha256', $password);

    // Vérifie si le pseudo et le mot de passe sont corrects
    $sql = "SELECT COUNT(*) FROM compte WHERE pseudo=$pseudo AND password='$password_hashed'";
    $nb = GetSQLValue($sql);

    // Récupère l'ID du compte associé
    $id_compte = GetSQLValue("SELECT id_compte FROM compte WHERE pseudo=$pseudo");

    if ($nb != 0) {
        // Définit les variables de session
        $_SESSION['isConnected'] = true;
        $_SESSION['pseudo'] = $pseudo;
        $_SESSION['user_id'] = $id_compte; // Définit la session user_id pour la cohérence

        header("Location: blog.php"); // Redirige vers la page du blog
        exit();
    } else {
        $mauvaislogin = true;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <h1>Merci de vous connecter</h1>

    <form method="POST">
        <input type="text" name="pseudo" placeholder="mets ton pseudo" required> 
        <br>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <br>
        <?php if ($mauvaislogin) { ?>
            <p style="color: red;">Erreur d'authentification</p>
        <?php } ?>
        <a href="creer.php">Créer un nouveau compte</a>    
        <br>
        <input type="submit" value="Connexion">
    </form>
</body>
</html>

<?php mysqli_close($link); ?>
