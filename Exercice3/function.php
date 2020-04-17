<?php
// Fonction Miniscule
function is_lower($caractere){
    if($caractere>='a' && $caractere<='z'){
        return true;
    }
    else{
       return false;
    }
}
// Fonction majuscule
function is_uper($caractere){
    if($caractere>='A' && $caractere<='Z'){
       return true;
    }
    else{
       return false;
    }
}

// taille Tableau ou chaine caractere
function my_sterlen($caractere){
    $nbr = 0;
    $i = 0;
    while (isset($caractere[$i])){
        $nbr++;
        $i++;
    }
    return $nbr;
}


//is_numeric
function is_numb($caractere){
    $temoin = "";
    for($i=0;$i<my_sterlen($caractere); $i++){
        if($caractere[$i]>='0' && $caractere[$i]<='9'){
            $temoin = true;
        }
        else{
            $temoin=false;
        }
    }
    if($temoin == true){
       return true;
    }
    else{
        return false;
    }

}


// Fonction Entier positif
function is_entier($caractere){
    $temoin = "";
    for($i=0;$i<my_sterlen($caractere);$i++){
        if(is_numb($caractere[$i]) == true){
           $temoin = 1;
        }
        else{
            $temoin = 2;
        }
    }
    if($temoin==1){
        if ($caractere>=0){
            return true;
        }
        else{
            return false;
        }
    }
    elseif($temoin==2){
        return false;
    }
}

function delete_space($caractere){
    for ($i=0;$i<my_sterlen($caractere); $i++){
        if($caractere[$i] ==" "){
            $caractere[$i] = "";
        }
    }
     return $caractere;
}
//Mot valide
function is_valid($caractere){
    $temoin = '';
    $caracteres = delete_space($caractere);
    for ($i=0; $i<my_sterlen($caracteres); $i++){
            if ((is_lower($caracteres[$i]) || is_uper($caracteres[$i]))){
               return true;
            } else {
                return false;
                break;
            }
        }
}

//Verifie si un caractere est dans une chaine de caractere

function is_car_in_string($car, $chain_caractere){
    $temoin='';
    if(is_valid($chain_caractere) == true){
        for ($i=0; $i<my_sterlen($chain_caractere); $i++){
            if($chain_caractere[$i] == $car){
                $temoin =  true;
            }
        }
        if($temoin == true){
            return true;
        }
        else{
            return false;
        }
    }
    else{
        return false;
    }
}

// fonction qui supprime les espaces fin et debut
function my_trim ($caractere){
    $car = $caractere;
        for($i=0; $i<my_sterlen($caractere); $i++){
            if(isset($caractere[$i+1])){
                if($caractere[$i] == " " && $caractere[$i+1] == " "){
                    $car[$i] = "";
                    $car[$i+1] = "";
                }
            }
        }
        if($car != $caractere){
            return true;
        }
        else{
            return false;
        }
}

//Fonction retourne une chaine inversant la case

function is_case($caractere){
    $car = $caractere;
    for ($i=0; $i<my_sterlen($caractere); $i++){
        if (is_uper($caractere[$i]) == true){
            $car[$i] = is_lower($caractere[$i]);
        }
    }
    return  $car;
}
