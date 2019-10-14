 <?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');
if(isset($_GET['funcion']) && !empty($_GET['funcion'])) {
    $funcion = $_GET['funcion'];
   
     

    //En función del parámetro que nos llegue ejecutamos una función u otra
    switch($funcion) {
       
        case 'LikesPorAñoYSexo': 
            $Datos = $_GET['Datos'];

              LikesPorAñoYSexo($Datos);
            break;
       case 'LikesdeMovilesYDeWeb': 
             $Datos = $_GET['Datos'];
              LikesdeMovilesYDeWeb($Datos);
            break;  
          case 'getSesion': 
              getSesion();
            break;  

          case 'ObtenerProyectos': 
          
           $Datos = $_GET['Datos'];
              ObtenerProyectos($Datos);
            break;  
            
           case 'sentimientosSexoYear': 
           $Datos = $_GET['Datos'];
              sentimientosSexoYear($Datos);
            break;  
              
            

    }
}

function sentimientosSexoYear($Datos){

  include_once 'Conexion.php';

  $listsentimientosSexoYear=getsentimientosSexoYear($Datos);

   
  echo json_encode($listsentimientosSexoYear);

}


function LikesPorAñoYSexo($Datos){

	include_once 'Conexion.php';

	$lisDetalle_Refacciones=getLikesPorAñoYSexo($Datos);

	 
	echo json_encode($lisDetalle_Refacciones);

}


function LikesdeMovilesYDeWeb($Datos){

	include_once 'Conexion.php';

	$lisLikesdeMovilesYDeWeb=getLikesdeMovilesYDeWeb($Datos);

	 
	echo json_encode($lisLikesdeMovilesYDeWeb);

}


function getSesion(){


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

      $usuario = new stdClass();
      $usuario->nombreusario=$user['nombre_usuario'];
      echo json_encode($usuario);
      

}

function ObtenerProyectos($data){

  include_once 'Conexion.php';

  $Poryectosobtenidos=getProyectos($data);

   
  echo json_encode($Poryectosobtenidos);

}



 ?> 


