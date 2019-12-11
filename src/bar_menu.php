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
      print "<li><a href=\"missions_gestion.php\" >Missions en gestion</a></li>" ;
      print "<li><a href=\"agent_gestion.php\" >Agents en gestion</a></li>" ;
      if ($niv == 2){
        print "<li><a href=\".php\" >Chefs des services</a></li>" ;
        print "<li><a href=\".php\" >RH agence</a></li>" ;
      }
    }
    ?>
  </ul>
</div>
