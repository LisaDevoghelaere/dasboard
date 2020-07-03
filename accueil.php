<?php
session_start();
require_once('db.php');
//var_dump($_SESSION['user'])
if(empty($_SESSION['user'])&& empty($_SESSION['mdp'])){
    header('Location: index.php');
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
        <?php 
            require_once 'header.php';
        ?>
        <main class="container-fluid">
            <div class="container">
                <h2><p>Suivit de consommation des ampoules</p></h2>
                <div class="align_btn">
                    <p><a href="edit.php" class="btn btn-outline-primary marge"><i class="fas fa-plus-circle"></i></a></p>
                    <form class="form-inline my-2 my-lg-0" action="" method="post">
                        <input class="form-control mr-sm-2" type="search" placeholder="chercher une ampoule" aria-label="Search" name="search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="submit"><i class="fas fa-search"></i></button>
                        <a href="accueil.php" class="btn btn-outline-success my-2 my-sm-0"><i class="fas fa-redo"></i></a>
                    </form>
                </div>
                
                <table class="table">
                    <tr id="ligne">
                        <th id="identifiant">id</th>
                        <th id="marque">Marque</th>
                        <th id="puissance">Puissance</th>
                        <th id="position">Position</th>
                        <th id="etage">Etage</th>
                        <th id="date">Date de changement</th>
                        <th id="modification">Modification</th>
                    </tr>
            </div>
                    <?php
                        //requête sql, préalablement testée (on u'tilise pas *)
                        $sql = "SELECT id, marque, puissance, position, etage, changement FROM ampoule";
                        //Récupération des données
                        $sth = $dbh->prepare($sql);  
                        $sth->execute();
                        
                        $resultat = $sth->fetchAll(PDO::FETCH_ASSOC); 
                            //On précise que l'on veut un tableau associatif

                        $intlDateFormater = new IntlDateFormatter('fr_FR', IntlDateFormatter::SHORT, IntlDateFormatter::NONE);
                            //gestion format de date français
                        if(!isset($_POST['search'])&& !isset($_POST['submit'])){
                            //Pour afficher le tableau on fait un foreach qui parcoura le tableau
                            foreach($resultat as $ligne){
                                echo '<tr>';
                                    echo'<td>' . $ligne['id'] . '</td> ';
                                    echo'<td>' . $ligne['marque'] . '</td> ';
                                    echo'<td>' . $ligne['puissance'] . '</td> ';
                                    echo'<td>' . $ligne['position'] . '</td> ';
                                    echo'<td>' . $ligne['etage'] . '</td> ';
                                    
                                    echo '<td>'.$intlDateFormater->format(strtotime($ligne['changement'])).'</td>';
                                    echo '<td><a class="btn btn-outline-success marge-d pos-r" href="edit.php?edit=1&id='.$ligne['id'].'"><i class="fas fa-edit"></i></a> 
                                    <a class="btn btn-outline-danger btn_delete pos-r" href="delete.php?id='.$ligne['id'].'" ><i class="fas fa-trash-alt"></i></a></td>';
                                echo '</tr>';
                            }
                        }else{
                            $sql = "SELECT id, marque, puissance, position, etage, changement FROM `ampoule` WHERE marque LIKE :search OR puissance LIKE :search OR position LIKE :search  OR etage LIKE :search OR changement LIKE :search ";
                            $sth = $dbh->prepare($sql);
                            $sth->bindValue(':search', '%' .$_POST['search'] . '%', PDO::PARAM_STR);  
                            $sth->execute();
                            while($ligne = $sth->fetch(PDO::FETCH_ASSOC)){
                                echo '<tr>';
                                    echo'<td>' . $ligne['id'] . '</td> ';
                                    echo'<td>' . $ligne['marque'] . '</td> ';
                                    echo'<td>' . $ligne['puissance'] . '</td> ';
                                    echo'<td>' . $ligne['position'] . '</td> ';
                                    echo'<td>' . $ligne['etage'] . '</td> ';
                                    
                                    echo '<td>'.$intlDateFormater->format(strtotime($ligne['changement'])).'</td>';
                                    echo '<td><a class="btn btn-outline-success marge-d pos-r" href="edit.php?edit=1&id='.$ligne['id'].'"><i class="fas fa-edit"></i></a> 
                                    <a class="btn btn-outline-danger btn_delete pos-r" href="delete.php?id='.$ligne['id'].'" ><i class="fas fa-trash-alt"></i></a></td>';
                                echo '</tr>';
                            }

                        }
                    ?>
            </table>
            
                <p><a href="edit.php" class="btn btn-outline-primary marge"><i class="fas fa-plus-circle"></i></a></p>

                <!--modal-->
            <div id="modal" class="hidden">
                <div id="modal_dialog">
                    <p id="modal_text">êtes-vous sûr de vouloir supprimer la ligne ?</p>
                    <div id="modal_area_btn">
                        <button id="modal_yes">Oui</button>
                        <button id="modal_no">Non</button>
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
        <script src="script.js"></script>
    </body>
</html>
<?php

    /*}else{
        header('Location: index.php');
        //echo "<p>ce n'est pas le bon mot de passe</p><a href='login> login</a>";
    }
}*/
?>