
<?php

use servicios\servicio\Funcion;

$conexion = "contractual";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
if (isset($_REQUEST ['servicio']) && $_REQUEST ['servicio'] != '') {
    
   
    if (isset($_REQUEST['variable1']) && isset($_REQUEST['variable2'])){
       $datos = array('id_orden' => $_REQUEST['variable1'],
                      'fecha' => $_REQUEST['variable2']); 
    }else{
        $datos = array('id_orden' => $_REQUEST['variable1']);
    }
  
    $cadena_sql = $this->sql->getCadenaSql("elementos_orden",$datos);
    $resultado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
    var_dump($cadena_sql);

    if ($resultado != false) {
        $this->deliver_response(200, "Elementos Encontrados", $resultado);
    } else {
        $this->deliver_response(300, "No se encontraron elementos", null);
    }
} else {
    $this->deliver_response(400, "Peticion Invalida", null);
}
