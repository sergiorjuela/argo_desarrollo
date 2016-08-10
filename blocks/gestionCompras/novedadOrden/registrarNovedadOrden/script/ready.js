$('#tabla').dataTable({
    "sPaginationType": "full_numbers"
});

$('#tablaRegistros').dataTable({
    paging: false,
    "bLengthChange": false,
});


$("#registrarNovedadOrden").validationEngine({
    promptPosition: "bottomRight",
    scroll: false,
    autoHidePrompt: true,
    autoHideDelay: 1000
});


$(function () {
    $("#registrarNovedadOrden").submit(function () {
        $resultado = $("#registrarNovedad").validationEngine("validate");

        if ($resultado) {

            return true;
        }
        return false;
    });
});



		