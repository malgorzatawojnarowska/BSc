
<?php

  session_start();

  if(!isset($_SESSION['zalogowany'])){
    header('Location: logowanie.php');
    exit();
  }
  $idnotatki=$_GET['n1'];

  require_once "connect.php";

  mysqli_report(MYSQLI_REPORT_STRICT);
  try{
    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

    if($polaczenie->connect_errno!=0){
      throw new Exception(mysqli_connect_errno());
    }
    else{

        if($polaczenie->query("DELETE FROM Notatki WHERE IdNotatki='$idnotatki' "))
          $_SESSION['udaneusuniecienotatki'] = true;

      $polaczenie->close();
    }


  }
  catch(Exception $e){
    echo '<div class="error">Błąd serwera!</div>';
//      echo '<br/>Info: '.$e;
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

      <div class="tile8">Dziękujemy za usunięcie notatki! Możesz dodać nową!</div>

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
