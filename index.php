<?php
session_start();
require_once('db.php');
$mdp = '';
$user = '';
$msg = '';

    if(isset($_POST['envoyer'])&&  !empty($_POST['user']) && !empty($_POST['mdp'])){
        
        $sql="SELECT username, mot_de_passe FROM login WHERE username = :user";
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':user', $_POST['user'], PDO::PARAM_STR);  
        $sth->execute();
        $data = $sth->fetch();

        $user = $data['username'];
        $mdp = $data['mot_de_passe'];
        
        if($_POST['user'] == $user && $_POST['mdp'] == $mdp){
            $_SESSION['valid'] = true;
            $_SESSION['timeout'] = time();
            $_SESSION['user'] = $user;
            $_SESSION['mdp'] = $mdp;
            header('Location: accueil.php');
        }else{
            $msg = "Le nom d'utilisateur ou mot de passe est invalide";
            //   echo '<p class="alerte-rouge">' . $msg . '</p>';
        }
    }
?>
<!doctype html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=MuseoModerno:wght@500;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Mon Dashboard</title>
  </head>
    <body>
        
        <main class="container-fluid">
            <div class="container">
                <h2>Entrez votre mot de passe</h2>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-8 col-lg-6 bloc">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="user">Utilisateur</label>
                                <input type="text" class="form-control" id="user" aria-describedby="user" placeholder="Lisa"  name="user">
                            </div>
                            <div class="form-group">
                                <label for="password">Mot de passe</label>
                                <input type="password" class="form-control" name="mdp" placeholder="gardien">
                                <small id="mdp-Help" class="form-text text-muted">Votre mot de passe vous a été communiqué préalablement par mail</small>
                                <p class="alerte-rouge"><?=$msg ?></p>
                            </div>
                            <button type="submit" class="btn btn-outline-primary btn-lg btn-block" name="envoyer">Envoyer</button>
                        </form>
                        
                    </div>
                </div>
            </div>
            
        </main>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    </body>
</html>