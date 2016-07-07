<?php

namespace gestionCompras\consultaOrden\funcion;

use gestionCompras\consultaOrden\funcion\redireccion;

include_once ('redireccionar.php');
if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

class RegistradorOrden {

    var $miConfigurador;
    var $lenguaje;
    var $miFormulario;
    var $miFuncion;
    var $miSql;
    var $conexion;

    function __construct($lenguaje, $sql, $funcion) {
        $this->miConfigurador = \Configurador::singleton();
        $this->miConfigurador->fabricaConexiones->setRecursoDB('principal');
        $this->lenguaje = $lenguaje;
        $this->miSql = $sql;
        $this->miFuncion = $funcion;
    }

    function procesarFormulario() {

        $conexion = "contractual";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
        $SQLs = [];
        $datos = array(
            'id_orden' => $_REQUEST['id_orden'],
            'numero_contrato' => $_REQUEST['numero_contrato'],
            'vigencia' => $_REQUEST['vigencia'],
        );


        $SQLEstadoAprobacion = $this->miSql->getCadenaSql('updateEstadoAprobacion', $datos);
        array_push($SQLs, $SQLEstadoAprobacion);

        $datosAprobacion = array(
            'id_orden' => $_REQUEST['id_orden'],
            'numero_contrato' => $_REQUEST['numero_contrato'],
            'vigencia' => $_REQUEST['vigencia'],
            'fecha_aprobacion' => date("Y-m-d"),
            'usuario' => $_REQUEST['usuario']
        );

        $SQLAprobarContrato = $this->miSql->getCadenaSql('aprobarContrato', $datosAprobacion);
        array_push($SQLs, $SQLAprobarContrato);
        $trans_aprobar_contrato = $esteRecursoDB->transaccion($SQLs);

        if ($trans_aprobar_contrato != false) {
            $sqlConsecutivoContrato = $this->miSql->getCadenaSql('obteneConsecutivoContratoAprobado');
            $resultado = $esteRecursoDB->ejecutarAcceso($sqlConsecutivoContrato, "busqueda");
            $consecutivoUnico = $resultado[0][0];
            array_push($datosAprobacion, $consecutivoUnico);
            redireccion::redireccionar('aproboContrato', $datosAprobacion);
            
        } else {
            redireccion::redireccionar('noAproboContrato', $datos);
        }
    }

    function resetForm() {
        foreach ($_REQUEST as $clave => $valor) {

            if ($clave != 'pagina' && $clave != 'development' && $clave != 'jquery' && $clave != 'tiempo') {
                unset($_REQUEST [$clave]);
            }
        }
    }

}

$miRegistrador = new RegistradorOrden($this->lenguaje, $this->sql, $this->funcion);

$resultado = $miRegistrador->procesarFormulario();
?>