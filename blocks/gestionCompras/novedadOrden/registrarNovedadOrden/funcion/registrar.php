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

                $arreglo_novedad = array(
                    0 => $_REQUEST['tipo_novedad'],
                    1 => $_REQUEST['numero_contrato'],
                    2 => $_REQUEST['vigencia'],
                    3 => date("Y-m-d"),
                    4 => $_REQUEST['usuario'],
                    5 => $_REQUEST['numero_acto'],
                    6 => $destino1,
                    7 => $_REQUEST['observaciones'],
                );


                $cadenaSqlNovedad = $this->miSql->getCadenaSql('registroNovedadContractual', $arreglo_novedad);

                array_push($SQls, $cadenaSqlNovedad);

                if ($_REQUEST['tipo_novedad'] == '') {
                    
                } elseif ($_REQUEST['tipo_novedad'] == '220') {
                    if ($_REQUEST['tipo_adicion'] == '248') {

                        $cadenaAcumulado = $cadenaSqlParticular = $this->miSql->getCadenaSql('acumuladoAdiciones', array(0 => $_REQUEST['numero_contrato'],
                            1 => $_REQUEST['vigencia']));
                        $acumulado = $esteRecursoDB->ejecutarAcceso($cadenaAcumulado, "busqueda");
                        if($acumulado == false){
                            $acumulado[0][0]=0;
                        }                        
                        $valorTope = $_REQUEST['valor_contrato'] * 0.5;
                        $valorOtrosSi = $acumulado[0][0] + $_REQUEST['valor_adicion_presupuesto'];

                        if ($valorOtrosSi > $valorTope) {

                            $datosRebasaOtroSi = array(
                                'acumulado' => $acumulado[0][0],
                                'valor_tope' => $valorTope,
                                'valor_adicion' => $_REQUEST['valor_adicion_presupuesto'],
                                'numero_contrato' => $_REQUEST['numero_contrato'],
                                'tipo_novedad' => $_REQUEST['tipo_novedad'],
                                'vigencia' => $_REQUEST['vigencia'],
                                'valor_contrado' => $_REQUEST['valor_contrato']
                            );
                    
                            redireccion::redireccionar("rebasaOtroSi", $datosRebasaOtroSi);
                        } else {

                            $arreglo_novedad_particular = array(
                                0 => "currval('novedad_contractual_id_seq')",
                                1 => $_REQUEST['tipo_adicion'],
                                2 => $_REQUEST['numero_solicitud'],
                                3 => $_REQUEST['numero_cdp'],
                                4 => $_REQUEST['valor_adicion_presupuesto'],
                            );
                            $cadenaSqlParticular = $this->miSql->getCadenaSql('registroNovedadAdicionPresupuesto', $arreglo_novedad_particular);
                            array_push($SQls, $cadenaSqlParticular);
                        }
                    } else {

                        $arreglo_novedad_particular = array(
                            0 => "currval('novedad_contractual_id_seq')",
                            1 => $_REQUEST['tipo_adicion'],
                            2 => $_REQUEST['unidad_tiempo_ejecucion'],
                            3 => $_REQUEST['valor_adicion_tiempo']
                        );
                        $cadenaSqlParticular = $this->miSql->getCadenaSql('registroNovedadAdicionTiempo', $arreglo_novedad_particular);
                        array_push($SQls, $cadenaSqlParticular);
                    }
                } elseif ($_REQUEST['tipo_novedad'] == '234') {

                    $arreglo_novedad_particular = array(
                        0 => "currval('novedad_contractual_id_seq')",
                        1 => $_REQUEST['tipo_anulacion'],
                    );
                    $cadenaSqlParticular = $this->miSql->getCadenaSql('registroNovedadAnulacion', $arreglo_novedad_particular);
                    array_push($SQls, $cadenaSqlParticular);
                } elseif ($_REQUEST['tipo_novedad'] == '222') {

                    $cadenaSupervisorActual = explode(" -- ", $_REQUEST['supervisor_actual']);
                    $arreglo_novedad_particular = array(
                        0 => "currval('novedad_contractual_id_seq')",
                        1 => $_REQUEST['tipoCambioSupervisor'],
                        2 => $cadenaSupervisorActual[0],
                        3 => $_REQUEST['nuevoSupervisor'],
                        4 => $_REQUEST['fecha_oficial_cambio']
                    );
                    $arregloCambioSupervisor = array(
                        0 => $_REQUEST['nuevoSupervisor'],
                        1 => $_REQUEST['numero_contrato'],
                        2 => $_REQUEST['vigencia'],
                    );
                    $cadenaSqlSupervisor = $this->miSql->getCadenaSql('actualizarSupervisor', $arregloCambioSupervisor);
                    $cadenaSqlParticular = $this->miSql->getCadenaSql('registroNovedadCambioSupervisor', $arreglo_novedad_particular);
                    array_push($SQls, $cadenaSqlParticular);
                    array_push($SQls, $cadenaSqlSupervisor);
                } elseif ($_REQUEST['tipo_novedad'] == '219') {

                    $cadenaContratistaActual = explode(" - ", $_REQUEST['actualContratista']);
                    $cadenaContratistaNuevo = explode("-", $_REQUEST['nuevoContratista']);
                    $arreglo_novedad_particular = array(
                        0 => "currval('novedad_contractual_id_seq')",
                        1 => $cadenaContratistaNuevo[0],
                        2 => $cadenaContratistaActual[0],
                        3 => $_REQUEST['fecha_inicio_cesion']
                    );

                    $arregloCambioContratista = array(
                        0 => $cadenaContratistaNuevo[0],
                        1 => $cadenaContratistaNuevo[1],
                        2 => $_REQUEST['numero_contrato'],
                        3 => $_REQUEST['vigencia'],
                    );
                    $cadenaSqlContratista = $this->miSql->getCadenaSql('actualizarContratista', $arregloCambioContratista);
                    $cadenaSqlParticular = $this->miSql->getCadenaSql('registroNovedadCesion', $arreglo_novedad_particular);
                    array_push($SQls, $cadenaSqlParticular);
                    array_push($SQls, $cadenaSqlContratista);
                } elseif ($_REQUEST['tipo_novedad'] == '216') {

                    $arreglo_novedad_particular = array(
                        0 => "currval('novedad_contractual_id_seq')",
                        1 => $_REQUEST['fecha_inicio_suspension'],
                        2 => $_REQUEST['fecha_fin_suspension'],
                    );
                    $cadenaSqlParticular = $this->miSql->getCadenaSql('registroNovedadSuspension', $arreglo_novedad_particular);
                    array_push($SQls, $cadenaSqlParticular);
                }
           
                $trans_Registro_Novedad = $esteRecursoDB->transaccion($SQls);
            }
        }


        $datosContrato = array('numero_contrato' => $_REQUEST['numero_contrato'],
            'vigencia' => $_REQUEST['vigencia'], 'tipo_novedad' => $_REQUEST['tipo_novedad'], 'acto_administrativo' => $_REQUEST['numero_acto']);

        if (isset($trans_Registro_Novedad) && $trans_Registro_Novedad != false) {
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