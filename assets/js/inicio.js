
var idUser;

function ObtenerNombreUsuario(){





 $.ajax({
    url: '../fit/GetData.php?funcion=getSesion',
    success: function(respuesta) {


         
          var  jso = JSON.parse(respuesta); 
           idUser =jso.nombreusario;
    
    },
    error: function() {
          console.log("No se ha podido obtener la información");
     }
    });


}



function VerificarProyectos(){

 $('#miModal').modal('show');

   objetoJSon = { nombreUsuaorio: idUser};
  $("#encabezadoModal").html(""); 
  $("#ArticuloE").html(""); 


  $("#encabezadoModal").append($("<th>Usuario</th>"));
  $("#encabezadoModal").append($("<th>Nombre Proyeyectp</th>"));


  $.ajax({
      url: '../fit/GetData.php?funcion=ObtenerProyectos&Datos='+JSON.stringify(objetoJSon),
      success: function(respuesta) {
        
         proyectos = JSON.parse(respuesta); 

           $.each(proyectos, function (key, tk) {
            row = $("<tr />");
            $("#ArticuloE").append(row);
           row.append($("<td>" + tk.usuario + "</td>"));
           row.append($("<td>" + tk.proyecto + "</td>"));       
           row.append($('<td><button type="button" class="btn  btn-sm btn-outline-warning" onclick="irDashboard('+key+')">Ver Proyecto </button></td>'));
    
                  
            });

       
       
                },
      error: function() {
            console.log("No se ha podido obtener la información");
       }
  });
}




          
                 