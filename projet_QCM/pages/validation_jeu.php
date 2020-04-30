<style>
    body{
        background-color: #7a7e7a;
    }
    .form_val{
        margin-top: 30%;
        text-align: center;
    }
    .input_val{
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
        .input_val{
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
<form class="form_val" action="" method="post">
    <?php
    $score = file_get_contents('./data/score.json');
    $score = json_decode($score, true);
    $questions = file_get_contents('./data/questions.json');
    $question_json = json_decode($questions,true);
    shuffle($question_json);

    //var_dump($score);
  //  echo $_SESSION['points'];
    for ($i=0;$i<count($score);$i++){
        if (isset($score[$i][$_SESSION['login']])){
            echo "<span class='score_pts'> Votre score : ";
            echo '<strong>';
            echo $score[$i][$_SESSION['login']]['score'];
            echo ' pts</strong>';
            echo "</span><br>";
        }
    }

    ?>
    <input class="input_val" type="submit" value="Rejouer" name="rejouer" style="background-color: green;border-color: green">
    <a href="?statut=logout"><input class="input_val"  type="submit" value="Quitter" name="quitter" style="background-color: red;border-color: red"></a>
</form>
<?php
if(isset($_POST['rejouer'])){
    shuffle($question_json);
}
?>
</body>
</html>
