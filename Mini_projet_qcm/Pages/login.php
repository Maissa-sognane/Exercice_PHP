<?php
session_start();
include 'header.php';

$msg = '';
$json = file_get_contents('user.json');
$parsed_json = json_decode($json);
//var_dump($parsed_json);

if(isset($_POST['login'], $_POST['password'])) {
    if (!(empty($_POST['login'])) && !(empty($_POST['password']))) {
        require 'auth.php';
        $login = $_POST['login'];
        $password = $_POST['password'];

        $_SESSION['parsed_json'] = $parsed_json;
        for ($i = 0; $i < count($parsed_json); $i++) {
            if (isset($parsed_json[$i]->{'login'}, $parsed_json[$i]->{'password'}, $parsed_json[$i]->{'prenom'},
                $parsed_json[$i]->{'nom'}, $parsed_json[$i]->{'profit'})) {
                $login_json = $parsed_json[$i]->{'login'};
                $password_json = $parsed_json[$i]->{'password'};
                $prenom = $parsed_json[$i]->{'prenom'};
                $nom = $parsed_json[$i]->{'nom'};
                $profit = $parsed_json[$i]->{'profit'};
                if (isset($parsed_json[$i]->{'photo'})) {
                    $photo = $parsed_json[$i]->{'photo'};
                }
            }
            if (($login == $login_json) && ($password == $password_json)){

                if ($profit == 'admin') {
                    $_SESSION['prenom'] = $prenom;
                    $_SESSION['login'] = $login_json;
                    $_SESSION['photo'] = $photo;
                    $_SESSION['nom'] = $nom;
                    $_SESSION['connecte'] = 1;
                    header('Location: home_admin.php');
                }
                if ($profit == 'joueur') {
                    $_SESSION['prenom_joueur'] = $prenom;
                    $_SESSION['login_joueur'] = $login_json;
                    $_SESSION['photo_joueur'] = $photo;
                    $_SESSION['nom_joueur'] = $nom;
                    $_SESSION['connecte_joueur'] = 1;
                    $_SESSION['rep']['score'] = 0;
                    header('Location: home_joueur.php');
                }
            }
            if (($login == $login_json) && ($password != $password_json)){
                $msg = 'Password invalid';
            }
            if (($login != $login_json) && ($password == $password_json)){
                $msg ='Login invalid';
            }
            if(($login != $login_json) && ($password != $password_json)){
                $msg = 'Login et password invalid';
            }
        }
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/login.css?refresh=<?php echo rand();?>">

    <title>login</title>
</head>
<body>
<?php if(isset($msg)){echo '<h2 style="color: red; text-align: center">'.$msg.'</h2>'; }?>
<div class="formulaire">
    <form action="" method="post" id="form-connexion">
        <div class="titre_formulaire"><p class="log_form">Login form</p></div>
        <span class="error" id="error-1"></span>
        <input class="input" type="text" id="login" error="error-1" name="login" placeholder="Login" value="<?php
        if(isset($_POST['login'])){
            echo $_POST['login'];
        }
            ?>">
        <img class="img_log" src="../Images/Icônes/ic-login.png" alt="">
        <br>
        <span class="error"  id="error-2"></span>
        <input class="input" type="password" error="error-2"  id="password" name="password" placeholder="Password" value="<?php
        if(isset($_POST['password'])){
            echo $_POST['password'];
        }
        ?>">
        <img class="img_log"   src="../Images/Icônes/icone-password.png" alt="" style="height: 20px"><br>
        <input class="button"  type="submit" value="Connexion">
        <a href="inscription.php">S'inscrire pour jouer?</a>

    </form>
</div>
<script >

    const inputs = document.getElementsByTagName('input');
    for (input of inputs){
        input.addEventListener("keyup", function (e){
            if(e.target.hasAttribute("error")){
                var idDivErrors = e.target.getAttribute("error");
                document.getElementById(idDivErrors).innerText="";
            };
        })
    }
document.getElementById("form-connexion").addEventListener("submit", function (e){
    const inputs = document.getElementsByTagName('input');
    var error = false;
    for (input of inputs){
        if(input.hasAttribute("error")){
            var idDivError = input.getAttribute("error");
                if(!input.value) {
                    document.getElementById(idDivError).innerText="Ce Champ est obligatoire";
                    error = true;
                }

        }
    }
    if (error){
        e.preventDefault();
        return false;
    }

});

</script>
</body>
</html>

