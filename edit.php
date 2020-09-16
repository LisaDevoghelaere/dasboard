<?php
session_start();
require_once('db.php');
if(empty($_SESSION['user'])){
    header('Location: index.php');
} 
$marque = '';
$puissance = '';
$position = '';
$etage = '';
$changement = '';
$id = '';
$error = false;

if(isset($_GET['id'])&& isset($_GET['edit'])){
    $sql = "SELECT id, marque, puissance, position, etage, changement FROM ampoule";

    $sth = $dbh->prepare($sql);

    $sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);

    $sth->execute();

    $data = $sth->fetch(PDO::FETCH_ASSOC);
    //Condition pour sécuriser le formulaire 
    if(gettype($data) === "boolean"){
        header('Location: accueil.php');
        exit;
    }
    $marque = $data['marque'];
    $puissance = $data['puissance'];
    $position = $data['position'];
    $etage = $data['etage'];
    $changement = $data['changement'];
    $id = htmlentities($_GET['id']);
}

//On vérifie si le formulaire a bien été soumis
if(count($_POST)>0){
    if(strlen(trim($_POST['marque'])) !== 0){
        $marque = trim($_POST['marque']);
    }else{
        $error = true;
    }
    if(strlen(trim($_POST['puissance'])) !== 0){
    $puissance = trim($_POST['puissance']);
    }else{
        $error = true;
    }
    if(strlen(trim($_POST['position'])) !== 0){
        $position = trim($_POST['position']);
    }else{
        $error = true;
    }
    if(strlen(trim($_POST['etage'])) !== 0){
        $etage = trim($_POST['etage']);
    }else{
        $error = true;
    }
    if(strlen(trim($_POST['changement'])) !== 0){
        $changement = trim($_POST['changement']);
    }else{
        $error = true;
    }
    if(isset($_POST['edit']) && isset($_POST['id'])){
        $id = htmlentities($_POST['id']);
    }
    
    if($error ===false){
        if(isset($_POST['edit'])&& isset($_POST['id'])){
            $sql = 'update ampoule set marque=:marque, puissance=:puissance, position=:position, etage=:etage, changement=:changement, id=:id';
        }else{
            $sql="INSERT INTO ampoule(marque, puissance, position, etage, changement) VALUES (:marque, :puissance, :position, :etage, :changement)";
        }

        $sth = $dbh->prepare($sql);

        $sth->bindParam(':marque', $marque, PDO::PARAM_STR);
        $sth->bindParam(':puissance', $puissance, PDO::PARAM_STR);
        $sth->bindParam(':position', $position, PDO::PARAM_STR);
        $sth->bindParam(':etage', $etage, PDO::PARAM_STR);
        $sth->bindValue(':changement', strftime("%Y-%m-%d",strtotime($changement)), PDO::PARAM_STR);

        if(isset($_POST['edit'])&& isset($_POST['id'])){
            $sth->bindParam(':id', $id, PDO::PARAM_INT);
        }
        $sth->execute();
        header('Location: accueil.php');
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
        <?php require_once 'header.php'; ?>
        <main class="container-fluid">
            <?php
                if(isset($_GET['id'])&& isset($_GET['edit'])){
                    $txtTitle = "Modifier";
                }else{
                        $txtTitle= "Ajouter";
                }
            ?>           
            <div class="container">
                <h2><?=$txtTitle ?></h2>
                
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-8 col-lg-8 bloc">
                        <form action="" method="post">
                            
                            <div class="form-group">
                                <label for="marque">Marque</label>
                                <input type="text" name="marque" id="marque" placeholder="marque" class="form-control" required value="<?=$marque; ?>">
                            </div>
                            <div class="form-group">
                                <label for="puissance">Puissance</label>
                                <select name="puissance" class="form-control">
                                    <?php
                                        $array = array('25W', '60W', '75W', '100W', '150W');
                                    
                                        foreach($array as $arraylight){ 
                                            $select = '';    
                                            // Sauvegarde de la puissance sélectionnée en cas d'édition               
                                            if($puissance == $arraylight){
                                            $select = "selected";
                                            }
                                            echo '<option value="'.$arraylight.'"' .$select. '>'.$arraylight.'</option>';
                                        }
                                    ?> 
                                </select>        
                            </div>
                            <div class="form-group">
                                <label for="position">Position</label>
                                <select name="position" id="position" class="form-control">
                                <?php
                                   $tableau = array('Centre', 'Gauche', 'Droite');
                                   foreach($tableau as $ligne){
                                       $choix = '';
                                       if($position == $ligne){
                                           $choix = "selected";
                                       }
                                    echo '<option value="' . $ligne . '"' . $choix .'>' . $ligne .'</option>', "\n";
                                   }
                                ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="etage">Étage</label>
                                <select name="etage" id="etage" class="form-control">
                                    <?php 
                                        for($i=0; $i<12; $i++){
                                        $selected = '';
                                        if ($etage == $i){
                                            $selected = "selected";
                                        }
                                        echo '<option value="' .$i. '"' .$selected. '>'.$i.'</option>', "\n";               
                                        } 
                                    ?>
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="changement">Date de changement</label><br>
                                <input type="date" name="changement" required id="changement" class="form-control except" placeholder="date de changement" class="form-control"  value="<?=$changement; ?>">
                            </div>
                            <div>
                                <?php
                                    if(isset($_GET['id'])&& isset($_GET['edit'])){
                                        $txtButton = '<i class="fas fa-edit"></i>';
                                    }else{
                                        $txtButton = '<i class="fas fa-plus-circle"></i>';
                                    }
                                ?>
                                <button type="submit" class="btn btn-outline-primary btn-lg btn-block"><?=$txtButton ?></button>
                            </div>
                            
                            <?php
                                if(isset($_GET['id'])&& isset($_GET['edit'])){
                            ?>
                                <input type="hidden" name="edit" value="1">
                                <input type="hidden" name="id" value="<?=$id; ?>">
                            <?php 
                                } 
                            ?>
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
        <script src="https://kit.fontawesome.com/5458cc12a8.js" crossorigin="anonymous"></script>

    </body>
</html>