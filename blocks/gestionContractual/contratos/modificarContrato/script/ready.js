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
 
			
			$("#ventanaA").steps({
			    headerTag: "h3",
			    bodyTag: "section",
			    enableAllSteps: true,
			    enablePagination: true,
			    transitionEffect: "slideLeft",
			    onStepChanging: function (event, currentIndex, newIndex){
	                $resultado = $("#modificarContrato").validationEngine("validate");
                        almacenarInfoTemporal(currentIndex, newIndex);
                       
	        		if ($resultado) {

	        			return true;
	        		}
	        		return false;
	        		;
			    },
			    onFinished: function (event, currentIndex)
			    {
			    	
			    	 $("#modificarContrato").submit();
			        
			    },
			    labels: {
			        cancel: "Cancelar",
			        current: "Paso Siguiente :",
			        pagination: "Paginación",
			        finish: "Actualizar Información",
			        next: "Siquiente",
			        previous: "Atras",
			        loading: "Cargando ..."
			    }
			     
			});






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
