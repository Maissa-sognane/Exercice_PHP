<?php
session_start();
//faire pagination
function pagination($page,$tab){
    $NbrLigne=0;
    if (count($tab)!=0)
    {$k=($page-1)*100;
        ?>
        <table border="1" width="700" style="margin-left:-15%">
            <tbody>
            <?php
            for ($i=$k; $i <$k+100 ; $i+=10)
            {
                echo "<tr>";
                for ($j=$i; $j <$i+10 ; $j++)
                {
                    if (array_key_exists($j, $tab))
                        echo "<td>$tab[$j]</td>";
                    else
                        echo "<td>&nbsp;</td>";
                }
                echo "</tr>";}?>
            </tbody>
        </table>
    <?php } else{?>
        pas de données
        <?php
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercice1</title>
</head>
<body>
    <h1 style="text-align:center;">Exercice 1</h1>
<style>
    body{
        background-color: #D6FFCB;
    }
    .formulaire{
        text-align: center;
    }
    input{
        width: 30%;
        height: 40px;
    }
    tbody tr:nth-child(odd) {
  background-color: #E6EEE6;
}

tbody tr:nth-child(even) {
  background-color: #e795e4;
}


table {
  background-color: #f833cc;
}
</style>
<div>
<div class="formulaire">
    <form action="#" method="post">
        <h1>Donner un nombre entier supérieur à 10000</h1>
        <input type="text" name="nombre" value="<?php if(isset($_POST['nombre']) && (preg_match("#[0-9]^.#", $_POST['nombre'])) && ($_POST['nombre']>10000)){echo $_POST['nombre'];}?>">
        <input class="btn btn-validate" type="submit" name="valider" value="Valider">
    </form>
</div>
<div style=" margin-left: 40%">
    <?php
    if(isset($_POST['valider'])){
        if (!(empty($_POST['nombre']))) {
            if ((preg_match("#[^0-9]#", $_POST['nombre'])) || ($_POST['nombre'] > 10000)) {
                echo "<h2>Donner un nombre entier supérieur à 10000</h2>";
            } else {
                //Recuperer les nombres premiers
                $n = $_POST['nombre'];
                $som = 0;
                $nbr = 0;
                $res = "";
                $T1 = array();
                echo "<h1>Tableau T1</h1>";
                for ($i = 1; $i <= $n; $i++) {
                    $res = 0;
                    $som = 0;
                    $nbr = 0;
                    for ($j = 1; $j <= $i; $j++) {
                        $res = $i % $j;
                        if ($res == 0) {
                            $nbr = $nbr + 1;
                        }
                    }
                    if ($nbr == 2) {
                        $T1[] = $i;
                    }
                }
                //Fonction calculer la moyenne
                function table_moyenne($table)
                {
                    $som = 0;
                    $taille = 0;
                    foreach ($table as $nombres) {
                        $som = $som + $nombres;
                        $taille = $taille + 1;
                    }
                    $moyenne = $som / $taille;
                    return $moyenne;
                }

                $moyenne_tableau = table_moyenne($T1);
            //Affichage tableau fonction
                function AffichageTableau($table)
                {

                    $NbrCol = 10;
                    $NbrLigne = 10;
                    echo '<table border="2" width="500">';
                    $s = 0;
                    $nbt = count($table);
                    for ($i = 0; $i < $NbrLigne; $i++) {
                        echo '<tr>';
                        for ($j = 0; $j < $NbrCol; $j++) {
                            echo '<td>';
                            if (!empty($table[$s])) {
                                echo $table[$s];
                                $s++;
                            }
                            echo '</td>';
                        }
                        echo '</tr>';
                    }
                    echo '</table>';

                }
                $_SESSION['tableau'] = $T1;
                $T2 = array();
                $T3 = array();

                foreach ($T1 as $key1 => $valeur) {
                    if ($valeur < $moyenne_tableau) {
                        $T2[] = $valeur;
                    } else {
                        $T3[] = $valeur;
                    }
                }
                $_SESSION['T2'] = $T2;
                $_SESSION['T3'] = $T3;
            }
        }
        else{
            echo '<h2 style="text-align: center; margin-top: 7%">Donner un nombre entier superieur à 10000</h2>';
        }
    }
    if(isset($_SESSION['tableau']) && isset($_POST['nombre']) && is_numeric($_POST['nombre']) && $_POST['nombre']<=10000){
        echo "<h4>Tableau des nombres premiers</h4>";

        $nombreDePage=ceil(count($_SESSION['tableau'])/100);
        if (isset($_GET['page'])) {
            $page=$_GET['page'];
            pagination($page,$_SESSION['tableau']);
        }else{
            pagination(1,$_SESSION['tableau']);
        }
        echo "</br> Page: ";
        for ($i=1; $i <=$nombreDePage ; $i++) {
            echo '<a href="exercice1.php?page='.$i.'">'.$i.'</a>';
        }
    }
    if(isset($_SESSION['T2']) && isset($_POST['nombre']) && is_numeric($_POST['nombre']) && $_POST['nombre']<=10000){
        echo "<h4>Tableau des nombres premiers inferieurs a la moyenne</h4>";

        $nombreDePage=ceil(count($_SESSION['T2'])/100);
        if (isset($_GET['page'])) {
            $page=$_GET['page'];
            pagination($page,$_SESSION['T2']);
        }else{
            pagination(1,$_SESSION['T2']);
        }
        echo "</br> Page: ";
        for ($i=1; $i <=$nombreDePage ; $i++) {
            echo '<a href="exercice1.php?page='.$i.'">'.$i.'</a>';
        }
    }
    if(isset($_SESSION['T3']) && isset($_POST['nombre']) && is_numeric($_POST['nombre']) && $_POST['nombre']<=10000){
        echo "<h4>Tableau des nombres premiers superieurs a la moyenne</h4>";

        $nombreDePage=ceil(count($_SESSION['T3'])/100);
        if (isset($_GET['page'])) {
            $page=$_GET['page'];
            pagination($page,$_SESSION['T3']);
        }else{
            pagination(1,$_SESSION['T3']);
        }
        echo "</br> Page: ";
        for ($i=1; $i <=$nombreDePage ; $i++) {
            echo '<a href="exercice1.php?page='.$i.'">'.$i.'</a>';
        }
    }
    

    ?>
</div>
</div>
</body>
</html>
