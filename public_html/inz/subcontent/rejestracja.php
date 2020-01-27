<?php
session_start();
if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: ../index.php');
		exit();
	}
	if (isset($_POST['email']))
    	{
    	//Udana walidacja? Załóżmy, że tak!
        		$wszystko_OK=true;
    	//czy email poprawny
    	$email = $_POST['email'];

    	$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

        		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
        		{
        			$wszystko_OK=false;
        			$_SESSION['e_email']="Podaj poprawny adres e-mail!";
        		}
        //czy login jest OK
        $login = $_POST['login'];

        		if ((strlen($login)<3) || (strlen($login)>20))
        		{
        			$wszystko_OK=false;
        			$_SESSION['e_login']="Login musi posiadać od 3 do 20 znaków!";
        		}

        		if (ctype_alnum($login)==false)
        		{
        			$wszystko_OK=false;
        			$_SESSION['e_login']="Login może składać się tylko z liter i cyfr (bez polskich znaków)";
        		}
        //czy haslo jest ok
        $haslo = $_POST['password'];
        if ((strlen($haslo)<8) || (strlen($haslo)>20))
        		{
        			$wszystko_OK=false;
        			$_SESSION['e_password']="Hasło musi posiadać od 8 do 20 znaków!";
        		}
        //Czy telefon jest OK

        $telefon = $_POST['telefon'];
        if(!is_numeric($telefon))
            {
            $wszystko_OK=false;
            $_SESSION['e_telefon']="Telefon musi być liczbą !";
            }
         if($telefon<0)
            {
                 $wszystko_OK=false;
                  $_SESSION['e_telefon']="Telefon musi być liczbą nieujemna!";
            }

         //czy data urodzenia nie dzisiejsza
         $dataU = $_POST['dataU'];
         if($dataU == date("Y-m-d"))
            {
                 $wszystko_OK=false;
                 $_SESSION['e_dataU']="Data urodzenia nie może być dzisiejsza!";
            }
          if(empty($dataU))
          {
                 $wszystko_OK=false;
                 $_SESSION['e_dataU']="Data urodzenia nie może być pusta!";

          }
          //Czy pesel/nip jest liczba
          $nip = $_POST['NIP'];
          if(!is_numeric($nip))
            {
                $wszystko_OK=false;
                $_SESSION['e_nip']="NIP/PESEL musi być liczbą!";
             }
           if($nip<0)
            {
                $wszystko_OK=false;
                $_SESSION['e_nip']="NIP/PESEL musi być liczbą nieujemną!";
            }
            //imie sprawdz i nazwisko
            $imie = $_POST['imie'];
            $nazwisko = $_POST['nazwisko'];

            if(empty($imie))
            {
                $wszystko_OK=false;
                $_SESSION['e_imie']="Imie nie może być puste!";
            }
            if(empty($nazwisko))
            {
                 $wszystko_OK=false;
                 $_SESSION['e_nazwisko']="Nazwisko nie może być puste!";

            }


            $haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);

            $_SESSION['fr_email'] = $email;
            $_SESSION['fr_login'] = $login;
            $_SESSION['fr_haslo'] = $haslo;
            $_SESSION['fr_telefon'] = $telefon;
            $_SESSION['fr_dataU'] = $dataU;
            $_SESSION['fr_nip'] = $nip;
            $_SESSION['fr_imie'] = $imie;
            $_SESSION['fr_nazwisko'] = $nazwisko;
            $_SESSION['fr_ulica'] = $_POST['ulica'];
            $_SESSION['fr_numerD'] = $_POST['numerD'];
            $_SESSION['fr_numerM'] = $_POST['numerM'];
            $_SESSION['fr_miasto'] = $_POST['miasto'];
            $_SESSION['fr_kodP'] = $_POST['kodP'];

            require_once ("../php/connect.php");
            mysqli_report(MYSQLI_REPORT_STRICT);

            try{
                    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
                    if ($polaczenie->connect_errno!=0)
            			{
            				throw new Exception(mysqli_connect_errno());
            			}
            			else
            			{
            			    $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$email'");
            			    if (!$rezultat) throw new Exception($polaczenie->error);

                            $ile_takich_maili = $rezultat->num_rows;
                            if($ile_takich_maili>0)
                            {
                                $wszystko_OK=false;
                                $_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
                            }
                            //Czy nick jest już zarezerwowany?
                            $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE user='$login'");

                            if (!$rezultat) throw new Exception($polaczenie->error);

                            $ile_takich_nickow = $rezultat->num_rows;
                            if($ile_takich_nickow>0)
                            {
                                $wszystko_OK=false;
                                $_SESSION['e_login']="Istnieje już konto z takim nickiem! Wybierz inny.";
                            }
                            if ($wszystko_OK==true)
                            {
                                //Hurra, wszystkie testy zaliczone

                                if ($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL, '$login', '$haslo_hash', '$email', '$imie', '$nazwisko', '$nip', NULL)"))
                                {
                                    $_SESSION['udanarejestracja']=true;
                                    header('Location: witamy.php');
                                }
                                else
                                {
                                    throw new Exception($polaczenie->error);
                                }
                            }
            			}
            		}
            		catch(Exception $e)
            		{
            		    echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
                        			echo '<br />Informacja developerska: '.$e;
            		}
    	}
?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
		<link rel="stylesheet" href="../css/reset.css" type="text/css"/>
		<link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css"/>
		<link rel="stylesheet" href="../css/style.css" type="text/css"/>
		<link rel="shortcut icon" href="../img/logo-mini.png"/>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="Description" content="Strona z podstawami JavaScript zrobiona na zaliczenie.">
		<title>Kurier PostHub</title>
</head>
<body>
	<section class="main-content">
			<div class="container-fluid">
							<nav class="col-md-12 navbar navbar-expand-lg navbar-dark sticky-top">
									<a class="navbar-brand" href="#"><img class="img-fluid" alt="logo strony"
																		  title="Posthub"
																		   src="../img/logo.svg"></a>
									<ul class="navbar-nav mr-auto">
											<li class="nav-item active">
													<a class="nav-link" href="subcontent/page0.html">Strona główna</a>
											</li>
											<li class="nav-item">
													<a class="nav-link" href="subcontent/page1.html">Śledź paczkę</a>
											</li>
											<li class="nav-item">
													<a class="nav-link" href="/#">O nas</a>
											</li>
									</ul>
									<?php
                                        if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
                                        {
                                        echo "
                                        <div class='btn-group' style='margin-right: 30px;' >
                                        <form action='../php/logout.php' method='post'>
                                                <button type='submit' class='btn btn-light my-2 my-sm-0 btn-lg disabled'>
                                                        Wyloguj</button>
                                        </form>
                                        </div>";
                                        }
                                        else
                                        {
                                        echo "
                                        <div class='btn-group' style='margin-right: 30px;'>
                                        <form action='../subcontent/logowanie.php' method='post'>
                                                <button type='submit' class='btn btn-light my-2 my-sm-0 btn-lg disabled'>
                                                        Zaloguj</button>
                                        </form>
                                        </div>";
                                        }
                                        ?>
							</nav>
					<div class="container">
						<section id="dynamic">
									<div class="row">
											<div class="col-md-9">
													<div class="bg-light p-5 rounded-lg">
													<h1 class='mb-4'>Rejestracja</h1>
													<h2 class='mb-4'>Dane konta:</h2>
													<div class='row'>
													<div class='col-2'>
													</div>
													<div class='col-7'>
													<form action='rejestracja.php' method='post'>
													<label for='email'>Email: </label>
													<input type='email' id='email' name='email' class='form-control mb-2' value="<?php
                                                                                                                          			if (isset($_SESSION['fr_email']))
                                                                                                                          			{
                                                                                                                          				echo $_SESSION['fr_email'];
                                                                                                                          				unset($_SESSION['fr_email']);
                                                                                                                          			}
                                                                                                                          		?>"/>
                                                                                                                          		<?php
                                                                                                                                			if (isset($_SESSION['e_email']))
                                                                                                                                			{
                                                                                                                                				echo '<p class="text-danger">'.$_SESSION['e_email'].'</p>';
                                                                                                                                				unset($_SESSION['e_email']);
                                                                                                                                			}
                                                                                                                                			?>
													<label for='login'>Login: </label>
                                                    <input type='text' id='login' name='login' class='form-control mb-2' value="<?php
                                                                                                                                    if (isset($_SESSION['fr_login']))
                                                                                                                                    {
                                                                                                                                        echo $_SESSION['fr_login'];
                                                                                                                                        unset($_SESSION['fr_login']);
                                                                                                                                    }
                                                                                                                                ?>"/> <?php
                                                                                                                                     			if (isset($_SESSION['e_login']))
                                                                                                                                     			{
                                                                                                                                     				echo '<p class="text-danger">'.$_SESSION['e_login'].'</p>';
                                                                                                                                     				unset($_SESSION['e_login']);
                                                                                                                                     			}?>
                                                    <label for='password'>Hasło: </label>
                                                    <input type='password' id='password' name='password' class='form-control mb-2' value="<?php
                                                                                                                                   			if (isset($_SESSION['fr_haslo']))
                                                                                                                                   			{
                                                                                                                                   				echo $_SESSION['fr_haslo'];
                                                                                                                                   				unset($_SESSION['fr_haslo']);
                                                                                                                                   			}
                                                                                                                                   		?>"/>
                                                                                                                                   		<?php
                                                                                                                                        			if (isset($_SESSION['e_password']))
                                                                                                                                        			{
                                                                                                                                        				echo '<p class="text-danger">'.$_SESSION['e_password'].'</p>';
                                                                                                                                        				unset($_SESSION['e_password']);
                                                                                                                                        			}?>
                                                    <label for='telefon'>Telefon: </label>
                                                    <input type='number' id='telefon' name='telefon' class='form-control mb-2' value="<?php
                                                                                                                               			if (isset($_SESSION['fr_telefon']))
                                                                                                                               			{
                                                                                                                               				echo $_SESSION['fr_telefon'];
                                                                                                                               				unset($_SESSION['fr_telefon']);
                                                                                                                               			}
                                                                                                                               		?>"/>
                                                                                                                               		<?php
                                                                                                                                    			if (isset($_SESSION['e_telefon']))
                                                                                                                                    			{
                                                                                                                                    				echo '<p class="text-danger">'.$_SESSION['e_telefon'].'</p>';
                                                                                                                                    				unset($_SESSION['e_telefon']);
                                                                                                                                    			}?>
                                                    <label for='dataU'>Data urodzenia: </label>
                                                    <input type='date' id='dataU' name='dataU' class='form-control mb-2' value="<?php
                                                                                                                         			if (isset($_SESSION['fr_dataU']))
                                                                                                                         			{
                                                                                                                         				echo $_SESSION['fr_dataU'];
                                                                                                                         				unset($_SESSION['fr_dataU']);
                                                                                                                         			}
                                                                                                                         		?>"/><?php
                                                                                                                                     			if (isset($_SESSION['e_dataU']))
                                                                                                                                     			{
                                                                                                                                     				echo '<p class="text-danger">'.$_SESSION['e_dataU'].'</p>';
                                                                                                                                     				unset($_SESSION['e_dataU']);
                                                                                                                                     			}?>
                                                    <label for='NIP'>NIP/PESEL: </label>
                                                    <input type='number' id='NIP' name='NIP' class='form-control mb-2' value="<?php
                                                                                                                       			if (isset($_SESSION['fr_nip']))
                                                                                                                       			{
                                                                                                                       				echo $_SESSION['fr_nip'];
                                                                                                                       				unset($_SESSION['fr_nip']);
                                                                                                                       			}
                                                                                                                       		?>"/><?php
                                                                                                                                 			if (isset($_SESSION['e_nip']))
                                                                                                                                 			{
                                                                                                                                 				echo '<p class="text-danger">'.$_SESSION['e_nip'].'</p>';
                                                                                                                                 				unset($_SESSION['e_nip']);
                                                                                                                                 			}?>
													</div>
													</div>
													<h2>Twój adres:</h2>
													<div class='row'>
													<div class='col-2'>
													</div>
													<div class='col-7'>
                                                    <div class="row">
                                                        <div class="col">
													<label for='imie'>Imie: </label>
                                                          <input type="text" id='imie' name='imie' class="form-control mb-2" value="<?php
                                                                                                                                            if (isset($_SESSION['fr_imie']))
                                                                                                                                            {
                                                                                                                                                echo $_SESSION['fr_imie'];
                                                                                                                                                unset($_SESSION['fr_imie']);
                                                                                                                                            }
                                                                                                                                        ?>" ><?php
                                                                                                                                            if (isset($_SESSION['e_imie']))
                                                                                                                                            {
                                                                                                                                                echo '<p class="text-danger">'.$_SESSION['e_imie'].'</p>';
                                                                                                                                                unset($_SESSION['e_imie']);
                                                                                                                                            }?>
                                                        </div>
                                                        <div class="col">
													<label for='nazwisko'>Nazwisko: </label>
                                                          <input type="text" id='nazwisko' name='nazwisko' class="form-control mb-2" value="<?php
                                                                                                                                            if (isset($_SESSION['fr_nazwisko']))
                                                                                                                                            {
                                                                                                                                                echo $_SESSION['fr_nazwisko'];
                                                                                                                                                unset($_SESSION['fr_nazwisko']);
                                                                                                                                            }
                                                                                                                                        ?>"><?php
                                                                                                                                            if (isset($_SESSION['e_nazwisko']))
                                                                                                                                            {
                                                                                                                                                echo '<p class="text-danger">'.$_SESSION['e_nazwisko'].'</p>';
                                                                                                                                                unset($_SESSION['e_nazwisko']);
                                                                                                                                            }?>
                                                        </div>
                                                      </div>
                                                    <label for='ulica'>Ulica: </label>
                                                    <input type='text' id='ulica' name='ulica' class='form-control mb-2' value="<?php
                                                                                                                         			if (isset($_SESSION['fr_ulica']))
                                                                                                                         			{
                                                                                                                         				echo $_SESSION['fr_ulica'];
                                                                                                                         				unset($_SESSION['fr_ulica']);
                                                                                                                         			}
                                                                                                                         		?>"/>
                                                    <label for='numerD'>Numer domu: </label>
                                                    <div class="row">
                                                        <div class="col">
                                                          <input type="text" id='numerD' name='numerD' class="form-control mb-2" value="<?php
                                                                                                                                 			if (isset($_SESSION['fr_numerD']))
                                                                                                                                 			{
                                                                                                                                 				echo $_SESSION['fr_numerD'];
                                                                                                                                 				unset($_SESSION['fr_numerD']);
                                                                                                                                 			}
                                                                                                                                 		?>" >
                                                        </div>
                                                        <span class='mt-2'> / </span>
                                                        <div class="col">
                                                          <input type="text" id='numerM' name='numerM' class="form-control mb-2" value="<?php
                                                                                                                                 			if (isset($_SESSION['fr_numerM']))
                                                                                                                                 			{
                                                                                                                                 				echo $_SESSION['fr_numerM'];
                                                                                                                                 				unset($_SESSION['fr_numerM']);
                                                                                                                                 			}
                                                                                                                                 		?>">
                                                        </div>
                                                      </div>
                                                     <label for='miasto'>Miasto: </label>
                                                     <input type='text' id='miasto' name='miasto' class='form-control mb-2' value="<?php
                                                                                                                            			if (isset($_SESSION['fr_miasto']))
                                                                                                                            			{
                                                                                                                            				echo $_SESSION['fr_miasto'];
                                                                                                                            				unset($_SESSION['fr_miasto']);
                                                                                                                            			}
                                                                                                                            		?>"/>
                                                     <label for='kodP'>Kod pocztowy: </label>
                                                     <input type='text' id='kodP' name='kodP' class='form-control mb-2' value="<?php
                                                                                                                        			if (isset($_SESSION['fr_kodP']))
                                                                                                                        			{
                                                                                                                        				echo $_SESSION['fr_kodP'];
                                                                                                                        				unset($_SESSION['fr_kodP']);
                                                                                                                        			}
                                                                                                                        		?>"/>
													</div>
													</div>
													<button class="btn btn-dark my-2 my-sm-0 btn-lg " type='submit'>Rejestruj </button>
													</form>
													</div>
											</div>
											<div class="col-md-3">
													<div class="bg-light p-5 rounded-lg">
													<?php
                                                    if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
                                                        {
                                                        }
                                                    else{
                                                    echo "<form action='../php/zaloguj.php' method='post'>
                                                        <label for='login'>
                                                            Login: <br/>
                                                        </label>
                                                        <input type='text' id='login' name='login' class='form-control' /> <br />
                                                        <label for='password'>
                                                            Hasło: <br />
                                                        </label>
                                                        <input type='password' id='password' name='haslo' class='form-control' /> <br /><br />";
                                                        if(isset($_SESSION['blad']))	echo $_SESSION['blad'];
                                                                     unset($_SESSION['blad']);
                                                        echo "
                                                        <a href='../subcontent/rejestracja.php'>Rejestracja</a>
                                                        <input class='btn btn-secondary float-right' type='submit' value='Zaloguj się' />
                                                        </form>";
                                                    }
                                                    ?>
													</div>
											</div>
									</div>
						</section>
									<div class="row">
											<div class="col-md-12">
													<footer class="page-footer font-small">
															<div class="footer-copyright text-center py-3">© 2019 Copyright Damian Szefler
															</div>
													</footer>
											</div>
									</div>
							</div>

			</div>
	</section>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</body>
</html>