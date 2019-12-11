<html>
<!-- head -->
<?php
include('head.php');
include('co_db.php');
 ?>
<body>
  <?php include('bar_menu.php');  ?>

  <div class="container">
    <div class="content is-medium">
      <h2>
        Missions actives :
      </h2>
    </div>
    <?php
      $tmp_nom = "";
      $pays_noms = "";
      $username = $_SESSION['username'];
      $requete_ma = "SELECT distinct P.nom_mission, L.nom_pays
                      from participe P, localise L, mission
                      where P.nom_mission = L.nom_mission and mission.nom_mission = P.nom_mission
                      and P.nom_de_code like '".$username."'
                      and mission.etat_mission = 'en cours'";
      $exec_ma = mysqli_query($db,$requete_ma);

      while($data = mysqli_fetch_array($exec_ma)){
        $pays_noms = $pays_noms.$data["nom_pays"]." ";
        if($data['nom_mission'] != $tmp_nom){
          echo "  <div class=\"container box\" style=\"margin-bottom : 2%\"><div class=\"content is-little\">";
          echo "  <p>Nom mission : ".$data['nom_mission']." <br> localisation : ".$pays_noms."<br> </p>";
          echo "</div> ";
          $tmp_nom =  $data['nom_mission'];

          $requete_adm = "SELECT nom_de_code FROM participe WHERE nom_mission like '".$data['nom_mission']."' ";
          $exec_adm = mysqli_query($db, $requete_adm);
          echo "<table class=\"table is-fullwidth is-bordered is-hoverable\"><tbody>";
          while($item = mysqli_fetch_array($exec_adm)){
            echo "<tr>";
            echo "<td>".$item['nom_de_code']."</td>" ;
            echo "</tr>";
          }
          echo " </tbody> </table>";

        }
        echo "</div>";
      }
      ?>

  </div>

  <div class="container">
    <div class="content is-medium">
      <h2>
        Missions terminées :
      </h2>
    </div>
    <?php
      $tmp_nom = "";
      $pays_noms = "";
      $username = $_SESSION['username'];
      $requete_ma = "SELECT distinct P.nom_mission, L.nom_pays
                      from participe P, localise L, mission
                      where P.nom_mission = L.nom_mission and mission.nom_mission = P.nom_mission
                      and P.nom_de_code like '".$username."'
                      and mission.etat_mission = 'fini'";
      $exec_ma = mysqli_query($db,$requete_ma);

      while($data = mysqli_fetch_array($exec_ma)){
        $pays_noms = $pays_noms.$data["nom_pays"]." ";
        if($data['nom_mission'] != $tmp_nom){
          echo "  <div class=\"container box\" style=\"margin-bottom : 2%\"><div class=\"content is-little\">";
          echo "  <p>Nom mission : ".$data['nom_mission']." <br> localisation : ".$pays_noms."<br> </p>";
          echo "</div> ";
          $tmp_nom =  $data['nom_mission'];

          $requete_adm = "SELECT nom_de_code FROM participe WHERE nom_mission like '".$data['nom_mission']."' ";
          $exec_adm = mysqli_query($db, $requete_adm);
          echo "<table class=\"table is-fullwidth is-bordered is-hoverable\"><tbody>";
          while($item = mysqli_fetch_array($exec_adm)){
            echo "<tr>";
            echo "<td>".$item['nom_de_code']."</td>" ;
            echo "</tr>";
          }
          echo " </tbody> </table>";

        }
        echo "</div>";
      }
      mysqli_close($db); // fermer la connexion
      ?>
  </div>
</body>
</html>
