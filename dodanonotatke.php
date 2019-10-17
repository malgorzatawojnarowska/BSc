
<?php

  session_start();
  if(!isset($_SESSION['udanedodanienotatki'])){
    header('Location: index.php');
    exit();
  }
  else{
    unset ($_SESSION['udanedodanienotatki']);
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

      <div id="login">
        <?php echo $_SESSION['imie']." ".$_SESSION['nazwisko'];?>
      </div>

      <div style="clear:both"></div>
    </div>

    <div class="rectangle">

      <div class="tile8">Dziękujemy za dodanie notatki! Możesz dodać kolejne!</div>

      <a href="addnote.php" class="tilelink">
        <div class="tile9">
          <i class="icon-note"></i>
          <br/>Dodaj notatkę
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
