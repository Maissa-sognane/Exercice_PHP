<?php
echo '<div class="entete_joueur">';
echo '<div class="image_joueur">';

$parsed_json = get_data();
if(isset($_SESSION['photo_joueur'])) {
    $photo = $_SESSION['photo_joueur'];
}
for($i=0;$i<count($parsed_json);$i++){
    if(isset($parsed_json[$i]['profit']) && $parsed_json[$i]['profit'] == 'joueur'){
        if(isset($parsed_json[$i]['login']) && ($_SESSION['login'] == $parsed_json[$i]['login'] )){
                echo '<img src="./photo_avatar/'.$parsed_json[$i]['photo'].'">';
        }
    }
}
$users = array();
if (isset($_FILES['avatar']) && !empty($_FILES['avatar']['name'])){
    $tailleMax = 2097152;
    $extentionsValides = array('jpeg', 'jpg', 'gif', 'png');
    if($_FILES['avatar']['size'] <= $tailleMax){
        $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
        if(in_array($extensionUpload, $extentionsValides)){
            $_SESSION['extensionUpload'] = $extensionUpload;
            $chemin = "/var/www/PHP/Exercice_PHP/Exercice_PHP/projet_QCM/photo_avatar/".$_SESSION['login_joueur'].".".$_SESSION['extensionUpload'];
            $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
            if($resultat){
                $users['photo'] = $_SESSION['login_joueur'].".".$_SESSION['extensionUpload'];
                $_SESSION['photo_joueur'] = $users['photo'];
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

    $js[] = $users;


    $js = json_encode($js);

    file_put_contents('./data/user.json', $js);
}
?>
<form action="#" method="post" enctype="multipart/form-data">
    <div class="avatar_joueur">
        <!--<div id="yourBtn" onclick="getFile()">Changer Avatar</div>-->
        <!-- this is your file input tag, so i hide it!-->
        <!-- i used the onchange event to fire the form submission-->
        <div style='height: 0px;width: 0px; overflow:hidden;'><input  id="upfile" type="file" name="avatar" value="upload" onChange="this.form.submit();" onchange="sub(this)" /></div>
        <input class="choixfichier" type="hidden" name="avatar" value="changer photo" onChange="this.form.submit();">
    </div>
</form>
</div>
<div class="pseudo_joueur">
    <?php
    if(isset($_SESSION['prenom'], $_SESSION['nom'])){
        echo  "<span class='prenom_joueur'>";
        echo $_SESSION['prenom'];
        echo '</span> ';
        echo  "<span class='nom_joueur'>";
        echo $_SESSION['nom'];
        echo '</span>';
    }
    echo '</div>';
    echo '<p class="titre_quizz_joueur">BIENVENUE SUR LA PLATEFORME DE JEU QUIZZ<br>
JOUER ET TESTER VOTRE NIVEAU DE CULTURE GÉNÉRALE
</p>';
    echo '<a href="?statut=logout"><button class="logout_joueur">Déconnexion</button></a>
</div>';
   // $question_json = $_SESSION['questions'];
   // shuffle($question_json);
    //$question_json[] = $question_json;
    ?>
    <div class="centre_joueur">
        <div class="para_gauche_joueur">
            <div class="reponse_joueur">
                <?php
                if(!isset($_SESSION['table_question_joueur']) && !empty($_SESSION['table_question_joueur'])) {
                    $_SESSION['table_question_joueur'] = [];
                }
                if(!isset($_SESSION['reponse_cocher_deja']) && !empty($_SESSION['reponse_cocher_deja'])){
                    $_SESSION['reponse_cocher_deja'] = array();
                }
                if(!isset($_SESSION['question_deja_repondu']) && !empty($_SESSION['question_deja_repondu'])){
                    $_SESSION['question_deja_repondu'] = array();
                }
                $questions = file_get_contents('./data/questions.json');
                $question_json = json_decode($questions,true);
                if(!isset($questions_repondu ) && !empty($questions_repondu )) {
                    $questions_repondu = [];
                }
                if(!isset($_SESSION['reponse_en_cours']) && !empty($_SESSION['reponse_en_cours'])){
                $_SESSION['reponse_en_cours'] = array(
                    $_SESSION['login']=>''
                );
                }
                $_SESSION['reponse_donner'] = "";
                $_SESSION['tmp_reponse'] = false;
                for ($i=0; $i<count($question_json); $i++){
                    if ($question_json[$i]){
                        $reponse = '';
                        $_SESSION['score'] = $question_json[$i]['score'];
                        if (is_array($question_json[$i]['reponse'])) {
                            if(sizeof($question_json[$i]['reponse']['bonne_reponse']) == 1){
                                if(isset($_SESSION['boutton_suivant']) || isset($_POST['button_terminer'])){
                                    if(isset($_POST["reponse0"])){
                                        $_SESSION['table_question_joueur'][$_SESSION['questions_afficher']] = $_POST["reponse0"];
                                        if(isset($question_json[$i]['reponse']['bonne_reponse'][0])){
                                            if ($question_json[$i]['reponse']['bonne_reponse'][0] == $_POST["reponse0"]){
                                                $reponse = 1;
                                            }
                                        }
                                    }
                                    for ($k=0;$k<count($question_json[$i]['reponse']['fausse_reponse']);$k++){
                                        if(isset($_SESSION['boutton_suivant']) || isset($_POST['button_terminer'])){
                                            if(isset($_POST["reponse0"])){
                                                $_SESSION['table_question_joueur'][$_SESSION['questions_afficher']] = $_POST["reponse0"];
                                                if(isset($question_json[$i]['reponse']['fausse_reponse'][$k])){
                                                    if ($question_json[$i]['reponse']['fausse_reponse'][$k] == $_POST["reponse0"]){
                                                        $reponse = 2;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            if(sizeof($question_json[$i]['reponse']['bonne_reponse']) > 1){
                                $nbr=0;
                                for ($j=0; $j<sizeof($question_json[$i]['reponse']['bonne_reponse']);$j++){
                                    if(isset($_SESSION['boutton_suivant']) || isset($_POST['button_terminer'])){
                                        if(isset($_POST["reponse_bonne$j"])){
                                            $_SESSION['reponse_cocher_deja'][] = $_POST["reponse_bonne$j"];
                                            $_SESSION['table_question_joueur'][$_SESSION['questions_afficher']] = $_POST["reponse_bonne$j"];
                                            if(isset($question_json[$i]['reponse']['bonne_reponse'][$j])){
                                                if ($question_json[$i]['reponse']['bonne_reponse'][$j] == $_POST["reponse_bonne$j"]){
                                                    $nbr++;
                                                }
                                            }
                                        }
                                    }
                                    if($nbr == sizeof($question_json[$i]['reponse']['bonne_reponse'])){
                                        $reponse = 1;
                                    }
                                }
                                for ($k=0;$k<count($question_json[$i]['reponse']['fausse_reponse']);$k++){
                                    if(isset($_SESSION['boutton_suivant']) || isset($_POST['button_terminer'])){
                                        if(isset($_POST["reponse$k"])){
                                            $_SESSION['reponse_cocher_deja'][] = $_POST["reponse$k"];
                                            $_SESSION['table_question_joueur'][$_SESSION['questions_afficher']] = $_POST["reponse$k"];
                                            if(isset($question_json[$i]['reponse']['fausse_reponse'][$k])){
                                                if ($question_json[$i]['reponse']['fausse_reponse'][$k] == $_POST["reponse$k"]){
                                                    $reponse = 2;
                                                }
                                            }
                                        }
                                    }
                                }

                            }

                            if($reponse == 1){
                                $_SESSION['reponse_en_cours'][$_SESSION['login']][] = $question_json[$i];
                                $_SESSION['rep']['score'] = $_SESSION['rep']['score'] + $_SESSION['score'];
                                $_SESSION['question_deja_repondu'][$_SESSION['questions_afficher']] = $_SESSION['score'];
                                $_SESSION['tmp_reponse'] = true;
                            }
                        }
                        else{
                            if(isset($_SESSION['boutton_suivant']) || isset($_POST['button_terminer'])){
                                if (isset($_POST["reponse_texte0"])){
                                    $_SESSION['table_question_joueur'][$_SESSION['questions_afficher']] = $_POST["reponse_texte0"];
                                    if(isset($question_json[$i]['reponse'])){
                                        if($question_json[$i]['questions']){
                                        if ($question_json[$i]['reponse'] == $_POST["reponse_texte0"]){
                                            $_SESSION['reponse'] = $_POST['reponse_texte0'];
                                            $_SESSION['reponse_en_cours'][$_SESSION['login']][] = $question_json[$i];
                                                $_SESSION['rep']['score'] = $_SESSION['rep']['score'] + $_SESSION['score'];
                                            }
                                        }
                                    }
                                }
                            }

                        }
                    }
                    $_SESSION['table_question_joueur'] = array_unique($_SESSION['table_question_joueur'] );
                    $_SESSION['reponse_cocher_deja'] = array_unique($_SESSION['reponse_cocher_deja']);
                    $_SESSION['question_deja_repondu'] = array_unique($_SESSION['question_deja_repondu']);
                }

                if(!isset($_POST['button_terminer'])){
                    require_once 'traitement_hohme_joueur.php';
                }
                if(isset($_POST['rejouer'])){
                    header('Location: ?lien=joueur');
                }
                if(isset($_POST['button_terminer'])){
                    $_SESSION['terminer'] = $_POST['button_terminer'];
                    $_SESSION['points'] = $_SESSION['rep']['score'];
                    if(isset($_SESSION['login'], $_SESSION['prenom'], $_SESSION['nom'])){
                        $nbre_points = $_SESSION['rep']['score'];
                        $score[$_SESSION['login']]['prenom'] = $_SESSION['prenom'];
                        $score[$_SESSION['login']]['nom'] = $_SESSION['nom'];
                        $score[$_SESSION['login']]['login'] = $_SESSION['login'];
                        $score[$_SESSION['login']]['score'] = $nbre_points;

                        $js = file_get_contents('./data/score.json');
                        $js= json_decode($js, true);

                        if(!(isset($js))){
                            $js[] = $score;
                        }
                        else{
                            for ($i=0; $i<count($js); $i++){
                                if(isset($js[$i][$_SESSION['login']])) {
                                    foreach ($js[$i] as $key => $value) {
                                        if (key_exists($key, $js[$i])){
                                            if($js[$i][$key]['login'] ==  $_SESSION['login']){
                                                $js[$i][$key]['score'] = $score[$_SESSION['login']]['score'];
                                            }

                                        }

                                    }
                                }
                                else{
                                    $js[$i][$_SESSION['login']]['prenom'] = $score[$_SESSION['login']]['prenom'];
                                    $js[$i][$_SESSION['login']]['nom'] = $score[$_SESSION['login']]['nom'];
                                    $js[$i][$_SESSION['login']]['login'] = $score[$_SESSION['login']]['login'];
                                    $js[$i][$_SESSION['login']]['score'] =  $score[$_SESSION['login']]['score'];
                                }

                            }
                        }

                        $js = json_encode($js);
                        file_put_contents('./data/score.json', $js);
                    }

                    if($_SESSION['login']){
                        for($i=0;$i<count($parsed_json); $i++){
                            if(isset($parsed_json[$i]['login'])){
                                if($parsed_json[$i]['login'] == $_SESSION['login']){
                                    $parsed_json[$i]['score'][] =   $nbre_points;
                                }
                            }
                        }
                        $js_users = json_encode($parsed_json);
                        file_put_contents('./data/user.json', $js_users);
                    }
                    $_SESSION['rep']['score'] = 0;


                    $reponses_vrai = file_get_contents("./data/Tag.json");
                    $reponses_vrai = json_decode($reponses_vrai, true);

                        if(key_exists($_SESSION['login'], $reponses_vrai)){
                            $reponses_vrai[$_SESSION['login']][] = $_SESSION['reponse_en_cours'];
                        }else{
                            $reponses_vrai[] = $_SESSION['reponse_en_cours'];
                        }

                    $reponses_vrai = json_encode($reponses_vrai);
                    file_put_contents('./data/Tag.json', $reponses_vrai);
                    $_SESSION['reponse_en_cours'] = null;

                }
                if(isset($_POST['button_terminer'])){
                    unset($_SESSION['table_question_joueur']);
                    unset($_SESSION['reponse_cocher_deja']);
                    unset($_SESSION['question_deja_repondu']);
                    include 'validation_jeu.php';
                }

                if(!isset($_POST['boutton_suivant'])){
                    if(isset($_SESSION['precedent'])){
                        $_SESSION['n']=$_SESSION['precedent'];
                    }else{
                        $_SESSION['n'] = 1;
                    }

                }
                if (isset($_SESSION['boutton_suivant'])){
                   unset($_SESSION['precedent']);
                }
                ?>
            </div>

      <div class="score">
               <div class="input_scores">
                   <input class="top" type="button" id="togg1" value="Top scores">
                   <input class="meilleur" type="button" id="togg2" value="Mon meilleur score">
                </div>
                <div id="d1" style="display: block">
                    <div class="class_score">
                        <?php
     $score_joueur = get_data();
     echo '<br>';
     $T = [];
     $t_score = [];
     for($i=0;$i<count($score_joueur);$i++){
         $tmp = 0;
         if(isset($score_joueur[$i]['profit']) && $score_joueur[$i]['profit'] == 'joueur'){
             if (isset($score_joueur[$i]['score']) && !empty($score_joueur[$i]['score'])){
                 $max = max($score_joueur[$i]['score']);
                 if($tmp<$max){
                     $tmp = $max;
                     $t_score[] = $tmp;

                     $T[] = array(
                         'prenom' => $score_joueur[$i]['prenom'],
                         'nom'=>$score_joueur[$i]['nom'],
                         'meileur_score'=>$tmp
                     );
                 }
             }
         }
     }
     rsort($t_score);
     $Tab_classement = [];
     for ($i=0;$i<count($t_score);$i++) {
         for ($j = 0; $j < count($T); $j++){
             if($t_score[$i] == $T[$j]['meileur_score']) {
                 $Tab_classement[] = array(
                     'prenom' => $T[$j]['prenom'],
                     'nom'=> $T[$j]['nom'],
                     'meileur_score'=> $T[$j]['meileur_score']
                 );
             }
         }
     }
     $meilleur = file_get_contents('./data/meilleur_joueur.json');
     $meilleur = json_decode($meilleur, true);
     //var_dump(count($Tab_classement));
     $Tab_classement_par_score = array_unique($Tab_classement, SORT_REGULAR);
     //var_dump(count($T));
     //var_dump(count($Tab_classement_par_score));
     $color0 = "#51BFD0";
     $color1 = "#3ADDD6";
     $color2 = "#e56CA7";
     $color3 = "#e56946";
     $color4 = "#F8FDFD";
    $_SESSION['tab_classement'] = $Tab_classement_par_score;
    for ($j=0;$j<count($Tab_classement);$j++){
        if(isset($Tab_classement_par_score[$j])){
            $meilleur_joueur[] = $Tab_classement_par_score[$j];
        }
    }
    //var_dump($meilleur_joueur);
    $meilleur_joueur = json_encode($meilleur_joueur);
    file_put_contents('./data/meilleur_joueur.json', $meilleur_joueur);

     $color = "";
     $nbr = 0;
    $taille = count($Tab_classement);
    $tail = file_get_contents('./data/nbre_question.json');
    $tail = json_decode($tail);
    $tail[1] = $taille;
    $tail = json_encode($tail);
    file_put_contents('./data/nbre_question.json', $tail);
     for ($j=0;$j<count($Tab_classement);$j++){
         echo '<div class="classement">';
         if($nbr==0){
             $color = $color0;
         }
         if($nbr==1){
             $color = $color1;
         }
         if($nbr==2){
             $color = $color2;
         }
         if($nbr==3){
             $color = $color3;
         }
         if($nbr==4){
             $color = $color4;
         }
         if(isset($Tab_classement_par_score[$j])){
             echo $Tab_classement_par_score[$j]['prenom'];
             echo '   ';
             echo $Tab_classement_par_score[$j]['nom'];
             echo '   ';
             echo "<span class='points' style='border-bottom: 4px solid $color'>";
             echo $Tab_classement_par_score[$j]['meileur_score'];
             echo ' pts</span>';
             echo '</div>';
             echo '<br>';
             $nbr++;
         }
         if($nbr == 5){
             break;
         }
     }
     ?>

                    </div>
               </div>

        </div>
    </div>
        <div id="d2" style="display: none">
            <?php
            $user = get_data();
            echo '<br/>';
            for ($i=0;$i<count($user);$i++){
                if(isset($user[$i]['profit']) && $user[$i]['profit'] == 'joueur'){
                    if($_SESSION['login'] == $user[$i]['login']){
                        if($user[$i]['score'] != null){
                            $max = max($user[$i]['score']);
                            echo "<div class=\"classement_score\"><span class=''>Meilleur score  : <em class='points_score'>$max pts</em></span></div>";
                        }
                    }
                }
            }
            ?>
        </div>



