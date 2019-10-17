<?php

  session_start();

  $nazwiskoPracownika = $_SESSION['nazwisko'];
  $imiePracownika = $_SESSION['imie'];

  if(!isset($_SESSION['zalogowany'])){
    header('Location: logowanie.php');
    exit();
  }
  $idnotatki=$_GET['n1'];


    if(isset($_POST['tytul']) || isset($_POST['data']) || isset($_POST['tresc'])){


      //Udana walidacja
      $wszystko_ok = true;

      require_once "connect.php";

      mysqli_report(MYSQLI_REPORT_STRICT);
      try{
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

        if($polaczenie->connect_errno!=0){
          throw new Exception(mysqli_connect_errno());
        }
        else{


          if(isset($_POST['tytul'])){
            $tytul = $_POST['tytul'];
            if($polaczenie->query("UPDATE Notatki SET Tytul='$tytul' WHERE IdNotatki='$idnotatki' "))
              $_SESSION['udanedodanienotatki'] = true;
          }
          if(isset($_POST['data'])){
            $data = $_POST['data'];
            if($polaczenie->query("UPDATE Notatki SET Data='$data' WHERE IdNotatki='$idnotatki' "))
              $_SESSION['udanedodanienotatki'] = true;
          }
          if(isset($_POST['tresc'])){
            $tresc = $_POST['tresc'];
            if($polaczenie->query("UPDATE Notatki SET Tresc='$tresc' WHERE IdNotatki='$idnotatki' "))
              $_SESSION['udanedodanienotatki'] = true;
          }

          $polaczenie->close();
        }


      }
      catch(Exception $e){
        echo '<div class="error">Błąd serwera!</div>';
  //      echo '<br/>Info: '.$e;
      }



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
      <form method="post">

          <div class="tile8" style="width: 1160px;">

            <label>Tytuł<br/><input type="text" name="tytul"></label>
            <br/>Data<br/><input type="date" name="data" placeholder="YYYY-MM-DD"></label>
            <br/>Treść<br/><input type="text" name="tresc" style="width: 90%; height: 150px;"></label>


          </div>

          <button type="submit" class="tile7" style="margin:10px; float: left;">
              <i class="icon-notes"></i>
              <br/>Zapisz notatkę
          </button>

      </form>

    </div>
      <a href="deletenote.php?n1=<?= $idnotatki ?>" class="tilelink">
        <div class="tile7" style="margin:10px; float: left; padding-left:230px; width: 350px;">
          <i class="icon-note"></i>
          <br/>Usuń notatkę
        </div>
      </a>



    <div style="clear:both"></div>


    <div class="rectangle">
      Małgorzata Wojnarowska &copy; Wszelkie prawa zastrzeżone
    </div>

  </div>


</body>
</html>
