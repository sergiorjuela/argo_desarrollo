<?php

namespace gestionContractual\contratos\modificarContrato\funcion;

use \contratos\modificarContrato\funcion\redireccion;

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

        if (isset($_REQUEST['multiple']) && $_REQUEST['multiple'] = "true") {
            $datos = stripslashes($_REQUEST['datos']);
            $datos = urldecode($datos);
            $datos = unserialize($datos);
            for ($i = 0; $i < count($datos); $i++) {
                $SQLEstadoAprobacion = $this->miSql->getCadenaSql('updateEstadoAprobacion', $datos[$i]);
                array_push($SQLs, $SQLEstadoAprobacion);
                $datosAprobacion = array(
                    'numero_contrato' => $datos[$i]['numero_contrato'],
                    'vigencia' => $datos[$i]['vigencia'],
                    'fecha_aprobacion' => date("Y-m-d"),
                    'usuario' => $_REQUEST['usuario'],
                    'estado' => 3
                );
                $datosestado = array(
                    'numero_contrato' => $datos[$i]['numero_contrato'],
                    'vigencia' => $datos[$i]['vigencia'],
                    'fecha_aprobacion' => date('Y-m-d H:i:s'),
                    'usuario' => $_REQUEST['usuario'],
                    'estado' => 3
                );
                $SQLAprobarContrato = $this->miSql->getCadenaSql('aprobarContrato', $datosAprobacion);
                array_push($SQLs, $SQLAprobarContrato);

                $SQLEstadoContrato = $this->miSql->getCadenaSql('cambioEstadoAprobarContrato', $datosestado);
                array_push($SQLs, $SQLEstadoContrato);
            }
            $trans_aprobar_contratos = $esteRecursoDB->transaccion($SQLs);

            if ($trans_aprobar_contratos != false) {
                redireccion::redireccionar('aproboContratos', $datos);
            } else {
                redireccion::redireccionar('noAproboContratos', $datos);
            }
        } else {
            $datos = array(
                
                'numero_contrato' => $_REQUEST['numero_contrato'],
                'vigencia' => $_REQUEST['vigencia'],
            );


            $SQLEstadoAprobacion = $this->miSql->getCadenaSql('updateEstadoAprobacion', $datos);
            array_push($SQLs, $SQLEstadoAprobacion);

            $datosAprobacion = array(
                
                'numero_contrato' => $_REQUEST['numero_contrato'],
                'vigencia' => $_REQUEST['vigencia'],
                'fecha_aprobacion' => date("Y-m-d"),
                'usuario' => $_REQUEST['usuario']
            );


            $SQLAprobarContrato = $this->miSql->getCadenaSql('aprobarContrato', $datosAprobacion);

            array_push($SQLs, $SQLAprobarContrato);

            $datosEstadoContrato = array(
                'numero_contrato' => $_REQUEST['numero_contrato'],
                'vigencia' => $_REQUEST['vigencia'],
                'fecha_aprobacion' => date('Y-m-d H:i:s'),
                'usuario' => $_REQUEST['usuario'],
                'estado' => 3
            );

            $SQLEstadoContrato = $this->miSql->getCadenaSql('cambioEstadoAprobarContrato', $datosEstadoContrato);
            array_push($SQLs, $SQLEstadoContrato);

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