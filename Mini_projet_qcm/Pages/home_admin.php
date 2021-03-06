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
    <link rel="stylesheet" type="text/css" href="">
    <link rel="stylesheet" href="css/home_admin.css?refresh=<?php echo rand();?>" media="screen" type="text/css" >
    <title>Home_Admin</title>
</head>
<?php
include 'header.php';
include 'header_home_admin.php';
?>
<?php
?>
<body>
<div class="centre"><br><br>
    <div class="para_droite">
        <div class="image_profil">
            <div class="image">
                <?php
                $json = file_get_contents('user.json');
                $parsed_json = json_decode($json);
                for($i=0;$i<count($parsed_json);$i++){
                    if(isset($parsed_json[$i]->{'profit'}) && $parsed_json[$i]->{'profit'} == 'admin'){
                        if(isset($parsed_json[$i]->{'login'}) && $_SESSION['login'] == $parsed_json[$i]->{'login'}){
                                echo '<img src="photo_avatar/'.$parsed_json[$i]->{'photo'}.'">';
                        }
                    }
                }
                if(isset($_SESSION['photo'])){
                $photo = $_SESSION['photo'];

                $admin = array();
                if (isset($_FILES['avatar']) && !empty($_FILES['avatar']['name'])){
                    $tailleMax = 2097152;
                    $extentionsValides = array('jpeg', 'jpg', 'gif', 'png');
                    if($_FILES['avatar']['size'] <= $tailleMax){
                        $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
                        if(in_array($extensionUpload, $extentionsValides)){
                            $_SESSION['extensionUpload'] = $extensionUpload;
                            $chemin = "/var/www/PHP/Exercice_PHP/Exercice_PHP/projet_QCM/photo_avatar/".$_SESSION['login'].".".$_SESSION['extensionUpload'];
                            $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
                            if($resultat){
                                $admin['photo'] = $_SESSION['login'].".".$_SESSION['extensionUpload'];
                                $_SESSION['photo'] = $admin['photo'];
                            }
                            else{
                                echo 'Erreur durant l\'importation de l\'image';
                            }
                        }
                        else{
                            echo 'Votre photo avatar doit etre au format jpeg, jpg, png ou gif';
                        }
                    }
                    else{
                        echo 'Votre avatar ne doit pas depasser 2Mo';
                    }



                    $js = file_get_contents('user.json');

                    $js= json_decode($js, true);

                  //  $js[] = $admin;


                    $js = json_encode($js);

                    file_put_contents('user.json', $js);
                }
                ?>
                <form action="#" method="post" enctype="multipart/form-data">
                    <div class="avatar">
                        <div id="yourBtn" onclick="getFile()">Changer Avatar</div>
                        <!-- this is your file input tag, so i hide it!-->
                        <!-- i used the onchange event to fire the form submission-->
                        <div style='height: 0px;width: 0px; overflow:hidden;'><input id="upfile" type="file" name="avatar" value="upload" onChange="this.form.submit();" onchange="sub(this)" /></div>
                        <input class="choixfichier" type="hidden" name="avatar" value="changer photo" onChange="this.form.submit();">
                        <!-- <button  style="color: white; background: #026c7b; width: 45%; height: 40px">changer</button>-->
                    </div>
                </form>
            </div>
            <div class="pseudo">
                <?php
                if(isset($_SESSION['prenom'], $_SESSION['nom'])){
                    echo  "<span class='prenom'>";
                    echo $_SESSION['prenom'];
                    echo '</span><br/>';
                    echo  "<span class='nom'>";
                    echo $_SESSION['nom'];
                    echo '</span>';
                }
                }
                ?>
            </div>
        </div>
        <div class="parametres">
            <ul>
                <li><a href="home_admin.php?page=liste_question">Liste Questions<img class="img_icone_list" src="../Images/Icônes/ic-liste.png"></a></li>
                <li><a href="home_admin.php?page=créer_admin">Créer Admin<img class="img_icone_ajout-active" src="../Images/Icônes/ic-ajout-active.png" alt=""></a></li>
                <li><a href="home_admin.php?page=liste_joueur">Liste joueurs<img class="img_ic_list" src="../Images/Icônes/ic-liste.png" alt=""></a></li>
                <li><a href="home_admin.php?page=creation_joueur">Créer Questions<img class="img_ic_ajout" src="../Images/Icônes/ic-ajout.png" alt=""></a></li>
            </ul>
        </div>
    </div>
    <div class="para_gauche">

        <?php
        if(!empty($_GET['page'])){
            $page = $_GET['page'];
            switch ($page){
                case 'liste_question':
                    include('liste_question.php');
                    break;
                case 'créer_admin':
                    include ('formulaire_creation_admin.php');
                    break;
                case 'liste_joueur':
                    include ('liste_joueur.php');
                    break;
                case 'creation_joueur':
                    include('formulaire_creation_questions.php');
                    break;
            }
        }
        ?>


        <div>
        </div>
        <!-- Partie affichage photo  -->
        <?php
        /*
        if(isset($page)) {
            if ($page == 'créer_admin') {
                echo '<div class="photoavatar" style="">';
                if (isset($_SESSION['photo'],  $_SESSION['login_admin_ajouter'])) {
                    if($_SESSION['login'] ==  $_SESSION['login_admin_ajouter']){
                        echo '<img src="membres/avatars/' . $_SESSION['photo'] . '">';
                    }
                }
                echo '<span style="margin-left: 25%">Avatar admin</span> </div>';
            }
        }
        */
        ?>

    </div>
</div>
<script>

    function getFile(){
        document.getElementById("upfile").click();
    }
    function sub(obj){
        var file = obj.value;
        var fileName = file.split("\'   ");
        document.getElementById("yourBtn").innerHTML = fileName[fileName.length-1];
        document.myForm.submit();
        event.preventDefault();
    }
</script>
</body>
</html>
