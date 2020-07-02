<!doctype html>
<html lang="fr">
    
    <body>
        <header class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <h1><a href="accueil.php">Mon Dashboard</a></h1>
                </div>
            
                <div class="col-6">
                   <p class="pseudo">
                        Bonjour <?=$_SESSION['user']?>
                        <a href="deconnexion.php" title="Au revoir!"><img src="media/door-white.svg" alt="icone de deconnexion"></a>
                   </p>
                   
                </div>
            </div>
        </div>
        </header>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    </body>
</html>