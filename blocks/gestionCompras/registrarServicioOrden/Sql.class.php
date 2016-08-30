<?php

namespace gestionCompras\registrarServicioOrden;

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

    function __construct() {
        $this->miConfigurador = \Configurador::singleton();
    }

    function getCadenaSql($tipo, $variable = "") {

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
            case "tipo_orden" :

                $cadenaSql = " 	SELECT 	id_parametro, ";
                $cadenaSql .= " descripcion ";
                $cadenaSql .= " FROM  ";
                $cadenaSql .= " parametros ";
                $cadenaSql .= " WHERE  ";
                $cadenaSql .= " estado_registro=TRUE  ";
                $cadenaSql .= " AND  ";
                $cadenaSql .= " rel_parametro=30 AND id_parametro <> 245;  ";

                break;
            case "obtenerInfoUsuario" :
                $cadenaSql = "SELECT u.dependencia_especifica ||' - '|| u.dependencia as nombre, unidad_ejecutora ";
                $cadenaSql .= "FROM frame_work.argo_usuario u  ";
                $cadenaSql .= "WHERE u.id_usuario='" . $variable . "' ";
                break;




            case "buscar_numero_orden" :

                $cadenaSql = " 	SELECT 	o.numero_contrato ||'-'|| o.vigencia as value, o.numero_contrato ||'-'||o.vigencia as orden ";
                $cadenaSql .= " FROM orden o, contrato_general cg, contrato_estado ce, estado_contrato ec  ";
                $cadenaSql .= " WHERE o.numero_contrato = cg.numero_contrato and o.vigencia = cg.vigencia and  cg.unidad_ejecutora ='" . $variable . "' ";
                $cadenaSql .= " AND cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id ";
                $cadenaSql .= " AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where o.numero_contrato = cee.numero_contrato and  o.vigencia = cee.vigencia) ";
                $cadenaSql .= " and tipo_orden = 246 and cg.estado_aprobacion = 'f' AND ec.id = 1 ;";

                break;

            case "sede" :

                $cadenaSql = "SELECT DISTINCT  \"ESF_ID_SEDE\", \"ESF_SEDE\" ";
                $cadenaSql .= " FROM \"SICapital\".\"sedes_SIC\" ";
                $cadenaSql .= " WHERE   \"ESF_ESTADO\"='A' ";
                $cadenaSql .= " AND    \"ESF_COD_SEDE\" >  0 ;";
                break;

            case "convenios" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " \"NUMERO_PRO\" as value,";
                $cadenaSql .= " \"NUMERO_PRO\" as data";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " convenio; ";
                break;

            case "consultarOrdenGeneral" :

                $cadenaSql = "SELECT DISTINCT o.id_orden, p.descripcion, o.numero_contrato, o.vigencia, o.fecha_registro, cg.contratista ||'-'|| cg.nombre_contratista as proveedor,cg.unidad_ejecutora, "
                        . " se.\"ESF_SEDE\" ||'-'|| dep.\"ESF_DEP_ENCARGADA\" as SedeDependencia, cg.numero_solicitud_necesidad,cg.numero_cdp, ec.nombre_estado, ce.fecha_registro as fecha_registro_estado ";
                $cadenaSql .= "FROM orden o, parametros p, contrato_general cg, \"SICapital\".\"sedes_SIC\" se, \"SICapital\".\"dependencia_SIC\" dep, ";
                $cadenaSql .= "contrato_estado ce, estado_contrato ec  ";
                $cadenaSql .= "WHERE o.tipo_orden = p.id_parametro ";
                $cadenaSql .= "AND se.\"ESF_ID_SEDE\" = cg.sede_solicitante ";
                $cadenaSql .= "AND cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id ";
                $cadenaSql .= "AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where o.numero_contrato = cee.numero_contrato and  o.vigencia = cee.vigencia) ";
                $cadenaSql .= "AND dep.\"ESF_CODIGO_DEP\" = cg.dependencia_solicitante ";
                $cadenaSql .= "AND o.numero_contrato = cg.numero_contrato ";
                $cadenaSql .= "AND o.vigencia = cg.vigencia ";
                $cadenaSql .= "AND cg.unidad_ejecutora = " . $variable ['unidad_ejecutora'] . " ";
                $cadenaSql .= "AND o.estado = 'true' AND cg.estado_aprobacion = 'f'  ";
                if ($variable ['tipo_orden'] != '') {
                    $cadenaSql .= " AND o.tipo_orden = '" . $variable ['tipo_orden'] . "' ";
                }
                if ($variable ['numero_contrato'] != '') {
                    $cadenaSql .= " AND o.numero_contrato = '" . $variable ['numero_contrato'] . "' ";
                }
                if ($variable ['vigencia'] != '') {
                    $cadenaSql .= " AND o.vigencia = '" . $variable ['vigencia'] . "' ";
                }

                if ($variable ['nit'] != '') {
                    $cadenaSql .= " AND cg.contratista = '" . $variable ['nit'] . "' ";
                }

                if ($variable ['sede'] != '') {
                    $cadenaSql .= " AND se.\"ESF_ID_SEDE\" = '" . $variable ['sede'] . "' ";
                }

                if ($variable ['dependencia'] != '') {
                    $cadenaSql .= " AND dep.\"ESF_CODIGO_DEP\" = '" . $variable ['dependencia'] . "' ";
                }
                if ($variable ['fecha_inicial'] != '' && $variable ['fecha_final'] != '') {
                    $cadenaSql .= " AND o.fecha_registro BETWEEN CAST ( '" . $variable ['fecha_inicial'] . "' AS DATE) ";
                    $cadenaSql .= " AND  CAST ( '" . $variable ['fecha_final'] . "' AS DATE)  ";
                }

                $cadenaSql .= " ; ";

                break;


            case "consultarOrdenIdexud" :

                $cadenaSql = "SELECT DISTINCT o.id_orden, p.descripcion, o.numero_contrato, o.vigencia, o.fecha_registro, cg.contratista ||'-'|| cg.nombre_contratista as proveedor,conv.\"NUMERO_PRO\","
                        . " 'IDEXUD'||'-'||conv.\"NOMBRE\" as SedeDependencia , cg.numero_solicitud_necesidad,cg.numero_cdp, ec.nombre_estado, ce.fecha_registro as fecha_registro_estado,cg.unidad_ejecutora  ";
                $cadenaSql .= "FROM orden o, parametros p,  contrato_general cg, convenio conv, ";
                $cadenaSql .= "contrato_estado ce, estado_contrato ec  ";
                $cadenaSql .= "WHERE o.tipo_orden = p.id_parametro ";
                $cadenaSql .= "AND conv.\"NUMERO_PRO\"  = cg.convenio_solicitante ";
                $cadenaSql .= "AND cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id ";
                $cadenaSql .= "AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where o.numero_contrato = cee.numero_contrato and  o.vigencia = cee.vigencia) ";
                $cadenaSql .= "AND o.numero_contrato = cg.numero_contrato ";
                $cadenaSql .= "AND o.vigencia = cg.vigencia ";
                $cadenaSql .= "AND cg.unidad_ejecutora = " . $variable ['unidad_ejecutora'] . " ";
                $cadenaSql .= "AND o.estado = 'true' AND cg.estado_aprobacion = 'f' ";
                if ($variable ['tipo_orden'] != '') {
                    $cadenaSql .= " AND o.tipo_orden = '" . $variable ['tipo_orden'] . "' ";
                }
                if ($variable ['numero_contrato'] != '') {
                    $cadenaSql .= " AND o.numero_contrato = '" . $variable ['numero_contrato'] . "' ";
                }
                if ($variable ['vigencia'] != '') {
                    $cadenaSql .= " AND o.vigencia = '" . $variable ['vigencia'] . "' ";
                }

                if ($variable ['nit'] != '') {
                    $cadenaSql .= " AND cg.contratista = '" . $variable ['nit'] . "' ";
                }

                if ($variable ['dependencia'] != '') {
                    $cadenaSql .= " AND conv.\"NUMERO_PRO\" = '" . $variable ['dependencia'] . "' ";
                }
                if ($variable ['fecha_inicial'] != '' && $variable ['fecha_final'] != '') {
                    $cadenaSql .= " AND o.fecha_registro BETWEEN CAST ( '" . $variable ['fecha_inicial'] . "' AS DATE) ";
                    $cadenaSql .= " AND  CAST ( '" . $variable ['fecha_final'] . "' AS DATE)  ";
                }

                $cadenaSql .= " ; ";

                break;
                
            case "informacion_convenio" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " * ";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " convenio";
                $cadenaSql .= " WHERE ";
                $cadenaSql .= " \"NUMERO_PRO\" = '$variable' ";
                break;


            case "consultar_nivel_inventario" :

                $cadenaSql = "SELECT ce.elemento_id, ce.elemento_codigo||' - '||ce.elemento_nombre ";
                $cadenaSql .= "FROM inventarios.catalogo_elemento  ce ";
                $cadenaSql .= "JOIN inventarios.catalogo_lista cl ON cl.lista_id = ce.elemento_catalogo  ";
                $cadenaSql .= "WHERE cl.lista_activo = 1  ";
                $cadenaSql .= "AND  ce.elemento_id > 0  ";
                $cadenaSql .= "AND  ce.elemento_padre > 0  ";
                $cadenaSql .= "ORDER BY ce.elemento_codigo ASC ;";

                break;

            case "dependenciasConsultadas" :
                $cadenaSql = "SELECT DISTINCT \"ESF_CODIGO_DEP\" , \"ESF_DEP_ENCARGADA\" ";
                $cadenaSql .= " FROM \"SICapital\".\"dependencia_SIC\" ad ";
                $cadenaSql .= " JOIN  \"SICapital\".\"espaciosfisicos_SIC\" ef ON  ef.\"ESF_ID_ESPACIO\"=ad.\"ESF_ID_ESPACIO\" ";
                $cadenaSql .= " JOIN  \"SICapital\".\"sedes_SIC\" sa ON sa.\"ESF_COD_SEDE\"=ef.\"ESF_COD_SEDE\" ";
                $cadenaSql .= " WHERE sa.\"ESF_ID_SEDE\"='" . $variable . "' ";
                $cadenaSql .= " AND  ad.\"ESF_ESTADO\"='A'";

                break;
            case "buscarProveedoresFiltro" :
                $cadenaSql = " SELECT DISTINCT contratista||' - ('||nombre_contratista||')' AS  value, contratista AS data  ";
                $cadenaSql .= " FROM contrato_general ";
                $cadenaSql .= " WHERE cast(contratista as text) LIKE '%$variable%' OR nombre_contratista LIKE '%$variable%' LIMIT 10; ";
                break;

            case "registrarServicio" :
                $cadenaSql = " INSERT INTO servicio_orden(descripcion, nombre, fecha_registro, ";
                $cadenaSql.= " numero_contrato, vigencia,valor_servicio, codigo_ciiu, usuario)";
                $cadenaSql.= " VALUES ( ";
                $cadenaSql.= "'" . $variable['descripcion'] . "',";
                $cadenaSql.= "'" . $variable['resumen_servicio'] . "',";
                $cadenaSql.= "'" . $variable['fecha'] . "',";
                $cadenaSql.= "'" . $variable['numero_contrato'] . "',";
                $cadenaSql.= $variable['vigencia'] . ",";
                $cadenaSql.= $variable['valor_servicio'] . ",";
                $cadenaSql.= "'" . $variable['codigo_ciiu'] . "',";
                $cadenaSql.= "'" . $variable['usuario'] . "'";

                $cadenaSql.= " );";

                break;

            case "tipoServicio" :
                $cadenaSql = "SELECT id_clase, nombre FROM agora.ciiu_clase;";
                break;

            case "serviciosPorClase" :
                $cadenaSql = "SELECT id_subclase, nombre FROM agora.ciiu_subclase WHERE clase = '$variable';";
                break;


//----------------------------------------------------------------------------------------------------------------------------
        }
        return $cadenaSql;
    }

}

?>
