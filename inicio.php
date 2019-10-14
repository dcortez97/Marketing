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
            <a class="navbar-brand" href="#">Bienvenido:</a>   <a id="idUser" class="navbar-brand" href="#"><?= $user['nombre_usuario']; ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ml-auto">
                <button class="btn btn-primary btn-sm" onclick="VerificarProyectos()" >Elegir Proyecto registrado</button>&nbsp;
                <a class="nav-item nav-link active" href="logout.php">Cerrar Sesión <span class="sr-only">(current)</span></a>
         
                </div>
            </div>
        </nav>
       <input type="text" id="nmTabla" name="nombre" size="15"></p>

       
    

</head>

<body  onload="ObtenerNombreUsuario()"   >
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 ancho">
            <div class="imagennew">
                <img src="assets/images/upload.png" alt="" width="25%">
            </div>

            <form action="subirArchivo.php" method="POST" enctype="multipart/form-data" id="testform">
                <div class="padre centrado form-group">
                    <input type="file" id="archivo" name="archivo" class="file-upload cursor" />
                </div>
                 
                <div class="">
                <label for="" class="nuevo_centro">Nombre Proyecto</label>
                    <input class="input100 nuevo_centro" type="text" name="nombre" id="nombre" value=""><br>
                <!--<input class="input100" type="password" name="pass" placeholder="Password">-->
                </div>

                <div class="form-group padre">
						<button class="btn-success form-control btn-suc" name="boton" type="submit" value="subir">
							Analizar
						</button>
				</div>
            </form>
			</div>
		</div>
	</div>
	
	<?php require 'partials/scripts.php' ?>




    <div class="modal fade" id="miModal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title" id="myModalLabel"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                 <div class="modal-body" id="TipoError">

                </div>
                 <table class="table">
                    <tr id="encabezadoModal"> 

           
                      </tr>
                    
                   <tbody id="ArticuloE">
                  </tbody>
                 </table>
                 
          

                
            </div>
        </div>
    </div>


    <script type="text/javascript" src="assets/js/inicio.js"></script>
    <script src="AdminLTE-3.0.0-rc.1/plugins/jquery-knob/jquery.knob.min.js"></script>
   
</body>
</html>

<?php else: header('Location: /fit')?>

<?php endif; ?>