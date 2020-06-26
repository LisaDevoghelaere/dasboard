# DashBoard

## Gestion des ampoules

### Création de la base de données
Création d'une base de donnée de 6 colones : 
    -Identifiant **id** Int/A.I/Primary 
    -Marque **marque** varchar/50
    -Puissance **puissance** Varchar/4
    -Position **position** varchar/10
    -Étage **etage** varchar/2
    -Date de changement **changement** date

### Structure générale
Faire un index.php qui contient le tableau
Faire un fichier nommé "db.php" qui contient le lien vers la base de donnée et qu'on va pouvoir ajouter à chaque page où l'on en a besoin à l'aide de ```require_once```
Faire des fichier edit.php et delete.php pour gérer l'ajout, la modification et suppression de ligne dans le tableau et la base de donnée.

### Création d'un index.php
Doctype
création d'un tableau

### Création du fichier db.PHP
Créer le lien vers la base de donnée et require_once sur chaque pages
```$dbh``` "databasehost" (= hébergement de la base de donnée) cette variable est celle qui fait la connection avec mysql

### Mise en place de l'affichage du tableau
Tout d'abord je prépare et teste une requête sql sur phpmyadmin, puis on l'attribue à la variable ```$sql```. Utiliser * n'est pas une bonne pratique, j'ai donc cité les différents champs puis la table.
La variable ```$sth``` ("statement handle" soit en français "déclaration gérée") récupère et exécute ```$dbh```. La variable ```$resultat``` récupère chaque ligne de la table via la fonction```$sth->fetchAll(PDO::FETCH_ASSOC);``` . FECTH_ASSOC permet de préciser qu'il s'agit d'un tableau associatif.
Afin de pouvoir écrire et lire les dates en français, j'utilise la fonction suivante :
```
$intlDateFormater = new IntlDateFormatter('fr_fr', IntlDateFormatter::SHORT, IntlDateFormatter::NONE);
```
On fait ensuite une boucle foreach pour afficher les différentes lignes.
On intègre aussi à chaque lignes deux "boutons" (liens) *Modifier* et *Supprimer* qui vont pointer respectivement vers **edit.php** et **delete.php**.
afin de sécuriser les données on ajoute un if en dessous de ma table
```
<?php
    if(count($resultat) === 0){
        echo '<p>Aucune donnée disponible</p>';
    }
?>
```

### Ajouter/modifier une ligne
Tout d'abord j'ai créé un doctype avec la structure de base en html. Puis des variables vides pour  que le formulaire soit vide au chargement de la page. Je pose une condition pour savoir si le formulaire passe en mode ajout ou modifier et une autre pour savoir s'il a été soumis. Cela permet de le sécuriser pour éviter une injection de sql. Toujours dans cette optique chaque input est sécurisé de sorte à ce qu'il indique une erreur dans le cas où l'on ferait un envoi égal à 0 caractère. D'autre part la fonction bindParam veillera à ce que les entrées ne soient jamais comprises comme étant du code. Si toutes les conditions sont remplies alors l'entrée est ajoutée ou modifiée selon le cas.

### Supprimer une ligne
Je crée un fichier delete.php
Pour des questions évidentes de sécurité on teste l'existence de la variable. Si c'est le cas php lance la requête en sql pour supprimer la ligne en la sélectionnant par l'id.
```
$sql = 'delete from stagiaire where id= :id';
```
Je prépare la requête puis précise le type de données de la colone pour plus de sécurité. Enfin on exécute la requête.

### Ajout du style
Création d'un thème bleu sombre, écritures blanches avec deux polices pour les titrages et le corps de texte. Pour des raisons pratiques en cas de changement les couleurs et polices ont donné lieux à des création de variables. Le style est fait en sass qui possède beaucoup d'option que le css classique ainsi que d'ajouts de composants Bootstrap. Ce dernier n'était pas vraiment nécessaire mais ce projet permettait de l'aborder doucement.