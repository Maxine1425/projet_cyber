<?php

    require 'config.php';
    EstConnecte();
    if (isset($_POST['import'])) {

        // Vérification du fichier
        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $fileName = $_FILES['file']['name'];
            $fileTmpPath = $_FILES['file']['tmp_name'];
            $fileType = $_FILES['file']['type'];

            // Vérifier que le fichier est un PDF
            if ($fileType === 'application/pdf') {
                $fileContent = file_get_contents($fileTmpPath);

                // Préparer la requête
                $sql = prepare("INSERT INTO pdf (name, file) VALUES (?, ?)");
                mysqli_bind_param($sql,"sb", $fileName, $fileContent);
                
                if (ExecuteSQL($sql)) {
                    echo "Fichier téléchargé et enregistré avec succès !";
                } else {
                    echo "Erreur lors de l'enregistrement du fichier : " . $sql->error;
                }

            } else {
                echo "Veuillez importer uniquement des fichiers PDF.";
            }
        } else {
            echo "Erreur lors de l'import du fichier.";
        }

    }
    header("Location: blog.php");
    // ExecuteSQL($sql);
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>