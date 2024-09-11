<?php 
    include ("config.php");
    $mauvaislogin=false;
    $_SESSION['isConnected']=false;

    if(isset($_POST["pseudo"]) && isset($_POST["password"]))
    {
        
        $pseudo = QuoteStr($_POST["pseudo"]);
        $password = QuoteStr($_POST["password"]);
        $password_hashed = hash('sha256', $password);
        

        $sql="select count(*) from compte where pseudo=$pseudo and password='$password_hashed'";
        $nb=GetSQLValue($sql);
        $id_compte=GetSQLValue("select id_compte from compte where pseudo=$pseudo ");


        if ($nb != 0)
        {
            $_SESSION['isConnected']=true; 
            $_SESSION['pseudo']=$pseudo;
            $_SESSION['id_compte']=$id_compte;
            header("Location: liste.php");
            
        }
        else
        {
            $mauvaislogin=true;
        }

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conection</title>
    <link  href="css/style.css" rel="stylesheet">
</head>
<body>


<h1> Merci de vous connecter </h1>

<form method="POST">

    <input type="text" name="pseudo" placeholder="mets ton pseudo" > 
    <br>
    <input type="password" name="password">
    <?php if($mauvaislogin==true){?>
        password incorect
    <?php } ?>
    <br>
    <a href="creer.php"> créer un nouveau compte </a>    
    <br>
    <input type="submit" value="Connexion">

</form>

</body>
</html>
<?php mysqli_close($link) ?>