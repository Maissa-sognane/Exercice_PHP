        <!doctype html>
<html lang= "fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Exercice2</title>
</head>
<style>
    body{
        background-color: #D6FFCB;
    }
    table, td, th {
        border: 1px solid #ddd;
        text-align: left;
    }

    table {
        border-collapse: collapse;
        width: 40%;
        text-align: center;
        margin-left: 30%;
        margin-top: 6%;
        background-color: rgba(217,103,225,0.52);
    }
    h1{
        text-align: center;
    }

    th, td {
        padding: 10px;
    }
    tr:nth-child(even) {background-color: #f2f2f2;}
</style>
<body>
    <h1>Exercice 2</h1>
<div style="text-align: center">
    <form action="#" method="post">
        <h1>Choisir une langue</h1>
        <select name="langue" style="width: 20%; height: 40px">
            <option>Langues</option>
            <option>Francais</option>
            <option>Anglais</option>
        </select>
        <button style="margin-top: 0%;margin-left: 2%; width: 10%; height: 40px">Choisir</button>
    </form>

<?php
if(isset($_POST['langue'])){
    if(!(empty($_POST['langue']))){
        $langues = $_POST['langue'];
        $calendrier = [
                'French' => [1=>'Janvier','Février', 'Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre'],
                'Anglais' => [1=>'January', 'February', 'May', 'April','May','June', 'July', 'August','September','October', 'November', 'December']
        ];
        if($langues == 'Francais'){

            foreach ($calendrier as $key=>$valeurs){
                echo "";
                echo "<table>";
                foreach ($valeurs as $nombre=>$val){
                    if($key == 'French'){
                        if($nombre==1) {
                            echo "<td>$nombre<td>$val</td></td>";
                        }
                        elseif ($nombre==2){
                            echo "<td>$nombre<td>$val</td></td>";
                        }
                        elseif ($nombre==3){
                            echo "<td>$nombre<td>$val</td></td>";
                        }
                        elseif ($nombre==4){
                            echo "<tr><td>$nombre<td>$val</td></td>";
                        }
                        elseif($nombre==5){
                            echo "<td>$nombre<td>$val</td></td>";
                        }
                        elseif ($nombre==6){
                            echo "<td>$nombre<td>$val</td></td></tr>";
                        }
                        elseif ($nombre==7){
                            echo "<tr><td>$nombre<td>$val</td></td>";
                        }
                        elseif ($nombre == 8){
                            echo "<td>$nombre<td>$val</td></td>";
                        }
                        elseif ($nombre == 9){
                            echo "<td>$nombre<td>$val</td></td></tr>";
                        }
                        elseif ($nombre == 10){
                            echo "<tr><td>$nombre<td>$val</td></td>";
                        }
                        elseif ($nombre == 11){
                            echo "<td>$nombre<td>$val</td></td>";
                        }
                        else{
                            echo "<td>$nombre<td>$val</td></td></tr>";
                        }
                    }
                }
                echo "</table>";
            }
        }
        if($langues == 'Anglais'){
            foreach ($calendrier as $key=>$valeurs){
                echo "<table>";
                foreach ($valeurs as $nombre=>$val){
                    if($key == 'Anglais'){
                        if($nombre==1) {
                            echo "<td>$nombre<td>$val</td></td>";
                        }
                        elseif ($nombre==2){
                            echo "<td>$nombre<td>$val</td></td>";
                        }
                        elseif ($nombre==3){
                            echo "<td>$nombre<td>$val</td></td>";
                        }
                        elseif ($nombre==4){
                            echo "<tr><td>$nombre<td>$val</td></td>";
                        }
                        elseif($nombre==5){
                            echo "<td>$nombre<td>$val</td></td>";
                        }
                        elseif ($nombre==6){
                            echo "<td>$nombre<td>$val</td></td></tr>";
                        }
                        elseif ($nombre==7){
                            echo "<tr><td>$nombre<td>$val</td></td>";
                        }
                        elseif ($nombre == 8){
                            echo "<td>$nombre<td>$val</td></td>";
                        }
                        elseif ($nombre == 9){
                            echo "<td>$nombre<td>$val</td></td></tr>";
                        }
                        elseif ($nombre == 10){
                            echo "<tr><td>$nombre<td>$val</td></td>";
                        }
                        elseif ($nombre == 11){
                            echo "<td>$nombre<td>$val</td></td>";
                        }
                        else{
                            echo "<td>$nombre<td>$val</td></td></tr>";
                        }
                    }
                }
                echo "</table>";
            }
        }
    }
     }



?>
</div>
</body>
</html>