<?php
use gestionCompras\gestionInformacionPresupuestal\funcion\redireccion;

include_once ('redireccionar.php');

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class RegistradorOrden {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miFuncion;
	var $miSql;
	var $conexion;
	function __construct($lenguaje, $sql, $funcion) {
		$this->miConfigurador = \Configurador::singleton ();
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		$this->lenguaje = $lenguaje;
		$this->miSql = $sql;
		$this->miFuncion = $funcion;
	}
	function procesarFormulario() {
		$datos = array (
				$_REQUEST ['id_orden'],
				$_REQUEST ['mensaje_titulo'],
				$_REQUEST ['usuario'] 
		);
		
		if ($_REQUEST ['valor_orden'] < (($_REQUEST ['total_solicitado'] - $_REQUEST ['solicitado_anterior']) + $_REQUEST ['valor_solicitud'])) {
			
			redireccion::redireccionar ( "ErrorValorAsignarModificar", $datos );
			
			exit ();
		}
		
		$conexion = "contractual";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$arregloDatos = array (
				"vigencia" => $_REQUEST ['vigencia_disponibilidad'],
				"unidad_ejecutora" => $_REQUEST ['unidad_ejecutora_hidden'],
				"diponibilidad" => $_REQUEST ['diponibilidad'],
				"fecha_diponibilidad" => $_REQUEST ['fecha_diponibilidad'],
				"valor_disponibilidad" => $_REQUEST ['valor_disponibilidad'],
				"valor_solicitud" => $_REQUEST ['valor_solicitud'],
				"valorLetras_disponibilidad" => $_REQUEST ['valorLetras_disponibilidad'],
				"id_disponibilidad" => $_REQUEST ['id_disponibilidad'],
				"id_rubro" => $_REQUEST ['rubro'] 
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'modificarDisponibilidades', $arregloDatos );
		$Orden = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "acceso" );
		
		if ($Orden == true) {
			$this->miConfigurador->setVariableConfiguracion ( "cache", true );
			
			if ($_REQUEST ['valor_orden'] == (($_REQUEST ['total_solicitado'] - $_REQUEST ['solicitado_anterior']) + $_REQUEST ['valor_solicitud'])) {
				redireccion::redireccionar ( "ModificarDisponibilidadCompleta", $datos );
				exit ();
			} else {
				redireccion::redireccionar ( "ModificarDisponibilidad", $datos );
				exit ();
			}
		} else {
			
			redireccion::redireccionar ( "noModificoDisponibilidad", $datos );
			exit ();
		}
	}
	function resetForm() {
		foreach ( $_REQUEST as $clave => $valor ) {
			
			if ($clave != 'pagina' && $clave != 'development' && $clave != 'jquery' && $clave != 'tiempo') {
				unset ( $_REQUEST [$clave] );
			}
		}
	}
}

$miRegistrador = new RegistradorOrden ( $this->lenguaje, $this->sql, $this->funcion );

$resultado = $miRegistrador->procesarFormulario ();

?>