<?php
is_connecte();
?>
<div class="entete">
    <p class="titre_quizz">CRÉER ET PARAMÉTRER VOS QUIZZ</p>
    <a href="?statut=logout"><button class="logout">Déconnexion</button></a>
</div>
<div class="centre"><br><br>
    <div class="para_droite">
        <div class="image_profil">
            <div class="image_admin">
                <?php
                $parsed_json = get_data();
                //var_dump($parsed_json[0]['login']);
                for($i=0;$i<count($parsed_json);$i++){
                    if(isset($parsed_json[$i]['profit']) && $parsed_json[$i]['profit'] == 'admin'){
                        if(isset($parsed_json[$i]['login']) && $_SESSION['login'] == $parsed_json[$i]['login']){
                                echo '<img src="./photo_avatar/'.$parsed_json[$i]['photo'].'">';
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
                            $chemin = "./photo_avatar/".$_SESSION['login'].".".$_SESSION['extensionUpload'];
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


                    $js= get_data();
                    $js = json_encode($js);
                    file_put_contents("./data/user.json", $js);
                }
                ?>
                <form action="#" method="post" enctype="multipart/form-data">
                    <div class="avatar_admin">
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
                <li id="togg1"><a href="?lien=admin&menu=liste_question">Liste Questions<img class="img_icone_list" src="./Images/Icônes/ic-liste.png"></a></li>
                <li id="togg2"><a href="?lien=admin&menu=créer_admin">Créer Admin<img class="img_icone_ajout-active" src="./Images/Icônes/ic-ajout-active.png"></a></li>
                <li id="togg3"><a href="?lien=admin&menu=liste_joueur">Liste joueurs<img class="img_ic_list" src="./Images/Icônes/ic-liste.png" alt=""></a></li>
                <li id="togg4"><a href="?lien=admin&menu=creation_joueur">Créer Questions<img class="img_ic_ajout" src="./Images/Icônes/ic-ajout.png" alt=""></a></li>
                <li id="togg4"><a href="?lien=admin&menu=graphique">Graphique<img class="img_ic_ajout" src="./Images/Icônes/ic-ajout.png" alt=""></a></li>
            </ul>
        </div>
    </div>
    <div class="para_gauche">
      <!--  <div id="d2" style="display: none"><?php include './pages/formulaire_creation_admin.php';?></div>
        <div id="d3" style="display: none"><?php include './pages/liste_joueur.php';?></div>
        <div id="d4" style="display: none"><?php include './pages/formulaire_creation_questions.php';?></div>
        <div id="d1" style="display: block"><?php include './pages/liste_question.php';?></div>-->

        <?php

        if(!empty($_GET['menu'])){
            $page = $_GET['menu'];
            switch ($page){
                case 'liste_question':
                    include('./pages/liste_question.php');
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
                case 'graphique':
                    include ('graphique.php');
                    break;
            }
        }

        ?>
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
<script src="./js/score.js">

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

