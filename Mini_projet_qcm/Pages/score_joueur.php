<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<style>
    .classement{
        font-size: 30px;
        margin-top: 6%;
        margin-left: 2%;

    }
    .points{
        margin-right: 9%;
        float: right;
        border-bottom: 4px solid #3ADDD6;
    }
    @media screen and (min-width: 667px) and  (max-width: 1024px){
        .classement {
            font-size: 18px;
        }
    }
    @media screen and (min-width: 320px) and  (max-width: 667px){
        .classement{
            font-size: 13px;
        }
    }

</style
<body>
<?php
$user = file_get_contents('user.json');
$user = json_decode($user);
echo '<br/>';
for ($i=0;$i<count($user);$i++){
    if(isset($user[$i]->{'profit'}) && $user[$i]->{'profit'} == 'joueur'){
        if($_SESSION['login_joueur'] == $user[$i]->{'login'}){
            if($user[$i]->{'score'} != null){
                $max = max($user[$i]->{'score'});
                echo "<div class=\"classement\"><span class=''>Meilleur score  : <em class='points'>$max pts</em></span></div>";
            }
        }
    }
}
?>
</body>
</html>
