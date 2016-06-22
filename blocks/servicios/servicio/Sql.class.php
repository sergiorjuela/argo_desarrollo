<?php

namespace servicios\servicio;

if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class Sql extends \Sql {

    var $miConfigurador;

    function getCadenaSql($tipo, $variable = '') {

        /**
         * 1.
         * Revisar las variables para evitar SQL Injection
         */
        $prefijo = $this->miConfigurador->getVariableConfiguracion("prefijo");
        $idSesion = $this->miConfigurador->getVariableConfiguracion("id_sesion");

        switch ($tipo) {
            /**
             * Clausulas específicas
             */
            case "elementos_orden" :
                $cadenaSql = " select * from contractual.elemento_acta_recibido ";
                $cadenaSql .= " where ";
                $cadenaSql .= " id_orden = " . $variable['id_orden'] . " ";
                if (isset($variable['fecha'])) {
                    $cadenaSql .= "  and fecha_registro > '".$variable['fecha']."' ";
                }
                $cadenaSql .= "  ; ";
                break;
           
            case "servicio_ordenes" :
                $cadenaSql = " select o.id_orden, pr.descripcion, o.vigencia, o.numero_contrato, p.nombre_razon_social  ";
                $cadenaSql .= " from contractual.orden o, contractual.contratista p, parametros pr   ";
                $cadenaSql .= " where o.proveedor=p.identificacion and o.tipo_orden=pr.id_parametro;   ";
              
        }

        return $cadenaSql;
    }

}

?>
