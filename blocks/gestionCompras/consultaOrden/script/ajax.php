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
$cadenaACodificar .= $cadenaACodificar . "&funcion=letrasNumeros";
$cadenaACodificar .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar, $enlace);

// URL definitiva
$urlFinal = $url . $cadena;

// Variables
$cadenaACodificar6 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar6 .= "&procesarAjax=true";
$cadenaACodificar6 .= "&action=index.php";
$cadenaACodificar6 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar6 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar6 .= $cadenaACodificar . "&funcion=SeleccionOrdenador";
$cadenaACodificar6 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace6 = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena6 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar6, $enlace6);

// URL definitiva
$urlFinal6 = $url . $cadena6;

// Variables
$cadenaACodificar7 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar7 .= "&procesarAjax=true";
$cadenaACodificar7 .= "&action=index.php";
$cadenaACodificar7 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar7 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar7 .= $cadenaACodificar . "&funcion=SeleccionCargo";
$cadenaACodificar7 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace7 = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena7 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar7, $enlace7);

// URL definitiva
$urlFinal7 = $url . $cadena7;

// Variables
$cadenaACodificar9 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar9 .= "&procesarAjax=true";
$cadenaACodificar9 .= "&action=index.php";
$cadenaACodificar9 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar9 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar9 .= $cadenaACodificar9 . "&funcion=letrasNumeros";
$cadenaACodificar9 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena9 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar9, $enlace);

// URL definitiva
$urlFinal9 = $url . $cadena9;

// Variables
$cadenaACodificar10 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar10 .= "&procesarAjax=true";
$cadenaACodificar10 .= "&action=index.php";
$cadenaACodificar10 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar10 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar10 .= $cadenaACodificar10 . "&funcion=disponibilidades";
$cadenaACodificar10 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena10 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar10, $enlace);

// URL definitiva
$urlFinal10 = $url . $cadena10;

// Variables
$cadenaACodificar12 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar12 .= "&procesarAjax=true";
$cadenaACodificar12 .= "&action=index.php";
$cadenaACodificar12 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar12 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar12 .= $cadenaACodificar12 . "&funcion=Infodisponibilidades";
$cadenaACodificar12 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena12 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar12, $enlace);

// URL definitiva
$urlFinal12 = $url . $cadena12;

// Variables
$cadenaACodificar13 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar13 .= "&procesarAjax=true";
$cadenaACodificar13 .= "&action=index.php";
$cadenaACodificar13 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar13 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar13 .= $cadenaACodificar13 . "&funcion=registroPresupuestal";
$cadenaACodificar13 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena13 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar13, $enlace);

// URL definitiva
$urlFinal13 = $url . $cadena13;

// Variables
$cadenaACodificar14 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar14 .= "&procesarAjax=true";
$cadenaACodificar14 .= "&action=index.php";
$cadenaACodificar14 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar14 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar14 .= $cadenaACodificar14 . "&funcion=Inforegistro";
$cadenaACodificar14 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena14 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar14, $enlace);

// URL definitiva
$urlFinal14 = $url . $cadena14;

// Variables
$cadenaACodificar15 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar15 .= "&procesarAjax=true";
$cadenaACodificar15 .= "&action=index.php";
$cadenaACodificar15 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar15 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar15 .= $cadenaACodificar15 . "&funcion=consultarContratistas";
$cadenaACodificar15 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena15 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar15, $enlace);

// URL definitiva
$urlFinal15 = $url . $cadena15;

// Variables
$cadenaACodificar16 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar16 .= "&procesarAjax=true";
$cadenaACodificar16 .= "&action=index.php";
$cadenaACodificar16 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar16 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar16 .= $cadenaACodificar16 . "&funcion=consultarDependencia";
$cadenaACodificar16 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena16 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar16, $enlace);

// URL definitiva
$urlFinal16 = $url . $cadena16;

// Variables
$cadenaACodificar17 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar17 .= "&procesarAjax=true";
$cadenaACodificar17 .= "&action=index.php";
$cadenaACodificar17 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar17 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar17 .= $cadenaACodificar17 . "&funcion=consultarCargoSuper";
$cadenaACodificar17 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena17 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar17, $enlace);

// URL definitiva
$urlFinal17 = $url . $cadena17;

// Variables
$cadenaACodificar18 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar18 .= "&procesarAjax=true";
$cadenaACodificar18 .= "&action=index.php";
$cadenaACodificar18 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar18 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar18 .= "&funcion=SeleccionProveedor";
$cadenaACodificar18 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace18 = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena18 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar18, $enlace18);

// URL definitiva
$urlFinal18 = $url . $cadena18;

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

// Variables
$cadenaACodificarTipoBien = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarTipoBien .= "&procesarAjax=true";
$cadenaACodificarTipoBien .= "&action=index.php";
$cadenaACodificarTipoBien .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarTipoBien .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarTipoBien .= "&funcion=SeleccionTipoBien";
$cadenaACodificarTipoBien .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarTipoBien, $enlace);

// URL definitiva
$urlFinalTipobien = $url . $cadena;


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


// Variables
$cadenaACodificarConvenio = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarConvenio .= "&procesarAjax=true";
$cadenaACodificarConvenio .= "&action=index.php";
$cadenaACodificarConvenio .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarConvenio .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarConvenio .= $cadenaACodificarConvenio . "&funcion=consultarConvenio";
$cadenaACodificarConvenio .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaACodificarConvenio = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarConvenio, $enlace);

// URL definitiva
$urlFinalConvenio = $url . $cadenaACodificarConvenio;


$cadenaACodificarConvenioxVigencia = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarConvenioxVigencia .= "&procesarAjax=true";
$cadenaACodificarConvenioxVigencia .= "&action=index.php";
$cadenaACodificarConvenioxVigencia .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarConvenioxVigencia .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarConvenioxVigencia .= $cadenaACodificarConvenioxVigencia . "&funcion=consultarConveniosxvigencia";
$cadenaACodificarConvenioxVigencia .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaACodificarConvenioxVigencia = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarConvenioxVigencia, $enlace);

// URL definitiva
$urlFinalConveniosxvigencia = $url . $cadenaACodificarConvenioxVigencia;



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
?>
<script type='text/javascript'>

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

    function tipo_bien(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinalTipobien ?>",
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
                        $("#<?php echo $this->campoSeguro('cantidad') ?>").removeProp('readonly');

                        $("#<?php echo $this->campoSeguro('cantidad') ?>").val('');

                        $('#<?php echo $this->campoSeguro('cantidad') ?>').removeAttr('disabled');

                        break;

                }








            }

        });
    }
    ;


    //--------------Inicio JavaScript y Ajax Convenios x Vigenca ---------------------------------------------------------------------------------------------    
    $("#<?php echo $this->campoSeguro('vigencia_convenio') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('vigencia_convenio') ?>").val() != '') {
            consultaConveniosxVigencia();
        } else {
            $("#<?php echo $this->campoSeguro('convenio_solicitante') ?>").attr('disabled', '');
        }

    });


    function consultaConveniosxVigencia(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinalConveniosxvigencia ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('vigencia_convenio') ?>").val()},
            success: function (data) {
                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('convenio_solicitante') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('convenio_solicitante') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].value + "'>" + data[ indice ].data + "</option>").appendTo("#<?php echo $this->campoSeguro('convenio_solicitante') ?>");

                    });

                    $("#<?php echo $this->campoSeguro('convenio_solicitante') ?>").removeAttr('disabled');

                    $('#<?php echo $this->campoSeguro('convenio_solicitante') ?>').width(350);
                    $("#<?php echo $this->campoSeguro('convenio_solicitante') ?>").select2();

                }


            }

        });
    }
    ;
//--------------Fin JavaScript y Convenios x Vigenca --------------------------------------------------------------------------------------------------   

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
//--------------Inicio JavaScript y Ajax Nombre Ordenador ---------------------------------------------------------------------------------------------    

    $("#<?php echo $this->campoSeguro('convenio_solicitante') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('convenio_solicitante') ?>").val() != '') {
            datosConvenio();
        } else {
            $("#<?php echo $this->campoSeguro('convenio_solicitante') ?>").val('');
        }



    });
    function datosConvenio(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinalConvenio ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('convenio_solicitante') ?>").val()},
            success: function (data) {

                if (data[0] != 'null') {

                    $("#<?php echo $this->campoSeguro('nombre_convenio_solicitante') ?>").val(data[0]);

                } else {





                }

            }

        });
    }
    ;
//--------------Fin JavaScript y Ajax Nombre Ordenador ---------------------------------------------------------------------------------------------    

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


                }


            }

        });
    }
    ;
//-------------------Fin JavaScript y Ajax numero de orden de acuerdo al tipo de orden ------------------------------------------------------------------

    $("#<?php echo $this->campoSeguro('sede_super') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('sede_super') ?>").val() != '') {
            consultarDependenciaSuper();
        } else {
            $("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").attr('disabled', '');
        }

    });


    function consultarDependenciaSuper(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal16 ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('sede_super') ?>").val()},
            success: function (data) {



                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").html('');
                    $('<option value=" ">Seleccione  ....</option>').appendTo("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].ESF_CODIGO_DEP + "'>" + data[ indice ].ESF_DEP_ENCARGADA + "</option>").appendTo("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>");

                    });

                    $("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").removeAttr('disabled');

                    $('#<?php echo $this->campoSeguro('dependencia_supervisor') ?>').width(400);
                    $("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").select2();



                }


            }

        });
    }
    ;



//--------------Inicio JavaScript y Ajax Sede y Dependencia Solicitante ---------------------------------------------------------------------------------------------    

    $("#<?php echo $this->campoSeguro('sede') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('sede') ?>").val() != '') {
            consultarDependencia();
        } else {
            $("#<?php echo $this->campoSeguro('dependencia_solicitante') ?>").attr('disabled', '');
        }

    });

    function consultarDependencia(elem, request, response) {

        $.ajax({
            url: "<?php echo $urlFinalConsultaDependencia ?>",
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

    //--------------Fin JavaScript y Ajax Sede y Dependencia Suepervisor --------------------------------------------------------------------------------------------------   



    function cargoSuper(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal17 ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('nombre_supervisor') ?>").val()},
            success: function (data) {


                $("#<?php echo $this->campoSeguro('cargo_supervisor') ?>").val(data[0]);
                $("#<?php echo $this->campoSeguro('cargo_inicial') ?>").val(data[0]);

            }

        });
    }
    ;
    function restCargoSuper(elem, request, response) {
        $("#<?php echo $this->campoSeguro('cargo_supervisor') ?>").val($("#<?php echo $this->campoSeguro('cargo_inicial') ?>").val());
    }
    ;



    function datosInfo(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal18 ?>",
            dataType: "json",
            data: {proveedor: $("#<?php echo $this->campoSeguro('id_proveedor') ?>").val()},
            success: function (data) {

                if (data[0] != 'null') {

                    $("#<?php echo $this->campoSeguro('identifcacion_proveedor') ?>").val(data[0]);
                    $("#<?php echo $this->campoSeguro('nombre_razon_proveedor') ?>").val(data[1]);
                    $("#<?php echo $this->campoSeguro('digito_verificacion') ?>").val(data[2]);
                    $("#<?php echo $this->campoSeguro('direccion_proveedor') ?>").val(data[3]);
                    $("#<?php echo $this->campoSeguro('correo_proveedor') ?>").val(data[4]);
                    $("#<?php echo $this->campoSeguro('telefono_proveedor') ?>").val(data[5]);
                    $("#<?php echo $this->campoSeguro('pais') ?>").val(data[6]);
                    var tipo_persona = '';
                    if (data[7] == 'J') {
                        tipo_persona = 'Jurídica'
                    } else {
                        tipo_persona = 'Natural'
                    }
                    ;
                    $("#<?php echo $this->campoSeguro('tipo_persona') ?>").val(tipo_persona);
                    $("#<?php echo $this->campoSeguro('nombre_contratista') ?>").val(data[8]);
                    $("#<?php echo $this->campoSeguro('tipo_documento') ?>").val(data[9]);
                    $("#<?php echo $this->campoSeguro('identifcacion_contratista') ?>").val(data[10]);
                    $("#<?php echo $this->campoSeguro('registro_mercantil') ?>").val(data[11]);
                    $("#<?php echo $this->campoSeguro('cargo_contratista') ?>").val("");


                } else {





                }

            }

        });
    }
    ;








    function consultarDependenciaConsulta(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal16 ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('sede_consultar') ?>").val()},
            success: function (data) {



                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('selec_dependencia_Sol') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('selec_dependencia_Sol') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].ESF_ID_ESPACIO + "'>" + data[ indice ].ESF_NOMBRE_ESPACIO + "</option>").appendTo("#<?php echo $this->campoSeguro('selec_dependencia_Sol') ?>");

                    });

                    $("#<?php echo $this->campoSeguro('selec_dependencia_Sol') ?>").removeAttr('disabled');
                    $('#<?php echo $this->campoSeguro('selec_dependencia_Sol') ?>').width(300);

                    $("#<?php echo $this->campoSeguro('selec_dependencia_Sol') ?>").select2();



                }


            }

        });
    }
    ;






//-------------------------------------------------------------------

    function valorLetras(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('valor_registro') ?>").val()},
            success: function (data) {


                $("#<?php echo $this->campoSeguro('valorLetras_registro') ?>").val(data);

            }

        });
    }
    ;




    function valorLetrasDis(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal9 ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('valor_disponibilidad') ?>").val()},
            success: function (data) {


                $("#<?php echo $this->campoSeguro('valorLetras_disponibilidad') ?>").val(data);

            }

        });
    }
    ;






    function valorLetrasReg(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal9 ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('valor_registro') ?>").val()},
            success: function (data) {


                $("#<?php echo $this->campoSeguro('valorL_registro') ?>").val(data);

            }

        });
    }
    ;


    function datosCargo(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal7 ?>",
            dataType: "json",
            data: {cargo: $("#<?php echo $this->campoSeguro('cargoJefeSeccion') ?>").val()},
            success: function (data) {

                if (data[0] != 'null') {

                    $("#<?php echo $this->campoSeguro('nombreJefeSeccion') ?>").val(data[0]);
                    $("#<?php echo $this->campoSeguro('id_jefe') ?>").val(data[1]);


                } else {





                }

            }

        });
    }
    ;


    function datosCargoDe(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal7 ?>",
            dataType: "json",
            data: {cargo: $("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").val()},
            success: function (data) {

                if (data[0] != 'null') {

                    $("#<?php echo $this->campoSeguro('nombre_supervisor') ?>").val(data[0]);



                } else {





                }

            }

        });
    }
    ;


    function consultarContratistas(elem, request, response) {

        if ($("#<?php echo $this->campoSeguro('selec_proveedor') ?>").val() != "") {


            $.ajax({
                url: "<?php echo $urlFinalProveedor ?>",
                dataType: "json",
                data: {proveedor: $("#<?php echo $this->campoSeguro('selec_proveedor') ?>").val()},
                success: function (data) {

                    if (data != 'null') {

                        if (data.status == 200) {
                            $("#<?php echo $this->campoSeguro('tipo_persona') ?>").val(data.datos.tipo_persona);
                            if (data.datos.tipo_persona != 'NATURAL') {
                                $("#<?php echo $this->campoSeguro('nombre_razon_proveedor') ?>").val(data.datos.nom_empresa);
                                $("#<?php echo $this->campoSeguro('identifcacion_proveedor') ?>").val(data.datos.num_nit_empresa);
                                $("#<?php echo $this->campoSeguro('digito_verificacion') ?>").val(data.datos.digito_verificacion_empresa);
                                $("#<?php echo $this->campoSeguro('telefono_proveedor') ?>").val(data.datos.telefono_empresa + ' - ' + data.datos.movil_empresa);
                                $("#<?php echo $this->campoSeguro('procedencia') ?>").val(data.datos.nom_pais_empresa + ' (' + data.datos.nom_departamento_empresa + ' - ' + data.datos.nom_ciudad_empresa + ')');
                                $("#<?php echo $this->campoSeguro('nombre_acesor') ?>").val(data.datos.nom_asesor_empresa);
                                $("#<?php echo $this->campoSeguro('nombre_contratista') ?>").val(data.datos.primer_nombre_representante + ' '
                                        + data.datos.segundo_nombre_representante + ' ' + data.datos.primer_apellido_representante + ' ' + data.datos.segundo_apellido_representante);
                                $("#<?php echo $this->campoSeguro('tipo_documento') ?>").val(data.datos.tipo_documento_representante);
                                $("#<?php echo $this->campoSeguro('identifcacion_contratista') ?>").val(data.datos.num_documento_representante);
                                $("#<?php echo $this->campoSeguro('cargo_contratista') ?>").val(data.datos.cargo_representante);
                                $("#<?php echo $this->campoSeguro('genero') ?>").val(data.datos.genero_empresa);
                            } else {

                                $("#<?php echo $this->campoSeguro('nombre_razon_proveedor') ?>").val(data.datos.primer_nombre_persona_natural +
                                        ' ' + data.datos.segundo_nombre_persona_natural + ' ' + data.datos.primer_apellido_persona_natural + ' ' +
                                        data.datos.primer_apellido_persona_natural);
                                $("#<?php echo $this->campoSeguro('identifcacion_proveedor') ?>").val(data.datos.num_documento_persona_natural);
                                $("#<?php echo $this->campoSeguro('digito_verificacion') ?>").val(data.datos.digito_verificacion_persona_natural);
                                $("#<?php echo $this->campoSeguro('telefono_proveedor') ?>").val(data.datos.telefono_persona_natural + ' - ' + data.datos.movil_persona_natural);
                                $("#<?php echo $this->campoSeguro('procedencia') ?>").val(data.datos.pais_nacimiento_persona_natural);
                                $("#<?php echo $this->campoSeguro('cargo_contratista') ?>").val(data.datos.cargo_persona_natural);
                                $("#<?php echo $this->campoSeguro('genero') ?>").val(data.datos.genero_persona_natural);
                                $("#<?php echo $this->campoSeguro('tipo_documento') ?>").val(data.datos.tipo_documento_persona_natural);
                                $("#<?php echo $this->campoSeguro('nombre_acesor') ?>").val('N/A');
                                $("#<?php echo $this->campoSeguro('nombre_contratista') ?>").val('N/A');
                                $("#<?php echo $this->campoSeguro('identifcacion_contratista') ?>").val('N/A');

                            }


                            $("#<?php echo $this->campoSeguro('direccion_proveedor') ?>").val(data.datos.dir_contacto);
                            $("#<?php echo $this->campoSeguro('sitio_web') ?>").val(data.datos.web_contacto);
                            $("#<?php echo $this->campoSeguro('pais') ?>").val(data.datos.nom_pais_contacto + ' (' + data.datos.nom_departamento_contacto + ' - ' + data.datos.nom_ciudad_contacto + ')');


                            $("#<?php echo $this->campoSeguro('correo_proveedor') ?>").val(data.datos.correo_contacto);

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


    function datosOrdenador(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal6 ?>",
            dataType: "json",
            data: {ordenador: $("#<?php echo $this->campoSeguro('asignacionOrdenador') ?>").val()},
            success: function (data) {

                if (data[0] != 'null') {

                    $("#<?php echo $this->campoSeguro('nombreOrdenador') ?>").val(data[0]);
                    $("#<?php echo $this->campoSeguro('id_ordenador') ?>").val(data[1]);
                    $("#<?php echo $this->campoSeguro('tipo_ordenador') ?>").val(data[2]);

                } else {





                }

            }

        });
    }
    ;





    $(function () {


        $("#<?php echo $this->campoSeguro('unidad_ejecutora') ?>").change(function () {

            if ($("#<?php echo $this->campoSeguro('unidad_ejecutora') ?>").val() != '') {

                disponibilidades();

            } else {
            }


        });



//----














//----


        $("#<?php echo $this->campoSeguro('cantidad') ?>").keyup(function () {

            $("#<?php echo $this->campoSeguro('valor') ?>").val('');
            $("#<?php echo $this->campoSeguro('subtotal_sin_iva') ?>").val('');
            $("#<?php echo $this->campoSeguro('total_iva') ?>").val('');
            $("#<?php echo $this->campoSeguro('total_iva_con') ?>").val('');

        });



        $("#<?php echo $this->campoSeguro('valor') ?>").keyup(function () {
            $("#<?php echo $this->campoSeguro('subtotal_sin_iva') ?>").val('');
            $("#<?php echo $this->campoSeguro('total_iva') ?>").val('');
            $("#<?php echo $this->campoSeguro('total_iva_con') ?>").val('');

            cantidad = Number($("#<?php echo $this->campoSeguro('cantidad') ?>").val());
            valor = Number($("#<?php echo $this->campoSeguro('valor') ?>").val());

            precio = cantidad * valor;


            if (precio == 0) {
                $("#<?php echo $this->campoSeguro('subtotal_sin_iva') ?>").val('');
            } else {
                $("#<?php echo $this->campoSeguro('subtotal_sin_iva') ?>").val(precio);
            }

        });









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



        $("#<?php echo $this->campoSeguro('nombre_supervisor') ?>").change(function () {

            if ($("#<?php echo $this->campoSeguro('nombre_supervisor') ?>").val() != '') {
                cargoSuper();
            }

        });









        $("#<?php echo $this->campoSeguro('vigencia_contratista') ?>").change(function () {

            if ($("#<?php echo $this->campoSeguro('vigencia_contratista') ?>").val() != '') {

                contratistasC();

            } else {
            }


        });

        $("#<?php echo $this->campoSeguro('vigencia_disponibilidad') ?>").change(function () {

            if ($("#<?php echo $this->campoSeguro('vigencia_disponibilidad') ?>").val() != '') {

                disponibilidades();

            } else {
            }


        });




        $("#<?php echo $this->campoSeguro('nivel') ?>").change(function () {

            if ($("#<?php echo $this->campoSeguro('nivel') ?>").val() != '') {

                tipo_bien();

            } else {
            }

        });



        $("#<?php echo $this->campoSeguro('diponibilidad') ?>").change(function () {

            if ($("#<?php echo $this->campoSeguro('diponibilidad') ?>").val() != '') {

                infodisponibilidades();
                registrosP();

            } else {
            }


        });











        $("#<?php echo $this->campoSeguro('registro') ?>").change(function () {

            if ($("#<?php echo $this->campoSeguro('registro') ?>").val() != '') {

                inforegistrosP();

            } else {
            }


        });



        $("#<?php echo $this->campoSeguro('nombreContratista') ?>").select2({
            placeholder: "Search for a repository",
            minimumInputLength: 3,
        });

        $("#<?php echo $this->campoSeguro('valor_registro') ?>").keyup(function () {


            if ($("#<?php echo $this->campoSeguro('valor_registro') ?>").val() != "") {

                valorLetras();

            } else {

                $("#<?php echo $this->campoSeguro('valorLetras_registro') ?>").val('');


            }

        });


        $("#<?php echo $this->campoSeguro('asignacionOrdenador') ?>").change(function () {

            if ($("#<?php echo $this->campoSeguro('asignacionOrdenador') ?>").val() != '') {
                datosOrdenador();
            } else {
                $("#<?php echo $this->campoSeguro('nombreOrdenador') ?>").val('');
            }



        });

        $("#<?php echo $this->campoSeguro('cargoJefeSeccion') ?>").change(function () {


            if ($("#<?php echo $this->campoSeguro('cargoJefeSeccion') ?>").val() != '') {
                datosCargo();
            } else {
                $("#<?php echo $this->campoSeguro('nombreJefeSeccion') ?>").val('');
            }


        });





        $("#<?php echo $this->campoSeguro('sede_consultar') ?>").change(function () {

            if ($("#<?php echo $this->campoSeguro('sede_consultar') ?>").val() != '') {
                consultarDependenciaConsulta();
            } else if ($("#<?php echo $this->campoSeguro('sede_consultar') ?>").val() == '') {

                $('#<?php echo $this->campoSeguro('selec_dependencia_Sol') ?>').removeClass("select2");

                $("#<?php echo $this->campoSeguro('selec_dependencia_Sol') ?>").html('');

                $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('selec_dependencia_Sol') ?>");
                $("#<?php echo $this->campoSeguro('selec_dependencia_Sol') ?>").attr('disabled', '');
            }

        });





        $("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").change(function () {


            if ($("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").val() != '') {
                datosCargoDe();
            } else {
                $("#<?php echo $this->campoSeguro('nombre_supervisor') ?>").val('');
            }


        });


        function disponibilidades(elem, request, response) {
            $.ajax({
                url: "<?php echo $urlFinal10 ?>",
                dataType: "json",
                data: {vigencia: $("#<?php echo $this->campoSeguro('vigencia_disponibilidad') ?>").val(),
                    unidad: $("#<?php echo $this->campoSeguro('unidad_ejecutora') ?>").val()},
                success: function (data) {
                    if (data[0] != " ") {

                        $("#<?php echo $this->campoSeguro('diponibilidad') ?>").html('');
                        $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('diponibilidad') ?>");
                        $.each(data, function (indice, valor) {

                            $("<option value='" + data[ indice ].identificador + "'>" + data[ indice ].numero + "</option>").appendTo("#<?php echo $this->campoSeguro('diponibilidad') ?>");

                        });
                        $("#<?php echo $this->campoSeguro('diponibilidad') ?>").removeAttr('disabled');

                        $("#<?php echo $this->campoSeguro('diponibilidad') ?>").select2({
                            placeholder: "Search for a repository",
                            minimumInputLength: 1,
                        });


                    }




                }

            });
        }
        ;


        function infodisponibilidades(elem, request, response) {
            $.ajax({
                url: "<?php echo $urlFinal12 ?>",
                dataType: "json",
                data: {vigencia: $("#<?php echo $this->campoSeguro('vigencia_disponibilidad') ?>").val(),
                    disponibilidad: $("#<?php echo $this->campoSeguro('diponibilidad') ?>").val()},
                success: function (data) {

                    if (data[0] != "null") {
                        $("#<?php echo $this->campoSeguro('fecha_diponibilidad') ?>").val(data[0]);
                        $("#<?php echo $this->campoSeguro('valor_disponibilidad') ?>").val(data[1]);

                        valorLetrasDis();


                    }




                }

            });
        }
        ;


        function registrosP(elem, request, response) {

            $.ajax({
                url: "<?php echo $urlFinal13 ?>",
                dataType: "json",
                data: {vigencia: $("#<?php echo $this->campoSeguro('vigencia_disponibilidad') ?>").val(),
                    disponibilidad: $("#<?php echo $this->campoSeguro('diponibilidad') ?>").val(),
                    unidad: $("#<?php echo $this->campoSeguro('unidad_ejecutora') ?>").val()},
                success: function (data) {
                    if (data[0] != " ") {

                        $("#<?php echo $this->campoSeguro('registro') ?>").html('');
                        $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('registro') ?>");
                        $.each(data, function (indice, valor) {

                            $("<option value='" + data[ indice ].identificador + "'>" + data[ indice ].numero + "</option>").appendTo("#<?php echo $this->campoSeguro('registro') ?>");

                        });

                        $("#<?php echo $this->campoSeguro('registro') ?>").removeAttr('disabled');

                        $("#<?php echo $this->campoSeguro('registro') ?>").select2();


                    }




                }

            });
        }
        ;



        function inforegistrosP(elem, request, response) {
            $.ajax({
                url: "<?php echo $urlFinal14 ?>",
                dataType: "json",
                data: {vigencia: $("#<?php echo $this->campoSeguro('vigencia_disponibilidad') ?>").val(),
                    registro: $("#<?php echo $this->campoSeguro('registro') ?>").val()},
                success: function (data) {

                    if (data[0] != "null") {
                        $("#<?php echo $this->campoSeguro('fecha_registro') ?>").val(data[0]);
                        $("#<?php echo $this->campoSeguro('valor_registro') ?>").val(data[1]);

                        valorLetrasReg();


                    }




                }

            });
        }
        ;


        function contratistasC(elem, request, response) {

            $.ajax({
                url: "<?php echo $urlFinal15 ?>",
                dataType: "json",
                data: {vigencia: $("#<?php echo $this->campoSeguro('vigencia_contratista') ?>").val()},
                success: function (data) {
                    if (data[0] != " ") {

                        $("#<?php echo $this->campoSeguro('nombreContratista') ?>").html('');
                        $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('nombreContratista') ?>");
                        $.each(data, function (indice, valor) {

                            $("<option value='" + data[ indice ].IDENTIFICADOR + "'>" + data[ indice ].CONTRATISTA + "</option>").appendTo("#<?php echo $this->campoSeguro('nombreContratista') ?>");

                        });

                        $("#<?php echo $this->campoSeguro('nombreContratista') ?>").removeAttr('disabled');


                        $('#<?php echo $this->campoSeguro('nombreContratista') ?>').attr("style", "width: 400px ; '");

                        $("#<?php echo $this->campoSeguro('nombreContratista') ?>").select2({
                            placeholder: "Search for a repository",
                            minimumInputLength: 3,
                        });


                    }





                }

            });
        }
        ;


    });

    $("#<?php echo $this->campoSeguro('cargosExistentes') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('cargosExistentes') ?>").val() != '') {
            $("#<?php echo $this->campoSeguro('cargo_supervisor') ?>").val($("#<?php echo $this->campoSeguro('cargosExistentes') ?>").val());
            $("#<?php echo $this->campoSeguro('cargosExistentes') ?>").val("");

        }


    });

</script>

<script>

    function registrarNuevoCargo() {
        var cargo = prompt("Por favor digite el nuevo cargo:", "");

        if (cargo != null) {
            var Campo = document.getElementById("<?php echo $this->campoSeguro('cargo_supervisor') ?>");
            Campo.value = cargo;
        }
    }



</script> 