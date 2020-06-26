<?php
require_once('db.php');
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
        header('Location: index.php');
        exit;
    }
    $marque = $data['marque'];
    $puissance = $data['puissance'];
    $position = $data['position'];
    $etage = $data['etage'];
    $changement = $data['changement'];
    $id = htmlentities($_GET['id']);
}

//On vérifie si le formulaire a bien été soumi
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
        header('Location: index.php');
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=MuseoModerno:wght@500;700&display=swap" rel="stylesheet"> 
    <title>ajouter-modifier</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php         require_once 'barnav.php'; ?>
<main class="container">
    <?php
    


        if(isset($_GET['id'])&& isset($_GET['edit'])){
            $txtTitle = "Modifier";
        }else{
                $txtTitle= "Ajouter";
        }
    ?>
    <h2><?=$txtTitle ?></h2>
    <div class="bloc">
        <form action="" method="post">
            <div>
                <input type="text" name="marque" id="marque" placeholder="marque" value="<?=$marque; ?>">
            </div>
            <div>
                <input type="text" name="puissance" id="puissance" placeholder="puissance" value="<?=$puissance; ?>">
            </div>
            <div>
                <input type="text" name="position" id="position" placeholder="position" value="<?=$position; ?>">
            </div>
            <div>      
                <input type="text" name="etage" id="etage" placeholder="etage" value="<?=$etage; ?>">
            </div>
            <div>
                <input type="date" name="changement" id="changement" class="except" placeholder="date de changement" value="<?=$changement; ?>">
            </div>
            <div>
                <?php
                    if(isset($_GET['id'])&& isset($_GET['edit'])){
                        $txtButton = "Modifier";
                    }else{
                        $txtButton = "Ajouter";
                    }
                ?>
                <button type="submit" class="btn btn-outline-primary"><?=$txtButton ?></button>
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
</main>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>    
</body>
</html>