<?php 
/*define('DATABASE', 'dashboard');
define('USER', 'root');
define('PWD', '');
define('HOST', 'localhost');*/

define('DATABASE', 'lisad_dashboard');
define('USER', 'lisad');
define('PWD', 'viHm9uwG+hfH2w==');
define('HOST', 'localhost');
try{
    $dbh = new PDO('mysql:host='.HOST.';dbname='.DATABASE, USER, PWD);

}catch (PDOException $e){
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die;
}
?>

