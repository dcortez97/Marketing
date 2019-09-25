<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "fit";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//SI EL ARCHIVO SE ENVIÓ Y ADEMÁS SE SUBIO CORRECTAMENTE
if (isset($_FILES["archivo"]) && is_uploaded_file($_FILES['archivo']['tmp_name'])) {
    $file = fopen($_FILES['archivo']['tmp_name'], "r");
    $nombreTabla = $_FILES["archivo"]["name"];
    $table = date("Y_m_d__H_i_s");  
    //echo $table;
    
    
    //echo $nombreTabla;
    
    $result = fgetcsv($file);

    foreach ($result as $res) {
    
        $nuevo = explode(";", $res);
        //echo $new . ' ';
        $primer_campo = $nuevo[0];
        
        //echo $campo;
        $consulta = " CREATE TABLE $table ($primer_campo " . " VARCHAR(60))" ;
        
        
        if ($conn->query($consulta) === TRUE) {
            //echo "Table MyGuests created successfully";
        } else {
            //echo "Error creating table: " . $conn->error;
        }
        
    
        //echo $consulta;
    
        for ($i=1; $i < count($nuevo); $i++) { 
            //echo "<br>";
            //echo $consulta;
            
            //echo $nuevo[$i];
            //echo "<br>";
            $consulta = " ALTER TABLE $table ADD $nuevo[$i] " . " VARCHAR(60);" ;
            
            if ($conn->query($consulta) === TRUE) {
                //echo "Table MyGuests created successfully";
            } else {
                //echo "Error creating table: " . $conn->error;
            }
            
            //echo $consulta;
            
    
        }
    
    }
    //echo "Subida Correcta";
}else{
    //echo "No se pudo subir";
}


//echo $result;



fclose($file);
?> 

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
                <h1 class="text-center">El archivo se analizó correctamente</h1>
            </div>

            <form action="subirArchivo.php" method="POST" enctype="multipart/form-data" id="testform">
                <div class="form-group mx-auto centerbutton ">
						<button class="btn-success form-control btn-suc centerbutton">
							Ver Gráficas 
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