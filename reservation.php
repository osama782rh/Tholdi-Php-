
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
   
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Tholdi - Site de réservation de container </title>
        <link rel="stylesheet" type="text/css" href="css/location.css">
        <meta charset="utf-8">
        <link rel="icon" href="image/THOLDI.png">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">  <!--bootstrap-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>  <!--googleapis jquery-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">  <!--font-awesome-->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>                          <!--bootstrap-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>           <!--bootstrap-->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script> 
        <link rel="stylesheet" type="text/css" href="css/form.css">
    </head>
<body>
	<!--Nav-->

    <?php
    include_once('header.php');
?>
	<!--Nav-->



<?php 
                if(isset($_GET['reg_err']))
                {
                    $err = htmlspecialchars($_GET['reg_err']);

                    switch($err)
                    {
                        case 'success':
                        ?>
                            <div class="alert alert-success">
                                <strong>Succès</strong> reservation réussie !
                            </div>
                        <?php
                        break;
                         case 'error':
                        ?>
                            <div class="alert alert-error">
                                <strong>Succès</strong> reservation raté!
                            </div>
                        <?php
                        break;
                     

                    }
                }
                ?>

<div class="flex">
  <div class="wrapper">
    <h1>Reservation</h1>
    <form action="location-2.traitement.php" method="post">
    <label>Debut de la location</label>
    <input type="date" name="dateDebutReservation" required >

      <label>Fin de la location</label>
    <input type="date" name="dateFinReservation" required>

    <label>Volume estimé (kg)</label>
    <input type="number" min="0" max="350000" name="volumeEstime" required>

    <label class="ville">Lieu de départ</label>
            <?php
            $collectionVilles = obtenirVille();
            ?>
            <select name="codeVilleMiseDisposition">
                <?php
                foreach ($collectionVilles as $ville) :
                    ?>
                    <option value="<?php echo $ville["codeVille"]; ?>">
                        <?php echo $ville["nomVille"]; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            
        <label class="ville">Lieu darriver</label>
            <select name="codeVilleRendre">
                <?php
                foreach ($collectionVilles as $ville) :
                    if($ville == $ville)
                    ?>
                    <option value="<?php echo $ville["codeVille"]; ?>">
                        <?php echo $ville["nomVille"]; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" name="submit" > Ajouter une reservation</button>

    </form>


  </div>
 </div>

  <!--Footer-->

	<!--Footer-->

</body>
</html>