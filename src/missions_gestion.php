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
    </div>

    <div class="container">
      <div class="content is-medium">
        <?php
          $tmp_nom = "";
          $tmp_pays_nom="";
          $pays_noms = "";
          $id_NS = $_SESSION['service'];

          $requete_ma = "SELECT gere.nom_mission, nom_de_code, nom_pays
          from gere, participe, localise
          where gere.nom_mission = participe.nom_mission
          and participe.nom_mission = localise.nom_mission
          and gere.nom_service = ".$id_NS."
          order by nom_mission";
          $exec_ma = mysqli_query($db,$requete_ma);

          while($data = mysqli_fetch_array($exec_ma)){
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
    </div>
  </body>
</html>
