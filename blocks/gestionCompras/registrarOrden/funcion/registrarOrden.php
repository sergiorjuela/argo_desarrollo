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
  
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        $SQLs = [];
        $fechaActual = date('Y-m-d');

        $conexion = "contractual";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        if ($_REQUEST ['tipo_persona'] == 'Juridica') {
            $tipo_persona = 2;
        } else {
            $tipo_persona = 1;
        }
        if ($_REQUEST ['tipo_documento'] == 'CC') {
            $tipo_documento = 184;
        } else {
            $tipo_documento = 186;
        }
        
        $datosContratista = array('razonSocial' => $_REQUEST ['nombre_razon_proveedor'],
            'direcccion' => $_REQUEST ['direccion_proveedor'],
            'nombreRepresentante' => $_REQUEST ['nombre_contratista'],
            'identificacionRepresentante' => $_REQUEST ['identifcacion_contratista'],
            'cargo_contratista' => $_REQUEST ['cargo_contratista'],
            'nit' => $_REQUEST ['identifcacion_proveedor'],
            'telefono' => $_REQUEST ['telefono_proveedor'],
            'correo' => $_REQUEST ['correo_proveedor'],
            'digito_verificacion' => $_REQUEST ['digito_verificacion'],
            'nacionalidad' => $_REQUEST ['pais'],
            'sitio_web' => $_REQUEST ['sitio_web'],
            'nombre_acesor' => $_REQUEST ['nombre_acesor'],
            'procedencia' => $_REQUEST ['procedencia'],
            'ubicacion_proveedor' => $_REQUEST ['ubicacion_proveedor'],
            'fecha' => date('Y-m-d'),
            'tipo_persona' => $tipo_persona,
            'tipo_documento' => $tipo_documento,
            'registro_mercantil' => $_REQUEST ['registro_mercantil']);
        

        $unidad_ejecutura = strpos($_REQUEST ['unidad_ejecutora'], 'IDEXUD - IDEXUD');
       
        if (!is_int($unidad_ejecutura)) {
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
        } else {
            $clausula_presupuesto = 'false';
        }
        if (isset($_REQUEST ['fecha_inicio_pago']) && $_REQUEST ['fecha_inicio_pago'] != '') {
            $fecha_inicio = "'".$_REQUEST ['fecha_inicio_pago']."'";
        } else {
            $fecha_inicio = 'null';
        }
        if (isset($_REQUEST ['fecha_final_pago']) && $_REQUEST ['fecha_final_pago'] != '' ) {
            $fecha_fin = "'".$_REQUEST ['fecha_final_pago']."'";
        } else {
            $fecha_fin = 'null';
        }
        
        
        $datosContratoGeneral = array('vigencia' => (int) date('Y'),
            'id_orden_contrato' => 1,
            'tipo_contrato' => 98,
            'unidad_ejecutura' => $unidad_ejecutura,
            'objeto_contrato' => $_REQUEST ['objeto_contrato'],
            'fecha_inicio' =>$fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'plazo_ejecucion' => $_REQUEST ['plazo_ejecucion'],
            'clausula_presupuesto' => $clausula_presupuesto,
            'ordenador_gasto' => $_REQUEST ['asignacionOrdenador'],
            'supervisor' => $_REQUEST ['nombre_supervisor'],
            'sede_supervisor' => $_REQUEST ['sede_super'],
            'dependencia_supervisor' => $_REQUEST ['dependencia_supervisor'],
            'cargo_supervisor' => $_REQUEST ['cargo_supervisor'],
            'sede_solicitante' => $sede_solicitante,
            'dependencia_solicitante' => $dependencia_solicitante,
            'forma_pago' => $_REQUEST ['formaPago'],
            'numero_solicitud' => $_REQUEST ['numero_solicitud'],
            'numero_cdp' => $_REQUEST ['numero_cdp'],
            );
               
        $datosOrden = array('tipo_orden' => $_REQUEST ['tipo_orden'],
            'numero_contrato' => "currval('numero_unico_contrato_seq')",
            'vigencia' => (int) date('Y'),
            'fecha' => date('Y-m-d'),
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
        
        $sqlValidarContratista = $this->miSql->getCadenaSql('validarContratista', $datosContratista['nit']);
        $contratista = $esteRecursoDB->ejecutarAcceso($sqlValidarContratista, "busqueda");
        if($contratista == false){
            // Registro Contratista
            $SQLsContratista = $this->miSql->getCadenaSql('insertarContratista', $datosContratista);
            array_push($SQLs, $SQLsContratista);
        }
        
       // Registro Contrato General
        $SQLsContratoGeneral = $this->miSql->getCadenaSql('insertarContratoGeneral', $datosContratoGeneral);
        array_push($SQLs, $SQLsContratoGeneral);
      
        // Registro Orden
        $SQLsOrden = $this->miSql->getCadenaSql('insertarOrden', $datosOrden);
        array_push($SQLs, $SQLsOrden);
        // Registro de Polizas
        for ($i = 0; $i < count($polizas); $i++) {
            $datosPoliza = array('poliza' => $polizas[$i],
                'orden' => "currval('id_orden_seq')");
            $sqlPoliza = $this->miSql->getCadenaSql('insertarPoliza', $datosPoliza);
            array_push($SQLs, $sqlPoliza);
        }
       
        $trans_Registro_Orden = $esteRecursoDB->transaccion($SQLs);
        $sqlNumeroContrato = $this->miSql->getCadenaSql('obtenerInfoOrden');
        $resultado = $esteRecursoDB->ejecutarAcceso($sqlNumeroContrato, "busqueda");
        $identificadorOrden = $resultado[0];

        if ($trans_Registro_Orden != false) {
            $datos = array('mensaje'=>"Contrato de Orden de Compra Almacenado Con Éxito, Numero: ".
                $identificadorOrden['numero_contrato'] . ". VIGENCIA " . date('Y'),
                'id_orden'=> $identificadorOrden['numero_contrato'] );
            $this->miConfigurador->setVariableConfiguracion("cache", true);
            redireccion::redireccionar('inserto',  $datos);
            exit();
        } else {
            echo "entro";
            $datos = "No se pudo llevar a cabo el registro del contrato";
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