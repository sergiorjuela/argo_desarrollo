<?php
/**
 *
 * Los datos del bloque se encuentran en el arreglo $esteBloque.
 */
// URL base
$url = $this->miConfigurador->getVariableConfiguracion("host");
$url .= $this->miConfigurador->getVariableConfiguracion("site");
$url .= "/index.php?";

// Variables
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar .= "&funcion=NumeroSolicitud";
$cadenaACodificar .= "&usuario=" . $_REQUEST['usuario'];
$cadenaACodificar .="&tiempo=" . $_REQUEST['tiempo'];


// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar, $enlace);

// URL definitiva
$urlVigencia = $url . $cadena;




$cadenaACodificar2 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar2 .= "&procesarAjax=true";
$cadenaACodificar2 .= "&action=index.php";
$cadenaACodificar2 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar2 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar2 .= "&funcion=AlmacenarDatos";
$cadenaACodificar2 .= "&usuario=" . $_REQUEST['usuario'];
$cadenaACodificar2 .="&tiempo=" . $_REQUEST['tiempo'];
$cadena2 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar2, $enlace);
$urlDatosPaso = $url . $cadena2;
?>
<script type='text/javascript'>


//---------------------Inicio Ajax Numero de Solicitud de Necesidad------------------
    
    
    $("#<?php echo $this->campoSeguro('vigencia') ?>").change(function () {
            if ($("#<?php echo $this->campoSeguro('vigencia') ?>").val() != '') {
                NumeroSolicitud();
            } else {
                $("#<?php echo $this->campoSeguro('num_solicitud') ?>").attr('disabled', '');
            }
        });
    
    
    
    
    function NumeroSolicitud(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlVigencia ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('vigencia') ?>").val()},
            success: function (data) {




                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('num_solicitud') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('num_solicitud') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].id + "'>" + data[ indice ].descripcion + "</option>").appendTo("#<?php echo $this->campoSeguro('num_solicitud') ?>");
                    });
                    $('#<?php echo $this->campoSeguro('num_solicitud') ?>').width(150);
                    $("#<?php echo $this->campoSeguro('num_solicitud') ?>").select2();
                    $("#<?php echo $this->campoSeguro('num_solicitud') ?>").removeAttr('disabled');
                }


            }

        });
    }
    ;
//---------------------Fin Ajax Numero de Solicitud de Necesidad------------------        


</script>

<script>

    function almacenarInfoTemporal(pasoActual, pasoNuevo) {
            var InfoPaso0 = [];
            
//------------------------------->Paso 1 --------------------------------------------------------------------------------------------            
            if (document.getElementById("<?php echo $this->campoSeguro('numero_contrato') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('numero_contrato') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('numero_contrato') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('tipo_identificacion') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('tipo_identificacion') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('tipo_identificacion') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('numero_identificacion') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('numero_identificacion') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('numero_identificacion') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('digito_verificacion') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('digito_verificacion') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('digito_verificacion') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('tipo_persona') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('tipo_persona') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('tipo_persona') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('primer_nombre') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('primer_nombre') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('primer_nombre') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('segundo_nombre') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('segundo_nombre') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('segundo_nombre') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('primer_apellido') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('primer_apellido') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('primer_apellido') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('nombre_Razon_Social') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('nombre_Razon_Social') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('nombre_Razon_Social') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('segundo_apellido') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('segundo_apellido') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('segundo_apellido') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('genero') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('genero') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('genero') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('nacionalidad') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('nacionalidad') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('nacionalidad') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('direccion') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('direccion') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('direccion') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('telefono') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('telefono') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('telefono') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('correo') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('correo') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('correo') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('perfil') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('perfil') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('perfil') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('profesion') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('profesion') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('profesion') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('especialidad') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('especialidad') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('especialidad') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('tipo_cuenta') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('tipo_cuenta') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('tipo_cuenta') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('numero_cuenta') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('numero_cuenta') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('numero_cuenta') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('entidad_bancaria') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('entidad_bancaria') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('entidad_bancaria') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('tipo_configuracion') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('tipo_configuracion') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('tipo_configuracion') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('clase_contratista') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('clase_contratista') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('clase_contratista') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('identificacion_clase_contratista') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('identificacion_clase_contratista') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('identificacion_clase_contratista') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('digito_verificacion_clase_contratista') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('digito_verificacion_clase_contratista') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('digito_verificacion_clase_contratista') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('porcentaje_clase_contratista') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('porcentaje_clase_contratista') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('porcentaje_clase_contratista') ?>").getAttribute("id"));
            }
            
//------------------------------->Paso 2 --------------------------------------------------------------------------------------------
          if (document.getElementById("<?php echo $this->campoSeguro('clase_contrato') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('clase_contrato') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('clase_contrato') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('tipo_compromiso') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('tipo_compromiso') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('tipo_compromiso') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('numero_convenio') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('numero_convenio') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('numero_convenio') ?>").getAttribute("id"));
            }
            
            if (document.getElementById("<?php echo $this->campoSeguro('vigencia_convenio') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('vigencia_convenio') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('vigencia_convenio') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('objeto_contrato') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('objeto_contrato') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('objeto_contrato') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('fecha_subcripcion') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('fecha_subcripcion') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('fecha_subcripcion') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('plazo_ejecucion') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('plazo_ejecucion') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('plazo_ejecucion') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('unidad_ejecucion_tiempo') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('unidad_ejecucion_tiempo') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('unidad_ejecucion_tiempo') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('fecha_inicio_poliza') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('fecha_inicio_poliza') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('fecha_inicio_poliza') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('fecha_final_poliza') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('fecha_final_poliza') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('fecha_final_poliza') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('dependencia') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('dependencia') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('dependencia') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('tipologia_especifica') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('tipologia_especifica') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('tipologia_especifica') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('numero_constancia') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('numero_constancia') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('numero_constancia') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('modalidad_seleccion') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('modalidad_seleccion') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('modalidad_seleccion') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('procedimiento') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('procedimiento') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('procedimiento') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('regimen_contratación') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('regimen_contratación') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('regimen_contratación') ?>").getAttribute("id"));
            }
             
//------------------------------->Paso 3 --------------------------------------------------------------------------------------------           
            
            if (document.getElementById("<?php echo $this->campoSeguro('tipo_moneda') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('tipo_moneda') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('tipo_moneda') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('valor_contrato') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('valor_contrato') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('valor_contrato') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('ordenador_gasto') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('ordenador_gasto') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('ordenador_gasto') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('tipo_gasto') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('tipo_gasto') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('tipo_gasto') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('origen_recursos') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('origen_recursos') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('origen_recursos') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('origen_presupuesto') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('origen_presupuesto') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('origen_presupuesto') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('tema_gasto_inversion') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('tema_gasto_inversion') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('tema_gasto_inversion') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('valor_contrato_moneda_ex') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('valor_contrato_moneda_ex') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('valor_contrato_moneda_ex') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('tasa_cambio') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('tasa_cambio') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('tasa_cambio') ?>").getAttribute("id"));
            }
            if (document.getElementById("<?php echo $this->campoSeguro('observacionesContrato') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('observacionesContrato') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('observacionesContrato') ?>").getAttribute("id"));
            }
//------------------------------->Paso 4 --------------------------------------------------------------------------------------------           
             
            if (document.getElementById("<?php echo $this->campoSeguro('tipo_control') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('tipo_control') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('tipo_control') ?>").getAttribute("id"));
            } 
            if (document.getElementById("<?php echo $this->campoSeguro('supervisor') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('supervisor') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('supervisor') ?>").getAttribute("id"));
            } 
            if (document.getElementById("<?php echo $this->campoSeguro('digito_supervisor') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('digito_supervisor') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('digito_supervisor') ?>").getAttribute("id"));
            } 
            if (document.getElementById("<?php echo $this->campoSeguro('fecha_suscrip_super') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('fecha_suscrip_super') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('fecha_suscrip_super') ?>").getAttribute("id"));
            } 
            if (document.getElementById("<?php echo $this->campoSeguro('fecha_limite') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('fecha_limite') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('fecha_limite') ?>").getAttribute("id"));
            } 
            if (document.getElementById("<?php echo $this->campoSeguro('observaciones_interventoria') ?>").value != "") {
                InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('observaciones_interventoria') ?>").value+";"+document.getElementById("<?php echo $this->campoSeguro('observaciones_interventoria') ?>").getAttribute("id"));
            } 
//---------------------------------------------Paso Informacion Disponibilidad para contrato-------------------------------------------- 
           
           var attribContTemp = document.getElementById("<?php echo $this->campoSeguro('atributosContratoTempHidden') ?>").value;
           InfoPaso0.push(attribContTemp);
            var arregloDatos = [];
            arregloDatos = JSON.stringify(InfoPaso0);
            AlmacenarPaso(arregloDatos);
        
      
    }

    function AlmacenarPaso(arreglo) {
        $.ajax({
            url: "<?php echo $urlDatosPaso ?>",
            dataType: "json",
            data: {valor: arreglo},
            success: function (data) {

                if (data[0] != " ") {

                    $.each(data, function (indice, valor) {
                        alert("bien");

                    });
                }


            }

        });
    }
    ;
  
   


</script>