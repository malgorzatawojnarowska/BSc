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
  td{
  	width: 100px;
  	height: 50px;
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
        <h4 style="margin: 10px">&lt 2018 &gt</h4>
        <center>
        <table cellpadding="10">
    			<thead><tr height="30">
    				<td>Styczeń</td>	<td>Luty</td> <td>Marzec</td>
    			</tr></thead>
    			<tbody><tr>
    				<td>Kwiecień</td> <td>Maj</td> <td>Czerwiec</td>
    			</tr>
          <tr>
    				<td>Lipiec</td>	<td>Sierpień</td> <td>Wrzesień</td>
    			</tr>
    			<tr>
    				<td>Październik</td> <td>Listopad</td> <td>Grudzień</td>
    			</tr></tbody>
    		</table></center>
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



              $sql = $polaczenie->query("SELECT * FROM Notatki WHERE IdPracownika='".$prac['IdPracownika']."' AND YEAR(Data)='2018'");
              while($row = mysqli_fetch_array($sql))
                echo '<a href="yearpokaz.php?n1='.$row['IdNotatki'].'">'.$row['Data'].' '.$row['Tytul'].'</a><br/>';
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
