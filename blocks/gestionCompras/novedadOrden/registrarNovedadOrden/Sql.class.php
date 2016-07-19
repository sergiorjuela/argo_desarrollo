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
                $cadenaSql .= "FROM contrato_general  ";

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

         
         
          

            case "tipologia_contrato" :

                $cadenaSql = "SELECT id_parametro  id,pr.codigo_contraloria|| ' - ' ||pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipologia_contrato'; ";
                break;

        
            case "tipo_novedad" :

                $cadenaSql = "SELECT id_parametro  id,pr.descripcion valor   ";
                $cadenaSql .= " FROM relacion_parametro rl ";
                $cadenaSql .= "JOIN parametros pr ON pr.rel_parametro=rl.id_rel_parametro ";
                $cadenaSql .= "WHERE rl.descripcion ='tipo_novedad'; ";
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

                $cadenaSql = " SELECT DISTINCT cg.vigencia, cg.numero_contrato, cg.contratista ||' - '||cg.nombre_contratista as contratista,  ";
                $cadenaSql .= " pr.descripcion, cg.numero_solicitud_necesidad, cg.numero_cdp, sede.\"ESF_SEDE\" ,  ";
                $cadenaSql .= " dependencia.\"ESF_DEP_ENCARGADA\" FROM ";
                $cadenaSql .= " contractual.contrato_general cg, contractual.parametros pr, \"SICapital\".\"sedes_SIC\" sede, ";
                $cadenaSql .= " \"SICapital\".\"dependencia_SIC\" dependencia ";
                $cadenaSql .= " WHERE cg.unidad_ejecutora = CAST(pr.id_parametro as text) and ";
                $cadenaSql .= " sede.\"ESF_ID_SEDE\" = cg.sede_solicitante  and ";
                $cadenaSql .= " dependencia.\"ESF_CODIGO_DEP\" = cg.dependencia_solicitante  and ";
                $cadenaSql .= " cg.numero_contrato=" .$variable['numero_contrato'] ." and ";
                $cadenaSql .= " cg.vigencia = ".$variable['vigencia']. " ; ";

                break;
            
            case 'registroNovedad':
                $cadenaSql = "  INSERT INTO registro_novedad( ";
                $cadenaSql.= " numero_contrato,  ";
                $cadenaSql.= " vigencia,  ";
                $cadenaSql.= " tipo_novedad, ";
                $cadenaSql.= " fecha_novedad,  ";
                $cadenaSql.= " numero_acto, ";
                $cadenaSql.= " dias_suspension,  ";
                $cadenaSql.= " observaciones, ";
                $cadenaSql.= " ruta_documento )VALUES ( ";
                $cadenaSql.=  $variable['numero_contrato'] . ", ";
                $cadenaSql.=  $variable['vigencia'] . ", ";
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
