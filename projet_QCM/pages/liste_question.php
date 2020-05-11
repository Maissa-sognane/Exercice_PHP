<body>
<div >
    <form action="" method="post" class="titre_entete_lister_question">
        <h3 class="titre_question">Nbre de question/jeu</h3>
        <?php
        $T = file_get_contents("./data/nbre_question.json");
        $T = json_decode($T);
        ?>
        <input type="number" class="champ_nbre_questions" name="nombre_question" value="<?php if(isset($T[0]))
        {echo $T[0] ;} ?>">
        <input class="button_ok" type="submit" value="OK">
    </form>
    <div class="affiche_reponse_lister_question">
        <?php
        if(isset($_POST['nombre_question']) && is_numeric($_POST['nombre_question'])){
            if(empty($_POST['nombre_question'])){
                echo 'Nombre question vide';
            }
            else{
                $T = [];
                $T[0] = $_POST['nombre_question'];
                $js = $T[0];

                $js = json_encode($js);
                file_put_contents('./data/nbre_question.json', $js);

                $_SESSION['T'] = array();
                $_SESSION['T'][] = $_POST['nombre_question'];
            }
        }

        $questions = file_get_contents('./data/questions.json');
        $question_json = json_decode($questions);
        $size = count($question_json);
       // $question_json = array_unique($question_json);
      //  var_dump($question_json);

        ##############PAGINATION####################
        if(isset($_GET['pages'])){
            $_GET['pages'] = intval($_GET['pages']);
            $currentPage= $_GET['pages'];
        }
        else{
            $currentPage = 1;
        }
        $count = $size;
        $perPage = 5;
        $pages = ceil($count/$perPage);
        $offeset = $perPage * ($currentPage - 1);
        $question_json = array_slice($question_json,$offeset, $perPage);

        for ($i=0; $i<$size; $i++){
            $x = $i+1;
                if ($question_json[$i]){
                    $affich_question = $x.'.'.$question_json[$i]->{'questions'} ;
                    echo "<span class='afficher_question_lister_question'>$affich_question</span><br/>";
                    if (is_object($question_json[$i]->{'reponse'})){
                        if(sizeof($question_json[$i]->{'reponse'}->{'bonne_reponse'}) == 1){
                            echo '<input type="radio" disabled="disabled" checked="checked"/><span class="affich_reponse_lister_question">'.$question_json[$i]->{'reponse'}->{'bonne_reponse'}[0].'</span><br/>';
                            for ($k=0;$k<count($question_json[$i]->{'reponse'}->{'fausse_reponse'});$k++){
                                echo '<input disabled="disabled" type="radio"/><span class="affich_reponse_lister_question">'.$question_json[$i]->{'reponse'}->{'fausse_reponse'}[$k].'</span><br/>';
                            }
                        }
                        if(sizeof($question_json[$i]->{'reponse'}->{'bonne_reponse'}) > 1){
                            for ($j=0; $j<sizeof($question_json[$i]->{'reponse'}->{'bonne_reponse'});$j++){
                                echo '<input type="checkbox" disabled="disabled" checked="checked"/><span class="affich_reponse_lister_question">'.$question_json[$i]->{'reponse'}->{'bonne_reponse'}[$j].'</span><br/>';
                            }
                            for ($k=0;$k<count($question_json[$i]->{'reponse'}->{'fausse_reponse'});$k++){
                                echo '<input disabled="disabled" type="checkbox"/><span class="affich_reponse_lister_question">'.$question_json[$i]->{'reponse'}->{'fausse_reponse'}[$k].'</span><br/>';
                            }
                        }
                    }
                    else{
                        echo '<span class="affich_reponse_lister_question"><input readonly  name="reponse'.$i.'" style="width: 49%; height: 26px;margin-left: 6%;border-radius: 8px;" value="'.$question_json[$i]->{'reponse'}.'"/></span><br/>';
                    }
                }

        }

        echo '</div>';

        $precedent = $currentPage-1;
        $suivant = $currentPage + 1;

        if($currentPage>1){
            $link ='?lien=admin&menu=liste_question';
            if($currentPage>2){
                $link .= '&pages='.$precedent;
            }
            echo ' <a href="'.$link.'"><button class="boutton_precendent_lister_question">&laquo;Precedent</button></a> ';
        }
        if($currentPage<$pages){
            echo ' <a href="?lien=admin&menu=liste_question&pages='.$suivant.'"><button class="button_suivant_lister_question">Suivant &raquo;</button></a> ';
        }

        ?>
    </div>
</div>
</body>

