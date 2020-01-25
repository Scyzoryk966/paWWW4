<?php

session_start();

if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
{
    header('Location: serwis.php');
    exit();
}

?>


<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="stylesheet" type="text/css" href="css/style.css">
	<title>Lista zakupów- Rejestracja - paWWW4</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>

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
            <article class="col-xs-3"></article>
            <article class="col-xs-6 bg-light">

                <form action="zaloguj.php" method="post">
                    <?php
                    if(isset($_SESSION['blad'])){
                        echo $_SESSION['blad']."<br>";
                        unset($_SESSION['blad']);
                    }
                    ?>
                    Login: <br /> <input type="text" name="login" /> <br />
                    Hasło: <br /> <input type="password" name="haslo" /> <br /><br />
                    <input type="submit" class="button" value="Zaloguj się" />

                </form>
                <p style="font-size: 11px;">Nie masz konta? - <a href="rejestracja.php">Rejestracja</a></p>
            </article>
            <article class="col-sx-3"></article>
        </section>
    </section>
    <!-- /.row -->

    <hr>

    <section class="container">
        <section class="row text-center">

            <section class="col-xs-12">
                <h1 class="hshadow">Co oferujemy?</h1>
            </section>

            <article class="col-xs-12 col-md-4">
                <img class="image image--circle image--center" src="img/list.jpg" alt="">
                <article class="bg-light" style="padding:10px; margin-top: 2%;">
                    <h2>Tworzenie własnych list</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut vulputate non quam lobortis condimentum. Nam maximus ligula ut dictum pharetra. Aenean ac nibh ultrices purus molestie elementum.</p>
                </article>
            </article>
            <article class="col-xs-12 col-md-4">
                <img class="image image--circle image--center" src="img/email.jpg" alt="">
                <article class="bg-light" style="padding:10px; margin-top: 2%;">
                    <h2>Wysyłanie listy na e-mail!</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut vulputate non quam lobortis condimentum. Nam maximus ligula ut dictum pharetra. Aenean ac nibh ultrices purus molestie elementum. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </article>
            </article>
            <article class="col-xs-12 col-md-4">
                <img class="image image--circle image--center" src="img/every.jpg " alt="">
                <article class="bg-light" style="padding:10px; margin-top: 2%;">
                    <h2>Dostęp w każdym miejscu poprzez przeglądarkę!</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut vulputate non quam lobortis condimentum. Nam maximus ligula ut dictum pharetra.</p>
                </article>
            </article>
        </section>
        <!-- /.row -->
    </section>
    <!-- /.container -->
    <footer class="footer">Damian Szefler &copy 2020</footer>
</body>
</html>