<style>
    .graphe{
       margin: auto;
       margin-top: 3%;
    }
    h3{
        text-align: center;
        color: #2acaff;
    }
    .carte_ad_jou{
        display: flex;
        justify-content: space-around;
        margin-top: 2%;
    }
    .admin, .joueur{
        border: 1px solid rgba(173,173,173,0.84);
        background-color: rgba(173,173,173,0.84);
        height: 100px;
        width: 47%;
    }
    i{
        font-size: 57px;
        margin-top: 6%;
        color: rgba(255, 99, 132, 1);
    }
    .nbre_admin{
        float: right;
        margin-top: 20%;
        font-size: 22px;
    }
    .btn_graphes{
        display: flex;
        justify-content: space-around;
    }
    #id_joueur_frequent,#id_graphique_utilisateur,#id_meilleur_score
    {
        width: 20%;
        height: 60px;
        font-size: 17px;
        border: 0px solid white;
        color: #2acaff;
        background-color: white;
    }
    #id_graphique_utilisateur:hover{
        background-color: #3ADDD6;
        color: white;
    }
    #id_graphique_utilisateur:focus{
        background-color: #3ADDD6;
        color: white;
    }
    #id_meilleur_score:hover{
        background-color: #3ADDD6;
        color: white;
    }
    #id_meilleur_score:focus{
        background-color: #3ADDD6;
        color: white;
    }
    #id_joueur_frequent:hover{
        background-color: #3ADDD6;
        color: white;
    }
    #id_joueur_frequent:focus{
        background-color: #3ADDD6;
        color: white;
    }
    #graphe_joueur_frequent{
        margin: auto;
    }
    #graphe_joueur_frequent h3{
        text-align: center;
    }
    #graphe_meilleur_score{
        margin: auto;
    }
</style>
<body>
<div>
    <?php $users = get_data();
    $nbrjoueur = 0;
    $nbradmin = 0;
    foreach ($users as $key=>$user){
        if($user['profit'] == 'joueur'){
            $nbrjoueur++;
        }
        if($user['profit'] == 'admin'){
            $nbradmin++;
        }
    }
    $tab_joueur = file_get_contents('./data/meilleur_joueur.json');
    $tab_joueur = json_decode($tab_joueur, true);
    $tail = file_get_contents('./data/nbre_question.json');
    $tail = json_decode($tail, true);
    $nbr=0;
    $tableau_joueur = [];
    $i=0;
    for ($j=0;$j<$tail[1];$j++){
        if(isset($tab_joueur[$j])){
            $tableau_joueur[] = $tab_joueur[$j];
        }
        $i++;
    }
   //var_dump($tab_joueur);
    $joueur_frequent = [];
    for ($i=0; $i<count($users);$i++){
            if ($users[$i]['profit'] === 'joueur'){
                $joueur_frequent[$users[$i]['login']] = count($users[$i]['score']);
            }
    }
   //var_dump($joueur_frequent);
   array_multisort($joueur_frequent, SORT_DESC);
  // echo '<br><br>';
    //var_dump($joueur_frequent);

    $joueurs_tableau = array();


    foreach ($joueur_frequent as $key=>$joueur){
        $joueurs_tableau['login'][] = $key;
        $joueurs_tableau['score'][]= $joueur;
    }
    //var_dump($joueurs_tableau['login'][0]);
    //var_dump($joueurs_tableau['score'][0]);

    ?>
   <div class="btn_graphes">
       <input  type="button" id="id_graphique_utilisateur" value="Utilisateurs">
       <input  type="button" id="id_meilleur_score" value="Meilleur Scores">
       <input  type="button" id="id_joueur_frequent" value="Joueurs Fréquent">
   </div>
</div>


<div id="graphe_utilisateur"  style="display: block">
    <div class="carte_ad_jou">
        <div class="admin">
            <i class="fas fa-user-cog"></i>
            <span class="nbre_admin">Admins:  <?php echo $nbradmin; ?></span>
        </div>
        <div class="joueur">
            <i class="fas fa-user" style="color: rgba(99,182,255,0.6)"></i>
            <span class="nbre_admin">Joueurs:  <?php echo $nbrjoueur; ?></span>
        </div>
    </div>

   <div class="graphe">
       <h3>Nombre de Joueurs et Admins</h3>
       <canvas id="myChart" width="100" height="100"></canvas>
   </div>
</div>
<div id="graphe_joueur_frequent" style="display: none">
    <h3>Les 5 meilleurs Joueurs </h3>
    <canvas id="Chart" width="400" height="400"></canvas>
</div>
<div id="graphe_meilleur_score" style="display: none">
    <h3>Les 10 joueurs les plus frequents</h3>
    <canvas id="LineChart" width="400" height="400"></canvas>
</div>

</body>

<script>
   var btnuser = document.getElementById('id_graphique_utilisateur');
   var btnscore = document.getElementById('id_meilleur_score');
   var btnjoeuur = document.getElementById('id_joueur_frequent');

   var graphuser = document.getElementById('graphe_utilisateur');
   var graphscore = document.getElementById('graphe_meilleur_score');
   var graphjoueur = document.getElementById('graphe_joueur_frequent');

   btnuser.addEventListener('click', function (e) {
        graphuser.style.display = "block";
        graphjoueur.style.display = "none";
        graphscore.style.display = "none";
   });
   btnscore.addEventListener('click', function (e) {
       graphuser.style.display = "none";
       graphjoueur.style.display = "block";
       graphscore.style.display = "none";

   });
   btnjoeuur.addEventListener('click', function (e) {
       graphuser.style.display = "none";
       graphjoueur.style.display = "none";
       graphscore.style.display = "block";

   });
    var tab =  JSON.parse('<?php echo json_encode($tab_joueur);?>');


    var joueur = <?php echo  json_encode( $nbrjoueur); ?>;
    var admin = <?php echo json_encode($nbradmin) ; ?>;


   var ctx = document.getElementById('myChart').getContext('2d');
   var myChart = new Chart(ctx, {
       type: 'pie',
       data: {
           labels: ['Admins', 'Joueurs'],
           datasets: [{
               label: '# of Votes',
               data: [admin, joueur],
               backgroundColor: [
                   'rgba(255, 99, 132, 1)',
                   'rgba(99,182,255,0.6)',
               ],
               borderColor: [
                   'rgba(255, 99, 102, 1)',
                   'rgba(99,182,255,0.6)',
               ],
               borderWidth: 1
           }]
       },
       options: {

       }
   });
   myChart.canvas.parentNode.style.height = '350px';
   myChart.canvas.parentNode.style.width = '350px';
    console.log(tab);
   var ctx_score_joueur = document.getElementById('Chart').getContext('2d');
   var Chartbar = new Chart(ctx_score_joueur, {
       type: 'horizontalBar',
       data: {
           labels: [tab[0]['prenom']+' '+tab[0]['nom'], tab[1]['prenom']+' '+tab[1]['nom'],
               tab[2]['prenom']+' '+tab[2]['nom'], tab[3]['prenom']+' '+tab[3]['nom'],
               tab[4]['prenom']+' '+tab[4]['nom']],
           datasets: [{
               label: 'Les 5 meilleurs joueurs',
               data: [tab[0]['meileur_score'], tab[1]['meileur_score'],
                   tab[2]['meileur_score'], tab[3]['meileur_score'],
                   tab[4]['meileur_score']],
               backgroundColor: [
                   'rgba(255, 99, 132, 0.2)',
                   'rgba(54, 162, 235, 0.2)',
                   'rgba(255, 206, 86, 0.2)',
                   'rgba(75, 192, 192, 0.2)',
                   'rgba(153, 102, 255, 0.2)',
                   'rgba(255, 159, 64, 0.2)'
               ],
               borderColor: [
                   'rgba(255, 99, 132, 1)',
                   'rgba(54, 162, 235, 1)',
                   'rgba(255, 206, 86, 1)',
                   'rgba(75, 192, 192, 1)',
                   'rgba(153, 102, 255, 1)',
                   'rgba(255, 159, 64, 1)'
               ],
               borderWidth: 1
           }]
       },
       options: {
           scales: {
               yAxes: [{
                   ticks: {
                       beginAtZero: true
                   }
               }]
           }
       }
   });
   Chartbar.canvas.parentNode.style.height = '450px';
   Chartbar.canvas.parentNode.style.width = '450px';

  var tableau_joueurs = JSON.parse('<?php echo json_encode($joueurs_tableau); ?>');

  var ctx_frequent = document.getElementById('LineChart').getContext('2d');
  var data = {
      labels: [tableau_joueurs['login'][0], tableau_joueurs['login'][1], tableau_joueurs['login'][2],
          tableau_joueurs['login'][3],tableau_joueurs['login'][4], tableau_joueurs['login'][5],
          tableau_joueurs['login'][6],tableau_joueurs['login'][7],tableau_joueurs['login'][8],
          tableau_joueurs['login'][9]],
      datasets: [
          {   label: "Nombre de parties jouer",
              data: [tableau_joueurs['score'][0],tableau_joueurs['score'][1],tableau_joueurs['score'][2],
                  tableau_joueurs['score'][3],tableau_joueurs['score'][4],tableau_joueurs['score'][5],
                  tableau_joueurs['score'][6],tableau_joueurs['score'][7],tableau_joueurs['score'][8],
                  tableau_joueurs['score'][9]],
              borderColor:'rgba(255, 99, 132)',
              fill: false
             // backgroundColor: 'rgba(0, 0, 0, 0.1)',
          }
      ],

  };
  var options = {

  };
  var LineChart = new Chart(ctx_frequent, {
      type: 'line',
      data: data,
      options: options
  });
  LineChart.canvas.parentNode.style.height = '450px';
  LineChart.canvas.parentNode.style.width = '450px';
</script>
