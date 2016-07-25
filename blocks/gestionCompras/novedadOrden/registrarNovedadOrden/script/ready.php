<?php   
$_REQUEST ['tiempo'] = time();
?>


$('#<?php echo $this->campoSeguro('fecha_novedad') ?>').datepicker({
dateFormat: 'yy-mm-dd',
changeYear: true,
changeMonth: true,
monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],

});




$("#<?php echo $this->campoSeguro('tipo_novedad') ?>").select2();
$('#<?php echo $this->campoSeguro('tipo_orden')?>').width(350);
$("#<?php echo $this->campoSeguro('tipo_orden')?>").select2();                 
$('#<?php echo $this->campoSeguro('sedeConsulta')?>').width(350);
$("#<?php echo $this->campoSeguro('sedeConsulta')?>").select2(); 
$("#<?php echo $this->campoSeguro('tipo_adicion')?>").width(200);  
$("#<?php echo $this->campoSeguro('tipo_adicion')?>").select2();                 
$("#<?php echo $this->campoSeguro('vigencia_novedad')?>").width(200);  
$("#<?php echo $this->campoSeguro('vigencia_novedad')?>").select2();                 
             
$("#<?php echo $this->campoSeguro('unidad_tiempo_ejecucion')?>").width(200);  
$("#<?php echo $this->campoSeguro('unidad_tiempo_ejecucion')?>").select2();                 
             
$("#<?php echo $this->campoSeguro('tipo_anulacion')?>").width(200);  
$("#<?php echo $this->campoSeguro('tipo_anulacion')?>").select2();                 
             
$("#<?php echo $this->campoSeguro('tipoCambioSupervisor')?>").width(200);  
$("#<?php echo $this->campoSeguro('tipoCambioSupervisor')?>").select2();                 
$("#<?php echo $this->campoSeguro('nuevoSupervisor')?>").width(400);  
$("#<?php echo $this->campoSeguro('nuevoSupervisor')?>").select2();                 
             




$("#<?php echo $this->campoSeguro('tipo_novedad') ?>").change(function() {

    if($("#<?php echo $this->campoSeguro('tipo_novedad') ?>").val()!=''){
    
    $("#<?php echo $this->campoSeguro('numero_solicitud') ?>").val(null);
    $("#<?php echo $this->campoSeguro('numero_solicitud') ?>").select2();
    $("#<?php echo $this->campoSeguro('numero_cdp') ?>").val(null);
    $("#<?php echo $this->campoSeguro('numero_cdp') ?>").select2();
    $("#<?php echo $this->campoSeguro('vigencia_novedad') ?>").val(null);
    $("#<?php echo $this->campoSeguro('vigencia_novedad') ?>").select2();
    $("#<?php echo $this->campoSeguro('valor_adicion_presupuesto') ?>").val('');
    $("#<?php echo $this->campoSeguro('numero_cdp') ?>").attr('disabled', '');
    $("#<?php echo $this->campoSeguro('numero_solicitud') ?>").attr('disabled', '');

    
     if($("#<?php echo $this->campoSeguro('tipo_novedad') ?>").val()==220){
              $("#<?php echo $this->campoSeguro('divisionAdicion') ?>").css('display','block');
              $("#<?php echo $this->campoSeguro('divisionAnulacion') ?>").css('display','none');
              $("#<?php echo $this->campoSeguro('divisionCambioSupervisor') ?>").css('display','none');
              $("#<?php echo $this->campoSeguro('divisionCesion') ?>").css('display','none');
              $("#<?php echo $this->campoSeguro('divisionSuspension') ?>").css('display','none');
    
            }
        if($("#<?php echo $this->campoSeguro('tipo_novedad') ?>").val()==234){
            $("#<?php echo $this->campoSeguro('divisionAnulacion') ?>").css('display','block');
            $("#<?php echo $this->campoSeguro('divisionAdicion') ?>").css('display','none');
              $("#<?php echo $this->campoSeguro('divisionCambioSupervisor') ?>").css('display','none');
              $("#<?php echo $this->campoSeguro('divisionCesion') ?>").css('display','none');
              $("#<?php echo $this->campoSeguro('divisionSuspension') ?>").css('display','none');
            }
        if($("#<?php echo $this->campoSeguro('tipo_novedad') ?>").val()==222){
            $("#<?php echo $this->campoSeguro('divisionCambioSupervisor') ?>").css('display','block');
            $("#<?php echo $this->campoSeguro('divisionAdicion') ?>").css('display','none');
              $("#<?php echo $this->campoSeguro('divisionAnulacion') ?>").css('display','none');
              $("#<?php echo $this->campoSeguro('divisionCesion') ?>").css('display','none');
              $("#<?php echo $this->campoSeguro('divisionSuspension') ?>").css('display','none');
            }
        if($("#<?php echo $this->campoSeguro('tipo_novedad') ?>").val()==219){
            $("#<?php echo $this->campoSeguro('divisionCesion') ?>").css('display','block');
                 $("#<?php echo $this->campoSeguro('divisionAdicion') ?>").css('display','none');
              $("#<?php echo $this->campoSeguro('divisionAnulacion') ?>").css('display','none');
              $("#<?php echo $this->campoSeguro('divisionCambioSupervisor') ?>").css('display','none');
              $("#<?php echo $this->campoSeguro('divisionSuspension') ?>").css('display','none');
            }
        if($("#<?php echo $this->campoSeguro('tipo_novedad') ?>").val()==216){
            $("#<?php echo $this->campoSeguro('divisionSuspension') ?>").css('display','block');
              $("#<?php echo $this->campoSeguro('divisionAdicion') ?>").css('display','none');
              $("#<?php echo $this->campoSeguro('divisionAnulacion') ?>").css('display','none');
              $("#<?php echo $this->campoSeguro('divisionCambioSupervisor') ?>").css('display','none');
              $("#<?php echo $this->campoSeguro('divisionCesion') ?>").css('display','none');
            }
        if($("#<?php echo $this->campoSeguro('tipo_novedad') ?>").val()==217){
            $("#<?php echo $this->campoSeguro('divisionSuspension') ?>").css('display','none');
              $("#<?php echo $this->campoSeguro('divisionAdicion') ?>").css('display','none');
              $("#<?php echo $this->campoSeguro('divisionAnulacion') ?>").css('display','none');
              $("#<?php echo $this->campoSeguro('divisionCambioSupervisor') ?>").css('display','none');
              $("#<?php echo $this->campoSeguro('divisionCesion') ?>").css('display','none');
            }
        if($("#<?php echo $this->campoSeguro('tipo_novedad') ?>").val()==218){
            $("#<?php echo $this->campoSeguro('divisionSuspension') ?>").css('display','none');
              $("#<?php echo $this->campoSeguro('divisionAdicion') ?>").css('display','none');
              $("#<?php echo $this->campoSeguro('divisionAnulacion') ?>").css('display','none');
              $("#<?php echo $this->campoSeguro('divisionCambioSupervisor') ?>").css('display','none');
              $("#<?php echo $this->campoSeguro('divisionCesion') ?>").css('display','none');
            }
       }
      else{
    
        $("#<?php echo $this->campoSeguro('divisionAdicion') ?>").css('display','none');
        $("#<?php echo $this->campoSeguro('divisionAnulacion') ?>").css('display','none');
        $("#<?php echo $this->campoSeguro('divisionCambioSupervisor') ?>").css('display','none');
        $("#<?php echo $this->campoSeguro('divisionCesion') ?>").css('display','none');
        $("#<?php echo $this->campoSeguro('divisionSuspension') ?>").css('display','none');
    
    }
    
});



$("#<?php echo $this->campoSeguro('tipo_adicion') ?>").change(function() {

    if($("#<?php echo $this->campoSeguro('tipo_adicion') ?>").val()!=''){

        if($("#<?php echo $this->campoSeguro('tipo_adicion') ?>").val()==248){
              $("#<?php echo $this->campoSeguro('divisionAdicionPresupuesto') ?>").css('display','block');
              $("#<?php echo $this->campoSeguro('divisionAdicionTiempo') ?>").css('display','none');
                 
            }
            else{
            $("#<?php echo $this->campoSeguro('divisionAdicionTiempo') ?>").css('display','block');
            $("#<?php echo $this->campoSeguro('divisionAdicionPresupuesto') ?>").css('display','none');
            
    $("#<?php echo $this->campoSeguro('numero_solicitud') ?>").val(null);
    $("#<?php echo $this->campoSeguro('numero_solicitud') ?>").select2();
    $("#<?php echo $this->campoSeguro('numero_cdp') ?>").val(null);
    $("#<?php echo $this->campoSeguro('numero_cdp') ?>").select2();
    $("#<?php echo $this->campoSeguro('vigencia_novedad') ?>").val(null);
    $("#<?php echo $this->campoSeguro('vigencia_novedad') ?>").select2();
    $("#<?php echo $this->campoSeguro('valor_adicion_presupuesto') ?>").val('');
    $("#<?php echo $this->campoSeguro('numero_cdp') ?>").attr('disabled', '');
    $("#<?php echo $this->campoSeguro('numero_solicitud') ?>").attr('disabled', '');
            
            }
       }
      else{
    
        $("#<?php echo $this->campoSeguro('divisionAdicionTiempo') ?>").css('display','none');
        $("#<?php echo $this->campoSeguro('divisionAdicionPresupuesto') ?>").css('display','none');
   
    
    }
    
});




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
	   