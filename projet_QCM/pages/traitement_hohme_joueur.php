
<div class="question">
        <?php
        $questions = file_get_contents('./data/questions.json');
        $question_json = json_decode($questions,true);

        $T = file_get_contents('./data/nbre_question.json');
        $T = json_decode($T,true);
        $tag = file_get_contents("./data/Tag.json");
        $tag = json_decode($tag, true);
        $tab_affichage= [];
        $a=0;
        if(isset($_SESSION['questions'])){
            $question_json = $_SESSION['questions'];
        }
if(isset($tag)) {
    for ($i = 0; $i < count($question_json); $i++) {
        $trouver = false;
        if ($question_json[$i]) {
            for ($j = 0; $j < count($tag); $j++) {
                for ($k = 0; $k < count($tag[$j][$_SESSION['login']]); $k++) {
                    if ($question_json[$i] == $tag[$j][$_SESSION['login']][$k]) {
                        $trouver = true;
                    }
                }

            }
            if ($trouver == true) {
                unset($question_json[$i]);
            }
        }
    }
}


        for ($i=0;$i<count($question_json); $i++){
            if(isset($question_json[$i])){
                $tab_affichage[] = $question_json[$i];
            }

        }
        $question_json = $tab_affichage;
        $size_total = count($question_json);


        echo '<form action="';
        echo '" method="post" id="myForm">';
        $question_afficher = '';
        $n=1;

        echo '<h1 style="text-align: center;text-decoration: underline;">Question '.$_SESSION['n'].'/' .$T[0]. '</h1>';

        $size = count($question_json);

        $_SESSION['nbrpts'] = 0;
        if(isset($_GET['pages'])){
            $_GET['pages'] = intval($_GET['pages']);
            $currentPage = $_GET['pages'];
        }
        else{
            $currentPage = 1;
        }

        $pos = rand(0, $size);
        $count =  $T[0];
        $perPage = 1;
        $pages = ceil($count / $perPage);
        $offeset = $perPage * ($currentPage - 1);
        $question_json = array_slice($question_json, $offeset, $perPage);



if($size_total>=$T[0]){
    for ($i=0; $i<count($question_json); $i++) {
        if(isset($i)) {
            if (isset($question_json[$i]['questions'])) {
                $affich_question = $question_json[$i]['questions'];
                $_SESSION['questions_afficher'] = $affich_question;
                echo "<span class='afficher_question'><h4 style='text-align: center'>$affich_question</h4></span><br/>";
            }
        }
    }

        ?>
</div>
<div class="scoreTag">
        <?php
        for ($i=0; $i<count($question_json); $i++){
                echo '<span class="score_question">' .$question_json[$i]['score'].' pts</span><br>';
        }
        ?>
    </div>
<div class="reponse_question">
        <?php

        $users = array();
        if(isset($_POST['reponse_texte0'])){
            $_SESSION['reponse_texte0'] = $_POST['reponse_texte0'];
        }
        for ($i=0; $i<count($question_json); $i++){
                $reponse = '';
                $_SESSION['score'] = $question_json[$i]['score'];
                if (is_array($question_json[$i]['reponse'])){
                    if(sizeof($question_json[$i]['reponse']['bonne_reponse']) == 1){
                        echo'<label class="container">'.$question_json[$i]['reponse']['bonne_reponse'][0].
                            '<input id= "reponse_bonne0"  value="'.$question_json[$i]['reponse']['bonne_reponse'][0].
                            '" name="reponse0" type="radio"';
                        if(isset($_SESSION['precedent']) || isset($_SESSION['boutton_suivant'])){
                            foreach ($_SESSION['table_question_joueur'] as $key=>$reponse){
                                if(($_SESSION['questions_afficher'] == $key)){
                                    if($reponse == $question_json[$i]['reponse']['bonne_reponse'][0]){
                                        echo 'checked="checked"';
                                    }
                                }
                            }
                        }
                        echo '"><span class="checkmark"></span></label><br>';
                        for ($k=0;$k<count($question_json[$i]['reponse']['fausse_reponse']);$k++){
                            echo'<label class="container">'.$question_json[$i]['reponse']['fausse_reponse'][$k].
                                '<input  value="'.$question_json[$i]['reponse']['fausse_reponse'][$k].'" name="reponse0" type="radio"';
                            if(isset($_SESSION['precedent']) || isset($_SESSION['boutton_suivant'])){
                                foreach ($_SESSION['table_question_joueur'] as $key=>$reponse){
                                    if(($_SESSION['questions_afficher'] == $key)){
                                        if($reponse == $question_json[$i]['reponse']['fausse_reponse'][$k]){
                                            echo 'checked="checked"';
                                        }
                                    }
                                }
                            }
                               echo '" ><span class="checkmark"></span></label><br>';
                        }
                    }
                    if(sizeof($question_json[$i]['reponse']['bonne_reponse']) > 1){
                        for ($j=0; $j<sizeof($question_json[$i]['reponse']['bonne_reponse']);$j++){
                            echo'<label class="container">'.$question_json[$i]['reponse']['bonne_reponse'][$j].
                                '<input id= "reponse_bonne'.$j.'"  value="'.$question_json[$i]['reponse']['bonne_reponse'][$j].
                                '" name="reponse_bonne'.$j.'" type="checkbox"';
                            if(isset($_SESSION['precedent']) || isset($_SESSION['boutton_suivant'])){
                                foreach ($_SESSION['table_question_joueur'] as $key=>$reponse){
                                    if(($_SESSION['questions_afficher'] == $key)){
                                        foreach ($_SESSION['reponse_cocher_deja'] as $question_cocher){
                                            if($question_json[$i]['reponse']['bonne_reponse'][$j] == $question_cocher){
                                                echo 'checked="checked"';
                                            }
                                        }
                                    }
                                }
                            }
                            echo '"><span class="checkmark"></span></label><br>';
                        }
                        for ($k=0;$k<count($question_json[$i]['reponse']['fausse_reponse']);$k++){
                            echo'<label class="container">'.$question_json[$i]['reponse']['fausse_reponse'][$k].
                                '<input value="'.$question_json[$i]['reponse']['fausse_reponse'][$k].'" name="reponse'.$k.
                                '" type="checkbox"';
                            if(isset($_SESSION['precedent']) || isset($_SESSION['boutton_suivant'])){
                                foreach ($_SESSION['table_question_joueur'] as $key=>$reponse){
                                    if(($_SESSION['questions_afficher'] == $key)){
                                        foreach ($_SESSION['reponse_cocher_deja'] as $question_cocher){
                                            if($question_json[$i]['reponse']['fausse_reponse'][$k] == $question_cocher){
                                                echo 'checked="checked"';
                                            }
                                        }
                                    }
                                }
                                }
                            echo '"><span class="checkmark"></span></label><br>';
                        }
                    }
                }
                else{
                    echo '<span class="affich_reponse"><input type="text" placeholder="REPONSE" id="reponse_texte0" name="reponse_texte0" style="width: 49%; height: 26px;" value="';
                    if(isset($_SESSION['precedent']) || isset($_SESSION['boutton_suivant'])){
                      foreach ($_SESSION['table_question_joueur'] as $key=>$reponse){
                          if($_SESSION['questions_afficher'] == $key){
                              echo $reponse;
                          }
                      }
                    }
                    echo '"/></span><br/>';
                }
        }


        $score = array(
            $_SESSION['login_joueur']=>array()
        );

        $precedent = $currentPage-1;
        $suivant = $currentPage + 1;
        $_SESSION['pages'] = $pages;
        $_SESSION['current'] = $currentPage;
        $_SESSION['precedent'] = $precedent;
        $_SESSION['suivant'] = $suivant;

        if($_SESSION['current'] < $_SESSION['pages']){
            echo ' <a href="?lien=joueur&pages='.$_SESSION['suivant'].'"><input type="submit" value="Suivant" id="suivant"   name="boutton_suivant" class="button_suivant"></a> ';

        }
        if ($_SESSION['current'] == $_SESSION['pages']){
            echo ' <a href="?lien=joueur&pages='.$_SESSION['current'].'" ><input type="submit" name="button_terminer" class="button_suivant" style="background: green; margin-top: 2%" value="Terminer"></a> ';
        }
        if($_SESSION['current']>1){
            $link ='?lien=joueur';
            if($_SESSION['current']>2){
                $link .= '&pages='.$_SESSION['precedent'];
            }
            echo ' <a href="'.$link.'"><input type="button" value="Precedent" name="boutton_precedent" class="boutton_precendent"></a> ';
        }
        echo '</form>';

        ?>
        <?php

         if(isset($_POST['boutton_suivant'])){
             $_SESSION['boutton_suivant'] = $_POST['boutton_suivant'];
             $_SESSION['n']=$_SESSION['suivant'];
             $_SESSION['precedent'] = null;
             unset($_SESSION['precedent']);
             header('Location:?lien=joueur&pages='.$_SESSION['suivant']);
        }
        }
        else{
            echo '<h3 style="color: red; text-align: center">Jeux Indisponible</h3>';
            }
        if(isset($_POST['boutton_precedent'])){
            $_SESSION['precedent'] = $_POST['boutton_precedent'];
        }
        ?>
</div>

