<?php
include "function.php";
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Exercice3</title>
</head>
<style>

    .inpt_js{
        width: 50%;
        height: 40px;
        border-radius: 6px;
    }
    .mot {
        margin-left: -46%;
    }
    .valider{
        height: 40px;
        width: 8%;
        background-color: #4112ff;
        color: white;
        border-color: #4112ff;
        border-radius: 10px
    }
    .annuler{
        height: 40px;
        width: 8%;
        background-color: #ff2c00;
        color: white;
        border-color: #ff2c00;
        border-radius: 10px
    }
    .resultat{
        width: 16%;
        height: 39px;
        border-radius: 6px;
        background-color: green;
        border-color: green ;
        color: white;
        margin-top: 2%;
    }
    .input_mot
    {
        width: 50%;
        height: 40px;
        border-radius: 6px;
        margin-top: 1%;
    }
    .div_mots{
        margin-top: 2%;
    }
</style>
<body>
<div style="text-align: center;">
    <form action="#" method="post">
        <label class="title_number_response"><span>Combien de Mots</span></label><br>
        <input type="text" value="<?php if((isset($_POST['nombre'])) && ($_POST['nombre']>0)){
            echo $_POST['nombre'];
        } ?>"  name="nombre" placeholder="Ex:3" id="number_reponse" style="width: 25%;height: 40px; border-radius: 8px "><br><br>
        <button class="valider" value="Valider" name="ajoutchamp">Valider</button>
        <input type="button" value="Annuler"  class="annuler"><br/>

        <?php

    if(isset($_POST['nombre'])){
        if((empty($_POST['nombre'])) || !(is_numeric($_POST['nombre']))){
            echo '<div style="color: #f9150e; margin-top: 2%; font-size: 40px">Donner un entier</div>';
        }
        else{
            $msg = '';
            $nombre =  $_POST['nombre'];
            $nbre = 0;
            for ($i=1; $i<=$nombre;$i++){
                if(isset($_POST['resultat'])){
                    if(isset($_POST["mot$i"])){
                        if(empty($_POST["mot$i"]) || my_sterlen($_POST["mot$i"]) >= 20){
                            $msg = 'Donner un mot';
                        }
                        else {
                            $mot = trim($_POST["mot$i"]);
                            if(preg_match('#[^a-zA-Z^-]#', $mot)){
                                $msg = 'Donner un mot';
                            }
                            else{
                                if(preg_match("#M#i", $mot)) {
                                    $nbre = $nbre + 1;
                                }
                            }
                        }
                    }
                }
                echo '<div class="div_mots">';
                echo '<span style="margin-left: -47%">Mot N°'.$i.'</span><br>';
                echo "<span style='color: #f9150e'>$msg</span><br>";
                echo '<input name="mot'.$i.'" class="input_mot" value="';
                if(isset($_POST["mot$i"])){
                    echo $_POST["mot$i"];
                }
                echo  ' "/>';
                echo '<br>';
                echo '</div>';
            }
            if(isset($nbre) && $nbre!=0){
                echo '<div style="font-size: 30px; background-color: rgba(103,255,33,0.51); margin-top: 3%; height: 70px;">Le nombre de mots qui ont la lettre m ou M est : '.$nbre.'</div>';
            }
            echo'<button class="resultat" name="resultat">Resultat</button>';

        }

}
        ?>

    </form>
</div>
</body>
</html>

