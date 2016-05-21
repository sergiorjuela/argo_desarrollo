<?php

use contratos\movimientoContrato\Sql;

$conexion = "contractual";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

if ($_REQUEST ['funcion'] == 'consultaContrato') {

    $cadenaSql = $this->sql->getCadenaSql('buscar_contrato', $_GET ['query']);
    $resultadoItems = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

    foreach ($resultadoItems as $key => $values) {
        $keys = array(
            'value',
            'data'
        );
        $resultado [$key] = array_intersect_key($resultadoItems [$key], array_flip($keys));
    }
    echo '{"suggestions":' . json_encode($resultado) . '}';
}

if ($_REQUEST ['funcion'] == 'consultaContratista') {
    $cadenaSql = $this->sql->getCadenaSql('buscar_contratista', $_GET ['query']);

    $resultadoItems = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

    foreach ($resultadoItems as $key => $values) {
        $keys = array(
            'value',
            'data'
        );
        $resultado [$key] = array_intersect_key($resultadoItems [$key], array_flip($keys));
    }
    echo '{"suggestions":' . json_encode($resultado) . '}';
}

if ($_REQUEST ['funcion'] == 'consultaDisponibilidad') {

    $cadenaSql = $this->sql->getCadenaSql('buscar_disponibilidades', $_GET);
    $resultadoItems = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
    
    $resultado = json_encode($resultadoItems);
    echo $resultado;
}

if ($_REQUEST ['funcion'] == 'consultaRegistro') {
    
echo    $cadenaSql = $this->sql->getCadenaSql('buscar_registro', $_GET['valor']);
    $resultadoItems = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
    
    $resultado = json_encode($resultadoItems);
    echo $resultado;
}
?>