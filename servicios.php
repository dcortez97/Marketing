<?php
 
$mysqli = new mysqli("localhost", "root", "root", "fit");
 
/* verificar conexion */
if (mysqli_connect_errno()) {
echo "Error enconexión: ". mysqli_connect_error();
exit();
}
 
$sql = " SELECT dob_year, COUNT(*) AS resultado FROM 2019_10_03__22_49 GROUP BY dob_year ";
 
if ($rs = $mysqli->query($sql)) {
 
/* fetch array asociativo*/

$arreglo_registros = array();

while ($fila = $rs->fetch_assoc()) {
echo '<h3>', $fila["dob_year"] , ' dice:</h3><div>' , $fila["resultado"] , '</div>' ;
$registro['fecha'] = $fila['dob_year'];
$registro['cantidad'] = $fila['resultado'];

$arreglo_registros[] = $registro;
}
 
echo "<pre>";
    var_dump(json_encode($arreglo_registros));
echo "</pre>";
/* liberamos la memoria asociada al resultado */
$rs->close();
}
 
/* cerramos la conexion */
$mysqli->close();
 
?>



