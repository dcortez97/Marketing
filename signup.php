<?php 
	session_start();
	if (isset($_SESSION['id'])) {
		header('Location: /fit/inicio.php');
	}
    require 'database.php';

	$message = '';

    if(!empty($_POST['usuario']) && !empty($_POST['email']) && !empty($_POST['pass'])) {
        $sql = " INSERT INTO users (nombre_usuario, email, password) VALUES (:usuario, :email, :pass) ";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':usuario', $_POST['usuario']);
        $stmt->bindParam(':email', $_POST['email']);
        $password = password_hash($_POST['pass'], PASSWORD_BCRYPT);
		$stmt->bindParam(':pass', $password);

		if($_POST['pass'] != $_POST['password_confirm']){
			$message = "Contraseñas no coinciden";
			
		}else{
			if ($stmt->execute()) {
				$message = '¡Registro exitoso!';
			}else{
				$message = "Error al registrar";
			}
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
                

				<form class="login100-form validate-form" action="signup.php" method="post">

                    <?php if(!empty($message)):  ?>
                        
						<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
						<strong><?= $message ?></strong> 
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						</div>
                    <?php endif; ?>
					
					<span class="login100-form-title">
						Registrate
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Nombre de usuario es requerido">
						<input class="input100" type="text" name="usuario" placeholder="Usuario">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>

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

					<div class="wrap-input100 validate-input" data-validate = "Confirmar password es requerido">
						<input class="input100" type="password" name="password_confirm" placeholder="Confirmar Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Registrarse
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
                        Si ya tienes una cuenta
						<a class="txt2" href="index.php">
							Inicia Sesión
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