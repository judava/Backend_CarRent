<?php
    $servidor ="localhost:3306";
    $usuario = "root";
    $clave = "";
    $bd = "alquiler_autos";

    $conexion= mysqli_connect($servidor,$usuario,$clave) or die('no se encontro el servidor');
    mysqli_select_db($conexion,$bd) or die('no se encontro la base de datos');
    mysqli_set_charset($conexion,"utf8");
    //echo "Conexion base de datos perfecta"
?>