<?php
//Fonction récupération de fichier json
function get_data($file='user.json'){
    $data = file_get_contents("./data/".$file);
    $data = json_decode($data, true);
    return $data;
}
//Function connection
function connexion($log,$pwd){
    $users = get_data('user.json');
    foreach ($users as $key=>$user){
        if($user['login']===$log && $user['password']===$pwd){
            $_SESSION['statut'] = 'logout';
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['login'] = $user['login'];
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['photo'] = $user['photo'];
            if($user['profit'] === 'admin'){
                return 'admin';
            }
            elseif ($user['profit'] === 'joueur'){
                return 'joueur';
            }
        }
        else{
            if($user['login']!==$log && $user['password']===$pwd){
                return 'error_loging';
            }
            elseif ($user['login']===$log && $user['password']!==$pwd){
                return 'error_pwd';
            }
        }
    }
}
function is_connecte(){
    if(!isset($_SESSION['statut'])){
        header('location: ./index.php');
    }
}

function deconnexion(){
    unset($_SESSION['statut']);
    unset($_SESSION['login']);
    unset($_SESSION['nom']);
    unset($_SESSION['prenom']);
    unset($_SESSION['photo']);
   // session_destroy();
}
