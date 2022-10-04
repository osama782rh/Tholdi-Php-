<?php 
        /*
           Attention ! le host => l'adresse de la base de données et non du site !!
        
           Pour ceux qui doivent spécifier le port ex : 
           $bdd = new PDO("mysql:host=CHANGER_HOST_ICI;dbname=CHANGER_DB_NAME;charset=utf8;port=3306", "CHANGER_LOGIN", "CHANGER_PASS");
           
         */

function gestionnaireDeConnexion(){
   try 
    {
        $bdd = new PDO("mysql:host=localhost;dbname=tholdi_ppe2;charset=utf8", "root", "");
    }catch (PDOException $err) {
        var_dump($err);
        die;
    }
    return $bdd;
}




function obtenirPays()
{
    $bdd = gestionnaireDeConnexion();
    $req = 'SELECT * FROM pays';
    $pdoStatement = $bdd->query($req);
    $lesPays = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    return $lesPays;
}


function obtenirVille()
{
    $bdd = gestionnaireDeConnexion();
    $req = "select * from ville";
    $pdoStatement = $bdd->query($req);
    $lesVilles = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    return $lesVilles;
}

function obtenirTypeContainer()
{
    $bdd = gestionnaireDeConnexion();
    $req = "SELECT * FROM typecontainer";
    $pdoStatement = $bdd->query($req);
    $lesContainers = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    return $lesContainers;
}





function ajouterUneReservation($dateDebutReservation, $dateFinReservation, $dateReservation, $volumeEstime, $codeVilleMiseDisposition, $codeVilleRendre, $codeUtilisateur)
{
    $bdd = gestionnaireDeConnexion();
    $dateReservation = time();
    $dateDebutReservation = strtotime($dateDebutReservation);
    $dateFinReservation = strtotime($dateFinReservation);
    $sql = "insert into reservation"
        . " (dateDebutReservation,dateFinReservation,dateReservation,"
        . " volumeEstime,codeVilleMiseDisposition,"
        . " codeVilleRendre,codeUtilisateur)"
        . " values ($dateDebutReservation,$dateFinReservation,$dateReservation
               ,$volumeEstime,$codeVilleMiseDisposition,$codeVilleRendre,"
        . "$codeUtilisateur)";
    $bdd->exec($sql);
    $lastInsertId = $bdd->lastInsertId();
    return $lastInsertId;

}


function ajouterLigneDeReservation($codeReservation,$numTypeContainer, $quantite)
{


  $bdd = gestionnaireDeConnexion();
  $sql = 'INSERT INTO reserver (codeReservation,numTypeContainer,qteReserver)  values ('.$codeReservation.','.$numTypeContainer.','.$quantite.')';
  $pdoStatement = $bdd->prepare($sql);
  $pdoStatement->execute();
 

}



function afficherNomVille()
{
    $bdd = gestionnaireDeConnexion();
    $sql = "SELECT nomVille FROM ville a, reservation b where a.codeVille = b.codeVille";
    $pdoStatement = $bdd->query($sql);
    $collectionville = $pdoStatement->fetchAll();
    return $collectionville;
}


function listeRerservation() {
    $lesReservations = array();

    $bdd = gestionnaireDeConnexion();
    $req = $bdd->prepare('SELECT codeUtilisateur FROM utilisateur WHERE token = ?');
    $req->execute(array($_SESSION['user']));
    $data = $req->fetch();
    $codeUtilisateur = $data['codeUtilisateur'];

    if(!empty($codeUtilisateur)){
        $sql ="(select * from reservation,reserver where reservation.codeReservation=reserver.codeReservation and reservation.codeUtilisateur='$codeUtilisateur')";
        $pdoStatement = $bdd->query($sql);
        $lesReservations = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
        return $lesReservations;
    }else{
        echo' Vous avez aucune reservation';
    }


}


function supprimerUneReservation($codeReservation){

    $bdd = gestionnaireDeConnexion();
    $req = $bdd->prepare('SELECT codeReservation FROM reservation  ORDER BY codeReservation DESC LIMIT  1');
    $req->execute();
    $data1 = $req->fetch();

    $codeReservation = $data1['codeReservation']; 

    $sql="DELETE FROM reserver WHERE codeReservation = $codeReservation";
    $pdoStatement = $bdd->prepare($sql);
    $pdoStatement->execute();
   
    $sql="DELETE FROM reservation WHERE codeReservation = $codeReservation";
    $pdoStatement = $bdd->prepare($sql);
    $pdoStatement->execute();
   
}


function modifierUneReservation($codeReservation){

   $bdd = gestionnaireDeConnexion();
    $req = $bdd->prepare('SELECT codeReservation FROM reservation  ORDER BY codeReservation DESC LIMIT  1');
    $req->execute();
    $data1 = $req->fetch();

    
    $codeReservation = $data1['codeReservation']; 

    $sql="Update * FROM reserver WHERE codeReservation = $codeReservation";
    $pdoStatement = $bdd->prepare($sql);
    $pdoStatement->execute();

 }

function afficherInfoUtilisateur($codeUtilisateur){
    $lesDonnees = array();
    $bdd = gestionnaireDeConnexion();
    $req = $bdd->prepare('SELECT codeUtilisateur FROM utilisateur WHERE token = ?');
    $req->execute(array($_SESSION['user']));
    $data = $req->fetch();
   

  
    $sql = "SELECT raisonSociale, adresse, cp, ville, adrMel, telephone, contact from utilisateur where codeUtilisateur= $codeUtilisateur";
    $lesDonnees = $bdd->query($sql);
    $lesDonnees = $lesDonnees->fetchAll();    
    return $lesDonnees;
}
function check_mdp_format($mdp)
{
	$majuscule = preg_match('@[A-Z]@', $mdp);
	$minuscule = preg_match('@[a-z]@', $mdp);
	$chiffre = preg_match('@[0-9]@', $mdp);
	
	if(!$majuscule || !$minuscule || !$chiffre || strlen($mdp) < 8)
	{
		return false;
	}
	else 
		return true;
}
?>