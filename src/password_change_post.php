<?php   
    // Démarrage de la session 
    session_start();
    // Include de la base de données
    require_once '../config.php';
        if(!empty($_POST['mdp']) && !empty($_POST['mdp2']) && !empty($_POST['token'])){
            $mdp = htmlspecialchars($_POST['mdp']);
            $mdp2 = htmlspecialchars($_POST['mdp2']);
            $token = htmlspecialchars($_POST['token']);

            

            $check = $bdd->prepare('SELECT * FROM utilisateur WHERE token = ?');
            $check->execute(array($token));
            $row = $check->rowCount();

            if($row){
                if($password === $password_repeat){
                    $cost = ['cost' => 12];
                    $password = password_hash($password, PASSWORD_BCRYPT, $cost);

                    $update = $bdd->prepare('UPDATE utilisateur SET password = ? WHERE token = ?');
                    $update->execute(array($password, $token));
                    
                    $delete = $bdd->prepare('DELETE FROM password_recover WHERE token_user = ?');
                    $delete->execute(array($token));

                    echo "Le mot de passe a bien été modifie";
                }else{
                    echo "Les mots de passes ne sont pas identiques";
                }
            }else{
                echo "Compte non existant";
            }
        }else{
            echo "Merci de renseigner un mot de passe";
        }
