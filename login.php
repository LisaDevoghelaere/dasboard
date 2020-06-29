<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
<?php         require_once 'barnav.php'; ?>
<main class="container">
    <h2>Entrez votre mot de passe</h2>
    <form action="index.php" method="post">
        <input type="password" name="mdp">
        <button type="submit" class="btn btn-outline-primary">Envoyer</button>
    </form>
   
</main>
</body>
</html>