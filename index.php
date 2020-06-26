<?php
require_once('db.php');
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=MuseoModerno:wght@500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <title>Mon Dashboard</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php 
            require_once 'barnav.php';
        ?>
        <main class="container">
            <h2><p>Suivit de consommation des ampoules</p></h2>
            <table class="table table-responsive">
                <tr><!-- Penser à mettre des id pour rendre le tableau accessible aux malvoyants-->
                    <th>id</th>
                    <th>Marque</th>
                    <th>Puissance</th>
                    <th>Position</th>
                    <th>Etage</th>
                    <th>Date de changement</th>
                    <th>Bouton</th>
                </tr>
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
                    //Pour afficher le tableau on fait un foreach qui parcoura le tableau
                    foreach($resultat as $ligne){
                        echo '<tr>';
                        echo'<td>' . $ligne['id'] . '</td> ';
                        echo'<td>' . $ligne['marque'] . '</td> ';
                        echo'<td>' . $ligne['puissance'] . '</td> ';
                        echo'<td>' . $ligne['position'] . '</td> ';
                        echo'<td>' . $ligne['etage'] . '</td> ';
                        
                        echo '<td>'.$intlDateFormater->format(strtotime($ligne['changement'])).'</td>';
                        echo '<td><a class="btn btn-outline-success" href="edit.php?edit=1&id='.$ligne['id'].'">Modifier</a> <a class="btn btn-outline-danger" href="delete.php?id='.$ligne['id'].'" >Supprimer</a></td>';
                        echo '</tr>';
                    }
                ?>
            </table>
            <?php
            if(count($resultat) === 0){
                echo '<p>Aucune donnée disponible</p>';
            }
            ?>
            <p><a href="edit.php" class="btn btn-outline-primary marge"> Ajouter </a></p>
        </main>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    </body>
</html>