<?php
// Permitir el acceso desde cualquier origen y configurar los headers
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Content-Type: application/json');
 // Este header define que la respuesta será en formato JSON

// Incluir la conexión a la base de datos y la clase Alquiler
require_once("../conexion.php");
require_once("../modelos/cliente.php");

$control = $_GET['control'];

$clien = new Cliente($conexion);

switch($control){
    case 'consulta';
        $vec= $clien->consulta();
    break;
    case 'insertar';
        $json = file_get_contents('php://input');
        //$json='{"nombre": "Juan","apellidos": "Pérez Gómez","Cedula": 123456789,"ciudad": "Medellín","direccion": "Calle 123 #45-67","correo_electronico": "juan.perez@example.com"}';
        $params= json_decode($json);
        $vec = $clien->insertar($params);
    break;
    //case 'eliminar':
       // $id = $_GET['id'];
        //$vec = $alqui->eliminar($id);

        case 'eliminar':
            if (isset($_GET['id'])) {  // Verificar si 'id' está presente en la URL
                $id = $_GET['id'];
                $vec = $clien->eliminar($id);
            } else {
                $vec = ["resultado" => "ERROR", "mensaje" => "ID no especificado para eliminación"];
            }
        break;
        case 'editar';
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            $json = file_get_contents('php://input');
            $params = json_decode($json);
            $vec = $clien->editar($id, $params);
        } else {
            $vec['resultado'] = "ERROR";
            $vec['mensaje'] = "ID no especificado para editar";
        }
        break;
        case 'filtro';
        if(isset($_GET['dato'])) {
            $dato = $_GET['dato'];
            $vec = $clien->filtro($dato);
        } else {
            $vec['resultado'] = "ERROR";
            $vec['mensaje'] = "Dato de filtro no especificado";
        }
    break;
}
$datos = json_encode($vec);
echo $datos;

?>
