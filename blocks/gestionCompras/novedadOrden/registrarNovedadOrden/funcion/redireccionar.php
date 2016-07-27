<?php

namespace gestionCompras\novedad\registrarNovedad;

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
                $variable .= "&tipo_novedad=" . $valor['tipo_novedad'];
                $variable .= "&acto_administrativo=" . $valor['acto_administrativo'];
                $variable .= "&usuario=" . $_REQUEST ['usuario'];

                break;

            case "ErrorRegistro" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&bloque=" . $_REQUEST ['bloque'];
                $variable .= "&bloqueGrupo=" . $_REQUEST ["bloqueGrupo"];
                $variable .= "&opcion=mensaje";
                $variable .= "&numero_contrato=" . $valor['numero_contrato'];
                $variable .= "&vigencia=" . $valor['vigencia'];
                $variable .= "&tipo_novedad=" . $valor['tipo_novedad'];
                $variable .= "&acto_administrativo=" . $valor['acto_administrativo'];
                $variable .= "&mensaje=noInserto";
                $variable .= "&usuario=" . $_REQUEST ['usuario'];
                break;

            case "rebasaOtroSi" :
                $variable = "pagina=" . $miPaginaActual;
                $variable .= "&bloque=" . $_REQUEST ['bloque'];
                $variable .= "&bloqueGrupo=" . $_REQUEST ["bloqueGrupo"];
                $variable .= "&opcion=mensaje";
                $variable .= "&acumulado=" . $valor['acumulado'];
                $variable .= "&valor_tope=" . $valor['valor_tope'];
                $variable .= "&valor_contrado=" . $valor['valor_contrado'];
                $variable .= "&tipo_novedad=" . $valor['tipo_novedad'];
                $variable .= "&numero_contrato=" . $valor['numero_contrato'];
                $variable .= "&vigencia=" . $valor['vigencia'];
                $variable .= "&valor_adicion=" . $valor['valor_adicion'];
                $variable .= "&mensaje=rebasaOtroSI";
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