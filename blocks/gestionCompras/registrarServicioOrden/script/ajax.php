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
$cadenaACodificariva = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificariva .= "&procesarAjax=true";
$cadenaACodificariva .= "&action=index.php";
$cadenaACodificariva .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificariva .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificariva .= "&funcion=consultarIva";
$cadenaACodificariva .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaiva = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificariva, $enlace);

// URL definitiva
$urlFinaliva = $url . $cadenaiva;


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
$cadenaACodificarDependencia = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarDependencia .= "&procesarAjax=true";
$cadenaACodificarDependencia .= "&action=index.php";
$cadenaACodificarDependencia .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarDependencia .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarDependencia .= $cadenaACodificarDependencia . "&funcion=consultarDependencias";
$cadenaACodificarDependencia .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaDependencia = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarDependencia, $enlace);

// URL definitiva
$urlFinalDependencia = $url . $cadenaDependencia;

// Variables
$cadenaACodificarServicio = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarServicio .= "&procesarAjax=true";
$cadenaACodificarServicio .= "&action=index.php";
$cadenaACodificarServicio .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarServicio .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarServicio .= $cadenaACodificarServicio . "&funcion=consultarServicios";
$cadenaACodificarServicio .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaServicio = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarServicio, $enlace);

// URL definitiva
$urlFinalServicio = $url . $cadenaServicio;

$cadenaACodificarInformacionConvenio = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarInformacionConvenio .= "&procesarAjax=true";
$cadenaACodificarInformacionConvenio .= "&action=index.php";
$cadenaACodificarInformacionConvenio .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarInformacionConvenio .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarInformacionConvenio .= $cadenaACodificarInformacionConvenio . "&funcion=consultarInfoConvenio";
$cadenaACodificarInformacionConvenio .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaACodificarInformacionConvenio = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarInformacionConvenio, $enlace);

// URL definitiva
$urlInformacionConvenio = $url . $cadenaACodificarInformacionConvenio;
?>
<script type='text/javascript'>


//--------------Inicio JavaScript y Ajax Sede y Dependencia elemento ---------------------------------------------------------------------------------------------    

    $("#<?php echo $this->campoSeguro('sede') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('sede') ?>").val() != '') {
            consultarDependencia();
        } else {
            $("#<?php echo $this->campoSeguro('dependencia_solicitante') ?>").attr('disabled', '');
        }

    });

    function consultarDependencia(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinalDependencia ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('sede') ?>").val()},
            success: function (data) {



                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('dependencia_solicitante') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('dependencia_solicitante') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].ESF_CODIGO_DEP + "'>" + data[ indice ].ESF_DEP_ENCARGADA + "</option>").appendTo("#<?php echo $this->campoSeguro('dependencia_solicitante') ?>");

                    });

                    $("#<?php echo $this->campoSeguro('dependencia_solicitante') ?>").removeAttr('disabled');

                    $('#<?php echo $this->campoSeguro('dependencia_solicitante') ?>').width(350);
                    $("#<?php echo $this->campoSeguro('dependencia_solicitante') ?>").select2();



                }


            }

        });
    }
    ;

    //--------------Fin JavaScript y Ajax Sede y Dependencia elemento --------------------------------------------------------------------------------------------------   

//--------------Inicio JavaScript y Ajax Clase servicio y servicio---------------------------------------------------------------------------------------------    

    $("#<?php echo $this->campoSeguro('tipo_servicio') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('tipo_servicio') ?>").val() != '') {
            consultarServicios();
        } else {
            $("#<?php echo $this->campoSeguro('codigo_ciiu') ?>").attr('disabled', '');
        }

    });

    function consultarServicios(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinalServicio ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('tipo_servicio') ?>").val()},
            success: function (data) {



                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('codigo_ciiu') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('codigo_ciiu') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].id_subclase + "'>" + data[ indice ].nombre + "</option>").appendTo("#<?php echo $this->campoSeguro('codigo_ciiu') ?>");

                    });

                    $("#<?php echo $this->campoSeguro('codigo_ciiu') ?>").removeAttr('disabled');

                    $('#<?php echo $this->campoSeguro('codigo_ciiu') ?>').width(350);
                    $("#<?php echo $this->campoSeguro('codigo_ciiu') ?>").select2();



                }


            }

        });
    }
    ;

    //--------------Fin JavaScript y Ajax Clase Servicio y servicio --------------------------------------------------------------------------------------------------   




    function resetIva(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinaliva ?>",
            dataType: "json",
            success: function (data) {




                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('iva') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('iva') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].id_iva + "'>" + data[ indice ].descripcion + "</option>").appendTo("#<?php echo $this->campoSeguro('iva') ?>");

                    });


                    $('#<?php echo $this->campoSeguro('iva') ?>').width(150);
                    $("#<?php echo $this->campoSeguro('iva') ?>").select2();



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



    function tipo_bien(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('nivel') ?>").val()},
            success: function (data) {


                $("#<?php echo $this->campoSeguro('id_tipo_bien') ?>").val(data[0]);
                $("#<?php echo $this->campoSeguro('tipo_bien') ?>").val(data[1]);

                switch ($("#<?php echo $this->campoSeguro('id_tipo_bien') ?>").val())
                {


                    case '2':


                        $("#<?php echo $this->campoSeguro('devolutivo') ?>").css('display', 'none');
                        $("#<?php echo $this->campoSeguro('consumo_controlado') ?>").css('display', 'block');
                        $("#<?php echo $this->campoSeguro('cantidad') ?>").val('1');
                        $('#<?php echo $this->campoSeguro('cantidad') ?>').attr('disabled', '');

                        break;

                    case '3':

                        $("#<?php echo $this->campoSeguro('devolutivo') ?>").css('display', 'block');
                        $("#<?php echo $this->campoSeguro('consumo_controlado') ?>").css('display', 'none');
                        $("#<?php echo $this->campoSeguro('tipo_poliza') ?>").select2();
                        $("#<?php echo $this->campoSeguro('cantidad') ?>").val('1');
                        $('#<?php echo $this->campoSeguro('cantidad') ?>').attr('disabled', '');

                        break;


                        break;


                    default:

                        $("#<?php echo $this->campoSeguro('devolutivo') ?>").css('display', 'none');
                        $("#<?php echo $this->campoSeguro('consumo_controlado') ?>").css('display', 'none');


                        $("#<?php echo $this->campoSeguro('cantidad') ?>").val('');
                        $('#<?php echo $this->campoSeguro('cantidad') ?>').removeAttr('disabled');

                        break;

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
            serviceUrl: '<?php echo $urlProveedorFiltro; ?>',
            onSelect: function (suggestion) {

                $("#<?php echo $this->campoSeguro('id_proveedor') ?>").val(suggestion.data);
            }

        });




        $("#<?php echo $this->campoSeguro('nivel') ?>").change(function () {

            if ($("#<?php echo $this->campoSeguro('nivel') ?>").val() != '') {

                tipo_bien();

            } else {
            }








        });




        $("#<?php echo $this->campoSeguro('tipo_orden') ?>").change(function () {

            if ($("#<?php echo $this->campoSeguro('tipo_orden') ?>").val() != '') {

                numero_orden();

            } else {
            }


        });


    });


    function VerInfoConvenio(informacionConvenio) {
        $.ajax({
            url: "<?php echo $urlInformacionConvenio ?>",
            dataType: "json",
            data: {codigo: informacionConvenio},
            success: function (data) {
                if (data[0] != " ") {

                    var objetoSPAN = document.getElementById('spandid');
                    objetoSPAN.innerHTML = "Información del Convenio :<br><br><br>" + "Numero de Convenio: " + data[0] + " <br><br> "
                            + "Vigencia: " + data[3] + " <br><br>"
                            + "Nombre: " + data[5] + " <br><br>"
                            + "Descripcion: " + data[4] + " <br><br>"
                            + "Entidad: " + data[6] + " <br><br>"
                            + "Codigo Tesoral: " + data[7] + " <br><br>"
                            + "Fecha Inicio: " + data[8] + " <br><br>"
                            + "Fecha de Finalizacion: " + data[9] + " <br><br>"
                            + "Situacion: " + data[10] + " <br><br>"
                            + "Unidad: " + data[11] + " <br><br>"
                            + "Estado: " + data[12] + " <br><br>"
                            + "Modalidad: " + data[13] + " <br><br>";
                    $("#ventanaEmergenteConvenio").dialog("open");


                }
            }

        });

    }

</script>

