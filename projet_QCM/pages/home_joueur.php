<?php
echo '<div class="entete_joueur">';
echo '<div class="image_joueur">';
//echo $_SESSION['nom'];
//var_dump($_SESSION);
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
                $questions = file_get_contents('./data/questions.json');
                $question_json = json_decode($questions,true);
                shuffle($question_json);
/*
                if(!isset($_SESSION['rep']) && !empty($_SESSION['rep'])) {
                    $_SESSION['rep'] = array(
                        'score'=>0
                    );
                }
*/
                for ($i=0; $i<count($question_json); $i++){
                    if ($question_json[$i]){
                        $reponse = '';
                        $_SESSION['score'] = $question_json[$i]['score'];
                        if (is_array($question_json[$i]['reponse'])) {
                            if(sizeof($question_json[$i]['reponse']['bonne_reponse']) == 1){
                                if(isset($_SESSION['boutton_suivant']) || isset($_POST['button_terminer'])){
                                    if(isset($_POST["reponse0"])){
                                        if(isset($question_json[$i]['reponse']['bonne_reponse'][0])){
                                            if ($question_json[$i]['reponse']['bonne_reponse'][0] == $_POST["reponse0"]){
                                                $reponse = 1;
                                            }
                                        }
                                    }
                                    for ($k=0;$k<count($question_json[$i]['reponse']['fausse_reponse']);$k++){
                                        if(isset($_SESSION['boutton_suivant']) || isset($_POST['button_terminer'])){
                                            if(isset($_POST["reponse0"])){
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
                                $nb=0;
                                for ($j=0; $j<sizeof($question_json[$i]['reponse']['bonne_reponse']);$j++){
                                    if(isset($_SESSION['boutton_suivant']) || isset($_POST['button_terminer'])){
                                        if(isset($_POST["reponse_bonne$j"])){
                                            if(isset($question_json[$i]['reponse']['bonne_reponse'][$j])){
                                                if ($question_json[$i]['reponse']['bonne_reponse'][$j] == $_POST["reponse_bonne$j"]){
                                                    $nbr++;
                                                }
                                            }
                                        }
                                    }
                                }
                                if($nbr == sizeof($question_json[$i]['reponse']['bonne_reponse'])){
                                    $reponse = 1;
                                }
                                for ($k=0;$k<count($question_json[$i]['reponse']['fausse_reponse']);$k++){
                                    if(isset($_SESSION['boutton_suivant']) || isset($_POST['button_terminer'])){
                                        if(isset($_POST["reponse$k"])){
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
                                $_SESSION['rep']['score'] = $_SESSION['rep']['score'] + $_SESSION['score'];
                            }
                        }
                        else{
                            //'.$question_json[$i][0]->{'reponse'}.'
                            if(isset($_SESSION['boutton_suivant']) || isset($_POST['button_terminer'])){
                                if (isset($_POST["reponse_texte0"])){
                                    if(isset($question_json[$i]['reponse'])){
                                        if ($question_json[$i]['reponse'] == $_POST["reponse_texte0"]) {
                                            $_SESSION['rep']['score'] = $_SESSION['rep']['score'] + $_SESSION['score'];
                                        }
                                    }
                                }
                            }

                        }
                    }

                }
                if(!isset($_POST['button_terminer'])){
                   // var_dump($question_json);
                    require_once 'traitement_hohme_joueur.php';
                }
                if(isset($_POST["quitter"])){

                }

                if(isset($_POST['rejouer'])){
                   // shuffle($_SESSION['questions'] );
                  //  $_SESSION['questions'] =  $question_json;
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

                        //  var_dump($js);
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
                                            //var_dump($js[$i]);
                                        }
                                        // var_dump($key);
                                    }
                                }
                                else{
                                    $js[$i][$_SESSION['login']]['prenom'] = $score[$_SESSION['login']]['prenom'];
                                    $js[$i][$_SESSION['login']]['nom'] = $score[$_SESSION['login']]['nom'];
                                    $js[$i][$_SESSION['login']]['login'] = $score[$_SESSION['login']]['login'];
                                    $js[$i][$_SESSION['login']]['score'] =  $score[$_SESSION['login']]['score'];
                                }
                                // var_dump($js[$i]);
                                //  var_dump($js[$i]['prenom']);
                            }
                        }

                        //var_dump($js[0]['bamba']['prenom']);
                        //$js[] = $score;
                        //var_dump($js);
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
                    // $_SESSION['questions'] =  $question_json;
                }
                if(isset($_POST['button_terminer'])){
                    include 'validation_jeu.php';
                }
                if(!isset($_POST['boutton_suivant'])){
                    if(isset($_SESSION['precedent'])){
                        $_SESSION['n']=$_SESSION['precedent'];
                    }else{
                        $_SESSION['n'] = 1;
                    }

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
     //var_dump(count($Tab_classement));
     $Tab_classement_par_score = array_unique($Tab_classement, SORT_REGULAR);
     //var_dump(count($T));
     //var_dump(count($Tab_classement_par_score));
     $color0 = "#51BFD0";
     $color1 = "#3ADDD6";
     $color2 = "#e56CA7";
     $color3 = "#e56946";
     $color4 = "#F8FDFD";


     $color = "";
     $nbr = 0;

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
            </div>
        </div>
    </div>
    <!--
    <script src="">

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
    </script>-->
