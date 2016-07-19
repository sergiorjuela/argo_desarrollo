<?php
$indice=0;
$estilo[$indice++]="jquery.dataTables.css";
$estilo[$indice++]="jquery.dataTables_themeroller.css";
$estilo[$indice++]="select2.css";
$estilo[$indice++]="select2.min.css";
$estilo[$indice++]="jquery.steps.css";
$estilo[$indice++]="jquery.auto-complete.css";

/*
 * Estilo Personalizado del Bloque actual
 */

$estilo[$indice++]="estiloBloque.css";






$rutaBloque=$this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site");

if($unBloque["grupo"]==""){
	$rutaBloque.="/blocks/".$unBloque["nombre"];
}else{
	$rutaBloque.="/blocks/".$unBloque["grupo"]."/".$unBloque["nombre"];
}

foreach ($estilo as $nombre){
	echo "<link rel='stylesheet' type='text/css' href='".$rutaBloque."/css/".$nombre."'>\n";
}
?>
