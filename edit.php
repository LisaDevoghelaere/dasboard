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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ajouter-modifier</title>
</head>
<body>
<main>
    <?php
        if(isset($_GET['id'])&& isset($_GET['edit'])){
            $txtTitle = "Modifier";
        }else{
                $txtTitle= "Ajouter";
        }
    ?>
    <h1><?=$txtTitle ?></h1>
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
            <input type="text" name="changement" id="changement" placeholder="date de changement" value="<?=$changement; ?>">
        </div>
        <div>
            <?php
                if(isset($_GET['id'])&& isset($_GET['edit'])){
                    $txtButton = "Modifier";
                }else{
                    $txtButton = "Ajouter";
                }
            ?>
            <button type="submit"><?=$txtButton ?></button>
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
</main>
    
</body>
</html>