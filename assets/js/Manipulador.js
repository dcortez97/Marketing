
var GraficaLikesPorAñoYSexo;
var chart;
var labelsList;
var strongPositive;
var positive;
var neutral;
var negative;
var strongNegative;
var withoutsentiment;
var SentimientosYearSexo;

function llenarGraficaLikesPorAñoYSexo(){



  objetoJSon = { nombredb: tablaActual};



  $.ajax({
    url: '../fit/GetData.php?funcion=LikesPorAñoYSexo&Datos='+JSON.stringify(objetoJSon),
    success: function(respuesta) {
     GraficaLikesPorAñoYSexo = JSON.parse(respuesta);
     cargarGraficaLikesPorAñoYSexoFamele("1");
      LikesdeMovilesYDeWeb();
    },
    error: function() {
          console.log("No se ha podido obtener la información");
       }
       });
  
 
}


function cargarGraficaLikesPorAñoYSexoFamele(sexo){
	 
  labelsList=new Array();
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
	
 objetoJSon = { nombredb: tablaActual};

 $.ajax({
    url: '../fit/GetData.php?funcion=LikesdeMovilesYDeWeb&Datos='+JSON.stringify(objetoJSon),
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

      cargarSelectYearSentimiento();
    },
    error: function() {
          console.log("No se ha podido obtener la información");
       }
       });



}


function cargarSelectYearSentimiento(){


  $.each(labelsList, function (key, tk) {

    $("#idYearSentimientos").append("<option value="+tk+">"+tk+"</option>");
           

                  
       });

  getSentimientoXSexoYear();


}


function callgetSentimientoXSexoYear(){
  SentimientosYearSexo.destroy();
  getSentimientoXSexoYear();

}



function getSentimientoXSexoYear(){ 


$("#idLoading").show();

sexoselect=$("#idsexosSentimientos").val();
yearselect=$("#idYearSentimientos").val();


   
 objetoJSon = { sexo: sexoselect,year:yearselect,nombredb: tablaActual};


 $.ajax({
    url: '../fit/GetData.php?funcion=sentimientosSexoYear&Datos='+JSON.stringify(objetoJSon),
    success: function(respuesta) {
         Comentarios = JSON.parse(respuesta);
      loadJsonFromPHP(Comentarios);

    },
    error: function() {
          console.log("No se ha podido obtener la información");
       }
       });

}



function loadJsonFromPHP(data) {
  
   strongPositive=0;
   positive=0;
   neutral=0;
   negative=0;
   strongNegative=0;
   withoutsentiment=0;

 
  
     
         for (let i = 0; i < data.length; i++) {
           

            (function(ind) {
                setTimeout(function(){
                    //console.log(ind);
                    var settings = {
                        "async": true,
                        "crossDomain": true,
                        "url": "https://api.meaningcloud.com/sentiment-2.1",
                        "method": "POST",
                        "headers": {
                            "content-type": "application/x-www-form-urlencoded"
                        },
                        "data": {
                            "key": "056dcf36f4818a5acf189f4a6012e4e4",
                            "lang": "es",
                            "txt": data[i].comentario,
                            "txtf": "plain"
                        }
                    }
                      $.ajax(settings).done(function (response) {

                           // RespuestaSentimiento = JSON.parse(response);
                    
                         
                          agregarArraySentimiento(response.score_tag);
                      
                         if (i == data.length-1) {
                            llenarGraficaSentimientos();
                         }
                            
                      });
                }, 1000 + (1000 * ind));
            })(i);

            
        }
}

function agregarArraySentimiento(score_tag){

switch (score_tag) {
            
            case 'P+':
              strongPositive=strongPositive+1;
            break;

            case 'P':
            positive=positive+1;

            break;

            case 'NEU':
            neutral=neutral+1;
            
            break;
            case 'N':
            negative=negative+1;
              
            break;
            case 'N+':
             strongNegative=strongNegative+1;
            
            break;
            case 'NONE':
             withoutsentiment=withoutsentiment+1;
            break;
    }

}


function llenarGraficaSentimientos(){
  $("#idLoading").hide();

    rgb= 'rgb(18, 122, 143)';

 let miCanvasSentimientos=document.getElementById("miGraficaSentimientos").getContext("2d");
       

          SentimientosYearSexo = new Chart(miCanvasSentimientos,{
           type:"bar",
            data:{
            labels:['strongPositive','positive','neutral','negative','strongNegative','withoutsentiment'],
            datasets:[
            {
              label:"Sentimientos por año y sexo",
               backgroundColor: rgb,
               borderColor:rgb,
               data: [strongPositive,positive,neutral,negative,strongNegative,withoutsentiment]
               }]
             }
         })



}
