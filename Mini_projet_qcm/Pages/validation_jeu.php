<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<style>
    body{
        background-color: #7a7e7a;
    }
    form{
        margin-top: 30%;
        text-align: center;
    }
    input{
        width: 40%;
        height: 50px;
        color: white;
        border-radius: 10px;
        font-size: 30px;
        margin-top: 2%;
    }
    .score_pts{
        margin-top: -3%;
        font-size: 30px;
    }
    strong{
        border-bottom: 4px solid #3ADDD6;
    }
    @media screen and (min-width: 320px) and  (max-width: 667px){
        input{
            width: 30%;
            height: 30px;
            font-size: 15px;
        }
        .score_pts{
            font-size: 16px;
        }
    }
</style>
<body>
<form action="" method="post">
    <?php
    $score = file_get_contents('score.json');
    $score = json_decode($score);
    $questions = file_get_contents('questions.json');
    $question_json = json_decode($questions);
    shuffle($question_json);

    //var_dump($score);
  //  echo $_SESSION['points'];
    for ($i=0;$i<count($score);$i++){
        if (isset($score[$i]->{$_SESSION['login_joueur']})){
            echo "<span class='score_pts'> Votre score : ";
            echo '<strong>';
            echo $score[$i]->{$_SESSION['login_joueur']}->{'score'};
            echo ' pts</strong>';
            echo "</span><br>";
        }
    }

    ?>
    <input type="submit" value="Rejouer" name="rejouer" style="background-color: green;border-color: green">
    <input type="submit" value="Quitter" name="quitter" style="background-color: red;border-color: red">
</form>
<?php
if(isset($_POST['rejouer'])){
    shuffle($question_json);
}
?>
</body>
</html>
