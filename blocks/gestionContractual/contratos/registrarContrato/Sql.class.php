<?php

namespace contratos\registrarContrato;

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
            case "vigencias_solicitudes" :

                $cadenaSql = "SELECT DISTINCT vigencia , vigencia valor  ";
                $cadenaSql .= " FROM \"SICapital\".solicitud_necesidad  ";
                $cadenaSql .= "WHERE estado_registro=TRUE; ";

                break;

            case "ConsultarNumeroNecesidades" :

                $cadenaSql = "SELECT * FROM (SELECT DISTINCT sl.numero_solicitud as descripcion, sl.id_sol_necesidad as id, sl.estado_registro,sl.vigencia  ";
                $cadenaSql .= " FROM \"SICapital\".solicitud_necesidad sl, \"SICapital\".orden_contrato oc, contractual.parametros pr,  "
                        . "contractual.contrato_general cg, contractual.contrato c ";
                $cadenaSql .= " WHERE sl.estado_registro= TRUE  ";
                $cadenaSql .= " and oc.solicitud_necesidad=sl.id_sol_necesidad   ";
                $cadenaSql .= " and pr.id_parametro = sl.ejecucion ";
                $cadenaSql .= " and cg.vigencia=c.vigencia and cg.numero_contrato = c.numero_contrato   ";
                $cadenaSql .= " EXCEPT ";
                $cadenaSql .= " SELECT DISTINCT sl.numero_solicitud as descripcion, sl.id_sol_necesidad as id, sl.estado_registro,sl.vigencia  ";
                $cadenaSql .= " FROM \"SICapital\".solicitud_necesidad sl, \"SICapital\".orden_contrato oc, contractual.parametros pr, "
                        . "  contractual.contrato_general cg, contractual.contrato c ";
                $cadenaSql .= "  WHERE sl.estado_registro= TRUE  ";
                $cadenaSql .= " and oc.solicitud_necesidad=sl.id_sol_necesidad ";
                $cadenaSql .= "  and pr.id_parametro = sl.ejecucion  ";
                $cadenaSql .= " and cg.vigencia=c.vigencia and cg.numero_contrato = c.numero_contrato  ";
                $cadenaSql .= " and cg.id_orden_contrato = oc.id_orden_contr ) as r ";
                $cadenaSql .= " WHERE vigencia=$variable;";

                break;

            case "consultarSolicitud" :
                $cadenaSql = "SELECT * FROM (SELECT DISTINCT sl.id_sol_necesidad, sl.vigencia, sl.numero_solicitud, sl.fecha_solicitud, sl.valor_contratacion, "
                        . " sl.unidad_tiempo_ejecucion ||' '||pr.descripcion duracion, sl.objeto_contrato,oc.id_orden_contr, sl.estado_registro  ";
                $cadenaSql .= " FROM \"SICapital\".solicitud_necesidad sl, \"SICapital\".orden_contrato oc, contractual.parametros pr,  "
                        . "contractual.contrato_general cg, contractual.contrato c ";
                $cadenaSql .= " WHERE sl.estado_registro= TRUE  ";
                $cadenaSql .= " and oc.solicitud_necesidad=sl.id_sol_necesidad   ";
                $cadenaSql .= " and pr.id_parametro = sl.ejecucion ";
                $cadenaSql .= " and cg.vigencia=c.vigencia and cg.numero_contrato = c.numero_contrato   ";
                $cadenaSql .= " EXCEPT ";
                $cadenaSql .= " SELECT DISTINCT sl.id_sol_necesidad, sl.vigencia, sl.numero_solicitud, sl.fecha_solicitud,sl.valor_contratacion, "
                        . "sl.unidad_tiempo_ejecucion ||' '||pr.descripcion duracion, sl.objeto_contrato,oc.id_orden_contr, sl.estado_registro    ";
                $cadenaSql .= " FROM \"SICapital\".solicitud_necesidad sl, \"SICapital\".orden_contrato oc, contractual.parametros pr, "
                        . "  contractual.contrato_general cg, contractual.contrato c ";
                $cadenaSql .= "  WHERE sl.estado_registro= TRUE  ";
                $cadenaSql .= " and oc.solicitud_necesidad=sl.id_sol_necesidad ";
                $cadenaSql .= "  and pr.id_parametro = sl.ejecucion  ";
                $cadenaSql .= " and cg.vigencia=c.vigencia and cg.numero_contrato = c.numero_contrato  ";
                $cadenaSql .= " and cg.id_orden_contrato = oc.id_orden_contr ) as r ";

                if ($variable ['vigencia'] != '' || $variable ['numero_solicitud'] != '' || $variable ['fecha_inicial'] != '') {
                    $cadenaSql .= " WHERE estado_registro= TRUE ";
                    if ($variable ['vigencia'] != '') {
                        $cadenaSql .= " AND vigencia = '" . $variable ['vigencia'] . "' ";
                    }
                    if ($variable ['numero_solicitud'] != '') {
                        $cadenaSql .= " AND  id_sol_necesidad = '" . $variable ['numero_solicitud'] . "' ";
                    }

                    if ($variable ['fecha_inicial'] != '') {
                        $cadenaSql .= " AND fecha_solicitud BETWEEN CAST ( '" . $variable ['fecha_inicial'] . "' AS DATE) ";
                        $cadenaSql .= " AND  CAST ( '" . $variable ['fecha_final'] . "' AS DATE)  ";
                    }
                }

                $cadenaSql .= "  ; ";

                break;

            case "dependenciasConsultadas" :
                $cadenaSql = "SELECT DISTINCT  id_dependencia , \"ESF_DEP_ENCARGADA\" ";
                $cadenaSql .= " FROM \"SICapital\".\"dependencia_SIC\" ad ";
                $cadenaSql .= " JOIN  \"SICapital\".\"espaciosfisicos_SIC\" ef ON  ef.\"ESF_ID_ESPACIO\"=ad.\"ESF_ID_ESPACIO\" ";
                $cadenaSql .= " JOIN  \"SICapital\".\"sedes_SIC\" sa ON sa.\"ESF_COD_SEDE\"=ef.\"ESF_COD_SEDE\" ";
                $cadenaSql .= " WHERE ad.\"ESF_ESTADO\"='A'";

                break;

          
            case "ordenadorGasto" :

                $cadenaSql = " 	select \"ORG_IDENTIFICADOR_UNICO\", \"ORG_ORDENADOR_GASTO\"   from argo_ordenadores ";
                $cadenaSql .= " where \"ORG_ESTADO\" = 'A' and \"ORG_ORDENADOR_GASTO\" <> 'DIRECTOR IDEXUD'; ";

                break;


            case "Consultar_Registro_Presupuestales" :
                $cadenaSql = " SELECT rp.id_registro_pres, rp.numero_registro, rp.valor_registro, rp.vigencia,rp.fecha_rgs_pr  ";
                $cadenaSql .= " FROM \"SICapital\".registro_presupuestal rp ";
                $cadenaSql .= " WHERE rp.estado_registro=true and rp.disponibilidad_presupuestal=$variable;";
                break;



            case "funcionarios" :

                $cadenaSql = "SELECT identificacion, identificacion ||' - '|| nombre_cp ";
                $cadenaSql .= "FROM \"SICapital\".\"funcionario\" ";
                $cadenaSql .= "WHERE estado='A' ";

                break;


           
            case "obtenerInfoUsuario" :
                $cadenaSql = "SELECT u.dependencia_especifica ||' - '|| u.dependencia as nombre, unidad_ejecutora  ";
                $cadenaSql .= "FROM frame_work.argo_usuario u  ";
                $cadenaSql .= "WHERE u.id_usuario='" . $variable . "' ";
                break;

            case "obtener_cargo_supervisro" :
                $cadenaSql = "SELECT cargo ";
                $cadenaSql .= "from \"SICapital\".funcionario  ";
                $cadenaSql .= "WHERE identificacion='" . $variable . "' ";
                break;

          case "forma_pago" :
                $cadenaSql = " 	SELECT id_parametro, descripcion ";
                $cadenaSql .= " FROM  parametros ";
                $cadenaSql .= " WHERE rel_parametro=28 and id_parametro=240;";

                break;

            case "insertarContratoGeneral" :
                $cadenaSql = " INSERT INTO contrato_general(";
                $cadenaSql .= " vigencia,id_orden_contrato, tipo_contrato,unidad_ejecutora, ";
                $cadenaSql .= " objeto_contrato,fecha_inicio,fecha_final,plazo_ejecucion, ";
                $cadenaSql .= " forma_pago,ordenador_gasto,supervisor,nombre_contratista,contratista,numero_solicitud_necesidad,numero_cdp,"
                        . " unidad_ejecucion, clausula_registro_presupuestal, ";
                $cadenaSql .= " cargo_supervisor) ";
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
                $cadenaSql .= "'" . $variable ['nombre_contratista'] . "',";
                $cadenaSql .=  $variable ['contratista'] . ",";
                $cadenaSql .=  $variable ['numero_solicitud_necesidad'] . ",";
                $cadenaSql .=  $variable ['numero_cdp'] . ",";
                $cadenaSql .=  $variable ['unidad_ejecucion_tiempo'] . ",";
                $cadenaSql .= $variable ['clausula_presupuesto'] . ",";
                $cadenaSql .= "'" . $variable ['cargo_supervisor'] . "');";

                break;

            case 'registrar_contrato' :

                $cadenaSql = " INSERT INTO contrato(vigencia, numero_contrato, fecha_sub, ";
                $cadenaSql .= " valor_moneda_ext, valor_tasa_cb, fecha_sub_super, ";
                $cadenaSql .= " fecha_lim_ejec, observacion_inter, observacion_contr, ";
                $cadenaSql .= " tipologia_contrato, tipo_configuracion, clase_contratista, ";
                $cadenaSql .= " clase_compromiso, numero_constancia, ";
                $cadenaSql .= " modalidad_seleccion, procedimiento, regimen_contratacion, tipo_moneda, ";
                $cadenaSql .= " tipo_gasto, origen_recursos, origen_presupuesto, tema_corr_gst_inv, ";
                $cadenaSql .= " tipo_control_ejecucion, fecha_registro, ";
                $cadenaSql .= " identificacion_clase_contratista,digito_verificacion_clase_contratista,porcentaje_clase_contratista,  ";
                $cadenaSql .= " numero_convenio,vigencia_convenio,valor_contrato,digito_verificacion_supervisor)  ";
                $cadenaSql .= " VALUES ('" . $variable ['vigencia'] . "',";
                $cadenaSql .= $variable ['numero_contrato'] . ",";
                $cadenaSql .= " '" . $variable ['fecha_subcripcion'] . "',";
                $cadenaSql .= " '" . $variable ['valor_contrato_moneda_ex'] . "',";
                $cadenaSql .= " '" . $variable ['tasa_cambio'] . "',";
                $cadenaSql .= " '" . $variable ['fecha_suscrip_super'] . "',";
                $cadenaSql .= " '" . $variable ['fecha_limite'] . "',";
                $cadenaSql .= " '" . $variable ['observaciones_interventoria'] . "',";
                $cadenaSql .= " '" . $variable ['observacionesContrato'] . "',";
                $cadenaSql .= " '" . $variable ['tipologia_especifica'] . "',";
                $cadenaSql .= " '" . $variable ['tipo_configuracion'] . "',";
                $cadenaSql .= " '" . $variable ['clase_contratista'] . "',";
                $cadenaSql .= " '" . $variable ['tipo_compromiso'] . "',";
                $cadenaSql .= " '" . $variable ['numero_constancia'] . "',";
                $cadenaSql .= " '" . $variable ['modalidad_seleccion'] . "',";
                $cadenaSql .= " '" . $variable ['procedimiento'] . "',";
                $cadenaSql .= " '" . $variable ['regimen_contratación'] . "',";
                $cadenaSql .= " '" . $variable ['tipo_moneda'] . "',";
                $cadenaSql .= " '" . $variable ['tipo_gasto'] . "',";
                $cadenaSql .= " '" . $variable ['origen_recursos'] . "',";
                $cadenaSql .= " '" . $variable ['origen_presupuesto'] . "',";
                $cadenaSql .= " '" . $variable ['tema_gasto_inversion'] . "',";
                $cadenaSql .= " '" . $variable ['tipo_control'] . "',";
                $cadenaSql .= " '" . $variable ['fecha_registro'] . "',";
                $cadenaSql .= " '" . $variable ['identificacion_clase_contratista'] . "',";
                $cadenaSql .= " '" . $variable ['digito_verificacion_clase_contratista'] . "',";
                $cadenaSql .= $variable ['porcentaje_clase_contratista'] . ",";
                $cadenaSql .= $variable ['numero_convenio'] . ",";
                $cadenaSql .= $variable ['vigencia_convenio'] . ",";
                $cadenaSql .= $variable ['valor_contrato'] . ",";
                $cadenaSql .= " '" . $variable ['digito_supervisor'] . "');";


                break;

            case "obtenerInfoOrden" :
                $cadenaSql = " SELECT MAX(numero_contrato) as numero_contrato";
                $cadenaSql .= " FROM ";
                $cadenaSql .= "contrato_general; ";

                break;

//------------------------------SQLs Sin Uso            
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
            case "tipo_identificacion" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipo_indentificacion_contratista'; ";

                break;

            case "tipo_persona" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipo_persona'; ";

                break;

            case "tipo_genero_ajax" :

                $cadenaSql = "SELECT id_parametro  id, pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='genero' and ";
                if ($variable == 1) {
                    $condicion = " id_parametro <> 247; ";
                } else {
                    $condicion = " id_parametro = 247; ";
                }

                $cadenaSql .= $condicion;

                break;

            case "tipo_genero" :

                $cadenaSql = "SELECT id_parametro  id, pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='genero'; ";

                break;

            case "tipo_perfil" :

                $cadenaSql = "SELECT id_parametro  id, pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipo_perfil'; ";

                break;

            case "tipo_nacionalidad" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='nacionalidad'; ";

                break;

            case "tipo_cuenta" :

                $cadenaSql = "SELECT id_parametro  id, pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipo_cuenta_bancaria'; ";

                break;

            case "tipo_configuracion" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipo_configuracion'; ";
                break;

            case "tipo_clase_contratista" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='clase_contratista'; ";
                break;

            case "tipo_clase_contrato" :

                $cadenaSql = "SELECT id_parametro  id, pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='clase_contrato'; ";

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

            case "consulta_dependencia" :

                $cadenaSql = "SELECT id_dependencia  ,nombre    ";
                $cadenaSql .= "FROM dependencia ";
                $cadenaSql .= "WHERE estado_registro = TRUE ;";

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

            case "consulta_ordenador" :

                $cadenaSql = "SELECT og.id_ordenador, pr.descripcion || ': ' ||og.nombre_cp ordenador  ";
                $cadenaSql .= "FROM ordenador_gasto og  ";
                $cadenaSql .= "JOIN parametros pr ON pr.id_parametro= og.tipo_ordenador  ";
                $cadenaSql .= "JOIN parametros rp ON rp.id_parametro= og.estado ";
                $cadenaSql .= "WHERE rp.descripcion='Activo' ";
                $cadenaSql .= "AND  og.estado_registro= TRUE;  ";
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




            case "Consultar_Contratista" :
                $cadenaSql = " SELECT cns.*, ib.tipo_cuenta,ib.nombre_banco,ib.numero_cuenta,ib.id_inf_bancaria,oc.id_orden_contr, sl.funcionario_solicitante  ";
                $cadenaSql .= " FROM contratista cns";
                $cadenaSql .= " LEFT JOIN inf_bancaria ib ON ib.contratista=cns.id_contratista ";
                $cadenaSql .= " LEFT JOIN \"SICapital\".orden_contrato oc ON oc.contratista=cns.id_contratista";
                $cadenaSql .= " LEFT JOIN \"SICapital\".solicitud_necesidad sl ON sl.id_sol_necesidad=oc.solicitud_necesidad";
                $cadenaSql .= " WHERE cns.estado_registro=TRUE ";
                $cadenaSql .= " AND sl.id_sol_necesidad= '" . $variable . "';";

                break;

            case "actualizar_contratista" :
                $cadenaSql = " UPDATE contratista";
                $cadenaSql .= " SET ";
                $cadenaSql .= " direccion='" . $variable ['direccion'] . "', ";
                $cadenaSql .= " telefono='" . $variable ['telefono'] . "', ";
                $cadenaSql .= " digito_verificacion='" . $variable ['digito_verificacion'] . "', ";

                if ($variable ['correo'] != '') {

                    $cadenaSql .= " correo='" . $variable ['correo'] . "', ";
                } else {

                    $cadenaSql .= " correo=NULL, ";
                }
                $cadenaSql .= " identificacion='" . $variable ['numero_identificacion'] . "', ";
                $cadenaSql .= " genero='" . $variable ['genero'] . "', ";
                $cadenaSql .= " tipo_naturaleza='" . $variable ['tipo_persona'] . "', ";
                $cadenaSql .= " tipo_documento='" . $variable ['tipo_identificacion'] . "', ";
                $cadenaSql .= " nombre_razon_social='" . $variable ['razon_social'] . "',";
                $cadenaSql .= " nacionalidad='" . $variable ['nacionalidad'] . "', ";
                $cadenaSql .= " perfil='" . $variable ['perfil'] . "', ";
                $cadenaSql .= " profesion='" . $variable ['profesion'] . "',";
                $cadenaSql .= " especialidad='" . $variable ['especialidad'] . "'";
                $cadenaSql .= " WHERE id_contratista='" . $variable ['id_contratista'] . "';";

                break;

            case 'actualizar_informacion_bancaria' :

                $cadenaSql = " UPDATE inf_bancaria";
                $cadenaSql .= " SET tipo_cuenta='" . $variable ['tipo_cuenta'] . "',";
                $cadenaSql .= " nombre_banco='" . $variable ['entidad_bancaria'] . "', ";
                $cadenaSql .= " numero_cuenta='" . $variable ['numero_cuenta'] . "' ";
                $cadenaSql .= " WHERE id_inf_bancaria='" . $variable ['id_info_bancaria'] . "' ;";

                break;

            case 'registrar_informacion_bancaria' :
                $cadenaSql = " INSERT INTO inf_bancaria(tipo_cuenta, nombre_banco, numero_cuenta,contratista, fecha_registro)";
                $cadenaSql .= " VALUES ( '" . $variable ['tipo_cuenta'] . "',";
                $cadenaSql .= " '" . $variable ['entidad_bancaria'] . "',";
                $cadenaSql .= " '" . $variable ['numero_cuenta'] . "',";
                $cadenaSql .= " '" . $variable ['id_contratista'] . "', ";
                $cadenaSql .= " '" . $variable ['fecha_registro'] . "');";
                break;

            case 'registrar_contratista' :
                $cadenaSql = " INSERT INTO contratista(  ";
                $cadenaSql .= " direccion, telefono, digito_verificacion, correo, ";
                $cadenaSql .= " identificacion, genero, tipo_naturaleza, tipo_documento,";
                $cadenaSql .= " fecha_registro, nacionalidad, perfil, profesion,nombre_razon_social, ";
                $cadenaSql .= " especialidad)";
                $cadenaSql .= " VALUES ('" . $variable ['direccion'] . "',";
                $cadenaSql .= " '" . $variable ['telefono'] . "',";
                $cadenaSql .= " '" . $variable ['digito_verificacion'] . "',";
                $cadenaSql .= " '" . $variable ['correo'] . "',";
                $cadenaSql .= " '" . $variable ['numero_identificacion'] . "', ";
                $cadenaSql .= " '" . $variable ['genero'] . "', ";
                $cadenaSql .= " '" . $variable ['tipo_persona'] . "',";
                $cadenaSql .= " '" . $variable ['tipo_identificacion'] . "',";
                $cadenaSql .= " '" . $variable ['fecha_registro'] . "',";
                $cadenaSql .= " '" . $variable ['nacionalidad'] . "', ";
                $cadenaSql .= " '" . $variable ['perfil'] . "',";
                $cadenaSql .= " '" . $variable ['profesion'] . "',";
                $cadenaSql .= " '" . $variable ['razon_social'] . "',";
                $cadenaSql .= " '" . $variable ['especialidad'] . "') RETURNING id_contratista ;";

                break;



            case 'insertarInformacionContratoTemporal' :

                $cadenaSql = "INSERT INTO ";
                $cadenaSql .= " temporal_contrato( ";
                $cadenaSql .= " id_contrato_temp,";
                $cadenaSql .= " campo_formulario,";
                $cadenaSql .= " informacion_campo,";
                $cadenaSql .= " usuario,";
                $cadenaSql .= " fecha) ";
                $cadenaSql .= " VALUES(";
                $cadenaSql .= $variable['id'];
                $cadenaSql .= ",'" . $variable['campo'] . "',";
                $cadenaSql .= "'" . $variable['informacion'] . "',";
                $cadenaSql .= "'" . $variable['usuario'] . "',";
                $cadenaSql .= "'" . $variable['fecha'] . "');";


                break;
            case 'obtenerInfoTemporal' :

                $cadenaSql = "SELECT  DISTINCT ";
                $cadenaSql .= "id_contrato_temp ";
                $cadenaSql .= "FROM ";
                $cadenaSql .= "contractual.temporal_contrato ";
                $cadenaSql .= "WHERE ";
                $cadenaSql .= "id_contrato_temp=" . $variable;

                break;
            case 'eliminarInfoTemporal' :

                $cadenaSql = "DELETE  FROM ";
                $cadenaSql .= "contractual.temporal_contrato ";
                $cadenaSql .= "WHERE ";
                $cadenaSql .= "id_contrato_temp=" . $variable;

                break;
            case 'Consultar_info_Temporal' :

                $cadenaSql = "SELECT ";
                $cadenaSql .= "campo_formulario, ";
                $cadenaSql .= "informacion_campo ";
                $cadenaSql .= "FROM ";
                $cadenaSql .= "contractual.temporal_contrato ";
                $cadenaSql .= "WHERE ";
                $cadenaSql .= "id_contrato_temp=" . $variable;

                break;
            case 'obtener_id_contratista' :

                $cadenaSql = "SELECT ";
                $cadenaSql .= "MAX(id_contratista) ";
                $cadenaSql .= "FROM ";
                $cadenaSql .= "contractual.contratista; ";
                break;

            case "obtenerUnidadUsuario" :

                $cadenaSql = " select unidad_ejecutora from frame_work.argo_usuario   ";
                $cadenaSql .= " where id_usuario = '$variable'; ";


                break;


            //---------------------SICapital--------------------------------------------------


            case "vigencias_sica_disponibilidades" :
                $cadenaSql = " SELECT DISTINCT SN.VIGENCIA AS valor, SN.VIGENCIA AS informacion  FROM CO.CO_SOLICITUD_ADQ SN ";
                $cadenaSql .= " ORDER BY SN.VIGENCIA DESC ";

                break;
            case "obtener_solicitudes_vigencia" :
                $cadenaSql = " SELECT DISTINCT SN.NUM_SOL_ADQ as valor , SN.NUM_SOL_ADQ as informacion  ";
                $cadenaSql .= " from CO.CO_SOLICITUD_ADQ SN, PR.PR_DISPONIBILIDADES CDP, ";
                $cadenaSql .= " CO.CO_DEPENDENCIAS DP where SN.NUM_SOL_ADQ =  CDP.NUM_SOL_ADQ ";
                $cadenaSql .= " and SN.DEPENDENCIA = DP.COD_DEPENDENCIA and SN.VIGENCIA= $variable[1]  ";
                $cadenaSql .= " and SN.CODIGO_UNIDAD_EJECUTORA = '0$variable[0]'   ";
                $cadenaSql .= " and SN.ESTADO = 'APROBADA' and CDP.ESTADO = 'VIGENTE' ";
                $cadenaSql .= " ORDER BY SN.NUM_SOL_ADQ ASC ";

                break;
            
             case "cdpRegistradas" :

                $cadenaSql = " select string_agg(cast(numero_cdp as text),',' ";
                $cadenaSql.=" order by numero_cdp) from contrato_general;";

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
                    $cadenaSql .= " and SN.NUM_SOL_ADQ = " . $variable['numero_solicitud'] . " ";
                }
                if ($variable['dependencia_solicitud'] != '') {
                    $cadenaSql .= " and SN.DEPENDENCIA = " . $variable['dependencia_solicitud'] . " ";
                }
                if ($variable['numero_cdp'] != '') {
                    $cadenaSql .= " and CDP.NUMERO_DISPONIBILIDAD = " . $variable['numero_cdp'] . " ";
                }
                if ($variable['fecha_inicial'] != '') {
                    $cadenaSql .= " and CDP.FECHA_REGISTRO BETWEEN TO_DATE ('" . $variable['fecha_inicial'] . "', 'yyyy/mm/dd') ";
                    $cadenaSql .= " AND TO_DATE ('" . $variable['fecha_final'] . "', 'yyyy/mm/dd') ";
                }
                break;

            case "Consultar_Disponibilidad" :
                $cadenaSql = " SELECT DISTINCT CDP.NUMERO_DISPONIBILIDAD, CDP.VIGENCIA,";
                $cadenaSql.=" CDP.FECHA_REGISTRO,SN.VALOR_CONTRATACION from ";
                $cadenaSql.=" CO.CO_SOLICITUD_ADQ SN, PR.PR_DISPONIBILIDADES CDP, CO.CO_DEPENDENCIAS DP ";
                $cadenaSql.=" where SN.NUM_SOL_ADQ = CDP.NUM_SOL_ADQ and SN.DEPENDENCIA = DP.COD_DEPENDENCIA and ";
                $cadenaSql.=" SN.VIGENCIA= $variable[1] and SN.CODIGO_UNIDAD_EJECUTORA = '0$variable[2]' and SN.NUM_SOL_ADQ = $variable[0] ";
                $cadenaSql.=" and SN.ESTADO = 'APROBADA' and CDP.ESTADO = 'VIGENTE' ";
                break;

             case "Consultar_Solicitud_Particular" :
                $cadenaSql = " SELECT NUM_SOL_ADQ, OBJETO as objeto, DEPENDENCIA as dependencia, ";
                $cadenaSql.=" VALOR_CONTRATACION as valor_contrato FROM CO.CO_SOLICITUD_ADQ WHERE ";
                $cadenaSql.=" NUM_SOL_ADQ=$variable[0] and VIGENCIA=$variable[1] and CODIGO_UNIDAD_EJECUTORA = '0$variable[2]'";

                break;

            /*
             *
             *
             */
        }
        return $cadenaSql;
    }

}

?>
