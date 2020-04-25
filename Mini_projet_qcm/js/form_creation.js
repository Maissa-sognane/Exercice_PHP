var nbInput = 0; //On utilise une variable globale pour éviter d'avoir des inputs avec le même nom...

function ajouterChamps(){
    var nbChampsAjout = document.getElementById('number_reponse').value;
    var DivToAdd = document.getElementById('conteneur');
    if(nbChampsAjout <= 0){alert('Veuillez indiquer le nombre de champs à ajouter');}
    else{
        tempInput = "";
        for(let i = 1 ; i <= nbChampsAjout; i++){
            nbInput++;
            tempInput+= '<input required type="text" id="reponse'+i+'"  name="reponse'+i+'" placeholder="reponse'+i+'" class="inpt_js"/>' +
                '<input  type="checkbox" id="c'+i+'"  name="c'+i+'" id="check_js" />  <a  onclick="Supprimer_element();" id="boutton_supprimer'+i+'"><img  src="../Images/Icônes/ic-supprimer.png"/></a>' +
                '<br />';
        }
        DivToAdd.innerHTML = tempInput;
    }
}
function Ajouter_champs_radio(){
        var nbChampsAjout = document.getElementById('number_reponse').value;
        var DivToAdd = document.getElementById('conteneur');
        if(nbChampsAjout <= 0){alert('Veuillez indiquer le nombre de champs à ajouter');}
        else{
            tempInput = "";
            for(let i = 1 ; i <= nbChampsAjout; i++){
                nbInput++;
                tempInput+= '<input required type="text" id="reponse'+i+'" name="reponse'+i+'" placeholder="reponse'+i+'" class="inpt_js"/>' +
                    '<input  type="radio" id="c'+i+'" name="c'+i+'" id="check_js" />  <a  onclick="Supprimer_element();" id="boutton_supprimer'+i+'" ><img src="../Images/Icônes/ic-supprimer.png"/></a>' +
                    '<br />';
            }
            DivToAdd.innerHTML = tempInput;
        }
}
function type_questions(){
    var type_question = document.getElementById('type_question');
    var type_reponse = document.getElementById('ajout_type_reponse');
    var titre = document.getElementById("titre");
    var select_type = type_question[type_question.selectedIndex].value;
    if(select_type === 'choix_texte'){
        titre.innerHTML = '<h4 style="margin-left: -85%;">Reponse</h4><textarea id="reponse_texte" name="reponse_texte" style="margin-top: -5%; margin-left: 22%;"></textarea>';
        titre.body.appendChild(titre);
    }
    else{
        if(select_type === 'choix_simple'){
            titre.innerHTML = '<label class="title_number_response"><span style="margin-left: 3%">NBRE<br>REPONSE</span></label>\n' +
                '        <input type="number" required class="number_reponse" name="nombre_reponse" placeholder="Ex:3" id="number_reponse">\n' +
                '        <input type="button" class="ajouter_nbre_reponse" value="Ajouter" name="ajoutchamp" onclick="Ajouter_champs_radio();"><br>';
            titre.body.appendChild(titre);
        }
        else{
            titre.innerHTML = '<label class="title_number_response"><span style="margin-left: 3%">NBRE<br>REPONSE</span></label>\n' +
                '        <input type="number" required class="number_reponse" name="number_reponse" placeholder="Ex:3" id="number_reponse">\n' +
                '        <input type="button" class="ajouter_nbre_reponse" value="Ajouter" name="ajoutchamp" onclick="ajouterChamps()"><br>';
            if(typeof titre !== 'undefined') {
                titre.body.appendChild(titre);
            }
        }
    }
}
function Supprimer_element(){
    let nbChampsAjout = document.getElementById('number_reponse').value;
    for (let i = 1 ; i <= nbChampsAjout; i++){
        let log = document.getElementById("boutton_supprimer"+i);
        log.addEventListener('click', function (){
            let btn_check = document.getElementById("c"+i);
            let input = document.getElementById("reponse"+i);
            input.remove();
             log.remove();
            btn_check.remove();
        });
    }
}



