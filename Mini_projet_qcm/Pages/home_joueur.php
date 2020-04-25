<?php
session_start();
?>
<!doctype html>
<?php
include 'header.php';
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/home_joueur.css?refresh=<?php echo rand();?>">
    <title>Home_Joueur</title>
</head>
<style>
</style>
<body>
<?php
require 'auth.php';
redirection();
if(est_connecte_joueur()){
echo '<div class="entete">';
echo '<div class="image">';
$json = file_get_contents('user.json');
$parsed_json = json_decode($json);
if(isset($_SESSION['photo_joueur'])) {
    $photo = $_SESSION['photo_joueur'];
}
for($i=0;$i<count($parsed_json);$i++){
    if(isset($parsed_json[$i]->{'profit'}) && $parsed_json[$i]->{'profit'} == 'joueur'){
        if(isset($parsed_json[$i]->{'login'}) && ($_SESSION['login_joueur'] == $parsed_json[$i]->{'login'} )){
                echo '<img src="photo_avatar/'.$parsed_json[$i]->{'photo'}.'">';
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
            $chemin = "photo_avatar/".$_SESSION['login_joueur'].".".$_SESSION['extensionUpload'];
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

    $js = file_get_contents('user.json');

    $js= json_decode($js, true);

    $js[] = $users;


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
       <!-- <input  class="choixfichier" type="file" name="avatar" value="changer photo" onChange="this.form.submit();">-->
        <!--<input  style="color: white;
    background: #026c7b;
    border-color: #026c7b;
    width: 107px;
    height: 40px;" value="changer" type="submit">-->
    </div>
</form>
</div>
<div class="pseudo">
    <?php
    if(isset($_SESSION['prenom_joueur'], $_SESSION['nom_joueur'])){
        echo  "<span class='prenom'>";
        echo $_SESSION['prenom_joueur'];
        echo '</span> ';
        echo  "<span class='nom'>";
        echo $_SESSION['nom_joueur'];
        echo '</span>';
    }
    echo '</div>';
    echo '<p class="titre_quizz">BIENVENUE SUR LA PLATEFORME DE JEU QUIZZ<br>
JOUER ET TESTER VOTRE NIVEAU DE CULTURE GÉNÉRALE
</p>';
    echo '<a href="logout_joueur.php"><button class="logout">Déconnexion</button></a>
</div>';
    }
   // $question_json = $_SESSION['questions'];
   // shuffle($question_json);
    //$question_json[] = $question_json;
    ?>
    <div class="centre">
        <div class="para_gauche">
            <div class="reponse">
                <?php
                $questions = file_get_contents('questions.json');
                $question_json = json_decode($questions);
                shuffle($question_json);
               // var_dump($question_json);
                for ($i=0; $i<count($question_json); $i++){
                    if ($question_json[$i]){
                        $reponse = '';
                        $_SESSION['score'] = $question_json[$i]->{'score'};
                        if (is_object($question_json[$i]->{'reponse'})) {
                            if(sizeof($question_json[$i]->{'reponse'}->{'bonne_reponse'}) == 1){
                                if(isset($_POST['boutton_suivant']) || isset($_POST['button_terminer'])){
                                    if(isset($_POST["reponse0"])){
                                        if(isset($question_json[$i]->{'reponse'}->{'bonne_reponse'}[0])){
                                            if ($question_json[$i]->{'reponse'}->{'bonne_reponse'}[0] == $_POST["reponse0"]){
                                                $reponse = 1;
                                            }
                                        }
                                    }
                                    for ($k=0;$k<count($question_json[$i]->{'reponse'}->{'fausse_reponse'});$k++){
                                        if(isset($_POST['boutton_suivant']) || isset($_POST['button_terminer'])){
                                            if(isset($_POST["reponse0"])){
                                                if(isset($question_json[$i]->{'reponse'}->{'fausse_reponse'}[$k])){
                                                    if ($question_json[$i]->{'reponse'}->{'fausse_reponse'}[$k] == $_POST["reponse0"]){
                                                        $reponse = 2;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            if(sizeof($question_json[$i]->{'reponse'}->{'bonne_reponse'}) > 1){
                                for ($j=0; $j<sizeof($question_json[$i]->{'reponse'}->{'bonne_reponse'});$j++){

                                    if(isset($_POST['boutton_suivant']) || isset($_POST['button_terminer'])){
                                        if(isset($_POST["reponse_bonne$j"])){
                                            if(isset($question_json[$i]->{'reponse'}->{'bonne_reponse'}[$j])){
                                                if ($question_json[$i]->{'reponse'}->{'bonne_reponse'}[$j] == $_POST["reponse_bonne$j"]){
                                                    $reponse = 1;
                                                }
                                            }
                                        }
                                    }
                                }
                                for ($k=0;$k<count($question_json[$i]->{'reponse'}->{'fausse_reponse'});$k++){
                                    if(isset($_POST['boutton_suivant']) || isset($_POST['button_terminer'])){
                                        if(isset($_POST["reponse$k"])){
                                            if(isset($question_json[$i]->{'reponse'}->{'fausse_reponse'}[$k])){
                                                if ($question_json[$i]->{'reponse'}->{'fausse_reponse'}[$k] == $_POST["reponse$k"]){
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
                            if(isset($_POST['boutton_suivant']) || isset($_POST['button_terminer'])){
                                if (isset($_POST["reponse_texte0"])){
                                    if(isset($question_json[$i]->{'reponse'})){
                                        if ($question_json[$i]->{'reponse'} == $_POST["reponse_texte0"]) {
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
                    require_once 'logout_joueur.php';
                }

                if(isset($_POST['rejouer'])){
                   // shuffle($_SESSION['questions'] );
                  //  $_SESSION['questions'] =  $question_json;
                    header('Location:home_joueur.php');
                }

                if(isset($_POST['button_terminer'])){
                    $_SESSION['terminer'] = $_POST['button_terminer'];
                    $_SESSION['points'] = $_SESSION['rep']['score'];
                    if(isset($_SESSION['login_joueur'], $_SESSION['prenom_joueur'], $_SESSION['nom_joueur'])){
                        $nbre_points = $_SESSION['rep']['score'];
                        $score[$_SESSION['login_joueur']]['prenom'] = $_SESSION['prenom_joueur'];
                        $score[$_SESSION['login_joueur']]['nom'] = $_SESSION['nom_joueur'];
                        $score[$_SESSION['login_joueur']]['login'] = $_SESSION['login_joueur'];
                        $score[$_SESSION['login_joueur']]['score'] = $nbre_points;

                        $js = file_get_contents('score.json');
                        $js= json_decode($js, true);

                        //  var_dump($js);
                        if(!(isset($js))){
                            $js[] = $score;
                        }
                        else{
                            for ($i=0; $i<count($js); $i++){
                                if(isset($js[$i][$_SESSION['login_joueur']])) {
                                    foreach ($js[$i] as $key => $value) {
                                        if (key_exists($key, $js[$i])){
                                            if($js[$i][$key]['login'] ==  $_SESSION['login_joueur']){
                                                $js[$i][$key]['score'] = $score[$_SESSION['login_joueur']]['score'];
                                            }
                                            //var_dump($js[$i]);
                                        }
                                        // var_dump($key);
                                    }
                                }
                                else{
                                    $js[$i][$_SESSION['login_joueur']]['prenom'] = $score[$_SESSION['login_joueur']]['prenom'];
                                    $js[$i][$_SESSION['login_joueur']]['nom'] = $score[$_SESSION['login_joueur']]['nom'];
                                    $js[$i][$_SESSION['login_joueur']]['login'] = $score[$_SESSION['login_joueur']]['login'];
                                    $js[$i][$_SESSION['login_joueur']]['score'] =  $score[$_SESSION['login_joueur']]['score'];
                                }
                                // var_dump($js[$i]);
                                //  var_dump($js[$i]['prenom']);
                            }
                        }

                        //var_dump($js[0]['bamba']['prenom']);
                        //$js[] = $score;
                        //var_dump($js);
                        $js = json_encode($js);
                        file_put_contents('score.json', $js);
                    }

                    if($_SESSION['login_joueur']){
                        for($i=0;$i<count($parsed_json); $i++){
                            if(isset($parsed_json[$i]->{'login'})){
                                if($parsed_json[$i]->{'login'} == $_SESSION['login_joueur']){
                                    $parsed_json[$i]->{'score'}[] =   $nbre_points;
                                }
                            }
                        }
                        $js_users = json_encode($parsed_json);
                        file_put_contents('user.json', $js_users);
                    }
                    $_SESSION['rep']['score'] = 0;
                    // $_SESSION['questions'] =  $question_json;
                }
                if(isset($_POST['button_terminer'])){
                    include 'validation_jeu.php';
                }

                if(!(est_connecte_joueur())){
                    $_SESSION['rep']['score'] = 0;
                }

                if(isset($_POST['boutton_suivant'])){
                    $_SESSION['n']=$_SESSION['suivant'];
                    header('Location:home_joueur.php?&pages='.$_SESSION['suivant']);
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
                        $score = file_get_contents('user.json');
                        $score_joueur = json_decode($score);
                        echo '<br>';
                        $T = [];
                        $t_score = [];
                        for($i=0;$i<count($score_joueur);$i++){
                            $tmp = 0;
                            if(isset($score_joueur[$i]->{'profit'}) && $score_joueur[$i]->{'profit'} == 'joueur'){
                                if (isset($score_joueur[$i]->{'score'}) && !empty($score_joueur[$i]->{'score'})){
                                    $max = max($score_joueur[$i]->{'score'});
                                    if($tmp<$max){
                                        $tmp = $max;
                                        $t_score[] = $tmp;

                                        $T[] = array(
                                            'prenom' => $score_joueur[$i]->{'prenom'},
                                            'nom'=>$score_joueur[$i]->{'nom'},
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
                    $user = file_get_contents('user.json');
                    $user = json_decode($user);
                    echo '<br/>';
                    for ($i=0;$i<count($user);$i++){
                        if(isset($user[$i]->{'profit'}) && $user[$i]->{'profit'} == 'joueur'){
                            if($_SESSION['login_joueur'] == $user[$i]->{'login'}){
                                if($user[$i]->{'score'} != null){
                                    $max = max($user[$i]->{'score'});
                                    echo "<div class=\"classement_score\"><span class=''>Meilleur score  : <em class='points_score'>$max pts</em></span></div>";
                                }
                            }
                        }
                    }
                    ?>
                </div>

                <!--<a href="home_joueur.php?page=top_score">Top scores</a>
                <a href="home_joueur.php?page=meilleur_score" style="float: right">Mon meilleur score</a>-->
                <?php
                if(!empty($_GET['page'])) {
                    $page = $_GET['page'];
                    switch ($page) {
                        case 'top_score':
                            include('top_score_joueur.php');
                            break;
                    default:
                            include('score_joueur.php');
                            break;
                    }
                }

                ?>
            </div>
        </div>
    </div>
</body>
<script src="../js/score.js">

</script>
</html>