<?php

?>

// Asociar el widget de validación al formulario
              $("#consultaOrdenesAprobadas").validationEngine({
            promptPosition : "centerRight", 
            scroll: false,
            autoHidePrompt: true,
            autoHideDelay: 2000
	         });
	
        
        $(function() {
            $("#consultaOrden").submit(function() {
                $resultado=$("#consultaOrdenesAprobadas").validationEngine("validate");
                if ($resultado) {
                
                    return true;
                }
                return false;
            });
        });

                     $('#tablaTitulos').dataTable( {
                "sPaginationType": "full_numbers"
                 } );
                 
 	$("#<?php echo $this->campoSeguro('clase_contrato')?>").width(220);
	$("#<?php echo $this->campoSeguro('clase_contrato')?>").select2();
 	
        $("#<?php echo $this->campoSeguro('clase_contratista')?>").width(220);
	$("#<?php echo $this->campoSeguro('clase_contratista')?>").select2();
 	
        $("#<?php echo $this->campoSeguro('tipo_compromiso')?>").width(220);
	$("#<?php echo $this->campoSeguro('tipo_compromiso')?>").select2();
 	
        $("#<?php echo $this->campoSeguro('unidad_ejecucion_tiempo')?>").width(220);
	$("#<?php echo $this->campoSeguro('unidad_ejecucion_tiempo')?>").select2();
 	
        $("#<?php echo $this->campoSeguro('formaPago')?>").width(220);
	$("#<?php echo $this->campoSeguro('formaPago')?>").select2();
 	
        $("#<?php echo $this->campoSeguro('dependencia')?>").width(220);
	$("#<?php echo $this->campoSeguro('dependencia')?>").select2();
 	
        $("#<?php echo $this->campoSeguro('tipologia_especifica')?>").width(220);
	$("#<?php echo $this->campoSeguro('tipologia_especifica')?>").select2();
 	
        $("#<?php echo $this->campoSeguro('modalidad_seleccion')?>").width(220);
	$("#<?php echo $this->campoSeguro('modalidad_seleccion')?>").select2();
 	
        $("#<?php echo $this->campoSeguro('procedimiento')?>").width(220);
	$("#<?php echo $this->campoSeguro('procedimiento')?>").select2();
 	
        $("#<?php echo $this->campoSeguro('regimen_contratación')?>").width(220);
	$("#<?php echo $this->campoSeguro('regimen_contratación')?>").select2();
 	
        $("#<?php echo $this->campoSeguro('tipo_moneda')?>").width(220);
	$("#<?php echo $this->campoSeguro('tipo_moneda')?>").select2();
 	
        $("#<?php echo $this->campoSeguro('ordenador_gasto')?>").width(220);
	$("#<?php echo $this->campoSeguro('ordenador_gasto')?>").select2();
          
 	
        $("#<?php echo $this->campoSeguro('tipo_gasto')?>").width(220);
	$("#<?php echo $this->campoSeguro('tipo_gasto')?>").select2();
          
 	
        $("#<?php echo $this->campoSeguro('origen_recursos')?>").width(220);
	$("#<?php echo $this->campoSeguro('origen_recursos')?>").select2();
          
 	
        $("#<?php echo $this->campoSeguro('origen_presupuesto')?>").width(220);
	$("#<?php echo $this->campoSeguro('origen_presupuesto')?>").select2();
        
        $("#<?php echo $this->campoSeguro('tema_gasto_inversion')?>").width(220);
	$("#<?php echo $this->campoSeguro('tema_gasto_inversion')?>").select2();
        
        $("#<?php echo $this->campoSeguro('tipo_control')?>").width(220);
	$("#<?php echo $this->campoSeguro('tipo_control')?>").select2();
        
        $("#<?php echo $this->campoSeguro('supervisor')?>").width(220);
	$("#<?php echo $this->campoSeguro('supervisor')?>").select2();
          
     $('#<?php echo $this->campoSeguro('fecha_inicio_sub')?>').datepicker({
			dateFormat: 'yy-mm-dd',
			changeYear: true,
			changeMonth: true,
			monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
			    'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
			    monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
			    dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
			    dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
			    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
			    onSelect: function(dateText, inst) {
				var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_inicio_sub')?>').datepicker('getDate'));
				$('input#<?php echo $this->campoSeguro('fecha_final_sub')?>').datepicker('option', 'minDate', lockDate);
				},
				onClose: function() { 
			 	    if ($('input#<?php echo $this->campoSeguro('fecha_inicio_sub')?>').val()!='')
		            {
		                $('#<?php echo $this->campoSeguro('fecha_final_sub')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
		        }else {
		                $('#<?php echo $this->campoSeguro('fecha_final_sub')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
		            }
				  }
			
			
			});
		      $('#<?php echo $this->campoSeguro('fecha_final_sub')?>').datepicker({
			dateFormat: 'yy-mm-dd',
			changeYear: true,
			changeMonth: true,
			monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
			    'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
			    monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
			    dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
			    dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
			    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
			    onSelect: function(dateText, inst) {
				var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_final_sub')?>').datepicker('getDate'));
				$('input#<?php echo $this->campoSeguro('fecha_inicio_sub')?>').datepicker('option', 'maxDate', lockDate);
				 },
				 onClose: function() { 
			 	    if ($('input#<?php echo $this->campoSeguro('fecha_final_sub')?>').val()!='')
		            {
		                $('#<?php echo $this->campoSeguro('fecha_inicio_sub')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
		        }else {
		                $('#<?php echo $this->campoSeguro('fecha_inicio_sub')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
		            }
				  }
			
		   });

          
          
     $('#<?php echo $this->campoSeguro('fecha_inicio_acta')?>').datepicker({
			dateFormat: 'yy-mm-dd',
			changeYear: true,
			changeMonth: true,
			monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
			    'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
			    monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
			    dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
			    dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
			    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
			    onSelect: function(dateText, inst) {
				var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_inicio_acta')?>').datepicker('getDate'));
				$('input#<?php echo $this->campoSeguro('fecha_final_acta')?>').datepicker('option', 'minDate', lockDate);
				},
				onClose: function() { 
			 	    if ($('input#<?php echo $this->campoSeguro('fecha_inicio_acta')?>').val()!='')
		            {
		                $('#<?php echo $this->campoSeguro('fecha_final_acta')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
		        }else {
		                $('#<?php echo $this->campoSeguro('fecha_final_acta')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
		            }
				  }
			
			
			});
		      $('#<?php echo $this->campoSeguro('fecha_final_acta')?>').datepicker({
			dateFormat: 'yy-mm-dd',
			changeYear: true,
			changeMonth: true,
			monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
			    'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
			    monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
			    dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
			    dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
			    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
			    onSelect: function(dateText, inst) {
				var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_final_acta')?>').datepicker('getDate'));
				$('input#<?php echo $this->campoSeguro('fecha_inicio_sub')?>').datepicker('option', 'maxDate', lockDate);
				 },
				 onClose: function() { 
			 	    if ($('input#<?php echo $this->campoSeguro('fecha_final_acta')?>').val()!='')
		            {
		                $('#<?php echo $this->campoSeguro('fecha_inicio_acta')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
		        }else {
		                $('#<?php echo $this->campoSeguro('fecha_inicio_acta')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
		            }
				  }
			
		   });

          
          
          
