<html>
<!-- head -->
<?php
include('head.php');
include('co_db.php');
 ?>

  <body>
    <?php include('bar_menu.php');  ?>


    <div class="content is-medium">
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
              <tr>
                <th>Service</th>
                <td><?php
                $NS = $_SESSION['service'];
                if ($niv == 2){
                  echo "N/A";
                }
                else{
                  switch ($NS) {
                    case '86883657':
                      $NS = "Informatique";
                      break;
                    case '44609807':
                      $NS = "Defense";
                      break;
                    case '91345364':
                      $NS = "Elimination";
                      break;
                    case '22195465':
                      $NS = "Enquete";
                      break;
                    case '78334802':
                      $NS = "Enquete interne";
                      break;
                    case '6350262':
                      $NS = "Action";
                      break;
                    case '1738411':
                      $NS = "Assistance";
                      break;
                    case '17410830':
                      $NS = "Contre-espionnage";
                      break;
                  }
                  if ($niv == 1) {
                    if ($sexe == "male"){
                      $NS = $NS." (Directeur)";
                    }
                    else if ($sexe == "female"){
                      $NS = $NS." (Directrice)";
                    }
                  }
                  echo "$NS";
                }
                ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </article>
</div>
<?php
// Missions inactives
$requete_count_missions_i = "SELECT nom_de_code, count(*) as nb_mission
from participe, mission
where participe.nom_mission = mission.nom_mission
and mission.etat_mission = 'fini'
and participe.nom_de_code like '".$username."'
group by nom_de_code
order by nb_mission desc;";

$exec_requete_count_mission_i = mysqli_query($db, $requete_count_missions_i);
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
<div id="mission-active" class="content is-medium">
  <h1 class="title is-4">
    Missions :
  </h1>
  <p>
    <?php
    if (empty($nb_mission_i)){
      print "Mission terminée : 0";
    }
    else {
      print "Missions terminée : $nb_mission_i";
    }
    echo "<br>";
    if (empty($nb_mission_a)){
      print "Mission active : 0";
    }
    else {
      print "Missions actives : $nb_mission_a";
    }
    ?>
  </p>
  </div>
</body>
</html>
