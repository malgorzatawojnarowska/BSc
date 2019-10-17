<?php

  session_start();
  if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true)){
    header('Location: indexzalogowany.php');
    exit();
  }

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
      <!--
      <div id="login">Jan Kowalski</div>
      -->
      <div style="clear:both"></div>
    </div>

    <div class="square">

      <a href="day.php" class="tilelink">
        <div class="tile1">
          <i class="icon-day"></i>
          <br/>Dzień
        </div></a>

      <a href="month.php" class="tilelink">
        <div class="tile1">
          <i class="icon-month"></i>
          <br/>Miesiąc
        </div>
      </a>


      <div style="clear:both"></div>

      <a href="year.php" class="tilelink">
        <div class="tile2">
          <i class="icon-year"></i>
          <br/>Rok
        </div>
      </a>

      <a href="notes.php" class="tilelink">
        <div class="tile3">
          <i class="icon-notes"></i>
          <br/>Notatki
        </div>
      </a>

    </div>


    <div class="square">

      <a href="logowanie.php" class="tilelink">
        <div class="tile4" style="padding-top:35px; height:140px;">
          <i class="icon-login"></i>
          <br/>Zaloguj
        </div>
      </a>

      <a href="addmeeting.php" class="tilelink">
        <div class="tile5">
          <i class="icon-meeting"></i>
          <br/><br/>Dodaj spotkanie
        </div>
      </a>

      <a href="addnote.php" class="tilelink">
        <div class="tile5" padding="80">
          <i class="icon-note"></i>
          <br/><br/>Dodaj notatkę
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
