<?php

namespace gestionCompras\registrarOrden\funcion;

use gestionCompras\registrarOrden\funcion\redireccion;

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
        $fechaActual = date('Y-m-d');

        $conexion = "contractual";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
        
        
        
        $arregloContratista =  array($_REQUEST ['nombre_supervisor']);
        $arregloContratoGeneral =  array($_REQUEST ['nombre_supervisor']);
        $arregloOrden =  array($_REQUEST ['nombre_supervisor']);
        $arregloPoliza = array($_REQUEST ['nombre_supervisor']); 
        
        
        
        
        
        
        
        
        $cadenaIdSupervisor = $this->miSql->getCadenaSql('obtenerIdSupervisor');
        $id_supervisor = $esteRecursoDB->ejecutarAcceso($cadenaIdSupervisor, "busqueda");
        if (is_null($id_supervisor [0] [0])) {

            $id_supervisor = 1;
        } else {

            $id_supervisor = $id_supervisor [0] [0] + 1;
        }

        $datosSupervisor = array(
            $_REQUEST ['nombre_supervisor'],
            $_REQUEST ['cargo_supervisor'],
            $_REQUEST ['dependencia_supervisor'],
            $_REQUEST ['sede_super'],
            $id_supervisor
        );

        // Registro Supervisor
        $SQLs[0] = $this->miSql->getCadenaSql('insertarSupervisor', $datosSupervisor);
   
        $cadenaIdProveedor = $this->miSql->getCadenaSql('obtenerIdProveedor');
        $id_Proveedor = $esteRecursoDB->ejecutarAcceso($cadenaIdProveedor, "busqueda");
        if (is_null($id_Proveedor [0] [0])) {

            $id_Proveedor = 1;
        } else {

            $id_Proveedor = $id_Proveedor [0] [0] + 1;
        }

        
        $datosProveedor = array(
            $_REQUEST ['nombre_razon_proveedor'],
            $_REQUEST ['identifcacion_proveedor'],
            $_REQUEST ['direccion_proveedor'],
            $_REQUEST ['telefono_proveedor'],
            $id_Proveedor
        );

        // Registro Proveedor
        $SQLs[1] = $this->miSql->getCadenaSql('insertarProveedor', $datosProveedor);

        $cadenaIdContratista = $this->miSql->getCadenaSql('obtenerIdContratista');
        $id_Contratista = $esteRecursoDB->ejecutarAcceso($cadenaIdContratista, "busqueda");
        if (is_null($id_Contratista [0] [0])) {

            $id_Contratista = 1;
        } else {

            $id_Contratista = $id_Contratista [0] [0] + 1;
        }
        
        $datosContratista = array(
            $_REQUEST ['nombre_contratista'],
            $_REQUEST ['identifcacion_contratista'],
            $_REQUEST ['cargo_contratista'],
            $id_Contratista
        );

        // Registro Contratista
        $SQLs[2] = $this->miSql->getCadenaSql('insertarContratista', $datosContratista);

       
        if (strpos($_REQUEST ['unidad_ejecutora'], 'IDEXUD') === false) {
            $_REQUEST ['unidad_ejecutora'] = 1;
        } else {
            $_REQUEST ['unidad_ejecutora'] = 2;
        }

        switch ($_REQUEST ['tipo_orden']) {
            case '1' :
                $nombre = "ORDEN DE COMPRA";
                $cadenaSql = $this->miSql->getCadenaSql('consecutivo_compra', array(
                    "vigencia" => date('Y'),
                    "unidad_ejecutora" => $_REQUEST ['unidad_ejecutora']
                ));

                $consecutivo = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

                $consecutivo_servicio = 'NULL';
                if (is_null($consecutivo [0] [0])) {

                    $consecutivo_compra = 1;
                } else {

                    $consecutivo_compra = $consecutivo [0] [0] + 1;
                }

                break;

            case '9' :

                $nombre = "ORDEN DE SERVICIO";

                $cadenaSql = $this->miSql->getCadenaSql('consecutivo_servicios', array(
                    "vigencia" => date('Y'),
                    "unidad_ejecutora" => $_REQUEST ['unidad_ejecutora']
                ));

                $consecutivo = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
                $consecutivo_compra = 'NULL';
                if (is_null($consecutivo [0] [0])) {

                    $consecutivo_servicio = 1;
                } else {

                    $consecutivo_servicio = $consecutivo [0] [0] + 1;
                }

                break;
        }

        //Validacion campos nulos de fecha de inicio y finalizacion
        if (isset($_REQUEST ['fecha_inicio_pago']) && $_REQUEST ['fecha_inicio_pago'] != "") {
            $fecha_inicio_pago = "'" . $_REQUEST ['fecha_inicio_pago'] . "'";
        } else {
            $fecha_inicio_pago = 'NULL';
        }
        if (isset($_REQUEST ['fecha_final_pago']) && $_REQUEST ['fecha_final_pago'] != "") {
            $fecha_final_pago = "'" . $_REQUEST ['fecha_final_pago'] . "'";
        } else {
            $fecha_final_pago = 'NULL';
        }
        if (isset($_POST ['clausula_presupuesto']) && $_POST ['clausula_presupuesto'] != "") {
            $clausula_presupuesto = $_POST ['clausula_presupuesto'];
        } else {
            $clausula_presupuesto = 'FALSE';
        }

        $datosOrden = array(
            "tipo_orden" => $_REQUEST ['tipo_orden'],
            "vigencia" => date('Y'),
            "consecutivo_servicio" => $consecutivo_servicio,
            "consecutivo_compras" => $consecutivo_compra,
            "fecha_registro" => date('Y-m-d'),
            "dependencia_solicitante" => $_REQUEST ['dependencia_solicitante'],
            "sede_solicitante" => $_REQUEST ['sede'],
            "objeto_contrato" => $_REQUEST ['objeto_contrato'],
            "poliza1" => isset($_REQUEST ['polizaA']),
            "poliza2" => isset($_REQUEST ['polizaB']),
            "poliza3" => isset($_REQUEST ['polizaC']),
            "poliza4" => isset($_REQUEST ['polizaD']),
            "duracion_pago" => $_REQUEST ['duracion'],
            "fecha_inicio_pago" => $fecha_inicio_pago,
            "fecha_final_pago" => $fecha_final_pago,
            "forma_pago" => $_REQUEST ['forma_pago'],
            "id_contratista" => $id_Contratista,
            "id_supervisor" => $id_supervisor,
            "id_ordenador_encargado" => $_REQUEST ['id_ordenador'],
            "tipo_ordenador" => $_REQUEST ['tipo_ordenador'],
            "id_proveedor" => $id_Proveedor,
            "unidad_ejecutora" => $_REQUEST['unidad_ejecutora'],
            "clausula_presupuesto" => $clausula_presupuesto,
        );

        $SQLs[3] = $this->miSql->getCadenaSql('insertarOrden', $datosOrden);
        $consecutivos_orden = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda", $datosOrden, 'insertarOrden');
        $trans_Registro_Orden = $esteRecursoDB->transaccion($SQLs);
        if ($trans_Registro_Orden != false) {
            if($consecutivo_compra!='NULL'){
                $consecutivo=$consecutivo_compra;
            }else{
                $consecutivo=$consecutivo_servicio;
            }            
            $datos = "NÚMERO DE " . $nombre . " # " . $consecutivo . "<br> Y VIGENCIA " . date('Y');
            $this->miConfigurador->setVariableConfiguracion("cache", true);
            redireccion::redireccionar('inserto', array(
                $datos,
                $consecutivo
            ));
            exit();
        } else {
            redireccion::redireccionar('noInserto', $datos);
            exit();
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