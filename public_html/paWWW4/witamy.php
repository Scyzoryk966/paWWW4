<?php

	session_start();
	
	if (!isset($_SESSION['udanarejestracja']))
	{
		header('Location: index.php');
		exit();
	}
	else
	{
		unset($_SESSION['udanarejestracja']);
	}
	
	//Usuwanie zmiennych pamiętających wartości wpisane do formularza
	if (isset($_SESSION['fr_nick'])) unset($_SESSION['fr_nick']);
	if (isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
	if (isset($_SESSION['fr_haslo1'])) unset($_SESSION['fr_haslo1']);
	if (isset($_SESSION['fr_haslo2'])) unset($_SESSION['fr_haslo2']);
	if (isset($_SESSION['fr_regulamin'])) unset($_SESSION['fr_regulamin']);
	
	//Usuwanie błędów rejestracji
	if (isset($_SESSION['e_nick'])) unset($_SESSION['e_nick']);
	if (isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
	if (isset($_SESSION['e_haslo'])) unset($_SESSION['e_haslo']);
	if (isset($_SESSION['e_regulamin'])) unset($_SESSION['e_regulamin']);

	
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
            <p>Dziękujemy za rejestracje, możesz sie już zalogować na swoje konto!</p>
            <button class="button" onclick="window.location.href = 'login.php'">Zaloguj się!</button>
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