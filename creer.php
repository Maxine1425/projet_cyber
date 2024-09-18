<?php 
    include ("config.php");

    if (isset($_POST["pseudo"]) && isset($_POST["password"]) && isset($_POST["mail"])) 
    {
        $pseudo = QuoteStr($_POST["pseudo"]);
        $password = QuoteStr($_POST["password"]);
        $mail = QuoteStr($_POST["mail"]);
        
        //chifrement password 
        $password_hashed = hash('sha256', $password);

        //verif si pseudo deja existant 
        $sql="select count(*) from compte where pseudo=$pseudo";
        $nb=GetSQLValue($sql);

        if ($nb == 0) 
        {
            //inserer nv compte
            $sql="insert into compte (id_compte, pseudo, password, mail) values (NULL, $pseudo, '$password_hashed', $mail)";
            ExecuteSQL($sql);
            htmlspecialchars (header("Location: blog.php"));
        } else 
        {
            $compte_existe = true;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte</title>
    <link  href="style.css" rel="stylesheet">
</head>
<body>

<h1>Créer un nouveau compte</h1>

<form method="POST">
    <input type="text" name="pseudo" placeholder="pseudo" required>
    <br>
    <input type="password" name="password" placeholder="password" required>
    <br>
    <input type="email" name="mail" placeholder="mail" required>
    <br>
    <?php if (isset($compte_existe) && $compte_existe == true) { ?>
        <p style="color:red;">Pseudo déjà utilisé</p>
    <?php } ?>
    <input type="submit" value="Créer le compte">
</form>

</body>
</html>
<?php mysqli_close($link); ?>



