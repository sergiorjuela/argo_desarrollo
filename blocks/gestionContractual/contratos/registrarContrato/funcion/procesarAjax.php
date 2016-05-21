<?php

use contratos\registrarContrato\Sql;

$conexion = "contractual";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

//---------------Obtener Numeros de Solicitud de Necesidad
if ($_REQUEST ['funcion'] == 'NumeroSolicitud') {

    $cadenaSql = $this->sql->getCadenaSql('ConsultarNumeroNecesidades', $_REQUEST ['valor']);
    $resultadoItems = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
    echo json_encode($resultadoItems);
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
    if($infoTemp != false){
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
?>