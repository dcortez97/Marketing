<?php 
	session_start();
	if (isset($_SESSION['id'])) {
		header('Location: /fit/inicio.php');
	  }

	require 'database.php';
	
	if (!empty($_POST['email']) && !empty($_POST['pass'])) {
		$records = $conn->prepare('SELECT id, nombre_usuario, email, password FROM users WHERE email=:email');
		$records->bindParam(':email', $_POST['email']);
		$records->execute();
		$results = $records->fetch(PDO::FETCH_ASSOC);

		$message = '';

		if (count($results) > 0 && password_verify($_POST['pass'], $results['password'])) {
			$_SESSION['id'] = $results['id'];
			header('Location: /fit/inicio.php');
		}else{
			$message = "Email o contraseña incorrecto";
		}
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Fast Fit</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php require 'partials/links.php' ?>

</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="assets/images/img-01.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" method="post" action="index.php">

					<?php if(!empty($message)):  ?>
                        
						<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
							<strong><?= $message ?></strong> 
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>

                    <?php endif; ?>
					<span class="login100-form-title">
						Inicia Sesión
					</span>
	
					<div class="wrap-input100 validate-input" data-validate = "Validar email es requerido: ex@abc.xyz">
						<input class="input100" type="text" name="email" placeholder="Email">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password es requerido">
						<input class="input100" type="password" name="pass" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Iniciar Sesión
						</button>
					</div>

					<!--
					<div class="text-center p-t-12">
						<span class="txt1">
							Forgot
						</span>
						<a class="txt2" href="#">
							Username / Password?
						</a>
					</div>-->

					<div class="text-center p-t-136">
						<a class="txt2" href="signup.php">
							Crea una cuenta
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<?php require 'partials/scripts.php' ?>


	

</body>
</html>