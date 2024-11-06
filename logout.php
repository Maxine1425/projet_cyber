<?php
require 'config.php';
EstConnecte();

session_unset(); // Supprime toutes les variables de session
session_destroy(); // Détruit la session active
header("Location: connexion.php"); // Redirige vers la page de connexion
exit();
?>
