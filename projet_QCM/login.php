<?php

$msg = '';
$json = file_get_contents('user.json');
$parsed_json = get_data();


if(isset($_POST['submit'])){
    $login = $_POST['login'];
    $password = $_POST['password'];
    $resultat = connexion($login, $password);
    if($resultat === 'error'){
        $msg = 'login ou password invalid';
    }
    else{
        if($resultat === 'error_loging'){
            $msg ='Login invalid';
        }
        elseif ($resultat === 'error_pwd'){
            $msg ='password invalid';
        }
        elseif ($resultat === 'invalid'){
            $msg ='Login et Password invalid';
        }
        else{
            $_SESSION['table_question_joueur'] = [];
            $_SESSION['reponse_cocher_deja'] = array();
            $_SESSION['question_deja_repondu'] = array();
            $_SESSION['rep'] = array(
                'score'=>0
            );
            header("Location:./?lien=" . $resultat);
        }
    }
}
?>
<?php if(isset($msg)){echo '<h2 style="color: red; text-align: center">'.$msg.'</h2>'; }?>
<div class="formulaire">
    <form action="" method="post" id="form-connexion">
        <div class="titre_formulaire"><p class="log_form">Login form</p></div>
        <span class="error" id="error-1"></span>
        <input class="input_login" type="text" id="login" error="error-1" name="login" placeholder="Login" value="<?php
        if(isset($_POST['login'])){
            echo $_POST['login'];
        }
            ?>">
        <img class="img_log" src="" alt="">
        <br>
        <span class="error"  id="error-2"></span>
        <input class="input_login" type="password" error="error-2"  id="password" name="password" placeholder="Password" value="<?php
        if(isset($_POST['password'])){
            echo $_POST['password'];
        }
        ?>">
        <img class="img_log"   src="../Images/Icônes/icone-password.png" alt="" style="height: 20px"><br>
        <input class="button" name="submit"  type="submit" value="Connexion">
        <a href="?lien=inscrire">S'inscrire pour jouer?</a>

    </form>
</div>
<script>
    document.getElementById("form-connexion").addEventListener("submit", function (e){
        const inputs = document.getElementsByTagName('input');
        const champ_text = document.getElementsByTagName('textarea');
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
        for (text of champ_text){
            if(text.hasAttribute("error")){
                var idDivErrors = text.getAttribute("error");
                if(!text.value){
                    document.getElementById(idDivErrors).innerText = "Ce Champ est obligatoire";
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

