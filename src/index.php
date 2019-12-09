<!DOCTYPE html>

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
</head>

<body  background style="background: #194993 url(../img/log_wp.jpg) center;">
  <div id="container">
      <!-- zone de connexion -->
      <form action="verification.php" method="POST">
        <img id="logo" src="../img/iasa.png">
           <font face="orator std"><h1 style="text-align: center">Connexion</h1></font>

          <label><b>Nom de code :</b></label>
          <input type="text" placeholder="Entrer le nom d'utilisateur" name="username" required>

          <label><b>Nom de famille :</b></label>
          <input type="password" placeholder="Entrer le mot de passe" name="password" required>

          <input type="submit" id='submit' value='LOGIN' >
          <?php
          if(isset($_GET['erreur'])){
              $err = $_GET['erreur'];
              if($err==1 || $err==2)
                  echo "<p style='color:red'>Utilisateur ou mot de passe incorrect</p>";
          }
          ?>
      </form>
  </div>
</body>
</html>
