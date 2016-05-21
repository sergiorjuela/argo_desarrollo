<?php

namespace contratos\modificarContrato;

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
            case 'buscar_contrato' :
                $cadenaSql = " SELECT  numero_contrato AS  data, numero_contrato||' - ('||vigencia||')'  AS value  ";
                $cadenaSql .= " FROM contrato ";
                $cadenaSql .= "WHERE cast(numero_contrato as text) LIKE '%" . $variable . "%' ";
                $cadenaSql .= "OR cast(vigencia as text ) LIKE '%" . $variable . "%' LIMIT 10; ";
                break;

//------------------------------------SQL SIN USO-------------            
            case "buscarUsuario" :
                $cadenaSql = "SELECT ";
                $cadenaSql .= "FECHA_CREACION, ";
                $cadenaSql .= "PRIMER_NOMBRE ";
                $cadenaSql .= "FROM ";
                $cadenaSql .= "USUARIOS ";
                $cadenaSql .= "WHERE ";
                $cadenaSql .= "`PRIMER_NOMBRE` ='" . $variable . "' ";
                break;

            case "funcionarios" :

                $cadenaSql = "SELECT identificacion, identificacion ||' - '|| nombre_cp ";
                $cadenaSql .= "FROM \"SICapital\".\"funcionario\" ";
                $cadenaSql .= "WHERE estado='A' ";

                break;

            case "dependenciasConsultadas" :
                $cadenaSql = "SELECT DISTINCT  id_dependencia , \"ESF_DEP_ENCARGADA\" ";
                $cadenaSql .= " FROM \"SICapital\".\"dependencia_SIC\" ad ";
                $cadenaSql .= " JOIN  \"SICapital\".\"espaciosfisicos_SIC\" ef ON  ef.\"ESF_ID_ESPACIO\"=ad.\"ESF_ID_ESPACIO\" ";
                $cadenaSql .= " JOIN  \"SICapital\".\"sedes_SIC\" sa ON sa.\"ESF_COD_SEDE\"=ef.\"ESF_COD_SEDE\" ";
                $cadenaSql .= " WHERE ad.\"ESF_ESTADO\"='A'";

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

            case "obtenerInfoUsuario" :
                $cadenaSql = "SELECT u.dependencia_especifica ||' - '|| u.dependencia as nombre ";
                $cadenaSql .= "FROM frame_work.argo_usuario u  ";
                $cadenaSql .= "WHERE u.id_usuario='" . $variable . "' ";
                break;

            case "ordenadorGasto" :

                $cadenaSql = " 	SELECT f.\"identificacion\",p.descripcion ||' ('|| f.\"nombre_cp\" ||')' as ordenador";
                $cadenaSql .= " FROM \"SICapital\".\"funcionario\" f ,\"SICapital\".\"funcionario_tipo_ordenador\"  o, parametros p ";
                $cadenaSql .= " WHERE o.\"estado\"=True and f.\"identificacion\"= o.\"funcionario\" and p.id_parametro= o.\"tipo_ordenador\";";

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

                $cadenaSql = "SELECT DISTINCT vigencia , vigencia valor  ";
                $cadenaSql .= " FROM solicitud_necesidad  ";
                $cadenaSql .= "WHERE estado_registro=TRUE; ";

                break;

            case "ConsultarNumeroNecesidades" :

                $cadenaSql = "SELECT DISTINCT numero_solicitud id , numero_solicitud descripcion   ";
                $cadenaSql .= " FROM solicitud_necesidad  ";
                $cadenaSql .= "WHERE vigencia='" . $variable . "';";

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

            case "consultarSolicitud" :
                $cadenaSql = "SELECT DISTINCT ";
                $cadenaSql .= "id_sol_necesidad, vigencia, numero_solicitud, fecha_solicitud,
				               valor_contratacion, unidad_tiempo_ejecucion ||' '||descripcion duracion, objeto_contrato ";
                $cadenaSql .= "FROM solicitud_necesidad ";
                $cadenaSql .= "JOIN parametros pr ON pr.id_parametro = ejecucion   ";
                $cadenaSql .= "WHERE solicitud_necesidad.estado_registro= TRUE ";

                if ($variable ['vigencia'] != '') {
                    $cadenaSql .= " AND vigencia = '" . $variable ['vigencia'] . "' ";
                }
                if ($variable ['numero_solicitud'] != '') {
                    $cadenaSql .= " AND numero_solicitud = '" . $variable ['numero_solicitud'] . "' ";
                }

                if ($variable ['fecha_inicial'] != '') {
                    $cadenaSql .= " AND fecha_solicitud BETWEEN CAST ( '" . $variable ['fecha_inicial'] . "' AS DATE) ";
                    $cadenaSql .= " AND  CAST ( '" . $variable ['fecha_final'] . "' AS DATE)  ";
                }

                $cadenaSql .= " ; ";

                break;

            case "Consultar_Solicitud_Particular" :
                $cadenaSql = "SELECT DISTINCT ";
                $cadenaSql .= " *  ";
                $cadenaSql .= "FROM \"SICapital\".solicitud_necesidad sn ";
                $cadenaSql .= "WHERE sn.estado_registro= TRUE ";
                $cadenaSql .= " AND sn.id_sol_necesidad = '" . $variable . "' ;";

                break;

            case "Consultar_Disponibilidad" :
                $cadenaSql = "SELECT dp.id_disponibilidad, dp.numero_disp,dp.valor_disp, dp.vigencia,dp.fecha_disp  ";
                $cadenaSql .= " FROM \"SICapital\".solicitud_necesidad sn, ";
                $cadenaSql .= "\"SICapital\".disponibilidad_presupuestal dp,  ";
                $cadenaSql .= "\"SICapital\".solicitud_diponibilidad sd   ";
                $cadenaSql .= "WHERE sn.id_sol_necesidad = sd.solicitud_necesidad and ";
                $cadenaSql .= "dp.id_disponibilidad = sd.disponibilidad_presupuestal and ";
                $cadenaSql .= "dp.estado_registro=true and sn.id_sol_necesidad=" . $variable . ";";
                break;

            case "Consultar_Registro_Presupuestales" :
                $cadenaSql = " SELECT rp.id_registro_pres, rp.numero_registro, rp.valor_registro, rp.vigencia,rp.fecha_rgs_pr  ";
                $cadenaSql .= " FROM \"SICapital\".registro_presupuestal rp ";
                $cadenaSql .= " WHERE rp.estado_registro=true and rp.disponibilidad_presupuestal=$variable;";
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

            case "actualizarContratoGeneral" :
                $cadenaSql = " UPDATE contrato_general SET ";
                $cadenaSql .= "tipo_contrato=" . $variable ['tipo_contrato'] . ",";
                $cadenaSql .= "unidad_ejecutora=" . $variable ['unidad_ejecutura'] . ",";
                $cadenaSql .= "objeto_contrato=" . "'" . $variable ['objeto_contrato'] . "',";
                $cadenaSql .= "fecha_inicio=" . $variable ['fecha_inicio'] . ",";
                $cadenaSql .= "fecha_final=" . $variable ['fecha_fin'] . ",";
                $cadenaSql .= "plazo_ejecucion=" . $variable ['plazo_ejecucion'] . ",";
                $cadenaSql .= "forma_pago=" . $variable ['forma_pago'] . ",";
                $cadenaSql .= "ordenador_gasto=" . "'" . $variable ['ordenador_gasto'] . "',";
                $cadenaSql .= "supervisor=" . "'" . $variable ['supervisor'] . "',";
                $cadenaSql .= "clausula_registro_presupuestal=" . $variable ['clausula_presupuesto'] . ",";
                $cadenaSql .= "cargo_supervisor=" . "'" . $variable ['cargo_supervisor'] . "' ";
                $cadenaSql .= "WHERE numero_contrato=" . $variable ['numero_contrato'] . " and ";
                $cadenaSql .= "vigencia=" . $variable ['vigencia'] . " ; ";

                break;

            /*
             * CONSULTA CONTRATO
             *
             */

            case "forma_pago" :
                $cadenaSql = " 	SELECT id_parametro, descripcion ";
                $cadenaSql .= " FROM  parametros ";
                $cadenaSql .= " WHERE rel_parametro=28;";

                break;

            case 'buscar_contrato' :
                $cadenaSql = " SELECT  numero_contrato||' - ('||vigencia||')' AS  value, id_contrato  AS data  ";
                $cadenaSql .= " FROM contrato ";
                $cadenaSql .= "WHERE cast(numero_contrato as text) LIKE '%" . $variable . "%' ";
                $cadenaSql .= "OR cast(vigencia as text ) LIKE '%" . $variable . "%' LIMIT 10; ";
                break;

            case 'buscar_contratista' :
                $cadenaSql = " SELECT  identificacion||' - '||nombre_razon_social AS  value, identificacion  AS data  ";
                $cadenaSql .= " FROM contratista ";
                $cadenaSql .= "WHERE cast(identificacion as text) LIKE '%" . $variable . "%' ";
                $cadenaSql .= "OR cast(nombre_razon_social as text ) LIKE '%" . $variable . "%' LIMIT 10; ";
                break;

            case "unidad_ejecutora_gasto" :

                $cadenaSql = "SELECT id_parametro  id, pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='unidad_ejecutora_gasto' ORDER BY id_parametro DESC ; ";
                break;

            case "consultarContrato" :

                $cadenaSql = " SELECT c.numero_contrato, c.vigencia,  ";
                $cadenaSql .= " cg.id_orden_contrato, ";
                $cadenaSql .= " ct.identificacion || '-'|| ct.nombre_razon_social as contratista, ";
                $cadenaSql .= " oc.solicitud_necesidad  ";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " contractual.contrato c, contractual.contrato_general cg, ";
                $cadenaSql .= " contractual.contratista ct, \"SICapital\".orden_contrato oc ";
                $cadenaSql .= " WHERE ";
                $cadenaSql .= " c.numero_contrato=cg.numero_contrato and ";
                $cadenaSql .= " c.vigencia=cg.vigencia and ";
                $cadenaSql .= " oc.id_orden_contr = cg.id_orden_contrato and ";
                $cadenaSql .= " oc.contratista=ct.id_contratista ";
                if ($variable ['id_contrato'] != '') {
                    $cadenaSql .= " AND c.numero_contrato='" . $variable ['id_contrato'] . "' ";
                }
                if ($variable ['clase_contrato'] != '') {
                    $cadenaSql .= " AND cg.tipo_contrato='" . $variable ['clase_contrato'] . "' ";
                }
                if ($variable ['id_contratista'] != '') {
                    $cadenaSql .= " AND ct.identificacion='" . $variable ['id_contratista'] . "' ";
                }
                if ($variable ['unidad_ejecutora'] != '') {
                    $cadenaSql .= " AND cg.unidad_ejecutora='" . $variable ['unidad_ejecutora'] . "' ";
                }
                if ($variable ['fecha_inicial'] != '' && $variable ['fecha_final'] != '') {
                    $cadenaSql .= " AND c.fecha_registro BETWEEN CAST ( '" . $variable ['fecha_inicial'] . "' AS DATE) ";
                    $cadenaSql .= " AND CAST ( '" . $variable ['fecha_final'] . "' AS DATE) ";
                }
                $cadenaSql .= " ;  ";

                break;


            case 'Actualizar_Contrato' :

                $cadenaSql = " UPDATE contrato SET ";
                $cadenaSql .= " fecha_sub='" . $variable ['fecha_subcripcion'] . "',";
                $cadenaSql .= " valor_moneda_ext='" . $variable ['valor_contrato_moneda_ex'] . "',";
                $cadenaSql .= " valor_tasa_cb='" . $variable ['tasa_cambio'] . "',";
                $cadenaSql .= " fecha_sub_super='" . $variable ['fecha_suscrip_super'] . "',";
                $cadenaSql .= " fecha_lim_ejec='" . $variable ['fecha_limite'] . "',";
                $cadenaSql .= " observacion_inter='" . $variable ['observaciones_interventoria'] . "',";
                $cadenaSql .= " observacion_contr='" . $variable ['observacionesContrato'] . "',";
                $cadenaSql .= " tipologia_contrato='" . $variable ['tipologia_especifica'] . "',";
                $cadenaSql .= " tipo_configuracion='" . $variable ['tipo_configuracion'] . "',";
                $cadenaSql .= " clase_contratista='" . $variable ['clase_contratista'] . "',";
                $cadenaSql .= " clase_compromiso='" . $variable ['tipo_compromiso'] . "',";
                $cadenaSql .= " numero_constancia='" . $variable ['numero_constancia'] . "',";
                $cadenaSql .= " unidad_ejecucion_tiempo='" . $variable ['unidad_ejecucion_tiempo'] . "',";
                $cadenaSql .= " modalidad_seleccion='" . $variable ['modalidad_seleccion'] . "',";
                $cadenaSql .= " procedimiento='" . $variable ['procedimiento'] . "',";
                $cadenaSql .= " regimen_contratacion='" . $variable ['regimen_contratación'] . "',";
                $cadenaSql .= " tipo_moneda='" . $variable ['tipo_moneda'] . "',";
                $cadenaSql .= " tipo_gasto='" . $variable ['tipo_gasto'] . "',";
                $cadenaSql .= " origen_recursos='" . $variable ['origen_recursos'] . "',";
                $cadenaSql .= " origen_presupuesto='" . $variable ['origen_presupuesto'] . "',";
                $cadenaSql .= " tema_corr_gst_inv='" . $variable ['tema_gasto_inversion'] . "',";
                $cadenaSql .= " tipo_control_ejecucion='" . $variable ['tipo_control'] . "',";
                $cadenaSql .= " fecha_registro='" . $variable ['fecha_registro'] . "',";
                $cadenaSql .= " identificacion_clase_contratista='" . $variable ['identificacion_clase_contratista'] . "',";
                $cadenaSql .= " digito_verificacion_clase_contratista='" . $variable ['digito_verificacion_clase_contratista'] . "',";
                $cadenaSql .= "porcentaje_clase_contratista=" . $variable ['porcentaje_clase_contratista'] . ",";
                $cadenaSql .= "numero_convenio=" . $variable ['numero_convenio'] . ",";
                $cadenaSql .= "vigencia_convenio=" . $variable ['vigencia_convenio'] . ",";
                $cadenaSql .= "valor_contrato=" . $variable ['valor_contrato'] . ",";
                $cadenaSql .= "digito_verificacion_supervisor='" . $variable ['digito_supervisor'] . "' ";
                $cadenaSql .= "WHERE id_contrato_normal=" . $variable ['id_contrato_normal'] . ";";

                break;


            case 'Consultar_Contrato_Particular' :

                $cadenaSql = " SELECT  ";
                $cadenaSql .= " c.*,cg.tipo_contrato,cg.objeto_contrato,cg.fecha_inicio, ";
                $cadenaSql .= " cg.fecha_final,cg.plazo_ejecucion,cg.forma_pago,cg.ordenador_gasto, ";
                $cadenaSql .= " cg.supervisor,cg.clausula_registro_presupuestal,cg.cargo_supervisor ";
                $cadenaSql .= " FROM ";
                $cadenaSql .= " contractual.contrato c,contractual.contrato_general cg ";
                $cadenaSql .= " WHERE ";
                $cadenaSql .= " c.numero_contrato=cg.numero_contrato and ";
                $cadenaSql .= " c.vigencia = cg.vigencia and cg.numero_contrato= $variable[0] and ";
                $cadenaSql .= " c.vigencia = $variable[1] ; ";

                break;
            case 'Actualizar_Supervisor' :

                $cadenaSql = " UPDATE funcionario";
                $cadenaSql .= " SET codigo_verificacion='" . $variable ['digito_supervisor'] . "'";
                $cadenaSql .= " WHERE id_funcionario='" . $variable ['id_funcionario'] . "';";

                break;


            case 'Actualizar_Solicitud_necesidad' :

                $cadenaSql = " UPDATE solicitud_necesidad";
                $cadenaSql .= " SET valor_contratacion='" . $variable ['valor_contrato'] . "',";
                $cadenaSql .= " dependencia_destino='" . $variable ['dependencia'] . "',";
                $cadenaSql .= " objeto_contrato='" . $variable ['objeto_contrato'] . "'";
                $cadenaSql .= " WHERE id_sol_necesidad='" . $variable ['id_solicitud'] . "'";

                break;

            case 'insertarInformacionContratoTemporal' :

                $cadenaSql = "INSERT INTO ";
                $cadenaSql .= " contractual.temporal_contrato_edicion( ";
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
                $cadenaSql .= "contractual.temporal_contrato_edicion ";
                $cadenaSql .= "WHERE ";
                $cadenaSql .= "id_contrato_temp=" . $variable;

                break;
            case 'eliminarInfoTemporal' :

                $cadenaSql = "DELETE  FROM ";
                $cadenaSql .= "contractual.temporal_contrato_edicion ";
                $cadenaSql .= "WHERE ";
                $cadenaSql .= "id_contrato_temp=" . $variable;

                break;
            case "obtener_cargo_supervisro" :
                $cadenaSql = "SELECT cargo ";
                $cadenaSql .= "from \"SICapital\".funcionario  ";
                $cadenaSql .= "WHERE identificacion='" . $variable . "' ";
                break;



            case 'obtener_id_contratista' :

                $cadenaSql = "SELECT ";
                $cadenaSql .= "MAX(id_contratista) ";
                $cadenaSql .= "FROM ";
                $cadenaSql .= "contractual.contratista; ";
                break;

            case 'Consultar_info_Temporal' :

                $cadenaSql = "SELECT ";
                $cadenaSql .= "campo_formulario, ";
                $cadenaSql .= "informacion_campo ";
                $cadenaSql .= "FROM ";
                $cadenaSql .= "contractual.temporal_contrato_edicion ";
                $cadenaSql .= "WHERE ";
                $cadenaSql .= "id_contrato_temp=" . $variable;

                break;
        }
        return $cadenaSql;
    }

}

?>
