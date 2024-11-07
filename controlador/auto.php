<?php
// Permitir el acceso desde cualquier origen y configurar los headers
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Content-Type: application/json');
 // Este header define que la respuesta será en formato JSON

// Incluir la conexión a la base de datos y la clase Alquiler
require_once("../conexion.php");
require_once("../modelos/auto.php");

$control = $_GET['control'];

$auto = new Auto($conexion);

switch($control){
    case 'consulta';
        $vec= $auto->consulta();
    break;
    case 'insertar';
        $json = file_get_contents('php://input');
        //$json='{"marca": "Toyota","modelo": 2024,"numero_placa": "XYZ123","caracteristicas": "4 puertas, color blanco, motor 2.0L","disponibilidad": 1,"tiempo_alquiler": "diario","precio": 45000.50}';
        $params= json_decode($json);
        $vec = $auto->insertar($params);
    break;
    //case 'eliminar':
       // $id = $_GET['id'];
        //$vec = $alqui->eliminar($id);

        case 'eliminar':
            if (isset($_GET['id'])) {  // Verificar si 'id' está presente en la URL
                $id = $_GET['id'];
                $vec = $auto->eliminar($id);
            } else {
                $vec = ["resultado" => "ERROR", "mensaje" => "ID no especificado para eliminación"];
            }
        break;
        case 'editar';
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            $json = file_get_contents('php://input');
            $params = json_decode($json);
            $vec = $auto->editar($id, $params);
        } else {
            $vec['resultado'] = "ERROR";
            $vec['mensaje'] = "ID no especificado para editar";
        }
        break;
        case 'filtro';
        if(isset($_GET['dato'])) {
            $dato = $_GET['dato'];
            $vec = $auto->filtro($dato);
        } else {
            $vec['resultado'] = "ERROR";
            $vec['mensaje'] = "Dato de filtro no especificado";
        }
    break;
}
$datos = json_encode($vec);
echo $datos;

?>

