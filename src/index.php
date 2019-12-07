<!DOCTYPE html>

<html>
<head>
  <meta name="author" content="Théo Nardin & Alexandre De freitas">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IASA</title>
  <link rel="icon" href="../img/Favicon.png">
  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">-->
  <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
  <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
  <link rel="stylesheet" href="../style/style.css">
</head>

<body  background style="background-color: black;">
  <div id="container">
      <!-- zone de connexion -->

      <form action="verification.php" method="POST">
          <h1>Connexion</h1>

          <label><b>Nom d'utilisateur</b></label>
          <input type="text" placeholder="Entrer le nom d'utilisateur" name="username" required>

          <label><b>Mot de passe</b></label>
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
