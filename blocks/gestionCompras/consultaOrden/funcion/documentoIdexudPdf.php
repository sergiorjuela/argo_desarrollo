<?php

$ruta = $this->miConfigurador->getVariableConfiguracion("raizDocumento");

$host = $this->miConfigurador->getVariableConfiguracion("host") . $this->miConfigurador->getVariableConfiguracion("site") . "/plugin/html2pfd/";

include ($ruta . "/plugin/html2pdf/html2pdf.class.php");

if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

class EnLetras {

    var $Void = "";
    var $SP = " ";
    var $Dot = ".";
    var $Zero = "0";
    var $Neg = "Menos";

    function ValorEnLetras($x, $Moneda) {
        $s = "";
        $Ent = "";
        $Frc = "";
        $Signo = "";

        if (floatVal($x) < 0)
            $Signo = $this->Neg . " ";
        else
            $Signo = "";

        if (intval(number_format($x, 2, '.', '')) != $x) // <- averiguar si tiene decimales
            $s = number_format($x, 2, '.', '');
        else
            $s = number_format($x, 0, '.', '');

        $Pto = strpos($s, $this->Dot);

        if ($Pto === false) {
            $Ent = $s;
            $Frc = $this->Void;
        } else {
            $Ent = substr($s, 0, $Pto);
            $Frc = substr($s, $Pto + 1);
        }

        if ($Ent == $this->Zero || $Ent == $this->Void)
            $s = "Cero ";
        elseif (strlen($Ent) > 7) {
            $s = $this->SubValLetra(intval(substr($Ent, 0, strlen($Ent) - 6))) . "Millones " . $this->SubValLetra(intval(substr($Ent, - 6, 6)));
        } else {
            $s = $this->SubValLetra(intval($Ent));
        }

        if (substr($s, - 9, 9) == "Millones " || substr($s, - 7, 7) == "Millón ")
            $s = $s . "de ";

        $s = $s . $Moneda;

        if ($Frc != $this->Void) {
            $s = $s . " Con " . $this->SubValLetra(intval($Frc)) . "Centavos";
            // $s = $s . " " . $Frc . "/100";
        }
        return ($Signo . $s . "");
    }

    function SubValLetra($numero) {
        $Ptr = "";
        $n = 0;
        $i = 0;
        $x = "";
        $Rtn = "";
        $Tem = "";

        $x = trim("$numero");
        $n = strlen($x);

        $Tem = $this->Void;
        $i = $n;

        while ($i > 0) {
            $Tem = $this->Parte(intval(substr($x, $n - $i, 1) . str_repeat($this->Zero, $i - 1)));
            If ($Tem != "Cero")
                $Rtn .= $Tem . $this->SP;
            $i = $i - 1;
        }

        // --------------------- GoSub FiltroMil ------------------------------
        $Rtn = str_replace(" Mil Mil", " Un Mil", $Rtn);
        while (1) {
            $Ptr = strpos($Rtn, "Mil ");
            If (!($Ptr === false)) {
                If (!(strpos($Rtn, "Mil ", $Ptr + 1) === false))
                    $this->ReplaceStringFrom($Rtn, "Mil ", "", $Ptr);
                else
                    break;
            } else
                break;
        }

        // --------------------- GoSub FiltroCiento ------------------------------
        $Ptr = - 1;
        do {
            $Ptr = strpos($Rtn, "Cien ", $Ptr + 1);
            if (!($Ptr === false)) {
                $Tem = substr($Rtn, $Ptr + 5, 1);
                if ($Tem == "M" || $Tem == $this->Void)
                    ;
                else
                    $this->ReplaceStringFrom($Rtn, "Cien", "Ciento", $Ptr);
            }
        } while (!($Ptr === false));

        // --------------------- FiltroEspeciales ------------------------------
        $Rtn = str_replace("Diez Un", "Once", $Rtn);
        $Rtn = str_replace("Diez Dos", "Doce", $Rtn);
        $Rtn = str_replace("Diez Tres", "Trece", $Rtn);
        $Rtn = str_replace("Diez Cuatro", "Catorce", $Rtn);
        $Rtn = str_replace("Diez Cinco", "Quince", $Rtn);
        $Rtn = str_replace("Diez Seis", "Dieciseis", $Rtn);
        $Rtn = str_replace("Diez Siete", "Diecisiete", $Rtn);
        $Rtn = str_replace("Diez Ocho", "Dieciocho", $Rtn);
        $Rtn = str_replace("Diez Nueve", "Diecinueve", $Rtn);
        $Rtn = str_replace("Veinte Un", "Veintiun", $Rtn);
        $Rtn = str_replace("Veinte Dos", "Veintidos", $Rtn);
        $Rtn = str_replace("Veinte Tres", "Veintitres", $Rtn);
        $Rtn = str_replace("Veinte Cuatro", "Veinticuatro", $Rtn);
        $Rtn = str_replace("Veinte Cinco", "Veinticinco", $Rtn);
        $Rtn = str_replace("Veinte Seis", "Veintiseís", $Rtn);
        $Rtn = str_replace("Veinte Siete", "Veintisiete", $Rtn);
        $Rtn = str_replace("Veinte Ocho", "Veintiocho", $Rtn);
        $Rtn = str_replace("Veinte Nueve", "Veintinueve", $Rtn);

        // --------------------- FiltroUn ------------------------------
        If (substr($Rtn, 0, 1) == "M")
            $Rtn = "Un " . $Rtn;
        // --------------------- Adicionar Y ------------------------------
        for ($i = 65; $i <= 88; $i ++) {
            If ($i != 77)
                $Rtn = str_replace("a " . Chr($i), "* y " . Chr($i), $Rtn);
        }
        $Rtn = str_replace("*", "a", $Rtn);
        return ($Rtn);
    }

    function ReplaceStringFrom(&$x, $OldWrd, $NewWrd, $Ptr) {
        $x = substr($x, 0, $Ptr) . $NewWrd . substr($x, strlen($OldWrd) + $Ptr);
    }

    function Parte($x) {
        $Rtn = '';
        $t = '';
        $i = '';
        Do {
            switch ($x) {
                Case 0 :
                    $t = "Cero";
                    break;
                Case 1 :
                    $t = "Un";
                    break;
                Case 2 :
                    $t = "Dos";
                    break;
                Case 3 :
                    $t = "Tres";
                    break;
                Case 4 :
                    $t = "Cuatro";
                    break;
                Case 5 :
                    $t = "Cinco";
                    break;
                Case 6 :
                    $t = "Seis";
                    break;
                Case 7 :
                    $t = "Siete";
                    break;
                Case 8 :
                    $t = "Ocho";
                    break;
                Case 9 :
                    $t = "Nueve";
                    break;
                Case 10 :
                    $t = "Diez";
                    break;
                Case 20 :
                    $t = "Veinte";
                    break;
                Case 30 :
                    $t = "Treinta";
                    break;
                Case 40 :
                    $t = "Cuarenta";
                    break;
                Case 50 :
                    $t = "Cincuenta";
                    break;
                Case 60 :
                    $t = "Sesenta";
                    break;
                Case 70 :
                    $t = "Setenta";
                    break;
                Case 80 :
                    $t = "Ochenta";
                    break;
                Case 90 :
                    $t = "Noventa";
                    break;
                Case 100 :
                    $t = "Cien";
                    break;
                Case 200 :
                    $t = "Doscientos";
                    break;
                Case 300 :
                    $t = "Trescientos";
                    break;
                Case 400 :
                    $t = "Cuatrocientos";
                    break;
                Case 500 :
                    $t = "Quinientos";
                    break;
                Case 600 :
                    $t = "Seiscientos";
                    break;
                Case 700 :
                    $t = "Setecientos";
                    break;
                Case 800 :
                    $t = "Ochocientos";
                    break;
                Case 900 :
                    $t = "Novecientos";
                    break;
                Case 1000 :
                    $t = "Mil";
                    break;
                Case 1000000 :
                    $t = "Millón";
                    break;
            }

            If ($t == $this->Void) {
                $i = $i + 1;
                $x = $x / 1000;
                If ($x == 0)
                    $i = 0;
            } else
                break;
        } while ($i != 0);

        $Rtn = $t;
        Switch ($i) {
            Case 0 :
                $t = $this->Void;
                break;
            Case 1 :
                $t = " Mil";
                break;
            Case 2 :
                $t = " Millones";
                break;
            Case 3 :
                $t = " Billones";
                break;
        }
        return ($Rtn . $t);
    }

}

class RegistradorOrden {

    var $miConfigurador;
    var $lenguaje;
    var $miFormulario;
    var $miFuncion;
    var $miSql;
    var $conexion;

    function __construct($lenguaje, $sql, $funcion) {
        $this->miConfigurador = \Configurador::singleton();
        $this->miConfigurador->fabricaConexiones->setRecursoDB('principal');
        $this->lenguaje = $lenguaje;
        $this->miSql = $sql;
        $this->miFuncion = $funcion;
    }

    function tipo_orden() {
        $conexion = "contractual";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        $cadenaSql = $this->miSql->getCadenaSql('consultarOrdenDocumento', $_REQUEST ['id_orden']);

        $orden = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        // var_dump ( $orden );
        $orden = $orden [0];

        $tipo_orden = $orden['tipo_orden'] . " - " . $orden ['numero_contrato'];

        return $tipo_orden;
    }

    function documento() {

        $conexion = "contractual";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        $conexionSICA = "sicapital";
        $DBSICA = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionSICA);

        $directorio = $this->miConfigurador->getVariableConfiguracion('rutaUrlBloque');

        $cadenaSql = $this->miSql->getCadenaSql('consultarOrdenDocumento', $_REQUEST ['id_orden']);


        $orden = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
       
        $orden = $orden [0];
       

        $cadenaSql = $this->miSql->getCadenaSql('consultarInformaciónDisponibilidad', $_REQUEST ['id_orden']);

        $infDisponibilidad = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        
        $sqlParametorUnidadTiempo=$this->miSql->getCadenaSql('consultarParametroUnidadTiempoEjecucion', $orden['unidad_ejecucion']);
        $parametorUnidadTiempo = $esteRecursoDB->ejecutarAcceso($sqlParametorUnidadTiempo, "busqueda");

        //$cadenaSql = $this->miSql->getCadenaSql('consultarInformaciónRegistro', $_REQUEST ['id_orden']);
        //$inRegistro = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        $inRegistro = false;
        $cadenaSql = $this->miSql->getCadenaSql('consultarSupervisorDocumento', $orden ['supervisor']);
        $supervisor = $DBSICA->ejecutarAcceso($cadenaSql, "busqueda");
        $supervisor = $supervisor [0];
        

        //-------------- Se accede al Servicio de Agora para Consultar el Proveedor de la Orden de Compra -------------------------------------------------------------------


        $parametro = $orden ['contratista'];

        $enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
        $url = "http://10.20.2.38/agora/index.php?";
        $data = "pagina=servicio&servicios=true&servicio=servicioArgoProveedor&parametro1=$parametro";
        $url_servicio = $url . $this->miConfigurador->fabricaConexiones->crypto->codificar_url($data, $enlace);
        $cliente = curl_init();
        curl_setopt($cliente, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($cliente, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cliente, CURLOPT_URL, $url_servicio);
        $repuestaWeb = curl_exec($cliente);
        curl_close($cliente);
        $repuestaWeb = explode("<json>", $repuestaWeb);
        $proveedor = json_decode($repuestaWeb[1]);
        $proveedor = (array) $proveedor;
        $proveedor = (array) $proveedor['datos'];

        if ($proveedor['tipo_persona'] == 'NATURAL') {
            $identificacionProveedor = utf8_decode($proveedor['tipo_documento_persona_natural']) . ": " . $proveedor['num_documento_persona_natural'];
            $nombreProveedor = "Nombre Proveedor: " . $proveedor['primer_nombre_persona_natural'] . " " . $proveedor['segundo_nombre_persona_natural'] . " " .
                    $proveedor['primer_apellido_persona_natural'] . " " . $proveedor['segundo_nombre_persona_natural'];

            $telefonosProveedor = $proveedor['telefono_persona_natural'] . "-" . $proveedor['movil_persona_natural'];
            $cargoProveedor = $proveedor['cargo_persona_natural'];
        } else {
            $identificacionProveedor = "NIT: " . $proveedor['num_nit_empresa'];
            $nombreProveedor = "Razon Social: " . $proveedor['nom_empresa'];
            $telefonosProveedor = $proveedor['telefono_empresa'] . "-" . $proveedor['movil_empresa'];
            $cargoProveedor = "N/A";
        }
        $direccionProveedor = $proveedor['dir_contacto'];

//----------------------------------------------------------------------------------------------------------------------------------------------------------------               

        $cadenaSql = $this->miSql->getCadenaSql('polizasDocumento', $_REQUEST ['id_orden']);
        $polizas = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");


        $cadenaSql = $this->miSql->getCadenaSql('ordenadorDocumento', $orden ['ordenador_gasto']);
        $ordenador = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        $ordenador = $ordenador [0];

        $cadenaSql = $this->miSql->getCadenaSql('consultarElementosOrden', $_REQUEST ['id_orden']);
        $ElementosOrden = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

        $datos = array(
            $orden['numero_contrato'],
            $orden['vigencia']
        );

        $cadenaSql = $this->miSql->getCadenaSql('consultarServiciosOrden', $datos);
        $ServiciosOrden = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");



        $cadenaSql = $this->miSql->getCadenaSql('consultarFormadePago', $orden ['forma_pago']);
        $formaPago = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        $formaPago = $formaPago[0][0];

        if ($orden['unidad_ejecutora'] == '2') {
            $cadenaSql = $this->miSql->getCadenaSql('consultarConvenioDocumento', $orden ['convenio_solicitante']);
            $dependencia = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
            $dependencia = $dependencia[0][0];
            $sede = $orden['sede_solicitante'];
        } else {
            $cadenaSql = $this->miSql->getCadenaSql('consultarSede', 'FICC');
            $sede = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
            $sede = $sede[0][0];
            $cadenaSql = $this->miSql->getCadenaSql('consultarDependencia', 'OTR35');
            $dependencia = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
            $dependencia = $dependencia[0][0];
        }


        $datosContrato = array(
            0 => $orden ['numero_contrato'],
            1 => $orden ['vigencia']
        );

        $sqlAdicionesPresupuesto = $this->miSql->getCadenaSql('consultarAdcionesPresupuesto', $datosContrato);
        $adicionesPresupuesto = $esteRecursoDB->ejecutarAcceso($sqlAdicionesPresupuesto, "busqueda");


        $sqlAdicionesTiempo = $this->miSql->getCadenaSql('consultarAdcionesTiempo', $datosContrato);
        $adicionesTiempo = $esteRecursoDB->ejecutarAcceso($sqlAdicionesTiempo, "busqueda");

        $sqlAdicionesAnulaciones = $this->miSql->getCadenaSql('consultarAnulaciones', $datosContrato);
        $anulaciones = $esteRecursoDB->ejecutarAcceso($sqlAdicionesAnulaciones, "busqueda");

        $sqlAdicionesSuspension = $this->miSql->getCadenaSql('consultarSuspensiones', $datosContrato);
        $suspensiones = $esteRecursoDB->ejecutarAcceso($sqlAdicionesSuspension, "busqueda");

        $sqlCesiones = $this->miSql->getCadenaSql('consultaCesiones', $datosContrato);
        $cesiones = $esteRecursoDB->ejecutarAcceso($sqlCesiones, "busqueda");

        $sqlCambiosSupervisor = $this->miSql->getCadenaSql('ConsultacambioSupervisor', $datosContrato);
        $cambioSupervisor = $esteRecursoDB->ejecutarAcceso($sqlCambiosSupervisor, "busqueda");

        $sqlOtras = $this->miSql->getCadenaSql('ConsultaOtras', $datosContrato);
        $otras = $esteRecursoDB->ejecutarAcceso($sqlOtras, "busqueda");

        
        $contenidoPagina = "
<style type=\"text/css\">
    table { 
        color:#333; /* Lighten up font color */
        font-family:Helvetica, Arial, sans-serif; /* Nicer font */
		
        border-collapse:collapse; border-spacing: 0px; 
    }

    td, th { 
        border: 1px solid #585858; 
        height: 13px;
    } /* Make cells a bit taller */

	col{
	width=50%;
	
	}			
				
    th {
        background: #F3F3F3; /* Light grey background */
        font-weight: bold; /* Make sure they're bold */
        text-align: center;
        font-size:10px
    }

    td {
        background: #FAFAFA; /* Lighter grey background */
        text-align: left;
        font-size:10px;
        
    }    
    
    td.especial1 {
         border-top: 0px;
         border-bottom: 0px;
         border-right: 0px;
    }
    td.especial2 {
         border-top: 0px;
         border-bottom: 0px;
         border-left: 0px;
    }
    td.especial3 {
         border-top: 0px;
         border-right: 0px;
    }
    td.especial4 {
         border-top: 0px;
         border-left: 0px;
    }
    td.especial5 {
         border-bottom: 0px;
         border-right: 0px;
    }
    td.especial6 {
         border-bottom: 0px;
         border-left: 0px;
    }
    td.especial7 {
         border-bottom: 0px;
         border-left: 0px;
         border-right: 0px;
         border-top: 0px;
    }



</style>				
				
				
<page backtop='5mm' backbottom='5mm' backleft='10mm' backright='10mm'>
	

        <table class='especial' align='center' style='width:100%;' >
            <tr style='width:100%;'>
         
                <td align='center' style='width:20%;'  >
                    <img src='" . $directorio . "/css/images/escudoIdexud.png'  width='80' height='100'>
                </td>
              
                <td align='left' style='width:80%;'>
                   <table class='especial' align='center' style='width:100%; '>
                    <tr>
                        <td class='especial4' align='center' style='width:60%; height:300%;'>SISTEMA DE GESTIÓN</td>
                        <td class='especial3' align='center' style='width:40%; height:280%;'>Codigo: EPS-FR-051</td>
                    </tr>
                    <tr>
                        <td class='especial6' align='center' style='width:60%; height:280%;'>FORMATO SOLICITUD ORDEN DE COMPRA Y/O <br>SERVICIO</td>
                        <td class='especial5' align='center' style='width:39%; height:280%;'>
                        <table class='especial' align='center' style='width:100%;border-top: 0; border-bottom: 0; border-left: 0;border-right: 0;'>
                        <tr>
                        <td class='especial2' align='center'   style='width:50.3%; height:100%;' >Versión: 2</td>
                        <td  class='especial1' align='center'   style='width:50.3%; height:100%;' >Vigencia: " . $orden['vigencia'] . "</td>
                        </tr>
                        </table>
                        
                        </td>
                    </tr>
                   </table>
                   
                </td>
                </tr>
        </table>
      	<table style='width:100%;'>
			<tr> 
			<td  bgcolor='#BDBDBD' align='center' style='width:100%;'><b>INFORMACIÓN DEL SOLICITANTE Y DIRECTO RESPONSABLE</b></td>
			</tr>
         	    </table>


		    <table style='width:100%;'>
			<tr> 
			<td align='center' style='width:60%;'> Numero de Orden: " . $orden['numero_contrato'] . " Vigencia: " . $orden['vigencia'] . "</td>
			<td align='center' style='width:10%;'>Fecha</td>
			<td align='center' style='width:30%;'>" . date("Y-m-d") . "</td>
			</tr>
	           </table>			
		    <table style='width:100%;'>
			<tr> 
			<td align='center' style='width:30%;'>Convenio Solicitante</td>
			<td align='center' style='width:70%;'>" . $dependencia . "</td>
			</tr>
	           </table>			
		    <table style='width:100%;'>
			<tr> 
			<td align='center' style='width:30%;'>Nombre del Director</td>
			<td align='center' style='width:30%;'></td>
			<td align='center' style='width:20%;'>Cedula N°</td>
			<td align='center' style='width:20%;'></td>
			</tr>
         	    </table>
		    <table style='width:100%;'>
			<tr> 
			<td align='center' style='width:30%;'>Teléfono Fijo</td>
			<td align='center' style='width:30%;'></td>
			<td align='center' style='width:20%;'>Télefono móvil</td>
			<td align='center' style='width:20%;'></td>
			</tr>
         	    </table>
                     <table style='width:100%;'>
			<tr> 
			<td align='center' style='width:30%;'>Correo electrónico</td>
			<td align='center' style='width:70%;'></td>
			</tr>
	           </table>
		    <table style='width:100%;'>
			<tr> 
			<td align='center' style='width:30%;'>Nombre del Supervisor</td>
			<td align='center' style='width:30%;'>".$supervisor['FUN_NOMBRE']."</td>
			<td align='center' style='width:20%;'>Cedula N°</td>
			<td align='center' style='width:20%;'>".$supervisor['FUN_IDENTIFICACION']."</td>
			</tr>
         	    </table>
		    <table style='width:100%;'>
			<tr> 
			<td align='center' style='width:30%;'>Teléfono Fijo</td>
			<td align='center' style='width:30%;'></td>
			<td align='center' style='width:20%;'>Télefono móvil</td>
			<td align='center' style='width:20%;'></td>
			</tr>
         	    </table>
                     <table style='width:100%;'>
			<tr> 
			<td align='center' style='width:30%;'>Correo electrónico</td>
			<td align='center' style='width:70%;'></td>
			</tr>
	           </table>
                   
                   <table style='width:100%;'>
			<tr> 
			<td align='center' bgcolor='#BDBDBD'  style='width:100%;'>OBJETO DE LA COMPRA Y/0 SERVICIO</td>
			</tr>
			<tr> 
			<td align='justify' style='width:100%; height:10%;'>" . $orden['objeto_contrato'] . "</td>
			</tr>
                        <tr> 
			<td align='center' bgcolor='#BDBDBD' style='width:100%;'>1. JUSTIFICACIÓN DE LA COMPRA (Diligenciar este espacio en todos los casos)</td>
			</tr>
                        <tr> 
			<td align='center' style='width:100%; height:10%;'>".$orden['justificacion']."</td>
			</tr>
	           </table>";



        
        if ($ElementosOrden) {

            $contenidoPagina .= "<table style='width:100%;'>
			<tr> 
			<td align='center' bgcolor='#6E6E6E'  style='width:100%;'>COMPRAS</td>
			</tr>
		</table>
                   
                   <table style='width:100%;'>
			<tr> 
			<td align='center' style='width:40%;'>2. VALOR PRESUPUESTADO PARA ESTA COMPRA</td>
			<td align='center' style='width:60%;'>$ " . number_format($orden['valor_contrato'], 2, ",", ".") . "</td>
			</tr>
         	    </table>
                   ";

            $funcionLetras = new EnLetras ();

            $ValorLetras = $funcionLetras->ValorEnLetras($orden['valor_contrato'], ' Pesos ');

            $contenidoPagina .= "<table style='width:100%;'>
			<tr> 
			<td align='center' style='width:30%;'> ( EN LETRAS)</td>
			<td align='center' style='width:70%;'>$ValorLetras</td>
			</tr>
         	    </table>
                   <table style='width:100%;'>
			<tr> 
			<td align='center' style='width:100%;'> 3. DETALLE DE BIENES O ELEMENTOS A ADQUIRIR</td>
			</tr>
         	    </table>
                    <table style='width:100%;'>
			<tr> 
			<td align='center' bgcolor='#BDBDBD'  style='width:10%;'>ITEM</td>
			<td align='center' bgcolor='#BDBDBD'  style='width:20%;'> U/ MEDIDA*</td>
			<td align='center' bgcolor='#BDBDBD'  style='width:10%;'> CANT.</td>
			<td align='center' bgcolor='#BDBDBD'  style='width:30%;'> DESCRIPCIÓN DEL ARTICULO</td>
			<td align='center' bgcolor='#BDBDBD'  style='width:30%;'> RUBRO PRESUPUESTAL AFECTADO</td>
			</tr>
         	    </table>";


            $contenidoPagina .= "<table style='width:100%;'>";
            $j = 1;
            foreach ($ElementosOrden as $valor => $it) {
                $contenidoPagina .= "<tr>";
                $contenidoPagina .= "<td align='center'   style='width:10%;'>" . $j . "</td>";
                $contenidoPagina .= "<td align='center'   style='width:20%;'>" . $it ['unidad'] . "</td>";
                $contenidoPagina .= "<td align='center'   style='width:10%;'>" . $it ['cantidad'] . "</td>";
                $contenidoPagina .= "<td align='center'   style='width:30%;'>" . $it ['descripcion'] . "</td>";
                $contenidoPagina .= "<td align='center'   style='width:30%;'></td>";
                $contenidoPagina .= "</tr>";

//                $sumatoriaTotal = $sumatoriaTotal + $it ['total_iva_con'];
//                $sumatoriaSubtotal = $sumatoriaSubtotal + $it ['subtotal_sin_iva'];
//                $sumatoriaIva = $sumatoriaIva + $it ['total_iva'];
                $j ++;
            }
            $contenidoPagina .="
			    	    </table>   ";

            $contenidoPagina .="	    	                     
                    <table style='width:100%;'>
			<tr> 
			<td align='center' style='width:100%;'>*EJEMPLLO: GALON, RESMA, PAQUETEX.., CAJA, UNIDAD, ETC.</td>
                        </tr>
         	    </table>
                    <table style='width:100%;'>
			<tr> 
			<td align='center' style='width:100%; height:7%;' >PARA SOLICITAR EQUIPOS DE 
                        OFICINA SOLICITAMOS CONSULTAR LAS ESPECIFICACIONES TECNICAS REQUERIDAS POR EL 
                        COMITÉ DE INFORMATICA: PAGINA PRINCIPAL DE LA UNIVERSIDAD DISTRITAL-VICERRECTORIA 
                        ADMINISTRATIVA Y FINANCIERA-COMITÉS-VERSION ACTUALIZADA DE LA PROPUESTA DE CONFIGURACION 
                        DE EQUIPOS VIGENCIA 2010</td>
                        </tr>
         	    </table>
                    <table style='width:100%;'>
			<tr> 
			<td align='center' style='width:100%; height:5%;' >PERSONA A CARGO DE LOS BIENES DEVOLUTIVOS ( Diligencie solamente si se adquieren bienes 
                        devolutivos: ej: equipos de computo, scaner,impresoras, muebles de oficina.)</td>
                        </tr>
         	    </table>
                    <table style='width:100%;'>
			<tr> 
			<td align='center' style='width:50%;' >Persona a cargo de los bienes (Funcionario de planta)</td>
			<td align='center' style='width:50%;' ></td>
                        </tr>
         	    </table>
                    <table style='width:100%;'>
			<tr> 
			<td align='center' style='width:20%;' >Area</td>
			<td align='center' style='width:80%;' ></td>
                        </tr>
         	    </table>
                    <table style='width:100%;'>
			<tr> 
			<td align='center' style='width:20%;' >Cargo</td>
			<td align='center' style='width:40%;' ></td>
			<td align='center' style='width:20%;' >Cédula N°</td>
			<td align='center' style='width:20%;' ></td>
                        </tr>
         	    </table>
                    <table style='width:100%;'>
			<tr> 
			<td align='center' style='width:20%;' >Teléfono Fijo</td>
			<td align='center' style='width:30%;' ></td>
			<td align='center' style='width:20%;' >Telefóno móvil</td>
			<td align='center' style='width:30%;' ></td>
                        </tr>
         	    </table>
                    <table style='width:100%;'>
			<tr> 
			<td align='center' style='width:50%;' >E-Mail</td>
			<td align='center' style='width:50%;' ></td>
                        </tr>
         	    </table>
                    <table style='width:100%;'>
			<tr> 
			<td align='center' style='width:40%;' >Ubicación de los bienes devolutivos</td>
			<td align='center' style='width:60%;' ></td>
                        </tr>
         	    </table>";
        }




        if ($ServiciosOrden) {

            $contenidoPagina .= "<table style='width:100%;'>
			<tr> 
			<td align='center' bgcolor='#6E6E6E'  style='width:100%;'>SERVICIOS</td>
			</tr>
			</table>
                   
                   <table style='width:100%;'>
			<tr> 
			<td align='center' style='width:40%;'>2. VALOR PRESUPUESTADO PARA ESTA COMPRA</td>
			<td align='center' style='width:60%;'>$</td>
			</tr>
         	    </table>
                   
                   <table style='width:100%;'>
			<tr> 
			<td align='center' style='width:30%;'> ( EN LETRAS)</td>
			<td align='center' style='width:70%;'></td>
			</tr>
         	    </table>
                   <table style='width:100%;'>
			<tr> 
			<td align='center' style='width:100%;'> 3. DETALLE DE SERVICIOS A ADQUIRIR</td>
			</tr>
         	    </table>
                     <table style='width:100%;'>
			<tr> 
			<td align='center' bgcolor='#BDBDBD'  style='width:10%;'>ITEM</td>
			<td align='center' bgcolor='#BDBDBD'  style='width:20%;'> U/ MEDIDA*</td>
			<td align='center' bgcolor='#BDBDBD'  style='width:10%;'> CANT.</td>
			<td align='center' bgcolor='#BDBDBD'  style='width:30%;'> DESCRIPCIÓN DEL ARTICULO</td>
			<td align='center' bgcolor='#BDBDBD'  style='width:30%;'> RUBRO PRESUPUESTAL AFECTADO</td>
			</tr>
         	    </table>";
            $contenidoPagina .="<table style='width:100%;'>";

            $j = 1;
            foreach ($ServiciosOrden as $valor => $it) {
                $contenidoPagina .= "<tr>";
                $contenidoPagina .= "<td align='center'  style='width:10%;'>" . $j . "</td>";
                $contenidoPagina .= "<td align='center'  style='width:20%;'> N/A</td>";
                $contenidoPagina .= "<td align='center'  style='width:10%;'>1</td>";
                $contenidoPagina .= "<td align='center'   style='width:30%;'>" . $it ['descripcion'] . " (Tipo Servicio: " . $it ['nombre_tipo_servicio'] . ")</td>";
                $contenidoPagina .= "<td align='center'  style='width:30%;'></td>";
                $contenidoPagina .= "</tr>";

//                $sumatoriaTotal = $sumatoriaTotal + $it ['total_iva_con'];
//                $sumatoriaSubtotal = $sumatoriaSubtotal + $it ['subtotal_sin_iva'];
//                $sumatoriaIva = $sumatoriaIva + $it ['total_iva'];
                $j ++;
            }
            $contenidoPagina .= "</table> ";
        }

        $contenidoPagina .= "
                    
                    <table style='width:100%;'>
			<tr> 
			<td align='center' bgcolor='#BDBDBD' style='width:100%;'>CONDICIONES DE LA COMPRA O SERVICIO</td>
			
                        </tr>
         	    </table>
                    <table style='width:100%;'>
			<tr> 
			<td align='center'  style='width:100%;'>Explique de manera clara, detallada y concisa las condiciones</td>
		        </tr>
         	    </table>
                    <table style='width:100%;'>
			<tr> 
			<td align='center'  style='width:100%; height:7%;'> La duracion del contrato es: ".$orden['condiciones']."</td>
                        </tr>
         	    </table>
                    <table style='width:100%;'>
			<tr> 
			<td align='center' bgcolor='#BDBDBD' style='width:100%;'>DURACION DE LA COMPRA SERVICIO</td>
			
                        </tr>
         	    </table>
                    <table style='width:100%;'>
			<tr> 
			<td align='center'  style='width:100%;'>Explique de manera clara, detallada y concisa la duración</td>
		        </tr>
         	    </table>
                    <table style='width:100%;'>
			<tr> 
			<td align='center'  style='width:100%; height:7%;'> La duracion del contrato es: ".$orden['plazo_ejecucion']." ".$parametorUnidadTiempo[0][0]."</td>
                        </tr>
         	    </table>
                    <table style='width:100%;'>
			<tr> 
			<td align='center' bgcolor='#BDBDBD' style='width:100%;'>FORMA DE PAGO PARA COMPRAS O SERVICIOS</td>
			
                        </tr>
         	    </table>
                    <table style='width:100%;'>
			<tr> 
			<td align='center'  style='width:100%;'>Explique de manera clara, detallada y concisa la forma de pago</td>
		        </tr>
         	    </table>
                    <table style='width:100%;'>
			<tr> 
			<td align='center'  style='width:100%; height:7%;'>".$orden['descripcion_forma_pago']."</td>
                        </tr>
         	    </table>
                              

                    <br>
                    <table style='width:100%;'>
			<tr> 
			<td align='center'  style='width:20%; height:5%;'>FIRMA</td>
			<td align='center'  style='width:30%;'></td>
			<td align='center'  style='width:20%; height:5%;'>FIRMA</td>
			<td align='center'  style='width:30%;'></td>
                        </tr>
			
         	    </table>
                    
                    <table style='width:100%;'>
			<tr> 
			<td align='center'  style='width:20%; '>Nombre Completo</td>
			<td align='center'  style='width:30%;'></td>
			<td align='center'  style='width:20%; '>Nombre Completo</td>
			<td align='center'  style='width:30%;'>".$supervisor['FUN_NOMBRE']."</td>
                        </tr>
			
         	    </table>
                    
                    <table style='width:100%;'>
			<tr> 
			<td align='center'  style='width:20%; '>N° Cedula</td>
			<td align='center'  style='width:30%;'></td>
			<td align='center'  style='width:20%; '>N° Cedula</td>
			<td align='center'  style='width:30%;'>" . $supervisor['FUN_IDENTIFICACION'] . "</td>
                        </tr>
			
         	    </table>
                    <table style='width:100%;'>
			<tr> 
			<td align='center' bgcolor='#BDBDBD'  style='width:50%;'>FIRMA DEL DIRECTOR DEL CONVENIO</td>
			<td align='center' bgcolor='#BDBDBD'  style='width:50%;'>FIRMA DEL SUPERVISOR</td>
                        </tr>
			
         	    </table>";




        $contenidoPagina .= "<page_footer  backleft='10mm' backright='10mm'>
				
				
		    <table style='width:100%;'>
			<tr>
			  <td class='especial7' align='center' style='width:100%;'  >
                            <img src='" . $directorio . "/css/images/escudopieIdexud.png'  width='200' height='80'>
                          </td>
			</tr>
			
		    </table>
							
				
											</page_footer> 
				</page>";

        // echo $contenidoPagina;exit;
        return $contenidoPagina;
    }

}

$miRegistrador = new RegistradorOrden($this->lenguaje, $this->sql, $this->funcion);

$textos = $miRegistrador->documento();
$tipo_orden = $miRegistrador->tipo_orden();

ob_start();
$html2pdf = new \HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8');
$html2pdf->pdf->SetDisplayMode('fullpage');
$html2pdf->WriteHTML($textos);

$html2pdf->Output($tipo_orden . '.pdf', 'D');
?>





