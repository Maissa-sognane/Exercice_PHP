<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<style>
    .classement{
        font-size: 30px;

    }
    .class_score{
        margin-top: 10%;
        margin-left: 4%;
    }
    .points{
        margin-right: 9%;
        float: right;
    }
</style>
<body>
<div class="class_score">
<?php
$score = file_get_contents('user.json');
$score_joueur = json_decode($score);
echo '<br>';
$T = [];
$t_score = [];
for($i=0;$i<count($score_joueur);$i++){
    $tmp = 0;
    if($score_joueur[$i]->{'profit'} == 'joueur'){
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
</body>
</html>
