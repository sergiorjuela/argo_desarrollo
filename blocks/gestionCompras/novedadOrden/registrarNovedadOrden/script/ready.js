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


$("#ventanaA").steps({
    headerTag: "h3",
    bodyTag: "section",
    enableAllSteps: true,
    enablePagination: true,
    transitionEffect: "slideLeft",
    onStepChanging: function (event, currentIndex, newIndex) {
        $resultado = $("#registrarContrato").validationEngine("validate");
        if ($resultado) {

            return true;
        }
        return false;

    },
    onFinished: function (event, currentIndex) {

        $("#registrarContrato").submit();

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

		