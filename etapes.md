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

### Création d'un index.php
Faire un Doctype.
Faire un tableau.
Penser à inclure un menu de navigation // ou pas[x]

### Création du fichier db.PHP
Créer le lien vers la base de donnée et require_once sur chaque pages
```$dbh``` "databasehost" (= hébergement de la base de donnée) cette variable est celle qui fait la connection avec mysql

### Mise en place de l'affichage du tableau
Tout d'abord on prépare et teste une requête sql sur phpmyadmin, puis on l'attribue à la variable ```$sql```. Utiliser * n'est pas une bonne pratique, j'ai donc cité les différents champs puis la table.
La variable ```$sth``` ("statement handle" soit en français "déclaration gérée") récupère et exécute ```$dbh```. La variable ```$resultat``` récupère chaque ligne de la table via la fonction```$sth->fetchAll(PDO::FETCH_ASSOC);``` . FECTH_ASSOC permet de préciser qu'il s'agit d'un tableau associatif.
Afin de pouvoir écrire et lire les dates en français, on utilise la fonction suivante :
```
$intlDateFormater = new IntlDateFormatter('fr_fr', IntlDateFormatter::SHORT, IntlDateFormatter::NONE);
```
On fait ensuite une boucle foreach pour afficher les différentes lignes.
On intègre aussi à chaque lignes deux "boutons" (liens) *Modifier* et *Supprimer* qui vont pointer respectivement vers **edit.php** et **delete.php**.