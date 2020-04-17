<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Exercice4</title>
</head>
<style>
    body{
        background-color: rgba(169, 51, 9, 0.44);
    }
    textarea{
        width:50%;
        height: 150px;
       /* background-color: rgba(169,167,154,0.44);*/
    }
    .form{
        text-align: center;
    }
    .button_ajouter{
        width: 10%;
        height: 50px;
        border-radius: 10px 10px 10px 10px;
    }
    .button_anuller{
        width: 10%;
        height: 50px;
        border-radius: 10px 10px 10px 10px;
    }

    a{
        color: black;
        text-decoration: none;
        font-size: 20px;
    }
</style>
<body>
<div class="form">
    <form action="#" method="post">
        <h1 style="margin-left: -30%;">Remplir</h1>
        <textarea  type="text" name="phrase" placeholder="Remplir ici"><?php if(isset($_POST['phrase'])){echo $_POST['phrase'];}?></textarea>
        <button class="button_ajouter" style="background-color: #81f905;border: #81f905"><a href="#">Afficher</a></button>
        <button class="button_anuller" style="background-color: #f9150e;border: #f9150e"><a href="Exercice4.php">Annuler</a></button>
    </form>
    <?php
    if(isset($_POST['phrase'])){
        if((empty($_POST['phrase']))){
            echo "<h2>Donner des phrases</h2>";
        }
        else{
            function get_phrase($phrase){
                if(preg_match("#^[A-Z]\|?|!|.$#", $phrase)){
                    return true;
                }else{
                    return false;
                }
            }
//Fonction recuperer le nombre de phrases et les pointillées
            function count_phrase($phrase){
                $nbr=0;
                $T = [];
                for($i=0; $i<strlen($phrase); $i++){
                    if (preg_match("#[.?!]$#", $phrase[$i])){
                        $T[] = $phrase[$i];
                        $nbr++;
                    }
                }
                return $T;
            }
            $phrases = $_POST['phrase'];
            $phrases = trim($_POST['phrase']);
            if(get_phrase($phrases) == false){
                echo '<h1>Donner des phrases correctes</h1>';
            }
            else{
                $points = count_phrase($phrases);
                $chaine = preg_split("#[.!?]#", $phrases);
                $phrase_normal[] = array();
                echo "<br>";
                foreach ($chaine as $key=>$phrase){
                    if( strlen($phrase) <= 200 && strlen($phrase) != "") {
                        echo "<br>";
                        $phrase_normal[] = $phrase;
                    }
                }
                $phrase_corriger[] = array();
                $phrase_corriger_interieur[] = array();
                foreach ($phrase_normal as $key=>$phrase){
                    if(!(empty($phrase))){
                        $phrase_esp =  preg_replace('/^\s+/', '', $phrase);
                        $phrase_corriger[$key] = $phrase_esp;
                    }
                }
                foreach ($phrase_corriger as $key=>$phrases){
                    if(!(empty($phrases))){
                        $phrase_esp =  preg_replace('/\s\s+/', ' ', $phrases);
                        $phrase_corriger_interieur[$key] = $phrase_esp;
                    }
                }
                $T[] = array();
                foreach ($phrase_corriger_interieur as $key=>$phrases){
                    if(!(empty($phrases))) {
                        if (preg_match("#^[a-z]#", $phrases)) {
                            $phrases = preg_replace("#^[a-z]#", strtoupper($phrases[0]), $phrases);
                            $phrase_corriger_interieur[$key] = $phrases;
                        }
                    }
                }
                echo "<h2 style='margin-left: -30%;margin-top: -6%;'>Les phrases corrigées</h2>";

                echo "<textarea style='margin-top: -1%;margin-left: -20%;'>";
                $j= 0;
                for($i=0;$i<sizeof($phrase_corriger_interieur);$i++){

                    if($phrase_corriger_interieur[$i] != null){
                        echo "$phrase_corriger_interieur[$i]";
                        echo $points[$j];
                        $j++;
                    }
                }
                echo "</textarea>";
            }
        }
    }
    ?>
</div>
</body>
</html>