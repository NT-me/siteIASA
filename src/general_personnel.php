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
</script>

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
    <?php
    include('bar_menu.php');

    // Supprimer un agent
    if(isset($_GET['del_a']))
    {
      $del_a = $_GET['del_a'];
      $requete_del_agent = "DELETE FROM personne WHERE nom_agent ='".$del_a."'";

      $exec_del_agent = mysqli_query($db,  $requete_del_agent);

      $requete_del_agent2 = "DELETE FROM agent WHERE nom_de_code ='".$del_a."'";

      $exec_del_agent2 = mysqli_query($db,  $requete_del_agent2);

      if (mysqli_query($db, $requete_del_agent)) {
          echo "<div class=\"content notification is-success\">
                Agent supprimé avec succès
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
          Ajout d'un agent<br><br>
        </h3>
        <form method="post">
          <h4 style="margin-top:2%">
            Nom
          </h4>
          <input name="add_nom" type="text" placeholder="Entrez un nom de code" required>

          <h4 style="margin-top:2%">
            Prénom
          </h4>
          <input name="add_prenom" type="text" placeholder="Entrez un nom de code" required>

          <h4 style="margin-top:2%">
            Age
          </h4>
          <input type="number" name="add_age" min="0" max="100" required>

          <h4 style="margin-top:2%">
            Sexe
          </h4>
          <select name="add_sexe" style="width: 100%">
            <option value="male">Masuclin</option>
            <option value="female">Féminin</option>
          </select>

          <h4 style="margin-top:2%">
            Nom du pays
          </h4>
          <input name="add_nom_p" type="text" placeholder="Entrez un nom de pays" required>

          <h4 style="margin-top:2%">
            Nom de code
          </h4>
          <input name="add_ndc" type="text" placeholder="Entrez un nom de code" required>

          <h4 style="margin-top:2%">
            Nom du service
          </h4>
          <select name="add_nom_service" style="width: 100%">
            <option value="86883657">Informatique</option>
            <option value="44609807">Defense</option>
            <option value="91345364">Elimination</option>
            <option value="22195465">Enquete</option>
            <option value="78334802">Enquete interne</option>
            <option value="6350262">Action</option>
            <option value="1738411">Assistance</option>
            <option value="17410830">Contre-espionnage</option>
          </select>

          <h4 style="margin-top:2%">
            Pourcentage de confiance
          </h4 >
          <input method="post" type="number" name="add_niv" min="0" max="100" required>

          <h4 style="margin-top:2%">
            Etat de service
          </h4>
          <textarea class="textarea" name="add_eds" placeholder="Entrez le nom de code" required></textarea>
          <input type="submit" name="show_add_form" value="show"/>
  </form>
</div>

  <?php
  if (isset($_POST['show_add_form'])) {
    $add_nom = $_POST['add_nom'];
    $add_nom_service = $_POST['add_nom_service'];
    $add_prenom = $_POST['add_prenom'];
    $add_nom_p = $_POST['add_nom_p'];
    $add_age = $_POST['add_age'];
    $add_sexe = $_POST['add_sexe'];

    $add_ndc = $_POST['add_ndc'];
    $add_niv = $_POST['add_niv'];
    $add_eds = $_POST['add_eds'];

    $req_add_agent = "INSERT INTO agent VALUES
    ('".$add_ndc."', 0, ".$add_niv.", '".$add_eds."')";
    mysqli_query($db, $req_add_agent);

    $req_add_pers = "INSERT INTO personne VALUES
    ('".$add_nom."', '".$add_prenom."', ".$add_age.", '".$add_sexe."', '".$add_ndc."', '".$add_nom_p."')";
    mysqli_query($db, $req_add_pers);

    $req_add_travail = "INSERT INTO travail VALUES
    ('".$add_ndc."', ".$add_nom_service.")";

  }
  if  (isset($_POST['show_add_form'])){
    if (mysqli_query($db, $req_add_travail)) {
      echo "<div class=\"content notification is-success\">
      Agent créer avec succès
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

    <div style="margin-bottom: 2%">
          <?php
          echo "<button style=\"float: right\" class=\"button is-success is-light\" onclick=\"openNav()\"><i class=\"far fa-plus-square\"></i> &nbsp Ajouter un agent</button>";
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
                      <th style=\"width: 10%\">Pays</th>
                    </tr>";

          while($data = mysqli_fetch_array($exec_tout_agents))
          {
            echo "<tr>";
            if ($data['niv_acces'] == 0){
              echo "<td>".$data['nom']."<a style=\"float:right\" class=\"button is-danger is-light\" href=\"general_personnel.php?del_a=".$data['nom_agent']."\">
              <i class=\"far fa-trash-alt\"></i> &nbsp Supprimer un agent</a>"."</td>";
            }
            else{
              echo "<td>".$data['nom']."</td>";
            }
            echo "<td>".$data['prenom']."</td>
            <td>".$data['nom_agent']."</td>
            <td>".ctp_agent($data['niv_acces'])."</td>
            <td>".ctn_service($data['nom_service'])."</td>
            <td style=\"width: 10%\">".$data['nom_pays']."</td>" ;
            echo "</tr>";
          }
          mysqli_close($db); // fermer la connexion
          ?>
        </tbody>
      </table>
  </div>
  </body>
