<?php 
    require_once 'config.php'; // On inclu la connexion à la bdd

    // Si les variables existent et qu'elles ne sont pas vides
   if (!empty($_POST['raisonSociale']) and !empty($_POST['adresse']) and !empty($_POST['cp']) and !empty($_POST['ville']) and !empty($_POST['adrMel']) and !empty($_POST['telephone']) and !empty($_POST['contact']) and !empty($_POST['codePays']) and !empty($_POST['login']) and !empty($_POST['mdp']) and !empty($_POST['mdp2']))

    {
        // Patch XSS
        $raisonSociale =  htmlspecialchars($_POST['raisonSociale']);
        $adresse =  htmlspecialchars($_POST['adresse']);
        $cp =  htmlspecialchars($_POST['cp']);
        $ville =  htmlspecialchars($_POST['ville']);
        $adrMel =  htmlspecialchars($_POST['adrMel']);
        $telephone =  htmlspecialchars($_POST['telephone']);
        $contact =  htmlspecialchars($_POST['contact']);
        $codePays =  htmlspecialchars($_POST['codePays']);
        $login =  htmlspecialchars($_POST['login']);
        $mdp =  htmlspecialchars($_POST['mdp']);
        $mdp2 =  htmlspecialchars($_POST['mdp2']);

        $bdd = gestionnaireDeConnexion();

        // On vérifie si l'utilisateur existe
        $check = $bdd->prepare('SELECT  login,adrMel, mdp FROM utilisateur WHERE adrMel = ?');
        $check->execute(array($adrMel));
        $data = $check->fetch();
        $row = $check->rowCount();

       
        $adrMel = strtolower($adrMel); // on transforme toute les lettres majuscule en minuscule pour éviter que Foo@gmail.com et foo@gmail.com soient deux compte différents ..
        
        // Si la requete renvoie un 0 alors l'utilisateur n'existe pas 
        if($row == 0)
        { 
            if(strlen($login) <= 100 && strlen($login) >= 10)
            { // On verifie que la longueur du pseudo <= 100
                if(strlen($adrMel) <= 100)
                { // On verifie que la longueur du mail <= 100
                    if(filter_var($adrMel, FILTER_VALIDATE_EMAIL))
                    { // Si l'email est de la bonne forme
                        if($mdp === $mdp2)
                        {// si les deux mdp saisis sont bon
                            if(check_mdp_format($mdp) == true){
                               
                                // On hash le mot de passe avec Bcrypt, via un coût de 12
                                $cost = ['cost' => 12];
                                $mdp = password_hash($mdp, PASSWORD_BCRYPT, $cost);
                                
                                // On stock l'adresse IP
                                $ip = $_SERVER['REMOTE_ADDR']; 
                                /*
                                ATTENTION
                                Verifiez bien que le champs token est présent dans votre table utilisateurs, il a été rajouté APRÈS la vidéo
                                le .sql est dispo pensez à l'importer ! 
                                ATTENTION
                                */
                                // On insère dans la base de données


                                $sql = ("INSERT INTO utilisateur (raisonSociale, adresse, cp, ville, adrMel, telephone, contact,codePays,login, mdp,ip, token) VALUES (:raisonSociale,:adresse,:cp,:ville,:adrMel,:telephone,:contact,:codePays,:login,:mdp,:ip,:token)");
                                $insert = $bdd->prepare($sql);

                                $insert->execute(array(
                                    'raisonSociale' => $raisonSociale,
                                    'adresse' => $adresse,
                                    'cp' =>  $cp ,
                                    'ville' =>  $ville,
                                    'adrMel' => $adrMel,
                                    'telephone' => $telephone,
                                    'contact' => $contact,
                                    'codePays' => $codePays,
                                    'login' =>  $login,
                                    'mdp' =>  $mdp,
                                    'ip' => $ip,
                                    'token' => bin2hex(openssl_random_pseudo_bytes(64))
                                ));


                                // On redirige avec le message de succès
                                header('Location:inscription.php?reg_err=success');
                                die();
                            }else{ header('Location: inscription.php?reg_err=password')} 
                        }else{ header('Location: inscription.php?reg_err=password'); die();}
                    }else{ header('Location: inscription.php?reg_err=email'); die();}
                }else{ header('Location: inscription.php?reg_err=email_length'); die();}
            }else{ header('Location: inscription.php?reg_err=pseudo_length'); die();}
        }else{ header('Location: inscription.php?reg_err=already'); die();}
    }
