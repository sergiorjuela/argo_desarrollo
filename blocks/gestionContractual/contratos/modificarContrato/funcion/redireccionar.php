<?

namespace contratos\modificarContrato\funcion;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
}
class redireccion {
	public static function redireccionar($opcion, $valor = "", $valor1 = "") {
		$miConfigurador = \Configurador::singleton ();
		$miPaginaActual = $miConfigurador->getVariableConfiguracion ( "pagina" );

		
		
		switch ($opcion) {
			case "Actualizo" :
				
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&bloque=" . $_REQUEST ['bloque'];
				$variable .= "&bloqueGrupo=" . $_REQUEST ["bloqueGrupo"];
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=Actualizo";
				$variable .= "&numero_contrato=" . $valor ['numero_contrato'];
				$variable .= "&vigencia=" . $valor ['vigencia'];
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				
				break;
			case "NoActualizo" :
				
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&bloque=" . $_REQUEST ['bloque'];
				$variable .= "&bloqueGrupo=" . $_REQUEST ["bloqueGrupo"];
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=NoActualizo";
				$variable .= "&numero_contrato=" . $valor ['numero_contrato'];
				$variable .= "&vigencia=" . $valor ['vigencia'];
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				
				break;
			
			case "ErrorRegistro" :
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&bloque=" . $_REQUEST ['bloque'];
				$variable .= "&bloqueGrupo=" . $_REQUEST ["bloqueGrupo"];
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=noInserto";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				break;
			

			case "Salir" :
				
				$variable = "pagina=indexAlmacen";
				
				break;
			
			case "SalidaElemento" :
				
				$variable = "pagina=registrarSalidas";
				$variable .= "&opcion=Salida";
				$variable .= "&numero_entrada=" . $valor;
				$variable .= "&datosGenerales=" . $valor1;
				break;
			
			
		}
		
		foreach ( $_REQUEST as $clave => $valor ) {
			unset ( $_REQUEST [$clave] );
		}
		
		
		
		$url = $miConfigurador->configuracion ["host"] . $miConfigurador->configuracion ["site"] . "/index.php?";
		$enlace = $miConfigurador->configuracion ['enlace'];
		$variable = $miConfigurador->fabricaConexiones->crypto->codificar ( $variable );
		$_REQUEST [$enlace] = $enlace . '=' . $variable;
		$redireccion = $url . $_REQUEST [$enlace];
		
		echo "<script>location.replace('" . $redireccion . "')</script>";

	}
}

?>