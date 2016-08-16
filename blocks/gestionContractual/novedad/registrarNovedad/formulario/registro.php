<?php

if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

class registrarForm {

    var $miConfigurador;
    var $lenguaje;
    var $miFormulario;
    var $miSql;

    function __construct($lenguaje, $formulario, $sql) {
        $this->miConfigurador = \Configurador::singleton();

        $this->miConfigurador->fabricaConexiones->setRecursoDB('principal');

        $this->lenguaje = $lenguaje;

        $this->miFormulario = $formulario;

        $this->miSql = $sql;
    }

    function miForm() {

        // Rescatar los datos de este bloque
        $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
        $miPaginaActual = $this->miConfigurador->getVariableConfiguracion('pagina');

        $directorio = $this->miConfigurador->getVariableConfiguracion("host");
        $directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
        $directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");

        // ---------------- SECCION: Parámetros Globales del Formulario ----------------------------------
        /**
         * Atributos que deben ser aplicados a todos los controles de este formulario.
         * Se utiliza un arreglo
         * independiente debido a que los atributos individuales se reinician cada vez que se declara un campo.
         *
         * Si se utiliza esta técnica es necesario realizar un mezcla entre este arreglo y el específico en cada control:
         * $atributos= array_merge($atributos,$atributosGlobales);
         */
        $atributosGlobales ['campoSeguro'] = 'true';

        $_REQUEST ['tiempo'] = time();
      
        // -------------------------------------------------------------------------------------------------
        $conexion = "contractual";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
        $conexionSICA = "sicapital";
        $DBSICA = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionSICA);

        // Limpia Items Tabla temporal
        // ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------

        $esteCampo = $esteBloque ['nombre'];
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;

        /**
         * Nuevo a partir de la versión 1.0.0.2, se utiliza para crear de manera rápida el js asociado a
         * validationEngine.
         */
        // Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
        $atributos ['tipoFormulario'] = 'multipart/form-data';
        // Si no se coloca, entonces toma el valor predeterminado 'POST'
        $atributos ['metodo'] = 'POST';
        // Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
        $atributos ['action'] = 'index.php';
        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo);
        // Si no se coloca, entonces toma el valor predeterminado.
        $atributos ['estilo'] = '';
        $atributos ['marco'] = true;
        $tab = 1;
        // ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
        // ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
        $atributos ['tipoEtiqueta'] = 'inicio';
        $atributos = array_merge($atributos);
        echo $this->miFormulario->formulario($atributos);
        // ---------------- SECCION: Controles del Formulario -----------------------------------------------


        $esteCampo = "marcoDatosBasicos";
        $atributos ['id'] = $esteCampo;
        $atributos ["estilo"] = "jqueryui";
        $atributos ['tipoEtiqueta'] = 'inicio';
        $atributos ["leyenda"] = "Registrar Novedad Contractual: " . $_REQUEST['numero_contrato'] . " | Vigencia: " . $_REQUEST['vigencia'];
        echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);
        unset($atributos);
        $conexionFrameWork = "estructura";
        $DBFrameWork = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionFrameWork);
        $id_usuario = $_REQUEST['usuario'];
        $cadenaSqlUnidad = $this->miSql->getCadenaSql("obtenerInfoUsuario", $id_usuario);
        $unidad = $DBFrameWork->ejecutarAcceso($cadenaSqlUnidad, "busqueda");

        $datosContrato = array('numero_contrato' => $_REQUEST['numero_contrato'],
            'vigencia' => $_REQUEST['vigencia']); {

            if ($unidad[0]['unidad_ejecutora'] == 1) {
                $cadena_sql = $this->miSql->getCadenaSql('Consultar_Contrato_Particular', $datosContrato);
                $datosContratista = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
                $sede = 'Sede';
                $dependencia = 'Dependencia';
            } else {
                $cadena_sql = $this->miSql->getCadenaSql('Consultar_Contrato_Particular_Idexud', $datosContrato);
                $datosContratista = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
                $sede = 'Convenio';
                $dependencia = 'Entidad';
            }

            $etiquetas = array(
                0 => 'Vigencia',
                1 => 'Número Contrato',
                2 => 'Contratista',
                3 => 'Unidad Ejecutora',
                4 => 'Numero de Solicitud de Necesidad',
                5 => 'Numero de CDP',
                6 => $sede,
                7 => $dependencia
            );

            $_REQUEST['arreglo'] = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $_REQUEST['arreglo']);
            $arreglo = unserialize($_REQUEST['arreglo']);


            $variable = "pagina=" . $miPaginaActual;
            $variable .= "&opcion=consultar";
            $variable .= "&numero_orden=" . $arreglo ['numero\_contrato'];
            $variable .= "&tipo_contrato=" . $arreglo ['tipo\_contrato'];
            $variable .= "&vigencia=" . $arreglo ['vigencia'];
            $variable .= "&id_proveedor=" . $arreglo ['nit'];
            $variable .= "&fecha_inicio=" . $arreglo ['fecha\_inicial'];
            $variable .= "&fecha_final=" . $arreglo ['fecha\_final'];
            $variable .= "&sedeConsulta=" . $arreglo ['sede'];
            $variable .= "&dependenciaConsulta=" . $arreglo ['dependencia'];
            $variable .= "&convenio_solicitante=" . $arreglo ['dependencia'];

            $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);



            $cadenaSql = $this->miSql->getCadenaSql('consultarValorElementos', $_REQUEST ['id_orden']);



            $sqlSupervisor = $this->miSql->getCadenaSql("consultaSupervisor", $datosContratista[0][8]);

            $inforSupervisor = $DBSICA->ejecutarAcceso($sqlSupervisor, "busqueda");

            // ------------------Division para los botones-------------------------
            $atributos ["id"] = "ventanaA";
            echo $this->miFormulario->division("inicio", $atributos);
            unset($atributos); { {
                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'botonRegresar';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['enlace'] = $variable;
                    $atributos ['tabIndex'] = 1;
                    $atributos ['estilo'] = 'textoSubtitulo';
                    $atributos ['enlaceTexto'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['ancho'] = '10%';
                    $atributos ['alto'] = '10%';
                    $atributos ['redirLugar'] = true;
                    echo $this->miFormulario->enlace($atributos);
                    unset($atributos);

                    $esteCampo = "AgrupacionInformación";
                    $atributos ['id'] = $esteCampo;
                    $atributos ['leyenda'] = "Datos Generales Contratista";
                    echo $this->miFormulario->agrupacion('inicio', $atributos); {
                        if ($datosContratista) {

                            foreach ($etiquetas as $key => $values) {
                                $esteCampo = $etiquetas[$key];
                                $atributos ['id'] = $esteCampo;
                                $atributos ['nombre'] = $esteCampo;
                                $atributos ['tipo'] = 'text';
                                $atributos ['estilo'] = 'textoPequenno';
                                $atributos ['marco'] = true;
                                $atributos ['estiloMarco'] = '';
                                $atributos ['texto'] = $etiquetas[$key] . ": " . $datosContratista[0][$key];
                                $atributos ["etiquetaObligatorio"] = false;
                                $atributos ['columnas'] = 1;
                                $atributos ['dobleLinea'] = 0;
                                $atributos ['tabIndex'] = $tab;
                                $atributos ['validar'] = '';
                                $atributos ['titulo'] = '';
                                $atributos ['deshabilitado'] = true;
                                $atributos ['tamanno'] = 10;
                                $atributos ['maximoTamanno'] = '';
                                $atributos ['anchoEtiqueta'] = 10;
                                $tab ++;
                                // Aplica atributos globales al control
                                $atributos = array_merge($atributos, $atributosGlobales);
                                echo $this->miFormulario->campoTexto($atributos);
                                unset($atributos);
                            }
                        } else {

                            echo "<center>No hay datos para el contratista</center>";
                        }
                    }

                    echo $this->miFormulario->agrupacion('fin');
                    unset($atributos);
                } {

                    $atributos ["id"] = "division";
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos); {
                        $esteCampo = 'tipo_novedad';
                        $atributos ['columnas'] = 3;
                        $atributos ['nombre'] = $esteCampo;
                        $atributos ['id'] = $esteCampo;
                        $atributos ['evento'] = '';
                        $atributos ['deshabilitado'] = false;
                        $atributos ["etiquetaObligatorio"] = true;
                        $atributos ['tab'] = $tab;
                        $atributos ['tamanno'] = 1;
                        $atributos ['estilo'] = 'jqueryui';
                        $atributos ['validar'] = 'required';
                        $atributos ['limitar'] = false;
                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                        $atributos ['anchoEtiqueta'] = 213;
                        $atributos ['anchoCaja'] = 100;
                        $atributos ['seleccion'] = -1;
                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }

                        $matrizItems = array(
                            array(
                                ' ',
                                'Sin Tipo de Novedades'
                            )
                        );

                        // $atributos ['matrizItems'] = $matrizItems;
                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        $atributos ['baseDatos'] = 'contractual';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_novedad");

                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);

                        $esteCampo = 'numero_acto';
                        $atributos ['id'] = $esteCampo;
                        $atributos ['nombre'] = $esteCampo;
                        $atributos ['tipo'] = 'text';
                        $atributos ['estilo'] = 'jqueryui';
                        $atributos ['marco'] = true;
                        $atributos ['estiloMarco'] = '';
                        $atributos ["etiquetaObligatorio"] = true;
                        $atributos ['columnas'] = 3;
                        $atributos ['dobleLinea'] = 0;
                        $atributos ['tabIndex'] = $tab;
                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                        $atributos ['validar'] = 'required, minSize[1],maxSize[9]';

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['valor'] = "";
                        }
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = false;
                        $atributos ['tamanno'] = 10;
                        $atributos ['maximoTamanno'] = '';
                        $atributos ['anchoEtiqueta'] = 250;
                        $tab ++;

                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);

                        $atributos ["id"] = "divisionCesion";
                        $atributos ["estiloEnLinea"] = "display:none";
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->division("inicio", $atributos);
                        unset($atributos); {


                            echo "<center>";


                            $esteCampo = "selec_proveedor";
                            $atributos ['id'] = $esteCampo;
                            $atributos ['nombre'] = $esteCampo;
                            $atributos ['tipo'] = 'text';
                            $atributos ['estilo'] = 'jqueryui';
                            $atributos ['marco'] = true;
                            $atributos ['estiloMarco'] = '';
                            $atributos ["etiquetaObligatorio"] = false;
                            $atributos ['columnas'] = 1;
                            $atributos ['dobleLinea'] = 0;
                            $atributos ['tabIndex'] = $tab;
                            $atributos ['etiqueta'] = "";
                            $atributos ['validar'] = ' ';
                            $atributos ['textoFondo'] = 'Ingrese el documento y de clic en el boton que aparece a continuación.';

                            if (isset($_REQUEST [$esteCampo])) {
                                $atributos ['valor'] = $_REQUEST [$esteCampo];
                            } else {
                                $atributos ['valor'] = '';
                            }
                            $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                            $atributos ['deshabilitado'] = false;
                            $atributos ['tamanno'] = 50;
                            $atributos ['maximoTamanno'] = '';
                            $atributos ['anchoEtiqueta'] = 220;
                            $tab ++;



                            // Aplica atributos globales al control
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroTexto($atributos);
                            unset($atributos);

                            echo "</center>";


                            echo "<br>";
                            $atributos ["id"] = "botones";
                            $atributos ["estilo"] = "marcoBotones";
                            echo $this->miFormulario->division("inicio", $atributos);
                            unset($atributos);
                            $esteCampo = 'botonContratista';
                            $atributos ["id"] = $esteCampo;
                            $atributos ["tabIndex"] = $tab;
                            $atributos ["tipo"] = 'boton';
                            // submit: no se coloca si se desea un tipo button genérico
                            $atributos ['onClick'] = 'consultarContratistas()';
                            $atributos ["estiloMarco"] = '';
                            $atributos ["estiloBoton"] = '';
                            // verificar: true para verificar el formulario antes de pasarlo al servidor.
                            $atributos ["verificar"] = '';
                            $atributos ["tipoSubmit"] = ''; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
                            $atributos ["valor"] = $this->lenguaje->getCadena($esteCampo);
                            $tab ++;

                            // Aplica atributos globales al control
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoBoton($atributos);
                            unset($atributos);

                            echo $this->miFormulario->division('fin');


                            $esteCampo = 'nuevoContratista';
                            $atributos ['id'] = $esteCampo;
                            $atributos ['nombre'] = $esteCampo;
                            $atributos ['tipo'] = 'text';
                            $atributos ['estilo'] = 'jqueryui';
                            $atributos ['marco'] = true;
                            $atributos ['estiloMarco'] = '';
                            $atributos ["etiquetaObligatorio"] = true;
                            $atributos ['columnas'] = 1;
                            $atributos ['dobleLinea'] = 0;
                            $atributos ['tabIndex'] = $tab;
                            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                            $atributos ['validar'] = 'required ';

                            if (isset($_REQUEST [$esteCampo])) {
                                $atributos ['valor'] = $_REQUEST [$esteCampo];
                            } else {
                                $atributos ['valor'] = '';
                            }
                            $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                            $atributos ['deshabilitado'] = true;
                            $atributos ['tamanno'] = 40;
                            $atributos ['maximoTamanno'] = '';
                            $atributos ['anchoEtiqueta'] = 300;
                            $tab ++;

                            // Aplica atributos globales al control
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroTexto($atributos);
                            unset($atributos);

                            $esteCampo = 'fecha_inicio_cesion';
                            $atributos ['id'] = $esteCampo;
                            $atributos ['nombre'] = $esteCampo;
                            $atributos ['tipo'] = 'text';
                            $atributos ['estilo'] = 'jqueryui';
                            $atributos ['marco'] = true;
                            $atributos ['estiloMarco'] = '';
                            $atributos ["etiquetaObligatorio"] = true;
                            $atributos ['columnas'] = 1;
                            $atributos ['dobleLinea'] = 0;
                            $atributos ['tabIndex'] = $tab;
                            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                            $atributos ['validar'] = 'required';

                            if (isset($_REQUEST [$esteCampo])) {
                                $atributos ['valor'] = $_REQUEST [$esteCampo];
                            } else {
                                $atributos ['valor'] = '';
                            }
                            $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                            $atributos ['deshabilitado'] = false;
                            $atributos ['tamanno'] = 10;
                            $atributos ['maximoTamanno'] = '';
                            $atributos ['anchoEtiqueta'] = 213;
                            $tab ++;

                            // Aplica atributos globales al control
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroTexto($atributos);
                            unset($atributos);
                        }
                        // ------------------Fin Division para los botones-------------------------
                        echo $this->miFormulario->division("fin");
                        unset($atributos);
                        $atributos ["id"] = "divisionSuspension";
                        $atributos ["estiloEnLinea"] = "display:none";
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->division("inicio", $atributos);
                        unset($atributos); {

                            $esteCampo = 'fecha_inicio_suspension';
                            $atributos ['id'] = $esteCampo;
                            $atributos ['nombre'] = $esteCampo;
                            $atributos ['tipo'] = 'text';
                            $atributos ['estilo'] = 'jqueryui';
                            $atributos ['marco'] = true;
                            $atributos ['estiloMarco'] = '';
                            $atributos ["etiquetaObligatorio"] = true;
                            $atributos ['columnas'] = 1;
                            $atributos ['dobleLinea'] = 0;
                            $atributos ['tabIndex'] = $tab;
                            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                            $atributos ['validar'] = 'required';

                            if (isset($_REQUEST [$esteCampo])) {
                                $atributos ['valor'] = $_REQUEST [$esteCampo];
                            } else {
                                $atributos ['valor'] = '';
                            }
                            $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                            $atributos ['deshabilitado'] = false;
                            $atributos ['tamanno'] = 10;
                            $atributos ['maximoTamanno'] = '';
                            $atributos ['anchoEtiqueta'] = 250;
                            $tab ++;

                            // Aplica atributos globales al control
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroTexto($atributos);
                            unset($atributos);

                            $esteCampo = 'fecha_fin_suspension';
                            $atributos ['id'] = $esteCampo;
                            $atributos ['nombre'] = $esteCampo;
                            $atributos ['tipo'] = 'text';
                            $atributos ['estilo'] = 'jqueryui';
                            $atributos ['marco'] = true;
                            $atributos ['estiloMarco'] = '';
                            $atributos ["etiquetaObligatorio"] = true;
                            $atributos ['columnas'] = 1;
                            $atributos ['dobleLinea'] = 0;
                            $atributos ['tabIndex'] = $tab;
                            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                            $atributos ['validar'] = 'required';

                            if (isset($_REQUEST [$esteCampo])) {
                                $atributos ['valor'] = $_REQUEST [$esteCampo];
                            } else {
                                $atributos ['valor'] = '';
                            }
                            $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                            $atributos ['deshabilitado'] = false;
                            $atributos ['tamanno'] = 10;
                            $atributos ['maximoTamanno'] = '';
                            $atributos ['anchoEtiqueta'] = 250;
                            $tab ++;

                            // Aplica atributos globales al control
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroTexto($atributos);
                            unset($atributos);
                        }
                        // ------------------Fin Division para los botones-------------------------
                        echo $this->miFormulario->division("fin");
                        unset($atributos);


                        $atributos ["id"] = "divisionAnulacion";
                        $atributos ["estiloEnLinea"] = "display:none";
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->division("inicio", $atributos);
                        unset($atributos); {

                            $esteCampo = 'tipo_anulacion';
                            $atributos ['columnas'] = 1;
                            $atributos ['nombre'] = $esteCampo;
                            $atributos ['id'] = $esteCampo;
                            $atributos ['evento'] = '';
                            $atributos ['deshabilitado'] = false;
                            $atributos ["etiquetaObligatorio"] = true;
                            $atributos ['tab'] = $tab;
                            $atributos ['tamanno'] = 1;
                            $atributos ['estilo'] = 'jqueryui';
                            $atributos ['validar'] = 'required';
                            $atributos ['limitar'] = false;
                            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                            $atributos ['anchoEtiqueta'] = 213;
                            $atributos ['anchoCaja'] = 150;
                            $atributos ['seleccion'] = -1;
                            if (isset($_REQUEST [$esteCampo])) {
                                $atributos ['valor'] = $_REQUEST [$esteCampo];
                            } else {
                                $atributos ['valor'] = '';
                            }

                            $matrizItems = array(
                                array(
                                    ' ',
                                    'Sin Tipo de Novedades'
                                )
                            );

                            $atributos ['baseDatos'] = 'contractual';
                            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_anulacion");

                            $tab ++;
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroLista($atributos);
                            unset($atributos);
                        }
                        // ------------------Fin Division para los botones-------------------------
                        echo $this->miFormulario->division("fin");
                        unset($atributos);

                        $atributos ["id"] = "divisionCambioSupervisor";
                        $atributos ["estiloEnLinea"] = "display:none";
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->division("inicio", $atributos);
                        unset($atributos); {

                            $esteCampo = 'tipoCambioSupervisor';
                            $atributos ['columnas'] = 1;
                            $atributos ['nombre'] = $esteCampo;
                            $atributos ['id'] = $esteCampo;
                            $atributos ['evento'] = '';
                            $atributos ['deshabilitado'] = false;
                            $atributos ["etiquetaObligatorio"] = true;
                            $atributos ['tab'] = $tab;
                            $atributos ['tamanno'] = 1;
                            $atributos ['estilo'] = 'jqueryui';
                            $atributos ['validar'] = 'required';
                            $atributos ['limitar'] = false;
                            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                            $atributos ['anchoEtiqueta'] = 220;
                            $atributos ['anchoCaja'] = 150;
                            $atributos ['seleccion'] = -1;
                            if (isset($_REQUEST [$esteCampo])) {
                                $atributos ['valor'] = $_REQUEST [$esteCampo];
                            } else {
                                $atributos ['valor'] = '';
                            }

                            $matrizItems = array(
                                array(
                                    ' ',
                                    'Sin Tipo de Novedades'
                                )
                            );

                            $atributos ['baseDatos'] = 'contractual';
                            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_cambio_supervisor");

                            $tab ++;
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroLista($atributos);
                            unset($atributos);


                            $esteCampo = 'supervisor_actual';
                            $atributos ['id'] = $esteCampo;
                            $atributos ['nombre'] = $esteCampo;
                            $atributos ['tipo'] = 'text';
                            $atributos ['estilo'] = 'jqueryui';
                            $atributos ['marco'] = true;
                            $atributos ['estiloMarco'] = '';
                            $atributos ["etiquetaObligatorio"] = false;
                            $atributos ['columnas'] = 1;
                            $atributos ['dobleLinea'] = 0;
                            $atributos ['tabIndex'] = $tab;
                            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                            $atributos ['validar'] = '';
                            $atributos ['valor'] = $inforSupervisor[0][0];
                            $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                            $atributos ['deshabilitado'] = true;
                            $atributos ['tamanno'] = 40;
                            $atributos ['maximoTamanno'] = '';
                            $atributos ['anchoEtiqueta'] = 150;
                            $tab ++;

                            // Aplica atributos globales al control
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroTexto($atributos);
                            unset($atributos);


                            $esteCampo = 'nuevoSupervisor';
                            $atributos ['columnas'] = 1;
                            $atributos ['nombre'] = $esteCampo;
                            $atributos ['id'] = $esteCampo;
                            $atributos ['evento'] = '';
                            $atributos ['deshabilitado'] = false;
                            $atributos ["etiquetaObligatorio"] = true;
                            $atributos ['tab'] = $tab;
                            $atributos ['tamanno'] = 1;
                            $atributos ['estilo'] = 'jqueryui';
                            $atributos ['validar'] = 'required';
                            $atributos ['limitar'] = false;
                            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                            $atributos ['anchoEtiqueta'] = 213;
                            $atributos ['anchoCaja'] = 150;
                            $atributos ['seleccion'] = -1;
                            if (isset($_REQUEST [$esteCampo])) {
                                $atributos ['valor'] = $_REQUEST [$esteCampo];
                            } else {
                                $atributos ['valor'] = '';
                            }

                            $matrizItems = array(
                                array(
                                    ' ',
                                    'Sin Tipo de Novedades'
                                )
                            );

                            $atributos ['baseDatos'] = 'sicapital';
                            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("funcionarios");

                            $tab ++;
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroLista($atributos);
                            unset($atributos);

                            $esteCampo = 'fecha_oficial_cambio';
                            $atributos ['id'] = $esteCampo;
                            $atributos ['nombre'] = $esteCampo;
                            $atributos ['tipo'] = 'text';
                            $atributos ['estilo'] = 'jqueryui';
                            $atributos ['marco'] = true;
                            $atributos ['estiloMarco'] = '';
                            $atributos ["etiquetaObligatorio"] = true;
                            $atributos ['columnas'] = 1;
                            $atributos ['dobleLinea'] = 0;
                            $atributos ['tabIndex'] = $tab;
                            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                            $atributos ['validar'] = 'required';

                            if (isset($_REQUEST [$esteCampo])) {
                                $atributos ['valor'] = $_REQUEST [$esteCampo];
                            } else {
                                $atributos ['valor'] = '';
                            }
                            $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                            $atributos ['deshabilitado'] = false;
                            $atributos ['tamanno'] = 10;
                            $atributos ['maximoTamanno'] = '';
                            $atributos ['anchoEtiqueta'] = 213;
                            $tab ++;

                            // Aplica atributos globales al control
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroTexto($atributos);
                            unset($atributos);
                        }
                        // ------------------Fin Division para los botones-------------------------
                        echo $this->miFormulario->division("fin");
                        unset($atributos);

                        $atributos ["id"] = "divisionAdicion";
                        $atributos ["estiloEnLinea"] = "display:none";
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->division("inicio", $atributos);
                        unset($atributos); {

                            $esteCampo = 'tipo_adicion';
                            $atributos ['columnas'] = 1;
                            $atributos ['nombre'] = $esteCampo;
                            $atributos ['id'] = $esteCampo;
                            $atributos ['evento'] = '';
                            $atributos ['deshabilitado'] = false;
                            $atributos ["etiquetaObligatorio"] = true;
                            $atributos ['tab'] = $tab;
                            $atributos ['tamanno'] = 1;
                            $atributos ['estilo'] = 'jqueryui';
                            $atributos ['validar'] = 'required';
                            $atributos ['limitar'] = false;
                            $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                            $atributos ['anchoEtiqueta'] = 213;
                            $atributos ['anchoCaja'] = 150;
                            $atributos ['seleccion'] = -1;
                            if (isset($_REQUEST [$esteCampo])) {
                                $atributos ['valor'] = $_REQUEST [$esteCampo];
                            } else {
                                $atributos ['valor'] = '';
                            }

                            $matrizItems = array(
                                array(
                                    ' ',
                                    'Sin Tipo de Novedades'
                                )
                            );

                            $atributos ['baseDatos'] = 'contractual';
                            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_adicion");

                            $tab ++;
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroLista($atributos);
                            unset($atributos);


                            $atributos ["id"] = "divisionAdicionPresupuesto";
                            $atributos ["estiloEnLinea"] = "display:none";
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->division("inicio", $atributos);
                            unset($atributos); {

                                $esteCampo = 'vigencia_novedad';
                                $atributos ['columnas'] = 1;
                                $atributos ['nombre'] = $esteCampo;
                                $atributos ['id'] = $esteCampo;
                                $atributos ['evento'] = '';
                                $atributos ['deshabilitado'] = false;
                                $atributos ["etiquetaObligatorio"] = true;
                                $atributos ['tab'] = $tab;
                                $atributos ['tamanno'] = 1;
                                $atributos ['estilo'] = '';
                                $atributos ['validar'] = 'required';
                                $atributos ['limitar'] = false;
                                $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                $atributos ['anchoEtiqueta'] = 213;
                                $atributos ['anchoCaja'] = 150;
                                $atributos ['seleccion'] = -1;
                                if (isset($_REQUEST [$esteCampo])) {
                                    $atributos ['valor'] = $_REQUEST [$esteCampo];
                                } else {
                                    $atributos ['valor'] = '';
                                }

                                $matrizItems = array(
                                    array(
                                        ' ',
                                        'Sin Tipo de Novedades'
                                    )
                                );

                                $atributos ['baseDatos'] = 'sicapital';
                                $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("vigencias_sica_disponibilidades");

                                $tab ++;
                                $atributos = array_merge($atributos, $atributosGlobales);
                                echo $this->miFormulario->campoCuadroLista($atributos);
                                unset($atributos);


                                $esteCampo = 'numero_solicitud';
                                $atributos ['columnas'] = 2;
                                $atributos ['nombre'] = $esteCampo;
                                $atributos ['id'] = $esteCampo;
                                $atributos ['seleccion'] = - 1;
                                $atributos ['evento'] = '';
                                $atributos ['deshabilitado'] = true;
                                $atributos ["etiquetaObligatorio"] = true;
                                $atributos ['tab'] = $tab;
                                $atributos ['tamanno'] = 1;
                                $atributos ['estilo'] = 'jqueryui';
                                $atributos ['validar'] = 'required';
                                $atributos ['limitar'] = false;
                                $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                $atributos ['anchoEtiqueta'] = 213;
                                $atributos ['cadena_sql'] = '';
                                $arreglo = array(
                                    array(
                                        '',
                                        'Seleccione .....'
                                    )
                                );

                                $matrizItems = $arreglo;
                                $atributos ['matrizItems'] = $matrizItems;
                                $tab ++;
                                $atributos = array_merge($atributos, $atributosGlobales);
                                echo $this->miFormulario->campoCuadroLista($atributos);
                                unset($atributos);

                                $esteCampo = 'numero_cdp';
                                $atributos ['columnas'] = 2;
                                $atributos ['nombre'] = $esteCampo;
                                $atributos ['id'] = $esteCampo;
                                $atributos ['seleccion'] = - 1;
                                $atributos ['evento'] = '';
                                $atributos ['deshabilitado'] = true;
                                $atributos ["etiquetaObligatorio"] = true;
                                $atributos ['tab'] = $tab;
                                $atributos ['tamanno'] = 1;
                                $atributos ['estilo'] = 'jqueryui';
                                $atributos ['validar'] = 'required';
                                $atributos ['limitar'] = false;
                                $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                $atributos ['anchoEtiqueta'] = 213;
                                $atributos ['cadena_sql'] = '';

                                $matrizItems = $arreglo;
                                $atributos ['matrizItems'] = $matrizItems;
                                $tab ++;
                                $atributos = array_merge($atributos, $atributosGlobales);
                                echo $this->miFormulario->campoCuadroLista($atributos);
                                unset($atributos);

                                $esteCampo = 'valor_contrato';
                                $atributos ['id'] = $esteCampo;
                                $atributos ['nombre'] = $esteCampo;
                                $atributos ['tipo'] = 'text';
                                $atributos ['estilo'] = 'jqueryui';
                                $atributos ['marco'] = true;
                                $atributos ['estiloMarco'] = '';
                                $atributos ["etiquetaObligatorio"] = false;
                                $atributos ['columnas'] = 3;
                                $atributos ['dobleLinea'] = 0;
                                $atributos ['tabIndex'] = $tab;
                                $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                $atributos ['validar'] = '';
                                $atributos ['valor'] = $datosContratista[0]['valor_contrato'];
                                $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                                $atributos ['deshabilitado'] = true;
                                $atributos ['tamanno'] = 10;
                                $atributos ['maximoTamanno'] = '';
                                $atributos ['anchoEtiqueta'] = 213;
                                $tab ++;

                                // Aplica atributos globales al control
                                $atributos = array_merge($atributos, $atributosGlobales);
                                echo $this->miFormulario->campoCuadroTexto($atributos);
                                unset($atributos);

                                $esteCampo = 'valor_adicion_presupuesto';
                                $atributos ['id'] = $esteCampo;
                                $atributos ['nombre'] = $esteCampo;
                                $atributos ['tipo'] = 'text';
                                $atributos ['estilo'] = 'jqueryui';
                                $atributos ['marco'] = true;
                                $atributos ['estiloMarco'] = '';
                                $atributos ["etiquetaObligatorio"] = true;
                                $atributos ['columnas'] = 3;
                                $atributos ['dobleLinea'] = 0;
                                $atributos ['tabIndex'] = $tab;
                                $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                $atributos ['validar'] = 'required, minSize[1],maxSize[16],custom[onlyNumberSp]';

                                if (isset($_REQUEST [$esteCampo])) {
                                    $atributos ['valor'] = $_REQUEST [$esteCampo];
                                } else {
                                    $atributos ['valor'] = '';
                                }
                                $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                                $atributos ['deshabilitado'] = false;
                                $atributos ['tamanno'] = 10;
                                $atributos ['maximoTamanno'] = '';
                                $atributos ['anchoEtiqueta'] = 213;
                                $tab ++;

                                // Aplica atributos globales al control
                                $atributos = array_merge($atributos, $atributosGlobales);
                                echo $this->miFormulario->campoCuadroTexto($atributos);
                                unset($atributos);
                            }
                            // ------------------Fin Division para los botones-------------------------
                            echo $this->miFormulario->division("fin");
                            unset($atributos);
                            $atributos ["id"] = "divisionAdicionTiempo";
                            $atributos ["estiloEnLinea"] = "display:none";
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->division("inicio", $atributos);
                            unset($atributos); {

                                $esteCampo = 'unidad_tiempo_ejecucion';
                                $atributos ['columnas'] = 2;
                                $atributos ['nombre'] = $esteCampo;
                                $atributos ['id'] = $esteCampo;
                                $atributos ['evento'] = '';
                                $atributos ['deshabilitado'] = false;
                                $atributos ["etiquetaObligatorio"] = true;
                                $atributos ['tab'] = $tab;
                                $atributos ['tamanno'] = 1;
                                $atributos ['estilo'] = 'jqueryui';
                                $atributos ['validar'] = 'required';
                                $atributos ['limitar'] = false;
                                $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                $atributos ['anchoEtiqueta'] = 213;
                                $atributos ['anchoCaja'] = 150;
                                $atributos ['seleccion'] = -1;
                                if (isset($_REQUEST [$esteCampo])) {
                                    $atributos ['valor'] = $_REQUEST [$esteCampo];
                                } else {
                                    $atributos ['valor'] = '';
                                }

                                $matrizItems = array(
                                    array(
                                        ' ',
                                        'Sin Tipo de Novedades'
                                    )
                                );

                                $atributos ['baseDatos'] = 'contractual';
                                $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_unidad_ejecucion");

                                $tab ++;
                                $atributos = array_merge($atributos, $atributosGlobales);
                                echo $this->miFormulario->campoCuadroLista($atributos);
                                unset($atributos);

                                $esteCampo = 'valor_adicion_tiempo';
                                $atributos ['id'] = $esteCampo;
                                $atributos ['nombre'] = $esteCampo;
                                $atributos ['tipo'] = 'text';
                                $atributos ['estilo'] = 'jqueryui';
                                $atributos ['marco'] = true;
                                $atributos ['estiloMarco'] = '';
                                $atributos ["etiquetaObligatorio"] = true;
                                $atributos ['columnas'] = 2;
                                $atributos ['dobleLinea'] = 0;
                                $atributos ['tabIndex'] = $tab;
                                $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                                $atributos ['validar'] = 'required, minSize[1],maxSize[3],custom[onlyNumberSp]';

                                if (isset($_REQUEST [$esteCampo])) {
                                    $atributos ['valor'] = $_REQUEST [$esteCampo];
                                } else {
                                    $atributos ['valor'] = '';
                                }
                                $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                                $atributos ['deshabilitado'] = false;
                                $atributos ['tamanno'] = 10;
                                $atributos ['maximoTamanno'] = '';
                                $atributos ['anchoEtiqueta'] = 213;
                                $tab ++;

                                // Aplica atributos globales al control
                                $atributos = array_merge($atributos, $atributosGlobales);
                                echo $this->miFormulario->campoCuadroTexto($atributos);
                                unset($atributos);
                            }
                            // ------------------Fin Division para los botones-------------------------
                            echo $this->miFormulario->division("fin");
                            unset($atributos);
                        }
                        // ------------------Fin Division para los botones-------------------------
                        echo $this->miFormulario->division("fin");
                        unset($atributos);

                        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                        $esteCampo = 'documentoSoporte';
                        $atributos ['id'] = $esteCampo;
                        $atributos ['nombre'] = $esteCampo;
                        $atributos ['tipo'] = 'file';
                        $atributos ['estilo'] = 'jqueryui';
                        $atributos ['marco'] = true;
                        $atributos ['estiloMarco'] = '';
                        $atributos ["etiquetaObligatorio"] = true;
                        $atributos ['columnas'] = 3;
                        $atributos ['dobleLinea'] = 0;
                        $atributos ['tabIndex'] = $tab;
                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                        $atributos ['validar'] = 'required';

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST[$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = false;
                        $atributos ['tamanno'] = 250;
                        $atributos ['maximoTamanno'] = '';
                        $atributos ['anchoEtiqueta'] = 160;
                        $tab ++;


                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);

                        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                        $esteCampo = 'observaciones';
                        $atributos ['id'] = $esteCampo;
                        $atributos ['nombre'] = $esteCampo;
                        $atributos ['tipo'] = 'text';
                        $atributos ['estilo'] = 'jqueryui';
                        $atributos ['marco'] = true;
                        $atributos ['estiloMarco'] = '';
                        $atributos ["etiquetaObligatorio"] = true;
                        $atributos ['columnas'] = 105;
                        $atributos ['filas'] = 5;
                        $atributos ['dobleLinea'] = 0;
                        $atributos ['tabIndex'] = $tab;
                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                        $atributos ['validar'] = 'required, minSize[1],maxSize[250]';
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = false;
                        $atributos ['tamanno'] = 10;
                        $atributos ['maximoTamanno'] = '';
                        $atributos ['anchoEtiqueta'] = 220;
                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
                        $tab ++;

                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoTextArea($atributos);
                        unset($atributos);

                        $esteCampo = 'unidad_ejecutora_hidden';
                        $atributos ['id'] = $esteCampo;
                        $atributos ['nombre'] = $esteCampo;
                        $atributos ['tipo'] = 'hidden';
                        $atributos ['estilo'] = 'jqueryui';
                        $atributos ['marco'] = true;
                        $atributos ['columnas'] = 1;
                        $atributos ['dobleLinea'] = false;
                        $atributos ['tabIndex'] = $tab;
                        $atributos ['valor'] = $unidad[0]['unidad_ejecutora'];
                        $atributos ['deshabilitado'] = false;
                        $atributos ['tamanno'] = 30;
                        $atributos ['maximoTamanno'] = '';
                        $tab ++;
                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);


                        $esteCampo = 'actualContratista';
                        $atributos ['id'] = $esteCampo;
                        $atributos ['nombre'] = $esteCampo;
                        $atributos ['tipo'] = 'hidden';
                        $atributos ['estilo'] = 'jqueryui';
                        $atributos ['marco'] = true;
                        $atributos ['columnas'] = 1;
                        $atributos ['dobleLinea'] = false;
                        $atributos ['tabIndex'] = $tab;
                        $atributos ['valor'] = $datosContratista[0]['contratista'];
                        $atributos ['deshabilitado'] = false;
                        $atributos ['tamanno'] = 30;
                        $atributos ['maximoTamanno'] = '';
                        $tab ++;
                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);


                        $sqlConsultaSolicitudRegistradas = $this->miSql->getCadenaSql("cdpRegistradas");
                        $resultado = $esteRecursoDB->ejecutarAcceso($sqlConsultaSolicitudRegistradas, "busqueda");



                        $esteCampo = 'cdpRegistradas';
                        $atributos ['id'] = $esteCampo;
                        $atributos ['nombre'] = $esteCampo;
                        $atributos ['tipo'] = 'hidden';
                        $atributos ['estilo'] = 'jqueryui';
                        $atributos ['marco'] = true;
                        $atributos ['columnas'] = 1;
                        $atributos ['dobleLinea'] = false;
                        $atributos ['tabIndex'] = $tab;
                        $atributos ['valor'] = $resultado[0][0];
                        $atributos ['deshabilitado'] = false;
                        $atributos ['tamanno'] = 30;
                        $atributos ['maximoTamanno'] = '';
                        $tab ++;
                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);

                        $sqlConsultaSolicitudRegistradasNovedades = $this->miSql->getCadenaSql("cdpRegistradasNovedades");
                        $resultadoNovedades = $esteRecursoDB->ejecutarAcceso($sqlConsultaSolicitudRegistradasNovedades, "busqueda");
                        if ($resultadoNovedades[0][0] == null) {
                            $resultadoNovedades[0][0] = "0";
                        }

                        $esteCampo = 'cdpRegistradasNovedades';
                        $atributos ['id'] = $esteCampo;
                        $atributos ['nombre'] = $esteCampo;
                        $atributos ['tipo'] = 'hidden';
                        $atributos ['estilo'] = 'jqueryui';
                        $atributos ['marco'] = true;
                        $atributos ['columnas'] = 1;
                        $atributos ['dobleLinea'] = false;
                        $atributos ['tabIndex'] = $tab;
                        $atributos ['valor'] = $resultadoNovedades[0][0];
                        $atributos ['deshabilitado'] = false;
                        $atributos ['tamanno'] = 30;
                        $atributos ['maximoTamanno'] = '';
                        $tab ++;
                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);
                    }
                    // ------------------Fin Division para los botones-------------------------
                    echo $this->miFormulario->division("fin");
                    unset($atributos);
                }
            }

            // ------------------Fin Division para los botones-------------------------
            echo $this->miFormulario->division("fin");
            unset($atributos);

            // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        }
        // ------------------Division para los botones-------------------------
        $atributos ["id"] = "botones";
        $atributos ["estilo"] = "marcoBotones";
        echo $this->miFormulario->division("inicio", $atributos);

        // -----------------CONTROL: Botón ----------------------------------------------------------------
        $esteCampo = 'botonAceptar';
        $atributos ["id"] = $esteCampo;
        $atributos ["tabIndex"] = $tab;
        $atributos ["tipo"] = 'boton';
        // submit: no se coloca si se desea un tipo button genérico
        $atributos ['submit'] = true;
        $atributos ["estiloMarco"] = '';
        $atributos ["estiloBoton"] = 'jqueryui';
        // verificar: true para verificar el formulario antes de pasarlo al servidor.
        $atributos ["verificar"] = '';
        $atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
        $atributos ["valor"] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['nombreFormulario'] = $esteBloque ['nombre'];
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoBoton($atributos);
        // -----------------FIN CONTROL: Botón -----------------------------------------------------------
        // ---------------------------------------------------------
        // ------------------Fin Division para los botones-------------------------
        echo $this->miFormulario->division("fin");

        // ------------------- SECCION: Paso de variables ------------------------------------------------

        /**
         * En algunas ocasiones es útil pasar variables entre las diferentes páginas.
         * SARA permite realizar esto a través de tres
         * mecanismos:
         * (a). Registrando las variables como variables de sesión. Estarán disponibles durante toda la sesión de usuario. Requiere acceso a
         * la base de datos.
         * (b). Incluirlas de manera codificada como campos de los formularios. Para ello se utiliza un campo especial denominado
         * formsara, cuyo valor será una cadena codificada que contiene las variables.
         * (c) a través de campos ocultos en los formularios. (deprecated)
         */
        // En este formulario se utiliza el mecanismo (b) para pasar las siguientes variables:
        // Paso 1: crear el listado de variables

        $valorCodificado = "action=" . $esteBloque ["nombre"];
        $valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
        $valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
        $valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
        $valorCodificado .= "&opcion=registrarNovedad";
        $valorCodificado .= "&usuario=" . $_REQUEST ['usuario'];
        $valorCodificado .= "&numero_contrato=" . $_REQUEST ['numero_contrato'];
        $valorCodificado .= "&vigencia=" . $_REQUEST ['vigencia'];

        /**
         * SARA permite que los nombres de los campos sean dinámicos.
         * Para ello utiliza la hora en que es creado el formulario para
         * codificar el nombre de cada campo. Si se utiliza esta técnica es necesario pasar dicho tiempo como una variable:
         * (a) invocando a la variable $_REQUEST ['tiempo'] que se ha declarado en ready.php o
         * (b) asociando el tiempo en que se está creando el formulario
         */
        $valorCodificado .= "&campoSeguro=" . $_REQUEST ['tiempo'];
        $valorCodificado .= "&tiempo=" . time();
        // Paso 2: codificar la cadena resultante
        $valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar($valorCodificado);

        $atributos ["id"] = "formSaraData"; // No cambiar este nombre
        $atributos ["tipo"] = "hidden";
        $atributos ['estilo'] = '';
        $atributos ["obligatorio"] = false;
        $atributos ['marco'] = true;
        $atributos ["etiqueta"] = "";
        $atributos ["valor"] = $valorCodificado;
        echo $this->miFormulario->campoCuadroTexto($atributos);
        unset($atributos);

        $atributos ['marco'] = true;
        $atributos ['tipoEtiqueta'] = 'fin';
        echo $this->miFormulario->formulario($atributos);
    }

}

$miSeleccionador = new registrarForm($this->lenguaje, $this->miFormulario, $this->sql);

$miSeleccionador->miForm();
?>

