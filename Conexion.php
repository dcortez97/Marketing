<?php

 function conectar(){
  $con = mysqli_connect("localhost","root","root","fit");
  mysqli_set_charset($con,'utf8');

   if ($con -> connect_errno) {
     echo "No conectado ";
   }
   else {
  //echo " conectado ";
  
   }

    return $con;
 }





function getLikesPorAñoYSexo(&$Datos){
	

	 $con=conectar();
$Datos=json_decode($Datos);
 $tablaPro=$Datos->nombredb;


 $sqlArticulos= "SELECT sum(ac.likes) as Likes, ac.dob_year  as year,'male' as sexo from `$tablaPro` ac
where ac.gender='male' group by ac.gender,dob_year
union 
select sum(ac.likes) as Likes, ac.dob_year as year,'famele' as sexo from `$tablaPro` ac
where ac.gender='female' group by ac.gender,dob_year;
";


 
   $resultado = $con->query($sqlArticulos);


    $listLikesPorAñoYSexo=[];
   while($rows = $resultado->fetch_assoc()){
   
           $LikesPorAñoYSexo = new stdClass();  
           $LikesPorAñoYSexo->Likes=$rows['Likes'];
           $LikesPorAñoYSexo->year=$rows['year'];
           $LikesPorAñoYSexo->sexo=$rows['sexo'];
         
           $listLikesPorAñoYSexo[]=$LikesPorAñoYSexo;
    }



  return $listLikesPorAñoYSexo;


}




function getLikesdeMovilesYDeWeb(&$Datos){
	

	 $con=conectar();
   
$Datos=json_decode($Datos);
 $tablaPro=$Datos->nombredb;

$sqlArticulos= "SELECT sum(ac.mobile_likes) as LikesMoviles, sum(ac.www_likes_received) as LikesWeb from $tablaPro ac";

  

   $resultado = $con->query($sqlArticulos);


    $listLikesdeMovilesYDeWeb=[];
   while($rows = $resultado->fetch_assoc()){
   
           $LikesdeMovilesYDeWeb = new stdClass();  
           $LikesdeMovilesYDeWeb->LikesMoviles=$rows['LikesMoviles'];
           $LikesdeMovilesYDeWeb->LikesWeb=$rows['LikesWeb'];
          
         
           $listLikesdeMovilesYDeWeb[]=$LikesdeMovilesYDeWeb;
    }



  return $listLikesdeMovilesYDeWeb;


}




function getProyectos(&$Datos){
  

   $con=conectar();
 $Datos=json_decode($Datos);

 $nombreUsuaorio=$Datos->nombreUsuaorio;

    $sqlArticulos = "SELECT * FROM `usuario_subida` where usuario='$nombreUsuaorio'";

   $resultado = $con->query($sqlArticulos);


    $listProyectos=[];
   while($rows = $resultado->fetch_assoc()){
   
           $proyectos = new stdClass();  
     
           $proyectos->usuario=$rows['usuario'];
           $proyectos->nombretable=$rows['nombretable'];
           $proyectos->proyecto=$rows['proyecto'];
           
         
           $listProyectos[]=$proyectos;
    }



  return $listProyectos;


}


function vercase(&$sexo){
   switch($sexo) {
       
        case 2: 
              return 'female'; 
            break;
       case 3: 
             return 'male';
            break;  
         
              
            

    }
}

function getsentimientosSexoYear(&$Datos){
  

 $con=conectar();
 $Datos=json_decode($Datos);

 $sexo=$Datos->sexo;
 $year=$Datos->year;
 $nombredb=$Datos->nombredb;


 if ($sexo ==1 and $year == 1) {
 
   $sqlArticulos = "SELECT comments FROM $nombredb";


 }

 if ($sexo ==1 and $year != 1) {
     $sqlArticulos = "SELECT comments FROM $nombredb WHERE dob_year=$year"; 
}
  if ($sexo !=1 and $year == 1) {

 $sexo=vercase($sexo);
   $sqlArticulos = "SELECT comments FROM $nombredb WHERE gender='$sexo'"; 
 }

 if ($sexo !=1 and $year != 1) {
   $sexo=vercase($sexo);
   $sqlArticulos = "SELECT comments FROM $nombredb WHERE gender='$sexo' and dob_year=$year "  ; 
 }

   

   $resultado = $con->query($sqlArticulos);


    $listcomentarios=[];
   while($rows = $resultado->fetch_assoc()){
   
           $comentarios = new stdClass();  
     
           $comentarios->comentario=$rows['comments'];
           
           $listcomentarios[]=$comentarios; 
         

    }



  return $listcomentarios;


}



?>


