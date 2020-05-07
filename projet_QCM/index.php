<?php
session_start();
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/style.css?refresh=<?php echo rand();?>">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <script src="https://kit.fontawesome.com/8435a2a226.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
<header>
    <nav class="nav">

        <div class="logo"><img src="Images/logo-QuizzSA.png"></div>
        <p class="titre">Le plaisir de jouer</p>
    </nav>
</header>
<?php
require 'pages/function.php';
if(isset($_GET['lien'])){
    $lien = $_GET['lien'];
    switch ($lien){
        case 'admin':
            require_once './pages/home_admin.php';
            break;
        case 'joueur':
            require_once './pages/home_joueur.php';
            break;
        case 'inscrire':
            require_once './pages/inscription.php';
            break;
    }
}
else{
        if(isset($_GET['statut']) && $_GET['statut'] === 'logout'){
            deconnexion();
        }
       require_once './pages/login.php';
    }
?>
</body>
<script src="js/score.js"></script>
</html>
