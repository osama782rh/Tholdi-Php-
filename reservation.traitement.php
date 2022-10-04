<?php
    session_start();
    require_once 'config.php'; // ajout connexion bdd 
   // si la session existe pas soit si l'on est pas connecté on redirige
    if(!isset($_SESSION['user'])){
        header('Location:index.php');
        die();
    }

 //création d'un tableau a partir du résultat de la requête SQL
    echo'test';
    // Si les variables existent et qu'elles ne sont pas vides
    if(!empty($_POST['typeContainer']) and  !empty($_POST['quantite'])){

      
	  $bdd = gestionnaireDeConnexion();
      $req = $bdd->prepare('SELECT codeReservation FROM reservation  ORDER BY codeReservation DESC LIMIT  1');
      $req->execute();
      $data1 = $req->fetch();
      
      
      $numTypeContainer = $_POST["typeContainer"];

      $quantite = $_POST["quantite"];
      $codeReservation = $data1['codeReservation']; 
  
      ajouterLigneDeReservation($codeReservation,$numTypeContainer, $quantite);
  

    header('Location: SaisirReservation.php?reg_err=success');

    }else{
        header('Location: inscription.php?reg_err=error'); die();
    }

?>