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
    //echo $table;
    //echo "<br>";
    
    //echo "<br>";
  
   
    $fila = 1;
    if (($gestor = fopen($_FILES['archivo']['tmp_name'], "r")) !== FALSE) {
        while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
            $numero = count($datos);
            //echo "<p> $numero de campos en la línea $fila: <br /></p>\n";
            
            $fila++;
            //implode("','", $datos);
            for ($c=0; $c < $numero; $c++) {
                $datos[$c] = str_replace(";", ",", $datos[$c]);
                //echo $c . " " . "---> " .$new_field[$c]; 
                //echo $datos[$c] = "'".$datos[$c]."'";
                $datos[$c] = str_replace(",","','",$datos[$c]) . "'";
                //echo "<br>";
                
                //echo $nuevo[$c] = explode(",", $datos[$c]);
                $consulta = " INSERT INTO $table VALUES ('$datos[$c])" ;
                //echo $consulta;
                
                if ($conn->query($consulta) === TRUE) {
                    //echo "Table MyGuests created successfully";
                } else {
                    //echo "Error creating table: " . $conn->error;
                }
                
            }
        }
        fclose($gestor);
    }

    
}

if (isset($_FILES["archivo"]) && is_uploaded_file($_FILES['archivo']['tmp_name'])) {

    
    //SE ABRE EL ARCHIVO EN MODO LECTURA
    $fp = fopen($_FILES['archivo']['tmp_name'], "r");
    //echo $table;
    //echo "<br>";
    
   // echo "<br>";
  
   
    $fila = 1;
    if (($gestor = fopen($_FILES['archivo']['tmp_name'], "r")) !== FALSE) {
        while (($datos = fgetcsv($gestor, 1000, ";")) !== FALSE) {
            $numero = count($datos);
            //echo "<p> $numero de campos en la línea $fila: <br /></p>\n";
            
            $fila++;
            //implode("','", $datos);
            for ($c=0; $c < $numero; $c++) {
                $datos[$c] = str_replace(";", ",", $datos[$c]);
                //echo $c . " " . "---> " .$new_field[$c]; 
                //echo $datos[$c] = "'".$datos[$c]."'";
                $datos[$c] = str_replace(",","','",$datos[$c]) . "'";
                //echo "<br>";
                //echo "<br>";
                
                //echo $nuevo[$c] = explode(",", $datos[$c]);
                $consulta = " INSERT INTO $table VALUES ('$datos[$c])" ;
                //echo $consulta;
                //echo "<br>";
                
                if ($conn->query($consulta) === TRUE) {
                    //echo "Table MyGuests created successfully";
                } else {
                    //echo "Error creating table: " . $conn->error;
                }
                
            }
        }
        fclose($gestor);
    }

    
}

$consulta = " DELETE FROM $table LIMIT 1 " ;
//echo $consulta;

if ($conn->query($consulta) === TRUE) {
    //echo "Table MyGuests created successfully";
} else {
    //echo "Error creating table: " . $conn->error;
}

$usuario = $user['nombre_usuario'];

$proyecto = $_POST["nombre"];
echo "el valor es:" . $proyecto; 
// el valor
echo $usuario;
$consulta = " INSERT INTO usuario_subida VALUES ('','$usuario', '$table', '$proyecto')" ;
//echo $consulta;

if ($conn->query($consulta) === TRUE) {
    echo "Table MyGuests created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

?> 



<?php 
    $mysqli = new mysqli("localhost", "root", "root", "fit");
     
    /* verificar conexion */
    if (mysqli_connect_errno()) {
    echo "Error enconexión: ". mysqli_connect_error();
    exit();
    }
     
    $sql = " SELECT comments FROM $table ";
    $rs = $mysqli->query($sql);
    $todos_comentarios = array();
    
    while ($fila = $rs->fetch_assoc()) {
            //echo '<h3>', $fila['comments'] , '</h3>' ;
            //echo '<h3>', $fila['userid'] , '</h3>' ;

            $comentario['comentario'] = $fila['comments'];
            $todos_comentarios[] = $comentario;
           // echo json_encode($todos_comentarios);
    }
        
    $todos_comentarios;
     
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Fast Fit</title>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="AdminLTE-3.0.0-rc.1/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="AdminLTE-3.0.0-rc.1/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="AdminLTE-3.0.0-rc.1/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="AdminLTE-3.0.0-rc.1/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="AdminLTE-3.0.0-rc.1/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="AdminLTE-3.0.0-rc.1/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="AdminLTE-3.0.0-rc.1/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="AdminLTE-3.0.0-rc.1/plugins/summernote/summernote-bs4.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">

    <script src="assets/js/analizar.js"></script>
        <script>
            loadJsonFromPHP(<?php echo json_encode($todos_comentarios) ?>);
        </script>

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

<body  onload="llenarGraficaLikesPorAñoYSexo()" class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="AdminLTE-3.0.0-rc.1/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="subirArchivo.php" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v1</p>
                </a>
              </li>
              
            </ul>
          </li>
          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Charts
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="AdminLTE-3.0.0-rc.1/pages/charts/chartjs.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>ChartJS</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="AdminLTE-3.0.0-rc.1/pages/charts/flot.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Flot</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="AdminLTE-3.0.0-rc.1/pages/charts/inline.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inline</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
          
          
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <?php

        

  ?>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
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


        ?>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
            <?php 
                $consulta = " SELECT SUM(likes) as total FROM $table " ;
                //echo $consulta;
    
                $resultado = $conn->query($consulta);
                $total = $resultado->fetch_assoc();
            
            ?>
              <div class="inner">
                <h3><?php echo $total['total'] ?></h3>
                <p>Total de Likes</p>
              </div>
              <div class="icon">
                <i class="ion ion-md-thumbs-up"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              
              <?php 
              
                $consulta = " SELECT COUNT(userid) as comentarios FROM $table WHERE gender = 'male'" ;
                //echo $consulta;
    
                $resultado = $conn->query($consulta);
                $comentarios = $resultado->fetch_assoc();
              
              ?>
              <div class="inner">
              <h3><?php echo $comentarios['comentarios'] ?></h3>

                <p>Comentarios</p>
              </div>
              <div class="icon">
                <i class="ion ion-md-mic"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
              <?php 
              
              $consulta = " SELECT COUNT(userid) as interaccion FROM $table WHERE likes != 0 " ;
              //echo $consulta;
  
              $resultado = $conn->query($consulta);
              $interacciones = $resultado->fetch_assoc();
              
              ?>

              <h3><?php echo $interacciones['interaccion'] ?></h3>

                <p>Interacciones</p>
              </div>
              <div class="icon">
                <i class="ion ion-md-trending-up"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
              <?php 
              
                $consulta = " SELECT COUNT(userid) as alcance FROM $table " ;
                //echo $consulta;
    
                $resultado = $conn->query($consulta);
                $alcance = $resultado->fetch_assoc();
              
              ?>
                <h3><?php echo $alcance['alcance'] ?><sup style="font-size: 20px"></sup></h3>

                <p>Personas Alcanzadas</p>
              </div>
              <div class="icon">
                <i class="ion ion-md-people"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-7 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Vistas en la Web
                </h3>
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item">
                    <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
                  </li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <!-- Morris chart - Sales -->
                  <div class="chart tab-pane active" id="revenue-chart"
                       style="position: relative; height: 300px;">
                      <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>                         
                   </div>
                  <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                    <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>                         
                  </div>  
                </div>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
             <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Likes por Origen de visita</h3>  
                </div>
              </div>
              <div  class="card-body">
               
              <canvas  id="MiGraficaLikesdeMovilesYDeWeb" width="400" height="300"></canvas>
               
           
               <script type="text/javascript">

               </script>

              </div>
            </div>
            <!-- /.card -->

            
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Likes por año y sexo</h3>
                   <select  class="form-control" onchange="changeSelectLikesPorAñoYSexo()"  id="idsexos">
                  <option value="1">famele</option>
                  <option value="2">mele</option>
                </select>
                 
                </div>
              </div>
              <div  class="card-body">
               
              <canvas  id="MiGraficaLikesPorAñoYSexo" width="400" height="300"></canvas>
               
           
               <script type="text/javascript">

               </script>

              </div>
            </div>

           

         <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">LikesEdad</h3>
                  <a href="javascript:void(0);">View Report</a>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg">$18,230.00</span>
                    <span>Sales Over Time</span>
                  </p>
                  <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fas fa-arrow-up"></i> 33.1%
                    </span>
                    <span class="text-muted">Since last month</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="sales-chart2" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> This year
                  </span>

                  <span>
                    <i class="fas fa-square text-gray"></i> Last year
                  </span>
                </div>
              </div>
            </div>

            <!-- /.card -->

            
        </section>
          <!-- /.Left col -->
          
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-5 connectedSortable">

            <!-- Map card -->
            <div class="card bg-gradient-primary">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="fas fa-map-marker-alt mr-1"></i>
                  Visitors
                </h3>
                <!-- card tools -->
                <div class="card-tools">
                  <button type="button"
                          class="btn btn-primary btn-sm daterange"
                          data-toggle="tooltip"
                          title="Date range">
                    <i class="far fa-calendar-alt"></i>
                  </button>
                  <button type="button"
                          class="btn btn-primary btn-sm"
                          data-card-widget="collapse"
                          data-toggle="tooltip"
                          title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <div class="card-body">
                <div id="world-map" style="height: 250px; width: 100%;"></div>
              </div>
              <!-- /.card-body-->
              <div class="card-footer bg-transparent">
                <div class="row">
                  <div class="col-4 text-center">
                    <div id="sparkline-1"></div>
                    <div class="text-white">Visitors</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-4 text-center">
                    <div id="sparkline-2"></div>
                    <div class="text-white">Online</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-4 text-center">
                    <div id="sparkline-3"></div>
                    <div class="text-white">Sales</div>
                  </div>
                  <!-- ./col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            <!-- /.card -->

            <!-- solid sales graph -->
            <div class="card bg-gradient-info">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="fas fa-th mr-1"></i>
                  Vistas en dispositivo movil
                </h3>

                <div class="card-tools">
                  <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas class="chart" id="line-chart" style="height: 250px;"></canvas>
              </div>
              <!-- /.card-body -->
              <div class="card-footer bg-transparent">
                <div class="row">
                  <div class="col-4 text-center">
                    <input type="text" class="knob" data-readonly="true" value="20" data-width="60" data-height="60"
                           data-fgColor="#39CCCC">

                    <div class="text-white">Mail-Orders</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-4 text-center">
                    <input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60"
                           data-fgColor="#39CCCC">

                    <div class="text-white">Online</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-4 text-center">
                    <input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60"
                           data-fgColor="#39CCCC">

                    <div class="text-white">In-Store</div>
                  </div>
                  <!-- ./col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->

           
            
            </div>
            <!-- /.card -->
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.0-rc.1
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="AdminLTE-3.0.0-rc.1/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="AdminLTE-3.0.0-rc.1/plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="AdminLTE-3.0.0-rc.1/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="AdminLTE-3.0.0-rc.1/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="AdminLTE-3.0.0-rc.1/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="AdminLTE-3.0.0-rc.1/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="AdminLTE-3.0.0-rc.1/plugins/jqvmap/maps/jquery.vmap.world.js"></script>
<!-- jQuery Knob Chart -->
<script src="AdminLTE-3.0.0-rc.1/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="AdminLTE-3.0.0-rc.1/plugins/moment/moment.min.js"></script>
<script src="AdminLTE-3.0.0-rc.1/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="AdminLTE-3.0.0-rc.1/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="AdminLTE-3.0.0-rc.1/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="AdminLTE-3.0.0-rc.1/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="AdminLTE-3.0.0-rc.1/dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="AdminLTE-3.0.0-rc.1/dist/js/pages/dashboard.php"></script>

<!-- AdminLTE for demo purposes -->
<script src="AdminLTE-3.0.0-rc.1/dist/js/demo.js"></script>

<script src="AdminLTE-3.0.0-rc.1/plugins/chart.js/Chart.min.js"></script>
<script src="AdminLTE-3.0.0-rc.1/dist/js/demo.js"></script>
<script src="AdminLTE-3.0.0-rc.1/dist/js/pages/dashboard3.js"></script>
<script type="text/javascript" src="assets/js/Manipulador.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
</body>

</html>

<?php else: header('Location: /fit')?>

<?php endif; ?>