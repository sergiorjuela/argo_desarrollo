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

      
        $SQLs = [];
        $Identificadores = array('numero_contrato' => $_REQUEST['numerocontrato'],
            'vigencia' => $_REQUEST['vigencia'],
            'id_orden' => $_REQUEST['id_orden']);

        $conexion = "contractual";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
       
        if ($_REQUEST ['identificador_unidad']==1) {
            $unidad_ejecutura = 209;
            $sede_solicitante = $_REQUEST ['sede'];
            $dependencia_solicitante = $_REQUEST ['dependencia_solicitante'];
        } else {
            $unidad_ejecutura = 208;
            $sede_solicitante = $_REQUEST ['sede_idexud'];
            $dependencia_solicitante = $_REQUEST ['convenio_solicitante'];
        }
       
        if (isset($_POST['clausula_presupuesto'])) {
            $clausula_presupuesto = $_POST['clausula_presupuesto'];
            if ($clausula_presupuesto = 't') {
                $clausula_presupuesto = 'true';
            }
        } else {
            $clausula_presupuesto = 'false';
        }
        if (isset($_REQUEST ['fecha_inicio_pago']) && $_REQUEST ['fecha_inicio_pago'] != '') {
            $fecha_inicio = "'" . $_REQUEST ['fecha_inicio_pago'] . "'";
        } else {
            $fecha_inicio = 'null';
        }
        if (isset($_REQUEST ['fecha_final_pago']) && $_REQUEST ['fecha_final_pago'] != '') {
            $fecha_fin = "'" . $_REQUEST ['fecha_final_pago'] . "'";
        } else {
            $fecha_fin = 'null';
        }


        $datosContratoGeneral = array(
            'id_orden_contrato' => 1,
            'tipo_contrato' => 98,
            'unidad_ejecutura' => $unidad_ejecutura,
            'objeto_contrato' => $_REQUEST ['objeto_contrato'],
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'plazo_ejecucion' => $_REQUEST ['plazo_ejecucion'],
            'clausula_presupuesto' => $clausula_presupuesto,
            'ordenador_gasto' => $_REQUEST ['asignacionOrdenador'],
            'supervisor' => $_REQUEST ['nombre_supervisor'],
            'sede_supervisor' => $_REQUEST ['sede_super'],
            'dependencia_supervisor' => $_REQUEST ['dependencia_supervisor'],
            'cargo_supervisor' => $_REQUEST ['cargo_supervisor'],
            'numero_contrato' => $Identificadores['numero_contrato'],
            'vigencia' => $Identificadores['vigencia'],
            'sede_solicitante' => $sede_solicitante,
            'dependencia_solicitante' => $dependencia_solicitante,
            'forma_pago' => $_REQUEST ['formaPago']);



        $datosOrden = array('tipo_orden' => $_REQUEST ['tipo_orden'],
            'id_orden' => $Identificadores['id_orden'],
            'unidad_ejecucion' => $_REQUEST ['unidad_ejecucion'],
            'nombre_proveedor' => $_REQUEST ['nombre_razon_proveedor'],
            'proveedor' => $_REQUEST ['identifcacion_proveedor']);



        $PolizasOrden = array('numero_contrato' => "curval('id_orden_seq')",
            'poliza' => "curval('numero_unico_contrato_seq')",
            'numero_contrato' => "currval('numero_unico_contrato_seq')");

        $polizas = [];
        for ($i = 0; $i < count($_POST); $i++) {
            if (isset($_POST["poliza" . "$i"])) {
                array_push($polizas, $i);
            }
        }

        // Registro Contrato General
        $SQLsContratoGeneral = $this->miSql->getCadenaSql('updateContratoGeneral', $datosContratoGeneral);
        array_push($SQLs, $SQLsContratoGeneral);
        // Registro Orden
        $SQLsOrden = $this->miSql->getCadenaSql('updateOrden', $datosOrden);
        array_push($SQLs, $SQLsOrden);
        // Registro de Polizas

        $sqlEliminarPolizas = $this->miSql->getCadenaSql('elimnarPolizas', $Identificadores['id_orden']);
        $resultado = $esteRecursoDB->ejecutarAcceso($sqlEliminarPolizas, "acceso");

        if ($resultado == false) {
            redireccion::redireccionar('noInserto', $datos);
        } else {

            for ($i = 0; $i < count($polizas); $i++) {
                $datosPoliza = array('poliza' => $polizas[$i],
                    'orden' => $Identificadores['id_orden']);
                $sqlPoliza = $this->miSql->getCadenaSql('insertarPoliza', $datosPoliza);
                array_push($SQLs, $sqlPoliza);
            }
        }


        $trans_actualizacion_orden = $esteRecursoDB->transaccion($SQLs);

        $datos = array('numero_contrato' => $Identificadores['numero_contrato'],
            'vigencia' => $Identificadores['vigencia']);

       
        if ($trans_actualizacion_orden != false) {
            $this->miConfigurador->setVariableConfiguracion("cache", true);
            
            redireccion::redireccionar('actualizoOrden', $datos);
        } else {

            redireccion::redireccionar('noActualizo', $datos);
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