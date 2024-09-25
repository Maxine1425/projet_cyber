<?php
    include ("config.php");
    EstConnecte();
    $id_compte=$_SESSION['id_compte'];
    $ret        = false;
    $img_blob   = '';
    $img_taille = 0;
    $img_type   = '';
    $img_nom    = '';
    $taille_max = 250000;
    $ret        = is_uploaded_file($_FILES['image']['tmp_name']);
        
    if (!$ret)
    {
        echo "Problème de transfert";
        return false;
    } 
    else 
    {
        // Le fichier a bien été reçu
        $img_taille = $_FILES['image']['size'];
            
        if ($img_taille > $taille_max) 
        {
            echo "Fichier trop volumineux";
            return false;
        }

        $img_type = $_FILES['image']['type'];
        $img_nom  = $_FILES['image']['name'];
        $auteur=GetSQLValue("select pseudo from compte where id_compte ='$id_compte'");
        $img_blob = file_get_contents ($_FILES['name']['tmp_name']);
        $sql = "INSERT INTO article WHERE auteur ='$auteur' ('image') VALUES ("addslashes ($img_blob)") ";
        $ret = mysql_query ($req) or die (mysql_error ());
        return true;
        }
?>
