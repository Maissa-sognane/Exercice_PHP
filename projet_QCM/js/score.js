let togg1 = document.getElementById("togg1");
let togg2 = document.getElementById("togg2");
let togg3 = document.getElementById("togg3");
let togg4 = document.getElementById("togg4");
let d1 = document.getElementById("d1");
let d2 = document.getElementById("d2");
let d3 = document.getElementById("d3");
let d4 = document.getElementById("d4");
togg1.addEventListener("click", () => {
        d1.style.display = "block";
        d2.style.display = "none";
        d3.style.display = "none";
        d4.style.display = "none";
})

function togg(){
        d2.style.display = "block";
        d1.style.display = "none";
        d3.style.display = "none";
        d4.style.display = "none";
};
togg2.onclick = togg;

function togg_3(){
    d3.style.display = "block";
    d1.style.display = "none";
    d2.style.display = "none";
    d4.style.display = "none";
};
togg3.onclick = togg_3;

function togg_4(){
    d3.style.display = "none";
    d1.style.display = "none";
    d2.style.display = "none";
    d4.style.display = "block";
};
togg4.onclick = togg_4;


var loadFile = function (event) {
    var output = document.getElementById("output");
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function () {
        URL.revokeObjectURL(output.src);
    }
};

function getFile(){
    document.getElementById("upfile").click();
}
function sub(obj){
    var file = obj.value;
    var fileName = file.split("\'   ");
    document.getElementById("yourBtn").innerHTML = fileName[fileName.length-1];
    document.myForm.submit();
    event.preventDefault();
}

var nbInput = 0; //On utilise une variable globale pour éviter d'avoir des inputs avec le même nom...

var nbInput = 0; //On utilise une variable globale pour éviter d'avoir des inputs avec le même nom...

function ajouterChamps(){
    var nbChampsAjout = document.getElementById('number_reponse').value;
    var DivToAdd = document.getElementById('conteneur');
    if(nbChampsAjout <= 0){alert('Veuillez indiquer le nombre de champs à ajouter');}
    else{
        tempInput = "";
        for(let i = 1 ; i <= nbChampsAjout; i++){
            nbInput++;
            tempInput+= '<input error="error-'+i+'"  type="text" id="reponse'+i+'"  name="reponse'+i+'" placeholder="reponse'+i+'" class="inpt_js"/>' +
                '<input  type="checkbox" id="c'+i+'"  name="c'+i+'" id="check_js" />  <a  onclick="Supprimer_element();" id="boutton_supprimer'+i+'"><img  src="./Images/Icônes/ic-supprimer.png"/></a>' +
                '<span class="error_ipt" id="error-'+i+'"></span><br />';
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
            tempInput+= '<input error="error-5" type="text" id="reponse'+i+'" name="reponse'+i+'" placeholder="reponse'+i+'" class="inpt_js"/>' +
                '<input  type="radio" id="c'+i+'" name="c'+i+'" id="check_js" />  <a  onclick="Supprimer_element();" id="boutton_supprimer'+i+'" ><img src="../Images/Icônes/ic-supprimer.png"/></a>' +
                '<span class="erro_nbre_reponser" id="error-5"></span><br />';
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
        titre.innerHTML = '<h4 style="margin-left: -85%;">Reponse</h4><textarea error="error-700" id="reponse_texte" name="reponse_texte" style="margin-top: -5%; margin-left: 22%;"></textarea>' +
            '<span class="error_ipt" id="error-700"></span>';
        titre.body.appendChild(titre);
    }
    else{
        if(select_type === 'choix_simple'){
            titre.innerHTML = '<label class="title_number_response"><span style="margin-left: 3%">NBRE<br>REPONSE</span></label>\n' +
                '        <input error="error-600" type="number"  class="number_reponse" name="nombre_reponse" placeholder="Ex:3" id="number_reponse">\n' +
                '        <input type="button" class="ajouter_nbre_reponse" value="Ajouter" name="ajoutchamp" onclick="Ajouter_champs_radio();">' +
                '<span class="erro_nbre_reponser" id="error-600"></span><br>';
            titre.body.appendChild(titre);
        }
        else{
            titre.innerHTML = '<label class="title_number_response"><span style="margin-left: 3%">NBRE<br>REPONSE</span></label>\n' +
                '        <input type="number" error="error-7" class="number_reponse" name="number_reponse" placeholder="Ex:3" id="number_reponse">\n' +
                '        <input type="button" class="ajouter_nbre_reponse" value="Ajouter" name="ajoutchamp" onclick="ajouterChamps()">' +
                '        <span class="erro_nbre_reponser" id="error-7"></span><br>';
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
const inputs = document.getElementsByTagName('input');
for (input of inputs){
    input.addEventListener("keyup", function (e){
        if(e.target.hasAttribute("error")){
            var idDivErrors = e.target.getAttribute("error");
            document.getElementById(idDivErrors).innerText=""
        }
    })
}
document.getElementById("form-connexion").addEventListener("submit", function (e){
    const inputs = document.getElementsByTagName('input');
    const champ_text = document.getElementsByTagName('textarea');
    var error = false;
    for (input of inputs){
        if(input.hasAttribute("error")){
            var idDivError = input.getAttribute("error");
            if(!input.value) {
                document.getElementById(idDivError).innerText="Ce Champ est obligatoire";
                error = true;
            }
        }
    }
    for (text of champ_text){
        if(text.hasAttribute("error")){
            var idDivErrors = text.getAttribute("error");
            if(!text.value){
                document.getElementById(idDivErrors).innerText = "Ce Champ est obligatoire";
                error = true;
            }
        }
    }

    if (error){
        e.preventDefault();
        return false;
    }

});












