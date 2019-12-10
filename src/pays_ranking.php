<html>
<head>
  <meta name="author" content="Théo Nardin & Alexandre De freitas">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IASA</title>
  <link rel="icon" href="Favicon.png">
  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">-->
  <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
  <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
  <link rel="stylesheet" href="../style/style.css">
  <link rel="stylesheet" href="../style/bulma.css">

  <?php
  // Vérfie qu'aucune déconnection n'a été demandée.
  include 'deconnexion.php';
  deco();

  // Récupère le niveau d'accès de la personne
  $niv = $_SESSION['lvl_acc'];
  $prenom = $_SESSION['prenom'];
  $nom = $_SESSION['nom'];
  $age = $_SESSION['age'];
  $sexe = $_SESSION['sexe'];
  $pays = $_SESSION['pays'];
  ?>
</head>
<body>
  <body>
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
          print "<li><a href=\".php\" >Agents en Mission</a></li>" ;
          print "<li><a href=\".php\" >Agents</a></li>" ;
          if ($niv == 2){
            print "<li><a href=\".php\" >Chefs des services</a></li>" ;
            print "<li><a href=\".php\" >RH agence</a></li>" ;
          }
        }
        ?>
      </ul>
    </div>

    <div class="requete-box">
      <p class="container is-medium" style="float: left">
        Rechercher les pays au niveau de danger
      </p>

      <div class="select" style="float: left">
        <select name="comparaison">
          <option value="<">Supérieur (<)</option>
          <option value="<=">Supérieur ou égal (<=)</option>
          <option value=">">Inferieur (>)</option>
          <option value=">=">Inferieur ou égal (>=)</option>

        </select>
      </div>

      <p class="container is-medium" style="float: left">
        a
      </p>

        <div class="select" style="float: left" method="post">
          <select name="valeur">
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select>
        </div>
        <button class="button is-light" style="float: left" type="submit" name="show_dowpdown_value" value="show">Go</button>
      </div>
<?php
// here starts the php
 if (isset($_POST['show_valeur'])) {

    echo $_POST['valeur']; // this will print the value if downbox out
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
          // connexion à la base de données
          $db_username = 'agent';
          $db_password = 'IDagnIASA_';
          $db_name     = 'iasa';
          $db_host     = 'localhost';
          $db = mysqli_connect($db_host, $db_username, $db_password,$db_name)
                 or die('could not connect to database');

          $requete_pr = "SELECT * FROM pays_ranking";

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
