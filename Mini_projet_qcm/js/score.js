let togg1 = document.getElementById("togg1");
let togg2 = document.getElementById("togg2");
let d1 = document.getElementById("d1");
let d2 = document.getElementById("d2");
togg1.addEventListener("click", () => {
        d1.style.display = "block";
        d2.style.display = "none";
})

function togg(){
        d2.style.display = "block";
        d1.style.display = "none";
};
togg2.onclick = togg;



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