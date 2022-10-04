<?php
require_once 'config.php';
include_once 'config.php';
?>
<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="author" content="NoS1gnal"/>

            <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <title>Inscription</title>
        </head>
        <body>
        <div class="login-form">
            <?php 
                if(isset($_GET['reg_err']))
                {
                    $err = htmlspecialchars($_GET['reg_err']);

                    switch($err)
                    {
                        case 'success':
                        ?>
                            <div class="alert alert-success">
                                <strong>Succès</strong> inscription réussie !
                            </div>
                        <?php
                        break;

                        case 'password':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> mot de passe différent
                            </div>
                        <?php
                        break;

                        case 'email':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> email non valide
                            </div>
                        <?php
                        break;

                        case 'email_length':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> email trop long
                            </div>
                        <?php 
                        break;

                        case 'pseudo_length':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> pseudo trop long
                            </div>
                        <?php 
                        case 'already':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> compte deja existant
                            </div>
                        <?php 

                    }
                }
                ?>
            
            <form action="inscription_traitement.php" method="post">
                <h2 class="text-center">Inscription</h2>       
                <div class="form-group">
                    <input placeholder="raisonSociale" type="text" name="raisonSociale" required autocomplete="off">
                </div>
                <div class="form-group">
                    <input placeholder="adresse" type="text" name="adresse"   required autocomplete="off">
                </div>
                <div class="form-group">
                  <input  placeholder="Code Postal" type="text" name="cp"  required autocomplete="off">
                </div>

                 <div class="form-group">
                  <input placeholder="ville"  type="text" name="ville"  required autocomplete="off">
                </div>

                <div class="form-group">
                 <input  placeholder="Mail"  name="adrMel"  type="email"  required autocomplete="off">
                </div>

                 <div class="form-group">
                   <input  placeholder="telephone" type="text" name="telephone" required autocomplete="off">
                </div>

                <div class="form-group">
                   <input placeholder="contact" type="text" name="contact" required autocomplete="off">
                </div>

                <label class="data">Pays</label>
            <?php
            $collectionPays = obtenirPays();
            ?>
            <select name="codePays">
                <?php
                foreach ($collectionPays as $pays) :
                    ?>
                    <option value="<?php echo $pays["codePays"]; ?>">
                        <?php echo $pays["nomPays"]; ?>
                    </option>
                <?php endforeach; ?>
            </select>

                 <div class="form-group">
                    <input placeholder="login" type="text" name="login" required autocomplete="off">
                </div>

                 <div class="form-group">
                     <input placeholder="Mot de passe" type="password" name="mdp" required autocomplete="off">
                </div>

                 <div class="form-group">
                     <input  placeholder="Re-tapez le mot de passe" type="password" name="mdp2"  required autocomplete="off">
                </div>


                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Inscription</button>
                </div>   
            </form>
        </div>
        <style>
            .login-form {
                width: 340px;
                margin: 50px auto;
            }
            .login-form form {
                margin-bottom: 15px;
                background: #f7f7f7;
                box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
                padding: 30px;
            }
            .login-form h2 {
                margin: 0 0 15px;
            }
            .form-control, .btn {
                min-height: 38px;
                border-radius: 2px;
            }
            .btn {        
                font-size: 15px;
                font-weight: bold;
            }
        </style>
        </body>
</html>
