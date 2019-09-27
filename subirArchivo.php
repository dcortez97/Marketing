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

$table = date("Y_m_d__H_i");
//SI EL ARCHIVO SE ENVIÓ Y ADEMÁS SE SUBIO CORRECTAMENTE
if (isset($_FILES["archivo"]) && is_uploaded_file($_FILES['archivo']['tmp_name'])) {
  
 //SE ABRE EL ARCHIVO EN MODO LECTURA
 $fp = fopen($_FILES['archivo']['tmp_name'], "r");
 
 //SE RECORRE
 $result  = explode(";", fgets($fp));

 while (!feof($fp)){ //LEE EL ARCHIVO A DATA, LO VECTORIZA A DATA
   
  //SI SE QUIERE LEER SEPARADO POR TABULADORES
  //$data  = explode(" ", fgets($fp));
  //SI SE LEE SEPARADO POR COMAS
  //$nombreTabla = $_FILES["archivo"]["name"];
  
  $campo_perdido = $result[0]; 
  
  if (count($result) > 1) {
 
        //for ($i=0; $i < count($result); $i++) { 
            //  echo "<br/>Imprimir el primer dato solo: {$result[$i]} VARCHAR(60) <br/>";
                $consulta = " CREATE TABLE $table ($result[0] " . " VARCHAR(60))" ;
                
                if ($conn->query($consulta) === TRUE) {
                    //echo "Table MyGuests created successfully";
                    
                } else {
                    //echo "Error creating table: " . $conn->error;
                }
        
                //echo $consulta;
                              
                for ($i=0; $i < count($result); $i++) {
                   
                        //echo $result[$i];
                    
                        //echo "ALTERADOS"; 
                        //echo "POSICION" . ":" . " " . $result[$i] . " ";
                        
                        $consulta = " ALTER TABLE $table ADD $result[$i] " . " VARCHAR(60);" ;
                    
                        if ($conn->query($consulta) === TRUE) {
                        // echo " SEGUNDO FOR Table MyGuests created successfully";
                            
                        } else {
                            //echo "Error creating table: " . $conn->error;
                        }  
                    
                }

               break;

                //echo $consulta;
            
        //}
        
  }else{
      //echo "ENTRO AL ELSE ,";
      //feof($fp) === false;
      $nuevo_campo = explode(",", $campo_perdido);
      //echo $nuevo_campo[0];
      //$table = date("Y_m_d__H_i");  
      $result  = explode(",", fgets($fp));
      

      //for ($i=-1; $i < count($result); $i++) { 
        //  echo "<br/>Imprimir el primer dato solo: {$result[$i]} VARCHAR(60) <br/>";
            $consulta = " CREATE TABLE $table ($nuevo_campo[0]" . " VARCHAR(60))" ;
            
            if ($conn->query($consulta) === TRUE) {
                //echo "Table MyGuests created successfully";
            } else {
                //echo "Error creating table: " . $conn->error;
            }
    
            //echo $consulta;
            for ($i=0; $i < count($result); $i++) { 
                
                $consulta = " ALTER TABLE $table ADD $nuevo_campo[$i] " . " VARCHAR(60);" ;
                
                if ($conn->query($consulta) === TRUE) {
                    //echo "Table MyGuests created successfully";
                } else {
                    //echo "Error creating table: " . $conn->error;
                }
                
            }
        break;
        
    //}
      
  }
   
} 
    
   
} else{
    echo "Error de subida";
    fclose($fp);
}

    
if (isset($_FILES["archivo"]) && is_uploaded_file($_FILES['archivo']['tmp_name'])) {

    
    //SE ABRE EL ARCHIVO EN MODO LECTURA
    $fp = fopen($_FILES['archivo']['tmp_name'], "r");
    echo $table;
    echo "<br>";
    
    echo "<br>";
  
   
    $fila = 1;
    if (($gestor = fopen($_FILES['archivo']['tmp_name'], "r")) !== FALSE) {
        while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
            $numero = count($datos);
            echo "<p> $numero de campos en la línea $fila: <br /></p>\n";
            
            $fila++;
            //implode("','", $datos);
            for ($c=0; $c < $numero; $c++) {
                $datos[$c] = str_replace(";", ",", $datos[$c]);
                //echo $c . " " . "---> " .$new_field[$c]; 
                //echo $datos[$c] = "'".$datos[$c]."'";
                //echo $datos[$c] = str_replace(",","','",$datos[$c]) . "'";
                //echo "<br>";
                
                //echo $nuevo[$c] = explode(",", $datos[$c]);
                $consulta = " INSERT INTO $table VALUES ('$datos[$c])" ;
                //echo $consulta;
                
                if ($conn->query($consulta) === TRUE) {
                    echo "Table MyGuests created successfully";
                } else {
                    echo "Error creating table: " . $conn->error;
                }
                
            }
        }
        fclose($gestor);
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