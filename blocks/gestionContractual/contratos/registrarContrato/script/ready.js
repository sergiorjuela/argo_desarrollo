$('#tabla').dataTable({
    "sPaginationType": "full_numbers"
});

$('#tablaDisponibilidades').dataTable({
    paging: false,
    "bLengthChange": false,
});

$('#tablaRegistros').dataTable({
    paging: false,
    "bLengthChange": false,
});



$("#registrarContrato").validationEngine({
    promptPosition: "bottomRight",
    scroll: false,
    autoHidePrompt: true,
    autoHideDelay: 1000
});

$(function () {
    $("#registrarContrato").submit(function () {
        $resultado = $("#registrarContrato").validationEngine("validate");

        if ($resultado) {

            return true;
        }
        return false;
    });
});
