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
        $rutaBloque = $this->miConfigurador->getVariableConfiguracion("raizDocumento") . "/blocks/gestionContractual/novedad/";
        $rutaBloque .= $esteBloque ['nombre'];
        $host = $this->miConfigurador->getVariableConfiguracion("host") . $this->miConfigurador->getVariableConfiguracion("site") . $rutaBloque;


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
                
                if (isset($_REQUEST ['diasSuspension']) && $_REQUEST ['diasSuspension'] != "") {
                    $diaSuspencion = $_REQUEST ['diasSuspension'];
                }
                else {
                    $diaSuspencion=0;
                }
                
                $arreglo_novedad = array(
                    'numero_contrato' => $_REQUEST['numero_contrato'],
                    'vigencia' => $_REQUEST['vigencia'],
                    'tipo_novedad' => $_REQUEST['tipo_novedad'],
                    'fecha_novedad' => $_REQUEST ['fecha_novedad'],
                    'numero_acto' => $_REQUEST ['numero_acto'],
                    'diasSuspension' => $diaSuspencion,
                    'observaciones' => $_REQUEST ['observaciones'],
                    'ruta_documento' => $destino1,
                );

                $cadenaSql = $this->miSql->getCadenaSql('registroNovedad', $arreglo_novedad);
                $novedad = $esteRecursoDB->ejecutarAcceso($cadenaSql, "acceso", $arreglo_novedad, 'registroNovedad');
                $registro = $novedad;
            }
        }
        
        
         $datosContrato=array('numero_contrato'=>$_REQUEST['numero_contrato'],
            'vigencia'=>$_REQUEST['vigencia']);

        if (isset($registro) && $registro != false) {
            redireccion::redireccionar("Inserto", $datosContrato);
            exit();
        } else {
            redireccion::redireccionar("ErrorRegistro",$datosContrato);
            exit();
        }
    }

}

$miRegistrador = new RegistradorContrato($this->lenguaje, $this->sql, $this->funcion);

$resultado = $miRegistrador->procesarFormulario();
?>