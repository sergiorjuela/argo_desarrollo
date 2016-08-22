<?php

namespace gestionContractual\consultaContratosAprobados;

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
            case "unidad_ejecutora_gasto" :

                $cadenaSql = "SELECT id_parametro  id, pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='unidad_ejecutora_gasto' ORDER BY id_parametro DESC ; ";
                break;


            case "dependenciasConsultadas" :
                $cadenaSql = "SELECT DISTINCT  \"ESF_CODIGO_DEP\" , \"ESF_DEP_ENCARGADA\" ";
                $cadenaSql .= " FROM \"SICapital\".\"dependencia_SIC\" ad ";
                $cadenaSql .= " JOIN  \"SICapital\".\"espaciosfisicos_SIC\" ef ON  ef.\"ESF_ID_ESPACIO\"=ad.\"ESF_ID_ESPACIO\" ";
                $cadenaSql .= " JOIN  \"SICapital\".\"sedes_SIC\" sa ON sa.\"ESF_COD_SEDE\"=ef.\"ESF_COD_SEDE\" ";
                $cadenaSql .= " WHERE sa.\"ESF_ID_SEDE\"='" . $variable . "' ";
                $cadenaSql .= " AND  ad.\"ESF_ESTADO\"='A'";
                break;



            case "buscar_Proveedores" :
                $cadenaSql = " SELECT nit||' - ('||nomempresa||')' AS  value, nit AS data  ";
                $cadenaSql .= " FROM proveedor.prov_proveedor_info ";
                $cadenaSql .= " WHERE cast(nit as text) LIKE '%$variable%' OR nomempresa LIKE '%$variable%' LIMIT 10; ";
                break;




            case "convenios" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " \"NUMERO_PRO\" as value,";
                $cadenaSql .= " \"NUMERO_PRO\" as data";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " convenio; ";
                break;


            case "vigencia_convenios" :
                $cadenaSql = " SELECT DISTINCT ";
                $cadenaSql .= " \"ANIO_PRO\" as value,";
                $cadenaSql .= " \"ANIO_PRO\" as data";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " convenio ORDER BY \"ANIO_PRO\" DESC; ";
                break;

            case "buscar_nombre_convenio" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " \"NOMBRE\"";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " convenio";
                $cadenaSql .= " WHERE ";
                $cadenaSql .= " \"NUMERO_PRO\" = '$variable' ";
                break;

            case "consultarOrdenGeneral" :

                $cadenaSql = "SELECT DISTINCT o.id_orden, p.descripcion, o.numero_contrato, o.vigencia, o.fecha_registro, cg.contratista ||'-'|| cg.nombre_contratista as proveedor,"
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
                $cadenaSql .= "AND cg.unidad_ejecutora = '" . $variable ['unidad_ejecutora'] . "' ";
                $cadenaSql .= "AND o.estado = 'true' AND cg.estado_aprobacion = 't' AND ec.id = 3";
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

                $cadenaSql = "SELECT DISTINCT o.id_orden, p.descripcion, o.numero_contrato, o.vigencia, o.fecha_registro, cg.contratista ||'-'|| cg.nombre_contratista as proveedor,"
                        . " 'IDEXUD'||'-'||conv.\"NOMBRE\" as SedeDependencia , cg.numero_solicitud_necesidad,cg.numero_cdp, ec.nombre_estado, ce.fecha_registro as fecha_registro_estado ";
                $cadenaSql .= "FROM orden o, parametros p,  contrato_general cg, convenio conv, ";
                $cadenaSql .= "contrato_estado ce, estado_contrato ec  ";
                $cadenaSql .= "WHERE o.tipo_orden = p.id_parametro ";
                $cadenaSql .= "AND conv.\"NUMERO_PRO\"  = cg.convenio_solicitante ";
                $cadenaSql .= "AND cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id ";
                $cadenaSql .= "AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where o.numero_contrato = cee.numero_contrato and  o.vigencia = cee.vigencia) ";
                $cadenaSql .= "AND o.numero_contrato = cg.numero_contrato ";
                $cadenaSql .= "AND o.vigencia = cg.vigencia ";
                $cadenaSql .= "AND cg.unidad_ejecutora = '" . $variable ['unidad_ejecutora'] . "' ";
                $cadenaSql .= "AND o.estado = 'true' AND cg.estado_aprobacion = 't' AND ec.id = 3 ";
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




            //-------------------- Agregadas -----------------------------------------------------

            case "buscar_numero_orden" :

                $cadenaSql = " 	SELECT 	o.numero_contrato ||'-'|| o.vigencia as value, o.numero_contrato ||'-'||o.vigencia as orden ";
                $cadenaSql .= " FROM orden o, contrato_general cg, contrato_estado ce, estado_contrato ec  ";
                $cadenaSql .= " WHERE o.numero_contrato = cg.numero_contrato and o.vigencia = cg.vigencia and  cg.unidad_ejecutora ='" . $variable['unidad'] . "' ";
                $cadenaSql .= " AND cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id ";
                $cadenaSql .= " AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where o.numero_contrato = cee.numero_contrato and  o.vigencia = cee.vigencia) ";
                $cadenaSql .= " and tipo_orden ='" . $variable['tipo_orden'] . "' and cg.estado_aprobacion = 't' AND ec.id = 3 ;";

                break;
            case "buscarProveedoresFiltro" :
                $cadenaSql = " SELECT DISTINCT contratista||' - ('||nombre_contratista||')' AS  value, contratista AS data  ";
                $cadenaSql .= " FROM contrato_general ";
                $cadenaSql .= " WHERE cast(contratista as text) LIKE '%$variable%' OR nombre_contratista LIKE '%$variable%' LIMIT 10; ";
                break;


          
            
              case 'buscar_contrato' :
                $cadenaSql = " SELECT  DISTINCT c.numero_contrato||'-('||c.vigencia||')' AS  data, c.numero_contrato||' - ('||c.vigencia||')'  AS value  ";
                $cadenaSql .= " FROM contrato c, contrato_general cg, contrato_estado ce, estado_contrato ec  ";
                $cadenaSql .= " WHERE c.numero_contrato = cg.numero_contrato and c.vigencia = cg.vigencia and  cg.unidad_ejecutora ='" . $variable['unidad'] . "' ";
                $cadenaSql .= " AND cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id ";
                $cadenaSql .= " AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where c.numero_contrato = cee.numero_contrato and  c.vigencia = cee.vigencia) ";
                $cadenaSql .= " AND cg.estado_aprobacion = 't' AND ec.id = 3  ";
                $cadenaSql .= " AND cast(c.numero_contrato as text) LIKE '%" . $variable['parametro'] . "%' ";
                $cadenaSql .= "OR cast(c.vigencia as text ) LIKE '%" . $variable['parametro'] . "%'  ";
                $cadenaSql .= "   LIMIT 10;";
                break;


            case "sede" :

            case "obtenerInfoUsuario" :
                $cadenaSql = "SELECT u.dependencia_especifica ||' - '|| u.dependencia as nombre, unidad_ejecutora ";
                $cadenaSql .= "FROM frame_work.argo_usuario u  ";
                $cadenaSql .= "WHERE u.id_usuario='" . $variable . "' ";
                break;

            case "tipo_clase_contrato" :

                $cadenaSql = "SELECT id_parametro  id, pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='clase_contrato'; ";

                break;

            case "consultarContratosGeneral" :

                $cadenaSql = "SELECT DISTINCT c.id_contrato_normal, p.descripcion, c.numero_contrato, c.vigencia, c.fecha_registro, cg.contratista ||'-'|| cg.nombre_contratista as proveedor,cg.tipo_contrato, "
                        . "  cg.numero_solicitud_necesidad,cg.numero_cdp, ec.nombre_estado, ce.fecha_registro as fecha_registro_estado ";
                $cadenaSql .= "FROM contrato c, parametros p, contrato_general cg, ";
                $cadenaSql .= "contrato_estado ce, estado_contrato ec  ";
                $cadenaSql .= "WHERE cg.tipo_contrato = p.id_parametro ";
                $cadenaSql .= "AND cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id ";
                $cadenaSql .= "AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where c.numero_contrato = cee.numero_contrato and  c.vigencia = cee.vigencia) ";
                $cadenaSql .= "AND c.numero_contrato = cg.numero_contrato ";
                $cadenaSql .= "AND c.vigencia = cg.vigencia ";
                $cadenaSql .= "AND cg.unidad_ejecutora = '" . $variable ['unidad_ejecutora'] . "' ";
                $cadenaSql .= "AND c.estado_registro = 'true' AND cg.estado_aprobacion = 't' AND ec.id = 3 ";
                if ($variable ['clase_contrato'] != '') {
                    $cadenaSql .= " AND cg.tipo_contrato = '" . $variable ['clase_contrato'] . "' ";
                }
                if ($variable ['numero_contrato'] != '') {
                    $cadenaSql .= " AND c.numero_contrato = '" . $variable ['numero_contrato'] . "' ";
                }
                if ($variable ['vigencia'] != '') {
                    $cadenaSql .= " AND c.vigencia = '" . $variable ['vigencia'] . "' ";
                }

                if ($variable ['nit'] != '') {
                    $cadenaSql .= " AND cg.contratista = '" . $variable ['nit'] . "' ";
                }

                if ($variable ['fecha_inicial'] != '' && $variable ['fecha_final'] != '') {
                    $cadenaSql .= " AND c.fecha_registro BETWEEN CAST ( '" . $variable ['fecha_inicial'] . "' AS DATE) ";
                    $cadenaSql .= " AND  CAST ( '" . $variable ['fecha_final'] . "' AS DATE)  ";
                }

                $cadenaSql .= " ; ";

                break;


            case 'Consultar_Contrato_Particular' :

                $cadenaSql = " SELECT  ";
                $cadenaSql .= " c.*,cg.tipo_contrato,cg.objeto_contrato,cg.fecha_inicio, ";
                $cadenaSql .= " cg.fecha_final,cg.plazo_ejecucion,cg.forma_pago,cg.ordenador_gasto, ";
                $cadenaSql .= " cg.supervisor,cg.clausula_registro_presupuestal,cg.cargo_supervisor, ";
                $cadenaSql .= " cg.numero_solicitud_necesidad,cg.numero_cdp,cg.contratista,cg.unidad_ejecucion, cg.valor_contrato as vcontrato ";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " contractual.contrato c,contractual.contrato_general cg ";
                $cadenaSql .= " WHERE ";
                $cadenaSql .= " c.numero_contrato=cg.numero_contrato and ";
                $cadenaSql .= " c.vigencia = cg.vigencia and cg.numero_contrato= '$variable[0]' and ";
                $cadenaSql .= " c.vigencia = $variable[1] ; ";

                break;

            case "Consultar_Disponibilidad" :
                $cadenaSql = " SELECT DISTINCT CDP.NUMERO_DISPONIBILIDAD, CDP.VIGENCIA,";
                $cadenaSql.=" CDP.FECHA_REGISTRO,SN.VALOR_CONTRATACION from ";
                $cadenaSql.=" CO.CO_SOLICITUD_ADQ SN, PR.PR_DISPONIBILIDADES CDP, CO.CO_DEPENDENCIAS DP ";
                $cadenaSql.=" where SN.NUM_SOL_ADQ = CDP.NUM_SOL_ADQ and SN.DEPENDENCIA = DP.COD_DEPENDENCIA and ";
                $cadenaSql.=" SN.VIGENCIA= $variable[1] and SN.CODIGO_UNIDAD_EJECUTORA = '0$variable[2]' and SN.NUM_SOL_ADQ = $variable[0] ";
                $cadenaSql.=" and SN.ESTADO = 'APROBADA' and CDP.ESTADO = 'VIGENTE' ";
                break;



            case "tipo_clase_contratista" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='clase_contratista'; ";
                break;

            case "tipo_compromiso" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipo_compromiso'; ";
                break;

            case "tipo_ejecucion_tiempo" :

                $cadenaSql = "SELECT id_parametro  id, pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipo_ejecucion_tiempo'; ";
                break;

            case "tipologia_contrato" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipologia_contrato'; ";
                break;

            case "modalidad_seleccion" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='modalidad_seleccion'; ";
                break;

            case "tipo_procedimiento" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='procedimiento'; ";
                break;

            case "regimen_contratacion" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='regimen_contratacion'; ";
                break;

            case "tipo_moneda" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipo_moneda'; ";
                break;

            case "ordenadorGasto" :

                $cadenaSql = " 	select \"ORG_IDENTIFICADOR_UNICO\", \"ORG_ORDENADOR_GASTO\"   from argo_ordenadores ";
                $cadenaSql .= " where \"ORG_ESTADO\" = 'A' and \"ORG_ORDENADOR_GASTO\" <> 'DIRECTOR IDEXUD'; ";

                break;

            case "tipo_gasto" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipo_gasto'; ";
                break;

            case "origen_recursos" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='origen_recursos'; ";
                break;


            case "origen_presupuesto" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='origen_presupuesto'; ";
                break;

            case "tema_gasto" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tema_gasto'; ";
                break;

            case "tipo_control" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipo_control'; ";
                break;

            case "informacion_ordenador" :
                $cadenaSql = " 	SELECT  \"ORG_NOMBRE\",  \"ORG_IDENTIFICACION\",  \"ORG_IDENTIFICADOR\"  ";
                $cadenaSql .= " FROM argo_ordenadores ";
                $cadenaSql .= " WHERE \"ORG_ESTADO\" = 'A' and  \"ORG_IDENTIFICADOR_UNICO\" = '$variable';";

                break;




            case "funcionarios" :

                $cadenaSql = " SELECT  FUN_IDENTIFICACION , FUN_IDENTIFICACION ";
                $cadenaSql .= " ||' '|| FUN_NOMBRE  FROM SICAARKA.FUNCIONARIOS  WHERE FUN_ESTADO='A' ";

                break;


            case "tipo_unidad_ejecucion" :
                $cadenaSql = " SELECT id_parametro, descripcion  ";
                $cadenaSql .= " FROM parametros WHERE rel_parametro=21; ";

                break;




            case "ConsultarDescripcionParametro" :
                $cadenaSql = "SELECT descripcion ";
                $cadenaSql .= " FROM parametros ";
                $cadenaSql .= " WHERE id_parametro=" . $variable;

                break;

            case "registroActaInicio" :
                $cadenaSql = " INSERT INTO acta_inicio(";
                $cadenaSql .= " numero_contrato, vigencia,fecha_inicio,fecha_fin,usuario,descripcion) ";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'" . $variable ['numero_contrato'] . "',";
                $cadenaSql .= $variable ['vigencia'] . ",";
                $cadenaSql .= "'" . $variable ['fecha_inicio_acta'] . "',";
                $cadenaSql .= "'" . $variable ['fecha_final_acta'] . "',";
                $cadenaSql .= "'" . $variable ['usuario'] . "',";
                $cadenaSql .= "'" . $variable ['observaciones'] . "');";

                break;


            case "insertarEstadoActaContratoGeneral" :
                $cadenaSql = " INSERT INTO contrato_estado(";
                $cadenaSql .= " numero_contrato, vigencia,fecha_registro,usuario,estado ) ";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'" . $variable ['numero_contrato'] . "',";
                $cadenaSql .= $variable ['vigencia'] . ",";
                $cadenaSql .= "'" . $variable ['fecha'] . "',";
                $cadenaSql .= "'" . $variable ['usuario'] . "',";
                $cadenaSql .= $variable ['estado'] . ");";

                break;

            case "forma_pago" :
                $cadenaSql = " 	SELECT id_parametro, descripcion ";
                $cadenaSql .= " FROM  parametros ";
                $cadenaSql .= " WHERE rel_parametro=28 and id_parametro=240;";

                break;
        }
        return $cadenaSql;
    }

}

?>
