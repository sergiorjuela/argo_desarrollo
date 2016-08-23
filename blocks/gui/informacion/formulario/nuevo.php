<?php
$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque .= $esteBloque ['grupo'] . "/" . $esteBloque ['nombre'] . "/css";

$directorio = $this->miConfigurador->getVariableConfiguracion("host");
$directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");
?>
<div id="espacio_trabajo">
    <div id="slider1_container" style="position: relative; top: 0px; left: 0px; width: 1900px; height: 500px; overflow: hidden;">
        <!-- Slides Container -->
        <div u="slides" style="cursor: move; position: relative; overflow: hidden; left: 0px; top: 0px; width: 1900px; height: 500px; overflow: hidden;">
            <div><img u="image" src="<?php echo $rutaBloque ?>/images/Fractales1.jpg" /></div>
            <div><img u="image" src="<?php echo $rutaBloque ?>/images/Fractales2.jpg" /></div>
            <div><img u="image" src="<?php echo $rutaBloque ?>/images/Fractales4.jpg" /></div>
            <div><img u="image" src="<?php echo $rutaBloque ?>/images/Fractales3.jpg" /></div>
        </div>
    </div>
</div>
