<?php

session_start();
$_PHP_SELF = &$_SERVER['PHP_SELF'];
if (!isset($_SESSION['zalogowany']))
{
    header('Location: login.php');
    exit();
}

?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Lista zakupów - paWWW4</title>
</head>

<body>

<!-- Header -->
<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 hero">
                <h1 style="font-size: 5em">Lista zakupów Online</h1>
            </div>
        </div>
    </div>
</header>

<!-- Page Content -->
<section class="container">
    <section class="row" style="margin-top: 2%;">
        <article class="col-xs-12 col-md-8 bg-light">
            <h1>Edytuj rekord:</h1>
            <table>
                <tr>
                    <th style="width: 50%;">Nazwa:</th>
                    <th style="width: 10%;">Ilość:</th>
                    <th style="width: 10%;">Cena:</th>
                    <th style="text-align: right; width: 30%">Akcje:</th>
                </tr>
                <?php
                require_once "connect.php";
                mysqli_report(MYSQLI_REPORT_STRICT);
                try {
                    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
                    if ($polaczenie->connect_errno != 0) {
                        throw new Exception(mysqli_connect_errno());
                    } else {
                        $id_list = $_POST['editBtn'];
                        $id = $_SESSION['id'];

                        if ($result = $polaczenie -> query("SELECT * FROM lista WHERE id_user='$id' ORDER BY id ASC")) {
                            while ($row = $result -> fetch_row()) {
                                if($row[0]==$id_list)
                                {
                                    echo "<tr><form action = '$_PHP_SELF' method = 'GET'>
                                            <input type='text' name='id_list' value='$id_list' hidden>
                                            <td><input type='text' name='nazwa' value='$row[2]'></td>
                                            <td><input type='text' name='ilosc' value='$row[3]'></td>
                                            <td><input type='text' name='cena' value='$row[4]'></td>
                                            <td><button class='button' type='submit' style='float: right;'>Zmień</button></td>
                                            </form></tr>";
                                }
                            }
                             if( $_GET["nazwa"] && $_GET["ilosc"] && $_GET["cena"] && $_GET["id_list"]) {
                                 $id_list = $_GET["id_list"];
                                 $nazwa = $_GET["nazwa"];
                                 $ilosc = $_GET["ilosc"];
                                 $cena = $_GET["cena"];
                                 if ($polaczenie->query("UPDATE lista SET opis='$nazwa', ilosc='$ilosc', cena='$cena' WHERE id='$id_list' AND id_user='$id'"))
                                 {
                                     header('Location: serwis.php');
                                 }
                                 else
                                 {
                                     throw new Exception($polaczenie->error);
                                 }
                             }
                        }
                        else{
                            echo "Błąd!!!";
                        }
                        $result -> free_result();

                    }

                }
                catch(Exception $e)
                {
                    echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o powrót w innym terminie!</span>';
                    echo '<br />Informacja developerska: '.$e;
                }
                ?>

            </table>
        </article>
        <article class="col-xs-12 col-md-4 bg-light">
            <article>
                <?php
                echo "<h2>Witaj ".$_SESSION['user'].'!</h2>';
                echo "<p>E-mail: ".$_SESSION['email'];
                ?>
                <br><br>
                <button class="button" onclick="window.location.href = 'logout.php'">Wyloguj się</button>
            </article>
        </article>
    </section>
</section>
<!-- /.row -->

<!-- /.container -->
<footer class="footer">Damian Szefler &copy 2020</footer>
<?php
$polaczenie->close();
?>
</body>
</html>