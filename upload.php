<?php
    include ("config.php");
    EstConnecte();
    
    $id_compte = $_SESSION['id_compte'];
    $ret       = false;
    $img_blob  = '';
    $img_taille = 0;
    $img_type  = '';
    $img_nom   = '';
    $taille_max = 500000;
    $ret = is_uploaded_file($_FILES['image']['tmp_name']);
    
    if (isset($_POST["nom_article"])) 
    {
        //$image = QuoteStr($_POST["image"]);
        $nom_article = QuoteStr($_POST["nom_article"]);
        $contenu = QuoteStr($_POST["contenu"]);
        $auteur=GetSQLValue("select pseudo from compte where id_compte ='$id_compte'");
        $sql = "insert into article (auteur, nom_article, contenu) values ('$auteur', $nom_article, $contenu)";
        ExecuteSQL($sql);
        echo $sql;  // Débogage
        echo 'coucou';
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
            $auteur   = GetSQLValue("SELECT pseudo FROM compte WHERE id_compte ='$id_compte'");
            $id_article   = GetSQLValue("SELECT id_article FROM article WHERE nom_article =$nom_article");
            echo "$nom_article";
            
            // Correction : Utilisation de 'image' comme clé
            $img_blob = file_get_contents($_FILES['image']['tmp_name']);
            
            // Correction de l'insertion avec 'mysqli_query'
            $sql = "update article set image='" . addslashes($img_blob) . "' where id_article='$id_article'";
        
            
            // Utilisation de mysqli_query à la place de mysql_query
            $ret = mysqli_query($link, $sql) or die(mysqli_error($link));
            return true;
        }
    }
    
   
?>
