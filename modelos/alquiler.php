<?php
class Alquiler {
    // Atributo de conexión
    public $conexion;

    // Constructor
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Método para consultar todos los alquileres
    public function consulta() {
        $con = "SELECT * FROM alquiler ORDER BY fecha";
        $res = mysqli_query($this->conexion, $con);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }

    // Método para eliminar un alquiler por ID
    public function eliminar($id) {
        $id = intval($id); // Asegurarse de que el ID sea un número entero
        
        $del = "DELETE FROM alquiler WHERE id_alquiler = $id";
        mysqli_query($this->conexion, $del);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "El alquiler ha sido eliminado con éxito";

        return $vec;
    }

    // Método para insertar un nuevo alquiler
    public function insertar($params) {
        $fecha = mysqli_real_escape_string($this->conexion, $params->fecha);
        $duracion = intval($params->duracion);
        $precio = doubleval($params->precio);
        $fo_auto = intval($params->fo_auto);
        $fo_cliente = intval($params->fo_cliente);

        $ins = "INSERT INTO alquiler (fecha, duracion, precio, fo_auto, fo_cliente)
                VALUES ('$fecha', $duracion, $precio, $fo_auto, $fo_cliente)";

        
    if (mysqli_query($this->conexion, $ins)) {
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Se ha registrado un nuevo alquiler";
    } else {
        $vec['resultado'] = "ERROR";
        $vec['mensaje'] = "Error al insertar: " . mysqli_error($this->conexion);
    }
        //mysqli_query($this->conexion, $ins);
        //$vec = [];
        //$vec['resultado'] = "OK";
        //$vec['mensaje'] = "Se ha registrado un nuevo alquiler";

        return $vec;
    }

    // Método para editar un alquiler existente
    public function editar($id, $params) {
        $id = intval($id);
        $fecha = mysqli_real_escape_string($this->conexion, $params->fecha);
        $duracion = intval($params->duracion);
        $precio = doubleval($params->precio);
        $fo_auto = intval($params->fo_auto);
        $fo_cliente = intval($params->fo_cliente);

        $editar = "UPDATE alquiler SET fecha = '$fecha', duracion = $duracion, precio = $precio,
                   fo_auto = $fo_auto, fo_cliente = $fo_cliente
                   WHERE id_alquiler = $id";
        mysqli_query($this->conexion, $editar);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Se ha actualizado el alquiler";

        return $vec;
    }

    // Método para filtrar alquileres por fecha
    public function filtro($valor) {
        $valor = mysqli_real_escape_string($this->conexion, $valor);
        $filtro = "SELECT * FROM alquiler WHERE fecha LIKE '%$valor%'";
        $res = mysqli_query($this->conexion, $filtro);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }
}
?>
