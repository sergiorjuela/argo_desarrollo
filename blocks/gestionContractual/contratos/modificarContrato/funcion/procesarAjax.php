<?php

use contratos\modificarContrato\Sql;

$conexion = "contractual";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

if ($_REQUEST ['funcion'] == 'obtenerGeneros') {

    $cadenaSql = $this->sql->getCadenaSql('tipo_genero_ajax', $_REQUEST ['valor']);
    $resultadoItems = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
    echo json_encode($resultadoItems);
}

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
if ($_REQUEST ['funcion'] == 'AlmacenarDatos') {

    $enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
    $miSesion = Sesion::singleton();
    $id_usuario = $miSesion->idUsuario();
    $arregloDatos = substr($_REQUEST ['valor'], 2, -2);
    $arregloDatos = str_replace("'", "", $arregloDatos);
    $arregloDatos = str_replace('"', "", $arregloDatos);
    $arregloDatos = explode(",", $arregloDatos);
    $idContratoTemp = $arregloDatos[count($arregloDatos) - 1];
    $cadenaVerificarTemp = $this->sql->getCadenaSql('obtenerInfoTemporal', $idContratoTemp);
    $infoTemp = $esteRecursoDB->ejecutarAcceso($cadenaVerificarTemp, "busqueda");
    if ($infoTemp != false) {

        $cadenaEliminarInfoTemporal = $this->sql->getCadenaSql('eliminarInfoTemporal', $idContratoTemp);
        $infoTemp = $esteRecursoDB->ejecutarAcceso($cadenaEliminarInfoTemporal, "acceso");
    }

    for ($i = 0; $i < count($arregloDatos); $i++) {
        $Datos = explode(";", $arregloDatos[$i]);
        $infoCadena = array('campo' => substr($this->miConfigurador->fabricaConexiones->crypto->decodificar($Datos[1], $enlace), 0, -10),
            'informacion' => $Datos[0],
            'fecha' => date("Y-m-d"),
            'usuario' => $id_usuario,
            'id' => $idContratoTemp);
        $cadenaSql = $this->sql->getCadenaSql('insertarInformacionContratoTemporal', $infoCadena);
        $resultado = $esteRecursoDB->ejecutarAcceso($cadenaSql, "acceso");
        var_dump($resultado);
    }
}

if ($_REQUEST ['funcion'] == 'consultaProveedor') {
    
    $parametro = $_REQUEST ['proveedor'];
    $enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
    $url = "http://10.20.0.38/agora/index.php?";
    $data = "pagina=servicio&servicios=true&servicio=servicioArgoProveedor&Parametro1=$parametro";
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