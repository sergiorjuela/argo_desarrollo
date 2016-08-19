<?php

namespace blocks\gui\bannerApp\formulario;

if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

class Formulario {

    var $miConfigurador;
    var $lenguaje;
    var $miFormulario;

    function __construct($lenguaje, $formulario) {
        $this->miConfigurador = \Configurador::singleton();

        $this->miConfigurador->fabricaConexiones->setRecursoDB('principal');

        $this->lenguaje = $lenguaje;

        $this->miFormulario = $formulario;
    }

    function formulario() {
        $this->estructura();
    }

    function estructura() {
        // ------------------- Inicio División -------------------------------
        $esteCampo = 'bannerAplicativo';
        $atributos ['id'] = $esteCampo;
        $atributos ['estilo'] = 'bannerAplicativo';
        $atributos['imagen'] = $this->miConfigurador->getVariableConfiguracion('rutaUrlBloque') . 'css/images/banner_argo.jpg';
        $atributos ['estiloEnLinea'] = '';
        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
        echo $this->miFormulario->division("inicio", $atributos);
        {
            $esteCampo = 'banner';
            $atributos ['id'] = $esteCampo;
            $atributos['estilo'] = $esteCampo;
            $atributos['etiqueta'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
            $atributos['ancho'] = '100%';
            $atributos['alto'] = '1%';
            echo $this->miFormulario->campoImagen($atributos);
            unset($atributos);
            
            
        }

        // ---------------------Fin Division -----------------------------------
        echo $this->miFormulario->division("fin");
    }

}

$miFormulario = new Formulario($this->lenguaje, $this->miFormulario);

$miFormulario->formulario();
?>