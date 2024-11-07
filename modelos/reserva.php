<?php
class Reserva {
    // Atributo de conexión
    public $conexion;

    // Constructor
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Método para consultar todas las reservas
    public function consulta() {
        $con = "SELECT * FROM reserva ORDER BY fecha";
        $res = mysqli_query($this->conexion, $con);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }

    // Método para eliminar una reserva por ID
    public function eliminar($id) {
        $id = intval($id); // Asegurarse de que el ID sea un número entero
        $del = "DELETE FROM reserva WHERE id_reserva = $id";
        mysqli_query($this->conexion, $del);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "La reserva ha sido eliminada con éxito";

        return $vec;
    }

    // Método para insertar una nueva reserva
    public function insertar($params) {
        $fecha = mysqli_real_escape_string($this->conexion, $params->fecha);
        $duracion = mysqli_real_escape_string($this->conexion, $params->duracion);
        $precio = doubleval($params->precio);
        $fo_auto = intval($params->fo_auto);
        $fo_cliente = intval($params->fo_cliente);

        $ins = "INSERT INTO reserva (fecha, duracion, precio, fo_auto, fo_cliente)
                VALUES ('$fecha', '$duracion', $precio, $fo_auto, $fo_cliente)";
        mysqli_query($this->conexion, $ins);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Se ha registrado una nueva reserva";

        return $vec;
    }

    // Método para editar una reserva existente
    public function editar($id, $params) {
        $id = intval($id);
        $fecha = mysqli_real_escape_string($this->conexion, $params->fecha);
        $duracion = mysqli_real_escape_string($this->conexion, $params->duracion);
        $precio = doubleval($params->precio);
        $fo_auto = intval($params->fo_auto);
        $fo_cliente = intval($params->fo_cliente);

        $editar = "UPDATE reserva SET fecha = '$fecha', duracion = '$duracion', precio = $precio,
           fo_auto = $fo_auto, fo_cliente = $fo_cliente
           WHERE id_reserva = $id";

        mysqli_query($this->conexion, $editar);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Se ha actualizado la reserva";

        return $vec;
    }

    // Método para filtrar reservas por fecha
    public function filtro($valor) {
        $valor = mysqli_real_escape_string($this->conexion, $valor);
        $filtro = "SELECT * FROM reserva WHERE fecha LIKE '%$valor%'";
        $res = mysqli_query($this->conexion, $filtro);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }
}
?>
