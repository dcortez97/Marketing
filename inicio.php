<?php 

    session_start();

    

    require 'database.php';
    if (isset($_SESSION['id'])) {
        $records = $conn->prepare(' SELECT id, nombre_usuario, email, password FROM users WHERE id = :id ');
        $records->bindParam(':id', $_SESSION['id']);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);

        $user = null;
        if(count($results) > 0 ) {
			$user = $results;
        }
        
       
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Fast Fit</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

    <?php require 'partials/links.php'; ?>

    <?php if(!empty($user)): ?>
    
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Bienvenido: <?= $user['nombre_usuario']; ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ml-auto">
                <a class="nav-item nav-link active" href="logout.php">Cerrar Sesión <span class="sr-only">(current)</span></a>
                
                </div>
            </div>
        </nav>
    

</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 ancho">
            <div class="imagennew">
                <img src="assets/images/upload.png" alt="" width="25%">
            </div>

            <form action="" method="POST" enctype="multipart/form-data">
                <div class="padre centrado form-group">
                    <input type="file" id="input-file-now" class="file-upload cursor" />
                </div>

                <div class="form-group padre">
						<button class="btn-success form-control btn-suc">
							Registrarse
						</button>
				</div>
            </form>
			</div>
		</div>
	</div>
	
	<?php require 'partials/scripts.php' ?>
   
</body>
</html>

<?php else: header('Location: /fit')?>

<?php endif; ?>