<?php

  session_start();

  if(!isset($_SESSION['zalogowany'])){
    header('Location: logowanie.php');
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
  <style>
    a{
      text-decoration: none;
      color:black;
    }
  </style>

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
        <?php $data = new DateTime($_SESSION['wybranadata']);?>
        <h4>&lt <?php echo $data->format('d-m-Y');?> &gt</h4>
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



              $sql = $polaczenie->query("SELECT * FROM Spotkania WHERE IdPracownika='".$prac['IdPracownika']."'
                AND MONTH(Data)='".$data->format('m')."' AND DAY(Data)='".$data->format('d')."' AND YEAR(Data)='".$data->format('Y')."'");
              while($row = mysqli_fetch_array($sql))
                echo '<a href="dayspotkaniepokaz.php?n1='.$row['IdSpotkania'].'">'.$row['Godzina'].' '.$row['Tytul'].'</a><br/>';
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
        <h4 style="margin: 10px">Notatki</h4>
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



              $sql = $polaczenie->query("SELECT * FROM Notatki WHERE IdPracownika='".$prac['IdPracownika']."'
                AND MONTH(Data)='".$data->format('m')."' AND DAY(Data)='".$data->format('d')."' AND YEAR(Data)='".$data->format('Y')."'");
              while($row = mysqli_fetch_array($sql))
                echo '<a href="daypokaz.php?n1='.$row['IdNotatki'].'">'.$row['Data'].' '.$row['Tytul'].'</a><br/>';
            }
          }
          catch(Exception $e){
            echo '<div class="error">Błąd serwera!</div>';
          }

        ?>
      </div>

      <a href="addnote.php" class="tilelink">
        <div class="tile7">
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
