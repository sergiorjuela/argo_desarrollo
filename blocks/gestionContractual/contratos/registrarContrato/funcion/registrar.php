<?php

namespace contratos\registrarContrato\funcion;

use contratos\registrarContrato\funcion\redireccion;

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
        $SQLs = [];

        if (isset($_REQUEST ['id_contratista']) == true && $_REQUEST ['id_contratista'] != '') {

            $arreglo_contratista = array(
                "tipo_identificacion" => $_REQUEST ['tipo_identificacion'],
                "numero_identificacion" => $_REQUEST ['numero_identificacion'],
                "digito_verificacion" => $_REQUEST ['digito_verificacion'],
                "tipo_persona" => $_REQUEST ['tipo_persona'],
                "genero" => $_REQUEST ['genero'],
                "nacionalidad" => $_REQUEST ['nacionalidad'],
                "direccion" => $_REQUEST ['direccion'],
                "telefono" => $_REQUEST ['telefono'],
                "correo" => $_REQUEST ['correo'],
                "perfil" => $_REQUEST ['perfil'],
                "profesion" => $_REQUEST ['profesion'],
                "especialidad" => $_REQUEST ['especialidad'],
                "razon_social" => $_REQUEST ['nombre_Razon_Social'],
                "id_contratista" => $_REQUEST ['id_contratista'],
                "fecha_registro" => date('Y-m-d')
            );

            $SqlContratista = $this->miSql->getCadenaSql('actualizar_contratista', $arreglo_contratista);
            array_push($SQLs, $SqlContratista);
            
            if ($_REQUEST ['id_inf_bancaria'] != '') {

                $arreglo_info_bancaria = array(
                    "tipo_cuenta" => $_REQUEST ['tipo_cuenta'],
                    "numero_cuenta" => $_REQUEST ['numero_cuenta'],
                    "entidad_bancaria" => $_REQUEST ['entidad_bancaria'],
                    "id_info_bancaria" => $_REQUEST ['id_inf_bancaria']
                );

                $SqlInfoBancaria = $this->miSql->getCadenaSql('actualizar_informacion_bancaria', $arreglo_info_bancaria);
                
                array_push($SQLs, $SqlInfoBancaria);
            } else {

                $arreglo_info_bancaria = array(
                    "tipo_cuenta" => $_REQUEST ['tipo_cuenta'],
                    "numero_cuenta" => $_REQUEST ['numero_cuenta'],
                    "entidad_bancaria" => $_REQUEST ['entidad_bancaria'],
                    "id_contratista" => $_REQUEST ['id_contratista'],
                    "fecha_registro" => date('Y-m-d')
                );

                $SqlInfoBancaria = $this->miSql->getCadenaSql('registrar_informacion_bancaria', $arreglo_info_bancaria);
                array_push($SQLs, $SqlInfoBancaria);
            }

            $id_contratista = $_REQUEST ['id_contratista'];
        } else {


             $arreglo_contratista = array(
                "tipo_identificacion" => $_REQUEST ['tipo_identificacion'],
                "numero_identificacion" => $_REQUEST ['numero_identificacion'],
                "digito_verificacion" => $_REQUEST ['digito_verificacion'],
                "tipo_persona" => $_REQUEST ['tipo_persona'],
                "genero" => $_REQUEST ['genero'],
                "nacionalidad" => $_REQUEST ['nacionalidad'],
                "direccion" => $_REQUEST ['direccion'],
                "telefono" => $_REQUEST ['telefono'],
                "correo" => $_REQUEST ['correo'],
                "perfil" => $_REQUEST ['perfil'],
                "profesion" => $_REQUEST ['profesion'],
                "especialidad" => $_REQUEST ['especialidad'],
                "razon_social" => $_REQUEST ['nombre_Razon_Social'],
                "fecha_registro" => date('Y-m-d')
            );

            $SqlContratista = $this->miSql->getCadenaSql('registrar_contratista', $arreglo_contratista);
            array_push($SQLs, $SqlContratista);
            $arreglo_info_bancaria = array(
                "tipo_cuenta" => $_REQUEST ['tipo_cuenta'],
                "numero_cuenta" => $_REQUEST ['numero_cuenta'],
                "entidad_bancaria" => $_REQUEST ['entidad_bancaria'],
                "id_contratista" => "currval('contratista_id_contratista_seq')",
                "fecha_registro" => date('Y-m-d')
            );

            $SqlInfoBancaria = $this->miSql->getCadenaSql('registrar_informacion_bancaria', $arreglo_info_bancaria);
            array_push($SQLs, $SqlInfoBancaria);


        }

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
        $unidad_ejecutura = strpos($_REQUEST ['unidad_ejecutora'], 'IDEXUD');
        if ($unidad_ejecutura == false) {
            $unidad_ejecutura = 209;
        } else {
            $unidad_ejecutura = 208;
        }
        //Obtener la Clausula de Presupuesto
        if (isset($_POST['clausula_presupuesto'])) {
            $clausula_presupuesto = $_POST['clausula_presupuesto'];
        } else {
            $clausula_presupuesto = 'false';
        }

        $SqlCargoSupervisor = $this->miSql->getCadenaSql('obtener_cargo_supervisro', 
                $_REQUEST ['supervisor']);
        $cargo = $esteRecursoDB->ejecutarAcceso($SqlCargoSupervisor, "busqueda");
      
        $arreglo_contrato_general = array('vigencia' => (int) date('Y'),
            'id_orden_contrato' => $_REQUEST ['id_orden_contrato'],
            'tipo_contrato' => $_REQUEST['clase_contrato'],
            'unidad_ejecutura' => $unidad_ejecutura,
            'objeto_contrato' => $_REQUEST ['objeto_contrato'],
            'fecha_inicio' =>$fecha_inicio_poliza,
            'fecha_fin' => $fecha_final_poliza,
            'plazo_ejecucion' => $_REQUEST ['plazo_ejecucion'],
            'clausula_presupuesto' => $clausula_presupuesto,
            'ordenador_gasto' => $_REQUEST ['ordenador_gasto'],
            'supervisor' => $_REQUEST ['supervisor'],
            'cargo_supervisor' => $cargo[0]['cargo'],
            'forma_pago' => $_REQUEST ['formaPago']);
        
        $SqlcontratoGeneral = $this->miSql->getCadenaSql('insertarContratoGeneral', $arreglo_contrato_general);
        array_push($SQLs, $SqlcontratoGeneral);
        $arreglo_contrato = array(
            "vigencia" => (int)date('Y'),
            "numero_contrato" => "currval('contractual.numero_unico_contrato_seq')",
            "tipo_configuracion" => $_REQUEST ['tipo_configuracion'],
            "clase_contratista" => $_REQUEST ['clase_contratista'],
            "identificacion_clase_contratista" => $_REQUEST ['identificacion_clase_contratista'],
            "digito_verificacion_clase_contratista" => $_REQUEST ['digito_verificacion_clase_contratista'],
            "porcentaje_clase_contratista" => $porcentaje_contratista,
            "tipo_compromiso" => $_REQUEST ['tipo_compromiso'],
            "numero_convenio" => $numero_convenio,
            "vigencia_convenio" => $vigencia_convenio,
            "fecha_subcripcion" => $_REQUEST ['fecha_subcripcion'],
            "unidad_ejecucion_tiempo" => $_REQUEST ['unidad_ejecucion_tiempo'],
            "dependencia" => $_REQUEST ['dependencia'],
            "tipologia_especifica" => $_REQUEST ['tipologia_especifica'],
            "numero_constancia" => $_REQUEST ['numero_constancia'],
            "modalidad_seleccion" => $_REQUEST ['modalidad_seleccion'],
            "procedimiento" => $_REQUEST ['procedimiento'],
            "regimen_contratación" => $_REQUEST ['regimen_contratación'],
            "tipo_moneda" => $_REQUEST ['tipo_moneda'],
            "valor_contrato" => $_REQUEST ['valor_contrato'],
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
        );


        $SqlContrato = $this->miSql->getCadenaSql('registrar_contrato', $arreglo_contrato);
        array_push($SQLs, $SqlContrato);
        
        
        $trans_Registro_contrato = $esteRecursoDB->transaccion($SQLs);
        $sqlNumeroContrato = $this->miSql->getCadenaSql('obtenerInfoOrden');
        $resultado = $esteRecursoDB->ejecutarAcceso($sqlNumeroContrato, "busqueda");
        $identificadorOrden = $resultado[0];
        $datos= array("numero_contrato"=> $identificadorOrden['numero_contrato'],
            "vigencia"=> date("Y"));
        if ($trans_Registro_contrato != false) {
            $cadenaVerificarTemp = $this->miSql->getCadenaSql('obtenerInfoTemporal', str_replace(";", "", $_REQUEST["atributosContratoTempHidden"]));
            $infoTemp = $esteRecursoDB->ejecutarAcceso($cadenaVerificarTemp, "busqueda");
            if ($infoTemp != false) {
                $cadenaEliminarInfoTemporal = $this->miSql->getCadenaSql('eliminarInfoTemporal', str_replace(";", "", $_REQUEST["atributosContratoTempHidden"]));
                $esteRecursoDB->ejecutarAcceso($cadenaEliminarInfoTemporal, "acceso");
            }

            redireccion::redireccionar("Inserto", $datos);
            exit;
        } else {

            redireccion::redireccionar("ErrorRegistro",$datos);
            exit;
        }
    }

}

$miRegistrador = new RegistradorContrato($this->lenguaje, $this->sql, $this->funcion);

$resultado = $miRegistrador->procesarFormulario();
?>