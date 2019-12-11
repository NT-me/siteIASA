<?php
// Renvoie True si aucune deco n'a été demandée
function deco(){
  session_start();
  if(isset($_GET['deconnexion']))
  {
    if ($_GET['deconnexion']==true){
      // Cas où une Déconnexion a été demandée
      session_unset();
      header("location:index.php");
    }
  }
  else if($_SESSION['username'] !== "" & isset($_SESSION['username'])){
    $user = $_SESSION['username'];
    // Cas où aucune déconnexion n'a été demandée et où une session est en cours
    return True;
  }
  else{
    // Cas où la session n'est plus en cours
    session_unset();
    header("location:index.php");
  }
}
?>
