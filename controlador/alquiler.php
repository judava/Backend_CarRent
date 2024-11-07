<?php
// Permitir el acceso desde cualquier origen y configurar los headers
header('Access-Control-Allow-Origin: *');
//header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");//eliminar
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// Manejo de la solicitud OPTIONS
//if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
   // header("HTTP/1.1 200 OK");
    //exit();
//}
header('Content-Type: application/json');
 // Este header define que la respuesta será en formato JSON

// Incluir la conexión a la base de datos y la clase Alquiler
require_once("../conexion.php");
require_once("../modelos/alquiler.php");

$control = $_GET['control'];

$alqui = new Alquiler($conexion);

switch($control){
    case 'consulta';
        $vec= $alqui->consulta();
    break;
    case 'insertar';
        $json = file_get_contents('php://input');
        //$json='{"fecha": "2024-10-10", "duracion": 3, "precio": 3400000, "fo_auto": 1, "fo_cliente": 1}';
        $params= json_decode($json);
        $vec = $alqui->insertar($params);
    break;
    //case 'eliminar':
       // $id = $_GET['id'];
        //$vec = $alqui->eliminar($id);

    case 'eliminar':
            if (isset($_GET['id'])) {  // Verificar si 'id' está presente en la URL
                $id = $_GET['id'];
                

                $vec = $alqui->eliminar($id);
            } else {
                $vec = ["resultado" => "ERROR", "mensaje" => "ID no especificado para eliminación"];
            }
        break;
        case 'editar';
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            $json = file_get_contents('php://input');
            $params = json_decode($json);
            $vec = $alqui->editar($id, $params);
        } else {
            $vec['resultado'] = "ERROR";
            $vec['mensaje'] = "ID no especificado para editar";
        }
        break;
        case 'filtro';
        if(isset($_GET['dato'])) {
            $dato = $_GET['dato'];
            $vec = $alqui->filtro($dato);
        } else {
            $vec['resultado'] = "ERROR";
            $vec['mensaje'] = "Dato de filtro no especificado";
        }
    break;
}
$datos = json_encode($vec);
echo $datos;

?>
