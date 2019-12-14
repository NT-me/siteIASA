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
    // Supprimer un agent
    if(isset($_GET['del_m']))
    {
      $del_a = $_GET['del_m'];
      $requete_del_mission = "DELETE FROM mission WHERE nom_mission ='".$del_a."'";
      $exec_del_agent = mysqli_query($db,  $requete_del_mission);

      $requete_del_mission2 = "DELETE FROM gere WHERE nom_mission ='".$del_a."'";
      $exec_del_agent2 = mysqli_query($db,  $requete_del_mission2);

      $requete_del_mission3 = "DELETE FROM localise WHERE nom_mission ='".$del_a."'";
      $exec_del_agent2 = mysqli_query($db,  $requete_del_mission3);

      if (mysqli_query($db, $requete_del_mission)) {
          echo "<div class=\"content notification is-success\">
                Mission supprimée avec succès
              </div>";
      } else {
        echo "<div class=\"content notification is-danger\">
              Une erreur est survenue : ".mysqli_error($db)."
            </div>";
      }
    }
    ?>

    <div id="mySidenav" class="sidenav">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <h3 style="margin-left:2%">
        Ajout d'une mission<br><br>
      </h3>
      <form method="post">
        <h4 style="margin-top:2%">
          Nom de la mission
        </h4>
        <input name="add_nom_m" type="text" placeholder="Entrez un nom" required>

        <h4 style="margin-top:2%">
          Nom du pays
        </h4>
        <input name="add_nom_p_m" type="text" placeholder="Entrez un nom de pays" required>

        <h4 style="margin-top:2%">
          Nom du service
        </h4>
        <select name="add_nom_service_m" style="width: 100%">
          <option value="86883657">Informatique</option>
          <option value="44609807">Defense</option>
          <option value="91345364">Elimination</option>
          <option value="22195465">Enquete</option>
          <option value="78334802">Enquete interne</option>
          <option value="6350262">Action</option>
          <option value="1738411">Assistance</option>
          <option value="17410830">Contre-espionnage</option>
        </select>

        <input type="submit" name="show_add_form_m" value="show"/>
    </form>
    </div>

    <<?php
    if (isset($_POST['show_add_form_m'])){
      $add_nom_m = $_POST['add_nom_m'];
      $add_nom_p_m = $_POST['add_nom_p_m'];
      $add_nom_service_m = ctn_service($_POST['add_nom_service_m']);
      $add_id_service_m = $_POST['add_nom_service_m'];

      $req_new_mission = "INSERT INTO mission VALUES
      ('".$add_nom_m."', '".$add_nom_service_m."', 'en cours')";
      mysqli_query($db, $req_new_mission);

      $req_new_mission_L = "INSERT INTO localise VALUES
      ('".$add_nom_p_m."', '".$add_nom_m."')";
      mysqli_query($db, $req_new_mission_L);

      $req_new_mission_G = "INSERT INTO gere VALUES
      (".$add_id_service_m.", '".$add_nom_m."')";
      if (mysqli_query($db, $req_new_mission_G)) {
        echo "<div class=\"content notification is-success\">
        Mission créer avec succès
        </div>";
      } else {
        echo "<div class=\"content notification is-danger\">
        Une erreur est survenue : ".mysqli_error($db)."
        </div>";
      }
    }


     ?>

  <div class="content is-medium">
    <h2>
      Ensemble des missions de la IASA:
    </h2>
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
              du service
            </p>
            <select name="service" style="float: left">
              <option value=""></option>
              <option value="86883657">Informatique</option>
              <option value="44609807">Defense</option>
              <option value="91345364">Elimination</option>
              <option value="22195465">Enquete</option>
              <option value="78334802">Enquete interne</option>
              <option value="6350262">Action</option>
              <option value="1738411">Assistance</option>
              <option value="17410830">Contre-espionnage</option>
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
        $c_service = $_POST['service'];
        if (isset ($_POST['nom_pays'])){
          $c_nom_pays = $_POST['nom_pays'];
          }
      }
      ?>
  </div>

  <div class="content is-medium">
  <?php
  echo "<button style=\"float: right\" class=\"button is-success is-light\" onclick=\"openNav()\"><i class=\"far fa-plus-square\"></i> &nbsp Ajouter une mission</button>";
    $tmp_nom = "";
    $tmp_pays_nom="";
    $pays_noms = "";
    $id_NS = $_SESSION['service'];

    if ( !isset($_POST['show_etat_service']) or ($c_etat == "" and $c_service == "")){
      $requete_all_missions = "SELECT nom_mission, mission.etat_mission
      from mission";
    }
    elseif ($c_etat != "" and $c_service == "") {
      $requete_all_missions = "SELECT nom_mission, mission.etat_mission
      from mission
      where etat_mission like '".$c_etat."'";
    }
    elseif ($c_etat == "" and $c_service != "") {
      $requete_all_missions = "SELECT DISTINCT mission.nom_mission as nom_mission, mission.etat_mission
			   from gere, mission, service
			   where gere.nom_mission = mission.nom_mission
			   and service.specialite = mission.type_mission
			   and service.code_service = ".$c_service;
    }
    else {
      $requete_all_missions = "SELECT DISTINCT mission.nom_mission as nom_mission, mission.etat_mission
			   from gere, mission, service
			   where gere.nom_mission = mission.nom_mission
			   and service.specialite = mission.type_mission
			   and mission.etat_mission like '".$c_etat."'
			   and service.code_service = ".$c_service;
    }
    $exec_all_missions = mysqli_query($db,$requete_all_missions);

    while($data = mysqli_fetch_array($exec_all_missions)){
      $Pays_flag = 1;
      $pays_noms = "";
      $service_noms = "";

      if($data['nom_mission'] != $tmp_nom){

        // Requête du pays
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
          // Requête des services
          $requete_service = "SELECT nom_service FROM gere where nom_mission like '".$data['nom_mission']."'";
          $exec_service = mysqli_query($db,$requete_service);
          while($data_service = mysqli_fetch_array($exec_service)){
            $service_noms = $service_noms.ctn_service($data_service["nom_service"])." ";
          }
          echo "<div class=\"box\" style=\"margin-bottom : 2%;\"><div class=\"is-little\" style=\"all_missionsrgin-bottom : 2%;\">";
          echo "
          <p>Nom mission : ".$data['nom_mission']." <br>
          Localisation : ".$pays_noms."<br>
          Etat : ".$data['etat_mission']."<br>
          Service : ".$service_noms."<br></p>";
          echo "<td><a style=\"float:right\" class=\"button is-danger is-light\" href=\"general_mission.php?del_m=".$data['nom_mission']."\">
          <i class=\"far fa-trash-alt\"></i> &nbsp Supprimer une mission</a>"."</td>";
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
          echo "</div>";
        }
      }
    }
    mysqli_close($db);
    ?>
  </div>
</body>
