# Mettre sa base de donnée sur le serveur

Vous avez monté votre projet en local et vous souhaiteriez à présent l'envoyer sur le serveur. Seulement voilà, vous ne savez-pas comment faire ni comment faire la nouvelle connexion avec votre code php. Ce tuto est fait pour vous.

## Exportez la base de donnée
Dans phpMyAdmin, cherchez l'onglet *Exporter*, cliquez. Choisissez l'option rapide au format "SQL". Cliquez sur exécuter.

## Mettre sa base de donnée sur le serveur (pour les ACS)
Le premier jour de formation, vous avez normalement reçu un mail avec les codes et adresses pour mettre vos projets sur le serveur. Tout en bas de ce mail, une URL qui commence par promo suivit d'un tiret ainsi que du numéro de votre promo et qui fini âr adminer. C'est de celle-ci dont vous aurez besoin présentement (accompagné de vos identifiants.)

Cliquez sur le lien puis identifiez-vous.

Cliquez sur "Créer une base de donnée".
Une page s'ouvre avec un formulaire avec deux input dont le premier est prérempli avec votre pseudo suivit d'un underscore :
**monpseudo_**
à la suite (non! n'éffacez pas votre prénom!), écrivez le nom de votre base de donnée. 
**monpseudo_mabdd**
Dans le second choisissez *utf8_general_ci* puis cliquez sur enregistrer.
Dans la colone de gauche vous trouverez un lien pour **importer** votre base de donnée.

## Refaire la connexion avec votre site

### (rappel) Se connecter en local

```
<?php 
define('DATABASE', 'dashboard');
define('USER', 'root');
define('PWD', '');
define('HOST', 'localhost');

try{
    $dbh = new PDO('mysql:host='.HOST.';dbname='.DATABASE, USER, PWD);

}catch (PDOException $e){
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die;
}
?>
```
On définit dans des constantes ```define``` le nom de la base, l'utilisateur le mot de passe et le chemin en dehors de la requête pour pouvoir facilement en changer.

### Changer les identifiants de connexion
C'est donc sur la première partie que nous allons nous concentrer.
#### define('DATABASE', 'monpseudo_mabdd');
ici pas de surprise, vous mettez le nom de votre base de donnée (ACS : noubliez pas, votre base de donnée commence par votre pseudo).
#### define('USER', 'monpseudo');
Dans user vous mettez le pseudo que vous utilisez pour votre serveur
#### define('PWD', 'mon_mdp');
Le mot de passe du serveur
#### define('HOST', 'localhost');
Et là... Et bien en fait vous ne faites rien ! vous laissez tel quel ! 
Comme vous hébergez le site et la base de donnée sur le serveur, il va la chercher en local. C'est le mêmeprincipe que pour n'importe quel chemin que vous créez dans votre site. si vous faites un lien de la page index vers la page contact vous écrire quelque chose comme ceci :
```
<a href="contact.html">contact</a>
```
Pas besoin ici de préciser que contact se trouve dans le dossier "monsite" car la page index y est aussi alors le lien va se faire naturellement au plus près. Au contraire même, indiquer le dossier empêchera le lien de se faire car vous lui demanderez de voir une adresse qu'il ne peut pas voir (puisqu'il est à l'intérieur). Si je suis dans ma maison je ne peux pas voir la maison, vous voyez où je veux en venir ?


C'est fini pour ce petit tuto qui pourra j'espère en aider certains.