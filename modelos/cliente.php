<?php
class Cliente {
    // Atributo de conexión
    public $conexion;

    // Constructor
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Método para consultar todos los clientes
    public function consulta() {
        $con = "SELECT * FROM cliente ORDER BY nombre, apellidos";
        $res = mysqli_query($this->conexion, $con);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }

    // Método para eliminar un cliente por ID
    public function eliminar($id) {
        $id = intval($id); // Asegurarse de que el ID sea un número entero
        $del = "DELETE FROM cliente WHERE id_cliente = $id";
        mysqli_query($this->conexion, $del);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "El cliente ha sido eliminado con éxito";

        return $vec;
    }

    // Método para insertar un nuevo cliente
    public function insertar($params) {
        $nombre = mysqli_real_escape_string($this->conexion, $params->nombre);
        $apellidos = mysqli_real_escape_string($this->conexion, $params->apellidos);
        $Cedula = intval($params->Cedula);
        $ciudad = mysqli_real_escape_string($this->conexion, $params->ciudad);
        $direccion = mysqli_real_escape_string($this->conexion, $params->direccion);
        $correo_electronico = mysqli_real_escape_string($this->conexion, $params->correo_electronico);

        $ins = "INSERT INTO cliente (nombre, apellidos, Cedula, ciudad, direccion, correo_electronico)
                VALUES ('$nombre', '$apellidos', $Cedula, '$ciudad', '$direccion', '$correo_electronico')";
        mysqli_query($this->conexion, $ins);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Se ha registrado un nuevo cliente";

        return $vec;
    }

    // Método para editar un cliente existente
    public function editar($id, $params) {
        $id = intval($id);
        $nombre = mysqli_real_escape_string($this->conexion, $params->nombre);
        $apellidos = mysqli_real_escape_string($this->conexion, $params->apellidos);
        $Cedula = intval($params->Cedula);
        $ciudad = mysqli_real_escape_string($this->conexion, $params->ciudad);
        $direccion = mysqli_real_escape_string($this->conexion, $params->direccion);
        $correo_electronico = mysqli_real_escape_string($this->conexion, $params->correo_electronico);

        $editar = "UPDATE cliente SET nombre = '$nombre', apellidos = '$apellidos', Cedula = $Cedula,
                   ciudad = '$ciudad', direccion = '$direccion', correo_electronico = '$correo_electronico'
                   WHERE id_cliente = $id";
        mysqli_query($this->conexion, $editar);
        $vec = [];
        $vec['resultado'] = "OK";
        $vec['mensaje'] = "Se ha actualizado la información del cliente";

        return $vec;
    }

    // Método para filtrar clientes por nombre o apellidos
    public function filtro($valor) {
        $valor = mysqli_real_escape_string($this->conexion, $valor);
        $filtro = "SELECT * FROM cliente WHERE nombre LIKE '%$valor%' OR apellidos LIKE '%$valor%'";
        $res = mysqli_query($this->conexion, $filtro);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }
        return $vec;
    }
}
?>
