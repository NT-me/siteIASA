<html>
<!-- head -->
<?php
include('head.php');
include('co_db.php');
 ?>
<body>
    <?php
    include('bar_menu.php')
     ?>
    <div class="requete-box">
        <form method="post">
          <p class="container is-medium" style="float: left">
            Rechercher les pays au niveau de danger
          </p>
          <select name="comparaison_signe" style="float: left">
            <option value=">">Supérieur</option>
            <option value=">=">Supérieur ou égal</option>
            <option value="<">Inferieur</option>
            <option value="<=">Inferieur ou égal</option>
          </select>
          <form method="post style="float: left"">
            <p class="container is-medium" style="float: left">
              a
            </p>
            <select name="valeur_niv">
              <option value="0">0</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            <input type="submit" name="show_valeur_niv" value="show"/>
          </form>
        </form>
      </div>

      <div class="container" style="float: left">

      </div>
      </div>
      <?php
      // here starts the php
       if (isset($_POST['show_valeur_niv'])) {
          $valeur_niv = $_POST['valeur_niv'];
          $comparaison_signe = $_POST['comparaison_signe'];
       }
      ?>
    <div class="container is medium" style="margin-bottom: 2%">
      <table class="table is-fullwidth is-bordered is-hoverable">
        <tbody>
          <tr style="background-color: lightgrey">
            <th>Nom de Pays</th>
            <th>Niveau de danger (/4)</th>
          </tr>
          <?php
          if (isset($_POST['show_valeur_niv'])) {
            $requete_pr = "SELECT * FROM pays_ranking P WHERE P.niv_danger ".$comparaison_signe." '".$valeur_niv."' ";
            echo "<p> Liste des pays ".$comparaison_signe." a ".$valeur_niv." </p>";
          }
          else{
            $requete_pr = "SELECT * FROM pays_ranking";
          }

          $exec_pr = mysqli_query($db,$requete_pr);

          while($data = mysqli_fetch_array($exec_pr))
          {
            echo "<tr>";
            echo "<td>".$data['nom']."</td><td>".$data['niv_danger']."</td>" ;
            echo "</tr>";
          }
          mysqli_close($db); // fermer la connexion
          ?>
        </tbody>
      </table>
  </div>
</body>
</html>
