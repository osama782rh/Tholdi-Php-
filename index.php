<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="author" content="NoS1gnal"/>

            <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
            <link rel="stylesheet" href="css/form.css ">
            <title>Connexion</title>
        </head>
        <body>
        
        <div class="login-form">
             <?php 
                if(isset($_GET['login_err']))
                {
                    $err = htmlspecialchars($_GET['login_err']);

                    switch($err)
                    {
                        case 'password':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> mot de passe incorrect
                            </div>
                        <?php
                        break;

                        case 'email':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> email incorrect
                            </div>
                        <?php
                        break;

                        case 'already':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> compte non existant
                            </div>
                        <?php
                        break;
                    }
                }
                ?> 
    
 
<div class="flex">
  <div class="wrapper">
    <h1>Connexion</h1>
    <br>
    <form action="connexion.php" method="post">
    
    <input type="email" name="adrMel" class="form-control" placeholder="Email" required="required" autocomplete="off">
    <br>
    <br>
    <input type="password" name="mdp" class="form-control" placeholder="Mot de passe" required="required" autocomplete="off">
    
        <button type="submit" class="btn btn-primary btn-block">Connexion</button>
    </form>
    <br>
    <a href="inscription.php">Inscription</a></p>

  </div>
 </div>
        </body>
</html>