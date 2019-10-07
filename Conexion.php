<?php

 function conectar(){
  $con = mysqli_connect("localhost","ulises","ulises1996","fit");
  mysqli_set_charset($con,'utf8');

   if ($con -> connect_errno) {
     echo "No conectado ";
   }
   else {
  //echo " conectado ";
  
   }

    return $con;
 }





function getLikesPorAñoYSexo(){
	

	 $con=conectar();


    $sqlArticulos = "CALL LikesPorAñoYSexo()";

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




function getLikesdeMovilesYDeWeb(){
	

	 $con=conectar();


    $sqlArticulos = "CALL LikesdeMovilesYDeWeb()";

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



