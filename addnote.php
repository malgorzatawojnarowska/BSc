<?php

  session_start();

  $nazwiskoPracownika = $_SESSION['nazwisko'];
  $imiePracownika = $_SESSION['imie'];

  if(!isset($_SESSION['zalogowany'])){
    header('Location: logowanie.php');
    exit();
  }


    if(isset($_POST['tytul'])){

      //wczytanie danych
      $tytul = $_POST['tytul'];
      $data = $_POST['data'];
      $tresc = $_POST['tresc'];

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

          $pracownik = mysqli_query($polaczenie, "SELECT * FROM Pracownicy WHERE Imie='$imiePracownika' AND Nazwisko='$nazwiskoPracownika'");
          $prac = mysqli_fetch_array($pracownik);


          if($wszystko_ok == true){
            //wszystkie testy zaliczone, dodajemy klienta do bazy
            if($polaczenie->query("INSERT INTO Notatki VALUES(NULL, '$tytul', '$data', '$tresc', '".$prac['IdPracownika']."')")){
              $_SESSION['udanedodanienotatki'] = true;
              header("Location: dodanonotatke.php");
            }
            else{
              throw new Exception($polaczenie->error);
            }
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


    <form method="post">
      <div class="rectangle">

        <div class="tile8" style="width: 1160px;">

          <label>Tytuł<br/><input type="text" name="tytul"></label>
          <br/>Data<br/><input type="date" name="data" placeholder="YYYY-MM-DD"></label>
          <br/>Treść<br/><input type="text" name="tresc" style="width: 90%; height: 150px;"></label>


        </div>

        <button type="submit" class="tile9" style="margin:10px; width:1180px;">
            <i class="icon-note"></i>
            <br/>Stwórz notatkę
        </button>

      </div>
  </form>


    <div style="clear:both"></div>


    <div class="rectangle">
      Małgorzata Wojnarowska &copy; Wszelkie prawa zastrzeżone
    </div>

  </div>


</body>
</html>
