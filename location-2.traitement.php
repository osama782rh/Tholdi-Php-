
<?php 
    session_start();
    require_once 'config.php'; // ajout connexion bdd 
   // si la session existe pas soit si l'on est pas connecté on redirige
    if(!isset($_SESSION['user'])){
        header('Location:index.php');
        die();
    }

    // $bdd = gestionnaireDeConnexion();
    // // On récupere les données de l'utilisateur
    // $req = $bdd->prepare('SELECT * FROM utilisateur WHERE token = ?');
    // $req->execute(array($_SESSION['user']));
    // $data = $req->fetch();

    // $req = $bdd->prepare('SELECT codeReservation FROM reservation  ORDER BY codeReservation DESC LIMIT  1');
    // $req->execute();
    // $data1 = $req->fetch();
   
   
// On inclu la connexion à la bdd

    // Si les variables existent et qu'elles ne sont pas vides
if(!empty($_POST['dateDebutReservation']) and  !empty($_POST['dateFinReservation']) and !empty($_POST['volumeEstime']) and !empty($_POST['codeVilleMiseDisposition']) and !empty($_POST['codeVilleRendre'])){


    $bdd = gestionnaireDeConnexion();
    // On récupere les données de l'utilisateur
    $req = $bdd->prepare('SELECT codeUtilisateur FROM utilisateur WHERE token = ?');
    $req->execute(array($_SESSION['user']));
    $data = $req->fetch();
   

	$dateDebutReservation =  $_POST["dateDebutReservation"];
	$dateFinReservation =  $_POST["dateFinReservation"];
	$dateReservation = date('m-d-Y');
	$volumeEstime =  $_POST["volumeEstime"];
	$codeVilleMiseDisposition = $_POST["codeVilleMiseDisposition"];
	$codeVilleRendre =  $_POST["codeVilleRendre"];
	$codeUtilisateur = $data['codeUtilisateur'];


    if($codeVilleMiseDisposition != $codeVilleRendre){
        if($dateFinReservation > $dateDebutReservation && $dateDebutReservation >= $dateReservation){
            ajouterUneReservation($dateDebutReservation, $dateFinReservation, $dateReservation, $volumeEstime, $codeVilleMiseDisposition, $codeVilleRendre, $codeUtilisateur);
            $req = $bdd->prepare('SELECT codeReservation FROM reservation  ORDER BY codeReservation DESC LIMIT  1');
            $req->execute();
            $data1 = $req->fetch();
            $codeReservation = $data1['codeReservation'];    
            header('Location: SaisirReservation.php');
        }else{ header('Location: reservation.php?reg_err=error'); die();}     
    }else{ header('Location: reservation.php?reg_err=error'); die();}
}else{header('Location: reservation.php?reg_err=error'); die();}





?>








