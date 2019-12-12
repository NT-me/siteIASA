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
        Voici l'ensemble des services composant l'IASA et leur directeurs respectifs :
      </p>
    </div>

    <div class="container is medium" style="margin-bottom: 2%">
      <table class="table is-fullwidth is-bordered is-hoverable">
        <tbody>
          <tr style="background-color: lightgrey">
            <th>Nom du service</th>
            <th>Nom de son directeur</th>
          </tr>
          <?php
            $requete_sd = "SELECT * FROM service";


          $exec_sd = mysqli_query($db,$requete_sd);

          while($data = mysqli_fetch_array($exec_sd))
          {
            echo "<tr>";
            echo "<td>".$data['specialite']."</td><td>".$data['directeur']."</td>" ;
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
  </div>

  <div class="container">
    <div class="requete-box">
        <form method="post">
          <p class="container is-medium" style="float: left">
            Plus d'information sur le service
          </p>
          <select name="nom_service_more_info" style="float: left">
            <option value="86883657">Informatique</option>
            <option value="44609807">Defense</option>
            <option value="91345364">Elimination</option>
            <option value="22195465">Enquete</option>
            <option value="78334802">Enquete interne</option>
            <option value="6350262">Action</option>
            <option value="1738411">Assistance</option>
            <option value="17410830">Contre-espionnage</option>
          </select>
          <input type="submit" name="show_nom_service_more_info" value="show"/>
        </form>
      </div>
  </div>
  <?php
  if (isset($_POST['show_nom_service_more_info'])) {
    $valeur_nsmi = $_POST['nom_service_more_info'];
  }
  ?>

  <div class="content is-medium">
    <?php
    if(isset($_POST['show_nom_service_more_info'])){
      $requete_nsmi =
      "SELECT specialite, directeur
      from service
      where code_service = ".$valeur_nsmi;
      $exec_nsmi = mysqli_query($db,$requete_nsmi);
      $data = mysqli_fetch_array($exec_nsmi);

      $requete_nami =
      "SELECT count(DISTINCT nom_de_code) as nbre_agent
      FROM travail
      WHERE nom_service = ".$valeur_nsmi;
      $exec_nami = mysqli_query($db,$requete_nami);
      $data_nami = mysqli_fetch_array($exec_nami);

      $requete_ntmi =
      "SELECT count(DISTINCT mission.nom_mission) as nbre_mission_terminees
			   from gere, mission, service
			   where gere.nom_mission = mission.nom_mission
			   and service.specialite = mission.type_mission
			   and mission.etat_mission like 'fini'
			   and service.code_service = ".$valeur_nsmi;
      $exec_ntmi = mysqli_query($db,$requete_ntmi);
      $data_ntmi = mysqli_fetch_array($exec_ntmi);

      $requete_nmami =
      "SELECT count(DISTINCT mission.nom_mission) as nbre_mission_en_cours
         from gere, mission, service
         where gere.nom_mission = mission.nom_mission
         and service.specialite = mission.type_mission
         and mission.etat_mission like 'en cours'
         and service.code_service = ".$valeur_nsmi;
      $exec_nmami = mysqli_query($db,$requete_nmami);
      $data_nmami = mysqli_fetch_array($exec_nmami);

      $requete_imcmi =
      "SELECT distinct service.code_service as nom_service
      from service
      where exists(select service.specialite, agent.nom_de_code
        from travail,agent
        where service.code_service = travail.nom_service
        and travail.nom_de_code = agent.nom_de_code
        and agent.niv_confiance = 100 )";
      $exec_imcmi = mysqli_query($db,$requete_imcmi);
      $data_imcmi = mysqli_fetch_array($exec_imcmi);

      $requete_moyenne =
      "SELECT avg(niv_confiance) as moy_conf
      from travail, agent
      where agent.nom_de_code = travail.nom_de_code
      and travail.nom_service = ".$valeur_nsmi;;
      $exec_moyenne = mysqli_query($db,$requete_moyenne);
      $data_moyenne = mysqli_fetch_array($exec_moyenne);

      $NS = $valeur_nsmi;
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

      $_SESSION['Directeur_Name'] = $data['directeur'];
      $_SESSION['Directeur_service'] = $valeur_nsmi;

      echo "Informations à propos du service $NS : <br>";

      echo "  <div class=\"box \" style=\"margin-bottom : 2%;\"><div style=\"margin-bottom : 2%;\">";
      echo "  <p>Spécialité du service : ".$data['specialite']." <br>
      Nom du directeur : ".$data['directeur']."<br>
      Nombre d'agent : ".$data_nami['nbre_agent']."<br></p>
      Moyenne des niveaux de confiance : ".$data_moyenne['moy_conf']."% <br></p>
      Nombre de missions actives : ".$data_nmami['nbre_mission_en_cours']."<br></p>
      Nombre de missions terminées : ".$data_ntmi['nbre_mission_terminees']."<br></p>
      <a href=\"info_directeur.php\" class=\"button is-medium\"><i class=\"far fa-eye\"></i> Plus d'information à propos de ".$data['directeur']."</a>";

      if(in_array($valeur_nsmi, $data_imcmi)){
        echo "<br><br><br>";
        echo "Il existe dans ce service au moins un agent au niveau de confiance égal à 100%";
      }
      echo "</div> ";
    }
    else{
      echo "<p>N'hésitez pas à selectionner un service pour avoir plus d'information à son propos</p>";
    }
    ?>
  </div>
  </body>
</html>
