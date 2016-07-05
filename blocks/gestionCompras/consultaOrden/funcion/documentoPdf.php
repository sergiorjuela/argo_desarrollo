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

        $directorio = $this->miConfigurador->getVariableConfiguracion('rutaUrlBloque');

        $cadenaSql = $this->miSql->getCadenaSql('consultarOrdenDocumento', $_REQUEST ['id_orden']);


        $orden = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        // var_dump ( $orden );
        $orden = $orden [0];
        
        $cadenaSql = $this->miSql->getCadenaSql('consultarInformaciónDisponibilidad', $_REQUEST ['id_orden']);

        $infDisponibilidad = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        

        //$cadenaSql = $this->miSql->getCadenaSql('consultarInformaciónRegistro', $_REQUEST ['id_orden']);
        //$inRegistro = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        $inRegistro=false;
        $cadenaSql = $this->miSql->getCadenaSql('consultarSupervisor', $orden ['supervisor']);

        $supervisor = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        $supervisor = $supervisor [0];
        
        
        //-------------- Se accede al Servicio de Agora para Consultar el Proveedor de la Orden de Compra -------------------------------------------------------------------

                $parametro = $orden ['proveedor'];
                $enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
                $url = "http://10.20.0.38/agora/index.php?data=";
                $data = "pagina=servicio&servicios=true&servicio=servicioArgoProveedor&Parametro1=$parametro";
                $url_servicio = $url . $this->miConfigurador->fabricaConexiones->crypto->codificar($data, $enlace);
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
            
//----------------------------------------------------------------------------------------------------------------------------------------------------------------               

        $cadenaSql = $this->miSql->getCadenaSql('polizasDocumento', $_REQUEST ['id_orden']);
        $polizas = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        

        $cadenaSql = $this->miSql->getCadenaSql('ordenadorDocumento', $orden ['ordenador_gasto']);
        $ordenador = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        $ordenador = $ordenador [0];

        $cadenaSql = $this->miSql->getCadenaSql('consultarElementosOrden', $_REQUEST ['id_orden']);
        $ElementosOrden = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");


        $cadenaSql = $this->miSql->getCadenaSql('consultarFormadePago', $orden ['forma_pago']);
        $formaPago = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        $formaPago = $formaPago[0][0];

        if ($orden['unidad_ejecutora'] == '208') {
            $cadenaSql = $this->miSql->getCadenaSql('consultarConvenio', $orden ['dependencia_solicitante']);
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

        $contenidoPagina = "
<style type=\"text/css\">
    table { 
        color:#333; /* Lighten up font color */
        font-family:Helvetica, Arial, sans-serif; /* Nicer font */
		
        border-collapse:collapse; border-spacing: 3px; 
    }

    td, th { 
        border: 1px solid #CCC; 
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
        font-size:10px
    }
</style>				
				
				
<page backtop='5mm' backbottom='5mm' backleft='10mm' backright='10mm'>
	

        <table align='left' style='width:100%;' >
            <tr>
                <td align='center' >
                    <img src='" . $directorio . "/css/images/escudo.png'  width='80' height='100'>
                </td>
                <td align='center' style='width:88%;' >
                    <font size='9px'><b>UNIVERSIDAD DISTRITAL FRANCISCO JOSÉ DE CALDAS </b></font>
                     <br>
                    <font size='7px'><b>NIT: 899.999.230-7</b></font>
                     <br>
                    <font size='3px'>CARRERA 7 No. 40-53 PISO 7. TELEFONO 3239300 EXT. 2609 -2605</font>
                     <br>		
                    <font size='5px'>www.udistrital.edu.co</font>
                     <br>
                    <font size='4px'>" . date("Y-m-d") . "</font>
                </td>
            </tr>
        </table>
	
	                  		
       		<table style='width:100%;'>
            <tr> 
			<td style='width:50%;'>" . $orden['tipo_orden'] . " - Numero Contrato: " . $orden ['numero_contrato'] . "</td>
			<td style='width:50%;text-aling=right;'>FECHA DE ORDEN :  " . $orden ['fecha_registro_orden'] . "</td> 			
 		 	</tr>
		    </table>
				  <table style='width:100%;'>
			<tr> 
			<td style='width:100%;'><b>Información Precontractual</b></td>
			</tr>
         	    </table>


		    <table style='width:100%;'>
			<tr> 
			<td style='width:50%;'>Numero de Solicitud de Necesidad : " . $orden['numero_solicitud_necesidad'] . " </td>
			<td style='width:50%;'>Numero de Disponibilidad Presupuestal : " . $orden['numero_cdp'] . " </td>
			</tr>
	           </table>			
		    <table style='width:100%;'>
			<tr> 
			<td style='width:100%;'><b>Información Solicitante</b></td>
			</tr>
         	    </table>


		    <table style='width:100%;'>
			<tr> 
			<td style='width:50%;'>Dependencia : " . $dependencia . " </td>
			<td style='width:50%;'>Sede : " . $sede . " </td>
			</tr>
	           </table>	
		  

			<table style='width:100%;'>
			<tr> 
			<td style='width:100%;'><b>Datos Supervisor</b></td>
			</tr>
         	</table>

			<table style='width:100%;'>		
			<tr> 
			<td style='width:50%;'>Nombre : " . $supervisor ['nombre_cp'] . " </td>
			<td style='width:50%;'>Cargo : " . $supervisor ['cargo'] . " </td>
			</tr>
			</table>
					
		   	<table style='width:100%;'>
			<tr> 
			<td style='width:100%;'><b>Información Contratista</b></td>
			</tr>
         	</table>	

            <table style='width:100%;'>
			<tr> 
			<td style='width:50%;'>Razón Social : " . $proveedor ['nomempresa'] . " </td>
			<td style='width:50%;'>Nit : " . $proveedor ['nit'] . " </td>
			</tr>
			<tr> 
			<td style='width:50%;'>Dirección : " . $proveedor ['direccion'] . " </td>
			<td style='width:50%;'>Telefono : " . $proveedor ['telefono'] . " </td>
			</tr>		
			</table>
					
  			 <table style='width:100%;'>
			<tr> 
			<td style='width:50%;'>Nombre Contratista : " . $proveedor ['primernombre']." ".$proveedor ['segundonombre']." ".$proveedor ['primerapellido'] ." ".$proveedor ['segundoapellido']. " </td>
			<td style='width:50%;'>Identificación : " . $proveedor ['numdocumento'] . " </td>
			</tr>
			</table>
					
			<table style='width:100%;'>
			<tr> 
			<td style='width:100%;'>Cargo : " . "CARGO" . "</td>
			</tr>
         	</table>			
					
			<table style='width:100%;'>
			<tr> 
			<td style='width:100%;'><b>Información Contrato</b></td>
			</tr>
         	</table>	

			<table style='width:100%;'>
			<tr> 
			<td style='width:100%;text-align:justify;font-size: 8px;font-size-adjust: 0.3;'>" . $orden ['objeto_contrato'] . " </td>
			</tr>		
			</table>";

        if ($polizas != false) {
            $contenidoPagina .= "<table style='width:100%;'>";
            for ($i = 0; $i < count($polizas); $i++) {
                $contenidoPagina.=
                        "<tr> 
			<td style='width:90%;text-align:left;'>" . $polizas [$i][0] . "</td>	
			</tr>";
            }
            $contenidoPagina .= "</table>";
        }


        $contenidoPagina .= "
			<table style='width:100%;'>
			<tr> 
			<td style='width:100%;'><b>Información Referente Pago</b></td>
			</tr>
         	</table>	             		

		    <table style='width:100%;'>
			<tr> 
			<td style='width:33.31%;'>Fecha Inicio:  " . $orden ['fecha_inicio'] . "</td>
			<td style='width:33.31%;'>Fecha Final:  " . $orden ['fecha_final'] . "</td>
			<td style='width:33.31%;'>Duración (en Dias):  " . $orden ['plazo_ejecucion'] . "</td>		
			</tr>
         	</table>	 

            <table style='width:100%;'>
			<tr> 
			<td style='width:100%;text-align:justify;'>Forma de Pago :  " . $formaPago . "</td>
			</tr>
         	</table>


		
			
					
<page_footer  backleft='10mm' backright='10mm'>
			<table style='width:100%;'>		
			<tr>
			<td style='width:100%;text-align:justify;'><font size='1px'>Observaciones: para el respectivo pago la factura y/o cuenta de cobro debe coincidir en valores, cantidades y razón social, con la presente orden de servicio. igualmente se debe anexar el recibido a satisfacción del servicio, pago de aportes parafiscal y/o seguridad social del mes de facturación y certificación bancaria con el numero de cuenta para realizar la transferencia bancaria.</font></td>	
			</tr>
			</table>
		
</page_footer> 
					
						</page>
				";

        $contenidoPagina .= "<page backtop='5mm' backbottom='5mm' backleft='10mm' backright='10mm'>";

        $contenidoPagina .= "
		<table style='width:100%;'>
		<tr>
		<td style='width:100%;text-align=center;'>Elementos Orden</td>
		</tr>
		</table>
		<table style='width:100%;'>
		<tr>
		<td style='width:10%;text-align=center;'>Item</td>
		<td style='width:15%;text-align=center;'>Unidad/Medida</td>
		<td style='width:20%;text-align=center;'>Cantidad</td>
		<td style='width:30%;text-align=center;'>Descripción</td>
		<td style='width:8.3%;text-align=center;'>Valor Unitario($)</td>
		<td style='width:8.3%;text-align=center;'>Iva</td>
		<td style='width:8.3%;text-align=center;'>Total</td>
		</tr>
		</table>
		<table style='width:100%;'>";

        $sumatoriaTotal = 0;

        $sumatoriaIva = 0;
        $sumatoriaSubtotal = 0;
        $j = 1;

        // var_dump ( $ElementosOrden );
        // exit ();

        if ($ElementosOrden) {
            foreach ($ElementosOrden as $valor => $it) {
                $contenidoPagina .= "<tr>";
                $contenidoPagina .= "<td style='width:10%;text-align=center;'>" . $j . "</td>";
                $contenidoPagina .= "<td style='width:15%;text-align=center;'>" . $it ['unidad'] . "</td>";
                $contenidoPagina .= "<td style='width:20%;text-align=center;'>" . $it ['cantidad'] . "</td>";
                $contenidoPagina .= "<td style='width:30%;text-align=justify;'>" . $it ['descripcion'] . "</td>";
                $contenidoPagina .= "<td style='width:8.3%;text-align=center;'>$ " . $it ['valor'] . "</td>";
                $contenidoPagina .= "<td style='width:8.3%;text-align=center;'>" . $it ['nombre_iva'] . "</td>";
                $contenidoPagina .= "<td style='width:8.3%;text-align=center;'>$ " . $it ['total_iva_con'] . "</td>";
                $contenidoPagina .= "</tr>";

                $sumatoriaTotal = $sumatoriaTotal + $it ['total_iva_con'];
                $sumatoriaSubtotal = $sumatoriaSubtotal + $it ['subtotal_sin_iva'];
                $sumatoriaIva = $sumatoriaIva + $it ['total_iva'];
                $j ++;
            }
        }
        $contenidoPagina .= "</table>";

        $contenidoPagina .= "		<table style='width:100%;'>
		<tr>
		
		<td style='width:91.7%;text-align=left;'><b>SUBTOTAL  : </b></td>
		<td style='width:8.3%;text-align=center;'><b>$" . $sumatoriaSubtotal . "</b></td>
		</tr>
		<tr>
		
		<td style='width:91.7%;text-align=left;'><b>TOTAL IVA  : </b></td>
		<td style='width:8.3%;text-align=center;'><b>$" . $sumatoriaIva . "</b></td>
		</tr>			
				
		<tr>
		
		<td style='width:91.7%;text-align=left;'><b>TOTAL  : </b></td>
		<td style='width:8.3%;text-align=center;'><b>$" . $sumatoriaTotal . "</b></td>
		</tr>
				
				
	</table>			
				";

        $funcionLetras = new EnLetras ();

        $Letras = $funcionLetras->ValorEnLetras($sumatoriaTotal, ' Pesos ');

        $contenidoPagina .= "<table style='width:100%;'>			
		<tr>
		
		<td style='width:100%;text-align=center;text-transform:uppercase;'><b>" . $Letras . "</b></td>
		</tr>		
		
		</table>";

        if ($infDisponibilidad) {

            $contenidoPagina .= "
			<BR>
			<BR>
			<BR>		
			<table style='width:100%;'>
			<tr>
			<td style='width:100%;'><b>INFORMACIÓN PRESUPUESTAL</b></td>
			</tr>
         	</table>";

            $contenidoPagina .= "
			<table style='width:100%;'>
			<tr>
			<td style='width:100%;'><b>Disponibilidades Presupuestales</b></td>
			</tr>
         	</table>		
				
					
					
			<table style='width:100%;'>
			<tr>
			<td style='width:6.5%;text-align=center;'>Vigencia</td>
			<td style='width:6.5%;text-align=center;'>Unidad Ejecutora</td>
			<td style='width:10%;text-align=center;'>Número<br>Solicitud</td>
			<td style='width:10%;text-align=center;'>Número<br>Disponibilidad</td>
			<td style='width:30%;text-align=center;'>Rubro</td>
			<td style='width:15%;text-align=center;'>Valor<br>Solicitado($)</td>
			<td style='width:22%;text-align=center;'>Valor Letras</td>
			</tr>
			</table>			
			<table style='width:100%;'>		
         ";

            foreach ($infDisponibilidad as $valor) {

                $contenidoPagina .= "<tr>";
                $contenidoPagina .= "<td style='width:6.5%;text-align=center;'>" . $valor ['vigencia'] . "</td>";
                $contenidoPagina .= "<td style='width:6.5%;text-align=center;'>" . $valor ['unidad_ejecutora'] . "</td>";
                $contenidoPagina .= "<td style='width:10%;text-align=center;'>" . $valor ['numero_solicitud'] . "</td>";
                $contenidoPagina .= "<td style='width:10%;text-align=center;'>" . $valor ['numero_diponibilidad'] . "</td>";
                $contenidoPagina .= "<td style='width:30%;text-align=justify;'>" . $valor ['id_rubro'] . "- " . $valor ['descripcion_rubro'] . "</td>";
                $contenidoPagina .= "<td style='width:15%;text-align=center;'>$ " . number_format($valor ['valor_solicitado'], 2, ",", ".") . "</td>";
                $contenidoPagina .= "<td style='width:22%;text-align=center;'>" . $valor ['valor_letras_solicitud'] . "</td>";
                $contenidoPagina .= "</tr>";
            }

            $contenidoPagina .= "</table>";

            if ($inRegistro) {

                $contenidoPagina .= "<br>
			<table style='width:100%;'>
			<tr>
			<td style='width:100%;'><b>Registros Presupuestales</b></td>
			</tr>
         	</table>
				
			
			
			<table style='width:100%;'>
			<tr>
			<td style='width:15%;text-align=center;'>Vigencia</td>
			<td style='width:30%;text-align=center;'>Rubro</td>
			<td style='width:15%;text-align=center;'>Unidad Ejecutora</td>
			<td style='width:20%;text-align=center;'>Número Registro</td>
			<td style='width:20%;text-align=center;'>Valor<br>Solicitado($)</td>
			</tr>
			</table>
			<table style='width:100%;'>
         ";

                foreach ($inRegistro as $valor) {

                    $contenidoPagina .= "<tr>";
                    $contenidoPagina .= "<td style='width:15%;text-align=center;'>" . $valor ['vigencia'] . "</td>";
                    $contenidoPagina .= "<td style='width:30%;text-align=center;'>" . $valor ['id_rubro'] . " " . $valor ['descr_rubro'] . "</td>";
                    $contenidoPagina .= "<td style='width:15%;text-align=center;'>" . $valor ['unidad_ejecutora'] . "</td>";
                    $contenidoPagina .= "<td style='width:20%;text-align=center;'>" . $valor ['numero_registro'] . "</td>";
                    $contenidoPagina .= "<td style='width:20%;text-align=center;'>$ " . number_format($valor ['valor_registro'], 2, ",", ".") . "</td>";
                    $contenidoPagina .= "</tr>";
                }

                $contenidoPagina .= "</table>";
            }
        }

        $contenidoPagina .= "<page_footer  backleft='10mm' backright='10mm'>
				
				
						<table style='width:100%; background:#FFFFFF ; border: 0px  #FFFFFF;'>
			<tr>
			<td style='width:50%;text-align:left;background:#FFFFFF ; border: 0px  #FFFFFF;'>_______________________________</td>
			<td style='width:50%;text-align:left;background:#FFFFFF ; border: 0px  #FFFFFF;'>_______________________________</td>
			</tr>
			<tr>
			<td style='width:50%;text-align:left;background:#FFFFFF ; border: 0px  #FFFFFF;'>FIRMA CONTRATISTA</td>
			<td style='width:50%;text-align:left;background:#FFFFFF ; border: 0px  #FFFFFF; text-transform:capitalize;'>" . $ordenador ['ordenador'] . "</td>
			</tr>
			<tr>
			<td style='width:50%;text-align:left;background:#FFFFFF ; border: 0px  #FFFFFF; text-transform:capitalize;'>NOMBRE: " . $proveedor ['nomempresa'] . "</td>
			<td style='width:50%;text-align:left;background:#FFFFFF ; border: 0px  #FFFFFF;'>ORDENADOR GASTO</td>
			</tr>
			<tr>
			<td style='width:50%;text-align:left;background:#FFFFFF ; border: 0px  #FFFFFF;'>C.C: " . $proveedor ['nit'] . "</td>
			<td style='width:50%;text-align:left;background:#FFFFFF ; border: 0px  #FFFFFF;'>" . $ordenador ['identificacion'] . "-" . $ordenador['nombre'] . "</td>
			</tr>
			</table>
							
				
												<table style='width:100%;'>		
												<tr>
												<td style='width:100%;text-align:justify;'><font size='1px'>Observaciones: para el respectivo pago la factura y/o cuenta de cobro debe coincidir en valores, cantidades y razón social, con la presente orden de servicio. igualmente se debe anexar el recibido a satisfacción del servicio, pago de aportes parafiscal y/o seguridad social del mes de facturación y certificación bancaria con el numero de cuenta para realizar la transferencia bancaria.</font></td>	
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





