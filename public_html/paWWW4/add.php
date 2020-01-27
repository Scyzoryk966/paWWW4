<?php

session_start();

if (!isset($_SESSION['zalogowany']))
{
    header('Location: login.php');
    exit();
}

require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);
    try {
    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
        if ($polaczenie->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        }
        else {
            $id = $_SESSION['id'];
            $nazwa = $_POST['nazwa'];
            $ilosc = $_POST['ilosc'];
            $cena = $_POST['cena'];
            if ($polaczenie->query("INSERT INTO lista(id_user, opis, ilosc, cena) VALUES ('$id', '$nazwa', '$ilosc', '$cena')"))
            {
                header('Location: serwis.php');
                echo "działa";
            }
            else
            {
                throw new Exception($polaczenie->error);
            }
        }
    }
    catch(Exception $e)
    {
        echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o powrót w innym terminie!</span>';
        echo '<br />Informacja developerska: '.$e;
    }

$polaczenie->close();


