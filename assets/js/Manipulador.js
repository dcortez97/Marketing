
var GraficaLikesPorAñoYSexo;
var chart;


function llenarGraficaLikesPorAñoYSexo(){

  $.ajax({
    url: '../fit/GetData.php?funcion=LikesPorAñoYSexo',
    success: function(respuesta) {
     GraficaLikesPorAñoYSexo = JSON.parse(respuesta);
     cargarGraficaLikesPorAñoYSexoFamele("1");
    },
    error: function() {
          console.log("No se ha podido obtener la información");
       }
       });
  
  LikesdeMovilesYDeWeb();
}


function cargarGraficaLikesPorAñoYSexoFamele(sexo){
	 
	var labelsList=new Array();
	var dataList=new Array();

	if (sexo==1) {
		sexoName='famele';
		
		rgb= 'rgb(255, 99, 132)';
	}else
	{
		sexoName='male';
		rgb= 'rgb(37, 137, 226)';
	}


	$.each(GraficaLikesPorAñoYSexo, function (key, tk) {

           if (tk.sexo==sexoName) {
   
             labelsList.push(tk.year);
             dataList.push(tk.Likes);
           }


                  
       });

	let miCanvas=document.getElementById("MiGraficaLikesPorAñoYSexo").getContext("2d");

      
       
              

                 chart = new Chart(miCanvas,{
                  type:"bar",
                  data:{
                    labels:labelsList,
                    datasets:[
                    {
                      label:"Likes "+sexoName,
                       backgroundColor: rgb,
                       borderColor:rgb,
                       data: dataList
                    }]
                  }
                })



}



function changeSelectLikesPorAñoYSexo(){

	let miCanvas=document.getElementById("MiGraficaLikesPorAñoYSexo").getContext("2d");
	chart.destroy();
	cargarGraficaLikesPorAñoYSexoFamele($("#idsexos").val());

}


function LikesdeMovilesYDeWeb(){
	


 $.ajax({
    url: '../fit/GetData.php?funcion=LikesdeMovilesYDeWeb',
    success: function(respuesta) {
        GraficaLikesdeMovilesYDeWeb = JSON.parse(respuesta);
     
		var labelsList=new Array();
		var dataList=new Array();
		rgb= 'rgb(59, 51, 178)';
		
		$.each(GraficaLikesdeMovilesYDeWeb, function (key, tk) {

		           
		   
		             labelsList.push("Likes Movil");
		             labelsList.push("Likes Web");

		             dataList.push(tk.LikesMoviles);
		             dataList.push(tk.LikesWeb);
		           


		                  
		 });
   		 let miCanvas=document.getElementById("MiGraficaLikesdeMovilesYDeWeb").getContext("2d");
       

         var LikesdeMovilesYDeWeb = new Chart(miCanvas,{
           type:"bar",
            data:{
            labels:labelsList,
            datasets:[
            {
              label:"Likes por dispositivo",
               backgroundColor: rgb,
               borderColor:rgb,
               data: dataList
               }]
             }
         })




    },
    error: function() {
          console.log("No se ha podido obtener la información");
       }
       });




	


	

	


}



