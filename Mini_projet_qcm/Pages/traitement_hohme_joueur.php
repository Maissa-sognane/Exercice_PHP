<div class="question">
        <?php
        $questions = file_get_contents('questions.json');
        $question_json = json_decode($questions);
        shuffle($question_json);
        $T = file_get_contents('nbre_question.json');
        $T = json_decode($T);

        echo '<form action="';
        echo '" method="post" id="myForm">';
        $question_afficher = '';
        $n=1;

        echo '<h1 style="text-align: center;text-decoration: underline;">Question '.$_SESSION['n'].'/' .$T[0]. '</h1>';

        $size = count($question_json);

        $_SESSION['nbrpts'] = 0;

        if (isset($_GET['pages'])) {
            $_GET['pages'] = intval($_GET['pages']);
            $currentPage = $_GET['pages'];
        } else {
            $currentPage = 1;
        }

        $pos = rand(0, $size);
        $count =  $T[0];
        $perPage = 1;
        $pages = ceil($count / $perPage);
        $offeset = $perPage * ($currentPage - 1);
        $question_json = array_slice($question_json, $offeset, $perPage);



        for ($i=0; $i<count($question_json); $i++) {
            if ($question_json[$i]) {
                $affich_question =  $question_json[$i]->{'questions'};
                echo "<span class='afficher_question'><h4 style='text-align: center'>$affich_question</h4></span><br/>";
            }
        }
        ?>
    </div>
    <div class="scoreTag">
        <?php
        for ($i=0; $i<count($question_json); $i++){
            if ($question_json[$i]) {
                echo '<span class="score_question">' .  $question_json[$i]->{'score'} . ' pts</span><br>';
            }
        }
        ?>
    </div>
    <div class="reponse_question">
        <?php
        //  $reponse = '';
        $users = array();
        if(!isset($_SESSION['rep']) && !empty($_SESSION['rep'])) {
            $_SESSION['rep'] = array(
                'score'=>0
            );
        }

        for ($i=0; $i<count($question_json); $i++){
            if ($question_json[$i]){
                $reponse = '';
                $_SESSION['score'] = $question_json[$i]->{'score'};
                if (is_object($question_json[$i]->{'reponse'})){
                    if(sizeof($question_json[$i]->{'reponse'}->{'bonne_reponse'}) == 1){
                        echo'<label class="container">'.$question_json[$i]->{'reponse'}->{'bonne_reponse'}[0].
                            '<input id= "reponse_bonne0"  value="'.$question_json[$i]->{'reponse'}->{'bonne_reponse'}[0].
                            '" name="reponse0" type="radio"><span class="checkmark"></span></label><br>';
                        for ($k=0;$k<count($question_json[$i]->{'reponse'}->{'fausse_reponse'});$k++){
                            echo'<label class="container">'.$question_json[$i]->{'reponse'}->{'fausse_reponse'}[$k].
                                '<input  value="'.$question_json[$i]->{'reponse'}->{'fausse_reponse'}[$k].'" name="reponse0" type="radio"><span class="checkmark"></span></label><br>';
                        }
                    }
                    if(sizeof($question_json[$i]->{'reponse'}->{'bonne_reponse'}) > 1){
                        for ($j=0; $j<sizeof($question_json[$i]->{'reponse'}->{'bonne_reponse'});$j++){
                            echo'<label class="container">'.$question_json[$i]->{'reponse'}->{'bonne_reponse'}[$j].
                                '<input id= "reponse_bonne'.$j.'"  value="'.$question_json[$i]->{'reponse'}->{'bonne_reponse'}[$j].
                                '" name="reponse_bonne'.$j.'" type="checkbox"><span class="checkmark"></span></label><br>';
                        }
                        for ($k=0;$k<count($question_json[$i]->{'reponse'}->{'fausse_reponse'});$k++){
                            echo'<label class="container">'.$question_json[$i]->{'reponse'}->{'fausse_reponse'}[$k].
                                '<input value="'.$question_json[$i]->{'reponse'}->{'fausse_reponse'}[$k].'" name="reponse'.$k.
                                '" type="checkbox"><span class="checkmark"></span></label><br>';
                        }
                    }

                }
                else{
                    echo '<span class="affich_reponse"><input placeholder="REPONSE" id="reponse_texte0" name="reponse_texte0" style="width: 49%; height: 26px;" value="';
                    if(isset($_POST['reponse_texte0'])){
                        $_SESSION['reponse_texte0'] = $_POST['reponse_texte0'];
                        echo $_SESSION['reponse_texte0'];
                    }
                    echo '"/></span><br/>';
                }
            }

        }


        // var_dump($reponse);
       var_dump($_SESSION['rep']);
        //  var_dump($parsed_json);

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
            echo ' <a href="home_joueur.php?&pages='.$_SESSION['suivant'].'"><input type="submit" value="Suivant"   name="boutton_suivant" class="button_suivant"></a> ';
            // echo' <a href="home_joueur.php?&pages='.$_SESSION['suivant'].'"><button name="boutton_suivant" class="button_suivant">Suivant</button></a>';
        }
        if ($_SESSION['current'] == $_SESSION['pages']){
            echo ' <a href="home_joueur.php?&pages='.$_SESSION['current'].'" ><input type="submit" name="button_terminer" class="button_suivant" style="background: green; margin-top: 2%" value="Terminer"></a> ';
        }
        if($_SESSION['current']>1){
            $link ='home_joueur.php?';
            if($_SESSION['current']>2){
                $link .= 'pages='.$_SESSION['precedent'];
            }
          //  echo ' <a href="'.$link.'"><input type="button" value="Precedent" name="boutton_precedent" class="boutton_precendent"></a> ';
        }
        echo '</form>';


        ?>
        <?php
        /*
         if(isset($_POST['boutton_suivant'])){
            header('Location:home_joueur.php?&pages='.$_SESSION['suivant'].'');
        }*/
        ?>
    </div>
