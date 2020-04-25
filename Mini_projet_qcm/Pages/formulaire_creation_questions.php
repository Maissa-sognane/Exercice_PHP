<?php
$msg='';
$question_js = file_get_contents('questions.json');
$question_js = json_decode($question_js, true);
if (isset($_POST['valider'])){
        if(empty($_POST['question'])){
            $msg = 'Veuillez entrer votre question';
        }
        elseif (empty($_POST['score'])){
            $msg = 'Veuillez saisir le nombre de point de la question';
        }
    elseif ($_POST['score']<1){
        $msg = 'Veuillez saisir un nombre positif';
    }
    elseif(isset($_POST['type_question'])){
        $score = $_POST['score'];
        $question = $_POST['question'];
        if(empty($_POST['type_question'])){
            $msg='Veullez choir un type de réponse';
        }
        else {
            $type_reponse = $_POST['type_question'];
            if ($type_reponse == 'choix_simple') {
                if ((isset($_POST['nombre_reponse']))) {
                    if (empty($_POST['nombre_reponse'])) {
                        $msg = 'veuillez entrer le nombre de reponse';
                    } elseif ($_POST['nombre_reponse'] <= 0) {
                        $msg = 'veuillez entrer le nombre strictement positif';
                    } else {
                        if (!(isset($rep)) && !(empty($rep))){
                            $rep = array(
                                'bonne_reponse' => '',
                                'fausse_reponse' => ''
                            );
                        }
                        for ($i = 1; $i <= $_POST['nombre_reponse']; $i++){
                            if (isset($_POST['reponse'.$i])) {
                                if (empty($_POST['reponse'.$i])) {
                                    $msg = "Donner la reponse $i";
                                    break;
                                } else {
                                    if (isset($_POST["c$i"])){
                                        $rep['bonne_reponse'][] = $_POST['reponse'.$i];
                                    }
                                    else {
                                        $rep['fausse_reponse'][] = $_POST['reponse'.$i];
                                    }
                                }
                            }
                        }
                        //var_dump($rep);
                             if((isset($rep['bonne_reponse']) && !empty($rep['bonne_reponse'])) && (isset($rep['fausse_reponse']) && !empty($rep['fausse_reponse']))){
                            $questions = array(
                                'questions' => $question,
                                'score' => $score,
                                'reponse' => $rep
                            );
                            $question_js[] = $questions;
                            $question_js = json_encode($question_js);
                            file_put_contents('questions.json', $question_js);
                        }
                       /* if(!isset($rep['bonne_reponse']) && empty($rep['bonne_reponse'])){
                            $msg = 'Veuillez cocher la bonne reponse';
                        }*/
                    }
                }
            }
            if ($type_reponse == 'choix_texte') {
                if (isset($_POST['reponse_texte']) && empty($_POST['reponse_texte'])) {
                    $msg = 'Veuillez entrer votre reponse';
                } else {
                    $reponse_simple = array(
                        'questions' => $question,
                        'score' => $score,
                        'reponse' => $_POST['reponse_texte'],
                    );
                    $questions = $reponse_simple;
                    $question_js[] = $questions;
                    $question_js = json_encode($question_js);
                    file_put_contents('questions.json', $question_js);
                }
            }
            if ($type_reponse == 'choix_multiple') {
                if ((isset($_POST['number_reponse']))) {
                    if (empty($_POST['number_reponse'])) {
                        $msg = 'veuillez entrer le nombre de reponse';
                    } elseif ($_POST['number_reponse'] <= 0) {
                        $msg = 'veuillez entrer le nombre strictement positif';
                    } else {
                        if (!(isset($rep)) && !(empty($rep))) {
                            $rep = array(
                                'bonne_reponse' => '',
                                'fausse_reponse' => ''
                            );
                        }
                        $bonne_reponse = '';
                        $mauvaise_response = '';
                        for ($i = 1; $i <= $_POST['number_reponse']; $i++){
                            if (isset($_POST['reponse' . $i])) {
                                if (empty($_POST['reponse' . $i])) {
                                    $msg = "Donner la reponse $i";
                                    break;
                                } else {
                                    if (isset($_POST["c$i"])) {
                                        $rep['bonne_reponse'][] = $_POST['reponse' . $i];
                                    } else {
                                        $rep['fausse_reponse'][] = $_POST['reponse' . $i];
                                    }
                                }
                            }
                        }
                        if(isset($rep['bonne_reponse']) && empty($rep['bonne_reponse'])){
                            $msg = 'Veuillez cocher les bonnes reponses';
                        }
                        if(isset($rep['fausse_reponse']) && empty($rep['fausse_reponse'])){
                            $msg = 'Veuillez donner les mauvaises réponses';
                        }
                        if((isset($rep['bonne_reponse']) && !empty($rep['bonne_reponse'])) && (isset($rep['fausse_reponse']) && !empty($rep['fausse_reponse']))){
                            $questions = array(
                                'questions' => $question,
                                'score' => $score,
                                'reponse' => $rep
                            );
                            $question_js[] = $questions;
                            $question_js = json_encode($question_js);
                            file_put_contents('questions.json', $question_js);
                        }
                    }
                }
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
    <link type="text/css" rel="stylesheet" href="css/formlaire_creation_questions.css?refresh=<?php echo rand();?>">
    <title>Document</title>
</head>
<style>

    @media screen and (min-width: 320px) and  (max-width: 667px) {

    }

</style>
<body>
<h1 class="titre_para_ques">PARAMÉTRER VOTRE QUESTION</h1>

<div class="formulaire">
    <?php if(isset($msg)){echo "<div class='message_erreur'>$msg</div>";} ?>
    <form action="" method="post" name="form" id="form-connexion">
        <div>
            <span id="error-1"></span>
            <label class="title_tag"><span>Questions</span></label>
            <textarea required name="question" error="error-1"><?php if(isset($_POST['question'])){echo $_POST['question'];} ?></textarea><br>
        </div>
        <span id="error-2"></span>
        <label class="title_score"><span class="score">Nbre de points   </span></label>
        <input required error="error-2" class="inpt_score" type="number" name="score" value="<?php if(isset($_POST['score'])){echo $_POST['score'];} ?>"><br>
        <span id="error-3"></span>
        <label class="title_type" style="">Type de réponse</label>
        <select required error="error-3" name="type_question" style="margin-left: 9%" id="type_question" value="">
            <?php if(isset($_POST['type_question'])){echo $_POST['type_question'];}?>
            <option class="defaut" value=""></option>
            <option name="choix_simple" class="choix_multiple" value="choix_simple">Choix simple</option>
            <option name="choix_multiple" class="choix_simple" value="choix_multiple">Choix multiple</option>
            <option name="choix_texte" class="choix_text" value="choix_texte">Choix texte</option>
        </select>
        <div class="ajouter_nbre_reponses"><a href="#" name="ajout_nombre_reponse"  onclick="type_questions()"><img src="../Images/Icônes/ic-ajout-réponse.png" style=""></a></div>
        <br>
        <div id='ajout_type_reponse'>
            <h3 id="titre" class="titre" style="color: black"></h3>
        </div>

        <div id="conteneur" style="margin-top: -2%">
        </div>
        <p><button type="submit" class="enregistrer" name="valider" style="" onclick=""><strong>Enrégistrer</strong></button></p>
    </form>
</div>
</body>
<script src="../js/form_creation.js"></script>
</html>