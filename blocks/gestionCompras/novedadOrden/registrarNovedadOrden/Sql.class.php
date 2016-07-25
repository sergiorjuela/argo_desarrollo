<?php

namespace gestionCompras\novedadOrden\registrarNovedadOrden;

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
                $cadenaSql .= " rel_parametro=30;  ";

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

                $cadenaSql = " 	SELECT 	o.numero_contrato ||'-'|| o.vigencia as value, o.numero_contrato ||'-'||o.vigencia as orden ";
                $cadenaSql .= " FROM orden o, contrato_general cg ";
                $cadenaSql .= " WHERE o.numero_contrato = cg.numero_contrato and o.vigencia = cg.vigencia and  cg.unidad_ejecutora ='" . $variable['unidad'] . "' ";
                $cadenaSql .= " and tipo_orden ='" . $variable['tipo_orden'] . "' and cg.estado_aprobacion = 'f' ;";

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
                $cadenaSql .= " dependencia.\"ESF_DEP_ENCARGADA\" FROM ";
                $cadenaSql .= " contractual.contrato_general cg, contractual.parametros pr, \"SICapital\".\"sedes_SIC\" sede, ";
                $cadenaSql .= " \"SICapital\".\"dependencia_SIC\" dependencia ";
                $cadenaSql .= " WHERE cg.unidad_ejecutora = CAST(pr.id_parametro as text) and ";
                $cadenaSql .= " sede.\"ESF_ID_SEDE\" = cg.sede_solicitante  and ";
                $cadenaSql .= " dependencia.\"ESF_CODIGO_DEP\" = cg.dependencia_solicitante  and ";
                $cadenaSql .= " cg.numero_contrato=" . $variable['numero_contrato'] . " and ";
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
                $cadenaSql .= " and CDP.NUMERO_DISPONIBILIDAD NOT IN ($variable[3]) ";
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





            case "consultarOrdenGeneral" :

                $cadenaSql = "SELECT DISTINCT o.id_orden, p.descripcion, o.numero_contrato, o.vigencia, o.fecha_registro, cg.contratista ||'-'|| cg.nombre_contratista as proveedor,"
                        . " se.\"ESF_SEDE\" ||'-'|| dep.\"ESF_DEP_ENCARGADA\" as SedeDependencia, cg.numero_solicitud_necesidad,cg.numero_cdp ";
                $cadenaSql .= "FROM orden o, parametros p, contrato_general cg, \"SICapital\".\"sedes_SIC\" se, \"SICapital\".\"dependencia_SIC\" dep ";
                $cadenaSql .= "WHERE o.tipo_orden = p.id_parametro ";
                $cadenaSql .= "AND se.\"ESF_ID_SEDE\" = cg.sede_solicitante ";
                $cadenaSql .= "AND dep.\"ESF_CODIGO_DEP\" = cg.dependencia_solicitante ";
                $cadenaSql .= "AND o.numero_contrato = cg.numero_contrato ";
                $cadenaSql .= "AND o.vigencia = cg.vigencia ";
                $cadenaSql .= "AND cg.unidad_ejecutora = '" . $variable ['unidad_ejecutora'] . "' ";
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
                        . " 'IDEXUD'||'-'||conv.\"NOMBRE\" as SedeDependencia , cg.numero_solicitud_necesidad,cg.numero_cdp  ";
                $cadenaSql .= "FROM orden o, parametros p,  contrato_general cg, convenio conv ";
                $cadenaSql .= "WHERE o.tipo_orden = p.id_parametro ";
                $cadenaSql .= "AND conv.\"NUMERO_PRO\"  = cg.dependencia_solicitante ";
                $cadenaSql .= "AND o.numero_contrato = cg.numero_contrato ";
                $cadenaSql .= "AND o.vigencia = cg.vigencia ";
                $cadenaSql .= "AND cg.unidad_ejecutora = '" . $variable ['unidad_ejecutora'] . "' ";
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







            case "obtenerInfoUsuario" :
                $cadenaSql = "SELECT u.dependencia_especifica ||' - '|| u.dependencia as nombre, unidad_ejecutora ";
                $cadenaSql .= "FROM frame_work.argo_usuario u  ";
                $cadenaSql .= "WHERE u.id_usuario='" . $variable . "' ";
                break;




            case "funcionarios" :

                $cadenaSql = " SELECT  FUN_IDENTIFICACION , FUN_IDENTIFICACION ";
                $cadenaSql .= " ||' '|| FUN_NOMBRE  FROM SICAARKA.FUNCIONARIOS  WHERE FUN_ESTADO='A' ";

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
                $cadenaSql .= "cg.numero_contrato =" . $variable['numerocontrato'] . " and ";
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
