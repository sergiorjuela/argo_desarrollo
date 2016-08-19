<?php

use gestionContractual\consultaContratosAprobados\funcion\redireccion;

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
        $datosActadeInicio = array(
            'numero_contrato' => $_REQUEST['numero_contrato'],
            'vigencia' => $_REQUEST['vigencia'],
            'fecha_inicio_acta' => $_REQUEST['fecha_inicio_acta'],
            'fecha_final_acta' => $_REQUEST['fecha_final_acta'],
            'observaciones' => $_REQUEST['observaciones'],
            'usuario' => $_REQUEST['usuario'],
        );


        $cadenaSql = $this->miSql->getCadenaSql('registroActaInicio', $datosActadeInicio);
        array_push($SQLs, $cadenaSql);

        $datosEstado = array(
            'numero_contrato' => $_REQUEST['numero_contrato'],
            'vigencia' => $_REQUEST['vigencia'],
            'fecha' => date('Y-m-d H:i:s'),
            'usuario' => $_REQUEST['usuario'],
            'estado' => 4
        );

        $SQLsEstadoContratoGeneral = $this->miSql->getCadenaSql('insertarEstadoActaContratoGeneral', $datosEstado);
        array_push($SQLs, $SQLsEstadoContratoGeneral);
        
        $trans_Registro_Acta = $esteRecursoDB->transaccion($SQLs);

        if ($trans_Registro_Acta != false) {
            $this->miConfigurador->setVariableConfiguracion("cache", true);
            redireccion::redireccionar('registroActa',$datosActadeInicio);
            exit();
        } else {

            redireccion::redireccionar('noRegistroActa',$datosActadeInicio);
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