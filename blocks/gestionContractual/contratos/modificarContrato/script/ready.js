 $('#tabla').dataTable( {
"sPaginationType": "full_numbers"
 } );
 
 $('#tablaDisponibilidades').dataTable( {
	 paging: false,
	 "bLengthChange": false,
	  } );
 
 $('#tablaRegistros').dataTable( {
	 paging: false,
	 "bLengthChange": false,
	  } );
 
			
			






            $("#modificarContrato").validationEngine({
            promptPosition : "bottomRight", 
            scroll: false,
            autoHidePrompt: true,
            autoHideDelay: 1000
	         });


     $(function() {
            $("#modificarContrato").submit(function() {
		                $resultado = $("#modificarContrato").validationEngine("validate");

		if ($resultado) {

			return true;
		}
		return false;
            });
        });
