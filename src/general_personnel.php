<?php
include('head.php');
include('co_db.php');
 ?>
<script>
function openPage(pageName, elmnt, color) {
  // Hide all elements with class="tabcontent" by default */
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Remove the background color of all tablinks/buttons
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].style.backgroundColor = "";
  }

  // Show the specific tab content
  document.getElementById(pageName).style.display = "block";

  // Add the specific color to the button used to open the tab content
  elmnt.style.backgroundColor = color;
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>
  <body>
    <?php
    include('bar_menu.php');
      ?>
    <div class="content is-medium">
      <h2>
        Ensemble du personnel de l'IASA :
      </h2>
    </div>

    <div class="content is-little">
    <p>
      Rechercher un membre du personnel avec :
    </p>
    <button class="tablink" onclick="openPage('NdC', this, '#bd272c')">Nom de code</button>
    <button class="tablink" onclick="openPage('Poste', this, '#bd272c')">Poste</button>
    <button class="tablink" onclick="openPage('Service', this, '#bd272c')">Service</button>
    <button class="tablink" onclick="openPage('Pays', this, '#bd272c')">Pays</button>

    <div id="NdC" class="tabcontent">
      <form method="post">
      <input type="text" name="ndc" placeholder="Mettez le nom de code">
      <input type="submit" name="show_ndc" value="Lancer la recherche"/>
    </form>
    </div>
    <?php
    if (isset($_POST['show_ndc'])) {
      $valeur_ndc = $_POST['ndc'];
    }
    ?>

    <div id="Poste" class="tabcontent">
      <div class="requete-box">
          <form method="post">
            <select name="niv_acc" style="width: 100%">
              <option value="1">Directeur</option>
              <option value="0">Agent</option>
            </select>
            <input type="submit" name="show_niv_acc" value="Lancer recherche"/>
          </form>
        </div>
    </div>
    <?php
    if (isset($_POST['show_niv_acc'])) {
      $valeur_niv_acc = $_POST['niv_acc'];
    }
    ?>

    <div id="Service" class="tabcontent">
      <div class="requete-box">
          <form method="post">
            <select name="nom_service" style="width: 100%">
              <option value="86883657">Informatique</option>
              <option value="44609807">Defense</option>
              <option value="91345364">Elimination</option>
              <option value="22195465">Enquete</option>
              <option value="78334802">Enquete interne</option>
              <option value="6350262">Action</option>
              <option value="1738411">Assistance</option>
              <option value="17410830">Contre-espionnage</option>
            </select>
            <input type="submit" name="show_nom_service" value="Lancer recherche"/>
          </form>
        </div>
    </div>
    <?php
    if (isset($_POST['show_nom_service'])) {
      $valeur_nom_service = $_POST['nom_service'];
    }
    ?>

    <div id="Pays" class="tabcontent">
      <form method="post">
      <input type="text" name="nom_pays" placeholder="Mettez le nom du pays">
      <input type="submit" name="show_nom_pays" value="Lancer la recherche"/>
    </form>
    </div>
    <?php
    if (isset($_POST['show_nom_pays'])) {
      $valeur_nom_pays = $_POST['nom_pays'];
    }
    ?>

    <div class="is-medium" style="margin-bottom: 2%">
          <?php

          echo "<br><br><br>";
          if (isset($valeur_ndc)) {
            $requete_tout_agents = "SELECT DISTINCT nom, prenom, nom_agent, agent.niv_acces, nom_service, nom_pays
            FROM personne, agent, travail
            where nom_agent like '".$valeur_ndc."'
            and agent.nom_de_code like '".$valeur_ndc."'
            and travail.nom_de_code like '".$valeur_ndc."'
            order by agent.niv_acces DESC";
          }
          elseif (isset($valeur_niv_acc)) {
            $requete_tout_agents = "SELECT nom, prenom, nom_agent, agent.niv_acces, nom_service, nom_pays
            FROM personne, agent, travail
            where agent.nom_de_code = personne.nom_agent
            AND agent.nom_de_code = travail.nom_de_code
            AND agent.niv_acces = ".$valeur_niv_acc."
            order by agent.niv_acces DESC";;
          }
          elseif (isset($valeur_nom_service)) {
            $requete_tout_agents = "SELECT nom, prenom, nom_agent, agent.niv_acces, nom_service, nom_pays
            FROM personne, agent, travail
            where agent.nom_de_code = personne.nom_agent
            AND agent.nom_de_code = travail.nom_de_code
            AND travail.nom_service = ".$valeur_nom_service."
            order by agent.niv_acces DESC";;
          }
          elseif (isset($valeur_nom_pays)) {
            $requete_tout_agents = "SELECT nom, prenom, nom_agent, agent.niv_acces, nom_service, nom_pays
            FROM personne, agent, travail
            where agent.nom_de_code = personne.nom_agent
            AND agent.nom_de_code = travail.nom_de_code
            AND nom_pays like '".$valeur_nom_pays."'
            order by agent.niv_acces DESC";;
          }
          else {
            $requete_tout_agents = "SELECT nom, prenom, nom_agent, agent.niv_acces, nom_service, nom_pays
            FROM personne, agent, travail
            where agent.nom_de_code = personne.nom_agent
            AND agent.nom_de_code = travail.nom_de_code
            order by agent.niv_acces DESC";
          }

          $exec_tout_agents = mysqli_query($db,$requete_tout_agents);
          $number = mysqli_num_rows($exec_tout_agents);
          echo $number." items affichés.</p>";
          echo "<table class=\"table is-fullwidth is-bordered is-hoverable\">
                  <tbody>
                    <tr style=\"background-color: lightgrey\">
                      <th>Nom</th>
                      <th>Prénom</th>
                      <th>Nom de code</th>
                      <th>Poste</th>
                      <th>Service</th>
                      <th>Pays</th>
                    </tr>";

          while($data = mysqli_fetch_array($exec_tout_agents))
          {
            echo "<tr>";
            echo "<td>".$data['nom']."</td>
            <td>".$data['prenom']."</td>
            <td>".$data['nom_agent']."</td>
            <td>".ctp_agent($data['niv_acces'])."</td>
            <td>".ctn_service($data['nom_service'])."</td>
            <td>".$data['nom_pays']."</td>" ;
            ;
            echo "</tr>";
          }
          mysqli_close($db); // fermer la connexion
          ?>
        </tbody>
      </table>
  </div>
  </body>
