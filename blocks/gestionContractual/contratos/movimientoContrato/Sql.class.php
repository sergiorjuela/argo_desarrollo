<?php

namespace gestionContractual\contrato\movimientoContrato;

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
            case "vigencias_solicitudes" :

                $cadenaSql = "SELECT DISTINCT vigencia , vigencia as valor  ";
                $cadenaSql .= " FROM contrato  ";
                $cadenaSql .= "WHERE estado_registro=TRUE; ";

                break;

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



            case "tipo_modificacion" :

                $cadenaSql = "SELECT id_parametro  id,pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipo_modificacion'; ";
                break;




            case "Consultar_Contratista" :
                $cadenaSql = " SELECT cns.*, ib.tipo_cuenta,ib.nombre_banco,ib.numero_cuenta,ib.id_inf_bancaria,oc.id_orden_contr  ";
                $cadenaSql .= " FROM contratista cns";
                $cadenaSql .= " LEFT JOIN inf_bancaria ib ON ib.contratista=cns.id_contratista ";
                $cadenaSql .= " LEFT JOIN orden_contrato oc ON oc.contratista=cns.id_contratista";
                $cadenaSql .= " LEFT JOIN solicitud_necesidad sl ON sl.id_sol_necesidad=oc.solicitud_necesidad";
                $cadenaSql .= " WHERE cns.estado_registro=TRUE ";
                $cadenaSql .= " AND sl.id_sol_necesidad= '" . $variable . "';";

                break;

            case 'registrar_contratista' :
                $cadenaSql = " INSERT INTO contratista( primer_nombre, segundo_nombre, ";
                $cadenaSql .= " primer_apellido,segundo_apellido, direccion, telefono, digito_verificacion, correo, ";
                $cadenaSql .= " identificacion, genero, tipo_naturaleza, tipo_documento,";
                $cadenaSql .= " fecha_registro, nacionalidad, perfil, profesion, ";
                $cadenaSql .= " especialidad)";
                $cadenaSql .= " VALUES ('" . $variable ['primer_nombre'] . "',";
                $cadenaSql .= " '" . $variable ['segundo_nombre'] . "',";
                $cadenaSql .= " '" . $variable ['primer_apellido'] . "',";
                $cadenaSql .= " '" . $variable ['segundo_apellido'] . "', ";
                $cadenaSql .= " '" . $variable ['direccion'] . "',";
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
                $cadenaSql .= " '" . $variable ['especialidad'] . "') RETURNING id_contratista ;";

                break;

            case 'registrar_contrato' :

                $cadenaSql = " INSERT INTO contrato(vigencia, numero_contrato, fecha_sub, plazo_ejecucion, ";
                $cadenaSql .= " fecha_inicio, fecha_final, valor_moneda_ext, valor_tasa_cb, fecha_sub_super, ";
                $cadenaSql .= " fecha_lim_ejec, observacion_inter, observacion_contr, solicitud_necesidad, ";
                $cadenaSql .= " contratista, tipologia_contrato, tipo_configuracion, clase_contratista, ";
                $cadenaSql .= " clase_contrato, clase_compromiso, numero_constancia, unidad_ejecucion_tiempo, ";
                $cadenaSql .= " modalidad_seleccion, procedimiento, regimen_contratacion, tipo_moneda, ";
                $cadenaSql .= " tipo_gasto, origen_recursos, origen_presupuesto, tema_corr_gst_inv, ";
                $cadenaSql .= " tipo_control_ejecucion, orden_contrato, fecha_registro)";
                $cadenaSql .= " VALUES ('" . $variable ['vigencia'] . "',";
                $cadenaSql .= " '" . $variable ['numero_contrato'] . "',";
                $cadenaSql .= " '" . $variable ['fecha_subcripcion'] . "',";
                $cadenaSql .= " '" . $variable ['plazo_ejecucion'] . "',";
                $cadenaSql .= " '" . $variable ['fecha_inicio_poliza'] . "',";
                $cadenaSql .= " '" . $variable ['fecha_final_poliza'] . "',";
                $cadenaSql .= " '" . $variable ['valor_contrato_moneda_ex'] . "',";
                $cadenaSql .= " '" . $variable ['tasa_cambio'] . "',";
                $cadenaSql .= " '" . $variable ['fecha_suscrip_super'] . "',";
                $cadenaSql .= " '" . $variable ['fecha_limite'] . "',";
                $cadenaSql .= " '" . $variable ['observaciones_interventoria'] . "',";
                $cadenaSql .= " '" . $variable ['observacionesContrato'] . "',";
                $cadenaSql .= " '" . $variable ['solicitud_necesidad'] . "',";
                $cadenaSql .= " '" . $variable ['contratista'] . "',";
                $cadenaSql .= " '" . $variable ['tipologia_especifica'] . "',";
                $cadenaSql .= " '" . $variable ['tipo_configuracion'] . "',";
                $cadenaSql .= " '" . $variable ['clase_contratista'] . "',";
                $cadenaSql .= " '" . $variable ['clase_contrato'] . "',";
                $cadenaSql .= " '" . $variable ['tipo_compromiso'] . "',";
                $cadenaSql .= " '" . $variable ['numero_constancia'] . "',";
                $cadenaSql .= " '" . $variable ['unidad_ejecucion_tiempo'] . "',";
                $cadenaSql .= " '" . $variable ['modalidad_seleccion'] . "',";
                $cadenaSql .= " '" . $variable ['procedimiento'] . "',";
                $cadenaSql .= " '" . $variable ['regimen_contratación'] . "',";
                $cadenaSql .= " '" . $variable ['tipo_moneda'] . "',";
                $cadenaSql .= " '" . $variable ['tipo_gasto'] . "',";
                $cadenaSql .= " '" . $variable ['origen_recursos'] . "',";
                $cadenaSql .= " '" . $variable ['origen_presupuesto'] . "',";
                $cadenaSql .= " '" . $variable ['tema_gasto_inversion'] . "',";
                $cadenaSql .= " '" . $variable ['tipo_control'] . "',";
                $cadenaSql .= " '" . $variable ['orden_contrato'] . "',";
                $cadenaSql .= " '" . $variable ['fecha_registro'] . "');";
                break;

            case 'consultar_supervisores' :

                $cadenaSql = " SELECT DISTINCT id_funcionario identificador, identificacion||' - ' ||nombre_cp supervisor";
                $cadenaSql .= " FROM funcionario";
                $cadenaSql .= " WHERE estado_registro=TRUE";

                break;

            /*
             * CONSULTA CONTRATO
             *
             */

           case 'buscar_contrato' :
                $cadenaSql = " SELECT  numero_contrato||' - ('||vigencia||')' AS  value, id_contrato_normal  AS data  ";
                $cadenaSql .= " FROM contrato ";
                $cadenaSql .= "WHERE cast(numero_contrato as text) ILIKE '%" . $variable . "%' ";
                $cadenaSql .= "OR cast(vigencia as text ) ILIKE '%" . $variable . "%' LIMIT 10; ";
                break;

            case 'buscar_contratista' :
                $cadenaSql = " SELECT  identificacion||' - '||nombre_razon_social AS value ,id_contratista  AS data  ";
                $cadenaSql .= " FROM contratista ";
                $cadenaSql .= "WHERE cast(identificacion as text) ILIKE '%" . $variable . "%' ";
                $cadenaSql .= "OR cast(nombre_razon_social as text ) ILIKE '%" . $variable . "%' LIMIT 10; ";
                break;
            
            case 'buscar_disponibilidad' :
                $cadenaSql = " SELECT id_disponibilidad as id, numero_disp as descripcion ";
                $cadenaSql.= "FROM contractual.disponibilidad_presupuestal dis ";
                $cadenaSql.= "JOIN contractual.solicitud_necesidad sol ON sol.id_sol_necesidad=dis.solicitud_necesidad ";
                $cadenaSql.= "WHERE dis.vigencia=" . $variable['valor'] . " ";
                $cadenaSql.= "AND dis.estado_registro=TRUE ";
                $cadenaSql.= "AND unidad_ejecutora=" . $variable['valor2'] . " ";
                break;
            
            case 'buscar_disponibilidades' :
                $cadenaSql = "SELECT DISTINCT id_disponibilidad as id, numero_disp as descripcion ";
                $cadenaSql.= "FROM \"SICapital\".disponibilidad_presupuestal dp, \"SICapital\".solicitud_diponibilidad sd,  ";
                $cadenaSql.= "\"SICapital\".solicitud_necesidad sn   ";
                $cadenaSql.= "WHERE dp.vigencia=" . $variable['valor'] . " ";
                $cadenaSql.= "AND sn.id_sol_necesidad= sd.solicitud_necesidad ";
                $cadenaSql.= "AND sd.disponibilidad_presupuestal= dp.id_disponibilidad ";
                $cadenaSql.= "AND dp.estado_registro=TRUE ";
                $cadenaSql.= "AND unidad_ejecutora=" . $variable['valor2'] . " ";
                break;
            
            
            case 'buscar_registro' :
                $cadenaSql = " SELECT id_registro_pres as id, numero_registro as descripcion ";
                $cadenaSql.= " FROM \"SICapital\".disponibilidad_presupuestal dis ";
                $cadenaSql.= " JOIN \"SICapital\".registro_presupuestal reg ON reg.disponibilidad_presupuestal=dis.id_disponibilidad";
                $cadenaSql.= " WHERE dis.estado_registro=TRUE ";
                $cadenaSql.= " AND id_disponibilidad=" . $variable . " ";
                break;

            case "unidad_ejecutora_gasto" :

                $cadenaSql = "SELECT id_parametro  id, pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='unidad_ejecutora_gasto' ORDER BY id_parametro DESC ; ";
                break;

            case "consultarContrato" :

                $cadenaSql = " SELECT c.numero_contrato, c.vigencia, c.id_contrato_normal, ";
                $cadenaSql .= " cg.id_orden_contrato, ";
                $cadenaSql .= " ct.identificacion || '-'|| ct.nombre_razon_social as contratista, ";
                $cadenaSql .= " oc.solicitud_necesidad, p.descripcion,ct.id_contratista  ";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " contractual.contrato c, contractual.contrato_general cg, ";
                $cadenaSql .= " contractual.contratista ct, \"SICapital\".orden_contrato oc, ";
                $cadenaSql .= " contractual.parametros p ";
                $cadenaSql .= " WHERE ";
                $cadenaSql .= " p.id_parametro=cg.tipo_contrato and ";
                $cadenaSql .= " c.numero_contrato=cg.numero_contrato and ";
                $cadenaSql .= " c.vigencia=cg.vigencia and ";
                $cadenaSql .= " oc.id_orden_contr = cg.id_orden_contrato and ";
                $cadenaSql .= " oc.contratista=ct.id_contratista ";
                if ($variable ['id_contrato'] != '') {
                    $cadenaSql .= " AND c.id_contrato_normal='" . $variable ['id_contrato'] . "' ";
                }
                if ($variable ['clase_contrato'] != '') {
                    $cadenaSql .= " AND cg.tipo_contrato='" . $variable ['clase_contrato'] . "' ";
                }
                if ($variable ['id_contratista'] != '') {
                    $cadenaSql .= " AND ct.id_contratista='" . $variable ['id_contratista'] . "' ";
                }
                if ($variable ['unidad_ejecutora'] != '') {
                    $cadenaSql .= " AND cg.unidad_ejecutora='" . $variable ['unidad_ejecutora'] . "' ";
                }
                if ($variable ['vigencia'] != '') {
                    $cadenaSql .= " AND c.vigencia='" . $variable ['vigencia'] . "' ";
                }
                $cadenaSql .= " ;  ";
                break;

            case 'Consultar_Contrato_Particular' :
                $cadenaSql = " SELECT  c.vigencia,c.numero_contrato, ct.identificacion || '-'|| ct.nombre_razon_social as contratista, ";
                $cadenaSql .= " c.fecha_sub,cg.fecha_final,c.valor_contrato,cg.plazo_ejecucion ";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " contractual.contrato c, contractual.contrato_general cg, ";
                $cadenaSql .= " contractual.contratista ct, \"SICapital\".orden_contrato oc, ";
                $cadenaSql .= " contractual.parametros p ";
                $cadenaSql .= " WHERE ";
                $cadenaSql .= " p.id_parametro=cg.tipo_contrato and ";
                $cadenaSql .= " c.numero_contrato=cg.numero_contrato and ";
                $cadenaSql .= " c.vigencia=cg.vigencia and ";
                $cadenaSql .= " oc.id_orden_contr = cg.id_orden_contrato and ";
                $cadenaSql .= " oc.contratista=ct.id_contratista and ";
                $cadenaSql .= " c.estado_registro=TRUE and cg.numero_contrato=".$variable['numero_contrato']." and ";
                $cadenaSql .= " cg.vigencia=".$variable['vigencia'].";";
                break;

            case 'registroNovedad':
                $cadenaSql = "  INSERT INTO contractual.registro_novedad( ";
                $cadenaSql.= " id_contrato,  ";
                $cadenaSql.= " tipo_novedad, ";
                $cadenaSql.= " fecha_novedad,  ";
                $cadenaSql.= " numero_acto, ";
                $cadenaSql.= " dias_suspension,  ";
                $cadenaSql.= " observaciones, ";
                $cadenaSql.= " ruta_documento )VALUES ( ";
                $cadenaSql.= " '" . $variable['id_contrato'] . "', ";
                $cadenaSql.= " '" . $variable['tipo_novedad'] . "', ";
                $cadenaSql.= " '" . $variable['fecha_novedad'] . "', ";
                $cadenaSql.= " '" . $variable['numero_acto'] . "', ";
                $cadenaSql.= " '" . $variable['diasSuspension'] . "', ";
                $cadenaSql.= " '" . $variable['observaciones'] . "', ";
                $cadenaSql.= " '" . $variable['ruta_documento'] . "'); ";
                break;
        }
        return $cadenaSql;
    }

}

?>
