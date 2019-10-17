<?php

  session_start();

  if(!isset($_SESSION['zalogowany'])){
    header('Location: logowanie.php');
    exit();
  }

  $idnotatki=$_GET['n1'];
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

    <div class="square">

      <div class="tile6">
        <h4>&lt 01 grudzień 2018 &gt</h4>
        <?php
          require_once "connect.php";

          mysqli_report(MYSQLI_REPORT_STRICT);
          try{
            $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
            if($polaczenie->connect_errno!=0){
              throw new Exception(mysqli_connect_errno());
            }
            else{

              $pracownik = mysqli_query($polaczenie, "SELECT * FROM Pracownicy WHERE Imie='".$_SESSION['imie']."' AND Nazwisko='".$_SESSION['nazwisko']."'");
              $prac = mysqli_fetch_array($pracownik);



              $sql = $polaczenie->query("SELECT * FROM Spotkania WHERE IdPracownika='".$prac['IdPracownika']."' AND MONTH(Data)='12' AND DAY(Data)='1' AND YEAR(Data)='2018'");
              while($row = mysqli_fetch_array($sql))
                echo $row['Data'] . ' ' . $row['Tytul'] . '<br/>';
            }
          }
          catch(Exception $e){
            echo '<div class="error">Błąd serwera!</div>';
          }

        ?>
      </div>

      <a href="addmeeting.php" class="tilelink">
        <div class="tile7">
          <i class="icon-meeting"></i>
          <br/>Dodaj spotkanie
        </div>
      </a>

    </div>

    <div class="square">
      <div class="tile6">
          <a href="day.php"><h4>Powrót</h4></a>
        <?php
          require_once "connect.php";

          mysqli_report(MYSQLI_REPORT_STRICT);
          try{
            $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
            if($polaczenie->connect_errno!=0){
              throw new Exception(mysqli_connect_errno());
            }
            else{



              $sql = $polaczenie->query("SELECT * FROM Notatki WHERE IdNotatki='$idnotatki'");
              while($row = mysqli_fetch_array($sql))
                echo '<h4>'.$row['Tytul'].'</h4> ' . $row['Tresc'] . '<br/>';
            }
          }
          catch(Exception $e){
            echo '<div class="error">Błąd serwera!</div>';
          }

        ?>
      </div>

      <a href="editnote.php?n1=<?= $idnotatki?>" class="tilelink">
        <div class="tile7">
          <i class="icon-note"></i>
          <br/>Edytuj notatkę
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
