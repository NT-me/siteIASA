<?php
// Récupère le niveau d'accès de la personne
$niv = $_SESSION['lvl_acc'];

// Se connect à la db
// connexion à la base de données
switch (niv) {
  case 0:
    $db_username = 'agent';
    $db_password = 'IDagnIASA_';
    break;
  case 1:
    $db_username = 'chief';
    $db_password = 'IDchfIASA_';
    break;
  case 2:
    $db_username = 'general';
    $db_password = 'IDgenIASA_';
    break;
}
$db_name     = 'iasa';
$db_host     = 'localhost';
$db = mysqli_connect($db_host, $db_username, $db_password,$db_name)
       or die('could not connect to database');
 ?>
