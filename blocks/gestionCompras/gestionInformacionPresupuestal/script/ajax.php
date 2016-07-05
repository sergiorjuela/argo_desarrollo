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
$cadenaACodificar .= "&funcion=SeleccionTipoBien";
$cadenaACodificar .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar, $enlace);

// URL definitiva
$urlFinal = $url . $cadena;

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
$cadenaACodificarNumeroOrden = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarNumeroOrden .= "&procesarAjax=true";
$cadenaACodificarNumeroOrden .= "&action=index.php";
$cadenaACodificarNumeroOrden .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarNumeroOrden .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarNumeroOrden .= $cadenaACodificarNumeroOrden . "&funcion=consultarDependencia";
$cadenaACodificarNumeroOrden .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena16 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarNumeroOrden, $enlace);

// URL definitiva
$urlFinal16 = $url . $cadena16;

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

// Variables
$cadenaACodificarDisponibilidades = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarDisponibilidades .= "&procesarAjax=true";
$cadenaACodificarDisponibilidades .= "&action=index.php";
$cadenaACodificarDisponibilidades .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarDisponibilidades .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarDisponibilidades .= "&funcion=disponibilidades";
$cadenaACodificarDisponibilidades .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaACodificarDisponibilidades = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarDisponibilidades, $enlace);

// URL definitiva
$urlFinalDisponibilidades = $url . $cadenaACodificarDisponibilidades;

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

// Variables
$cadenaACodificarLetrasNumeros = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarLetrasNumeros .= "&procesarAjax=true";
$cadenaACodificarLetrasNumeros .= "&action=index.php";
$cadenaACodificarLetrasNumeros .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarLetrasNumeros .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarLetrasNumeros .= "&funcion=letrasNumeros";
$cadenaACodificarLetrasNumeros .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaACodificarLetrasNumeros = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarLetrasNumeros, $enlace);

// URL definitiva
$urlFinalLetrasNumeros = $url . $cadenaACodificarLetrasNumeros;

// Variables
$cadenaACodificarRubro = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarRubro .= "&procesarAjax=true";
$cadenaACodificarRubro .= "&action=index.php";
$cadenaACodificarRubro .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarRubro .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarRubro .= "&funcion=consultarRubro";
$cadenaACodificarRubro .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlaceRubro = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaRubro = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarRubro, $enlace);

// URL definitiva
$urlFinalRubro = $url . $cadenaRubro;
?>
<script type='text/javascript'>


    //--------------Inicio JavaScript y Ajax Vigencia y Numero solicitud ---------------------------------------------------------------------------------------------    

    $("#<?php echo $this->campoSeguro('rubro') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('rubro') ?>").val() != '') {
            var descripcionRubro = $("#<?php echo $this->campoSeguro('rubro') ?>").find(":selected").text();
            $("#<?php echo $this->campoSeguro('descripcion_rubro_hidden') ?>").val(descripcionRubro);

        }

    });


    $("#<?php echo $this->campoSeguro('vigencia_solicitud') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('vigencia_solicitud') ?>").val() != '') {
            $("#<?php echo $this->campoSeguro('diponibilidad') ?>").attr('disabled', '');
            $("#<?php echo $this->campoSeguro('rubro') ?>").attr('disabled', '');
            consultarSoliditudyCdp();
        } else {
            $("#<?php echo $this->campoSeguro('vigencia_solicitud') ?>").attr('disabled', '');
        }

    });

    function consultarSoliditudyCdp(elem, request, response) {

        $.ajax({
            url: "<?php echo $urlFinalSolCdp ?>",
            dataType: "json",
            data: {vigencia: $("#<?php echo $this->campoSeguro('vigencia_solicitud') ?>").val(),
                unidad: $("#<?php echo $this->campoSeguro('unidad_ejecutora_hidden') ?>").val()},
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




    function disponibilidades(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinalDisponibilidades; ?>",
            dataType: "json",
            data: {vigencia: $("#<?php echo $this->campoSeguro('vigencia_solicitud') ?>").val(),
                unidad: $("#<?php echo $this->campoSeguro('unidad_ejecutora_hidden') ?>").val(),
                Numsolicitud: $("#<?php echo $this->campoSeguro('numero_solicitud') ?>").val()},
            success: function (data) {
                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('diponibilidad') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('diponibilidad') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].VALOR + "'>" + data[ indice ].INFORMACION + "</option>").appendTo("#<?php echo $this->campoSeguro('diponibilidad') ?>");

                    });
                    $("#<?php echo $this->campoSeguro('diponibilidad') ?>").removeAttr('disabled');

                    $('#<?php echo $this->campoSeguro('diponibilidad') ?>').width(300);
                    $("#<?php echo $this->campoSeguro('diponibilidad') ?>").select2();



                }




            }

        });
    }
    ;



    function rubro(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinalRubro; ?>",
            dataType: "json",
            data: {vigencia: $("#<?php echo $this->campoSeguro('vigencia_solicitud') ?>").val(),
                disponbilidad: $("#<?php echo $this->campoSeguro('diponibilidad') ?>").val(),
                unidad: $("#<?php echo $this->campoSeguro('unidad_ejecutora_hidden') ?>").val()

            },
            success: function (data) {
                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('rubro') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('rubro') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].INTERNO + "'>" + data[ indice ].DESCRIPCION + "</option>").appendTo("#<?php echo $this->campoSeguro('rubro') ?>");

                    });
                    $("#<?php echo $this->campoSeguro('rubro') ?>").removeAttr('disabled');
                    $('#<?php echo $this->campoSeguro('rubro') ?>').width(900);
                    $("#<?php echo $this->campoSeguro('rubro') ?>").select2();


                }




            }

        });
    }
    ;




    function infodisponibilidades(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinalInfoDisponibilidades ?>",
            dataType: "json",
            data: {vigencia: $("#<?php echo $this->campoSeguro('vigencia_solicitud') ?>").val(),
                disponibilidad: $("#<?php echo $this->campoSeguro('diponibilidad') ?>").val(),
                unidad: $("#<?php echo $this->campoSeguro('unidad_ejecutora_hidden') ?>").val(),
                numsolicitud: $("#<?php echo $this->campoSeguro('numero_solicitud') ?>").val()},
            success: function (data) {

                if (data[0] != "null") {
                    $("#<?php echo $this->campoSeguro('fecha_diponibilidad') ?>").val(data[0]);
                    $("#<?php echo $this->campoSeguro('valor_disponibilidad') ?>").val(data[1]);
                    $("#<?php echo $this->campoSeguro('valor_solicitud') ?>").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required,minSize[1],custom[number],max[" + data[1] + "]] ");



                }




            }

        });
    }
    ;




    function valorLetras(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinalLetrasNumeros ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('valor_solicitud') ?>").val()},
            success: function (data) {


                $("#<?php echo $this->campoSeguro('valorLetras_disponibilidad') ?>").val(data);

            }

        });
    }
    ;



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


                }


            }

        });
    }
    ;


    function consultarDependenciaConsultada(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal16 ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('sedeConsulta') ?>").val()},
            success: function (data) {




                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('dependenciaConsulta') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('dependenciaConsulta') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].id_dependencia + "'>" + data[ indice ].ESF_DEP_ENCARGADA + "</option>").appendTo("#<?php echo $this->campoSeguro('dependenciaConsulta') ?>");

                    });

                    $("#<?php echo $this->campoSeguro('dependenciaConsulta') ?>").removeAttr('disabled');

                    $('#<?php echo $this->campoSeguro('dependenciaConsulta') ?>').width(300);
                    $("#<?php echo $this->campoSeguro('dependenciaConsulta') ?>").select2();



                }


            }

        });
    }
    ;



    $(function () {


        $("#<?php echo $this->campoSeguro('sedeConsulta') ?>").change(function () {
            if ($("#<?php echo $this->campoSeguro('sedeConsulta') ?>").val() != '') {
                consultarDependenciaConsultada();
            } else {
                $("#<?php echo $this->campoSeguro('dependenciaConsulta') ?>").attr('disabled', '');
            }

        });


        $("#<?php echo $this->campoSeguro('nitproveedor') ?>").keyup(function () {


            $('#<?php echo $this->campoSeguro('nitproveedor') ?>').val($('#<?php echo $this->campoSeguro('nitproveedor') ?>').val());


        });




        $("#<?php echo $this->campoSeguro('nitproveedor') ?>").autocomplete({
            minChars: 3,
            serviceUrl: '<?php echo $urlFinalProveedor; ?>',
            onSelect: function (suggestion) {

                $("#<?php echo $this->campoSeguro('id_proveedor') ?>").val(suggestion.data);
            }

        });






        $("#<?php echo $this->campoSeguro('tipo_orden') ?>").change(function () {

            if ($("#<?php echo $this->campoSeguro('tipo_orden') ?>").val() != '') {

                numero_orden();

            } else {
            }


        });



        $("#<?php echo $this->campoSeguro('numero_solicitud') ?>").change(function () {

            if ($("#<?php echo $this->campoSeguro('numero_solicitud') ?>").val() != '') {

            $("#<?php echo $this->campoSeguro('rubro') ?>").attr('disabled', '');
                disponibilidades();


            } else {
            }


        });



        $("#<?php echo $this->campoSeguro('diponibilidad') ?>").change(function () {

            if ($("#<?php echo $this->campoSeguro('diponibilidad') ?>").val() != '') {

                rubro();


            } else {
            }


        });










        $("#<?php echo $this->campoSeguro('unidad_ejecutora') ?>").change(function () {

            if ($("#<?php echo $this->campoSeguro('unidad_ejecutora') ?>").val() != '') {

                disponibilidades();

            } else {
            }


        });


        $("#<?php echo $this->campoSeguro('diponibilidad') ?>").change(function () {

            if ($("#<?php echo $this->campoSeguro('diponibilidad') ?>").val() != '') {

                infodisponibilidades();


            }


        });

        $("#<?php echo $this->campoSeguro('valor_solicitud') ?>").change(function () {

            if ($("#<?php echo $this->campoSeguro('valor_solicitud') ?>").val() != '') {

                valorLetras();


            }


        });








    });



</script>

