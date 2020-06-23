<?php
require_once('db.php');
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mon Dashboard</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <header>
            <h1>Mon Dashboard</h1>
            <p>Suivit de consommation des ampoules</p>
        </header>
        <main>
            <table>
                <tr><!-- Penser à mettre des id pour rendre le tableau accessible aux malvoyants-->
                    <th>id</th>
                    <th>Marque</th>
                    <th>Puissance</th>
                    <th>Position</th>
                    <th>Etage</th>
                    <th>Date de changement</th>
                </tr>
                <?php
                //requête sql, préalablement testée (on u'tilise pas *)
                $sql = "SELECT id, marque, puissance, position, etage, changement FROM ampoule";
                //Récupération des données
                $sth = $dbh->prepare($sql);  
                $sth->execute();
                   
                $resultat = $sth->fetchAll(PDO::FETCH_ASSOC); 
                     //On précise que l'on veut un tableau associatif

                $intlDateFormater = new IntlDateFormatter('fr_fr', IntlDateFormatter::SHORT, IntlDateFormatter::NONE);
                    //gestion format de date français
                //Pour afficher le tableau on fait un foreach qui parcoura le tableau
                foreach($resultat as $ligne){
                    echo '<tr>';
                    echo'<td>' . $ligne['id'] . '</td> ';
                    echo'<td>' . $ligne['marque'] . '</td> ';
                    echo'<td>' . $ligne['puissance'] . '</td> ';
                    echo'<td>' . $ligne['position'] . '</td> ';
                    echo'<td>' . $ligne['etage'] . '</td> ';
                    echo'<td>' . $ligne['changement'] . '</td> ';
                    echo '<td>'.$intlDateFormater->format(strtotime($ligne['changement'])).'</td>';
                    echo '<td><a href="edit.php?edit=1&id='.$ligne['id'].'">Modifier</a> <a href="delete.php?id='.$ligne['id'].'" >Supprimer</a></td>';
                    echo '</tr>';
                }
            ?>
            </table>
            <?php
            if(count($resultat) === 0){
                echo '<p>Aucune donnée disponible</p>';
            }
            ?>
        </main>
    </body>
</html>