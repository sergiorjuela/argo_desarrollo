<?php
use contratos\modificarContrato\Sql;

$conexion = "contractual";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );

if ($_REQUEST ['funcion'] == 'NumeroSolicitud') {
	
	$cadenaSql = $this->sql->getCadenaSql ( 'ConsultarNumeroNecesidades', $_REQUEST ['valor'] );
	echo $cadenaSql;exit;
	$resultadoItems = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );

	echo json_encode ( $resultadoItems );
}

if ($_REQUEST ['funcion'] == 'consultaContrato') {

	$cadenaSql = $this->sql->getCadenaSql ( 'buscar_contrato', $_GET ['query'] );

	$resultadoItems = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );

	foreach ( $resultadoItems as $key => $values ) {
		$keys = array (
				'value',
				'data'
		);
		$resultado [$key] = array_intersect_key ( $resultadoItems [$key], array_flip ( $keys ) );
	}

	echo '{"suggestions":' . json_encode ( $resultado ) . '}';
}




if ($_REQUEST ['funcion'] == 'consultaContratista') {

	$cadenaSql = $this->sql->getCadenaSql ( 'buscar_contratista', $_GET ['query'] );
	
	$resultadoItems = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );

	foreach ( $resultadoItems as $key => $values ) {
		$keys = array (
				'value',
				'data'
		);
		$resultado [$key] = array_intersect_key ( $resultadoItems [$key], array_flip ( $keys ) );
	}

	echo '{"suggestions":' . json_encode ( $resultado ) . '}';
}





?>