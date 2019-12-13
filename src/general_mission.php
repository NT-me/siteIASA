<?php
include('head.php');
include('co_db.php');
 ?>

  <body>
    <?php include('bar_menu.php');  ?>

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
  include "code_to_nom.php";
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

        if (isset ($_POST['nom_pays'])) {
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
