<html>
<!-- head -->
<?php
include('head.php');
include('co_db.php');
 ?>

  <body>
    <?php include('bar_menu.php');
    $nom_dir = $_SESSION['Directeur_Name'];
    $requete_info = "SELECT prenom, nom, age, sexe, nom_pays FROM personne where
          nom_agent = '".$nom_dir."' ";

    $exec_requete_info = mysqli_query($db, $requete_info);
    $reponse_info      = mysqli_fetch_array($exec_requete_info);

    $prenom_dir = $reponse_info['prenom'];
    $age_dir =$reponse_info['age'];
    $sexe_dir=$reponse_info['sexe'];
    $pays_dir = $reponse_info['nom_pays'];
    $service_dir = $_SESSION['Directeur_service'];
          ?>
    <div class="box info">
      <article class="media">
        <div class="media-left">
          <figure class="image is-128x128">
            <?php
            if ($sexe == "male"){
              print "<img src=\"../img/men_PP.jpg\">";
            }
            else if ($sexe == "female"){
              print "<img src=\"../img/women_PP.jpg\">";
            }
             ?>
          </figure>
        </div>
        <div>
          <table class="table is-fullwidth is-bordered">
            <tbody>
              <tr>
                <th>Nom</th>
                <td><?php print "$nom_dir" ?></td>
              </tr>
                <th>Prénom</th>
                <td><?php print "$prenom_dir" ?></td>
              </tr>
              <tr>
                <th>Age</th>
                <td><?php print "$age_dir" ?></td>
              </tr>
              <tr>
                <th>Sexe</th>
                <td><?php print "$sexe_dir" ?></td>
              </tr>
              <tr>
                <th>Pays</th>
                <td><?php print "$pays_dir" ?></td>
              </tr>
              <tr>
                <th>Service</th>
                <td><?php
                  switch ($service_dir) {
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
                  if ($niv == 1) {
                    if ($sexe == "male"){
                      $NS = $NS." (Directeur)";
                    }
                    else if ($sexe == "female"){
                      $NS = $NS." (Directrice)";
                    }
                  }
                  echo "$NS";
                ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </article>
</div>
  </body>
</html>
