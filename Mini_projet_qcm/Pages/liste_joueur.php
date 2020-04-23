<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/liste_joueur.css?refresh=<?php echo rand();?>">
</head>
<body>
<h2>LISTE DES JOUEURS PAR SCORE</h2>
<div class="center">
    <table>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Score</th>
        </tr>
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
        $Tab_classement_par_score = array_unique($Tab_classement, SORT_REGULAR);

        if(isset($_GET['pages'])){
            $_GET['pages'] = intval($_GET['pages']);
            $currentPage= $_GET['pages'];
        }
        else{
            $currentPage = 1;
        }
        $count = count($Tab_classement);
        $perPage = 5;
        $pages = ceil($count/$perPage);
        $offeset = $perPage * ($currentPage - 1);
        $Tab_classement_par_score = array_slice($Tab_classement_par_score,$offeset, $perPage);

        for($i=0;$i<count($Tab_classement);$i++){
            if(isset($Tab_classement_par_score[$i])) {
                echo '<tr>';

                echo "<td>";
                echo $Tab_classement_par_score[$i]['nom'];
                echo "</td>";

                echo "<td>";
                echo $Tab_classement_par_score[$i]['prenom'];
                echo "</td>";

                echo "<td>";
                echo $Tab_classement_par_score[$i]['meileur_score'];
                echo " pts</td>";

                echo '</tr>';
            }
        }
        ?>
    </table>
</div>
<?php
echo '<div class="pagination">';

$precedent = $currentPage-1;
$suivant = $currentPage + 1;

if($currentPage>1){
    $link ='home_admin.php?page=liste_joueur';
    if($currentPage>2){
        $link .= '&pages='.$precedent;
    }
    echo ' <a href="'.$link.'"><input type="button" class="boutton_precendent" value="Precedent"></a> ';
}
if($currentPage<$pages){
    echo ' <a href="home_admin.php?page=liste_joueur&pages='.$suivant.'"><input type="button" class="button_suivant" value="Suivant"></a> ';
}
echo '</div>';
?>
</body>
</html>
