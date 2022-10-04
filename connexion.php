<?php 
    session_start(); // Démarrage de la session
    require_once 'config.php'; // On inclut la connexion à la base de données

    if(!empty($_POST['adrMel']) && !empty($_POST['mdp'])) // Si il existe les champs email, password et qu'il sont pas vident
{
        // Patch XSS
        $adrMel  = htmlspecialchars($_POST['adrMel']);
        $mdp  = htmlspecialchars($_POST['mdp']);

        $adrMel = strtolower($adrMel);  // email transformé en minuscule
        
         $bdd = gestionnaireDeConnexion();
        // On regarde si l'utilisateur est inscrit dans la table utilisateurs
        $check = $bdd->prepare('SELECT codeUtilisateur , login, adrMel, mdp, token FROM utilisateur WHERE adrMel = ?');
        $check->execute(array($adrMel));
        $data = $check->fetch();
        $row = $check->rowCount();


        // $prep = $bdd->prepare('SELECT codeUtilisateur FROM utilisateur WHERE adrMel= ?');
        // $prep->execute(array($codeUtilisateur));
        // $code = $prep->fetch();
   

        

        // Si > à 0 alors l'utilisateur existe
        if($row > 0)
        {
            // Si le mail est bon niveau format
            if(filter_var($adrMel, FILTER_VALIDATE_EMAIL))
            {
                // Si le mot de passe est le bon
                if(password_verify($mdp, $data['mdp']))
                {
                    // On créer la session et on redirige sur landing.php
                    $_SESSION['user'] = $data['token'];
                    $_SESSION['user_reservation'] = $data['codeUtilisateur'];
                     $_SESSION['user_id'] = $data['adrMel'];
                    $_SESSION["codeUtilisateur"] =  $data['codeUtilisateur'];
                   //$_SESSION['codeUtilsateur'] = $row['uidUsers'];
                    header('Location: landing.php');
                    die();
                }else{ header('Location: index.php?login_err=password'); die(); }
            }else{ header('Location: index.php?login_err=email'); die(); }
        }else{ header('Location: index.php?login_err=already'); die(); }
    }else{ header('Location: index.php'); die();} // si le formulaire est envoyé sans aucune données
?>