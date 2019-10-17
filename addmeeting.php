
<?php

  session_start();

  $nazwiskoPracownika = $_SESSION['nazwisko'];
  $imiePracownika = $_SESSION['imie'];

  if(!isset($_SESSION['zalogowany'])){
    header('Location: logowanie.php');
    exit();
  }

  if(isset($_POST['email'])){

    //wczytanie danych
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $firma = $_POST['firma'];
    $email = $_POST['email'];

    //Udana walidacja
    $wszystko_ok = true;

    //Poprawnosc email
    $email = $_POST['email'];
    $email_safe = filter_var($email, FILTER_SANITIZE_EMAIL);
    if(!filter_var($email_safe, FILTER_VALIDATE_EMAIL) || $email_safe != $email){
      $wszystko_ok = false;
      $_SESSION['e_email'] = "Podaj poprawny adres e-mail";
    }

    //łączenie się z bazą danych
    require_once "connect.php";

    mysqli_report(MYSQLI_REPORT_STRICT);
    try{
      $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

      if($polaczenie->connect_errno!=0){
        throw new Exception(mysqli_connect_errno());
      }
      else{
        //czy email istnieje

        $rezultat = $polaczenie->query("SELECT IdKlienta FROM Klienci WHERE Email='$email'");

        if(!$rezultat) throw new Exception($polaczenie->error);

        if($rezultat->num_rows > 0){
          $wszystko_ok = false;
          $_SESSION['e_email'] = "Istnieje już konto z takim adresem e-mail!";
        }

        if($wszystko_ok == true){
          //wszystkie testy zaliczone, dodajemy klienta do bazy

          if($polaczenie->query("INSERT INTO Klienci VALUES(NULL, '$imie', '$nazwisko', '$firma', '$email')")){
            $_SESSION['udanedodanieklienta'] = true;
            header("Location: dodanoklienta.php");
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

  if(isset($_POST['tytul'])){

    //wczytanie danych
    $tytul = $_POST['tytul'];
    $klient = $_POST['klienci'];
    $data = $_POST['data'];
    $godzina = $_POST['czas'];

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

        $idklienta = mysqli_query($polaczenie, "SELECT * FROM Klienci WHERE Email='$klient'");
        $kli = mysqli_fetch_array($idklienta);

        if($wszystko_ok == true){
          //wszystkie testy zaliczone, dodajemy klienta do bazy
          if($polaczenie->query("INSERT INTO Spotkania VALUES(NULL, '$tytul', '$data', '$godzina', '".$prac['IdPracownika']."', '".$kli['IdKlienta']."')")){
            $_SESSION['udanedodaniespotkania'] = true;
            header("Location: dodanospotkanie.php");
          }
          else{
            throw new Exception($polaczenie->error);
          }
        }

        $polaczenie->close();
      }


    }
    catch(Exception $e){
      echo '<div class="error">Błąd serwera2!</div>';
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

    <!-- dodawanie spotkania -->
    <form method="post">

      <div class="square">

        <div class="tile6">
          <label>Tytuł<br/><input type="text" name="tytul"></label>

          <br/>Klient<br/>

            <?php
              require_once "connect.php";

              mysqli_report(MYSQLI_REPORT_STRICT);
              try{
                $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
                if($polaczenie->connect_errno!=0){
                  throw new Exception(mysqli_connect_errno());
                }
                else{
                  $sql = $polaczenie->query("SELECT Email FROM Klienci");
                  echo '<select name="klienci">';
                  while($row = mysqli_fetch_array($sql))
                    echo '<option>' . $row['Email'] . '</option>';
                  echo '</select>';
                }
              }
              catch(Exception $e){
                echo '<div class="error">Błąd serwera!</div>';
              }

            ?>


          <br/>Data<br/><input type="date" name="data" placeholder="YYYY-MM-DD"></label>
          <br/>Godzina<br/><input type="time" name="czas" placeholder="HH:MM"></label>
        </div>

        <button type="submit" class="tile7" style="margin:10px;">
            <i class="icon-meeting"></i>
            <br/>Stwórz spotkanie
        </button>

      </div>

    </form>

    <!-- dodawanie klienta -->
    <form method="post">

      <div class="square">
        <div class="tile6">
          Imię<br/><input type="text" name="imie"></label>
          <br/>Nazwisko<br/><input type="text" name="nazwisko"></label>
          <br/>Firma<br/><input type="text" name="firma"></label>
          <br/>Adres e-mail<br/><input type="text" name="email"></label>
          <?php
            if(isset($_SESSION['e_email'])){
              echo '<div class="error">'.$_SESSION['e_email'].'</div>';
              unset($_SESSION['e_email']);
            }
          ?>
        </div>

        <button type="submit" class="tile7" style="margin:10px;">
            <i class="icon-meeting"></i>
            <br/>Stwórz klienta
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
