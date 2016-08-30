<?php

$conexion = "contractual";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
$conexionAgora = "agora";
$esteRecursoDBAgora = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionAgora);





if ($_REQUEST ['funcion'] == 'consultarDependencias') {

    $cadenaSql = $this->sql->getCadenaSql('dependenciasConsultadas', $_REQUEST ['valor']);
    $resultado = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultado);
    echo $resultado;
}
if ($_REQUEST ['funcion'] == 'consultarDependencia') {

    $cadenaSql = $this->sql->getCadenaSql('dependenciasConsultadas', $_REQUEST ['valor']);
    $resultado = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultado);

    echo $resultado;
}
if ($_REQUEST ['funcion'] == 'consultarServicios') {

    $cadenaSql = $this->sql->getCadenaSql('serviciosPorClase', $_REQUEST ['valor']);
    $resultado = $esteRecursoDBAgora->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultado);

    echo $resultado;
}
if ($_REQUEST ['funcion'] == 'consultarInfoConvenio') {

    $cadenaSql = $this->sql->getCadenaSql('informacion_convenio', $_REQUEST['codigo']);
    $resultadoItems = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

    $resultado = json_encode($resultadoItems [0]);

    echo $resultado;
}



if ($_REQUEST ['funcion'] == 'consultarProveedorFiltro') {

    $cadenaSql = $this->sql->getCadenaSql('buscarProveedoresFiltro', $_GET ['query']);
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
?>