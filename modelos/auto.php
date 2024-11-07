<?php
class Auto {
    // Atributo de conexión
    public $conexion;

    // Constructor
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Método para consultar todos los autos
    public function consulta() {
        $con = "SELECT * FROM auto ORDER BY marca, modelo";
        $res = mysqli_query($this->conexion, $con);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }

    // Método para eliminar un auto por ID

    public function eliminar($id) {
        $id = intval($id); // Asegúrate de que el ID sea un número entero
    
        // Eliminar primero las referencias en la tabla `reserva`
        $delReservas = "DELETE FROM reserva WHERE fo_auto = $id";
        mysqli_query($this->conexion, $delReservas);
    
        // Luego, elimina el auto
        $delAuto = "DELETE FROM auto WHERE id_auto = $id";
        if (mysqli_query($this->conexion, $delAuto)) {
            $vec = ["resultado" => "OK", "mensaje" => "El auto y sus reservas asociadas han sido eliminados con éxito"];
        } else {
            $vec = ["resultado" => "ERROR", "mensaje" => "Error al eliminar el auto"];
        }
    
        return $vec;
    }
    
    /*public function eliminar($id) {
        $id = intval($id); // Asegurarse de que el ID sea un número entero
        $del = "DELETE FROM auto WHERE id_auto = $id";                          //"DELETE FROM auto WHERE id_auto = $id";
        mysqli_query($this->conexion, $del);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "El auto ha sido eliminado con éxito";

        return $vec;
    }*/

    // Método para insertar un nuevo auto
    public function insertar($params) {
        $marca = mysqli_real_escape_string($this->conexion, $params->marca);
        $modelo = intval($params->modelo);
        $numero_placa = mysqli_real_escape_string($this->conexion, $params->numero_placa);
        $caracteristicas = mysqli_real_escape_string($this->conexion, $params->caracteristicas);
        $disponibilidad = intval($params->disponibilidad);
        $tiempo_alquiler = mysqli_real_escape_string($this->conexion, $params->tiempo_alquiler);
        $precio = doubleval($params->precio);

        $ins = "INSERT INTO auto (marca, modelo, numero_placa, caracteristicas, disponibilidad, tiempo_alquiler, precio)
                VALUES ('$marca', $modelo, '$numero_placa', '$caracteristicas', $disponibilidad, '$tiempo_alquiler', $precio)";
        mysqli_query($this->conexion, $ins);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Se ha registrado un nuevo auto";

        return $vec;
    }

    // Método para editar un auto existente
    public function editar($id, $params) {
        $id = intval($id);
        $marca = mysqli_real_escape_string($this->conexion, $params->marca);
        $modelo = intval($params->modelo);
        $numero_placa = mysqli_real_escape_string($this->conexion, $params->numero_placa);
        $caracteristicas = mysqli_real_escape_string($this->conexion, $params->caracteristicas);
        $disponibilidad = intval($params->disponibilidad);
        $tiempo_alquiler = mysqli_real_escape_string($this->conexion, $params->tiempo_alquiler);
        $precio = doubleval($params->precio);

        $editar = "UPDATE auto SET marca = '$marca', modelo = $modelo, numero_placa = '$numero_placa',
                   caracteristicas = '$caracteristicas', disponibilidad = $disponibilidad, 
                   tiempo_alquiler = '$tiempo_alquiler', precio = $precio
                   WHERE id_auto = $id";
        mysqli_query($this->conexion, $editar);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Se ha actualizado la información del auto";

        return $vec;
    }

    // Método para filtrar autos por marca o características
    public function filtro($valor) {
        $valor = mysqli_real_escape_string($this->conexion, $valor);
        $filtro = "SELECT * FROM auto WHERE marca LIKE '%$valor%' OR caracteristicas LIKE '%$valor%'";
        $res = mysqli_query($this->conexion, $filtro);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }
}
?>
