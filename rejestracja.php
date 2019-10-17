<?php

  session_start();

  if(isset($_POST['email'])){

    //wczytanie danych
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $stanowisko = $_POST['stanowisko'];

    //Udana walidacja
    $wszystko_ok = true;

    //Poprawność loginu
    $login = $_POST['login'];
    //Sprawdzenie długości loginu
    if(strlen($login)<3 || strlen($login)>20){
      $wszystko_ok = false;
      $_SESSION['e_login'] = "Login musi mieć od 3 do 20 znaków!";
    }
    //login bez znakow polskich, tylko alfanumeryczne
    if(!ctype_alnum($login)){
      $wszystko_ok = false;
      $_SESSION['e_login'] = "Login moze skladać się tylko z liter i cyfr, bez polskich znaków!";
    }

    //Poprawnosc email
    $email = $_POST['email'];
    $email_safe = filter_var($email, FILTER_SANITIZE_EMAIL);
    if(!filter_var($email_safe, FILTER_VALIDATE_EMAIL) || $email_safe != $email){
      $wszystko_ok = false;
      $_SESSION['e_email'] = "Podaj poprawny adres e-mail";
    }

    //Poprawność hasła
    $haslo = $_POST['haslo'];
    $haslo2 = $_POST['haslo2'];
    //Długość hasła
    if(strlen($login)<3 || strlen($login)>20){
      $wszystko_ok = false;
      $_SESSION['e_haslo'] = "Hasło musi mieć od 3 do 20 znaków!";
    }
    //Identyczne hasła
    if($haslo != $haslo2){
      $wszystko_ok = false;
      $_SESSION['e_haslo'] = "Podane hasła nie są identyczne!";
    }
    //haszowanie
    $haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);

    //regulamin
    if(!isset($_POST['regulamin'])){
      $wszystko_ok = false;
      $_SESSION['e_regulamin'] = "Zaakceptuj regulamin!";
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
        $rezultat = $polaczenie->query("SELECT IdPracownika FROM Pracownicy WHERE Email='$email'");

        if(!$rezultat) throw new Exception($polaczenie->error);

        if($rezultat->num_rows > 0){
          $wszystko_ok = false;
          $_SESSION['e_email'] = "Istnieje już konto z takim adresem e-mail!";
        }

        //czy login istnieje
        $rezultat = $polaczenie->query("SELECT IdPracownika FROM Pracownicy WHERE Login='$login'");

        if(!$rezultat) throw new Exception($polaczenie->error);

        if($rezultat->num_rows > 0){
          $wszystko_ok = false;
          $_SESSION['e_login'] = "Istnieje już konto z takim loginem!";
        }


        if($wszystko_ok == true){
          //wszystkie testy zaliczone, dodajemy użytkownika do bazy
          if($polaczenie->query("INSERT INTO Pracownicy VALUES(NULL, '$imie', '$nazwisko', '$login', '$stanowisko', '$email', '$haslo_hash')")){
            $_SESSION['udanarejestracja'] = true;
            header("Location: witamy.php");
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

      <!--
      <div id="login">Jan Kowalski</div>
    -->
      <div style="clear:both"></div>
    </div>

    <div class="rectangle" style="width: 1180px; margin: 10px;">

      <form method="post">

        <div class="square2">
            Imię<br/><input type="text" name="imie">
            <br/>Nazwisko<br/><input type="text" name="nazwisko">
            <br/>Stanowisko<br/><input type="text" name="stanowisko">
            <br/>Login<br/><input type="text" name="login">
            <?php
              if(isset($_SESSION['e_login'])){
                echo '<div class="error">'.$_SESSION['e_login'].'</div>';
                unset($_SESSION['e_login']);
              }
            ?>

        </div>

        <div class="square2">
            Adres e-mail<br/><input type="text" name="email">
            <?php
              if(isset($_SESSION['e_email'])){
                echo '<div class="error">'.$_SESSION['e_email'].'</div>';
                unset($_SESSION['e_email']);
              }
            ?>

            <br/>Hasło<br/><input type="password" name="haslo">
            <br/>Powtórz hasło<br/><input type="password" name="haslo2">
            <?php
              if(isset($_SESSION['e_haslo'])){
                echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
                unset($_SESSION['e_haslo']);
              }
            ?>

            <br/><label><input type="checkbox" name="regulamin"/> Akceptuję regulamin</label>
            <?php
              if(isset($_SESSION['e_regulamin'])){
                echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
                unset($_SESSION['e_regulamin']);
              }
            ?>

        </div>

        <div style="clear:both"></div>

        <button type="submit" class="tile11">
            <i class="icon-meeting"></i>
            <br/>Zarejestruj się
        </button>

      </form>

    </div>


    <div style="clear:both"></div>


    <div class="rectangle">
      Małgorzata Wojnarowska &copy; Wszelkie prawa zastrzeżone
    </div>

  </div>


</body>
</html>
