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
                 
$("#ventanaEmergenteConvenio" ).dialog({
height: 700,
width: 700,
title: "Datos Convenio",
autoOpen: false,
});
                 
$('#<?php echo $this->campoSeguro('dependencia_solicitante')?>').width(350);
$("#<?php echo $this->campoSeguro('dependencia_solicitante')?>").select2(); 

$('#<?php echo $this->campoSeguro('vigencia_convenio')?>').width(150);
$("#<?php echo $this->campoSeguro('vigencia_convenio')?>").select2();


$('#<?php echo $this->campoSeguro('sede')?>').width(350);
$("#<?php echo $this->campoSeguro('sede')?>").select2();                 

$('#<?php echo $this->campoSeguro('formaPago')?>').width(150);
$("#<?php echo $this->campoSeguro('formaPago')?>").select2();                 

$('#<?php echo $this->campoSeguro('convenio_solicitante')?>').width(150);
$("#<?php echo $this->campoSeguro('convenio_solicitante')?>").select2();                 

$('#<?php echo $this->campoSeguro('sede_super')?>').width(300);
$("#<?php echo $this->campoSeguro('sede_super')?>").select2();

$('#<?php echo $this->campoSeguro('unidad_ejecucion')?>').width(200);
$("#<?php echo $this->campoSeguro('unidad_ejecucion')?>").select2();

$('#<?php echo $this->campoSeguro('dependencia_supervisor')?>').width(350);
$("#<?php echo $this->campoSeguro('dependencia_supervisor')?>").select2(); 

$('#<?php echo $this->campoSeguro('asignacionOrdenador')?>').width(300);			       
$("#<?php echo $this->campoSeguro('asignacionOrdenador')?>").select2();

$('#<?php echo $this->campoSeguro('nombre_supervisor')?>').width(300);			       
               $("#<?php echo $this->campoSeguro('nombre_supervisor')?>").select2({
			   	 placeholder: "Ingrese Mínimo 3 Caracteres de Búsqueda",
			   	 minimumInputLength: 3,
			       });
			   
 $("#<?php echo $this->campoSeguro('tipo_orden')?>").select2();
 $("#<?php echo $this->campoSeguro('numero_orden')?>").select2();
 $("#<?php echo $this->campoSeguro('sedeConsulta')?>").select2();
 $("#<?php echo $this->campoSeguro('dependenciaConsulta')?>").select2();
  $("#<?php echo $this->campoSeguro('proveedorContratista')?>").select2();
		$("#<?php echo $this->campoSeguro('sede')?>").select2();
		                     
		$('#<?php echo $this->campoSeguro('orden_consulta')?>').select2();
        
        $('#<?php echo $this->campoSeguro('vigencia_disponibilidad')?>').width(100);             
        $("#<?php echo $this->campoSeguro('vigencia_disponibilidad')?>").select2();
        $('#<?php echo $this->campoSeguro('diponibilidad')?>').width(150);
		$('#<?php echo $this->campoSeguro('diponibilidad')?>').select2();
		
		
		$("#<?php echo $this->campoSeguro('vigencia_registro')?>").select2();
		$('#<?php echo $this->campoSeguro('registro')?>').width(150);
		$("#<?php echo $this->campoSeguro('registro')?>").select2(); 
                
                
                
		$('#<?php echo $this->campoSeguro('cargosExistentes')?>').width(160);
		$("#<?php echo $this->campoSeguro('cargosExistentes')?>").select2(); 
		
		$("#<?php echo $this->campoSeguro('vigencia_contratista')?>").select2();
		$('#<?php echo $this->campoSeguro('nombreContratista')?>').attr("style", "width: 60px '");

        
        
                 
                 
        $('#<?php echo $this->campoSeguro('fecha_inicio')?>').datepicker({
		dateFormat: 'yy-mm-dd',
		maxDate: 0,
		changeYear: true,
		changeMonth: true,
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
		    'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		    monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
		    dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
		    dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		    onSelect: function(dateText, inst) {
			var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_inicio')?>').datepicker('getDate'));
			$('input#<?php echo $this->campoSeguro('fecha_final')?>').datepicker('option', 'minDate', lockDate);
			},
			onClose: function() { 
		 	    if ($('input#<?php echo $this->campoSeguro('fecha_inicio')?>').val()!='')
                    {
                        $('#<?php echo $this->campoSeguro('fecha_final')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
                }else {
                        $('#<?php echo $this->campoSeguro('fecha_final')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
                    }
			  }
			
			
		});
              $('#<?php echo $this->campoSeguro('fecha_final')?>').datepicker({
		dateFormat: 'yy-mm-dd',
		maxDate: 0,
		changeYear: true,
		changeMonth: true,
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
		    'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		    monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
		    dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
		    dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		    onSelect: function(dateText, inst) {
			var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_final')?>').datepicker('getDate'));
			$('input#<?php echo $this->campoSeguro('fecha_inicio')?>').datepicker('option', 'maxDate', lockDate);
			 },
			 onClose: function() { 
		 	    if ($('input#<?php echo $this->campoSeguro('fecha_final')?>').val()!='')
                    {
                        $('#<?php echo $this->campoSeguro('fecha_inicio')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
                }else {
                        $('#<?php echo $this->campoSeguro('fecha_inicio')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
                    }
			  }
			
	   });
	
		
		
			   
	           $('#<?php echo $this->campoSeguro('fecha_disponibilidad')?>').datepicker({
	        dateFormat: 'yy-mm-dd',
	        maxDate: 0,
	        changeYear: true,
	        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
				'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
				dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
				dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa']
        });
        
        
        	           $('#<?php echo $this->campoSeguro('fecha_registro')?>').datepicker({
	        dateFormat: 'yy-mm-dd',
	        maxDate: 0,
	        changeYear: true,
	        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
				'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
				dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
				dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa']
        });
	   
	   
	   
	   $("#<?php echo $this->campoSeguro('contratista_consulta')?>").select2();
	   
	   	 
	   
	   
	   $('#<?php echo $this->campoSeguro('selec_dependencia_Sol')?>').attr('disabled','');
	   $("#<?php echo $this->campoSeguro('sede_consultar')?>").select2();
	  
	   
	   
	    	
	   
	   
	   
	   
	   
	   
	   
	   $("#<?php echo $this->campoSeguro('rubro')?>").select2({
			   	 placeholder: "Search for a repository",
			   	 minimumInputLength: 3,
			
			       });
	   
	   $("#<?php echo $this->campoSeguro('asignacionOrdenador')?>").select2();
	   $("#<?php echo $this->campoSeguro('cargoJefeSeccion')?>").select2();
	   $("#<?php echo $this->campoSeguro('nombreContratista')?>").select2();
	   
	
               $( "#<?php echo $this->campoSeguro('cantidad')?>" ).keyup(function() {
        
            $("#<?php echo $this->campoSeguro('valor')?>").val('');
            $("#<?php echo $this->campoSeguro('subtotal_sin_iva')?>").val('');
            $("#<?php echo $this->campoSeguro('total_iva')?>").val('');
            $("#<?php echo $this->campoSeguro('total_iva_con')?>").val('');
            
            
            resetIva();
            
            
          });  
       
       
       
       	 $( "#<?php echo $this->campoSeguro('valor')?>" ).keyup(function() {
        	$("#<?php echo $this->campoSeguro('subtotal_sin_iva')?>").val('');
            $("#<?php echo $this->campoSeguro('total_iva')?>").val('');
            $("#<?php echo $this->campoSeguro('total_iva_con')?>").val('');
            resetIva(); 
            cantidad=Number($("#<?php echo $this->campoSeguro('cantidad')?>").val());
            valor=Number($("#<?php echo $this->campoSeguro('valor')?>").val());
            
             precio = Math.round((cantidad * valor)*100)/100;
      
      
            if (precio==0){
            
            
            $("#<?php echo $this->campoSeguro('subtotal_sin_iva')?>").val('');
            
            }else{
            
            $("#<?php echo $this->campoSeguro('subtotal_sin_iva')?>").val(precio);
            
            }

          }); 
       
       
         $( "#<?php echo $this->campoSeguro('iva')?>" ).change(function() {
        
		     switch($("#<?php echo $this->campoSeguro('iva')?>").val())
            {
                           
                case '1':
                 
                 cantidad=Number($("#<?php echo $this->campoSeguro('cantidad')?>").val());
            	 valor=Number($("#<?php echo $this->campoSeguro('valor')?>").val());
       			 precio=cantidad * valor;
       			 total=Math.round(precio*100)/100;
       			 
                 $("#<?php echo $this->campoSeguro('total_iva')?>").val('0');
                 
                 $("#<?php echo $this->campoSeguro('total_iva_con')?>").val(total);
                                    
                break;
                
                case '2':
                 
                 cantidad=Number($("#<?php echo $this->campoSeguro('cantidad')?>").val());
            	 valor=Number($("#<?php echo $this->campoSeguro('valor')?>").val());
       			 precio=cantidad * valor;
       			 total=Math.round(precio*100)/100;
       			 
                 $("#<?php echo $this->campoSeguro('total_iva')?>").val('0');
                 
                 $("#<?php echo $this->campoSeguro('total_iva_con')?>").val(total);
                                    
                break;
                
                case '3':
                
                 cantidad=Number($("#<?php echo $this->campoSeguro('cantidad')?>").val());
            	 valor=Number($("#<?php echo $this->campoSeguro('valor')?>").val());
       			 iva = Math.round(((cantidad * valor)* 0.05)*100)/100;
       			 precio=Math.round((cantidad * valor)*100)/100;
       			 total=Math.round((precio+iva)*100)/100;
       			 
       			 
                 $("#<?php echo $this->campoSeguro('total_iva')?>").val(iva);
                 
                 $("#<?php echo $this->campoSeguro('total_iva_con')?>").val(total);
                    
                break;
                                
                case '4':
                
                 cantidad=Number($("#<?php echo $this->campoSeguro('cantidad')?>").val());
            	 valor=Number($("#<?php echo $this->campoSeguro('valor')?>").val());
       			 iva = Math.round(((cantidad * valor)* 0.04)*100)/100;
       			 precio = Math.round((cantidad*valor)*100)/100;
       			 total=Math.round((precio+iva)*100)/100;
       			 
       			 
                 $("#<?php echo $this->campoSeguro('total_iva')?>").val(iva);
                 $("#<?php echo $this->campoSeguro('total_iva_con')?>").val(total);
                                     
                break;
                
                case '5':
                
                 cantidad=Number($("#<?php echo $this->campoSeguro('cantidad')?>").val());
            	 valor=Number($("#<?php echo $this->campoSeguro('valor')?>").val());
       			 iva = Math.round(((cantidad * valor)* 0.1)*100)/100;
       			 precio = Math.round((cantidad*valor)*100)/100;
       			 total=Math.round((precio+iva)*100)/100;
       			 
                 $("#<?php echo $this->campoSeguro('total_iva')?>").val(iva);
                 $("#<?php echo $this->campoSeguro('total_iva_con')?>").val(total);
                                     
                break;
                
                 case '6':
                
                 cantidad=Number($("#<?php echo $this->campoSeguro('cantidad')?>").val());
            	 valor=Number($("#<?php echo $this->campoSeguro('valor')?>").val());
       	     	 iva = Math.round(((cantidad * valor)* 0.16)*100)/100;
       			 precio = Math.round((cantidad*valor)*100)/100;
       			 total=Math.round((precio+iva)*100)/100;

       			 
                 $("#<?php echo $this->campoSeguro('total_iva')?>").val(iva);
                 $("#<?php echo $this->campoSeguro('total_iva_con')?>").val(total);
                                     
                break;
                

                default:
                $("#<?php echo $this->campoSeguro('total_iva')?>").val('');
                $("#<?php echo $this->campoSeguro('total_iva_con')?>").val('');
                   
                break;
                
                }
            
          });  
          
          
   var dates0 = $("#<?php echo $this->campoSeguro('fecha_inicio_acta') ?>").datepicker({
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
    var inidate0 = new Date($('#<?php echo $this->campoSeguro('fecha_inicio_acta') ?>').datepicker('getDate'));
    var dates0 = $("#<?php echo $this->campoSeguro('fecha_final_acta') ?>").datepicker({
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
          
          
          
