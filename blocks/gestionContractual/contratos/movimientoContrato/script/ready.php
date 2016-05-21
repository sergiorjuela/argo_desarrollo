<?php
$_REQUEST ['tiempo'] = time();
?>



$("#<?php echo $this->campoSeguro('clase_contrato') ?>").width(250);
$("#<?php echo $this->campoSeguro('clase_contrato') ?>").select2();
$("#<?php echo $this->campoSeguro('tipo_modificacion') ?>").width(250);
$("#<?php echo $this->campoSeguro('tipo_modificacion') ?>").select2();
$("#<?php echo $this->campoSeguro('dependencia') ?>").width(450);
$("#<?php echo $this->campoSeguro('dependencia') ?>").select2();
$("#<?php echo $this->campoSeguro('vigencia') ?>").width(200);
$("#<?php echo $this->campoSeguro('vigencia') ?>").select2();
$("#<?php echo $this->campoSeguro('numero_disponibilidad') ?>").select2();
$("#<?php echo $this->campoSeguro('unidad_ejecutora') ?>").width(200);
$("#<?php echo $this->campoSeguro('unidad_ejecutora') ?>").select2();



$("#<?php echo $this->campoSeguro('tipo_modificacion') ?>").change(function() {

if($("#<?php echo $this->campoSeguro('tipo_modificacion') ?>").val()!=''){

if($("#<?php echo $this->campoSeguro('tipo_modificacion') ?>").val()==219){
$("#<?php echo $this->campoSeguro('divisionCesion') ?>").css('display','block');
}else{
$("#<?php echo $this->campoSeguro('divisionCesion') ?>").css('display','none');
}

if($("#<?php echo $this->campoSeguro('tipo_modificacion') ?>").val()==220 ||$("#<?php echo $this->campoSeguro('tipo_modificacion') ?>").val()==237 ||$("#<?php echo $this->campoSeguro('tipo_modificacion') ?>").val()==238 ){
$("#<?php echo $this->campoSeguro('divisionAdicion') ?>").css('display','block');
}else{
$("#<?php echo $this->campoSeguro('divisionAdicion') ?>").css('display','none');
}


}else{
$("#<?php echo $this->campoSeguro('divisionCesion') ?>").css('display','none');
$("#<?php echo $this->campoSeguro('divisionAdicion') ?>").css('display','none');
}
});


$( "#<?php echo $this->campoSeguro('valor_adicion') ?>" ).keyup(function() {

adicion=Number($("#<?php echo $this->campoSeguro('valor_adicion') ?>").val());
inicial=Number($("#<?php echo $this->campoSeguro('valor_inicial') ?>").val());
final=adicion+inicial;

$("#<?php echo $this->campoSeguro('valor_final') ?>").val(final)

});  
