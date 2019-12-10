<html>
<head>
  <meta name="author" content="Théo Nardin & Alexandre De freitas">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IASA</title>
  <link rel="icon" href="Favicon.png">
  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">-->
  <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
  <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
  <link rel="stylesheet" href="../style/style.css">
  <link rel="stylesheet" href="../style/bulma.css">

  <?php
  // Vérfie qu'aucune déconnection n'a été demandée.
  include 'deconnexion.php';
  deco();

  // Récupère le niveau d'accès de la personne
  $niv = $_SESSION['lvl_acc'];
  $prenom = $_SESSION['prenom'];
  $nom = $_SESSION['nom'];
  $age = $_SESSION['age'];
  $sexe = $_SESSION['sexe'];
  $pays = $_SESSION['pays'];
  ?>
</head>

  <body>
    <div class="high-bar">
    <ul>
      <img src="Favicon.png">
      <li ><a class="deco-button" href="principale.php?deconnexion=true"><i class="fas fa-power-off"></i> Déconnexion</a></li>
    </ul>
    </div>

    <div class="general-menu">
      <ul>
        <li><a href="principale.php">Espace personnel</a></li>
        <li><a href="mission.php">Missions</a></li>
        <li><a href="pays_ranking.php">Classement des pays</a></li>
        <?php
        if ($niv >= 1){
          print "<li><a href=\".php\" >Agents en Mission</a></li>" ;
          print "<li><a href=\".php\" >Agents</a></li>" ;
          if ($niv == 2){
            print "<li><a href=\".php\" >Chefs des services</a></li>" ;
            print "<li><a href=\".php\" >RH agence</a></li>" ;
          }
        }
        ?>
      </ul>
    </div>

    <div class="container is-medium">
      <p class="title is-4">
        <?php
        $username = $_SESSION['username'];
        echo "Bienvenue $username sur votre espace personnel : \n";
        ?>
      </p>
    </div>

    <div class="box info">
      <article class="media">
        <div class="media-left">
          <figure class="image is-128x128">
            <?php
            if ($sexe == "male"){
              print "<img src=\"../img/men_PP.jpg\">";
            }
            else if ($sexe == "female"){
              print "<img src=\"../img/women_PP.jpg\">";
            }
             ?>
          </figure>
        </div>
        <div>
          <table class="table is-fullwidth is-bordered">
            <tbody>
              <tr>
                <th>Nom</th>
                <td><?php print "$nom" ?></td>
              </tr>
                <th>Prénom</th>
                <td><?php print "$prenom" ?></td>
              </tr>
              <tr>
                <th>Age</th>
                <td><?php print "$age" ?></td>
              </tr>
              <tr>
                <th>Sexe</th>
                <td><?php print "$sexe" ?></td>
              </tr>
              <tr>
                <th>Pays</th>
                <td><?php print "$pays" ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </article>
</div>
<?php
// connexion à la base de données
$db_username = 'agent';
$db_password = 'IDagnIASA_';
$db_name     = 'iasa';
$db_host     = 'localhost';
$db = mysqli_connect($db_host, $db_username, $db_password,$db_name)
       or die('could not connect to database');

// Missions inactives
$requete_count_missions_i = "SELECT nom_de_code, count(*) as nb_mission
from participe, mission
where participe.nom_mission = mission.nom_mission
and mission.etat_mission = 'fini'
and participe.nom_de_code like '".$username."'
group by nom_de_code
order by nb_mission desc;";

$exec_requete_count_mission_i = mysqli_query($db,$requete_count_missions_i);
$reponse_count_mission_i      = mysqli_fetch_array($exec_requete_count_mission_i);
$nb_mission_i = $reponse_count_mission_i['nb_mission'];

// Missions actives
$requete_count_missions_a = "SELECT nom_de_code, count(*) as nb_mission_a
from participe, mission
where participe.nom_mission = mission.nom_mission
and mission.etat_mission = 'en cours'
and participe.nom_de_code like '".$username."'
group by nom_de_code
order by nb_mission_a desc;";

$exec_requete_count_mission_a = mysqli_query($db,$requete_count_missions_a);
$reponse_count_mission_a      = mysqli_fetch_array($exec_requete_count_mission_a);
$nb_mission_a = $reponse_count_mission_a['nb_mission_a'];

mysqli_close($db); // fermer la connexion
 ?>
<div id="mission-active" class="container is-medium">
  <h1 class="title is-4">
    Missions :
  </h1>
  <p>
    <?php
    print "Mission inactive : $nb_mission_i <br>";
    if (empty($nb_mission_a)){
      print "Mission active : 0";
    }
    else {
      print "Mission active : $nb_mission_a";
    }
    ?>
  </p>

</div>


  </body>
</html>
