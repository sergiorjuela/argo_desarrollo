<?php

namespace gestionCompras\registrarOrden;

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
            case "obtenerInfoUsuario" :
                $cadenaSql = "SELECT u.dependencia_especifica ||' - '|| u.dependencia as nombre, unidad_ejecutora  ";
                $cadenaSql .= "FROM frame_work.argo_usuario u  ";
                $cadenaSql .= "WHERE u.id_usuario='" . $variable . "' ";
                break;

            case "polizas" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " id_poliza,";
                $cadenaSql .= " nombre_de_la_poliza, ";
                $cadenaSql .= " descripcion_poliza ";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " poliza; ";
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

            case "funcionarios" :

                $cadenaSql = "SELECT identificacion, identificacion ||' - '|| nombre_cp ";
                $cadenaSql .= "FROM \"SICapital\".\"funcionario\" ";
                $cadenaSql .= "WHERE estado='A' ";

                break;

            case "cargos_existentes" :
                $cadenaSql = " SELECT ";
                $cadenaSql .= " distinct cargo ";
                $cadenaSql .= " FROM \"SICapital\".\"funcionario\"; ";

                break;

            case "tipo_unidad_ejecucion" :
                $cadenaSql = " SELECT id_parametro, descripcion  ";
                $cadenaSql .= " FROM parametros WHERE rel_parametro=21; ";
            
                break;


            case "tipoComprador" :

                $cadenaSql = " 	SELECT f.\"identificacion\",p.descripcion ";
                $cadenaSql .= " FROM \"SICapital\".\"funcionario\" f ,\"SICapital\".\"funcionario_tipo_ordenador\"  o, parametros p ";
                $cadenaSql .= " WHERE o.\"estado\"=True and f.\"identificacion\"= o.\"funcionario\" and p.id_parametro= o.\"tipo_ordenador\" ";
                $cadenaSql .= " and p.id_parametro <> 202 ;";

                break;

            case "tipoComprador_idexud" :

                $cadenaSql = " 	SELECT f.\"identificacion\",p.descripcion ";
                $cadenaSql .= " FROM \"SICapital\".\"funcionario\" f ,\"SICapital\".\"funcionario_tipo_ordenador\"  o, parametros p ";
                $cadenaSql .= " WHERE o.\"estado\"=True and f.\"identificacion\"= o.\"funcionario\" and p.id_parametro= o.\"tipo_ordenador\" ";
                $cadenaSql .= " and p.id_parametro = 202 ;";

                break;
                
            case "ordenadores_orden" :

                $cadenaSql = " 	select \"ORG_IDENTIFICACION\", \"ORG_ORDENADOR_GASTO\"   from arka_parametros.argo_ordenadores ";
                $cadenaSql .= " where \"ORG_ESTADO\" = 'A' and \"ORG_ORDENADOR_GASTO\" <> 'DIRECTOR IDEXUD'; ";

                break;
            case "ordenadores_orden_idexud" :

                $cadenaSql = " 	select \"ORG_IDENTIFICACION\", \"ORG_ORDENADOR_GASTO\"   from arka_parametros.argo_ordenadores ";
                $cadenaSql .= " where \"ORG_ESTADO\" = 'A' and \"ORG_ORDENADOR_GASTO\" = 'DIRECTOR IDEXUD'; ";

                break;
            
            
            

            case "cargoSuper" :

                $cadenaSql = "SELECT f.\"cargo\" ";
                $cadenaSql .= "FROM \"SICapital\".\"funcionario\" f  ";
                $cadenaSql .= "WHERE f.\"identificacion\"='$variable' ";

                break;

            case "informacion_ordenador" :
                $cadenaSql = " 	SELECT  \"ORG_NOMBRE\",  \"ORG_IDENTIFICACION\",  \"ORG_IDENTIFICADOR\"  ";
                $cadenaSql .= " FROM arka_parametros.argo_ordenadores ";
                $cadenaSql .= " WHERE \"ORG_ESTADO\" = 'A' and  \"ORG_IDENTIFICACION\" = $variable;";

                break;

            case "forma_pago" :
                $cadenaSql = " 	SELECT id_parametro, descripcion ";
                $cadenaSql .= " FROM  parametros ";
                $cadenaSql .= " WHERE rel_parametro=28;";

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

            case "insertarContratoGeneral" :
                $cadenaSql = " INSERT INTO contrato_general(";
                $cadenaSql .= " vigencia,id_orden_contrato, tipo_contrato,unidad_ejecutora, ";
                $cadenaSql .= " objeto_contrato,fecha_inicio,fecha_final,plazo_ejecucion, ";
                $cadenaSql .= " forma_pago,ordenador_gasto,supervisor,clausula_registro_presupuestal, ";
                $cadenaSql .= " sede_supervisor,dependencia_supervisor,sede_solicitante,dependencia_solicitante,cargo_supervisor, ";
                $cadenaSql .= " numero_solicitud_necesidad,numero_cdp) ";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= $variable ['vigencia'] . ",";
                $cadenaSql .= $variable ['id_orden_contrato'] . ",";
                $cadenaSql .= $variable ['tipo_contrato'] . ",";
                $cadenaSql .= $variable ['unidad_ejecutura'] . ",";
                $cadenaSql .= "'" . $variable ['objeto_contrato'] . "',";
                $cadenaSql .= $variable ['fecha_inicio'] . ",";
                $cadenaSql .= $variable ['fecha_fin'] . ",";
                $cadenaSql .= $variable ['plazo_ejecucion'] . ",";
                $cadenaSql .= $variable ['forma_pago'] . ",";
                $cadenaSql .= "'" . $variable ['ordenador_gasto'] . "',";
                $cadenaSql .= "'" . $variable ['supervisor'] . "',";
                $cadenaSql .= $variable ['clausula_presupuesto'] . ",";
                $cadenaSql .= "'" . $variable ['sede_supervisor'] . "',";
                $cadenaSql .= "'" . $variable ['dependencia_supervisor'] . "',";
                $cadenaSql .= "'" . $variable ['sede_solicitante'] . "',";
                $cadenaSql .= "'" . $variable ['dependencia_solicitante'] . "',";
                $cadenaSql .= "'" . $variable ['cargo_supervisor'] . "',";
                $cadenaSql .=  $variable ['numero_solicitud'] . ", ";
                $cadenaSql .=  $variable ['numero_cdp'] . ");";

                break;
            case "insertarOrden" :
                $cadenaSql = " INSERT INTO orden(";
                $cadenaSql .= " tipo_orden,numero_contrato, vigencia,fecha_registro, ";
                $cadenaSql .= " proveedor, unidad_ejecucion) ";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= $variable ['tipo_orden'] . ",";
                $cadenaSql .= $variable ['numero_contrato'] . ",";
                $cadenaSql .= $variable ['vigencia'] . ",";
                $cadenaSql .= "'" . $variable ['fecha'] . "',";
                $cadenaSql .= "'" . $variable ['proveedor'] . "',";
                $cadenaSql .= $variable ['unidad_ejecucion'] . ");";

                break;

            case "insertarPoliza" :
                $cadenaSql = " INSERT INTO orden_poliza(";
                $cadenaSql .= " orden, poliza) ";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= $variable ['orden'] . ",";
                $cadenaSql .= $variable ['poliza'] . ");";

                break;

            case "obtenerInfoOrden" :
                $cadenaSql = " SELECT MAX(numero_contrato) as numero_contrato";
                $cadenaSql .= " FROM ";
                $cadenaSql .= "contrato_general; ";

                break;

            case "validarContratista" :
                $cadenaSql = "SELECT * From contratista WHERE identificacion=" . $variable;
                ;

                break;


//-----------------------------------------------------------SQLs SIN DDEFINIR USO-----------------------------------------------------------------------------------
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
            case "ubicacionesConsultadas" :
                $cadenaSql = "SELECT DISTINCT  ef.\"ESF_ID_ESPACIO\" , ef.\"ESF_NOMBRE_ESPACIO\" ";
                $cadenaSql .= " FROM arka_parametros.arka_espaciosfisicos ef  ";
                $cadenaSql .= " JOIN arka_parametros.arka_dependencia ad ON ad.\"ESF_ID_ESPACIO\"=ef.\"ESF_ID_ESPACIO\" ";
                $cadenaSql .= " WHERE ad.\"ESF_CODIGO_DEP\"='" . $variable . "' ";
                $cadenaSql .= " AND  ef.\"ESF_ESTADO\"='A'";

                break;




            case "proveedores" :
                $cadenaSql = " SELECT \"PRO_NIT\",\"PRO_NIT\"||' - '||\"PRO_RAZON_SOCIAL\" AS proveedor ";
                $cadenaSql .= " FROM arka_parametros.arka_proveedor ";

                break;



            case "dependencias" :
                $cadenaSql = "SELECT DISTINCT  ESF_ID_ESPACIO, ESF_NOMBRE_ESPACIO ";
                $cadenaSql .= " FROM ESPACIOS_FISICOS ";
                $cadenaSql .= " WHERE ESF_ID_SEDE='" . $variable . "' ";
                $cadenaSql .= " AND  ESF_ESTADO='A'";

                break;

            case "sede" :

                $cadenaSql = "SELECT DISTINCT  \"ESF_ID_SEDE\", \"ESF_SEDE\" ";
                $cadenaSql .= " FROM arka_parametros.arka_sedes ";
                $cadenaSql .= " WHERE   \"ESF_ESTADO\"='A' ";
                $cadenaSql .= " AND    \"ESF_COD_SEDE\" >  0 ;";
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

            case "vigencia_disponibilidad" :
                $cadenaSql = "SELECT \"DIS_VIGENCIA\" AS valor, \"DIS_VIGENCIA\" AS vigencia  ";
                $cadenaSql .= "FROM arka_parametros.arka_disponibilidadpresupuestal ";
                $cadenaSql .= "GROUP BY \"DIS_VIGENCIA\" ORDER BY  \"DIS_VIGENCIA\"  DESC; ";
                break;

            case "buscar_disponibilidad" :
                $cadenaSql = "SELECT DISTINCT \"DIS_NUMERO_DISPONIBILIDAD\" AS identificador,\"DIS_NUMERO_DISPONIBILIDAD\" AS numero ";
                $cadenaSql .= "FROM arka_parametros.arka_disponibilidadpresupuestal  ";
                $cadenaSql .= "WHERE \"DIS_VIGENCIA\"='" . $variable [0] . "' ";
                $cadenaSql .= "AND \"DIS_UNIDAD_EJECUTORA\"='" . $variable [1] . "' ";
                $cadenaSql .= "ORDER BY \"DIS_NUMERO_DISPONIBILIDAD\" DESC ;";

                break;

            case "info_disponibilidad" :
                $cadenaSql = "SELECT DISTINCT \"DIS_FECHA_REGISTRO\" AS FECHA, \"DIS_VALOR\" ";
                $cadenaSql .= "FROM arka_parametros.arka_disponibilidadpresupuestal  ";
                $cadenaSql .= "WHERE \"DIS_VIGENCIA\"='" . $variable [1] . "' ";
                $cadenaSql .= "AND  \"DIS_IDENTIFICADOR\"='" . $variable [0] . "' ";
                $cadenaSql .= "AND  \"DIS_UNIDAD_EJECUTORA\"='" . $variable [2] . "' ";

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
            case "informacion_cargo_jefe" :
                $cadenaSql = " SELECT JEF_NOMBRE,JEF_IDENTIFICADOR ";
                $cadenaSql .= " FROM JEFES_DE_SECCION ";
                $cadenaSql .= " WHERE  JEF_IDENTIFICADOR='" . $variable . "' ";

                break;

            case "ordenador_gasto" :
                $cadenaSql = " 	SELECT ORG_IDENTIFICACION, ORG_ORDENADOR_GASTO ";
                $cadenaSql .= " FROM ORDENADORES_GASTO ";
                $cadenaSql .= " WHERE ORG_ESTADO='A' ";
                break;

            case "constratistas" :
                $cadenaSql = " SELECT CON_IDENTIFICADOR,CON_IDENTIFICACION ||' - '|| CON_NOMBRE ";
                $cadenaSql .= "FROM CONTRATISTAS ";

                break;

            case "cargo_jefe" :
                $cadenaSql = " SELECT JEF_IDENTIFICADOR,JEF_DEPENDENCIA_PERTENECIENTE ";
                $cadenaSql .= " FROM JEFES_DE_SECCION ";

                break;

            case "rubros" :
                $cadenaSql = " SELECT \"RUB_IDENTIFICADOR\", \"RUB_RUBRO\" ||' - '|| \"RUB_NOMBRE_RUBRO\" ";
                $cadenaSql .= "FROM arka_parametros.arka_rubros ";
                $cadenaSql .= "WHERE \"RUB_VIGENCIA\"='" . date('Y') . "';";

                break;

            case "dependencia" :
                $cadenaSql = " SELECT DEP_IDENTIFICADOR, DEP_IDENTIFICADOR ||' - ' ||DEP_DEPENDENCIA  ";
                $cadenaSql .= "FROM DEPENDENCIAS ";
                break;





            case "insertarSolicitante" :
                $cadenaSql = " INSERT INTO solicitante_servicios(";
                $cadenaSql .= " dependencia, ";
                $cadenaSql .= " rubro )";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'" . $variable [0] . "',";
                $cadenaSql .= "'" . $variable [1] . "') ";
                $cadenaSql .= "RETURNING  id_solicitante; ";
                break;

            case "insertarSupervisor" :
                $cadenaSql = " INSERT INTO supervisor_servicios(";
                $cadenaSql .= " nombre,cargo, dependencia,sede,id_supervisor) ";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'" . $variable [0] . "',";
                $cadenaSql .= "'" . $variable [1] . "',";
                $cadenaSql .= "'" . $variable [2] . "',";
                $cadenaSql .= "'" . $variable [3] . "', ";
                $cadenaSql .= $variable [4] . ");";
                break;

            case "insertarProveedor" :
                $cadenaSql = " INSERT INTO proveedor_adquisiones(";
                $cadenaSql .= " id_proveedor_adq ,razon_social, identificacion,direccion, telefono,fecha_registro) ";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= $variable [4] . ",";
                $cadenaSql .= "'" . $variable [0] . "',";
                $cadenaSql .= "'" . $variable [1] . "',";
                $cadenaSql .= "'" . $variable [2] . "',";
                $cadenaSql .= "'" . $variable [3] . "',";
                $cadenaSql .= "'" . date('Y-m-d') . "') ";
                $cadenaSql .= "RETURNING  id_proveedor_adq; ";


                break;



            case "insertarEncargado" :
                $cadenaSql = " INSERT INTO arka_inventarios.encargado(";
                $cadenaSql .= " id_tipo_encargado,";
                $cadenaSql .= " nombre, ";
                $cadenaSql .= " identificacion,";
                $cadenaSql .= " cargo, ";
                $cadenaSql .= " asignacion)";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'" . $variable [0] . "',";
                $cadenaSql .= "'" . $variable [1] . "',";
                $cadenaSql .= "'" . $variable [2] . "',";
                $cadenaSql .= "'" . $variable [3] . "',";
                $cadenaSql .= "'" . $variable [4] . "') ";
                $cadenaSql .= "RETURNING  id_encargado; ";
                break;

            // INSERT
            // orden(
            // id_orden, tipo_orden, vigencia, consecutivo_servicio, consecutivo_compras,
            // fecha_registro, info_presupuestal, dependencia_solicitante, sede,
            // rubro, objeto_contrato, poliza1, poliza2, poliza3, poliza4, duracion_pago,
            // fecha_inicio_pago, fecha_final_pago, forma_pago, id_ordenador_encargado,
            // estado)
            // ;

            case "insertarOrden" :
                $cadenaSql = " INSERT INTO ";
                $cadenaSql .= " orden(";
                $cadenaSql .= "tipo_orden, vigencia, consecutivo_servicio, consecutivo_compras, 
								            fecha_registro, dependencia_solicitante, sede_solicitante, 
								            objeto_contrato, poliza1, poliza2, poliza3, poliza4, duracion_pago, 
								            fecha_inicio_pago, fecha_final_pago, forma_pago,id_contratista,id_supervisor, id_ordenador_encargado, tipo_ordenador,id_proveedor,clausula_presupuesto,unidad_ejecutora)";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'" . $variable ['tipo_orden'] . "',";
                $cadenaSql .= "'" . $variable ['vigencia'] . "',";
                $cadenaSql .= "" . $variable ['consecutivo_servicio'] . ",";
                $cadenaSql .= "" . $variable ['consecutivo_compras'] . ",";
                $cadenaSql .= "'" . $variable ['fecha_registro'] . "',";
                $cadenaSql .= "'" . $variable ['dependencia_solicitante'] . "',";
                $cadenaSql .= "'" . $variable ['sede_solicitante'] . "',";
                $cadenaSql .= "'" . $variable ['objeto_contrato'] . "',";



                if ($variable ['poliza1'] != '') {
                    $cadenaSql .= "'" . $variable ['poliza1'] . "',";
                } else {
                    $cadenaSql .= "'0',";
                }


                if ($variable ['poliza2'] != '') {
                    $cadenaSql .= "'" . $variable ['poliza2'] . "',";
                } else {
                    $cadenaSql .= "'0',";
                }
                if ($variable ['poliza3'] != '') {
                    $cadenaSql .= "'" . $variable ['poliza3'] . "',";
                } else {
                    $cadenaSql .= "'0',";
                }

                if ($variable ['poliza4'] != '') {
                    $cadenaSql .= "'" . $variable ['poliza4'] . "',";
                } else {
                    $cadenaSql .= "'0',";
                }

                $cadenaSql .= "'" . $variable ['duracion_pago'] . "',";
                $cadenaSql .= $variable ['fecha_inicio_pago'] . ",";
                $cadenaSql .= $variable ['fecha_final_pago'] . ",";
                $cadenaSql .= "'" . $variable ['forma_pago'] . "',";
                $cadenaSql .= "'" . $variable ['id_contratista'] . "',";
                $cadenaSql .= "'" . $variable ['id_supervisor'] . "',";
                $cadenaSql .= "'" . $variable ['id_ordenador_encargado'] . "',";
                $cadenaSql .= "'" . $variable ['tipo_ordenador'] . "',";
                $cadenaSql .= "'" . $variable ['id_proveedor'] . "',";
                $cadenaSql .= "'" . $variable ['clausula_presupuesto'] . "',";
                $cadenaSql .= "'" . $variable ['unidad_ejecutora'] . "') ";
                $cadenaSql .= "RETURNING  consecutivo_compras,consecutivo_servicio,id_orden  ; ";

                break;

            case "insertarInformacionPresupuestal" :
                $cadenaSql = " INSERT INTO informacion_presupuestal_orden( ";
                $cadenaSql .= " vigencia_dispo, numero_dispo, valor_disp, fecha_dip,
								letras_dispo, vigencia_regis, numero_regis, valor_regis, fecha_regis,
								letras_regis, fecha_registro,unidad_ejecutora)";
                $cadenaSql .= " VALUES (";
                $cadenaSql .= "'" . $variable [1] . "',";
                $cadenaSql .= "'" . $variable [2] . "',";
                $cadenaSql .= "'" . $variable [3] . "',";
                $cadenaSql .= "'" . $variable [4] . "',";
                $cadenaSql .= "'" . $variable [5] . "',";
                $cadenaSql .= "'" . $variable [6] . "',";
                $cadenaSql .= "'" . $variable [7] . "',";
                $cadenaSql .= "'" . $variable [8] . "',";
                $cadenaSql .= "'" . $variable [9] . "',";
                $cadenaSql .= "'" . $variable [10] . "',";
                $cadenaSql .= "'" . $variable [0] . "',";
                $cadenaSql .= "'" . $variable [11] . "') ";
                $cadenaSql .= "RETURNING  id_informacion; ";

                break;

            case "consultarDependencia" :
                $cadenaSql = " SELECT   ESF_ID_ESPACIO, ESF_NOMBRE_ESPACIO ";
                $cadenaSql .= "FROM ESPACIOS_FISICOS  ";
                $cadenaSql .= " WHERE ESF_ID_ESPACIO='" . $variable . "' ";
                $cadenaSql .= " AND  ESF_ESTADO='A'";

                break;

            case "consultarRubro" :
                $cadenaSql = " SELECT RUB_NOMBRE_RUBRO ";
                $cadenaSql .= " FROM RUBROS ";
                $cadenaSql .= " WHERE  RUB_IDENTIFICADOR='" . $variable . "'";

                break;

            case "consultarDependenciaSupervisor" :
                $cadenaSql = " SELECT   ESF_ID_ESPACIO, ESF_NOMBRE_ESPACIO ";
                $cadenaSql .= "FROM ESPACIOS_FISICOS  ";
                $cadenaSql .= " WHERE ESF_ID_ESPACIO='" . $variable . "' ";
                $cadenaSql .= " AND  ESF_ESTADO='A'";
                break;

            case "consultarSupervisor" :
                $cadenaSql = " SELECT nombre, cargo, dependencia ";
                $cadenaSql .= " FROM supervisor_servicios ";
                $cadenaSql .= " WHERE id_supervisor='" . $variable . "'";
                break;

            case "consultarOrdenador_gasto" :
                $cadenaSql = " 	SELECT ORG_ORDENADOR_GASTO,ORG_NOMBRE ";
                $cadenaSql .= " FROM ORDENADORES_GASTO ";
                $cadenaSql .= " WHERE ORG_IDENTIFICADOR ='" . $variable . "' ";
                $cadenaSql .= " AND ORG_ESTADO='A' ";
                break;

            case "consultarContratista" :
                $cadenaSql = "SELECT CON_IDENTIFICACION , CON_NOMBRE AS CONTRATISTA ";
                $cadenaSql .= "FROM CONTRATISTAS ";
                $cadenaSql .= "WHERE CON_VIGENCIA ='" . $variable [1] . "' ";
                $cadenaSql .= "AND  CON_IDENTIFICADOR ='" . $variable [0] . "' ";
                break;


            case "consultarCosntraistaServicios" :
                $cadenaSql = " SELECT nombre_razon_social, identificacion, direccion,telefono, cargo ";
                $cadenaSql .= " FROM contratista_servicios ";
                $cadenaSql .= " WHERE id_contratista='" . $variable . "'";
                break;

            case "informacionPresupuestal" :
                $cadenaSql = "SELECT  vigencia_dispo, numero_dispo, valor_disp, fecha_dip,
									letras_dispo, vigencia_regis, numero_regis, valor_regis, fecha_regis,
									letras_regis  ";
                $cadenaSql .= "FROM informacion_presupuestal_orden ";
                $cadenaSql .= "WHERE id_informacion ='" . $variable . "' ";

                break;

            case "consultarOrdenServicios" :
                $cadenaSql = "SELECT  fecha_registro, info_presupuestal, dependencia_solicitante,
				rubro, objeto_contrato, poliza1, poliza2, poliza3, poliza4, duracion_pago,
				fecha_inicio_pago, fecha_final_pago, forma_pago, total_preliminar,
				iva, total, id_contratista,id_supervisor,
				id_ordenador_encargado, estado ";
                $cadenaSql .= "FROM orden_servicio  ";
                $cadenaSql .= "WHERE  id_orden_servicio='" . $variable . "';";

                break;




            case "consecutivo_compra" :

                $cadenaSql = " 	SELECT max(consecutivo_compras)  ";
                $cadenaSql .= " FROM orden ";
                $cadenaSql .= " WHERE vigencia ='" . $variable ['vigencia'] . "' ";
                $cadenaSql .= " AND unidad_ejecutora ='" . $variable ['unidad_ejecutora'] . "';";

                break;

            case "consecutivo_servicios" :

                $cadenaSql = " 	SELECT max(consecutivo_servicio)  ";
                $cadenaSql .= " FROM orden ";
                $cadenaSql .= " WHERE vigencia ='" . $variable['vigencia'] . "' ";
                $cadenaSql .= " AND unidad_ejecutora ='" . $variable['unidad_ejecutora'] . "';";
                break;

            case "Unidad_Ejecutoria" :

                $cadenaSql = " SELECT DISTINCT \"DIS_UNIDAD_EJECUTORA\" valor ,\"DIS_UNIDAD_EJECUTORA\" descripcion  ";
                $cadenaSql .= "FROM arka_parametros.arka_disponibilidadpresupuestal; ";

                break;



            case "obtenerIdSupervisor" :

                $cadenaSql = " 	SELECT max(id_supervisor)  ";
                $cadenaSql .= " FROM supervisor_servicios; ";


                break;
            case "obtenerIdProveedor" :

                $cadenaSql = " 	SELECT max(id_proveedor_adq)  ";
                $cadenaSql .= " FROM proveedor_adquisiones; ";


                break;
            case "obtenerIdContratista" :

                $cadenaSql = " 	SELECT max(id_contratista_adq)  ";
                $cadenaSql .= " FROM contratistas_adquisiones; ";


                break;

            case "obtenerUnidadUsuario" :

                $cadenaSql = " select unidad_ejecutora from frame_work.argo_usuario   ";
                $cadenaSql .= " where id_usuario = '$variable'; ";


                break;


            //---------------------SICapital--------------------------------------------------


            case "vigencias_sica_disponibilidades" :
                $cadenaSql = " SELECT DISTINCT SN.VIGENCIA AS valor, SN.VIGENCIA AS informacion  FROM CO.CO_SOLICITUD_ADQ SN ";
                $cadenaSql .= " where SN.CODIGO_UNIDAD_EJECUTORA = 01 ORDER BY SN.VIGENCIA DESC ";

                break;
            case "obtener_solicitudes_vigencia" :
                $cadenaSql = " SELECT DISTINCT SN.NUM_SOL_ADQ as valor , SN.NUM_SOL_ADQ as informacion  ";
                $cadenaSql .= " from CO.CO_SOLICITUD_ADQ SN, PR.PR_DISPONIBILIDADES CDP, ";
                $cadenaSql .= " CO.CO_DEPENDENCIAS DP where SN.NUM_SOL_ADQ =  CDP.NUM_SOL_ADQ ";
                $cadenaSql .= " and SN.DEPENDENCIA = DP.COD_DEPENDENCIA and SN.VIGENCIA= $variable  ";
                $cadenaSql .= " and SN.CODIGO_UNIDAD_EJECUTORA = 01   ";
                $cadenaSql .= " and SN.ESTADO = 'APROBADA' and CDP.ESTADO = 'VIGENTE' ";
                $cadenaSql .= " ORDER BY SN.NUM_SOL_ADQ ASC ";

                break;
            
            case "obtener_solicitudes_vigencia" :
                $cadenaSql = " SELECT DISTINCT SN.NUM_SOL_ADQ as valor , SN.NUM_SOL_ADQ as informacion  ";
                $cadenaSql .= " from CO.CO_SOLICITUD_ADQ SN, PR.PR_DISPONIBILIDADES CDP, ";
                $cadenaSql .= " CO.CO_DEPENDENCIAS DP where SN.NUM_SOL_ADQ =  CDP.NUM_SOL_ADQ ";
                $cadenaSql .= " and SN.DEPENDENCIA = DP.COD_DEPENDENCIA and SN.VIGENCIA= $variable  ";
                $cadenaSql .= " and SN.CODIGO_UNIDAD_EJECUTORA = 01   ";
                $cadenaSql .= " and SN.ESTADO = 'APROBADA' and CDP.ESTADO = 'VIGENTE' ";
                $cadenaSql .= " ORDER BY SN.NUM_SOL_ADQ ASC ";

                break;
            
            case "obtener_cdp_numerosol" :
                $cadenaSql = " SELECT DISTINCT CDP.NUMERO_DISPONIBILIDAD as valor , CDP.NUMERO_DISPONIBILIDAD as informacion  ";
                $cadenaSql .= " from CO.CO_SOLICITUD_ADQ SN, PR.PR_DISPONIBILIDADES CDP, ";
                $cadenaSql .= " CO.CO_DEPENDENCIAS DP where SN.NUM_SOL_ADQ =  CDP.NUM_SOL_ADQ ";
                $cadenaSql .= " and SN.DEPENDENCIA = DP.COD_DEPENDENCIA and SN.VIGENCIA= ".$variable ['vigencia']." ";
                $cadenaSql .= " and SN.CODIGO_UNIDAD_EJECUTORA = 01  and SN.NUM_SOL_ADQ = ".$variable ['numsol']." ";
                $cadenaSql .= " and SN.ESTADO = 'APROBADA' and CDP.ESTADO = 'VIGENTE' ";
                $cadenaSql .= " ORDER BY CDP.NUMERO_DISPONIBILIDAD ";

                break;

            case "dependencia_solicitud_consulta" :
                $cadenaSql = " SELECT  DP.COD_DEPENDENCIA as VALOR, DP.NOMBRE_DEPENDENCIA as INFORMACION   ";
                $cadenaSql .= " FROM CO.CO_DEPENDENCIAS DP ";
                break;


            case "obtenerSolicitudesCdp" :
                $cadenaSql = "  SELECT SN.NUM_SOL_ADQ, SN.VIGENCIA ,DP.NOMBRE_DEPENDENCIA, SN.ESTADO, CDP.OBJETO,   ";
                $cadenaSql .= " CDP.NUMERO_DISPONIBILIDAD, SN.VALOR_CONTRATACION,CDP.ESTADO as ESTADOCDP , CDP.FECHA_REGISTRO ";
                $cadenaSql .= " FROM CO.CO_SOLICITUD_ADQ SN, PR.PR_DISPONIBILIDADES CDP, CO.CO_DEPENDENCIAS DP  ";
                $cadenaSql .= " WHERE SN.NUM_SOL_ADQ =  CDP.NUM_SOL_ADQ and SN.DEPENDENCIA = DP.COD_DEPENDENCIA ";
                $cadenaSql .= " and SN.VIGENCIA= " . $variable['vigencia_solicitud_consulta'] . " and SN.CODIGO_UNIDAD_EJECUTORA =" . $variable['unidad_ejecutora'] . " ";
                $cadenaSql .= " and SN.ESTADO = 'APROBADA' and CDP.ESTADO = 'VIGENTE'  ";
                if ($variable['numero_solicitud'] != '') {
                    $cadenaSql .= " and SN.NUM_SOL_ADQ = ". $variable['numero_solicitud']." " ;
                }
                if ($variable['dependencia_solicitud'] != '') {
                    $cadenaSql .= " and SN.DEPENDENCIA = ". $variable['dependencia_solicitud'] ." ";
                }
                if ($variable['numero_cdp'] != '') {
                    $cadenaSql .= " and CDP.NUMERO_DISPONIBILIDAD = ". $variable['numero_cdp'] ." ";
                }
                if ($variable['fecha_inicial'] != '') {
                     $cadenaSql .= " and CDP.FECHA_REGISTRO BETWEEN TO_DATE ('".$variable['fecha_inicial']."', 'yyyy/mm/dd') ";
                     $cadenaSql .= " AND TO_DATE ('".$variable['fecha_final']."', 'yyyy/mm/dd') ";
                     
                }
                break;
        }
        return $cadenaSql;
    }

}

?>
