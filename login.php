<?php
header("Access-Control-Allow-Origin: *");
$con = mysqli_connect('localhost','root','%unal$','db_cognitivo');

if(mysqli_connect_errno())
{
echo "Conexión Fallida";
exit();

}

$id = $_POST["id"];

$check_query = "SELECT documento,nombre,apellido1,apellido2 FROM users WHERE documento = '" .$id. "';";
$id_check = mysqli_query($con,$check_query) or die ("Usuario no encontrado");

if (mysqli_num_rows($id_check ) != 1){

	echo("Usuario no encontrado");
	exit();

}


$user_info = mysqli_fetch_assoc($id_check);
$nombre = $user_info["nombre"] . " " . $user_info["apellido1"] . " " . $user_info["apellido2"];


echo "0\t" . $nombre;
?>