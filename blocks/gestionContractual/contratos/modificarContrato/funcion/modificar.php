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

        $SQLs=[];
        $conexion = "contractual";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        if (isset($_REQUEST ['id_contratista']) == true && $_REQUEST ['id_contratista'] != '') {

            $arreglo_contratista = array(
                "tipo_identificacion" => $_REQUEST ['tipo_identificacion'],
                "numero_identificacion" => $_REQUEST ['numero_identificacion'],
                "digito_verificacion" => $_REQUEST ['digito_verificacion'],
                "tipo_persona" => $_REQUEST ['tipo_persona'],
                "primer_nombre" => $_REQUEST ['primer_nombre'],
                "segundo_nombre" => $_REQUEST ['segundo_nombre'],
                "primer_apellido" => $_REQUEST ['primer_apellido'],
                "segundo_apellido" => $_REQUEST ['segundo_apellido'],
                "genero" => $_REQUEST ['genero'],
                "nacionalidad" => $_REQUEST ['nacionalidad'],
                "direccion" => $_REQUEST ['direccion'],
                "telefono" => $_REQUEST ['telefono'],
                "correo" => $_REQUEST ['correo'],
                "perfil" => $_REQUEST ['perfil'],
                "profesion" => $_REQUEST ['profesion'],
                "especialidad" => $_REQUEST ['especialidad'],
                "id_contratista" => $_REQUEST ['id_contratista'],
                "fecha_registro" => date('Y-m-d')
            );

            $SQLs[0] = $this->miSql->getCadenaSql('actualizar_contratista', $arreglo_contratista);

           
            if ($_REQUEST ['id_inf_bancaria'] != '') {

                $arreglo_info_bancaria = array(
                    "tipo_cuenta" => $_REQUEST ['tipo_cuenta'],
                    "numero_cuenta" => $_REQUEST ['numero_cuenta'],
                    "entidad_bancaria" => $_REQUEST ['entidad_bancaria'],
                    "id_info_bancaria" => $_REQUEST ['id_inf_bancaria']
                );

                $SQLs[1]  = $this->miSql->getCadenaSql('actualizar_informacion_bancaria', $arreglo_info_bancaria);

                } else {

                $arreglo_info_bancaria = array(
                    "tipo_cuenta" => $_REQUEST ['tipo_cuenta'],
                    "numero_cuenta" => $_REQUEST ['numero_cuenta'],
                    "entidad_bancaria" => $_REQUEST ['entidad_bancaria'],
                    "id_contratista" => $_REQUEST ['id_contratista'],
                    "fecha_registro" => date('Y-m-d')
                );

                $SQLs[1]  = $this->miSql->getCadenaSql('registrar_informacion_bancaria', $arreglo_info_bancaria);
               }

            $id_contratista = $_REQUEST ['id_contratista'];
        } else {

            $arreglo_contratista = array(
                "tipo_identificacion" => $_REQUEST ['tipo_identificacion'],
                "numero_identificacion" => $_REQUEST ['numero_identificacion'],
                "digito_verificacion" => $_REQUEST ['digito_verificacion'],
                "tipo_persona" => $_REQUEST ['tipo_persona'],
                "primer_nombre" => $_REQUEST ['primer_nombre'],
                "segundo_nombre" => $_REQUEST ['segundo_nombre'],
                "primer_apellido" => $_REQUEST ['primer_apellido'],
                "segundo_apellido" => $_REQUEST ['segundo_apellido'],
                "genero" => $_REQUEST ['genero'],
                "nacionalidad" => $_REQUEST ['nacionalidad'],
                "direccion" => $_REQUEST ['direccion'],
                "telefono" => $_REQUEST ['telefono'],
                "correo" => $_REQUEST ['correo'],
                "perfil" => $_REQUEST ['perfil'],
                "profesion" => $_REQUEST ['profesion'],
                "especialidad" => $_REQUEST ['especialidad'],
                "fecha_registro" => date('Y-m-d')
            );

            $SQLs[0]  = $this->miSql->getCadenaSql('registrar_contratista', $arreglo_contratista);

            $arreglo_info_bancaria = array(
                "tipo_cuenta" => $_REQUEST ['tipo_cuenta'],
                "numero_cuenta" => $_REQUEST ['numero_cuenta'],
                "entidad_bancaria" => $_REQUEST ['entidad_bancaria'],
                "id_contratista" => $contratista [0] [0],
                "fecha_registro" => date('Y-m-d')
            );

            $SQLs[1]  = $this->miSql->getCadenaSql('registrar_informacion_bancaria', $arreglo_info_bancaria);

            $cadenaIdContratista = $this->miSql->getCadenaSql('obtener_id_contratista');
            $id_contratista=$esteRecursoDB->ejecutarAcceso($cadenaIdContratista, "busqueda");
            $id_contratista = $id_contratista[0][0]+1;
        }



        $arreglo_Supervisor = array(
            "digito_supervisor" => $_REQUEST ['digito_supervisor'],
            "id_funcionario" => $_REQUEST ['supervisor']
        );


        $SQLs[2] = $this->miSql->getCadenaSql('Actualizar_Supervisor', $arreglo_Supervisor);
       
        $arreglo_SolicitudNecesidad = array(
            "objeto_contrato" => $_REQUEST ['objeto_contrato'],
            "valor_contrato" => $_REQUEST ['valor_contrato'],
            "dependencia" => $_REQUEST ['dependencia'],
            "id_solicitud" => $_REQUEST ['id_solicitud_necesidad'],
        );


        $SQLs[3] = $this->miSql->getCadenaSql('Actualizar_Solicitud_necesidad', $arreglo_SolicitudNecesidad);
      
        if ($_REQUEST ['tipo_compromiso'] != '46') {
            $numero_convenio = -1;
            $vigencia_convenio = -1;
        } else {
            $numero_convenio = $_REQUEST ['numero_convenio'];
            $vigencia_convenio = $_REQUEST ['vigencia_convenio'];
        }

        if ($_REQUEST ['clase_contratista'] == "35") {
            $porcentaje_contratista = 0;
        } else {
            $porcentaje_contratista = $_REQUEST ['porcentaje_clase_contratista'];
        }

        //Validacion campos nulos de fecha de inicio y finalizacion
        if (isset($_REQUEST ['fecha_final_poliza']) && $_REQUEST ['fecha_final_poliza'] != "") {
            $fecha_final_poliza = "'".$_REQUEST ['fecha_final_poliza']."'";
        } else {
            $fecha_final_poliza = 'NULL';
        }
        if (isset($_REQUEST ['fecha_inicio_poliza']) && $_REQUEST ['fecha_inicio_poliza'] != "") {
            $fecha_inicio_poliza = "'".$_REQUEST ['fecha_inicio_poliza']."'";
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


        $arreglo_contrato = array(
            "vigencia" => date('Y-m-d'),
            "id_contrato" => $_REQUEST['id_contrato'],
            "numero_contrato" => $_REQUEST ['numero_contrato'],
            "tipo_configuracion" => $_REQUEST ['tipo_configuracion'],
            "clase_contratista" => $_REQUEST ['clase_contratista'],
            "identificacion_clase_contratista" => $_REQUEST ['identificacion_clase_contratista'],
            "digito_verificacion_clase_contratista" => $_REQUEST ['digito_verificacion_clase_contratista'],
            "porcentaje_clase_contratista" => $porcentaje_contratista,
            "clase_contrato" => $_REQUEST ['clase_contrato'],
            "tipo_compromiso" => $_REQUEST ['tipo_compromiso'],
            "numero_convenio" => $numero_convenio,
            "vigencia_convenio" => $vigencia_convenio,
            "objeto_contrato" => $_REQUEST ['objeto_contrato'],
            "fecha_subcripcion" => $_REQUEST ['fecha_subcripcion'],
            "plazo_ejecucion" => $_REQUEST ['plazo_ejecucion'],
            "unidad_ejecucion_tiempo" => $_REQUEST ['unidad_ejecucion_tiempo'],
            "fecha_inicio_poliza" => $fecha_inicio_poliza,
            "fecha_final_poliza" => $fecha_final_poliza,
            "dependencia" => $_REQUEST ['dependencia'],
            "tipologia_especifica" => $_REQUEST ['tipologia_especifica'],
            "numero_constancia" => $_REQUEST ['numero_constancia'],
            "modalidad_seleccion" => $_REQUEST ['modalidad_seleccion'],
            "procedimiento" => $_REQUEST ['procedimiento'],
            "regimen_contratación" => $_REQUEST ['regimen_contratación'],
            "tipo_moneda" => $_REQUEST ['tipo_moneda'],
            "valor_contrato" => $_REQUEST ['valor_contrato'],
            "ordenador_gasto" => $_REQUEST ['ordenador_gasto'],
            "tipo_gasto" => $_REQUEST ['tipo_gasto'],
            "origen_recursos" => $_REQUEST ['origen_recursos'],
            "origen_presupuesto" => $_REQUEST ['origen_presupuesto'],
            "tema_gasto_inversion" => $_REQUEST ['tema_gasto_inversion'],
            "valor_contrato_moneda_ex" => $valor_moneda_extranjera,
            "tasa_cambio" => $tasa_cambio,
            "observacionesContrato" => $_REQUEST ['observacionesContrato'],
            "tipo_control" => $_REQUEST ['tipo_control'],
            "supervisor" => $_REQUEST ['supervisor'],
            "fecha_suscrip_super" => $_REQUEST ['fecha_suscrip_super'],
            "fecha_limite" => $_REQUEST ['fecha_limite'],
            "observaciones_interventoria" => $_REQUEST ['observaciones_interventoria'],
            "fecha_registro" => date('Y-m-d'),
            "contratista" => $id_contratista,
            "solicitud_necesidad" => $_REQUEST ['id_solicitud_necesidad'],
            "orden_contrato" => $_REQUEST ['id_orden_contrato']
        );

        $SQLs[4] = $this->miSql->getCadenaSql('Actualizar_Contrato', $arreglo_contrato);
        $trans_Editar_contrato = $esteRecursoDB->transaccion($SQLs);
        
        if ($trans_Editar_contrato != false) {
            $cadenaVerificarTemp = $this->miSql->getCadenaSql('obtenerInfoTemporal',  $_REQUEST["atributosContratoTempHidden"]);
            $infoTemp = $esteRecursoDB->ejecutarAcceso($cadenaVerificarTemp, "busqueda");
            if ($infoTemp != false) {
                $cadenaEliminarInfoTemporal = $this->miSql->getCadenaSql('eliminarInfoTemporal', $_REQUEST["atributosContratoTempHidden"]);
                $esteRecursoDB->ejecutarAcceso($cadenaEliminarInfoTemporal, "acceso");
            }
            redireccion::redireccionar("Inserto", $arreglo_contrato);

            exit();
        } else {
            redireccion::redireccionar("ErrorRegistro");

            exit();
        }
    }

}

$miRegistrador = new RegistradorContrato($this->lenguaje, $this->sql, $this->funcion);

$resultado = $miRegistrador->procesarFormulario();
?>