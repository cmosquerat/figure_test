<?php
header("Access-Control-Allow-Origin: *");
$con = mysqli_connect("localhost", "root", "%unal$", "db_cognitivo");

if(mysqli_connect_errno())
{
echo "Conexión Fallida";
exit();
}

$num_tabla = mysqli_query($con,"SELECT * from figuras;");
$caracterizacion_tabla = mysqli_query($con,"SELECT * from tipo_caracterizacion;");
$num_figuras   = mysqli_num_rows($num_tabla);
$id = $_POST["id"];
$figuras_completadas = $_POST["figuras_completadas"];
$figuras_no_completadas = (int)($num_figuras) - $figuras_completadas;
$tiempo = $_POST["tiempo"];
$bools = $_POST["bools"];
$figures_scene = $_POST["figures_scene"];
$caracterizacion = "Mixto";

$bools_array = explode(',',  $bools);
$tableros_array = explode(',',  $figures_scene);

$values_bool = "";
$values_tablero = "";


for($i=0;$i < count($bools_array); ++$i){
   if($i == (count($bools_array) - 1)){

        $values_bool.=  "(" . $id . "," . ($i+1) . ",'" . $bools_array[$i] ."');";
                                      }

    else{

        $values_bool .=  "(" . $id . "," . ($i+1) . ",'" . $bools_array[$i] ."'),";

        }


}


for($i=0;$i < count($tableros_array); ++$i){
   if($i == (count($tableros_array) - 1)){

         $values_tablero .=  "(" . $id . "," . ($i) . "," . $tableros_array[$i] ."," . (10 - (int)$tableros_array[$i]).");";
                                      }

    else{

        $values_tablero .=  "(" . $id . "," . ($i) . "," . $tableros_array[$i] ."," . (10 - (int)$tableros_array[$i])."),";

        }


}


while($row = mysqli_fetch_array($caracterizacion_tabla)){
    $range_array = explode(',',  $row['FIGURAS_PARA_CARACTERIZACION']);
    if($figuras_completadas >= (int)$range_array[0] & $figuras_completadas <= (int)$range_array[1]){

    	$caracterizacion = $row['CARACTERIZACION'];
    }

	
}


$updatequery = "INSERT IGNORE  INTO resultado_figuras_enmascaradas VALUES (" . $id .  ",'" . $caracterizacion . "'," . $figuras_completadas ."," . $figuras_no_completadas ."," . $tiempo .")";
mysqli_query($con, $updatequery) or die ($updatequery);

$boolquery = "INSERT IGNORE  INTO resultado_figuras_individuales VALUES " . $values_bool . "";

mysqli_query($con, $boolquery) or die ($boolquery);

$tableroquery = "INSERT IGNORE  INTO resultado_tableros VALUES " . $values_tablero . "";

mysqli_query($con, $tableroquery) or die ($tableroquery);


echo "0";
?>