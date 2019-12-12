<html>
<!-- head -->
<?php
include('head.php');
include('co_db.php');
 ?>

  <body>
    <?php include('bar_menu.php');  ?>
      <div class="content is-medium">
        <p>
          <?php
          $NS = $_SESSION['service'];
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
          echo "Les missions gérées par le service $NS : <br>";
           ?>
        </p>
      </div>

      <div class="content is-medium">
        <?php
          $tmp_nom = "";
          $tmp_pays_nom="";
          $pays_noms = "";
          $id_NS = $_SESSION['service'];

          $requete_ma = "SELECT gere.nom_mission, mission.etat_mission
          from gere, mission
          where gere.nom_service = ".$id_NS." AND mission.nom_mission = gere.nom_mission";
          $exec_ma = mysqli_query($db,$requete_ma);

          while($data = mysqli_fetch_array($exec_ma)){
            $pays_noms = "";
            if($data['nom_mission'] != $tmp_nom){
              $requete_npm = "SELECT nom_pays FROM localise where nom_mission like '".$data['nom_mission']."'";
              $exec_npm = mysqli_query($db,$requete_npm);
              while($data_npm = mysqli_fetch_array($exec_npm)){
                $pays_noms = $pays_noms.$data_npm["nom_pays"]." ";
              }
              echo "  <div class=\"box\" style=\"margin-bottom : 2%;\"><div class=\"is-little\" style=\"margin-bottom : 2%;\">";
              echo "  <p>Nom mission : ".$data['nom_mission']." <br> localisation : ".$pays_noms."<br> Etat : ".$data['etat_mission']."<br></p>";
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
          mysqli_close($db);
          ?>
      </div>
  </body>
</html>
