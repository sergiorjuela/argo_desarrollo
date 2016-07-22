<?php

use contratos\registrarContrato\Sql;

$conexion = "contractual";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

$conexionSICA = "sicapital";
$DBSICA = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionSICA);

//---------------Obtener Numeros de Solicitud de Necesidad
if ($_REQUEST ['funcion'] == 'NumeroSolicitud') {

    $cadenaSql = $this->sql->getCadenaSql('ConsultarNumeroNecesidades', $_REQUEST ['valor']);
    $resultadoItems = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
    echo json_encode($resultadoItems);
}

if ($_REQUEST ['funcion'] == 'obtenerGeneros') {

    $cadenaSql = $this->sql->getCadenaSql('tipo_genero_ajax', $_REQUEST ['valor']);
    $resultadoItems = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
    echo json_encode($resultadoItems);
}
//-------------------------Obtener Solicitud y CDPs por Vigencia ----------------------------------------------------------
if ($_REQUEST ['funcion'] == 'ObtenerSolicitudesCdp') {

    $datos = array(0 => $_REQUEST ['unidad'], 1 => $_REQUEST ['vigencia']);
    $cadenaSql = $this->sql->getCadenaSql('obtener_solicitudes_vigencia', $datos);
    $resultadoItems = $DBSICA->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultadoItems);
    echo $resultado;
}
if ($_REQUEST ['funcion'] == 'ObtenerCdps') {

    $datos = array(1 => $_REQUEST ['numsol'], 0 => $_REQUEST ['vigencia'], 2 => $_REQUEST ['unidad'], 3 => $_REQUEST ['cdps']);
    $cadenaSql = $this->sql->getCadenaSql('obtener_cdp_numerosol', $datos);
    $resultadoItems = $DBSICA->ejecutarAcceso($cadenaSql, "busqueda");
    $resultado = json_encode($resultadoItems);
    echo $resultado;
}


if ($_REQUEST ['funcion'] == 'AlmacenarDatos') {

    $enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
    $miSesion = Sesion::singleton();
    $id_usuario = $miSesion->idUsuario();
    $arregloDatos = substr($_REQUEST ['valor'], 2, -2);
    $arregloDatos = str_replace("'", "", $arregloDatos);
    $arregloDatos = str_replace('"', "", $arregloDatos);
    $arregloDatos = explode(",", $arregloDatos);
    $idContratoTemp = str_replace(";", "", $arregloDatos[count($arregloDatos) - 1]);
    echo $idContratoTemp;
    $cadenaVerificarTemp = $this->sql->getCadenaSql('obtenerInfoTemporal', $idContratoTemp);
    $infoTemp = $esteRecursoDB->ejecutarAcceso($cadenaVerificarTemp, "busqueda");
    if ($infoTemp != false) {
        echo "entro";
        $cadenaEliminarInfoTemporal = $this->sql->getCadenaSql('eliminarInfoTemporal', $idContratoTemp);
        $infoTemp = $esteRecursoDB->ejecutarAcceso($cadenaEliminarInfoTemporal, "acceso");
        //var_dump($cadenaEliminarInfoTemporal);
    }

    for ($i = 0; $i < count($arregloDatos); $i++) {
        $Datos = explode(";", $arregloDatos[$i]);
        $infoCadena = array('campo' => substr($this->miConfigurador->fabricaConexiones->crypto->decodificar($Datos[1], $enlace), 0, -10),
            'informacion' => $Datos[0],
            'fecha' => date("Y-m-d"),
            'usuario' => $id_usuario,
            'id' => $idContratoTemp);
        $cadenaSql = $this->sql->getCadenaSql('insertarInformacionContratoTemporal', $infoCadena);
        var_dump($cadenaSql);
        $resultado = $esteRecursoDB->ejecutarAcceso($cadenaSql, "acceso");
    }
}

//-------------------------Obtener Proveedor ----------------------------------------------------------
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