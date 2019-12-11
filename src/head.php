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
  $prenom = $_SESSION['prenom'];
  $nom = $_SESSION['nom'];
  $age = $_SESSION['age'];
  $sexe = $_SESSION['sexe'];
  $pays = $_SESSION['pays'];
  // Récupère le niveau d'accès de la personne
  $niv = $_SESSION['lvl_acc'];
  ?>
</head>
