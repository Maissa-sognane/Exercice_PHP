<?php
$msg = '';
if(isset($_POST['prenom'], $_POST['nom'], $_POST['login'], $_POST['password'], $_POST['confirm_password'])){
    if (empty($_POST['prenom']) || empty($_POST['nom']) || empty($_POST['login']) ||
        empty($_POST['password']) || empty($_POST['confirm_password'])){
        if(empty($_POST['prenom']) || preg_match("#[^a-zA-Z]#", $_POST['prenom'])){
            $msg = 'Saisir un prenom correct';
        }
        elseif(empty($_POST['nom']) || preg_match("#[^a-zA-Z]#", $_POST['nom'])){
            $msg = 'Saisir un nom';
        }
        elseif(empty($_POST['login'])){
            $msg = 'Saisir un login';
        }
        elseif (empty($_POST['password'])){
            $msg = 'Saisir un mot de pass';
        }
        else{
            $msg = 'Veuillez confirmer votre mot de pass';
        }
    }
    else{
        $prenom =  $_POST['prenom'];
        $nom = $_POST['nom'];
        $login = $_POST['login'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        //$photo = $_FILES['avatar']['name'];
        if($password != $confirm_password){
            $msg = 'Veuillez entrer deux mots de pass identiques';
        }
        else{
            $user = array();

            $user['prenom'] = $prenom;
            $user['nom'] = $nom;
            $user['profit'] = 'joueur';
            $user['login'] = $login;
            $user['password'] = $password;
            $user['confirm_password'] = $confirm_password;
            $user['score'] = array();
            $user['photo'] = '';

            //$_SESSION['login_admin_ajouter'] = $user['login'];

            if (isset($_FILES['avatar']) && !empty($_FILES['avatar']['name'])){
                $tailleMax = 2097152;
                $extentionsValides = array('jpeg', 'jpg', 'gif', 'png');
                if($_FILES['avatar']['size'] <= $tailleMax)
                {
                    $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
                    if(in_array($extensionUpload, $extentionsValides)){
                        $_SESSION['extensionUpload'] = $extensionUpload;
                        if(isset($user['login'])) {
                            $chemin = "./photo_avatar/".$user['login']. "." . $_SESSION['extensionUpload'];
                            $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
                        }
                        if($resultat){
                            $user['photo'] = $user['login'].".".$_SESSION['extensionUpload'];
                           // $_SESSION['photo_joueur'] = $user['photo'];
                        }
                        else{
                            $msg =  'Erreur durant l\'importation de l\'image';
                        }
                    }
                    else{
                        $msg = 'Votre photo avatar doit etre au format jpeg, jpg, png ou gif';
                    }
                }
                else{
                    $msg = 'Votre avatar ne doit pas depasser 2Mo';
                }
            }
            $js= get_data();

            if(!(isset($js))){
                $js[] = $user;
                //header('Location : login.php');
            }
            else{
                for ($i=0;$i<count($js);$i++){
                    $ver = in_array($user['login'],$js[$i]);
                    if($ver == true){
                        break;
                    }
                }
                if(($ver == true)){
                    $msg = 'Login existe déja';
                }
                elseif(($ver == false)){
                    $js[] = $user;
                    header('Location: login.php');
                }

            }
        }
        if(isset($js)) {
            $js = json_encode($js);
            file_put_contents('./data/user.json', $js);
        }
    }
}
?>
<body>
<div class="form_image_inscription">
    <div>
        <div class="inscrire_inscription">
            <h3>S'INSCRIRE</h3>
            <span>Pour proposer des quiz</span>
        </div>
        <hr style="">
        <div class="formulaire_inscription">
            <?php if (isset($msg)){echo "<h4 style='color: red'>$msg</h4>";} ?>
            <form action="#" method="post" enctype="multipart/form-data" id="form-connexion">
                <label >Prénom</label><br>
                <input error="error-1" class="inpt_inscription" type="text" name="prenom" value="<?php if(isset($_POST['prenom'])){echo $_POST['prenom'];} ?>"><br>
                <span class="error_input_admin" id="error-1"></span><br>
                <label>Nom</label><br>
                <input error="error-2" class="inpt_inscription" type="text" name="nom" value="<?php if(isset($_POST['nom'])){echo $_POST['nom'];} ?>"><br>
                <span class="error_input_admin" id="error-2"></span><br>
                <label>Login</label><br>
                <input error="error-3" class="inpt_inscription" type="text" name="login" value="<?php if(isset($_POST['login'])){echo $_POST['login'];} ?>"><br>
                <span class="error_input_admin" id="error-3"></span><br>
                <label>Password</label><br>
                <input error="error-4" class="inpt_inscription" type="password" name="password" value="<?php if(isset($_POST['password'])){echo $_POST['password'];} ?>"><br>
                <span class="error_input_admin" id="error-4"></span><br>
                <label>Confirm password</label><br>
                <input error="error-5" class="inpt_inscription" type="password" name="confirm_password" value="<?php if(isset($_POST['confirm_password'])){echo $_POST['confirm_password'];} ?>"><br>
                <span class="error_input_admin" id="error-5"></span><br>
                <div class="avatar_inscription">
                    Avatar
                    <input style="display: block" class="choix_fichier_inscription" type="file" name="avatar" accept="image/*" onchange="loadFile(event);">
                </div>
                <button class="creer_compte_inscription" style="color: black">Créer compte</button>
            </form>
        </div>
    </div>
    <?php
    echo '<div class="photoavatar_inscription">';
    echo '<img id="output" class="avatares_inscription" />';
    /*
    if(isset($login)){
        echo '<img src="photo_avatar/'.$user['login'].".".$_SESSION['extensionUpload'].'">';
    }*/

    echo '<span style="margin-left: 25%; margin-top: 20%;">Avatar joueur</span> </div>';
    ?>
</div>
</body>
<script>
    var loadFile = function (event) {
        var output = document.getElementById("output");
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function () {
            URL.revokeObjectURL(output.src);
        }
    };
</script>

