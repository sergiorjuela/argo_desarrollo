<?php

namespace gestionContractual\novedad\registrarNovedad;

if (!isset($GLOBALS ["autorizado"])) {
    include ("index.php");
    exit();
}

class redireccion {

    public static function redireccionar($opcion, $valor = "", $valor1 = "") {
        $miConfigurador = \Configurador::singleton();
        $miPaginaActual = $miConfigurador->getVariableConfiguracion("pagina");

        switch ($opcion) {
            case "Inserto" :

                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&bloque=" . $_REQUEST ['bloque'];
                $variable .= "&bloqueGrupo=" . $_REQUEST ["bloqueGrupo"];
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=Inserto";
                $variable .= "&numero_contrato=" . $valor['numero_contrato'];
                $variable .= "&vigencia=" . $valor['vigencia'];
                $variable .= "&usuario=" . $_REQUEST ['usuario'];

                break;

            case "ErrorRegistro" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&bloque=" . $_REQUEST ['bloque'];
                $variable .= "&bloqueGrupo=" . $_REQUEST ["bloqueGrupo"];
                $variable .= "&opcion=mensaje";
                $variable .= "&numero_contrato=" . $valor['numero_contrato'];
                $variable .= "&vigencia=" . $valor['vigencia'];
                $variable .= "&mensaje=noInserto";
                $variable .= "&usuario=" . $_REQUEST ['usuario'];
                break;
        }

        foreach ($_REQUEST as $clave => $valor) {
            unset($_REQUEST [$clave]);
        }



        $url = $miConfigurador->configuracion ["host"] . $miConfigurador->configuracion ["site"] . "/index.php?";
        $enlace = $miConfigurador->configuracion ['enlace'];
        $variable = $miConfigurador->fabricaConexiones->crypto->codificar($variable);
        $_REQUEST [$enlace] = $enlace . '=' . $variable;
        $redireccion = $url . $_REQUEST [$enlace];

        echo "<script>location.replace('" . $redireccion . "')</script>";
    }

}

?>