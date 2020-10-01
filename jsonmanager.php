<?php
header("Access-Control-Allow-Origin: *");
$con = mysqli_connect("localhost", "root", "%unal$", "unityaccess");

if(mysqli_connect_errno())
{
echo "Conexión Fallida";
exit();

}
$id = $_POST["id"];
$tablero = $_POST["tablero"];
$json = $_POST["json"];
$tablero_1 = $_POST["Tablero_1"];
$tablero_2 = $_POST["Tablero_2"];
$tablero_3 = $_POST["Tablero_3"];
$tablero_4 = $_POST["Tablero_4"];
$tablero_5 = $_POST["Tablero_5"];
$tablero_6 = $_POST["Tablero_6"];




$updatequery = "INSERT INTO players (id,". $tablero .") VALUES (". $id .",'" . $json . "''); ";
mysqli_query($con, $updatequery) or die ($updatequery);
if (mysqli_num_rows($updatequery ) != 1){

	echo mysql_error($con);
	exit();

}
echo "0";
?>