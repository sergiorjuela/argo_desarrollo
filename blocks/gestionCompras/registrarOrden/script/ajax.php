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
$cadenaACodificarDependencia = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarDependencia .= "&procesarAjax=true";
$cadenaACodificarDependencia .= "&action=index.php";
$cadenaACodificarDependencia .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarDependencia .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarDependencia .= $cadenaACodificarDependencia . "&funcion=consultarDependencia";
$cadenaACodificarDependencia .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaDependencia = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarDependencia, $enlace);

// URL definitiva
$urlFinalDependencia = $url . $cadenaDependencia;







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

// Variables

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
?>
<script type='text/javascript'>




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

    //--------------Fin JavaScript y Ajax Sede y Dependencia Suepervisor --------------------------------------------------------------------------------------------------   


    //--------------Inicio JavaScript y Ajax Sede y Dependencia Suepervisor ---------------------------------------------------------------------------------------------    
    $("#<?php echo $this->campoSeguro('sede_super') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('sede_super') ?>").val() != '') {
            consultarDependenciaSuper();
        } else {
            $("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").attr('disabled', '');
        }

    });


    function consultarDependenciaSuper(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinalDependencia ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('sede_super') ?>").val()},
            success: function (data) {
                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].ESF_CODIGO_DEP + "'>" + data[ indice ].ESF_DEP_ENCARGADA + "</option>").appendTo("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>");

                    });

                    $("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").removeAttr('disabled');

                    $('#<?php echo $this->campoSeguro('dependencia_supervisor') ?>').width(350);
                    $("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").select2();

                }


            }

        });
    }
    ;
//--------------Fin JavaScript y Ajax Sede y Dependencia Suepervisor --------------------------------------------------------------------------------------------------   
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

//--------------Inicio JavaScript y Ajax Cargo Suepervisor ---------------------------------------------------------------------------------------------    


    $("#<?php echo $this->campoSeguro('nombre_supervisor') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('nombre_supervisor') ?>").val() != '') {
            cargoSuper();
        }

    });

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


//--------------Fin JavaScript y Ajax Cargo Suepervisor ---------------------------------------------------------------------------------------------    


//--------------Inicio JavaScript y Ajax Nombre Ordenador ---------------------------------------------------------------------------------------------    

    $("#<?php echo $this->campoSeguro('asignacionOrdenador') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('asignacionOrdenador') ?>").val() != '') {
            datosOrdenador();
        } else {
            $("#<?php echo $this->campoSeguro('nombreOrdenador') ?>").val('');
        }



    });
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
//--------------Fin JavaScript y Ajax Nombre Ordenador ---------------------------------------------------------------------------------------------    
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



//---------------Inicio JavaScript y Ajax Letras ---------------------------------------------------------------------------------------------------

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

//---------------Fin JavaScript y Ajax Letras --------------selec_proveedor-------------------------------------------------------------------------------------

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

                            $("#<?php echo $this->campoSeguro('tipo_persona') ?>").val(data.datos.tipo_persona);
                            
                            if (data.datos.tipo_persona != 'NATURAL') {
                                $("#<?php echo $this->campoSeguro('nombre_razon_proveedor') ?>").val(data.datos.nom_empresa);
                                $("#<?php echo $this->campoSeguro('identifcacion_proveedor') ?>").val('NIT: ' + data.datos.num_nit_empresa);
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
                                        data.datos.segundo_nombre_persona_natural);
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

//-------------------------------------------------------------------------------------------------------------------------
//    $("#<?php echo $this->campoSeguro('selec_proveedor') ?>").keyup(function () {
//        $('#<?php echo $this->campoSeguro('selec_proveedor') ?>').val($('#<?php echo $this->campoSeguro('selec_proveedor') ?>').val());
//    });

//
//    $("#<?php echo $this->campoSeguro('selec_proveedor') ?>").autocomplete({
//        minChars: 8,
//        serviceUrl: '<?php echo $urlFinalProveedor; ?>',
//        onSelect: function (data) {
//
//           alert(data.data[0]);
//        }
//
//    });
//------------------------------------------------------------------------------------------------------------------------

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
                    $("#<?php echo $this->campoSeguro('cargo_contratista') ?>").val('');


                } else {





                }

            }

        });
    }
    ;

//---------------Fin JavaScript y Ajax Proveedor ---------------------------------------------------------------------------------------------------






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

    $(function () {


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

        $("#<?php echo $this->campoSeguro('unidad_ejecutora') ?>").change(function () {

            if ($("#<?php echo $this->campoSeguro('unidad_ejecutora') ?>").val() != '') {

                disponibilidades();

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


        $("#<?php echo $this->campoSeguro('valor_registro') ?>").keyup(function () {


            if ($("#<?php echo $this->campoSeguro('valor_registro') ?>").val() != "") {

                valorLetras();

            } else {

                $("#<?php echo $this->campoSeguro('valorLetras_registro') ?>").val('');


            }

        });

        $("#<?php echo $this->campoSeguro('cargoJefeSeccion') ?>").change(function () {


            if ($("#<?php echo $this->campoSeguro('cargoJefeSeccion') ?>").val() != '') {
                datosCargo();
            } else {
                $Inicio("#<?php echo $this->campoSeguro('nombreJefeSeccion') ?>").val('');
            }


        });


        $("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").change(function () {


            if ($("#<?php echo $this->campoSeguro('dependencia_supervisor') ?>").val() != '') {
                datosCargoDe();
            } else {
                $("#<?php echo $this->campoSeguro('nombre_supervisor') ?>").val('');
            }


        });

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




                    $('#<?php echo $this->campoSeguro('diponibilidad') ?>').width(300);
                    $("#<?php echo $this->campoSeguro('diponibilidad') ?>").select2({
                        placeholder: "Ingrese Mínimo 1 Caracter",
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
                disponibilidad: $("#<?php echo $this->campoSeguro('diponibilidad') ?>").val(),
                unidad: $("#<?php echo $this->campoSeguro('unidad_ejecutora') ?>").val()},
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




    function registrosPresupuestales(elem, request, response) {
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


                    $('#<?php echo $this->campoSeguro('nombreContratista') ?>').attr("style", "width: 25 ; '");

                    $("#<?php echo $this->campoSeguro('nombreContratista') ?>").select2({
                        placeholder: "Search for a repository",
                        minimumInputLength: 3,
                    });


                }





            }

        });
    }
    ;


    $("#<?php echo $this->campoSeguro('cargosExistentes') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('cargosExistentes') ?>").val() != '') {
            $("#<?php echo $this->campoSeguro('cargo_supervisor') ?>").val($("#<?php echo $this->campoSeguro('cargosExistentes') ?>").val());
            $("#<?php echo $this->campoSeguro('cargosExistentes') ?>").val("");

        }


    });



    //--------------Inicio JavaScript y Ajax Vigencia y Numero solicitud ---------------------------------------------------------------------------------------------    

    $("#<?php echo $this->campoSeguro('vigencia_solicitud_consulta') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('vigencia_solicitud_consulta') ?>").val() != '') {
            $("#<?php echo $this->campoSeguro('numero_cdp') ?>").attr('disabled', '');
            consultarSoliditudyCdp();
        } else {
            $("#<?php echo $this->campoSeguro('vigencia_solicitud_consulta') ?>").attr('disabled', '');
        }

    });

    function consultarSoliditudyCdp(elem, request, response) {

        $.ajax({
            url: "<?php echo $urlFinalSolCdp ?>",
            dataType: "json",
            data: {vigencia: $("#<?php echo $this->campoSeguro('vigencia_solicitud_consulta') ?>").val(),
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
                vigencia: $("#<?php echo $this->campoSeguro('vigencia_solicitud_consulta') ?>").val(),
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

