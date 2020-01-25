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
        $list_id =  $_POST['delBtn'];

        if ($polaczenie->query("DELETE FROM `lista` WHERE id='$list_id'"))
        {
            header('Location: serwis.php');
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