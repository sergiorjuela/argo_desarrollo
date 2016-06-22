
<?php

use servicios\servicio\Funcion;

$conexion = "contractual";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
if (isset($_REQUEST ['servicio']) && $_REQUEST ['servicio'] != '') {


    $cadena_sql = $this->sql->getCadenaSql("servicio_ordenes");
    $resultado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
    if ($resultado != false) {
        $this->deliver_response(200, "Ordenes Encontradas", $resultado);
    } else {
        $this->deliver_response(300, "No se encontraron Ordenes", null);
    }
} else {
    $this->deliver_response(400, "Peticion Invalida", null);
}
