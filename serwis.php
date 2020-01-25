<?php

	session_start();
	
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
            <h1>Towja zapisana lista zakupów:</h1>
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

                    $id = $_SESSION['id'];

                    if ($result = $polaczenie -> query("SELECT * FROM lista WHERE id_user='$id' ORDER BY id ASC")) {
                        while ($row = $result -> fetch_row()) {
                            echo "<td>" . $row[2] . "</td><td>". $row[3] . "</td><td>". $row[4];
                            echo "<form method=\"POST\" action=\"edit.php\">";
                            echo "</td><td><button type='submit' name='editBtn' class='button' value='$row[0]' style='float: right;'>Edytuj</button>";
                            echo "</form><form method=\"POST\" action=\"del.php\">";
                            echo "<button type='submit' name='delBtn' class='button' value='$row[0]' style='float: right; border-color: crimson; color: crimson;'>Usuń</button></td></tr>";
                            echo "</form>";
                        }}
                        else{
                            echo "Brak zaisanej listy.";
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
                <tr>
                    <form method="POST" action="add.php">
                        <td><input type="text" name="nazwa" placeholder="Nazwa"></td>
                        <td><input type="text" name="ilosc" placeholder="Ilość"></td>
                        <td><input type="text" name="cena" placeholder="Cena"></td>
                        <td><button class="button" type="submit" style="float: right;">Dodaj</button></td>
                    </form>
                </tr>
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