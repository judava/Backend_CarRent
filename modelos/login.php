<?php
class Login {
    // Atributo de conexión
    public $conexion;

    // Constructor
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Método para consultar todos los alquileres
    public function consulta($email, $clave) {
        $con = "SELECT * FROM usuario WHERE email='$email' && clave = sha1('$clave')";
        $res = mysqli_query($this->conexion, $con);
        $vec = [];

        while ($row = mysqli_fetch_array($res)) {
            $vec[] = $row;
        }

        if($vec==[]){
            $vec[0] = array("validar"=>"no valida");
        } else {
            $vec[0]['validar'] ="valida";
        }
        return $vec;
    }

    
}
?>
