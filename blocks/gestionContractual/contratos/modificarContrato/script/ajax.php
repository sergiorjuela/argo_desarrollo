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



// Variables
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar .= "&funcion=consultaContrato";
$cadenaACodificar .= "&usuario=" . $_REQUEST['usuario'];
$cadenaACodificar .="&tiempo=" . $_REQUEST['tiempo'];


// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar, $enlace);

// URL definitiva
$urlVigenciaContrato = $url . $cadena;


// Variables
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar .= "&funcion=consultaContratista";
$cadenaACodificar .= "&usuario=" . $_REQUEST['usuario'];
$cadenaACodificar .="&tiempo=" . $_REQUEST['tiempo'];


// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar, $enlace);

// URL definitiva
$urlContratista = $url . $cadena;



// Variables
$cadenaACodificarProveedor = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarProveedor .= "&procesarAjax=true";
$cadenaACodificarProveedor .= "&action=index.php";
$cadenaACodificarProveedor .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarProveedor .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarProveedor .= "&funcion=consultaProveedor";
$cadenaACodificarProveedor .= "&tiempo=" . $_REQUEST ['tiempo'];



// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarProveedor, $enlace);

// URL definitiva
$urlFinalProveedor = $url . $cadena;



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


$cadenaACodificar3 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar3 .= "&procesarAjax=true";
$cadenaACodificar3 .= "&action=index.php";
$cadenaACodificar3 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar3 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar3 .= "&funcion=obtenerGeneros";
$cadenaACodificar3 .= "&usuario=" . $_REQUEST['usuario'];
$cadenaACodificar3 .="&tiempo=" . $_REQUEST['tiempo'];
$cadena3 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar3, $enlace);
$urlPersonaGenero = $url . $cadena3;
?>
<script type='text/javascript'>
//----------------------------Configuracion Paso a Paso--------------------------------------
    $("#ventanaA").steps({
        headerTag: "h3",
        bodyTag: "section",
        enableAllSteps: true,
        enablePagination: true,
        transitionEffect: "slideLeft",
        onStepChanging: function (event, currentIndex, newIndex) {

            $resultado = $("#modificarContrato").validationEngine("validate");
            //almacenarInfoTemporal(currentIndex, newIndex);
            if ($resultado) {
                return true;
            }
            return false;

        },
        onFinished: function (event, currentIndex) {
           
            $("#modificarContrato").submit();
        },
        labels: {
            cancel: "Cancelar",
            current: "Paso Siguiente :",
            pagination: "Paginación",
            finish: "Guardar Información",
            next: "Siquiente",
            previous: "Atras",
            loading: "Cargando ..."
        }

    });

//----------------------------Fin Configuracion Paso a Paso--------------------------------------



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

    $(function () {

        $("#<?php echo $this->campoSeguro('vigencia_contrato') ?>").keyup(function () {
            $('#<?php echo $this->campoSeguro('vigencia_contrato') ?>').val($('#<?php echo $this->campoSeguro('vigencia_contrato') ?>').val());

        });

        $("#<?php echo $this->campoSeguro('vigencia_contrato') ?>").autocomplete({
            minChars: 2,
            serviceUrl: '<?php echo $urlVigenciaContrato; ?>',
            onSelect: function (suggestion) {

                $("#<?php echo $this->campoSeguro('id_contrato') ?>").val(suggestion.data);
            }

        });



        $("#<?php echo $this->campoSeguro('contratista') ?>").autocomplete({
            minChars: 3,
            serviceUrl: '<?php echo $urlContratista; ?>',
            onSelect: function (suggestion) {

                $("#<?php echo $this->campoSeguro('id_contratista') ?>").val(suggestion.data);
            }

        });



    });



    //---------------------Inicio Ajax Tipo Persona y Genero ------------------


    $("#<?php echo $this->campoSeguro('tipo_persona') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('tipo_persona') ?>").val() != '') {
            cargarGeneros();
        } else {
            $("#<?php echo $this->campoSeguro('genero') ?>").attr('disabled', '');
        }
    });




    function cargarGeneros(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlPersonaGenero ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('tipo_persona') ?>").val()},
            success: function (data) {

                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('genero') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('genero') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].id + "'>" + data[ indice ].valor + "</option>").appendTo("#<?php echo $this->campoSeguro('genero') ?>");
                    });
                    $('#<?php echo $this->campoSeguro('genero') ?>').width(150);
                    $("#<?php echo $this->campoSeguro('genero') ?>").select2();
                    $("#<?php echo $this->campoSeguro('genero') ?>").removeAttr('disabled');
                }


            }

        });
    }
    ;
//---------------------Fin Ajax Tipo Persona y Genero------------------ 


//---------------Inicio JavaScript y Ajax Proveedor ---------------------------------------------------------------------------------------------------




    function consultarContratistas(elem, request, response) {
        if ($("#<?php echo $this->campoSeguro('selec_proveedor') ?>").val() != "") {
            $.ajax({
                url: "<?php echo $urlFinalProveedor ?>",
                dataType: "json",
                data: {proveedor: $("#<?php echo $this->campoSeguro('selec_proveedor') ?>").val()},
                success: function (data) {

                    if (data.datos != 'null') {
                        if (data.status == 200) {
                            console.log(data.datos);
                            $("#<?php echo $this->campoSeguro('numero_identificacion') ?>").val(data.datos.nit);
                            $("#<?php echo $this->campoSeguro('nombre_Razon_Social') ?>").val(data.datos.nomempresa);
                            $("#<?php echo $this->campoSeguro('digito_verificacion') ?>").val(data.datos.digitoverificacion);
                            $("#<?php echo $this->campoSeguro('direccion') ?>").val(data.datos.direccion);
                            $("#<?php echo $this->campoSeguro('correo') ?>").val(data.datos.correo);
                            $("#<?php echo $this->campoSeguro('telefono') ?>").val(data.datos.telefono);
                            if (data.datos.pais == null) {
                                $("#<?php echo $this->campoSeguro('nacionalidad') ?>").val(3);
                                $("#<?php echo $this->campoSeguro('nacionalidad') ?>").select2();
                            } else {
                                $("#<?php echo $this->campoSeguro('nacionalidad') ?>").val(4);
                                $("#<?php echo $this->campoSeguro('nacionalidad') ?>").select2();
                            }
                            $("#<?php echo $this->campoSeguro('tipo_persona') ?>").val(data.datos.tipopersona);
                            $("#<?php echo $this->campoSeguro('tipo_persona') ?>").select2();

                            if (data.datos.tipodocumento == 1) {
                                $("#<?php echo $this->campoSeguro('tipo_identificacion') ?>").val(184);
                                $("#<?php echo $this->campoSeguro('tipo_identificacion') ?>").select2();
                            } else {
                                $("#<?php echo $this->campoSeguro('tipo_identificacion') ?>").val(190);
                                $("#<?php echo $this->campoSeguro('tipo_identificacion') ?>").select2();
                            }
                            //----------------------Vacios Temporalmente Mientras se termina de Reestructurar Agora----------------
                          
                             $("#<?php echo $this->campoSeguro('genero') ?>").val(null);
                             //$("#<?php echo $this->campoSeguro('genero') ?>").select2();
                             $("#<?php echo $this->campoSeguro('tipo_cuenta') ?>").val(null);
                             $("#<?php echo $this->campoSeguro('tipo_cuenta') ?>").select2();
                             $("#<?php echo $this->campoSeguro('tipo_configuracion') ?>").val(null);
                             $("#<?php echo $this->campoSeguro('tipo_configuracion') ?>").select2();
                             $("#<?php echo $this->campoSeguro('perfil') ?>").val(null);
                             $("#<?php echo $this->campoSeguro('perfil') ?>").select2();
                             $("#<?php echo $this->campoSeguro('clase_contratista') ?>").val(null);
                             $("#<?php echo $this->campoSeguro('clase_contratista') ?>").select2();
                             $("#<?php echo $this->campoSeguro('profesion') ?>").val("");
                             $("#<?php echo $this->campoSeguro('especialidad') ?>").val("");
                             $("#<?php echo $this->campoSeguro('numero_cuenta') ?>").val("");
                             $("#<?php echo $this->campoSeguro('entidad_bancaria') ?>").val("");
                             
                            
                            

                        } else {
                            alert("Sin Cocincidencias en la Busqueda.");
                        }
                    } else {
                        alert("Servidor de Proveedores No Disponible.");

                    }

                }

            });
        } else {
            alert("Ingrese la Identificacion o el nombre del proveedor");
        }
    }
    ;




</script>

<script>

    function almacenarInfoTemporal(pasoActual, pasoNuevo) {
        var InfoPaso0 = [];

//------------------------------->Paso 1 --------------------------------------------------------------------------------------------            
        if (document.getElementById("<?php echo $this->campoSeguro('tipo_identificacion') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('tipo_identificacion') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('tipo_identificacion') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('numero_identificacion') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('numero_identificacion') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('numero_identificacion') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('digito_verificacion') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('digito_verificacion') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('digito_verificacion') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('tipo_persona') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('tipo_persona') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('tipo_persona') ?>").getAttribute("id"));
        }
//        if (document.getElementById("<?php echo $this->campoSeguro('primer_nombre') ?>").value != "") {
//            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('primer_nombre') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('primer_nombre') ?>").getAttribute("id"));
//        }
        if (document.getElementById("<?php echo $this->campoSeguro('nombre_Razon_Social') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('nombre_Razon_Social') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('nombre_Razon_Social') ?>").getAttribute("id"));
        }
//        if (document.getElementById("<?php echo $this->campoSeguro('segundo_nombre') ?>").value != "") {
//            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('segundo_nombre') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('segundo_nombre') ?>").getAttribute("id"));
//        }
//        if (document.getElementById("<?php echo $this->campoSeguro('primer_apellido') ?>").value != "") {
//            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('primer_apellido') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('primer_apellido') ?>").getAttribute("id"));
//        }
//        if (document.getElementById("<?php echo $this->campoSeguro('segundo_apellido') ?>").value != "") {
//            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('segundo_apellido') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('segundo_apellido') ?>").getAttribute("id"));
//        }
        if (document.getElementById("<?php echo $this->campoSeguro('genero') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('genero') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('genero') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('nacionalidad') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('nacionalidad') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('nacionalidad') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('direccion') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('direccion') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('direccion') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('telefono') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('telefono') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('telefono') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('correo') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('correo') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('correo') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('perfil') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('perfil') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('perfil') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('profesion') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('profesion') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('profesion') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('especialidad') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('especialidad') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('especialidad') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('tipo_cuenta') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('tipo_cuenta') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('tipo_cuenta') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('numero_cuenta') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('numero_cuenta') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('numero_cuenta') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('entidad_bancaria') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('entidad_bancaria') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('entidad_bancaria') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('tipo_configuracion') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('tipo_configuracion') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('tipo_configuracion') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('clase_contratista') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('clase_contratista') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('clase_contratista') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('identificacion_clase_contratista') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('identificacion_clase_contratista') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('identificacion_clase_contratista') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('digito_verificacion_clase_contratista') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('digito_verificacion_clase_contratista') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('digito_verificacion_clase_contratista') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('porcentaje_clase_contratista') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('porcentaje_clase_contratista') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('porcentaje_clase_contratista') ?>").getAttribute("id"));
        }

//------------------------------->Paso 2 --------------------------------------------------------------------------------------------
        if (document.getElementById("<?php echo $this->campoSeguro('clase_contrato') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('clase_contrato') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('clase_contrato') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('tipo_compromiso') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('tipo_compromiso') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('tipo_compromiso') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('numero_convenio') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('numero_convenio') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('numero_convenio') ?>").getAttribute("id"));
        }

        if (document.getElementById("<?php echo $this->campoSeguro('vigencia_convenio') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('vigencia_convenio') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('vigencia_convenio') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('objeto_contrato') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('objeto_contrato') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('objeto_contrato') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('fecha_subcripcion') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('fecha_subcripcion') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('fecha_subcripcion') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('plazo_ejecucion') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('plazo_ejecucion') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('plazo_ejecucion') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('unidad_ejecucion_tiempo') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('unidad_ejecucion_tiempo') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('unidad_ejecucion_tiempo') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('fecha_inicio_poliza') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('fecha_inicio_poliza') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('fecha_inicio_poliza') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('fecha_final_poliza') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('fecha_final_poliza') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('fecha_final_poliza') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('dependencia') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('dependencia') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('dependencia') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('tipologia_especifica') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('tipologia_especifica') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('tipologia_especifica') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('numero_constancia') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('numero_constancia') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('numero_constancia') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('modalidad_seleccion') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('modalidad_seleccion') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('modalidad_seleccion') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('procedimiento') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('procedimiento') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('procedimiento') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('regimen_contratación') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('regimen_contratación') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('regimen_contratación') ?>").getAttribute("id"));
        }

//------------------------------->Paso 3 --------------------------------------------------------------------------------------------           

        if (document.getElementById("<?php echo $this->campoSeguro('tipo_moneda') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('tipo_moneda') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('tipo_moneda') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('valor_contrato') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('valor_contrato') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('valor_contrato') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('ordenador_gasto') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('ordenador_gasto') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('ordenador_gasto') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('tipo_gasto') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('tipo_gasto') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('tipo_gasto') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('origen_recursos') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('origen_recursos') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('origen_recursos') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('origen_presupuesto') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('origen_presupuesto') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('origen_presupuesto') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('tema_gasto_inversion') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('tema_gasto_inversion') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('tema_gasto_inversion') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('valor_contrato_moneda_ex') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('valor_contrato_moneda_ex') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('valor_contrato_moneda_ex') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('tasa_cambio') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('tasa_cambio') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('tasa_cambio') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('observacionesContrato') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('observacionesContrato') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('observacionesContrato') ?>").getAttribute("id"));
        }
//------------------------------->Paso 4 --------------------------------------------------------------------------------------------           

        if (document.getElementById("<?php echo $this->campoSeguro('tipo_control') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('tipo_control') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('tipo_control') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('supervisor') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('supervisor') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('supervisor') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('digito_supervisor') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('digito_supervisor') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('digito_supervisor') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('fecha_suscrip_super') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('fecha_suscrip_super') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('fecha_suscrip_super') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('fecha_limite') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('fecha_limite') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('fecha_limite') ?>").getAttribute("id"));
        }
        if (document.getElementById("<?php echo $this->campoSeguro('observaciones_interventoria') ?>").value != "") {
            InfoPaso0.push(document.getElementById("<?php echo $this->campoSeguro('observaciones_interventoria') ?>").value + ";" + document.getElementById("<?php echo $this->campoSeguro('observaciones_interventoria') ?>").getAttribute("id"));
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