<html>
<!-- head -->
<?php
include('head.php');
include('co_db.php');
 ?>

  <body>
    <?php include('bar_menu.php');

    $NS = $_SESSION['service'];
    ?>
      <div class="content is-medium">
        <p>
          <?php
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
          echo "Les agents gérés par le service $NS : <br>";
           ?>
        </p>
      </div>

      <div class="container">
        <div class="requete-box">
            <form method="post">
              <p class="container is-medium" style="float: left">
                Rechercher les agents avec un niveau de confiance
              </p>
              <select name="comparaison_signe" style="float: left">
                <option value=">">Supérieur</option>
                <option value=">=">Supérieur ou égal</option>
                <option value="<">Inferieur</option>
                <option value="<=">Inferieur ou égal</option>
                <option value="=">Egal</option>

              </select>
              <form method="post style="float: left"">
                <p class="container is-medium" style="float: left">
                  a
                </p>
                <input method="post" type="number" name="valeur_niv" min="0" max="100">
                <input type="submit" name="show_valeur_niv" value="show"/>
              </form>
            </form>
          </div>
          <?php
          if (isset($_POST['show_valeur_niv'])) {
            $valeur_niv = $_POST['valeur_niv'];
            $comparaison_signe = $_POST['comparaison_signe'];
          }
          ?>
      </div>
      <div class="content is-medium">
        <table class=\"table is-fullwidth is-bordered is-hoverable\">
          <tbody>
            <tr style="background-color: lightgrey">
              <th>Nom de code</th>
              <th>Niveau de confiance (/100)</th>
            </tr>
        <?php

        $id_NS = $_SESSION['service'];
        if (isset($_POST['show_valeur_niv'])) {
          $requete_ads = "SELECT travail.nom_de_code, agent.niv_confiance FROM travail, agent WHERE travail.nom_service like '".$id_NS."' and travail.nom_de_code like agent.nom_de_code and agent.niv_confiance".$comparaison_signe." '".$valeur_niv."' order by agent.niv_confiance";
        }
        else{
          $requete_ads = "SELECT travail.nom_de_code, agent.niv_confiance FROM travail, agent WHERE travail.nom_service like '".$id_NS."' and travail.nom_de_code like agent.nom_de_code order by agent.niv_confiance";
        }
        $exec_ads = mysqli_query($db, $requete_ads);
        while($item = mysqli_fetch_array($exec_ads)){
          echo "<tr>";
          echo "<td>".$item['nom_de_code']."</td>" ;
          echo "<td>".$item['niv_confiance']."</td>" ;
          echo "</tr>";
        }
        echo " </tbody> </table>";

        mysqli_close($db);
        ?>
      </div>
  </body>
</html>
