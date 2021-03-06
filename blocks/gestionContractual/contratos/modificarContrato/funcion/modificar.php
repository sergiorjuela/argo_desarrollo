<?php

namespace contratos\modificarContrato\funcion;

use contratos\modificarContrato\funcion\redireccion;

// include_once ('redireccionar.php');
if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

class RegistradorContrato {

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
        $conexion = "contractual";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);


        //Validacion campos nulos de tipo compromiso y clase contratista

        if ($_REQUEST ['tipo_compromiso'] != '34') {
            $numero_convenio = 0;
            $vigencia_convenio = 0;
        } else {
            $numero_convenio = $_REQUEST ['numero_convenio'];
            $vigencia_convenio = $_REQUEST ['vigencia_convenio'];
        }
        if ($_REQUEST ['clase_contratista'] == "33") {
            $porcentaje_contratista = 0;
        } else {
            $porcentaje_contratista = $_REQUEST ['porcentaje_clase_contratista'];
        }

        //Validacion campos nulos de fecha de inicio y finalizacion
        if (isset($_REQUEST ['fecha_final_poliza']) && $_REQUEST ['fecha_final_poliza'] != "") {
            $fecha_final_poliza = "'" . $_REQUEST ['fecha_final_poliza'] . "'";
        } else {
            $fecha_final_poliza = 'NULL';
        }
        if (isset($_REQUEST ['fecha_inicio_poliza']) && $_REQUEST ['fecha_inicio_poliza'] != "") {
            $fecha_inicio_poliza = "'" . $_REQUEST ['fecha_inicio_poliza'] . "'";
        } else {
            $fecha_inicio_poliza = 'NULL';
        }
        //Validacion campos nulos de moneda y tasa extranjera
        if (isset($_REQUEST ['valor_contrato_moneda_ex']) && $_REQUEST ['valor_contrato_moneda_ex'] != "") {
            $valor_moneda_extranjera = $_REQUEST ['valor_contrato_moneda_ex'];
        } else {
            $valor_moneda_extranjera = 0;
        }
        if (isset($_REQUEST ['tasa_cambio']) && $_REQUEST ['tasa_cambio'] != "") {
            $tasa_cambio = $_REQUEST ['tasa_cambio'];
        } else {
            $tasa_cambio = 0;
        }
        // Determinar la Unidad Ejecutora
        
        //Obtener la Clausula de Presupuesto
        if (isset($_POST['clausula_presupuesto'])) {
            $clausula_presupuesto = $_POST['clausula_presupuesto'];
        } else {
            $clausula_presupuesto = 'false';
        }

        $SqlCargoSupervisor = $this->miSql->getCadenaSql('obtener_cargo_supervisro', $_REQUEST ['supervisor']);
        $cargo = $esteRecursoDB->ejecutarAcceso($SqlCargoSupervisor, "busqueda");


        $arreglo_contrato_general = array(
            'tipo_contrato' => $_REQUEST['clase_contrato'],
            'unidad_ejecutura' => $_REQUEST ['unidad_ejecutora_hidden'],
            'objeto_contrato' => $_REQUEST ['objeto_contrato'],
            'fecha_inicio' => $fecha_inicio_poliza,
            'fecha_fin' => $fecha_final_poliza,
            'plazo_ejecucion' => $_REQUEST ['plazo_ejecucion'],
            'clausula_presupuesto' => $clausula_presupuesto,
            'ordenador_gasto' => $_REQUEST ['ordenador_gasto'],
            'valor_contrato' => $_REQUEST ['valor_contrato'],
            'supervisor' => $_REQUEST ['supervisor'],
            'cargo_supervisor' => $cargo[0]['cargo'],
            'forma_pago' => $_REQUEST ['formaPago'],
            'numero_contrato' => $_REQUEST ['numero_contrato'],
            'contratista' => $_REQUEST ['numero_identificacion'],
            'nombre_contratista' => $_REQUEST ['nombre_Razon_Social'],
            "unidad_ejecucion_tiempo" => $_REQUEST ['unidad_ejecucion_tiempo'],
            'vigencia' => $_REQUEST ['vigencia']);


        $SqlcontratoGeneral = $this->miSql->getCadenaSql('actualizarContratoGeneral', $arreglo_contrato_general);
        array_push($SQLs, $SqlcontratoGeneral);

        $arreglo_contrato = array(
            "tipo_configuracion" => 0,
            "clase_contratista" => $_REQUEST ['clase_contratista'],
            "identificacion_clase_contratista" => $_REQUEST ['identificacion_clase_contratista'],
            "digito_verificacion_clase_contratista" => $_REQUEST ['digito_verificacion_clase_contratista'],
            "porcentaje_clase_contratista" => $porcentaje_contratista,
            "tipo_compromiso" => $_REQUEST ['tipo_compromiso'],
            "numero_convenio" => $numero_convenio,
            "vigencia_convenio" => $vigencia_convenio,
            "fecha_subcripcion" => $_REQUEST ['fecha_subcripcion'],
            "dependencia" => $_REQUEST ['dependencia'],
            "tipologia_especifica" => $_REQUEST ['tipologia_especifica'],
            "numero_constancia" => $_REQUEST ['numero_constancia'],
            "modalidad_seleccion" => $_REQUEST ['modalidad_seleccion'],
            "procedimiento" => $_REQUEST ['procedimiento'],
            "regimen_contratación" => $_REQUEST ['regimen_contratación'],
            "tipo_moneda" => $_REQUEST ['tipo_moneda'],
            "tipo_gasto" => $_REQUEST ['tipo_gasto'],
            "origen_recursos" => $_REQUEST ['origen_recursos'],
            "origen_presupuesto" => $_REQUEST ['origen_presupuesto'],
            "tema_gasto_inversion" => $_REQUEST ['tema_gasto_inversion'],
            "valor_contrato_moneda_ex" => $valor_moneda_extranjera,
            "tasa_cambio" => $tasa_cambio,
            "observacionesContrato" => $_REQUEST ['observacionesContrato'],
            "tipo_control" => $_REQUEST ['tipo_control'],
            "digito_supervisor" => $_REQUEST ['digito_supervisor'],
            "fecha_suscrip_super" => $_REQUEST ['fecha_suscrip_super'],
            "fecha_limite" => $_REQUEST ['fecha_limite'],
            "observaciones_interventoria" => $_REQUEST ['observaciones_interventoria'],
            "fecha_registro" => date('Y-m-d'),
            'id_contrato_normal' => $_REQUEST ['id_contrato_normal']
        );

        $SqlContrato = $this->miSql->getCadenaSql('Actualizar_Contrato', $arreglo_contrato);
        array_push($SQLs, $SqlContrato);

        $trans_Editar_contrato = $esteRecursoDB->transaccion($SQLs);

        $datos = array("numero_contrato" => $_REQUEST['numero_contrato'],
            "vigencia" => $_REQUEST['vigencia']);

        if ($trans_Editar_contrato != false) {
            $cadenaVerificarTemp = $this->miSql->getCadenaSql('obtenerInfoTemporal', $_REQUEST["atributosContratoTempHidden"]);
            $infoTemp = $esteRecursoDB->ejecutarAcceso($cadenaVerificarTemp, "busqueda");
            if ($infoTemp != false) {
                $cadenaEliminarInfoTemporal = $this->miSql->getCadenaSql('eliminarInfoTemporal', $_REQUEST["atributosContratoTempHidden"]);
                $esteRecursoDB->ejecutarAcceso($cadenaEliminarInfoTemporal, "acceso");
            }
            redireccion::redireccionar("Actualizo", $datos);

            exit();
        } else {
            redireccion::redireccionar("NoActualizo", $datos);

            exit();
        }
    }

}

$miRegistrador = new RegistradorContrato($this->lenguaje, $this->sql, $this->funcion);

$resultado = $miRegistrador->procesarFormulario();
?>