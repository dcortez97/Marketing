 <?php 




if(isset($_GET['funcion']) && !empty($_GET['funcion'])) {
    $funcion = $_GET['funcion'];
   
     

    //En función del parámetro que nos llegue ejecutamos una función u otra
    switch($funcion) {
       
        case 'LikesPorAñoYSexo': 
              LikesPorAñoYSexo();
            break;
       case 'LikesdeMovilesYDeWeb': 
              LikesdeMovilesYDeWeb();
            break;  

    }
}




function LikesPorAñoYSexo(){

	include_once 'Conexion.php';

	$lisDetalle_Refacciones=getLikesPorAñoYSexo();

	 
	echo json_encode($lisDetalle_Refacciones);

}


function LikesdeMovilesYDeWeb(){

	include_once 'Conexion.php';

	$lisLikesdeMovilesYDeWeb=getLikesdeMovilesYDeWeb();

	 
	echo json_encode($lisLikesdeMovilesYDeWeb);

}


 ?> 