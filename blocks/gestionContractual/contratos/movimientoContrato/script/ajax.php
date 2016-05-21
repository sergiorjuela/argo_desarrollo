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
$cadenaACodificarDisponibilidad = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarDisponibilidad.= "&procesarAjax=true";
$cadenaACodificarDisponibilidad.= "&action=index.php";
$cadenaACodificarDisponibilidad.= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarDisponibilidad.= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarDisponibilidad.= "&funcion=consultaDisponibilidad";
$cadenaACodificarDisponibilidad.= "&usuario=" . $_REQUEST['usuario'];
$cadenaACodificarDisponibilidad.="&tiempo=" . $_REQUEST['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaDisponibilidad = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarDisponibilidad, $enlace);

// URL definitiva
$urlDisponibilidad = $url . $cadenaDisponibilidad;


// Variables
$cadenaACodificarRegistro = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarRegistro.= "&procesarAjax=true";
$cadenaACodificarRegistro.= "&action=index.php";
$cadenaACodificarRegistro.= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarRegistro.= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarRegistro.= "&funcion=consultaRegistro";
$cadenaACodificarRegistro.= "&usuario=" . $_REQUEST['usuario'];
$cadenaACodificarRegistro.="&tiempo=" . $_REQUEST['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaRegistro = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarRegistro, $enlace);

// URL definitiva
$urlRegistro = $url . $cadenaRegistro;
?>

<script type='text/javascript'>

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

        $("#<?php echo $this->campoSeguro('vigencia') ?>").change(function () {
            if ($("#<?php echo $this->campoSeguro('vigencia') ?>").val() != '') {
                consultarDisponibilidad();
            } else {
                $("#<?php echo $this->campoSeguro('numero_disponibilidad') ?>").attr('disabled', '');
            }
        });


        $("#<?php echo $this->campoSeguro('numero_disponibilidad') ?>").change(function () {
            if ($("#<?php echo $this->campoSeguro('numero_disponibilidad') ?>").val() != '') {
                consultarRegistro();
            } else {
                $("#<?php echo $this->campoSeguro('numero_registro') ?>").attr('disabled', '');
            }
        });


    });


    function consultarDisponibilidad(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlDisponibilidad ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('vigencia') ?>").val(), valor2: $("#<?php echo $this->campoSeguro('unidad_ejecutora') ?>").val()},
            success: function (data) {
                if (data[0] != " ") {
                    $("#<?php echo $this->campoSeguro('numero_disponibilidad') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('numero_disponibilidad') ?>");
                    $.each(data, function (indice, valor) {
                        $("<option value='" + data[ indice ].id + "'>" + data[ indice ].descripcion + "</option>").appendTo("#<?php echo $this->campoSeguro('numero_disponibilidad') ?>");
                    });

                    $('#<?php echo $this->campoSeguro('numero_disponibilidad') ?>').width(250);
                    $("#<?php echo $this->campoSeguro('numero_disponibilidad') ?>").select2();
                    $("#<?php echo $this->campoSeguro('numero_disponibilidad') ?>").removeAttr('disabled');
                }
            }
        });
    }
    ;


    function consultarRegistro(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlRegistro ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('numero_disponibilidad') ?>").val()},
            success: function (data) {
                if (data[0] != " ") {
                    $("#<?php echo $this->campoSeguro('numero_registro') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('numero_registro') ?>");
                    $.each(data, function (indice, valor) {
                        $("<option value='" + data[ indice ].id + "'>" + data[ indice ].descripcion + "</option>").appendTo("#<?php echo $this->campoSeguro('numero_registro') ?>");
                    });

                    $('#<?php echo $this->campoSeguro('numero_registro') ?>').width(250);
                    $("#<?php echo $this->campoSeguro('numero_registro') ?>").select2();
                    $("#<?php echo $this->campoSeguro('numero_registro') ?>").removeAttr('disabled');
                }
            }
        });
    }
    ;
</script>

