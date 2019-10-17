<?php
session_start();
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
  <meta charset="utf-8"/>
  <title>Planer spotkań biznesowych</title>
  <meta name="description" content="Planer spotkań biznesowych"/>

  <link rel="stylesheet" href="css/style.css" type="text/css"/>
  <link rel="stylesheet" href="css/fontello.css" type="text/css"/>
  <link href="https://fonts.googleapis.com/css?family=Lato:400,900i&amp;subset=latin-ext" rel="stylesheet">

</head>

<body>

  <div id="container">

    <div class="rectangle">
      <div id="zegar">
        <a href="index.php"  style="color: white">
          <i class="icon-home"></i>
        </a>
      </div>

      
      <div style="clear:both"></div>
    </div>

    <div class="square">
    <form action="zaloguj.php" method="post">
      <div class="tile6" style="padding-top: 80px; height: 280px">

          Login:<br/><input type="text" name="login" placeholder="Adres e-mail lub login">
          <br/>Hasło:<br/><input type="password" name="haslo" placeholder="Hasło">
          <?php
            if(isset($_SESSION['blad']))
              echo $_SESSION['blad'];
          ?>
      </div>

      <button type="submit" class="tile4">

          <i class="icon-login"></i>
          <br/>Zaloguj się

      </button>
    </form>
    </div>


    <div class="square">

      <a href="rejestracja.php" class="tilelink">
        <div class="tile10">
          <i class="icon-meeting"></i>
          <br/>Zarejestruj się
        </div>
      </a>

    </div>

    <div style="clear:both"></div>


    <div class="rectangle">
      Małgorzata Wojnarowska &copy; Wszelkie prawa zastrzeżone
    </div>

  </div>


</body>
</html>
