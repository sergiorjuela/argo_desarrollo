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



$("#<?php echo $this->campoSeguro('clase_contrato') ?>").width(250);
$("#<?php echo $this->campoSeguro('clase_contrato') ?>").select2();
$("#<?php echo $this->campoSeguro('tipo_novedad') ?>").select2();
$("#<?php echo $this->campoSeguro('dependencia') ?>").width(450);
$("#<?php echo $this->campoSeguro('dependencia') ?>").select2();
$("#<?php echo $this->campoSeguro('vigencia') ?>").select2();
$("#<?php echo $this->campoSeguro('unidad_ejecutora') ?>").select2();



$("#<?php echo $this->campoSeguro('tipo_novedad') ?>").change(function() {

    if($("#<?php echo $this->campoSeguro('tipo_novedad') ?>").val()!=''){

        if($("#<?php echo $this->campoSeguro('tipo_novedad') ?>").val()==216){
            $("#<?php echo $this->campoSeguro('divisionNovedad') ?>").css('display','block');
            }else{
            $("#<?php echo $this->campoSeguro('divisionNovedad') ?>").css('display','none');
        }
    }else{
    
        $("#<?php echo $this->campoSeguro('divisionNovedad') ?>").css('display','none');
    }
    
});
