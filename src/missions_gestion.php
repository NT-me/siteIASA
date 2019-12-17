<html>
<!-- head -->
<?php
include('head.php');
include('co_db.php');
 ?>
 <script>
       /* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
       function openNav() {
         document.getElementById("mySidenav").style.width = "250px";
       }

       /* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
       function closeNav() {
         document.getElementById("mySidenav").style.width = "0";
       }
  </script>
  <body>
    <?php include('bar_menu.php');

    // Supprimer un agent d'une mission
    if(isset($_GET['del_a']) and isset($_GET['del_m']))
    {
      $del_a = $_GET['del_a'];
      $del_m = $_GET['del_m'];
       $requete_del_agent_to_mission = "DELETE FROM participe WHERE nom_de_code ='".$del_a."' AND nom_mission ='".$del_m."'";

      $exec_del_agent_to_mission = mysqli_query($db,  $requete_del_agent_to_mission);

      if (mysqli_query($db, $requete_del_agent_to_mission)) {
          echo "<div class=\"content notification is-success\">
                Agent supprimé avec succès
              </div>";
      } else {
        echo "<div class=\"content notification is-danger\">
              Une erreur est survenue : ".mysqli_error($db)."
            </div>";
      }
    }

    // Supprimer un agent d'une mission
    if(isset($_GET['change_etat']) and isset($_GET['change_m']))
    {
      $change_etat = $_GET['change_etat'];
      $change_m = $_GET['change_m'];

      if ($change_etat == "en cours"){
        $switch_m_etat = "fini";
      }
      else {
        $switch_m_etat = "en cours";
      }
       $requete_change_etat = "UPDATE `mission` SET `etat_mission` = '".$switch_m_etat."' WHERE `mission`.`nom_mission` = '".$change_m."'";

      $exec_change_etat = mysqli_query($db,  $requete_change_etat);

      if (mysqli_query($db, $requete_change_etat)) {
          echo "<div class=\"content notification is-success\">
                Etat modifié avec succès <br>
              </div>";
      } else {
        echo "<div class=\"content notification is-danger\">
              Une erreur est survenue : ".mysqli_error($db)."<br>
              ".$requete_change_etat."
            </div>";
      }
    }

    $NS = $_SESSION['service'];?>
    <div id="mySidenav" class="sidenav">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <h3 style="margin-left:2%">
        <?php echo "Ajout d'un agent du service ".ctn_service($NS)." dans une mission" ?> <br><br>
      </h3>

      <form method="post">
        <p class="container is-medium" style="float: left">
          Nom de code
        </p>
        <select name="add_ndc" style="float: left">
          <?php
          $id_NS = $_SESSION['service'];

          $requete_ads = "SELECT travail.nom_de_code, agent.niv_confiance FROM travail, agent WHERE travail.nom_service like '".$id_NS."' and travail.nom_de_code like agent.nom_de_code order by agent.niv_confiance";
          $exec_ads = mysqli_query($db, $requete_ads);
          while($item = mysqli_fetch_array($exec_ads)){
            echo "<option value=\"".$item["nom_de_code"]."\">".$item["nom_de_code"]."</option>";
        }
           ?>

        </select>
        <form method="post style="float: left"">
          <p class="container is-medium" style="float: left">
            Nom de la mission
          </p>
          <select name="add_mission">
            <?php
            $id_NS = $_SESSION['service'];

            $requete_mds = "SELECT gere.nom_mission, mission.etat_mission
            from gere, mission
            where gere.nom_service = ".$id_NS." AND mission.nom_mission = gere.nom_mission AND mission.etat_mission like 'en cours'";

            $exec_mds = mysqli_query($db, $requete_mds);


            while($item = mysqli_fetch_array($exec_mds)){
              echo "<option value=\"".$item["nom_mission"]."\">".$item["nom_mission"]."</option>";
          }
             ?>
          </select>
          <input type="submit" name="show_add_form" value="show"/>
        </form>
      </form>
   </div>
      <?php
      if (isset($_POST['show_add_form'])) {
        $add_ndc = $_POST['add_ndc'];
        $add_mission = $_POST['add_mission'];

        $requete_add_agent_to_mission = "INSERT INTO participe
        VALUES ('".$add_ndc."', '".$add_mission."')";

        if (mysqli_query($db, $requete_add_agent_to_mission)) {
            echo "<div class=\"content notification is-success\">
                  Agent ajouté avec succès
                </div>";
        } else {
          echo "<div class=\"content notification is-danger\">
                Une erreur est survenue : ".mysqli_error($db)."
              </div>";
        }
      }
      ?>
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

      <div class="container">
        <div class="requete-box">
            <form method="post">
              <p class="container is-medium" style="float: left">
                Rechercher les missions
              </p>
              <select name="etat" style="float: left">
                <option value=""></option>
                <option value="en cours">En cours</option>
                <option value="fini">Fini</option>

              </select>
                <p class="container is-medium" style="float: left">
                  en
                </p>
                <input style="float: left" type="text" placeholder="Entrer le nom d'un pays" name="nom_pays">
                <input type="submit" name="show_etat_service" value="show"/>
            </form>
          </div>
          <?php
          if (isset($_POST['show_etat_service'])) {
            $c_etat = $_POST['etat'];
            if (isset ($_POST['nom_pays'])){
              $c_nom_pays = $_POST['nom_pays'];
              }
          }
          ?>
      </div>

      <div class="content">
        <button style= " float:right " class= "button is-success is-light " onclick= "openNav() "><i class= "far fa-plus-square "></i> &nbsp Ajouter un agent à une mission</button>
      </div>

      <div class="content is-medium">
        <?php
          $tmp_nom = "";
          $tmp_pays_nom="";
          $pays_noms = "";
          $id_NS = $_SESSION['service'];

          if ( !isset($_POST['show_etat_service']) or $c_etat == ""){
            $requete_ma = "SELECT gere.nom_mission, mission.etat_mission
            from gere, mission
            where gere.nom_service = ".$id_NS." AND mission.nom_mission = gere.nom_mission";
          }
          elseif ($c_etat != "") {
            $requete_ma = "SELECT gere.nom_mission, mission.etat_mission
            from gere, mission
            where gere.nom_service = ".$id_NS." AND mission.nom_mission = gere.nom_mission AND mission.etat_mission like '".$c_etat."'";
          }
          else {
            $requete_ma = "SELECT gere.nom_mission, mission.etat_mission
            from gere, mission
            where gere.nom_service = ".$id_NS." AND mission.nom_mission = gere.nom_mission AND mission.etat_mission like '".$c_etat."'";
          }


          $exec_ma = mysqli_query($db,$requete_ma);

          while($data = mysqli_fetch_array($exec_ma)){
            $Pays_flag = 1;
            $pays_noms = "";
            if($data['nom_mission'] != $tmp_nom){
              $requete_npm = "SELECT nom_pays FROM localise where nom_mission like '".$data['nom_mission']."'";
              $exec_npm = mysqli_query($db,$requete_npm);

              while($data_npm = mysqli_fetch_array($exec_npm)){
                $pays_noms = $pays_noms.$data_npm["nom_pays"]." ";
              }

              if (isset ($_POST['nom_pays']) and !empty($_POST['nom_pays'])) {
                if(strpos($pays_noms, $_POST['nom_pays']) === false){
                  $Pays_flag = 0;
                }
              }
              if ($Pays_flag == 1){
                if ($data['etat_mission'] == "en cours"){
                  $switch_text = '<i class="fas fa-toggle-off"></i>Terminer';
                }
                else {
                  $switch_text = '<i class="fas fa-toggle-on"></i>Rouvrir';

                }
                echo "  <div class=\"box\" style=\"margin-bottom : 2%;\">
                <div class=\"is-little\" style=\"margin-bottom : 2%;\">";
                echo "  <p>Nom mission : ".$data['nom_mission']." <br>
                localisation : ".$pays_noms."<br>
                Etat : ".$data['etat_mission']."
                <a class=\"button is-little is-light\" href=\"missions_gestion.php?change_etat=".$data['etat_mission']."&change_m=".$data['nom_mission']."\"></i> &nbsp ".$switch_text."</a><br></p>";
                echo "</div> ";
                $tmp_nom =  $data['nom_mission'];

                $requete_adm = "SELECT nom_de_code FROM participe WHERE nom_mission like '".$data['nom_mission']."' ";
                $exec_adm = mysqli_query($db, $requete_adm);
                echo "<table class=\"table is-fullwidth is-bordered is-hoverable\"><tbody>";
                while($item = mysqli_fetch_array($exec_adm)){
                  echo "<tr>";
                  echo "<td>".$item['nom_de_code']."</td>" ;
                  echo "<th style=\"width: 10%\"><a class=\"button is-danger is-light\" href=\"missions_gestion.php?del_a=".$item['nom_de_code']."&del_m=".$data['nom_mission']."\"><i class=\"far fa-trash-alt\"></i> &nbsp Supprimer un agent</a></th>";
                  echo "</tr>";
                }
                echo "</div></tbody> </table>";
                echo "</div> ";

              }

            }

          //  echo "</div>";
          }
          mysqli_close($db);
          ?>
      </div>
  </body>
</html>
