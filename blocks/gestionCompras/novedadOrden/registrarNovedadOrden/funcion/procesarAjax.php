<?php

use contratos\modificarContrato\Sql;

$conexion = "contractual";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
$conexionSICA = "sicapital";
$DBSICA = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionSICA);
if ($_REQUEST ['funcion'] == 'NumeroSolicitud') {

    $cadenaSql = $this->sql->getCadenaSql('ConsultarNumeroNecesidades', $_REQUEST ['valor']);
    echo $cadenaSql;
    exit;
    $resultadoItems = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

    echo json_encode($resultadoItems);
}

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

if ($_REQUEST ['funcion'] == 'ObtenerCdps') {

    $datos = array(1 => $_REQUEST ['numsol'], 0 => $_REQUEST ['vigencia'], 2 => $_REQUEST ['unidad'], 3 => $_REQUEST ['cdps'],
        4 => $_REQUEST ['cdpsNovedades']);
    $cadenaSql = $this->sql->getCadenaSql('obtener_cdp_numerosol', $datos);
    $resultadoItems = $DBSICA->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultadoItems);
    echo $resultado;
}

if ($_REQUEST ['funcion'] == 'consultarNumeroOrden') {
    $datos = array('tipo_orden' => $_REQUEST ['valor1'], 'unidad' => $_REQUEST ['valor2']);
    $cadenaSql = $this->sql->getCadenaSql('buscar_numero_orden', $datos);

    $resultado = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

    $resultado = json_encode($resultado);

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

if ($_REQUEST ['funcion'] == 'consultarDependencia') {

    $cadenaSql = $this->sql->getCadenaSql('dependenciasConsultadas', $_REQUEST ['valor']);
    $resultado = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultado);
    echo $resultado;
}

if ($_REQUEST ['funcion'] == 'ObtenerSolicitudesCdp') {

    $datos = array(0 => $_REQUEST ['vigencia'], 1 => $_REQUEST ['unidad']);
    $cadenaSql = $this->sql->getCadenaSql('obtener_solicitudes_vigencia', $datos);
    $resultadoItems = $DBSICA->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultadoItems);
    echo $resultado;
}
if ($_REQUEST ['funcion'] == 'Infodisponibilidades') {

    $arreglo = array(
        $_REQUEST ['disponibilidad'],
        $_REQUEST ['numsolicitud'],
        $_REQUEST ['vigencia'],
        $_REQUEST ['unidad']
    );

    $cadenaSql = $this->sql->getCadenaSql('info_disponibilidad', $arreglo);
    $resultadoItems = $DBSICA->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultadoItems [0]);

    echo $resultado;
}

if ($_REQUEST ['funcion'] == 'consultarInfoConvenio') {

    $cadenaSql = $this->sql->getCadenaSql('informacion_convenio', $_REQUEST['codigo']);
    $resultadoItems = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

    $resultado = json_encode($resultadoItems [0]);

    echo $resultado;
}
if ($_REQUEST ['funcion'] == 'consultaProveedor') {

    $parametro = $_REQUEST ['proveedor'];
    $enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
    $url = "http://10.20.2.38/agora/index.php?";
    $data = "pagina=servicio&servicios=true&servicio=servicioArgoProveedor&parametro1=$parametro";
    $url_servicio = $url . $this->miConfigurador->fabricaConexiones->crypto->codificar_url($data, $enlace);
    $cliente = curl_init();
    curl_setopt($cliente, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($cliente, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($cliente, CURLOPT_URL, $url_servicio);
    $repuestaWeb = curl_exec($cliente);
    curl_close($cliente);
    $repuestaWeb = explode("<json>", $repuestaWeb);
    echo $repuestaWeb[1];
}
?>