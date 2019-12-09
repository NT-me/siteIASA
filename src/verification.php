<?php
session_start();
if(isset($_POST['username']) && isset($_POST['password']))
{
    // connexion à la base de données
    $db_username = 'root';
    $db_password = '';
    $db_name     = 'iasa';
    $db_host     = 'localhost';
    $db = mysqli_connect($db_host, $db_username, $db_password,$db_name)
           or die('could not connect to database');

    // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
    // pour éliminer toute attaque de type injection SQL et XSS
    $username = $_POST['username'];
    $password = $_POST['password'];

    if($username !== "" && $password !== "")
    {
        $requete_login = "SELECT count(*) FROM personne where
              nom_agent = '".$username."' and nom = '".$password."' ";
        $requete_lvl_acc = "SELECT niv_acces FROM agent where
              nom_de_code = '".$username."' ";

        $exec_requete_login = mysqli_query($db,$requete_login);
        $reponse_login      = mysqli_fetch_array($exec_requete_login);
        $count = $reponse_login['count(*)'];
        if($count!=0) // nom d'utilisateur et mot de passe correctes
        {
          $exec_requete_lvl_acc = mysqli_query($db,$requete_lvl_acc);
          $reponse_lvl_acc      = mysqli_fetch_array($exec_requete_lvl_acc);

          $_SESSION['username'] = $username;
          $_SESSION['lvl_acc'] = $reponse_lvl_acc['niv_acces'];
          header('Location: principale.php');
        }
        else
        {
           header('Location: index.php?erreur=1'); // utilisateur ou mot de passe incorrect
        }
    }
    else
    {
       header('Location: index.php?erreur=2'); // utilisateur ou mot de passe vide
    }
}
else
{
   header('Location: index.php');
}
mysqli_close($db); // fermer la connexion
?>
