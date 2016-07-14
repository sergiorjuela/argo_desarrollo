
// Asociar el widget de validación al formulario
     $("#registrarOrden").validationEngine({
            promptPosition : "centerRight", 
            scroll: false,
            validateNonVisibleFields: true,
            autoHidePrompt: true,
            autoHideDelay: 2000
	         });
	

        $(function() {
            $("#registrarOrden").submit(function() {
                $resultado=$("#registrarOrden").validationEngine("validate");
                   
                if ($resultado) {
                
                    return true;
                }else{
                    
                    alert("Verifique que todos los campos requeridos del formulario este debidamente registrados.");
                    return false;
                
                }
                
            });
        });

       //$('#tablaTitulos').DataTable();
       

         $('#<?php echo $this->campoSeguro('fecha_inicio_pago')?>').datepicker({
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
			var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_inicio_pago')?>').datepicker('getDate'));
			$('input#<?php echo $this->campoSeguro('fecha_final_pago')?>').datepicker('option', 'minDate', lockDate);
			},
			onClose: function() { 
		 	    if ($('input#<?php echo $this->campoSeguro('fecha_inicio_pago')?>').val()!='')
                    {
                        $('#<?php echo $this->campoSeguro('fecha_final_pago')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all  ");
                }else {
                        $('#<?php echo $this->campoSeguro('fecha_final_pago')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
                    }
                    
                    var fechaIn = new Date($('#<?php echo $this->campoSeguro('fecha_inicio_pago')?>').datepicker('getDate'));
                    
                    var fechaFin = new Date($('#<?php echo $this->campoSeguro('fecha_final_pago')?>').datepicker('getDate'));
                    
                    
                    var tiempo = fechaFin.getTime() - fechaIn.getTime();
                    
                    var dias = Math.floor(tiempo / (1000*60*60*24));
                    
                    if($('#<?php echo $this->campoSeguro('fecha_final_pago')?>').val()!=''){
                    
                    $('#<?php echo $this->campoSeguro('duracion')?>').val(dias);
                    
                    $('#<?php echo $this->campoSeguro('numero_dias')?>').val(dias);
                    
                    }
                    
                    
                    
                    
			  }
			
        		
			
		});
		
		
		
		$('#<?php echo $this->campoSeguro('fecha_final_pago')?>').datepicker({
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
			var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_final_pago')?>').datepicker('getDate'));
			$('input#<?php echo $this->campoSeguro('fecha_inicio_pago')?>').datepicker('option', 'maxDate', lockDate);
			 },
			 onClose: function() { 
		 	    if ($('input#<?php echo $this->campoSeguro('fecha_final_pago')?>').val()!='')
                    {
                        $('#<?php echo $this->campoSeguro('fecha_inicio_pago')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
                }else {
                        $('#<?php echo $this->campoSeguro('fecha_inicio_pago')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
                    }
                    
                    
                    var fechaIn = new Date($('#<?php echo $this->campoSeguro('fecha_inicio_pago')?>').datepicker('getDate'));
                    
                    var fechaFin = new Date($('#<?php echo $this->campoSeguro('fecha_final_pago')?>').datepicker('getDate'));
                    
                    
                    var tiempo = fechaFin.getTime() - fechaIn.getTime();
                    
                    var dias = Math.floor(tiempo / (1000*60*60*24));
                    
                    if($('#<?php echo $this->campoSeguro('fecha_inicio_pago')?>').val()!=''){
                    
                    $('#<?php echo $this->campoSeguro('duracion')?>').val(dias);
                                        
                    $('#<?php echo $this->campoSeguro('numero_dias')?>').val(dias);
                    }
			  }
			
	   });
	   
	   
           
           
         $('#<?php echo $this->campoSeguro('fecha_inicial')?>').datepicker({
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
			var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_inicial')?>').datepicker('getDate'));
			$('input#<?php echo $this->campoSeguro('fecha_final')?>').datepicker('option', 'minDate', lockDate);
			},
			onClose: function() { 
		 	    if ($('input#<?php echo $this->campoSeguro('fecha_inicial')?>').val()!='')
                    {
                        $('#<?php echo $this->campoSeguro('fecha_final')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all  ");
                }else {
                        $('#<?php echo $this->campoSeguro('fecha_final')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
                    }
                    
                    var fechaIn = new Date($('#<?php echo $this->campoSeguro('fecha_inicial')?>').datepicker('getDate'));
                    
                    var fechaFin = new Date($('#<?php echo $this->campoSeguro('fecha_final')?>').datepicker('getDate'));
                    
                   
                    
                    
                    
			  }
			
        		
			
		});
		
         $('#<?php echo $this->campoSeguro('fecha_final')?>').datepicker({
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
			var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_inicial')?>').datepicker('getDate'));
			$('input#<?php echo $this->campoSeguro('fecha_final')?>').datepicker('option', 'minDate', lockDate);
			},
			onClose: function() { 
		 	    if ($('input#<?php echo $this->campoSeguro('fecha_inicial')?>').val()!='')
                    {
                        $('#<?php echo $this->campoSeguro('fecha_final')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all  ");
                }else {
                        $('#<?php echo $this->campoSeguro('fecha_final')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
                    }
                    
                    var fechaIn = new Date($('#<?php echo $this->campoSeguro('fecha_inicial')?>').datepicker('getDate'));
                    
                    var fechaFin = new Date($('#<?php echo $this->campoSeguro('fecha_final')?>').datepicker('getDate'));
                    
                  
                    
                   
                    
                    
                    
			  }
			
        		
			
		});
		

        
        
		//$('#<?php echo $this->campoSeguro('duracion')?>').attr('disabled',''); 
		$('#<?php echo $this->campoSeguro('total_iva')?>').attr('disabled',''); 
		$('#<?php echo $this->campoSeguro('total')?>').attr('disabled','');    
		
		$('#<?php echo $this->campoSeguro('nombreOrdenador')?>').attr('disabled',''); 
		$('#<?php echo $this->campoSeguro('nombreJefeSeccion')?>').attr('disabled',''); 
		
		
		
		
		
		
		
		$("#<?php echo $this->campoSeguro('iva')?>").change(function(){ 
		
		switch($("#<?php echo $this->campoSeguro('iva')?>").val())
		
		{
	
			case '0':
		
				$('#<?php echo $this->campoSeguro('total_iva')?>').val(0);
				
				var total =$('#<?php echo $this->campoSeguro('total_preliminar')?>').val();
				var iva =$('#<?php echo $this->campoSeguro('total_iva')?>').val();
				var numero = Number(total) + Number(iva) ;
				
				$('#<?php echo $this->campoSeguro('total')?>').val(numero);
		
		
			break;
		
			case '1':
		
				$('#<?php echo $this->campoSeguro('total_iva')?>').val($('#<?php echo $this->campoSeguro('total_preliminar')?>').val() * 0.16);
		
				var total =$('#<?php echo $this->campoSeguro('total_preliminar')?>').val();
				var iva =$('#<?php echo $this->campoSeguro('total_iva')?>').val();
				var numero = Number(total) + Number(iva) ;
				
				$('#<?php echo $this->campoSeguro('total')?>').val(numero);
		
		
			break;	

		
		}
		
		 });
		 
		 
		 $("#<?php echo $this->campoSeguro('total_preliminar')?>").keyup(function(){ 
		
	
				var total =$('#<?php echo $this->campoSeguro('total_preliminar')?>').val();
				var iva =$('#<?php echo $this->campoSeguro('total_iva')?>').val();
				var numero = Number(total) + Number(iva) 
				
				$('#<?php echo $this->campoSeguro('total')?>').val(numero);

			
		 });
		    
		    
		    

          $("#<?php echo $this->campoSeguro('cargoJefeSeccion')?>").select2();
	      $("#<?php echo $this->campoSeguro('nombreContratista')?>").select2({
			   	 placeholder: "Search for a repository",
			   	 minimumInputLength: 3,
			
			       });
			$('#<?php echo $this->campoSeguro('asignacionOrdenador')?>').width(300);			       
          $("#<?php echo $this->campoSeguro('asignacionOrdenador')?>").select2();
          $("#<?php echo $this->campoSeguro('tipo_orden')?>").select2();
		    
        
               
               
 
				$('#<?php echo $this->campoSeguro('nombre_supervisor')?>').width(300);			       
               $("#<?php echo $this->campoSeguro('nombre_supervisor')?>").select2({
			   	 placeholder: "Ingrese Mínimo 3 Caracteres de Búsqueda",
			   	 minimumInputLength: 3,
			       });
			        	
			        	
			        	
			        	
$("#<?php echo $this->campoSeguro('rubro')?>").select2({
             	 placeholder: "Ingrese Mínimo 3 Caracteres de Búsqueda",
              	 minimumInputLength: 3,
              	 });
                 
 $("#poliza0").change(function () {
       if ($(this).is(':checked')) {
            $("#divisionPoliza0").css('display', 'block');
             $("#<?php echo $this->campoSeguro('fecha_inicio_poliza0')?>").addClass( " validate[required] " );
             $("#<?php echo $this->campoSeguro('fecha_final_poliza0')?>").addClass( " validate[required] " );
        } else {
            $("#divisionPoliza0").css('display', 'none');
             $("#<?php echo $this->campoSeguro('fecha_inicio_poliza0')?>").removeClass( " validate[required] " );  
             $("#<?php echo $this->campoSeguro('fecha_final_poliza0')?>").removeClass( " validate[required] " );
             $("#<?php echo $this->campoSeguro('fecha_inicio_poliza0')?>").val("");
             $("#<?php echo $this->campoSeguro('fecha_final_poliza0')?>").val(""); 
        }
    });
 $("#poliza1").change(function () {
       if ($(this).is(':checked')) {
            $("#divisionPoliza1").css('display', 'block');
              $("#<?php echo $this->campoSeguro('fecha_inicio_poliza1')?>").addClass( " validate[required] " );
             $("#<?php echo $this->campoSeguro('fecha_final_poliza1')?>").addClass( " validate[required] " );
        } else {
            $("#divisionPoliza1").css('display', 'none');
            $("#<?php echo $this->campoSeguro('fecha_inicio_poliza1')?>").removeClass( " validate[required] " );  
             $("#<?php echo $this->campoSeguro('fecha_final_poliza1')?>").removeClass( " validate[required] " );
             $("#<?php echo $this->campoSeguro('fecha_inicio_poliza1')?>").val("");
             $("#<?php echo $this->campoSeguro('fecha_final_poliza1')?>").val(""); 
        }
    });
 $("#poliza2").change(function () {
       if ($(this).is(':checked')) {
            $("#divisionPoliza2").css('display', 'block');
              $("#<?php echo $this->campoSeguro('fecha_inicio_poliza2')?>").addClass( " validate[required] " );
             $("#<?php echo $this->campoSeguro('fecha_final_poliza2')?>").addClass( " validate[required] " );
        } else {
            $("#divisionPoliza2").css('display', 'none');
             $("#<?php echo $this->campoSeguro('fecha_inicio_poliza2')?>").removeClass( " validate[required] " );  
             $("#<?php echo $this->campoSeguro('fecha_final_poliza2')?>").removeClass( " validate[required] " );
             $("#<?php echo $this->campoSeguro('fecha_inicio_poliza2')?>").val("");
             $("#<?php echo $this->campoSeguro('fecha_final_poliza2')?>").val(""); 
        }
    });
 $("#poliza3").change(function () {
       if ($(this).is(':checked')) {
            $("#divisionPoliza3").css('display', 'block');
             $("#<?php echo $this->campoSeguro('fecha_inicio_poliza3')?>").addClass( " validate[required] " );
             $("#<?php echo $this->campoSeguro('fecha_final_poliza3')?>").addClass( " validate[required] " );
        } else {
            $("#divisionPoliza3").css('display', 'none');
             $("#<?php echo $this->campoSeguro('fecha_inicio_poliza3')?>").removeClass( " validate[required] " );  
             $("#<?php echo $this->campoSeguro('fecha_final_poliza3')?>").removeClass( " validate[required] " ); 
             $("#<?php echo $this->campoSeguro('fecha_inicio_poliza3')?>").val("");
             $("#<?php echo $this->campoSeguro('fecha_final_poliza3')?>").val(""); 
        }
    });
 $("#poliza4").change(function () {
       if ($(this).is(':checked')) {
            $("#divisionPoliza4").css('display', 'block');
             $("#<?php echo $this->campoSeguro('fecha_inicio_poliza4')?>").addClass( " validate[required] " );
             $("#<?php echo $this->campoSeguro('fecha_final_poliza4')?>").addClass( " validate[required] " );
        } else {
            $("#divisionPoliza4").css('display', 'none');
             $("#<?php echo $this->campoSeguro('fecha_inicio_poliza4')?>").removeClass( " validate[required] " );  
             $("#<?php echo $this->campoSeguro('fecha_final_poliza4')?>").removeClass( " validate[required] " );  
             $("#<?php echo $this->campoSeguro('fecha_inicio_poliza4')?>").val("");
             $("#<?php echo $this->campoSeguro('fecha_final_poliza4')?>").val(""); 
        }
    });
    
 
    var dates0 = $("#<?php echo $this->campoSeguro('fecha_inicio_poliza0') ?>").datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
        onSelect: function (selectedDate) {
            var option = this.id == "from" ? "maxDate" : "minDate",
                    instance = $(this).data("datepicker"),
                    date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
            dates0.not(this).datepicker("option", option, date);
        }
    });
    var inidate0 = new Date($('#<?php echo $this->campoSeguro('fecha_inicio_poliza0') ?>').datepicker('getDate'));
    var dates0 = $("#<?php echo $this->campoSeguro('fecha_final_poliza0') ?>").datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        minDate: inidate0,
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']

    });
   
    var dates1 = $("#<?php echo $this->campoSeguro('fecha_inicio_poliza1') ?>").datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
        onSelect: function (selectedDate) {
            var option = this.id == "from" ? "maxDate" : "minDate",
                    instance = $(this).data("datepicker"),
                    date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
            dates1.not(this).datepicker("option", option, date);
        }
    });
    var inidate1 = new Date($('#<?php echo $this->campoSeguro('fecha_inicio_poliza1') ?>').datepicker('getDate'));
    var dates1 = $("#<?php echo $this->campoSeguro('fecha_final_poliza1') ?>").datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        minDate: inidate1,
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']

    });
    
    var dates2 = $("#<?php echo $this->campoSeguro('fecha_inicio_poliza2') ?>").datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
        onSelect: function (selectedDate) {
            var option = this.id == "from" ? "maxDate" : "minDate",
                    instance = $(this).data("datepicker"),
                    date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
            dates2.not(this).datepicker("option", option, date);
        }
    });
    var inidate2 = new Date($('#<?php echo $this->campoSeguro('fecha_inicio_poliza2') ?>').datepicker('getDate'));
    var dates2 = $("#<?php echo $this->campoSeguro('fecha_final_poliza2') ?>").datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        minDate: inidate2,
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']

    });
   
    var dates3 = $("#<?php echo $this->campoSeguro('fecha_inicio_poliza3') ?>").datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
        onSelect: function (selectedDate) {
            var option = this.id == "from" ? "maxDate" : "minDate",
                    instance = $(this).data("datepicker"),
                    date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
            dates3.not(this).datepicker("option", option, date);
        }
    });
    var inidate3 = new Date($('#<?php echo $this->campoSeguro('fecha_inicio_poliza3') ?>').datepicker('getDate'));
    var dates3 = $("#<?php echo $this->campoSeguro('fecha_final_poliza3') ?>").datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        minDate: inidate3,
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']

    });
    var dates4 = $("#<?php echo $this->campoSeguro('fecha_inicio_poliza4') ?>").datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
        onSelect: function (selectedDate) {
            var option = this.id == "from" ? "maxDate" : "minDate",
                    instance = $(this).data("datepicker"),
                    date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
            dates4.not(this).datepicker("option", option, date);
        }
    });
    var inidate4 = new Date($('#<?php echo $this->campoSeguro('fecha_inicio_poliza4') ?>').datepicker('getDate'));
    var dates4 = $("#<?php echo $this->campoSeguro('fecha_final_poliza4') ?>").datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        minDate: inidate4,
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']

    });
   
   
                
   
   
                
                


                 
$('#<?php echo $this->campoSeguro('sede')?>').width(300);
$("#<?php echo $this->campoSeguro('sede')?>").select2();

$('#<?php echo $this->campoSeguro('formaPago')?>').width(150);
$("#<?php echo $this->campoSeguro('formaPago')?>").select2();

$('#<?php echo $this->campoSeguro('vigencia_convenio')?>').width(150);
$("#<?php echo $this->campoSeguro('vigencia_convenio')?>").select2();
$('#<?php echo $this->campoSeguro('convenio_solicitante')?>').attr('disabled',''); 
$('#<?php echo $this->campoSeguro('cargosExistentes')?>').width(300);
$("#<?php echo $this->campoSeguro('cargosExistentes')?>").select2();


$('#<?php echo $this->campoSeguro('sede_super')?>').width(300);
$("#<?php echo $this->campoSeguro('sede_super')?>").select2();


$("#<?php echo $this->campoSeguro('vigencia_disponibilidad')?>").select2();
$('#<?php echo $this->campoSeguro('diponibilidad')?>').select2();

$('#<?php echo $this->campoSeguro('dependencia_solicitante')?>').width(350);
$("#<?php echo $this->campoSeguro('dependencia_solicitante')?>").select2();



$('#<?php echo $this->campoSeguro('convenio_solicitante')?>').width(200);
$("#<?php echo $this->campoSeguro('convenio_solicitante')?>").select2();

$('#<?php echo $this->campoSeguro('unidad_ejecucion')?>').width(200);
$("#<?php echo $this->campoSeguro('unidad_ejecucion')?>").select2();

$('#<?php echo $this->campoSeguro('vigencia_solicitud_consulta')?>').width(200);
$("#<?php echo $this->campoSeguro('vigencia_solicitud_consulta')?>").select2();


$('#<?php echo $this->campoSeguro('numero_solicitud')?>').width(200);
$("#<?php echo $this->campoSeguro('numero_solicitud')?>").select2();

$('#<?php echo $this->campoSeguro('numero_cdp')?>').width(200);
$("#<?php echo $this->campoSeguro('numero_cdp')?>").select2();

$('#<?php echo $this->campoSeguro('dependencia_solicitud')?>').width(200);
$("#<?php echo $this->campoSeguro('dependencia_solicitud')?>").select2();



$('#<?php echo $this->campoSeguro('dependencia_supervisor')?>').width(350);
$("#<?php echo $this->campoSeguro('dependencia_supervisor')?>").select2(); 

$("#<?php echo $this->campoSeguro('vigencia_registro')?>").select2();
$("#<?php echo $this->campoSeguro('registro')?>").select2();

$("#<?php echo $this->campoSeguro('vigencia_contratista')?>").select2();
$('#<?php echo $this->campoSeguro('nombreContratista')?>').attr("style", "width: 60px '");



        
          






