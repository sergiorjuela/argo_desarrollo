<?php

namespace gestionCompras\novedad\registrarNovedad;

use gestionCompras\novedad\registrarNovedad;

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


        $conexion = "contractual";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
        $rutaBloque = $this->miConfigurador->getVariableConfiguracion("raizDocumento") . "/blocks/gestionCompras/novedadOrden/";
        $rutaBloque .= $esteBloque ['nombre'];
        $host = $this->miConfigurador->getVariableConfiguracion("host") . $this->miConfigurador->getVariableConfiguracion("site") . $rutaBloque;
        $SQls = [];

        foreach ($_FILES as $key => $values) {
            $archivo = $_FILES [$key];
        }

        $acceptedFormats = array('pdf', 'png', 'jpg', 'doc', 'docx', 'xls', 'csv');

        if (!in_array(pathinfo($archivo['name'], PATHINFO_EXTENSION), $acceptedFormats)) {
            $estado = false;
        } elseif ($archivo['size'] > 262144000) {
            $estado = false;
        } else {

            if ($archivo ['name'] != '') {
                // obtenemos los datos del archivo
                $tamano = $archivo ['size'];
                $tipo = $archivo ['type'];
                $archivo1 = $archivo ['name'];
                $prefijo = substr(md5(uniqid(rand())), 0, 6);

                if ($archivo1 != "") {
                    // guardamos el archivo a la carpeta files
                    $destino1 = $rutaBloque . "/archivoSoporte/" . $prefijo . "_" . $archivo1;
                    echo $destino1;
                    if (copy($archivo ['tmp_name'], $destino1)) {
                        $status = "Archivo subido: <b>" . $archivo1 . "</b>";
                        $destino1 = $host . "/archivoSoporte/" . $prefijo . "_" . $archivo1;

                        $estado = true;
                    } else {
                        $estado = FALSE;
                    }
                } else {
                    $estado = FALSE;
                }
            } else {
                $estado = FALSE;
            }

            if ($estado != FALSE) {

                if ($_REQUEST['tipo_novedad'] == '') {
                    
                } elseif ($_REQUEST['tipo_novedad'] == '220') {
                    if ($_REQUEST['tipo_adicion'] == '248') {

                        $arreglo_novedad = array(
                            'novedad' => "curval('novedad_contractual_id_seq')",
                            'tipo_adicion' => $_REQUEST['tipo_adicion'],
                            'numero_solicitud' => $_REQUEST['numero_solicitud'],
                            'numero_cdp' => $_REQUEST['numero_cdp'],
                            'valor_adicion_presupuesto' => $_REQUEST['valor_adicion_presupuesto'],
                        );
                        $cadenaSqlParticular = $this->miSql->getCadenaSql('registroNovedadAdicionPresupuesto', $arreglo_novedad);
                    } else {

                        $arreglo_novedad = array(
                            'novedad' => "curval('novedad_contractual_id_seq')",
                            'tipo_adicion' => $_REQUEST['tipo_adicion'],
                            'unidad_tiempo_ejecucion' => $_REQUEST['unidad_tiempo_ejecucion'],
                            'valor_adicion_tiempo' => $_REQUEST['valor_adicion_tiempo'],
                        );
                        $cadenaSqlParticular = $this->miSql->getCadenaSql('registroNovedadAdicionTiempo', $arreglo_novedad);
                    }
                } elseif ($_REQUEST['tipo_novedad'] == '234') {

                    $arreglo_novedad = array(
                        'novedad' => "curval('novedad_contractual_id_seq')",
                        'tipo_anulacion' => $_REQUEST['tipo_anulacion'],
                    );
                    $cadenaSqlParticular = $this->miSql->getCadenaSql('registroNovedadAnulacion', $arreglo_novedad);
                } elseif ($_REQUEST['tipo_novedad'] == '222') {
                    $arreglo_novedad = array(
                        'novedad' => "curval('novedad_contractual_id_seq')",
                        'tipoCambioSupervisor' => $_REQUEST['tipoCambioSupervisor'],
                        'supervisor_actual' => $_REQUEST['supervisor_actual'],
                        'nuevoSupervisor' => $_REQUEST['nuevoSupervisor'],
                    );

                    $cadenaSqlParticular = $this->miSql->getCadenaSql('registroNovedadCambioSupervisor', $arreglo_novedad);
                } elseif ($_REQUEST['tipo_novedad'] == '219') {

                    $arreglo_novedad = array(
                        'novedad' => "curval('novedad_contractual_id_seq')",
                        'nuevoContratista' => $_REQUEST['nuevoContratista'],
                        'fecha_inicio_cesion' => $_REQUEST['supervisor_actual'],
                    );
                    $cadenaSqlParticular = $this->miSql->getCadenaSql('registroNovedadCesion', $arreglo_novedad);
                } elseif ($_REQUEST['tipo_novedad'] == '216') {

                    $arreglo_novedad = array(
                        'novedad' => "curval('novedad_contractual_id_seq')",
                        'unidad_tiempo_ejecucion_suspencion' => $_REQUEST['unidad_tiempo_ejecucion_suspencion'],
                        'valor_suspension' => $_REQUEST['valor_suspension'],
                    );
                    $cadenaSqlParticular = $this->miSql->getCadenaSql('registroNovedadSuspension', $arreglo_novedad);
                } else {

                    $cadenaSqlParticular = false;
                }


                $arreglo_novedad = array(
                    'tipo_novedad' => $_REQUEST['tipo_novedad'],
                    'numero_contrato' => $_REQUEST['numero_contrato'],
                    'vigencia' => $_REQUEST['vigencia'],
                    'fecha_registro' => date("Y-md"),
                    'usuario' => $_REQUEST['usuario'],
                    'acto_administrativo' => $_REQUEST['numero_acto'],
                    'documentoSoporte' => $destino1,
                    'observaciones' => $_REQUEST['observaciones'],
                );
                
                $cadenaSqlNovedad = $this->miSql->getCadenaSql('registroNovedadContractual', $arreglo_novedad);
                var_dump($cadenaSqlNovedad);
                exit;
                array_push($SQls, $cadenaSqlNovedad);
                if ($cadenaSqlParticular != false) {
                    array_push($SQls, $cadenaSqlParticular);
                }

                $trans_Registro_Novedad = $esteRecursoDB->transaccion($SQls);
            }
        }


        $datosContrato = array('numero_contrato' => $_REQUEST['numero_contrato'],
            'vigencia' => $_REQUEST['vigencia'], 'tipo_novedad' => $_REQUEST['tipo_novedad'], 'acto_administrativo' => $_REQUEST['numero_acto']);

        if (isset($registro) && $trans_Registro_Novedad != false) {
            redireccion::redireccionar("Inserto", $datosContrato);
            exit();
        } else {
            redireccion::redireccionar("ErrorRegistro", $datosContrato);
            exit();
        }
    }

}

$miRegistrador = new RegistradorContrato($this->lenguaje, $this->sql, $this->funcion);

$resultado = $miRegistrador->procesarFormulario();
?>