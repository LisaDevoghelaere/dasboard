<?php
session_start();

require_once('db.php');

if(empty($_SESSION['user'])&& empty($_SESSION['mdp'])){
    header('Location: index.php');
} 
if(isset($_GET['id'])){
    $sql = 'delete from ampoule where id= :id';
    $sth = $dbh->prepare($sql);
    $sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $sth->execute();
}
header('Location: accueil.php');
?>