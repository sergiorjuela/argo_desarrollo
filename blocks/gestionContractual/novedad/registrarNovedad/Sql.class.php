<?php

namespace gestionContractual\novedad\registrarNovedad;

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
        case "tipo_clase_contrato" :

                $cadenaSql = "SELECT id_parametro  id, pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='clase_contrato'; ";

                break;
            case "sede" :

                $cadenaSql = "SELECT DISTINCT  \"ESF_ID_SEDE\", \"ESF_SEDE\" ";
                $cadenaSql .= " FROM \"SICapital\".\"sedes_SIC\" ";
                $cadenaSql .= " WHERE   \"ESF_ESTADO\"='A' ";
                $cadenaSql .= " AND    \"ESF_COD_SEDE\" >  0 ;";
                break;

            case "dependenciasConsultadas" :
                $cadenaSql = "SELECT DISTINCT  \"ESF_CODIGO_DEP\" , \"ESF_DEP_ENCARGADA\" ";
                $cadenaSql .= " FROM \"SICapital\".\"dependencia_SIC\" ad ";
                $cadenaSql .= " JOIN  \"SICapital\".\"espaciosfisicos_SIC\" ef ON  ef.\"ESF_ID_ESPACIO\"=ad.\"ESF_ID_ESPACIO\" ";
                $cadenaSql .= " JOIN  \"SICapital\".\"sedes_SIC\" sa ON sa.\"ESF_COD_SEDE\"=ef.\"ESF_COD_SEDE\" ";
                $cadenaSql .= " WHERE sa.\"ESF_ID_SEDE\"='" . $variable . "' ";
                $cadenaSql .= " AND  ad.\"ESF_ESTADO\"='A'";
                break;

            case "buscar_numero_orden" :

                $cadenaSql = " 	SELECT 	c.numero_contrato ||'-'|| c.vigencia as value, c.numero_contrato ||'-'||c.vigencia as orden ";
                $cadenaSql .= " FROM contrato c, contrato_general cg, contrato_estado ce, estado_contrato ec  ";
                $cadenaSql .= " WHERE c.numero_contrato = cg.numero_contrato and c.vigencia = cg.vigencia and  cg.unidad_ejecutora ='" . $variable['unidad'] . "' ";
                $cadenaSql .= " AND cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id ";
                $cadenaSql .= " AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where c.numero_contrato = cee.numero_contrato and  c.vigencia = cee.vigencia) ";
                $cadenaSql .= " and cg.tipo_contrato ='" . $variable['tipo_contrato'] . "' and cg.estado_aprobacion = 't' AND ec.id = 4 ;";

                break;

            case "buscar_Proveedores" :
                $cadenaSql = " SELECT nit||' - ('||nomempresa||')' AS  value, nit AS data  ";
                $cadenaSql .= " FROM proveedor.prov_proveedor_info ";
                $cadenaSql .= " WHERE cast(nit as text) LIKE '%$variable%' OR nomempresa LIKE '%$variable%' LIMIT 10; ";
                break;

            case "informacion_proveedor" :
                $cadenaSql = " SELECT nit, nomempresa, digitoverificacion,direccion,correo,telefono,pais,  ";
                $cadenaSql .= " tipopersona,primerapellido||' '||segundoapellido||' '||primernombre||' '||segundonombre as nombrerepresentate,"
                        . "tipodocumento,numdocumento,registromercantil  ";
                $cadenaSql .= " FROM proveedor.prov_proveedor_info  ";
                $cadenaSql .= " WHERE nit= $variable ";

                break;


            case "buscarProveedoresFiltro" :
                $cadenaSql = " SELECT DISTINCT contratista||' - ('||nombre_contratista||')' AS  value, contratista AS data  ";
                $cadenaSql .= " FROM contrato_general ";
                $cadenaSql .= " WHERE cast(contratista as text) LIKE '%$variable%' OR nombre_contratista LIKE '%$variable%' LIMIT 10; ";
                break;


            case "convenios" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " \"NUMERO_PRO\" as value,";
                $cadenaSql .= " \"NUMERO_PRO\" as data";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " convenio; ";
                break;

            case "conveniosxvigencia" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " \"NUMERO_PRO\" as value,";
                $cadenaSql .= " \"NUMERO_PRO\" as data";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " convenio ";
                $cadenaSql .= " WHERE \"ANIO_PRO\" = '$variable' ; ";
                break;

            case "vigencia_convenios" :
                $cadenaSql = " SELECT DISTINCT ";
                $cadenaSql .= " \"ANIO_PRO\" as value,";
                $cadenaSql .= " \"ANIO_PRO\" as data";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " convenio ORDER BY \"ANIO_PRO\" DESC; ";
                break;




            case 'Consultar_Contrato_Particular' :

                $cadenaSql = " SELECT DISTINCT cg.vigencia, cg.numero_contrato, cg.contratista ||' - '||cg.nombre_contratista as contratista,  ";
                $cadenaSql .= " pr.descripcion, cg.numero_solicitud_necesidad, cg.numero_cdp, sede.\"ESF_SEDE\" ,  ";
                $cadenaSql .= " dependencia.\"ESF_DEP_ENCARGADA\", cg.supervisor, cg.valor_contrato  FROM ";
                $cadenaSql .= " contractual.contrato_general cg, contractual.parametros pr, \"SICapital\".\"sedes_SIC\" sede, ";
                $cadenaSql .= " \"SICapital\".\"dependencia_SIC\" dependencia ";
                $cadenaSql .= " WHERE cg.unidad_ejecutora = CAST(pr.id_parametro as text) and ";
                $cadenaSql .= " sede.\"ESF_ID_SEDE\" = cg.sede_solicitante  and ";
                $cadenaSql .= " dependencia.\"ESF_CODIGO_DEP\" = cg.dependencia_solicitante  and ";
                $cadenaSql .= " cg.numero_contrato='" . $variable['numero_contrato'] . "' and ";
                $cadenaSql .= " cg.vigencia = " . $variable['vigencia'] . " ; ";

                break;
            case 'Consultar_Contrato_Particular_Idexud' :

                $cadenaSql = " SELECT DISTINCT cg.vigencia, cg.numero_contrato, cg.contratista ||' - '||cg.nombre_contratista as contratista,  ";
                $cadenaSql .= " pr.descripcion, cg.numero_solicitud_necesidad, cg.numero_cdp, conv.\"NOMBRE\" ,  ";
                $cadenaSql .= " conv.\"ENTIDAD\", cg.supervisor, cg.valor_contrato FROM ";
                $cadenaSql .= " contractual.contrato_general cg, contractual.parametros pr, convenio conv ";
                $cadenaSql .= " WHERE cg.unidad_ejecutora = CAST(pr.id_parametro as text) and ";
                $cadenaSql .= " conv.\"NUMERO_PRO\" = cg.convenio_solicitante  and ";
                $cadenaSql .= " cg.numero_contrato='" . $variable['numero_contrato'] . "' and ";
                $cadenaSql .= " cg.vigencia = " . $variable['vigencia'] . " ; ";

                break;


            case "tipo_novedad" :

                $cadenaSql = "SELECT id_parametro  id,pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipo_novedad' and pr.estado_registro = 't' order by pr.descripcion ASC ; ";
                break;

            case "consultarValorElementos" :

                $cadenaSql = "SELECT id_orden,SUM(total_iva_con) valor ";
                $cadenaSql .= " FROM elemento_acta_recibido  ";
                $cadenaSql .= " WHERE id_orden='" . $variable . "' and estado='t' ";
                $cadenaSql .= " GROUP BY id_orden;  ";
                break;

            case "tipo_unidad_ejecucion" :
                $cadenaSql = " SELECT id_parametro, descripcion  ";
                $cadenaSql .= " FROM parametros WHERE rel_parametro=21; ";

                break;

            case "tipo_anulacion" :
                $cadenaSql = " SELECT id_parametro, descripcion  ";
                $cadenaSql .= " FROM parametros WHERE rel_parametro=33; ";

                break;

            case "tipo_cambio_supervisor" :
                $cadenaSql = " SELECT id_parametro, descripcion  ";
                $cadenaSql .= " FROM parametros WHERE rel_parametro=34; ";

                break;

            case "tipo_adicion" :

                $cadenaSql = "SELECT id_parametro  id,pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipo_adicion' and pr.estado_registro = 't' order by pr.descripcion ASC ; ";
                break;

            case "consultarTipoNovedad" :

                $cadenaSql = " SELECT pr.descripcion ";
                $cadenaSql .= " FROM parametros pr ";
                $cadenaSql .= " WHERE pr.id_parametro = $variable ; ";
                break;

            case "vigencias_sica_disponibilidades" :
                $cadenaSql = " SELECT DISTINCT SN.VIGENCIA AS valor, SN.VIGENCIA AS informacion  FROM CO.CO_SOLICITUD_ADQ SN ";
                $cadenaSql .= " ORDER BY SN.VIGENCIA DESC ";

                break;

            case "obtener_solicitudes_vigencia" :
                $cadenaSql = " SELECT DISTINCT SN.NUM_SOL_ADQ as valor , SN.NUM_SOL_ADQ as informacion  ";
                $cadenaSql .= " from CO.CO_SOLICITUD_ADQ SN, PR.PR_DISPONIBILIDADES CDP, ";
                $cadenaSql .= " CO.CO_DEPENDENCIAS DP where SN.NUM_SOL_ADQ =  CDP.NUM_SOL_ADQ ";
                $cadenaSql .= " and SN.DEPENDENCIA = DP.COD_DEPENDENCIA and SN.VIGENCIA= $variable[0]  ";
                $cadenaSql .= " and SN.CODIGO_UNIDAD_EJECUTORA = '0$variable[1]'   ";
                $cadenaSql .= " and SN.ESTADO = 'APROBADA' and CDP.ESTADO = 'VIGENTE' ";
                $cadenaSql .= " ORDER BY SN.NUM_SOL_ADQ ASC ";

                break;

            case "obtener_cdp_numerosol" :
                $cadenaSql = " SELECT DISTINCT CDP.NUMERO_DISPONIBILIDAD as valor , CDP.NUMERO_DISPONIBILIDAD as informacion  ";
                $cadenaSql .= " from CO.CO_SOLICITUD_ADQ SN, PR.PR_DISPONIBILIDADES CDP, ";
                $cadenaSql .= " CO.CO_DEPENDENCIAS DP where SN.NUM_SOL_ADQ =  CDP.NUM_SOL_ADQ ";
                $cadenaSql .= " and SN.DEPENDENCIA = DP.COD_DEPENDENCIA and SN.VIGENCIA= " . $variable [0] . " ";
                $cadenaSql .= " and SN.CODIGO_UNIDAD_EJECUTORA = '0$variable[2]' and SN.NUM_SOL_ADQ = " . $variable [1] . " ";
                $cadenaSql .= " and SN.ESTADO = 'APROBADA' and CDP.ESTADO = 'VIGENTE' ";
                $cadenaSql .= " and CDP.NUMERO_DISPONIBILIDAD NOT IN ($variable[3]) and CDP.NUMERO_DISPONIBILIDAD NOT IN ($variable[4]) ";
                $cadenaSql .= " ORDER BY CDP.NUMERO_DISPONIBILIDAD ";

                break;
            case "obtener_cdp_numerosol_editar" :
                $cadenaSql = " SELECT DISTINCT CDP.NUMERO_DISPONIBILIDAD as valor , CDP.NUMERO_DISPONIBILIDAD as informacion  ";
                $cadenaSql .= " from CO.CO_SOLICITUD_ADQ SN, PR.PR_DISPONIBILIDADES CDP, ";
                $cadenaSql .= " CO.CO_DEPENDENCIAS DP where SN.NUM_SOL_ADQ =  CDP.NUM_SOL_ADQ ";
                $cadenaSql .= " and SN.DEPENDENCIA = DP.COD_DEPENDENCIA and SN.VIGENCIA= " . $variable [0] . " ";
                $cadenaSql .= " and SN.CODIGO_UNIDAD_EJECUTORA = '0$variable[2]' and SN.NUM_SOL_ADQ = " . $variable [1] . " ";
                $cadenaSql .= " and SN.ESTADO = 'APROBADA' and CDP.ESTADO = 'VIGENTE' ";
                $cadenaSql .= " and CDP.NUMERO_DISPONIBILIDAD NOT IN ($variable[3])  ";
                $cadenaSql .= " ORDER BY CDP.NUMERO_DISPONIBILIDAD ";

                break;
            case "info_disponibilidad" :
                $cadenaSql = " SELECT CDP.FECHA_REGISTRO AS FECHA , SN.VALOR_CONTRATACION AS VALOR  ";
                $cadenaSql .= " from CO.CO_SOLICITUD_ADQ SN, PR.PR_DISPONIBILIDADES CDP, ";
                $cadenaSql .= " CO.CO_DEPENDENCIAS DP where SN.NUM_SOL_ADQ =  CDP.NUM_SOL_ADQ ";
                $cadenaSql .= " and SN.DEPENDENCIA = DP.COD_DEPENDENCIA and SN.VIGENCIA= " . $variable [2] . " ";
                $cadenaSql .= " and SN.CODIGO_UNIDAD_EJECUTORA = '0$variable[3]'  and SN.NUM_SOL_ADQ = " . $variable [1] . " and CDP.NUMERO_DISPONIBILIDAD = $variable[0] ";
                $cadenaSql .= " and SN.ESTADO = 'APROBADA' and CDP.ESTADO = 'VIGENTE' ";
                $cadenaSql .= " ORDER BY CDP.NUMERO_DISPONIBILIDAD ";


                break;


            case "cdpRegistradas" :

                $cadenaSql = " select string_agg(cast(numero_cdp as text),',' ";
                $cadenaSql.=" order by numero_cdp) from contrato_general;";

                break;

            case "cdpRegistradasNovedades" :

                $cadenaSql = " select string_agg(cast(numero_cdp as text),',' ";
                $cadenaSql.=" order by numero_cdp) from adicion;";

                break;





            case "consultarOrdenGeneral" :

                $cadenaSql = "SELECT DISTINCT c.id_contrato_normal, p.descripcion, cg.tipo_contrato, c.numero_contrato, c.vigencia, c.fecha_registro, cg.contratista ||'-'|| cg.nombre_contratista as proveedor,"
                        . "  cg.numero_solicitud_necesidad,cg.numero_cdp, ec.nombre_estado, ce.fecha_registro as fecha_registro_estado ";
                $cadenaSql .= "FROM contrato c, parametros p, contrato_general cg,  ";
                $cadenaSql .= "contrato_estado ce, estado_contrato ec  ";
                $cadenaSql .= "WHERE  cg.tipo_contrato = p.id_parametro  ";
                $cadenaSql .= "AND cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id ";
                $cadenaSql .= "AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where c.numero_contrato = cee.numero_contrato and  c.vigencia = cee.vigencia) ";
                $cadenaSql .= "AND c.numero_contrato = cg.numero_contrato ";
                $cadenaSql .= "AND c.vigencia = cg.vigencia ";
                $cadenaSql .= "AND cg.unidad_ejecutora = " . $variable ['unidad_ejecutora'] . " ";
                $cadenaSql .= "AND cg.estado_aprobacion = 't' AND ec.id = 4";
                if ($variable ['tipo_contrato'] != '') {
                    $cadenaSql .= " AND cg.tipo_contrato = '" . $variable ['tipo_contrato'] . "' ";
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

                if ($variable ['sede'] != '') {
                    $cadenaSql .= " AND se.\"ESF_ID_SEDE\" = '" . $variable ['sede'] . "' ";
                }

                if ($variable ['dependencia'] != '') {
                    $cadenaSql .= " AND dep.\"ESF_CODIGO_DEP\" = '" . $variable ['dependencia'] . "' ";
                }
                if ($variable ['fecha_inicial'] != '' && $variable ['fecha_final'] != '') {
                    $cadenaSql .= " AND c.fecha_registro BETWEEN CAST ( '" . $variable ['fecha_inicial'] . "' AS DATE) ";
                    $cadenaSql .= " AND  CAST ( '" . $variable ['fecha_final'] . "' AS DATE)  ";
                }

                $cadenaSql .= " ; ";

                break;


            case "consultarOrdenIdexud" :

                $cadenaSql = "SELECT DISTINCT c.id_contrato_normal, p.descripcion,cg.tipo_contrato, c.numero_contrato, c.vigencia, c.fecha_registro, cg.contratista ||'-'|| cg.nombre_contratista as proveedor,"
                        . " 'IDEXUD'||'-'||conv.\"NOMBRE\" as SedeDependencia , cg.numero_solicitud_necesidad,cg.numero_cdp, ec.nombre_estado, ce.fecha_registro as fecha_registro_estado ";
                $cadenaSql .= "FROM orden o, parametros p,  contrato_general cg, convenio conv, ";
                $cadenaSql .= "contrato_estado ce, estado_contrato ec  ";
                $cadenaSql .= "WHERE cg.tipo_contrato = p.id_parametro ";
                $cadenaSql .= "AND conv.\"NUMERO_PRO\"  = cg.convenio_solicitante ";
                $cadenaSql .= "AND cg.numero_contrato = ce.numero_contrato and cg.vigencia = ce.vigencia and ce.estado = ec.id ";
                $cadenaSql .= "AND ce.fecha_registro = (SELECT MAX(cee.fecha_registro) from contrato_estado cee where o.numero_contrato = cee.numero_contrato and  o.vigencia = cee.vigencia) ";
                $cadenaSql .= "AND c.numero_contrato = cg.numero_contrato ";
                $cadenaSql .= "AND c.vigencia = cg.vigencia ";
                $cadenaSql .= "AND cg.unidad_ejecutora = '" . $variable ['unidad_ejecutora'] . "' ";
                $cadenaSql .= "AND c.estado_registro = 'true' AND cg.estado_aprobacion = 't' AND ec.id = 4 ";
                if ($variable ['tipo_orden'] != '') {
                    $cadenaSql .= " AND cg.tipo_contrato = '" . $variable ['tipo_orden'] . "' ";
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

                if ($variable ['dependencia'] != '') {
                    $cadenaSql .= " AND conv.\"NUMERO_PRO\" = '" . $variable ['dependencia'] . "' ";
                }
                if ($variable ['fecha_inicial'] != '' && $variable ['fecha_final'] != '') {
                    $cadenaSql .= " AND c.fecha_registro BETWEEN CAST ( '" . $variable ['fecha_inicial'] . "' AS DATE) ";
                    $cadenaSql .= " AND  CAST ( '" . $variable ['fecha_final'] . "' AS DATE)  ";
                }
                $cadenaSql .= " ; ";

                break;

            case "obtenerInfoUsuario" :
                $cadenaSql = "SELECT u.dependencia_especifica ||' - '|| u.dependencia as nombre, unidad_ejecutora ";
                $cadenaSql .= "FROM frame_work.argo_usuario u  ";
                $cadenaSql .= "WHERE u.id_usuario='" . $variable . "' ";
                break;




            case "funcionarios" :

                $cadenaSql = " SELECT  FUN_IDENTIFICACION , FUN_IDENTIFICACION ";
                $cadenaSql .= " ||' '|| FUN_NOMBRE  FROM SICAARKA.FUNCIONARIOS  WHERE FUN_ESTADO='A' ";

                break;
            case "consultaSupervisor" :

                $cadenaSql = " SELECT  FUN_IDENTIFICACION ";
                $cadenaSql .= " ||' -- '|| FUN_NOMBRE  FROM SICAARKA.FUNCIONARIOS  WHERE FUN_IDENTIFICACION = $variable ";

                break;


            case "ConsultarInformacionOrden" :
                $cadenaSql = "SELECT DISTINCT ";
                $cadenaSql .= "cg.numero_contrato,cg.vigencia, ";
                $cadenaSql .= "cg.tipo_contrato,cg.unidad_ejecutora, ";
                $cadenaSql .= "cg.fecha_final,cg.plazo_ejecucion, ";
                $cadenaSql .= "cg.objeto_contrato,cg.fecha_inicio, ";
                $cadenaSql .= "cg.forma_pago,cg.ordenador_gasto, ";
                $cadenaSql .= "cg.supervisor,cg.clausula_registro_presupuestal, ";
                $cadenaSql .= "cg.sede_supervisor,cg.dependencia_supervisor,cg.cargo_supervisor, ";
                $cadenaSql .= "cg.sede_solicitante,cg.dependencia_solicitante, ";
                $cadenaSql .= "cg.contratista,o.tipo_orden,o.id_orden, cg.unidad_ejecucion ";
                $cadenaSql .= "FROM ";
                $cadenaSql .= "contractual.contrato_general cg, contractual.orden o, ";
                $cadenaSql .= "\"SICapital\".\"funcionario\" f ";
                $cadenaSql .= "WHERE ";
                $cadenaSql .= "cg.numero_contrato=o.numero_contrato and  ";
                $cadenaSql .= "cg.vigencia=o.vigencia and ";
                $cadenaSql .= "cg.numero_contrato ='" . $variable['numerocontrato'] . "' and ";
                $cadenaSql .= "cg.vigencia =" . $variable['vigencia'] . "; ";

                break;



            case "informacion_ordenador" :
                $cadenaSql = " 	SELECT  \"ORG_NOMBRE\",  \"ORG_IDENTIFICACION\",  \"ORG_IDENTIFICADOR\"  ";
                $cadenaSql .= " FROM argo_ordenadores ";
                $cadenaSql .= " WHERE \"ORG_ESTADO\" = 'A' and  \"ORG_IDENTIFICADOR_UNICO\" = '$variable';";

                break;



            case "ConsultarDescripcionParametro" :
                $cadenaSql = "SELECT descripcion ";
                $cadenaSql .= " FROM parametros ";
                $cadenaSql .= " WHERE id_parametro=" . $variable;

                break;

            case "registroNovedadContractual" :
                $cadenaSql = " INSERT INTO novedad_contractual( ";
                $cadenaSql .= " tipo_novedad, numero_contrato, vigencia, fecha_registro,";
                $cadenaSql .= "  usuario, acto_administrativo, documento, descripcion ) ";
                $cadenaSql .= " VALUES ($variable[0], '$variable[1]', $variable[2], '$variable[3]',";
                $cadenaSql .= " '$variable[4]', '$variable[5]', '$variable[6]', '$variable[7]');";

                break;

            case "registroNovedadAdicionPresupuesto" :
                $cadenaSql = " INSERT INTO adicion( ";
                $cadenaSql .= " id, tipo_adicion, numero_solicitud, numero_cdp, valor_presupuesto) ";
                $cadenaSql .= " VALUES ( ";
                $cadenaSql .= " $variable[0],";
                $cadenaSql .= " $variable[1],";
                $cadenaSql .= " $variable[2],";
                $cadenaSql .= " $variable[3],";
                $cadenaSql .= " $variable[4]";
                $cadenaSql .= " ); ";

                break;

            case "registroNovedadAdicionTiempo" :
                $cadenaSql = " INSERT INTO adicion( ";
                $cadenaSql .= " id, tipo_adicion, unidad_tiempo_ejecucion, valor_tiempo) ";
                $cadenaSql .= " VALUES ( ";
                $cadenaSql .= " $variable[0],";
                $cadenaSql .= " $variable[1],";
                $cadenaSql .= " $variable[2],";
                $cadenaSql .= " $variable[3]";
                $cadenaSql .= " ); ";

                break;

            case "registroNovedadAnulacion" :
                $cadenaSql = " INSERT INTO anulacion( ";
                $cadenaSql .= " id, tipo_anulacion ) ";
                $cadenaSql .= " VALUES ( ";
                $cadenaSql .= " $variable[0],";
                $cadenaSql .= " $variable[1]";
                $cadenaSql .= " ); ";

                break;

            case "registroNovedadCambioSupervisor" :
                $cadenaSql = " INSERT INTO cambio_supervisor( ";
                $cadenaSql .= " id, tipo_cambio,supervisor_antiguo,supervisor_nuevo,fecha_cambio) ";
                $cadenaSql .= " VALUES ( ";
                $cadenaSql .= " $variable[0],";
                $cadenaSql .= " $variable[1],";
                $cadenaSql .= " '$variable[2]',";
                $cadenaSql .= " '$variable[3]',";
                $cadenaSql .= " '$variable[4]'";
                $cadenaSql .= " ); ";

                break;

            case "registroNovedadCesion" :
                $cadenaSql = " INSERT INTO cesion( ";
                $cadenaSql .= " id,nuevo_contratista,antiguo_contratista,fecha_cesion) ";
                $cadenaSql .= " VALUES ( ";
                $cadenaSql .= " $variable[0],";
                $cadenaSql .= " $variable[1],";
                $cadenaSql .= " $variable[2],";
                $cadenaSql .= " '$variable[3]'";
                $cadenaSql .= " ); ";

                break;

            case "registroNovedadSuspension" :
                $cadenaSql = " INSERT INTO suspension( ";
                $cadenaSql .= " id,fecha_inicio ,fecha_fin) ";
                $cadenaSql .= " VALUES ( ";
                $cadenaSql .= " $variable[0],";
                $cadenaSql .= " '$variable[1]',";
                $cadenaSql .= " '$variable[2]'";
                $cadenaSql .= " ); ";

                break;
            case "actualizarSupervisor" :
                $cadenaSql = "  UPDATE contrato_general ";
                $cadenaSql .= " SET ";
                $cadenaSql .= " supervisor = $variable[0] ";
                $cadenaSql .= " WHERE numero_contrato = '$variable[1]' and vigencia = $variable[2]; ";
                break;

            case "actualizarContratista" :
                $cadenaSql = "  UPDATE contrato_general ";
                $cadenaSql .= " SET ";
                $cadenaSql .= " contratista = $variable[0] , ";
                $cadenaSql .= " nombre_contratista = '$variable[1]' ";
                $cadenaSql .= " WHERE numero_contrato = '$variable[2]' and vigencia = $variable[3];";
                break;

            case "acumuladoAdiciones" :
                $cadenaSql = "  SELECT SUM(valor_presupuesto) as acumulado  ";
                $cadenaSql .= " FROM adicion a , novedad_contractual nc  ";
                $cadenaSql .= " WHERE a.id = nc.id AND numero_contrato = '$variable[0]' AND vigencia = $variable[1];";
                break;



            case "consultarAdcionesPresupuesto" :
                $cadenaSql = "  SELECT nc.*, a.numero_solicitud, a.numero_cdp, a.valor_presupuesto, a.tipo_adicion ";
                $cadenaSql .= " FROM adicion a , novedad_contractual nc    ";
                $cadenaSql .= " WHERE a.id = nc.id AND numero_contrato = '$variable[0]' AND vigencia = $variable[1] ";
                $cadenaSql .= " AND tipo_adicion = 248;";
                break;


            case "consultarAdcionesTiempo" :
                $cadenaSql = "  SELECT nc.*, pr.descripcion as unidad_tiempo_ejecucion, a.valor_tiempo, a.tipo_adicion  ";
                $cadenaSql .= " FROM adicion a , novedad_contractual nc, parametros pr    ";
                $cadenaSql .= " WHERE a.id = nc.id AND a.unidad_tiempo_ejecucion = pr.id_parametro ";
                $cadenaSql .= " AND tipo_adicion = 249 AND numero_contrato = '$variable[0]' AND vigencia = $variable[1] ;";
                break;

            case "consultarAnulaciones" :
                $cadenaSql = "  SELECT nc.*, pr.descripcion as parametro_anulacion  ";
                $cadenaSql .= " FROM anulacion n , novedad_contractual nc, parametros pr    ";
                $cadenaSql .= " WHERE n.id = nc.id AND numero_contrato = '$variable[0]' AND vigencia = $variable[1] ";
                $cadenaSql .= " AND pr.id_parametro= n.tipo_anulacion;";
                break;

            case "consultarSuspensiones" :
                $cadenaSql = "  SELECT nc.*, s.fecha_inicio, s.fecha_fin ";
                $cadenaSql .= " FROM suspension s , novedad_contractual nc   ";
                $cadenaSql .= " WHERE s.id = nc.id AND numero_contrato = '$variable[0]' AND vigencia = $variable[1]; ";
                break;

            case "consultaCesiones" :
                $cadenaSql = "  SELECT nc.*, c.nuevo_contratista, c.antiguo_contratista, c.fecha_cesion  ";
                $cadenaSql .= " FROM cesion c , novedad_contractual nc   ";
                $cadenaSql .= " WHERE c.id = nc.id AND numero_contrato = '$variable[0]' AND vigencia = $variable[1]; ";
                break;

            case "ConsultacambioSupervisor" :
                $cadenaSql = "  SELECT nc.*, cs.supervisor_antiguo, cs.supervisor_nuevo, cs.fecha_cambio, pr.descripcion as tipoCambio_parametro ";
                $cadenaSql .= " FROM cambio_supervisor cs , novedad_contractual nc, parametros pr   ";
                $cadenaSql .= " WHERE cs.id = nc.id AND numero_contrato = '$variable[0]' AND vigencia = $variable[1] ";
                $cadenaSql .= " AND cs.tipo_cambio = pr.id_parametro;";
                break;

            case "ConsultaOtras" :
                $cadenaSql = "  SELECT nc.numero_contrato,nc.vigencia,nc.estado,nc.fecha_registro,nc.usuario,nc.acto_administrativo, ";
                $cadenaSql .= "  nc.documento, nc.descripcion, pr.descripcion as parametro_descripcion, nc.id, nc.tipo_novedad ";
                $cadenaSql .= " FROM novedad_contractual nc, parametros pr  ";
                $cadenaSql .= " WHERE numero_contrato = '$variable[0]' AND vigencia = $variable[1] AND pr.id_parametro = nc.tipo_novedad ";
                $cadenaSql .= " AND ( nc.tipo_novedad = 217 or nc.tipo_novedad = 218 ) ; ";
                break;

            case "consultarAdcionPresupuesto" :
                $cadenaSql = "  SELECT nc.*, a.numero_solicitud, a.numero_cdp, a.valor_presupuesto, a.tipo_adicion ";
                $cadenaSql .= " FROM adicion a , novedad_contractual nc    ";
                $cadenaSql .= " WHERE a.id = nc.id AND nc.id = $variable; ";

                break;


            case "consultarAdcionTiempo" :
                $cadenaSql = "  SELECT nc.*, a.valor_tiempo, a.tipo_adicion, a.unidad_tiempo_ejecucion  ";
                $cadenaSql .= " FROM adicion a , novedad_contractual nc ";
                $cadenaSql .= " WHERE a.id = nc.id  ";
                $cadenaSql .= " AND  nc.id = $variable;";
                break;

            case "consultarAnulacion" :
                $cadenaSql = "  SELECT nc.*, pr.descripcion as parametro_anulacion, n.tipo_anulacion  ";
                $cadenaSql .= " FROM anulacion n , novedad_contractual nc, parametros pr    ";
                $cadenaSql .= " WHERE n.id = nc.id AND nc.id = $variable  ";
                $cadenaSql .= " AND pr.id_parametro= n.tipo_anulacion;";
                break;

            case "consultarSuspension" :
                $cadenaSql = "  SELECT nc.*, s.fecha_inicio, s.fecha_fin ";
                $cadenaSql .= " FROM suspension s , novedad_contractual nc   ";
                $cadenaSql .= " WHERE s.id = nc.id AND nc.id = $variable; ";
                break;

            case "consultaCesion" :
                $cadenaSql = "  SELECT nc.*, c.nuevo_contratista, c.antiguo_contratista, c.fecha_cesion  ";
                $cadenaSql .= " FROM cesion c , novedad_contractual nc   ";
                $cadenaSql .= " WHERE c.id = nc.id AND nc.id = $variable; ";
                break;

            case "ConsultarcambioSupervisorPaticular" :
                $cadenaSql = "  SELECT nc.*, cs.supervisor_antiguo, cs.supervisor_nuevo, cs.fecha_cambio,cs.tipo_cambio  ";
                $cadenaSql .= " FROM cambio_supervisor cs , novedad_contractual nc   ";
                $cadenaSql .= " WHERE cs.id = nc.id AND nc.id = $variable; ";
                break;

            case "ConsultaOtra" :
                $cadenaSql = "  SELECT nc.numero_contrato,nc.vigencia,nc.estado,nc.fecha_registro,nc.usuario,nc.acto_administrativo, ";
                $cadenaSql .= "  nc.documento, nc.descripcion, pr.descripcion as parametro_descripcion, nc.id, nc.tipo_novedad ";
                $cadenaSql .= " FROM novedad_contractual nc, parametros pr  ";
                $cadenaSql .= " WHERE nc.id = $variable AND pr.id_parametro = nc.tipo_novedad;";
                break;

            case "ConsultaSupervisorNovedad" :
                $cadenaSql = "   SELECT FUN_IDENTIFICACION ||' - '|| FUN_NOMBRE ";
                $cadenaSql .= "  FROM SICAARKA.FUNCIONARIOS WHERE FUN_IDENTIFICACION = $variable ";
                break;


            case "updateNovedadContractualconArchivo" :
                $cadenaSql = " UPDATE novedad_contractual";
                $cadenaSql.=" SET acto_administrativo= '$variable[5]', documento='$variable[6]', ";
                $cadenaSql.=" descripcion='$variable[7]'";
                $cadenaSql.=" WHERE id=$variable[0];";
                break;

            case "updateNovedadContractualsinArchivo" :
                $cadenaSql = " UPDATE novedad_contractual";
                $cadenaSql.=" SET acto_administrativo= '$variable[5]', ";
                $cadenaSql.=" descripcion='$variable[7]'";
                $cadenaSql.=" WHERE id=$variable[0];";
                break;

            case "updateNovedadAdicionPresupuesto" :
                $cadenaSql = " UPDATE adicion ";
                $cadenaSql.=" SET  numero_solicitud=$variable[2], ";
                $cadenaSql.=" numero_cdp=$variable[3], valor_presupuesto=$variable[4] ";
                $cadenaSql.=" WHERE id= $variable[0];";
                break;
            case "updateNovedadAdicionTiempo" :
                $cadenaSql = " UPDATE adicion ";
                $cadenaSql.=" SET  unidad_tiempo_ejecucion=$variable[2], ";
                $cadenaSql.=" valor_tiempo=$variable[3] ";
                $cadenaSql.=" WHERE id= $variable[0];";
                break;

            case "updateNovedadAnulacion" :
                $cadenaSql = " UPDATE anulacion ";
                $cadenaSql.=" SET  tipo_anulacion=$variable[1] ";
                $cadenaSql.=" WHERE id= $variable[0];";
                break;

            case "updateNovedadCambioSupervisor" :
                $cadenaSql = " UPDATE cambio_supervisor";
                $cadenaSql.=" SET  tipo_cambio=$variable[1], supervisor_antiguo='$variable[2]', ";
                $cadenaSql.=" supervisor_nuevo='$variable[3]', fecha_cambio='$variable[4]'";
                $cadenaSql.=" WHERE id=$variable[0] ;";
                break;

            case "updateNovedadCesion" :
                $cadenaSql = " UPDATE cesion";
                $cadenaSql.=" SET  nuevo_contratista=$variable[1],";
                $cadenaSql.=" antiguo_contratista=$variable[2], fecha_cesion='$variable[3]'";
                $cadenaSql.=" WHERE id=$variable[0];";
                break;

            case "updateNovedadSuspension" :
                $cadenaSql = " UPDATE suspension";
                $cadenaSql.=" SET fecha_inicio='$variable[1]', fecha_fin='$variable[2]'";
                $cadenaSql.=" WHERE id=$variable[0];";
                break;





//------------------------------------------------SQLs SIN DDEFINIR USO-----------------------------------------------------------------------------------
            case "sedeConsulta" :
                $cadenaSql = "SELECT DISTINCT  ESF_ID_SEDE  ";
                $cadenaSql .= " FROM ESPACIOS_FISICOS ";
                $cadenaSql .= " WHERE   ESF_ESTADO='A'";
                $cadenaSql .= " AND  ESF_ID_ESPACIO='" . $variable . "' ";
                break;



            case "consultarConvenioDocumento" :
                $cadenaSql = "SELECT \"NOMBRE\" FROM contractual.convenio WHERE \"NUMERO_PRO\" = '$variable';";

                break;

            case "consultarSede" :
                $cadenaSql = " SELECT \"ESF_SEDE\" FROM  \"SICapital\".\"sedes_SIC\" ";
                $cadenaSql .= " WHERE \"ESF_ID_SEDE\" = '$variable';  ";
                break;


            case "consultarDependencia" :
                $cadenaSql = " SELECT \"ESF_DEP_ENCARGADA\" FROM  \"SICapital\".\"dependencia_SIC\" ";
                $cadenaSql .= " WHERE \"ESF_CODIGO_DEP\" = '$variable';  ";
                break;



            case "consultarDependenciaSupervisor" :
                $cadenaSql = " SELECT   ESF_ID_ESPACIO, ESF_NOMBRE_ESPACIO ";
                $cadenaSql .= "FROM ESPACIOS_FISICOS  ";
                $cadenaSql .= " WHERE ESF_ID_ESPACIO='" . $variable . "' ";
                $cadenaSql .= " AND  ESF_ESTADO='A'";
                break;

            case "consultarSolicitante" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= "dependencia, rubro ";
                $cadenaSql .= " FROM solicitante_servicios ";
                $cadenaSql .= " WHERE id_solicitante='" . $variable . "'";

                break;
        }
        return $cadenaSql;
    }

}

?>
