<?php
    include ("config.php");
    EstConnecte();
    //$id_article = $_SESSION['id_article'];
    $id_compte = $_SESSION['id_compte'];
    $ret       = false;
    $img_blob  = '';
    $img_taille = 0;
    $img_type  = '';
    $img_nom   = '';
    $taille_max = 500000;
    
    $ret = is_uploaded_file($_FILES['image']['tmp_name']);
    
    if (!$ret) {
        echo "Problème de transfert";
        return false;
    } else {
        // Le fichier a bien été reçu
        $img_taille = $_FILES['image']['size'];
        
        if ($img_taille > $taille_max) {
            echo "Fichier trop volumineux";
            return false;
        }

        $img_type = $_FILES['image']['type'];
        $img_nom  = $_FILES['image']['name'];
        $auteur   = GetSQLValue("SELECT pseudo FROM compte WHERE id_compte ='$id_compte'");
        echo "$auteur"
        
        // Correction : Utilisation de 'image' comme clé
        $img_blob = file_get_contents($_FILES['image']['tmp_name']);
        
        // Correction de l'insertion avec 'mysqli_query'
        $sql = "update article set image='" . addslashes($img_blob) . "' where auteur='$auteur'";
        echo "$sql"
        
        // Utilisation de mysqli_query à la place de mysql_query
        $ret = mysqli_query($link, $sql) or die(mysqli_error($link));
        
        return true;
    }
?>
