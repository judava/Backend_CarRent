<?php
// Permitir el acceso desde cualquier origen y configurar los headers
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// Incluir la conexión a la base de datos y la clase login
require_once("../conexion.php");
require_once("../modelos/login.php");

$email = $_GET['email'];
$clave = $_GET['clave'];

$login = new Login($conexion);

$vec = $login->consulta($email, $clave);


$datos = json_encode($vec);
echo $datos;
header('Content-Type: application/json');

 // Este header define que la respuesta será en formato JSON

?>
