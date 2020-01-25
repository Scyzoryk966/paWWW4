<?php

	session_start();
	
	if (isset($_POST['email']))
	{
		//Udana walidacja? Załóżmy, że tak!
		$wszystko_OK=true;
		
		//Sprawdź poprawność nickname'a
		$nick = $_POST['nick'];
		
		//Sprawdzenie długości nicka
		if ((strlen($nick)<3) || (strlen($nick)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_nick']="Nick musi posiadać od 3 do 20 znaków!";
		}
		
		if (ctype_alnum($nick)==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_nick']="Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
		
		// Sprawdź poprawność adresu email
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$wszystko_OK=false;
			$_SESSION['e_email']="Podaj poprawny adres e-mail!";
		}
		
		//Sprawdź poprawność hasła
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		
		if ((strlen($haslo1)<8) || (strlen($haslo1)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków!";
		}
		
		if ($haslo1!=$haslo2)
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Podane hasła nie są identyczne!";
		}	

		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
		
		//Czy zaakceptowano regulamin?
		if (!isset($_POST['regulamin']))
		{
			$wszystko_OK=false;
			$_SESSION['e_regulamin']="Potwierdź akceptację regulaminu!";
		}				
		
		//Bot or not? Oto jest pytanie!

		
		//Zapamiętaj wprowadzone dane
		$_SESSION['fr_nick'] = $nick;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_haslo1'] = $haslo1;
		$_SESSION['fr_haslo2'] = $haslo2;
		if (isset($_POST['regulamin'])) $_SESSION['fr_regulamin'] = true;
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try 
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				//Czy email już istnieje?
				$rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$email'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_maili = $rezultat->num_rows;
				if($ile_takich_maili>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
				}		

				//Czy nick jest już zarezerwowany?
				$rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE user='$nick'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_nickow = $rezultat->num_rows;
				if($ile_takich_nickow>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_nick']="Istnieje już użytkow o takim nicku! Wybierz inny.";
				}
				
				if ($wszystko_OK==true)
				{
					//Hurra, wszystkie testy zaliczone, dodajemy klienta do bazy
					
					if ($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL, '$nick', '$haslo_hash', '$email')"))
					{
						$_SESSION['udanarejestracja']=true;
						header('Location: witamy.php');
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
					
				}
				
				$polaczenie->close();
			}
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
			echo '<br />Informacja developerska: '.$e;
		}
		
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

                <form method="post">

                    Nickname: <br /> <input type="text" value="<?php
                    if (isset($_SESSION['fr_nick']))
                    {
                        echo $_SESSION['fr_nick'];
                        unset($_SESSION['fr_nick']);
                    }
                    ?>" name="nick" /><br />

                    <?php
                    if (isset($_SESSION['e_nick']))
                    {
                        echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
                        unset($_SESSION['e_nick']);
                    }
                    ?>

                    E-mail: <br /> <input type="text" value="<?php
                    if (isset($_SESSION['fr_email']))
                    {
                        echo $_SESSION['fr_email'];
                        unset($_SESSION['fr_email']);
                    }
                    ?>" name="email" /><br />

                    <?php
                    if (isset($_SESSION['e_email']))
                    {
                        echo '<div class="error">'.$_SESSION['e_email'].'</div>';
                        unset($_SESSION['e_email']);
                    }
                    ?>

                    Twoje hasło: <br /> <input type="password" value="<?php
                    if (isset($_SESSION['fr_haslo1']))
                    {
                        echo $_SESSION['fr_haslo1'];
                        unset($_SESSION['fr_haslo1']);
                    }
                    ?>" name="haslo1" /><br />

                    <?php
                    if (isset($_SESSION['e_haslo']))
                    {
                        echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
                        unset($_SESSION['e_haslo']);
                    }
                    ?>

                    Powtórz hasło: <br /> <input type="password" value="<?php
                    if (isset($_SESSION['fr_haslo2']))
                    {
                        echo $_SESSION['fr_haslo2'];
                        unset($_SESSION['fr_haslo2']);
                    }
                    ?>" name="haslo2" /><br />

                    <label>
                        <input type="checkbox" name="regulamin" <?php
                        if (isset($_SESSION['fr_regulamin']))
                        {
                            echo "checked";
                            unset($_SESSION['fr_regulamin']);
                        }
                        ?>/> Akceptuję regulamin
                    </label>

                    <?php
                    if (isset($_SESSION['e_regulamin']))
                    {
                        echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
                        unset($_SESSION['e_regulamin']);
                    }
                    ?>

                    <div class="g-recaptcha" data-sitekey="6LeoLtIUAAAAAHAB2quIp-gy8PzzjyJH2_PH6vK4"></div>

                    <?php
                    if (isset($_SESSION['e_bot']))
                    {
                        echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
                        unset($_SESSION['e_bot']);
                    }
                    ?>

                    <br />

                    <input type="submit" class = "button" value="Zarejestruj się" />
                    <input type="button" class = "button" style="border-color: crimson; color: crimson; float: right;" onclick="window.location.href = 'index.php'" value="Powrót" />

                </form>
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