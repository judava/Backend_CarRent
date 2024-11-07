<?php
// Permitir el acceso desde cualquier origen y configurar los headers
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Content-Type: application/json');
 // Este header define que la respuesta será en formato JSON

// Incluir la conexión a la base de datos y la clase Alquiler
require_once("../conexion.php");
require_once("../modelos/reserva.php");

$control = $_GET['control'];

$reser = new Reserva($conexion);

switch($control){
    case 'consulta':
        $vec= $reser->consulta();
    break;
    case 'insertar':
        $json = file_get_contents('php://input');
        //$json='{"fecha": "2024-10-15","duracion": "5 días","precio": 150000.50,"fo_auto": 1,"fo_cliente": 6}';
        $params= json_decode($json);
        $vec = $reser->insertar($params);
    break;
    //case 'eliminar':
       // $id = $_GET['id'];
        //$vec = $alqui->eliminar($id);

        case 'eliminar':
            if (isset($_GET['id'])) {  // Verificar si 'id' está presente en la URL
                $id = $_GET['id'];
                $vec = $reser->eliminar($id);
            } else {
                $vec = ["resultado" => "ERROR", "mensaje" => "ID no especificado para eliminación"];
            }
        break;
        case 'editar';
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            $json = file_get_contents('php://input');
            $params = json_decode($json);
            $vec = $reser->editar($id, $params);
        } else {
            $vec['resultado'] = "ERROR";
            $vec['mensaje'] = "ID no especificado para editar";
        }
        break;
        case 'filtro';
        if(isset($_GET['dato'])) {
            $dato = $_GET['dato'];
            $vec = $reser->filtro($dato);
        } else {
            $vec['resultado'] = "ERROR";
            $vec['mensaje'] = "Dato de filtro no especificado";
        }
    break;
}
$datos = json_encode($vec);
echo $datos;

?>
