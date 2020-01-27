<?php
session_start();
	if (!isset($_SESSION['udanarejestracja']))
	{
		header('Location: '. $_SERVER['HTTP_REFERER']);
		exit();
	}
	else
	{
		unset($_SESSION['udanarejestracja']);
	}
	    unset($_SESSION['fr_email']);
        unset($_SESSION['fr_login']);
        unset($_SESSION['fr_haslo']);
        unset($_SESSION['fr_telefon']);
        unset($_SESSION['fr_dataU']);
        unset($_SESSION['fr_nip']);
        unset($_SESSION['fr_imie']);
       unset($_SESSION['fr_nazwisko']);
        unset($_SESSION['fr_ulica']);
        unset($_SESSION['fr_numerD']);
        unset($_SESSION['fr_numerM']);
       unset($_SESSION['fr_miasto']);
        unset($_SESSION['fr_kodP']);
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
													    <h1 class='display-2'> DZIĘKUJEMY ZA REJESTRACJE</h1>
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
	<script src="js/jQuery.js"></script>
</body>
</html>