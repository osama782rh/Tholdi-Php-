<?php
session_start();
require_once 'config.php';



    $bdd = gestionnaireDeConnexion();
    // On récupere les données de l'utilisateur
     modifierUneReservation($codeReservation);
    

    header('location: consultation_location.php');


?>