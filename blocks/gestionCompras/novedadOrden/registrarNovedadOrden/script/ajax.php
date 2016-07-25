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


$cadenaACodificarSolCdp = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarSolCdp .= "&procesarAjax=true";
$cadenaACodificarSolCdp .= "&action=index.php";
$cadenaACodificarSolCdp .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarSolCdp .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarSolCdp .= $cadenaACodificarSolCdp . "&funcion=ObtenerSolicitudesCdp";
$cadenaACodificarSolCdp .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaACodificarSolCdp = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarSolCdp, $enlace);

// URL definitiva
$urlFinalSolCdp = $url . $cadenaACodificarSolCdp;

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
$cadenaACodificarNumeroOrden = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarNumeroOrden .= "&procesarAjax=true";
$cadenaACodificarNumeroOrden .= "&action=index.php";
$cadenaACodificarNumeroOrden .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarNumeroOrden .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarNumeroOrden .= $cadenaACodificarNumeroOrden . "&funcion=consultarNumeroOrden";
$cadenaACodificarNumeroOrden .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlaceNumeroOrden = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaNumeroOrden = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarNumeroOrden, $enlace);

// URL definitiva
$urlFinalNumeroOrden = $url . $cadenaNumeroOrden;



$cadenaACodificarProveedorFiltro = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarProveedorFiltro .= "&procesarAjax=true";
$cadenaACodificarProveedorFiltro .= "&action=index.php";
$cadenaACodificarProveedorFiltro .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarProveedorFiltro .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarProveedorFiltro .= $cadenaACodificarProveedorFiltro . "&funcion=consultarProveedorFiltro";
$cadenaACodificarProveedorFiltro .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaACodificarProveedorFiltro = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarProveedorFiltro, $enlace);

// URL definitiva
$urlProveedorFiltro = $url . $cadenaACodificarProveedorFiltro;


// Variables
$cadenaACodificarConsultaDependencia = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarConsultaDependencia .= "&procesarAjax=true";
$cadenaACodificarConsultaDependencia .= "&action=index.php";
$cadenaACodificarConsultaDependencia .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarConsultaDependencia .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarConsultaDependencia .= $cadenaACodificarConsultaDependencia . "&funcion=consultarDependencia";
$cadenaACodificarConsultaDependencia .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena16 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarConsultaDependencia, $enlace);

// URL definitiva
$urlFinalConsultaDependencia = $url . $cadena16;

$cadenaACodificarCdps = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarCdps .= "&procesarAjax=true";
$cadenaACodificarCdps .= "&action=index.php";
$cadenaACodificarCdps .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarCdps .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarCdps .= $cadenaACodificarCdps . "&funcion=ObtenerCdps";
$cadenaACodificarCdps .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaACodificarCdps = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarCdps, $enlace);

// URL definitiva
$urlFinalCdps = $url . $cadenaACodificarCdps;

// Variables
$cadenaACodificarInfoDisponibilidades = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarInfoDisponibilidades .= "&procesarAjax=true";
$cadenaACodificarInfoDisponibilidades .= "&action=index.php";
$cadenaACodificarInfoDisponibilidades .= "&bloqueNombre=" . $esteBloque ["nombre"]; 
$cadenaACodificarInfoDisponibilidades .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarInfoDisponibilidades .= "&funcion=Infodisponibilidades";
$cadenaACodificarInfoDisponibilidades .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaACodificarInfoDisponibilidades = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarInfoDisponibilidades, $enlace);

// URL definitiva
$urlFinalInfoDisponibilidades = $url . $cadenaACodificarInfoDisponibilidades;
?>
<script type='text/javascript'>



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
            $('#<?php echo $this->campoSeguro('vigencia_contrato') ?>').val($('#<?php echo $this->campoSeguro('vigencia_contrato') ?>').val().toUpperCase());

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



    //-------------------Inicio JavaScript y Ajax numero de orden de acuerdo al tipo de orden ------------------------------------------------------------------

    $("#<?php echo $this->campoSeguro('tipo_orden') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('tipo_orden') ?>").val() != '') {

            numero_orden();

        } else {
        }


    });


    function numero_orden(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinalNumeroOrden ?>",
            dataType: "json",
            data: {valor1: $("#<?php echo $this->campoSeguro('tipo_orden') ?>").val(), valor2: $("#<?php echo $this->campoSeguro('unidad_ejecutora_hidden') ?>").val()},
            success: function (data) {
                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('numero_orden') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('numero_orden') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].value + "'>" + data[ indice ].orden + "</option>").appendTo("#<?php echo $this->campoSeguro('numero_orden') ?>");

                    });
                    $("#<?php echo $this->campoSeguro('numero_orden') ?>").removeAttr('disabled');
                    $('#<?php echo $this->campoSeguro('numero_orden') ?>').width(200);
                    $("#<?php echo $this->campoSeguro('numero_orden') ?>").select2();


                }


            }

        });
    }
    ;
//-------------------Fin JavaScript y Ajax numero de orden de acuerdo al tipo de orden ------------------------------------------------------------------

    $("#<?php echo $this->campoSeguro('nitproveedor') ?>").keyup(function () {


        $('#<?php echo $this->campoSeguro('nitproveedor') ?>').val($('#<?php echo $this->campoSeguro('nitproveedor') ?>').val());


    });




    $("#<?php echo $this->campoSeguro('nitproveedor') ?>").autocomplete({
        minChars: 3,
        serviceUrl: '<?php echo $urlProveedorFiltro; ?>',
        onSelect: function (suggestions) {

            $("#<?php echo $this->campoSeguro('id_proveedor') ?>").val(suggestions.data);
        }

    });


    //-------------------Inicio JavaScript y Ajax Sede Dependencia ------------------------------------------------------------------

    $("#<?php echo $this->campoSeguro('sedeConsulta') ?>").change(function () {
        if ($("#<?php echo $this->campoSeguro('sedeConsulta') ?>").val() != '') {
            consultarDependenciaConsultada();
        } else {
            $("#<?php echo $this->campoSeguro('dependenciaConsulta') ?>").attr('disabled', '');
        }

    });

    function consultarDependenciaConsultada(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinalConsultaDependencia ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('sedeConsulta') ?>").val()},
            success: function (data) {

                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('dependenciaConsulta') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('dependenciaConsulta') ?>");
                    $.each(data, function (indice, valor) {
                        $("<option value='" + data[ indice ].ESF_CODIGO_DEP + "'>" + data[ indice ].ESF_DEP_ENCARGADA + "</option>").appendTo("#<?php echo $this->campoSeguro('dependenciaConsulta') ?>");

                    });

                    $("#<?php echo $this->campoSeguro('dependenciaConsulta') ?>").removeAttr('disabled');

                    $('#<?php echo $this->campoSeguro('dependenciaConsulta') ?>').width(300);
                    $("#<?php echo $this->campoSeguro('dependenciaConsulta') ?>").select2();



                }


            }

        });
    }
    ;

//-------------------Fin JavaScript y Ajax Sede Dependencia ------------------------------------------------------------------

    //--------------Inicio JavaScript y Ajax Vigencia y Numero solicitud ---------------------------------------------------------------------------------------------    

    $("#<?php echo $this->campoSeguro('vigencia_novedad') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('vigencia_novedad') ?>").val() != '') {
            $("#<?php echo $this->campoSeguro('numero_cdp') ?>").attr('disabled', '');
            consultarSoliditudyCdp();
        } else {
            $("#<?php echo $this->campoSeguro('vigencia_novedad') ?>").attr('disabled', '');
        }

    });

    function consultarSoliditudyCdp(elem, request, response) {

        $.ajax({
            url: "<?php echo $urlFinalSolCdp ?>",
            dataType: "json",
            data: {vigencia: $("#<?php echo $this->campoSeguro('vigencia_novedad') ?>").val(),
                unidad: $("#<?php echo $this->campoSeguro('unidad_ejecutora_hidden') ?>").val()
            },
            success: function (data) {


                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('numero_solicitud') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('numero_solicitud') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].VALOR + "'>" + data[ indice ].INFORMACION + "</option>").appendTo("#<?php echo $this->campoSeguro('numero_solicitud') ?>");

                    });

                    $("#<?php echo $this->campoSeguro('numero_solicitud') ?>").removeAttr('disabled');

                    $('#<?php echo $this->campoSeguro('numero_solicitud') ?>').width(200);
                    $("#<?php echo $this->campoSeguro('numero_solicitud') ?>").select2();



                }


            }

        });
    }
    ;

    //--------------Fin JavaScript y Ajax SVigencia y Numero solicitud --------------------------------------------------------------------------------------------------   
//--------------Inicio JavaScript y Ajax CDP x Solicitud ---------------------------------------------------------------------------------------------    

    $("#<?php echo $this->campoSeguro('numero_solicitud') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('numero_solicitud') ?>").val() != '') {
            consultarCDPs();
        } else {
            $("#<?php echo $this->campoSeguro('numero_solicitud') ?>").attr('disabled', '');
        }

    });

    function consultarCDPs(elem, request, response) {

        $.ajax({
            url: "<?php echo $urlFinalCdps ?>",
            dataType: "json",
            data: {numsol: $("#<?php echo $this->campoSeguro('numero_solicitud') ?>").val(),
                vigencia: $("#<?php echo $this->campoSeguro('vigencia_novedad') ?>").val(),
                unidad: $("#<?php echo $this->campoSeguro('unidad_ejecutora_hidden') ?>").val(),
                cdps: $("#<?php echo $this->campoSeguro('cdpRegistradas') ?>").val()},
            success: function (data) {


                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('numero_cdp') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('numero_cdp') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].VALOR + "'>" + data[ indice ].INFORMACION + "</option>").appendTo("#<?php echo $this->campoSeguro('numero_cdp') ?>");

                    });

                    $("#<?php echo $this->campoSeguro('numero_cdp') ?>").removeAttr('disabled');

                    $('#<?php echo $this->campoSeguro('numero_cdp') ?>').width(200);
                    $("#<?php echo $this->campoSeguro('numero_cdp') ?>").select2();



                }


            }

        });
    }
    ;

    //--------------Fin JavaScript y Ajax CDP x Solicitud --------------------------------------------------------------------------------------------------   
    $("#<?php echo $this->campoSeguro('numero_cdp') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('numero_cdp') ?>").val() != '') {

            infodisponibilidades();


        }


    });

    function infodisponibilidades(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinalInfoDisponibilidades ?>",
            dataType: "json",
            data: {vigencia: $("#<?php echo $this->campoSeguro('vigencia_novedad') ?>").val(),
                disponibilidad: $("#<?php echo $this->campoSeguro('numero_cdp') ?>").val(),
                unidad: $("#<?php echo $this->campoSeguro('unidad_ejecutora_hidden') ?>").val(),
                numsolicitud: $("#<?php echo $this->campoSeguro('numero_solicitud') ?>").val()},
            success: function (data) {

                if (data[0] != "null") {
                    $("#<?php echo $this->campoSeguro('valor_adicion_presupuesto') ?>").val(data[1]);
                   


                }




            }

        });
    }
    ;


</script>

