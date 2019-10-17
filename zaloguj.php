<?php

  session_start();

  if(!isset($_POST['login']) || !isset($_POST['haslo'])){
    header('Location: logowanie.php');
    exit();
  }

  require_once "connect.php";

  $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

  if($polaczenie->connect_errno!=0){
    echo "Error: ".$polaczenie->connect_errno;
  }

  else{
    $login = $_POST['login'];
    $haslo= $_POST['haslo'];

    /*Encje html
    $login = htmlentities($login, END_QUOTES, "UTF-8");
    $haslo = htmlentities($haslo, END_QUOTES, "UTF-8");*/

    if($rezultat = $polaczenie->query(sprintf("SELECT * FROM Pracownicy WHERE Email='%s' || Login='%s'", mysqli_real_escape_string($polaczenie, $login), mysqli_real_escape_string($polaczenie, $login)))){

      if($rezultat->num_rows > 0){

        $wiersz = $rezultat->fetch_assoc();

          if(password_verify($haslo, $wiersz['Haslo'])){

          $_SESSION['zalogowany'] = true;


          $_SESSION['id'] = $wiersz['IdPracownika'];
          $_SESSION['imie'] = $wiersz['Imie'];
          $_SESSION['nazwisko'] = $wiersz['Nazwisko'];
          unset($_SESSION['blad']);


          $rezultat->close();
          header('Location: indexzalogowany.php');
          }
          else{
            $_SESSION['blad'] = '<span style="color: red">Nieprawidłowy login lub hasło!</span>';
            header('Location: logowanie.php');
          }

      }
      else{

        $_SESSION['blad'] = '<span style="color: red">Nieprawidłowy login lub hasło!</span>';
        header('Location: logowanie.php');


      }

    }

    $polaczenie->close();
  }

?>
