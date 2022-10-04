<?php 
    session_start();
    require_once 'config.php'; // ajout connexion bdd 
   // si la session existe pas soit si l'on est pas connecté on redirige
    if(!isset($_SESSION['user'])){
        header('Location:index.php');
        die();
    }

     $bdd = gestionnaireDeConnexion();
    // On récupere les données de l'utilisateur
    $req = $bdd->prepare('SELECT * FROM utilisateur WHERE token = ?');
    $req->execute(array($_SESSION['user']));
    $data = $req->fetch();

    $codeReservationRecherche = $data['codeUtilisateur'];
	$colllectionReservation = listeRerservation();
   
?>

<!DOCTYPE html>
<html>
<head>
	<title>Tholdi - Consultation Location</title>
	<meta charset="utf-8">
	<link rel="icon" href="image/THOLDI.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/form.css">

</head>

<body>
	<!--Nav-->

    <?php
    include_once('header.php');
?>
    <!--Tableau de consultation-->

<div class="flex">
<table class="table">
  <thead>
    <tr>
    <td>Code Reservation</td>      
        <td>La date de début de votre réservation</td>
        <td>La date de fin de votre réservation</td>       
        <td>Le volume</td> 
        <td>Ville de départ</td>
        <td>Ville d'arrivé</td>
       <td>Type de containers</td>
      <td>Quantité de containers</td> 
    </tr>
  </thead>
  <tbody>
    <tr>
    <?php
       $collectionReservation = listeRerservation();
            foreach ($collectionReservation as $lesReservations) :
                ?>
            <tr>    
                <td><?php echo $lesReservations["codeReservation"]; ?></td>
                    <td> <?php echo date('d/m/Y',$lesReservations["dateDebutReservation"])?></td>
                    <td><?php echo date('d/m/Y',$lesReservations["dateFinReservation"]); ?></td>
                    <td><?php echo $lesReservations["volumeEstime"]; ?></td>
                     <td><?php echo $lesReservations["codeVilleMiseDisposition"]; ?></td>
                     <td><?php echo $lesReservations["codeVilleRendre"]; ?></td>
                     <td><?php echo $lesReservations["numTypeContainer"]; ?></td>
                     <td><?php echo $lesReservations["qteReserver"]; ?></td>
                     <td><form action="delete.php" method='post'><button>Supprimer</button></form></td>
                     <td><form action="SaisirUpdate.php" method='post'><button>Modifier</button></form></td>
                     <td><form action="pdf.php" method='post'><button>Devis</button></form></td>
                <?php endforeach; ?>
            </tr>
  </tbody>
</table>
</div>
</body>
</html>
