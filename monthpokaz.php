<?php

  session_start();

  if(!isset($_SESSION['zalogowany'])){
    header('Location: logowanie.php');
    exit();
  }

  date_default_timezone_set('Europe/Berlin');

  if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
  } else {
      $ym = date('Y-m');
  }

  // Check format
  $timestamp = strtotime($ym . '-01');  // the first day of the month
  if ($timestamp === false) {
      $ym = date('Y-m');
      $timestamp = strtotime($ym . '-01');
  }
  // Today (Format:2018-08-8)
  $today = date('Y-m-j');
  // Title (Format:August, 2018)
  $title = date('F, Y', $timestamp);
  // Create prev & next month link
  $prev = date('Y-m', strtotime('-1 month', $timestamp));
  $next = date('Y-m', strtotime('+1 month', $timestamp));
  // Number of days in the month
  $day_count = date('t', $timestamp);
  // 1:Mon 2:Tue 3: Wed ... 7:Sun
  $str = date('N', $timestamp);
  // Array for calendar
  $weeks = [];
  $week = '';
  // Add empty cell(s)
  $week .= str_repeat('<td></td>', $str - 1);
  for ($day = 1; $day <= $day_count; $day++, $str++) {
      $date = $ym . '-' . $day;
      if ($today == $date) {
          $week .= '<td class="today">';

      } else {
          $week .= '<td>';
      }
      $y = date('Y', $timestamp);
      $m = date('m', $timestamp);
      $week .= '<a href="month.php?dzien='.$day.'&miesiac='.date('m', $timestamp).'&rok='.date('Y', $timestamp).'&yes=1">' . $day . '</a></td>';
      // Sunday OR last day of the month
      if ($str % 7 == 0 || $day == $day_count) {
          // last day of the month
          if ($day == $day_count && $str % 7 != 0) {
              // Add empty cell(s)
              $week .= str_repeat('<td></td>', 7 - $str % 7);
          }
          $weeks[] = '<tr>' . $week . '</tr>';
          $week = '';
      }
  }

  if(isset($_GET['yes']))
    if($_GET['yes'] == '1'){
      $_SESSION['wybranadata'] = date("Y-m-j", mktime(0,0,0, $_GET['miesiac'], $_GET['dzien'], $_GET['rok']));
      //$test = $_SESSION['wybranadata'];
      //echo $test;

      header('Location: day.php');
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
    th:nth-of-type(6), td:nth-of-type(6){
      color: blue;
    }
    th:nth-of-type(7), td:nth-of-type(7){
      color: red;
    }
    .today{
      background-color: ghostwhite;
    }

    a{
      text-decoration: none;
      color:black;
    }

    /*Nieodwiedzony link*/
    a:link{
      color: black;
    }

    /*Odwiedzony link*/
    a:visited{
      color: black;
    }

    /*Link po najechaniu kursorem*/
    a:hover{
      color: black;
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
        <h4 style="margin: 10px">
          <a href="?ym=<?= $prev; ?>">&lt</a>
          <?= $title; ?>
          <a href="?ym=<?= $next; ?>">&gt</a>
        </h4>
        <center>
        <table cellpadding="10">
    			<thead>
            <tr height="30">
    				      <td>Pn</td>	<td>Wt</td> <td>Śr</td> <td>Czw</td> <td>Pt</td> <td>Sb</td> <td>Ndz</td>
    			  </tr>
          </thead>
    			<tbody>
            <?php
                    foreach ($weeks as $week) {
                        echo $week;
                    }
                ?>
          </tbody>
    		</table></center>

      </div>

      <a href="addmeeting.php" style="color:white">
        <div class="tile7">
          <i class="icon-meeting"></i>
          <br/>Dodaj spotkanie
        </div>
      </a>

    </div>

    <div class="square">
      <div class="tile6">
        <a href="month.php"><h4>Powrót</h4></a>
        <?php
          require_once "connect.php";

          mysqli_report(MYSQLI_REPORT_STRICT);
          try{
            $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
            if($polaczenie->connect_errno!=0){
              throw new Exception(mysqli_connect_errno());
            }
            else{
              $idnotatki=$_GET['n1'];
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

      <a href="editnote.php" style="color:white">
        <div class="tile7">
          <i class="icon-notes"></i>
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
