<?php
session_start();
require_once 'config.php';
// On se connecte à la base de données
    $bdd = gestionnaireDeConnexion();

    // On récupere les données de l'utilisateur

    supprimerUneReservation($codeReservation);
    header('location: consultation_location.php');
?>