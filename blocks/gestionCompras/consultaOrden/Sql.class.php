<?php

namespace gestionCompras\consultaOrden;

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
                $cadenaSql .= " AND  ad.\"ESF_ESTADO\"='A';";
                break;

            case "dependenciasElemetos" :
                $cadenaSql = "SELECT DISTINCT  \"ESF_CODIGO_DEP\" , \"ESF_DEP_ENCARGADA\" ";
                $cadenaSql .= " FROM \"SICapital\".\"dependencia_SIC\" ";
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

            case "polizas" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " id_poliza,";
                $cadenaSql .= " nombre_de_la_poliza, ";
                $cadenaSql .= " descripcion_poliza ";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " poliza; ";
                break;


            case "cambioEstadoAprobarContrato" :
                $cadenaSql = " INSERT INTO contrato_estado(";
                $cadenaSql .= " numero_contrato, vigencia,fecha_registro,usuario,estado ) ";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'".$variable ['numero_contrato'] . "',";
                $cadenaSql .= $variable ['vigencia'] . ",";
                $cadenaSql .= "'" . $variable ['fecha_aprobacion'] . "',";
                $cadenaSql .= "'" . $variable ['usuario'] . "',";
                $cadenaSql .= $variable ['estado'] . ");";

                break;
            
        

            case "polizasDocumento" :
                $cadenaSql = " SELECT p.descripcion_poliza, p.id_poliza, op.fecha_inicio, op.fecha_final FROM poliza p , orden o, orden_poliza op ";
                $cadenaSql .= " WHERE o.id_orden = op.orden and op.poliza = p.id_poliza and op.orden=$variable; ";
                break;

            case "ordenadorDocumento" :

                $cadenaSql = " 	SELECT \"ORG_ORDENADOR_GASTO\" as ordenador , \"ORG_NOMBRE\" as nombre , \"ORG_IDENTIFICACION\" as identificacion  ";
                $cadenaSql .= " FROM argo_ordenadores ";
                $cadenaSql .= " WHERE \"ORG_IDENTIFICACION\" =$variable;";

                break;

            case "textos" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " id_parametro, ";
                $cadenaSql .= " descripcion ";
                $cadenaSql .= " FROM";
                $cadenaSql .= " parametros ";
                $cadenaSql .= " WHERE ";
                $cadenaSql .= " estado_registro=TRUE ";
                $cadenaSql .= " AND ";
                $cadenaSql .= " rel_parametro=29;  ";
                break;
            
            case "consultarServiciosOrden" :
                $cadenaSql = " SELECT so.*, sbc.nombre as nombre_tipo_servicio 	";
                $cadenaSql .= " FROM servicio_orden so, agora.ciiu_subclase sbc  ";
                $cadenaSql .= " WHERE so.codigo_ciiu = sbc.id_subclase ";
                $cadenaSql .= " AND so.numero_contrato='$variable[0]' ";
                $cadenaSql .= " AND so.vigencia=$variable[1]; ";
           
                break;

            case "obtenerInfoUsuario" :
                $cadenaSql = "SELECT u.dependencia_especifica ||' - '|| u.dependencia as nombre, unidad_ejecutora ";
                $cadenaSql .= "FROM frame_work.argo_usuario u  ";
                $cadenaSql .= "WHERE u.id_usuario='" . $variable . "' ";
                break;

            case "forma_pago" :
                $cadenaSql = " 	SELECT id_parametro, descripcion ";
                $cadenaSql .= " FROM  parametros ";
                $cadenaSql .= " WHERE rel_parametro=28 and id_parametro = 240 ;";

                break;
            case "tipoComprador" :

                $cadenaSql = " 	SELECT f.\"identificacion\",p.descripcion ";
                $cadenaSql .= " FROM \"SICapital\".\"funcionario\" f ,\"SICapital\".\"funcionario_tipo_ordenador\"  o, parametros p ";
                $cadenaSql .= " WHERE o.\"estado\"=True and f.\"identificacion\"= o.\"funcionario\" and p.id_parametro= o.\"tipo_ordenador\" ";
                $cadenaSql .= " and p.id_parametro <> 202 ;";

                break;
            case "ordenadores_orden" :

                $cadenaSql = " 	select \"ORG_IDENTIFICADOR_UNICO\", \"ORG_ORDENADOR_GASTO\"   from argo_ordenadores ";
                $cadenaSql .= " where \"ORG_ESTADO\" = 'A' and \"ORG_ORDENADOR_GASTO\" <> 'DIRECTOR IDEXUD'; ";

                break;
            case "ordenadores_orden_idexud" :

                $cadenaSql = " 	select \"ORG_IDENTIFICADOR_UNICO\", \"ORG_ORDENADOR_GASTO\"   from argo_ordenadores ";
                $cadenaSql .= " where \"ORG_ESTADO\" = 'A' and \"ORG_ORDENADOR_GASTO\" = 'DIRECTOR IDEXUD'; ";

                break;



            case "tipoComprador_idexud" :

                $cadenaSql = " 	SELECT f.\"identificacion\",p.descripcion ";
                $cadenaSql .= " FROM \"SICapital\".\"funcionario\" f ,\"SICapital\".\"funcionario_tipo_ordenador\"  o, parametros p ";
                $cadenaSql .= " WHERE o.\"estado\"=True and f.\"identificacion\"= o.\"funcionario\" and p.id_parametro= o.\"tipo_ordenador\" ";
                $cadenaSql .= " and p.id_parametro = 202 ;";

                break;


            case "funcionarios" :

                $cadenaSql = " SELECT  FUN_IDENTIFICACION , FUN_IDENTIFICACION ";
                $cadenaSql .= " ||' '|| FUN_NOMBRE  FROM SICAARKA.FUNCIONARIOS  WHERE FUN_ESTADO='A' ";

                break;



            case "obtenerCargoSuper" :

                $cadenaSql = " SELECT  FUN_CARGO ";
                $cadenaSql .= " FROM SICAARKA.FUNCIONARIOS ";
                $cadenaSql .= " WHERE FUN_IDENTIFICACION = $variable ";

                break;

            case "cargos_existentes" :
                $cadenaSql = " SELECT  DISTINCT FUN_CARGO";
                $cadenaSql .= " FROM SICAARKA.FUNCIONARIOS ORDER BY FUN_CARGO ASC";
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
                $cadenaSql .= "cg.contratista,cg.valor_contrato,o.tipo_orden,o.id_orden, cg.unidad_ejecucion ";
                $cadenaSql .= "FROM ";
                $cadenaSql .= "contractual.contrato_general cg, contractual.orden o ";
                $cadenaSql .= "WHERE ";
                $cadenaSql .= "cg.numero_contrato=o.numero_contrato and  ";
                $cadenaSql .= "cg.vigencia=o.vigencia and ";
                $cadenaSql .= "cg.numero_contrato ='" . $variable['numerocontrato'] . "' and ";
                $cadenaSql .= "cg.vigencia =" . $variable['vigencia'] . "; ";

                break;

            case "tipo_unidad_ejecucion" :
                $cadenaSql = " SELECT id_parametro, descripcion  ";
                $cadenaSql .= " FROM parametros WHERE rel_parametro=21; ";

                break;



            case "informacion_ordenador" :
                $cadenaSql = " 	SELECT  \"ORG_NOMBRE\",  \"ORG_IDENTIFICACION\",  \"ORG_IDENTIFICADOR\"  ";
                $cadenaSql .= " FROM argo_ordenadores ";
                $cadenaSql .= " WHERE \"ORG_ESTADO\" = 'A' and  \"ORG_IDENTIFICADOR_UNICO\" = '$variable';";

                break;


            case "obtenerPolizarOrden" :
                $cadenaSql = " 	SELECT poliza, fecha_inicio, fecha_final ";
                $cadenaSql .= " FROM orden_poliza ";
                $cadenaSql .= " WHERE orden=" . $variable;

                break;

            case "ConsultarDescripcionParametro" :
                $cadenaSql = "SELECT descripcion ";
                $cadenaSql .= " FROM parametros ";
                $cadenaSql .= " WHERE id_parametro=" . $variable;

                break;
            case "insertarContratista" :
                $cadenaSql = " INSERT INTO contratista(";
                $cadenaSql .= " nombre_razon_social,direccion, telefono,digito_verificacion, ";
                $cadenaSql .= " correo,identificacion,tipo_naturaleza,tipo_documento,fecha_registro,nacionalidad, ";
                $cadenaSql .= " nombre_contratista,identificacion_contratista_representante,sitio_web,nombre_acesor, ";
                $cadenaSql .= " ubicacion,procedencia_contratista,cargo_contratista_representante) ";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'" . $variable ['razonSocial'] . "',";
                $cadenaSql .= "'" . $variable ['direcccion'] . "',";
                $cadenaSql .= $variable ['telefono'] . ",";
                $cadenaSql .= $variable ['digito_verificacion'] . ",";
                $cadenaSql .= "'" . $variable ['correo'] . "',";
                $cadenaSql .= "'" . $variable ['nit'] . "',";
                $cadenaSql .= $variable ['tipo_persona'] . ",";
                $cadenaSql .= $variable ['tipo_documento'] . ",";
                $cadenaSql .= "'" . $variable ['fecha'] . "',";
                $cadenaSql .= "'" . $variable ['nacionalidad'] . "',";
                $cadenaSql .= "'" . $variable ['nombreRepresentante'] . "',";
                $cadenaSql .= "'" . $variable ['identificacionRepresentante'] . "',";
                $cadenaSql .= "'" . $variable ['sitio_web'] . "',";
                $cadenaSql .= "'" . $variable ['nombre_acesor'] . "',";
                $cadenaSql .= "'" . $variable ['ubicacion_proveedor'] . "',";
                $cadenaSql .= "'" . $variable ['procedencia'] . "',";
                $cadenaSql .= "'" . $variable ['cargo_contratista'] . "');";

                break;
            case "validarContratista" :
                $cadenaSql = "SELECT * From contratista WHERE identificacion=" . $variable;
                ;

                break;

            case "modificarContratista" :
                $cadenaSql = " UPDATE contratista ";
                $cadenaSql .= " SET ";
                $cadenaSql .= " cargo_contratista_representante = '" . $variable['cargo'] . "' ";
                $cadenaSql .= " WHERE identificacion=" . $variable['id'] . ";";

                break;

            case "updateOrden" :
                $cadenaSql = " UPDATE orden ";
                $cadenaSql .= " SET ";
                $cadenaSql .= " tipo_orden = " . $variable['tipo_orden'] . " ";
                $cadenaSql .= " WHERE id_orden=" . $variable['id_orden'] . ";";

                break;

            case "updateContratoGeneral":

                if ($variable['unidad_ejecutura'] == 209) {
                    $campo = " dependencia_solicitante ";
                } else {
                    $campo = " convenio_solicitante ";
                }

                $cadenaSql = "UPDATE contrato_general SET ";
                $cadenaSql .= "objeto_contrato='" . $variable['objeto_contrato'] . "', ";
                $cadenaSql .= "fecha_inicio= " . $variable['fecha_inicio'] . ", ";
                $cadenaSql .= "fecha_final= " . $variable['fecha_fin'] . ", ";
                $cadenaSql .= "plazo_ejecucion= " . $variable['plazo_ejecucion'] . ", ";
                $cadenaSql .= "forma_pago=" . $variable['forma_pago'] . ", ";
                $cadenaSql .= "ordenador_gasto= '" . $variable['ordenador_gasto'] . "', ";
                $cadenaSql .= "supervisor= '" . $variable['supervisor'] . "', ";
                $cadenaSql .= "clausula_registro_presupuestal= " . $variable['clausula_presupuesto'] . ", ";
                $cadenaSql .= "sede_supervisor= '" . $variable['sede_supervisor'] . "', ";
                $cadenaSql .= "dependencia_supervisor= '" . $variable['dependencia_supervisor'] . "', ";
                $cadenaSql .= "sede_solicitante= '" . $variable['sede_solicitante'] . "', ";
                $cadenaSql .= " contratista = " . $variable['proveedor'] . ", ";
                $cadenaSql .= " valor_contrato = " . $variable['valor_contrato'] . ", ";
                $cadenaSql .= " nombre_contratista = '" . $variable['nombre_proveedor'] . "', ";
                $cadenaSql .= " $campo = '" . $variable['dependencia_solicitante'] . "', ";
                $cadenaSql .= "cargo_supervisor= '" . $variable['cargo_supervisor'] . "', ";
                $cadenaSql .= " unidad_ejecucion = " . $variable['unidad_ejecucion'] . " ";
                $cadenaSql .= "WHERE numero_contrato='" . $variable['numero_contrato'] . "' and ";
                $cadenaSql .= "vigencia=" . $variable['vigencia'] . "; ";

                break;

            case "elimnarPolizas":
                $cadenaSql = "DELETE FROM orden_poliza WHERE orden=" . $variable . ";";
                break;

            case "insertarPoliza" :
                $cadenaSql = " INSERT INTO orden_poliza(";
                $cadenaSql .= " orden, poliza, fecha_inicio,fecha_final) ";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= $variable ['orden'] . ",";
                $cadenaSql .= $variable ['poliza'] . ",";
                $cadenaSql .= "'" . $variable ['fecha_inicio'] . "',";
                $cadenaSql .= "'" . $variable ['fecha_final'] . "');";

                break;



            case "updateEstadoAprobacion" :
                $cadenaSql = " UPDATE contrato_general SET estado_aprobacion='t' ";
                $cadenaSql.=" WHERE numero_contrato= '" . $variable['numero_contrato'] . "' and vigencia = " . $variable['vigencia'] . ";";

                break;

            case "aprobarContrato" :
                $cadenaSql = " INSERT INTO contrato_aprobado( ";
                $cadenaSql.=" numero_contrato, vigencia, fecha_aprobacion, usuario)";
                $cadenaSql.=" VALUES ('" . $variable['numero_contrato'] . "', " . $variable['vigencia'] . ", ";
                $cadenaSql.=" '" . $variable['fecha_aprobacion'] . "', '" . $variable['usuario'] . "');";

                break;

            case "obteneConsecutivoContratoAprobado" :
                $cadenaSql = " SELECT MAX(consecutivo_contrato) as consecutivo_contrato FROM contrato_aprobado; ";

                break;


//------------------------------------------------SQLs SIN DDEFINIR USO-----------------------------------------------------------------------------------

            case "buscarUsuario" :
                $cadenaSql = "SELECT ";
                $cadenaSql .= "FECHA_CREACION, ";
                $cadenaSql .= "PRIMER_NOMBRE ";
                $cadenaSql .= "FROM ";
                $cadenaSql .= "USUARIOS ";
                $cadenaSql .= "WHERE ";
                $cadenaSql .= "`PRIMER_NOMBRE` ='" . $variable . "' ";
                break;

            case "insertarRegistro" :
                $cadenaSql = "INSERT INTO ";
                $cadenaSql .= $prefijo . "registradoConferencia ";
                $cadenaSql .= "( ";
                $cadenaSql .= "`idRegistrado`, ";
                $cadenaSql .= "`nombre`, ";
                $cadenaSql .= "`apellido`, ";
                $cadenaSql .= "`identificacion`, ";
                $cadenaSql .= "`codigo`, ";
                $cadenaSql .= "`correo`, ";
                $cadenaSql .= "`tipo`, ";
                $cadenaSql .= "`fecha` ";
                $cadenaSql .= ") ";
                $cadenaSql .= "VALUES ";
                $cadenaSql .= "( ";
                $cadenaSql .= "NULL, ";
                $cadenaSql .= "'" . $variable ['nombre'] . "', ";
                $cadenaSql .= "'" . $variable ['apellido'] . "', ";
                $cadenaSql .= "'" . $variable ['identificacion'] . "', ";
                $cadenaSql .= "'" . $variable ['codigo'] . "', ";
                $cadenaSql .= "'" . $variable ['correo'] . "', ";
                $cadenaSql .= "'0', ";
                $cadenaSql .= "'" . time() . "' ";
                $cadenaSql .= ")";
                break;

            case "actualizarRegistro" :
                $cadenaSql = "UPDATE ";
                $cadenaSql .= $prefijo . "conductor ";
                $cadenaSql .= "SET ";
                $cadenaSql .= "`nombre` = '" . $variable ["nombre"] . "', ";
                $cadenaSql .= "`apellido` = '" . $variable ["apellido"] . "', ";
                $cadenaSql .= "`identificacion` = '" . $variable ["identificacion"] . "', ";
                $cadenaSql .= "`telefono` = '" . $variable ["telefono"] . "' ";
                $cadenaSql .= "WHERE ";
                $cadenaSql .= "`idConductor` =" . $_REQUEST ["registro"] . " ";
                break;

            /**
             * Clausulas genéricas.
             * se espera que estén en todos los formularios
             * que utilicen esta plantilla
             */
            case "iniciarTransaccion" :
                $cadenaSql = "START TRANSACTION";
                break;

            case "finalizarTransaccion" :
                $cadenaSql = "COMMIT";
                break;

            case "cancelarTransaccion" :
                $cadenaSql = "ROLLBACK";
                break;



            case "eliminarTemp" :

                $cadenaSql = "DELETE ";
                $cadenaSql .= "FROM ";
                $cadenaSql .= $prefijo . "tempFormulario ";
                $cadenaSql .= "WHERE ";
                $cadenaSql .= "id_sesion = '" . $variable . "' ";
                break;

            case "insertarTemp" :
                $cadenaSql = "INSERT INTO ";
                $cadenaSql .= $prefijo . "tempFormulario ";
                $cadenaSql .= "( ";
                $cadenaSql .= "id_sesion, ";
                $cadenaSql .= "formulario, ";
                $cadenaSql .= "campo, ";
                $cadenaSql .= "valor, ";
                $cadenaSql .= "fecha ";
                $cadenaSql .= ") ";
                $cadenaSql .= "VALUES ";

                foreach ($_REQUEST as $clave => $valor) {
                    $cadenaSql .= "( ";
                    $cadenaSql .= "'" . $idSesion . "', ";
                    $cadenaSql .= "'" . $variable ['formulario'] . "', ";
                    $cadenaSql .= "'" . $clave . "', ";
                    $cadenaSql .= "'" . $valor . "', ";
                    $cadenaSql .= "'" . $variable ['fecha'] . "' ";
                    $cadenaSql .= "),";
                }

                $cadenaSql = substr($cadenaSql, 0, (strlen($cadenaSql) - 1));
                break;

            case "rescatarTemp" :
                $cadenaSql = "SELECT ";
                $cadenaSql .= "id_sesion, ";
                $cadenaSql .= "formulario, ";
                $cadenaSql .= "campo, ";
                $cadenaSql .= "valor, ";
                $cadenaSql .= "fecha ";
                $cadenaSql .= "FROM ";
                $cadenaSql .= $prefijo . "tempFormulario ";
                $cadenaSql .= "WHERE ";
                $cadenaSql .= "id_sesion='" . $idSesion . "'";
                break;

            /**
             * Clausulas Del Caso Uso.
             */
            case "dependenciasArreglo" :

                $cadenaSql = "SELECT DISTINCT ESF_ID_ESPACIO,ESF_NOMBRE_ESPACIO ";
                $cadenaSql .= " FROM ESPACIOS_FISICOS ";
                $cadenaSql .= " WHERE ESF_ID_SEDE='" . $variable . "' ";
                $cadenaSql .= " AND  ESF_ESTADO='A'";

                break;


            case "cargoSuper" :

                $cadenaSql = "SELECT f.\"cargo\" ";
                $cadenaSql .= "FROM \"SICapital\".\"funcionario\" f  ";
                $cadenaSql .= "WHERE f.\"identificacion\"='$variable' ";

                break;

            case "sedeConsulta" :
                $cadenaSql = "SELECT DISTINCT  ESF_ID_SEDE  ";
                $cadenaSql .= " FROM ESPACIOS_FISICOS ";
                $cadenaSql .= " WHERE   ESF_ESTADO='A'";
                $cadenaSql .= " AND  ESF_ID_ESPACIO='" . $variable . "' ";
                break;

            case "proveedores" :
                $cadenaSql = " SELECT PRO_NIT,PRO_NIT||' - '||PRO_RAZON_SOCIAL AS proveedor ";
                $cadenaSql .= " FROM PROVEEDORES ";

                break;

            // case "dependencias" :
            // $cadenaSql = "SELECT DISTINCT ESF_COD_SEDE, ESF_NOMBRE_ESPACIO ";
            // $cadenaSql .= " FROM ESPACIOS_FISICOS ";
            // break;
            // case "sede" :
            // $cadenaSql = "SELECT DISTINCT ESF_COD_SEDE, ESF_SEDE ";
            // $cadenaSql .= " FROM ESPACIOS_FISICOS ";
            // break;
            case "informacionPresupuestal" :
                $cadenaSql = "SELECT  vigencia_dispo, numero_dispo, valor_disp, fecha_dip,
									letras_dispo, vigencia_regis, numero_regis, valor_regis, fecha_regis,
									letras_regis  ";
                $cadenaSql .= "FROM informacion_presupuestal_orden ";
                $cadenaSql .= "WHERE id_informacion ='" . $variable . "' ";

                break;



            case "consultarRubro" :
                $cadenaSql = " SELECT \"RUB_NOMBRE_RUBRO\" ";
                $cadenaSql .= " FROM arka_parametros.arka_rubros  ";
                $cadenaSql .= " WHERE  \"RUB_IDENTIFICADOR\"='" . $variable . "'";

                break;

            case "buscar_contratista" :
                $cadenaSql = "SELECT CON_IDENTIFICADOR AS IDENTIFICADOR , CON_IDENTIFICACION ||'  -  '||CON_NOMBRE AS CONTRATISTA ";
                $cadenaSql .= "FROM CONTRATISTAS ";
                $cadenaSql .= "WHERE CON_VIGENCIA ='" . $variable . "' ";
                break;

            case "vigencia_contratista" :
                $cadenaSql = "SELECT CON_VIGENCIA AS VALOR , CON_VIGENCIA AS VIGENCIA  ";
                $cadenaSql .= "FROM CONTRATISTAS ";
                $cadenaSql .= "GROUP BY CON_VIGENCIA ";
                break;


            case "vigencia_registro" :
                $cadenaSql = "SELECT REP_VIGENCIA AS VALOR,REP_VIGENCIA AS VIGENCIA ";
                $cadenaSql .= "FROM REGISTRO_PRESUPUESTAL ";
                $cadenaSql .= "GROUP BY REP_VIGENCIA ";

                break;

            case "buscar_registro" :
                $cadenaSql = "SELECT  \"REP_IDENTIFICADOR\" AS identificador,\"REP_IDENTIFICADOR\" AS numero ";
                $cadenaSql .= "FROM arka_parametros.arka_registropresupuestal ";
                $cadenaSql .= "WHERE \"REP_VIGENCIA\"='" . $variable [0] . "'";
                $cadenaSql .= "AND  \"REP_NUMERO_DISPONIBILIDAD\"='" . $variable [1] . "'";
                $cadenaSql .= "AND  \"REP_UNIDAD_EJECUTORA\"='" . $variable [2] . "'";
                break;
            case "info_registro" :
                $cadenaSql = "SELECT \"REP_FECHA_REGISTRO\" AS fecha, \"REP_VALOR\" valor ";
                $cadenaSql .= "FROM arka_parametros.arka_registropresupuestal  ";
                $cadenaSql .= "WHERE \"REP_VIGENCIA\"='" . $variable [1] . "'  ";
                $cadenaSql .= "AND  \"REP_IDENTIFICADOR\"='" . $variable [0] . "' ";

                break;

            case "informacion_supervisor" :
                $cadenaSql = " SELECT JEF_NOMBRE,JEF_IDENTIFICADOR ";
                $cadenaSql .= " FROM JEFES_DE_SECCION ";
                $cadenaSql .= " WHERE  JEF_IDENTIFICADOR='" . $variable . "' ";
                break;

            case "informacion_cargo_jefe" :
                $cadenaSql = " SELECT JEF_NOMBRE,JEF_IDENTIFICADOR ";
                $cadenaSql .= " FROM JEFES_DE_SECCION ";
                $cadenaSql .= " WHERE  JEF_IDENTIFICADOR='" . $variable . "' ";
                break;

            case "constratistas" :
                $cadenaSql = " SELECT CON_IDENTIFICADOR,CON_IDENTIFICACION ||' - '|| CON_NOMBRE ";
                $cadenaSql .= "FROM CONTRATISTAS ";

                break;


            case "cargo_jefe" :
                $cadenaSql = " SELECT JEF_IDENTIFICADOR,JEF_DEPENDENCIA_PERTENECIENTE ";
                $cadenaSql .= " FROM JEFES_DE_SECCION ";
                break;

            case "ordenador_gasto" :
                $cadenaSql = " 	SELECT ORG_IDENTIFICADOR, ORG_ORDENADOR_GASTO ";
                $cadenaSql .= " FROM ORDENADORES_GASTO ";
                $cadenaSql .= " WHERE ORG_ESTADO='A' ";
                break;

            case "constratistas" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " id_encargado,";
                $cadenaSql .= "identificacion ||' - '|| nombres ||' 	'||apellidos as contratista ";
                $cadenaSql .= " FROM";
                $cadenaSql .= " encargado ";
                $cadenaSql .= " WHERE id_tipo_encargado='3' AND estado='TRUE'";
                break;

            case "cargo_jefe" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " id_cargo,";
                $cadenaSql .= "descripcion ";
                $cadenaSql .= " FROM";
                $cadenaSql .= " tipo_cargo ; ";
                break;

            case "dependencia" :
                $cadenaSql = " SELECT DEP_IDENTIFICADOR, DEP_IDENTIFICADOR ||' - ' ||DEP_DEPENDENCIA  ";
                $cadenaSql .= "FROM DEPENDENCIAS ";
                break;

            case 'seleccion_contratista' :
                $cadenaSql = " SELECT id_contratista, ";
                $cadenaSql .= "  identificacion||' - '|| nombre_razon_social contratista ";
                $cadenaSql .= "FROM contratista_servicios;";

                break;




            // _________________________________________________



            case "consultarOrdenServicios" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " dependencia_solicitante,rubro,objeto_contrato, poliza1,";
                $cadenaSql .= "poliza2, poliza3, poliza4, duracion_pago, fecha_inicio_pago,";
                $cadenaSql .= "fecha_final_pago, forma_pago, total_preliminar, iva, total,id_contratista,";
                $cadenaSql .= " id_ordenador_encargado,sede, ";
                $cadenaSql .= "id_supervisor ,info_presupuestal ";
                $cadenaSql .= " FROM orden_servicio ";
                $cadenaSql .= " WHERE id_orden_servicio='" . $variable . "' AND estado='TRUE';";
                break;

            case "consultarContratista" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " nombre_razon_social, identificacion,direccion,telefono, cargo ";
                $cadenaSql .= " FROM contratista_servicios ";
                $cadenaSql .= " WHERE id_contratista='" . $variable . "'";

                break;

            case "consultarContratistaDocumento" :
                $cadenaSql = "SELECT CON_IDENTIFICACION , CON_NOMBRE AS CONTRATISTA ";
                $cadenaSql .= "FROM CONTRATISTAS ";
                $cadenaSql .= "WHERE CON_VIGENCIA ='" . $variable [1] . "' ";
                $cadenaSql .= "AND  CON_IDENTIFICADOR ='" . $variable [0] . "' ";
                break;

            case "consultarOrdenador_gasto" :
                $cadenaSql = " 	SELECT \"ORG_ORDENADOR_GASTO\",\"ORG_NOMBRE\" ";
                $cadenaSql .= " FROM arka_parametros.arka_ordenadores     ";
                $cadenaSql .= " WHERE     \"ORG_IDENTIFICACION\" ='" . $variable [0] . "'";
                $cadenaSql .= " AND       \"ORG_TIPO_ORDENADOR\"  ='" . $variable [1] . "'";

                break;

            case "consultarOrdenDocumento" :
                $cadenaSql = "SELECT o.id_orden,o.fecha_registro as fecha_registro_orden, cg.* , p.descripcion  as tipo_orden  ";
                $cadenaSql .= "FROM orden o, contrato_general cg, parametros p WHERE o.numero_contrato = cg.numero_contrato AND p.id_parametro = o.tipo_orden    ";
                $cadenaSql .= "AND o.vigencia = cg.vigencia AND o.estado = true AND o.id_orden=$variable;  ";

                break;


            case "consultarSupervisor" :
                $cadenaSql = " SELECT p.descripcion,f.* FROM \"SICapital\".funcionario f, contractual.parametros p ";
                $cadenaSql .= " WHERE p.id_parametro = f.tipo_documento and identificacion='$variable';  ";
                break;

            case "consultarSupervisorDocumento" :
                $cadenaSql = " SELECT * FROM SICAARKA.FUNCIONARIOS  ";
                $cadenaSql .= " WHERE FUN_IDENTIFICACION = $variable  ";
                break;


            case "consultarFormadePago" :
                $cadenaSql = " SELECT descripcion  FROM contractual.parametros  ";
                $cadenaSql .= " WHERE id_parametro = $variable;  ";
                break;

            case "consultarConvenio" :
                $cadenaSql = " SELECT nombre_convenio  FROM contractual.convenio  ";
                $cadenaSql .= " WHERE id_convenio = $variable;  ";
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

            case "consultarProveedor" :
                $cadenaSql = " SELECT *  ";
                $cadenaSql .= " FROM contratista ";
                $cadenaSql .= " WHERE identificacion='" . $variable . "'";
                break;

            case "consultarContratistas" :
                $cadenaSql = " SELECT nombres, identificacion, cargo ";
                $cadenaSql .= " FROM contratistas_adquisiones ";
                $cadenaSql .= " WHERE id_contratista_adq='" . $variable . "'";

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

            case "consultarEncargado" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " nombres ||' '||apellidos as nombre, cargo,asignacion  ";
                $cadenaSql .= " FROM encargado ";
                $cadenaSql .= " WHERE id_encargado='" . $variable . "' AND estado=TRUE";

                break;
            // ____________________________________update___________________________________________

            case "actualizarSolicitante" :

                $cadenaSql = " UPDATE ";
                $cadenaSql .= " solicitante_servicios";
                $cadenaSql .= " SET ";
                $cadenaSql .= " dependencia='" . $variable [0] . "',";
                $cadenaSql .= " rubro='" . $variable [1] . "' ";
                $cadenaSql .= "  WHERE id_solicitante='" . $variable [2] . "';";
                break;

            case "actualizarSupervisor" :
                $cadenaSql = " UPDATE supervisor_servicios ";
                $cadenaSql .= " SET nombre='" . $variable [0] . "', ";
                $cadenaSql .= " cargo='" . $variable [1] . "', ";
                $cadenaSql .= " dependencia='" . $variable [2] . "', ";
                $cadenaSql .= " sede='" . $variable [3] . "' ";
                $cadenaSql .= "  WHERE id_supervisor='" . $variable [4] . "';";

                break;

            case "actualizarProveedor" :
                $cadenaSql = " UPDATE proveedor_adquisiones ";
                $cadenaSql .= " SET razon_social='" . $variable [0] . "', ";
                $cadenaSql .= " identificacion='" . $variable [1] . "', ";
                $cadenaSql .= " direccion='" . $variable [2] . "', ";
                $cadenaSql .= " telefono='" . $variable [3] . "' ";
                $cadenaSql .= "  WHERE id_proveedor_adq='" . $variable [4] . "';";

                break;

            case "actualizarContratista" :
                $cadenaSql = " UPDATE contratistas_adquisiones	 ";
                $cadenaSql .= " SET nombres='" . $variable [0] . "', ";
                $cadenaSql .= " identificacion='" . $variable [1] . "', ";
                $cadenaSql .= " cargo='" . $variable [2] . "' ";
                $cadenaSql .= "  WHERE id_contratista_adq='" . $variable [3] . "';";

                break;

            case "actualizarEncargado" :
                $cadenaSql = " UPDATE encargado ";
                $cadenaSql .= " SET id_tipo_encargado='" . $variable [0] . "', ";
                $cadenaSql .= " nombre='" . $variable [1] . "', ";
                $cadenaSql .= " identificacion='" . $variable [2] . "', ";
                $cadenaSql .= " cargo='" . $variable [3] . "', ";
                $cadenaSql .= " asignacion='" . $variable [4] . "' ";
                $cadenaSql .= "  WHERE id_encargado='" . $variable [5] . "';";

                break;

            // UPDATE orden
            // SET id_orden=?, tipo_orden=?, vigencia=?, consecutivo_servicio=?,
            // consecutivo_compras=?, fecha_registro=?, info_presupuestal=?,
            // dependencia_solicitante=?, sede=?, rubro=?, objeto_contrato=?,
            // poliza1=?, poliza2=?, poliza3=?, poliza4=?, duracion_pago=?,
            // fecha_inicio_pago=?, fecha_final_pago=?, forma_pago=?, id_contratista=?,
            // id_supervisor=?, id_ordenador_encargado=?, tipo_ordenador=?,
            // estado=?
            // WHERE <condition>;

            case "actualizarOrden" :
                $cadenaSql = " UPDATE ";
                $cadenaSql .= " orden ";
                $cadenaSql .= " SET ";
                $cadenaSql .= " dependencia_solicitante='" . $variable [0] . "', ";
                $cadenaSql .= " sede_solicitante='" . $variable [1] . "', ";
                $cadenaSql .= " objeto_contrato='" . $variable [2] . "', ";

                if ($variable [3] != '') {
                    $cadenaSql .= " poliza1='" . $variable [3] . "', ";
                } else {
                    $cadenaSql .= " poliza1='0', ";
                }
                if ($variable [4] != '') {
                    $cadenaSql .= " poliza2='" . $variable [4] . "', ";
                } else {
                    $cadenaSql .= " poliza2='0', ";
                }

                if ($variable [5] != '') {
                    $cadenaSql .= " poliza3='" . $variable [5] . "', ";
                } else {
                    $cadenaSql .= " poliza3='0', ";
                }
                if ($variable [6] != '') {
                    $cadenaSql .= " poliza4='" . $variable [6] . "', ";
                } else {
                    $cadenaSql .= " poliza4='0', ";
                }

                $cadenaSql .= " duracion_pago='" . $variable [7] . "', ";
                $cadenaSql .= " fecha_inicio_pago=" . $variable [8] . ", ";
                $cadenaSql .= " fecha_final_pago=" . $variable [9] . ", ";
                $cadenaSql .= " forma_pago='" . $variable [10] . "', ";
                $cadenaSql .= " id_ordenador_encargado='" . $variable [11] . "', ";
                $cadenaSql .= " tipo_ordenador='" . $variable [12] . "',  ";
                $cadenaSql .= " clausula_presupuesto='" . $variable [15] . "'  ";
                $cadenaSql .= "  WHERE id_orden='" . $variable [13] . "';";

                break;

            case "actualizarPresupuestal" :
                $cadenaSql = " UPDATE informacion_presupuestal_orden ";
                $cadenaSql .= " SET vigencia_dispo='" . $variable [0] . "', ";
                $cadenaSql .= " numero_dispo='" . $variable [1] . "', ";
                $cadenaSql .= " valor_disp='" . $variable [2] . "', ";
                $cadenaSql .= " fecha_dip='" . $variable [3] . "', ";
                $cadenaSql .= " letras_dispo='" . $variable [4] . "', ";
                $cadenaSql .= " vigencia_regis='" . $variable [5] . "', ";
                $cadenaSql .= " numero_regis='" . $variable [6] . "', ";
                $cadenaSql .= " valor_regis='" . $variable [7] . "', ";
                $cadenaSql .= " fecha_regis='" . $variable [8] . "', ";
                $cadenaSql .= " letras_regis='" . $variable [9] . "', ";
                $cadenaSql .= " unidad_ejecutora='" . $variable [11] . "' ";
                $cadenaSql .= "  WHERE id_informacion='" . $variable [10] . "';";

                break;

            case "insertarItems" :
                $cadenaSql = " INSERT INTO ";
                $cadenaSql .= " items_orden_compra(";
                $cadenaSql .= " id_orden, item, unidad_medida, cantidad, descripcion, ";
                $cadenaSql .= " valor_unitario, valor_total)";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'" . $variable [0] . "',";
                $cadenaSql .= "'" . $variable [1] . "',";
                $cadenaSql .= "'" . $variable [2] . "',";
                $cadenaSql .= "'" . $variable [3] . "',";
                $cadenaSql .= "'" . $variable [4] . "',";
                $cadenaSql .= "'" . $variable [5] . "',";
                $cadenaSql .= "'" . $variable [6] . "');";

                break;

            case "dependecia_solicitante" :

                $cadenaSql = "SELECT DISTINCT ESF_NOMBRE_ESPACIO ";
                $cadenaSql .= " FROM ESPACIOS_FISICOS ";
                $cadenaSql .= " WHERE ESF_ID_ESPACIO='" . $variable . "' ";
                $cadenaSql .= " AND  ESF_ESTADO='A'";

                break;

            case 'consultar_numero_orden' :
                $cadenaSql = " SELECT id_orden_servicio, id_orden_servicio  ";
                $cadenaSql .= " FROM orden_servicio; ";

                break;

            case "identificacion_contratista" :
                $cadenaSql = " SELECT CON_IDENTIFICACION  ";
                $cadenaSql .= " FROM CONTRATISTAS  ";
                $cadenaSql .= " WHERE CON_IDENTIFICADOR='" . $variable . "' ";

                break;





            case "dependencias" :
                $cadenaSql = "SELECT DISTINCT  \"ESF_CODIGO_DEP\" , \"ESF_DEP_ENCARGADA\" ";
                $cadenaSql .= " FROM arka_parametros.arka_dependencia ad ";
                $cadenaSql .= " JOIN  arka_parametros.arka_espaciosfisicos ef ON  ef.\"ESF_ID_ESPACIO\"=ad.\"ESF_ID_ESPACIO\" ";
                $cadenaSql .= " JOIN  arka_parametros.arka_sedes sa ON sa.\"ESF_COD_SEDE\"=ef.\"ESF_COD_SEDE\" ";
                $cadenaSql .= " WHERE ad.\"ESF_ESTADO\"='A'";

                break;

            case "consultarElementos" :
                $cadenaSql = "SELECT *   ";
                $cadenaSql .= " FROM elemento_acta_recibido ";
                $cadenaSql .= " WHERE id_orden ='" . $variable . "';";

                break;

            case "consultarElementosOrden" :
                $cadenaSql = "SELECT DISTINCT ela.*, ct.elemento_nombre nivel_nombre, tb.descripcion nombre_tipo, iv.descripcion nombre_iva,elemento_nombre,  ";
                $cadenaSql .= " dep.\"ESF_DEP_ENCARGADA\"   ";
                $cadenaSql .= "FROM elemento_acta_recibido ela ";
                $cadenaSql .= "JOIN  inventarios.catalogo_elemento ct ON ct.elemento_id=ela.nivel ";
                $cadenaSql .= "JOIN \"SICapital\".\"dependencia_SIC\" dep ON dep.\"ESF_CODIGO_DEP\"=ela.codigo_dependencia ";
                $cadenaSql .= "JOIN  inventarios.tipo_bienes tb ON tb.id_tipo_bienes=ela.tipo_bien ";
                $cadenaSql .= "JOIN  inventarios.aplicacion_iva iv ON iv.id_iva=ela.iva  ";
                $cadenaSql .= "WHERE id_orden ='" . $variable . "'  ";
                $cadenaSql .= "AND  ela.estado=true; ";
                break;

            case "consultarElemento" :
                $cadenaSql = "SELECT  * ";
                $cadenaSql .= "FROM contractual.elemento_acta_recibido ";
                $cadenaSql .= "WHERE  id_elemento_ac ='" . $variable . "'  ;";

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

            case "consultar_tipo_poliza" :

                $cadenaSql = "SELECT id_tipo_poliza, descripcion ";
                $cadenaSql .= "FROM inventarios.tipo_poliza;";

                break;

            case "consultar_tipo_iva" :

                $cadenaSql = "SELECT id_iva, descripcion ";
                $cadenaSql .= "FROM inventarios.aplicacion_iva;";

                break;

            case "ConsultaTipoBien" :

                $cadenaSql = "SELECT ge.elemento_tipobien , tb.descripcion  ";
                $cadenaSql .= "FROM  inventarios.catalogo_elemento ce ";
                $cadenaSql .= "JOIN  inventarios.catalogo_elemento_grupo ge  ON (ge.elemento_id)::text =ce .elemento_grupoc  ";
                $cadenaSql .= "JOIN  inventarios.tipo_bienes tb ON tb.id_tipo_bienes = ge.elemento_tipobien  ";
                $cadenaSql .= "WHERE ce.elemento_id = '" . $variable . "';";

                break;

            case 'consultarExistenciaImagen' :

                $cadenaSql = "SELECT id_imagen ";
                $cadenaSql .= "FROM  asignar_imagen_acta ";
                $cadenaSql .= "WHERE  id_elemento_acta ='" . $variable . "';";

                break;

            case "ActualizarElementoImagen" :

                $cadenaSql = " UPDATE inventarios.asignar_imagen_acta ";
                $cadenaSql .= "SET  id_elemento_acta='" . $variable ['elemento'] . "', imagen='" . $variable ['imagen'] . "' ";
                $cadenaSql .= "WHERE id_imagen='" . $variable ['id_imagen'] . "';";

                break;

            case "RegistrarElementoImagen" :

                $cadenaSql = " 	INSERT INTO inventarios.asignar_imagen_acta(";
                $cadenaSql .= " id_elemento_acta, imagen ) ";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'" . $variable ['elemento'] . "',";
                $cadenaSql .= "'" . $variable ['imagen'] . "') ";
                $cadenaSql .= "RETURNING id_imagen; ";

                break;

            case "consultar_iva" :

                $cadenaSql = "SELECT iva ";
                $cadenaSql .= "FROM inventarios.aplicacion_iva ";
                $cadenaSql .= "WHERE id_iva='" . $variable . "';";

                break;

            case "actualizar_elemento_tipo_1" :
                $cadenaSql = "UPDATE elemento_acta_recibido ";
                $cadenaSql .= "SET nivel='" . $variable [0] . "', ";
                $cadenaSql .= "tipo_bien='" . $variable [1] . "', ";
                $cadenaSql .= "descripcion='" . $variable [2] . "', ";
                $cadenaSql .= "cantidad='" . $variable [3] . "', ";
                $cadenaSql .= "unidad='" . $variable [4] . "', ";
                $cadenaSql .= "valor='" . $variable [5] . "', ";
                $cadenaSql .= "iva='" . $variable [6] . "', ";
                $cadenaSql .= "subtotal_sin_iva='" . $variable [7] . "', ";
                $cadenaSql .= "total_iva='" . $variable [8] . "', ";
                $cadenaSql .= "total_iva_con='" . $variable [9] . "', ";
                $cadenaSql .= (is_null($variable [10]) == true) ? "marca=NULL, " : "marca='" . $variable [10] . "', ";
                $cadenaSql .= (is_null($variable [11]) == true) ? "serie=NULL,  " : "serie='" . $variable [11] . "',  ";
                $cadenaSql .= (is_null($variable [13]) == true) ? "referencia=NULL, " : "referencia='" . $variable [13] . "', ";
                $cadenaSql .= (is_null($variable [14]) == true) ? "placa=NULL,  " : "placa='" . $variable [14] . "',  ";
                $cadenaSql .= (is_null($variable [15]) == true) ? "observacion=NULL, " : "observacion='" . $variable [15] . "',  ";
                $cadenaSql .= (is_null($variable [16]) == true) ? "codigo_dependencia=NULL,  " : "codigo_dependencia='" . $variable [16] . "',  ";
                $cadenaSql .= (is_null($variable [17]) == true) ? "funcionario=NULL " : "funcionario='" . $variable [17] . "'  ";

                $cadenaSql .= "WHERE id_elemento_ac ='" . $variable [12] . "'  ";

                break;

            case "actualizar_elemento_tipo_2" :
                $cadenaSql = "UPDATE elemento_acta_recibido ";
                $cadenaSql .= "SET nivel='" . $variable [0] . "', ";
                $cadenaSql .= "tipo_bien='" . $variable [1] . "', ";
                $cadenaSql .= "descripcion='" . $variable [2] . "', ";
                $cadenaSql .= "cantidad='" . $variable [3] . "', ";
                $cadenaSql .= "unidad='" . $variable [4] . "', ";
                $cadenaSql .= "valor='" . $variable [5] . "', ";
                $cadenaSql .= "iva='" . $variable [6] . "', ";
                $cadenaSql .= "subtotal_sin_iva='" . $variable [7] . "', ";
                $cadenaSql .= "total_iva='" . $variable [8] . "', ";
                $cadenaSql .= "total_iva_con='" . $variable [9] . "', ";
                $cadenaSql .= "tipo_poliza='" . $variable [10] . "', ";
                if ($variable [10] == 0) {

                    $cadenaSql .= "fecha_inicio_pol=NULL, ";
                    $cadenaSql .= "fecha_final_pol=NULL, ";
                } else if ($variable [10] == 1) {

                    $cadenaSql .= "fecha_inicio_pol='" . $variable [11] . "', ";
                    $cadenaSql .= "fecha_final_pol='" . $variable [12] . "', ";
                }
                $cadenaSql .= (is_null($variable [13]) == true) ? "marca=NULL, " : "marca='" . $variable [13] . "', ";
                $cadenaSql .= (is_null($variable [14]) == true) ? "serie=NULL, " : "serie='" . $variable [14] . "',  ";

                $cadenaSql .= (is_null($variable [16]) == true) ? "referencia=NULL, " : "referencia='" . $variable [16] . "', ";
                $cadenaSql .= (is_null($variable [17]) == true) ? "placa=NULL,  " : "placa='" . $variable [17] . "',  ";
                $cadenaSql .= (is_null($variable [18]) == true) ? "observacion=NULL, " : "observacion='" . $variable [18] . "',  ";
                $cadenaSql .= (is_null($variable [19]) == true) ? "codigo_dependencia=NULL,  " : "codigo_dependencia='" . $variable [19] . "',  ";
                $cadenaSql .= (is_null($variable [20]) == true) ? "funcionario=NULL " : "funcionario='" . $variable [20] . "'  ";

                $cadenaSql .= "WHERE id_elemento_ac ='" . $variable [15] . "' ";

                break;

            case "eliminarElementoActa" :
                $cadenaSql = " UPDATE ";
                $cadenaSql .= " elemento_acta_recibido  ";
                $cadenaSql .= " SET ";
                $cadenaSql .= " estado='false'  ";
                $cadenaSql .= " WHERE id_elemento_ac='" . $variable . "'";
                break;

            // -- Modificar orden

            case "rubros" :
                $cadenaSql = " SELECT \"RUB_IDENTIFICADOR\", \"RUB_RUBRO\" ||' - '|| \"RUB_NOMBRE_RUBRO\" ";
                $cadenaSql .= "FROM arka_parametros.arka_rubros ";
                $cadenaSql .= "WHERE \"RUB_VIGENCIA\"='" . date('Y') . "';";

                break;







            case "registro_consultas" :
                $cadenaSql = "SELECT  \"REP_IDENTIFICADOR\" AS identificador,\"REP_IDENTIFICADOR\" AS numero ";
                $cadenaSql .= "FROM arka_parametros.arka_registropresupuestal ";
                $cadenaSql .= "WHERE \"REP_VIGENCIA\"='" . $variable [0] . "'";
                $cadenaSql .= "AND  \"REP_NUMERO_DISPONIBILIDAD\"='" . $variable [1] . "'";

                break;


            case "consultarInformaciónDisponibilidad" :

                $cadenaSql = "SELECT *  ";
                $cadenaSql .= " FROM disponibilidad_orden   ";
                $cadenaSql .= " WHERE id_orden='" . $variable . "' ";
                $cadenaSql .= " AND estado_registro='t'  ";
                $cadenaSql .= " ORDER BY id_orden ASC;  ";

                break;


            case "consultarConsecutivo" :

                $cadenaSql = "SELECT ro.vigencia,ro.unidad_ejecutora, ro.consecutivo_servicio,ro.consecutivo_compras,ro.tipo_orden   ";
                $cadenaSql .= " FROM orden ro  ";
                $cadenaSql .= " WHERE ro.id_orden='" . $variable . "'";
                break;

            case "consultarConsecutivoUnidad" :

                $cadenaSql = "SELECT 
								CASE ro.tipo_orden
								WHEN 1 THEN max(ro.consecutivo_compras)
								WHEN 9 THEn max(ro.consecutivo_servicio)
								END consecutivo ";
                $cadenaSql .= " FROM orden ro  ";
                $cadenaSql .= " WHERE ro.vigencia='" . $variable ['vigencia'] . "' ";
                $cadenaSql .= " AND  ro.unidad_ejecutora ='" . $variable ['unidad_ejecutora'] . "' ";
                $cadenaSql .= " AND  ro.tipo_orden ='" . $variable ['tipo_orden'] . "' ";
                $cadenaSql .= " GROUP BY ro.tipo_orden ; ";

                break;

            case "actualizarConsecutivoCompras" :
                $cadenaSql = " UPDATE ";
                $cadenaSql .= " orden ";
                $cadenaSql .= " SET ";
                $cadenaSql .= " consecutivo_compras='" . $variable ['consecutivo'] . "', ";
                $cadenaSql .= " unidad_ejecutora='" . $variable ['unidad_ejecutora'] . "'  ";
                $cadenaSql .= "  WHERE id_orden='" . $variable ['id_orden'] . "';";

                break;

            case "actualizarConsecutivoServicios" :
                $cadenaSql = " UPDATE ";
                $cadenaSql .= " orden ";
                $cadenaSql .= " SET ";
                $cadenaSql .= " consecutivo_servicio='" . $variable ['consecutivo'] . "', ";
                $cadenaSql .= " unidad_ejecutora='" . $variable ['unidad_ejecutora'] . "'  ";
                $cadenaSql .= "  WHERE id_orden='" . $variable ['id_orden'] . "';";

                break;

            //-------------------------Documento Novedades ------------------------------------------------


            case "acumuladoAdiciones" :
                $cadenaSql = "  SELECT SUM(valor_presupuesto) as acumulado  ";
                $cadenaSql .= " FROM adicion a , novedad_contractual nc  ";
                $cadenaSql .= " WHERE a.id = nc.id AND numero_contrato = '$variable[0]' AND vigencia = $variable[1];";
                break;



            case "consultarAdcionesPresupuesto" :
                $cadenaSql = "  SELECT nc.*, a.numero_solicitud, a.numero_cdp, a.valor_presupuesto ";
                $cadenaSql .= " FROM adicion a , novedad_contractual nc    ";
                $cadenaSql .= " WHERE a.id = nc.id AND numero_contrato = '$variable[0]' AND vigencia = $variable[1] ";
                $cadenaSql .= " AND tipo_adicion = 248;";
                break;


            case "consultarAdcionesTiempo" :
                $cadenaSql = "  SELECT nc.*, pr.descripcion as unidad_tiempo_ejecucion, a.valor_tiempo  ";
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
                $cadenaSql .= "  nc.documento, nc.descripcion, pr.descripcion as parametro_descripcion ";
                $cadenaSql .= " FROM novedad_contractual nc, parametros pr  ";
                $cadenaSql .= " WHERE numero_contrato = '$variable[0]' AND vigencia = $variable[1] AND pr.id_parametro = nc.tipo_novedad ";
                $cadenaSql .= " AND ( nc.tipo_novedad = 217 or nc.tipo_novedad = 218 ) ; ";
                break;

            case "ConsultaSupervisorNovedad" :
                $cadenaSql = "   SELECT FUN_IDENTIFICACION ||' - '|| FUN_NOMBRE ";
                $cadenaSql .= "  FROM SICAARKA.FUNCIONARIOS WHERE FUN_IDENTIFICACION = $variable ";
                break;
        }
        return $cadenaSql;
    }

}

?>
