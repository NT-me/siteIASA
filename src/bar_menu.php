<div class="high-bar">
<ul>
  <img src="Favicon.png">

    <h1>
      <?php
      include "code_to_nom.php";
      $ndc = $_SESSION['username'];
      echo ctp_agent($niv).", ".$ndc;
      ?>
    </h1>
  <li ><a class="deco-button" href="principale.php?deconnexion=true"><i class="fas fa-power-off"></i> Déconnexion</a></li>
</ul>
</div>
<div class="sidebar">
  <a href="principale.php">Espace personnel</a>
  <a href="mission.php">Missions</a>

  <?php
  if ($niv == 1){
    print "<a href=\"missions_gestion.php\" >Missions en gestion</a>" ;
    print "<a href=\"agent_gestion.php\" >Agents en gestion</a>" ;
  }
  if ($niv == 2){
    print "<a href=\"chef_service.php\" >Gestion des services</a>" ;
    print "<a href=\"general_personnel.php\" >Gestion du personnel</a>" ;
    print "<a href=\"general_mission.php\" >Gestion des missions</a>" ;
  }
  ?>
  <a href="pays_ranking.php">Classement des pays</a>
</div>
