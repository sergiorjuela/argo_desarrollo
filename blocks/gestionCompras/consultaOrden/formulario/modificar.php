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
        // echo "Modificar Ornden";
        // var_dump ( $_REQUEST );
        // Rescatar los datos de este bloque
        $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

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
        $tiempo = $_REQUEST ['tiempo'];

        // -------------------------------------------------------------------------------------------------
        $conexionContractual = "contractual";
        $DBContractual = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionContractual);
        $conexionFrameWork = "estructura";
        $DBFrameWork = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionFrameWork);
        $datosOrden = array('vigencia' => $_REQUEST['vigencia'], 'numerocontrato' => $_REQUEST['numerocontrato']);
        $cadenaSql = $this->miSql->getCadenaSql('ConsultarInformacionOrden', $datosOrden);
        $Orden = $DBContractual->ejecutarAcceso($cadenaSql, "busqueda");
        $Orden = $Orden [0];


        $arreglo = array(
            'tipo_orden' => $Orden ['tipo_orden'],
            'sede_solicitante' => $Orden ['sede_solicitante'],
            'dependencia_solicitante' => $Orden ['dependencia_solicitante'],
            'sede_super' => $Orden ['sede_supervisor'],
            'dependencia_supervisor' => $Orden ['dependencia_supervisor'],
            'nombre_supervisor' => $Orden ['supervisor'],
            'cargo_supervisor' => $Orden ['cargo_supervisor'],
            'objeto_contrato' => $Orden ['objeto_contrato'],
            'fecha_inicio_pago' => $Orden ['fecha_inicio'],
            'fecha_final_pago' => $Orden ['fecha_final'],
            'plazo_ejecucion' => $Orden ['plazo_ejecucion'],
            'formaPago' => $Orden ['forma_pago'],
            'asignacionOrdenador' => $Orden ['ordenador_gasto'],
            'clausula_presupuesto' => $Orden ['clausula_registro_presupuestal'],
            'unidad_ejecucion' => $Orden ['unidad_ejecucion'],
            'proveedor' => $Orden ['proveedor']
        );

        $cadenaSql = $this->miSql->getCadenaSql('textos');
        $resultado_textos = $DBContractual->ejecutarAcceso($cadenaSql, "busqueda");
        $texto = array(
            'formaPago' => $resultado_textos [1] [1],
            'objeto_contrato' => $resultado_textos [0] [1]
        );

        $_REQUEST = array_merge($_REQUEST, $arreglo);


        // ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
        $esteCampo = $esteBloque ['nombre'];
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        // Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
        $atributos ['tipoFormulario'] = 'multipart/form-data';
        // Si no se coloca, entonces toma el valor predeterminado 'POST'
        $atributos ['metodo'] = 'POST';
        // Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
        $atributos ['action'] = 'index.php';
        // $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo );
        // Si no se coloca, entonces toma el valor predeterminado.
        $atributos ['estilo'] = '';
        $atributos ['marco'] = false;
        $tab = 1;
        // ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
        // ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
        $atributos ['tipoEtiqueta'] = 'inicio';
        echo $this->miFormulario->formulario($atributos);
        {
            // ---------------- SECCION: Controles del Formulario -----------------------------------------------

            $miPaginaActual = $this->miConfigurador->getVariableConfiguracion('pagina');

            $directorio = $this->miConfigurador->getVariableConfiguracion("host");
            $directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
            $directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");

            $arreglo = unserialize(base64_decode($_REQUEST ['arreglo']));


            $esteCampo = "marcoDatosBasicos";
            $atributos ['id'] = $esteCampo;
            $atributos ["estilo"] = "jqueryui";
            $atributos ['tipoEtiqueta'] = 'inicio';
            $atributos ["leyenda"] = "MODIFICAR  " . $_REQUEST ['mensaje_titulo'];
            echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);
            unset($atributos);
            {

                // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                $esteCampo = 'botonRegresar';
                $atributos ['id'] = $esteCampo;
                //$atributos ['enlace'] = $variable;
                $atributos ['tabIndex'] = 1;
                $atributos ['estilo'] = 'textoSubtitulo';
                $atributos ['enlaceTexto'] = $this->lenguaje->getCadena($esteCampo);
                $atributos ['ancho'] = '10%';
                $atributos ['alto'] = '10%';
                $atributos ['redirLugar'] = true;
                echo $this->miFormulario->enlace($atributos);
                unset($atributos);
                echo "<br>";
                // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                $esteCampo = 'tipo_orden';
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
                $atributos ['limitar'] = true;
                $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                $atributos ['anchoEtiqueta'] = 190;

                if (isset($_REQUEST [$esteCampo])) {
                    $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                } else {
                    $atributos ['seleccion'] = - 1;
                }

                $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_orden");
                $matrizItems = $DBContractual->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                $atributos ['matrizItems'] = $matrizItems;
                $tab ++;
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoCuadroLista($atributos);
                unset($atributos);


                // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------

                $miSesion = Sesion::singleton();
                $id_usuario = $miSesion->idUsuario();
                $cadenaSqlUnidad = $this->miSql->getCadenaSql("obtenerInfoUsuario", $id_usuario);
                $unidadEjecutora = $DBFrameWork->ejecutarAcceso($cadenaSqlUnidad, "busqueda");
                $esteCampo = 'unidad_ejecutora';
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
                $atributos ['validar'] = '';
                if (isset($unidadEjecutora)) {
                    $atributos ['valor'] = $unidadEjecutora[0]['nombre'];
                } else {
                    $atributos ['valor'] = 'Usuario sin Dependencia Registrada';
                }
                $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                $atributos ['deshabilitado'] = true;
                $atributos ['tamanno'] = 25;
                $atributos ['maximoTamanno'] = '';
                $atributos ['anchoEtiqueta'] = 220;
                $tab ++;
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoCuadroTexto($atributos);
                unset($atributos);





                $esteCampo = "AgrupacionSolicitante";
                $atributos ['id'] = $esteCampo;
                $atributos ['leyenda'] = "Información del Solicitante";
                echo $this->miFormulario->agrupacion('inicio', $atributos);
                {

                    if ($Orden ['unidad_ejecutora'] == 208) {
                        $esteCampo = 'sede_idexud';
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
                        $atributos ['validar'] = 'required';

                        if (isset($Orden['sede_solicitante'])) {
                            $atributos ['valor'] = $Orden['sede_solicitante'];
                        } else {
                            $atributos ['valor'] = "";
                        }
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = true;
                        $atributos ['tamanno'] = 28;
                        $atributos ['maximoTamanno'] = '';
                        $atributos ['anchoEtiqueta'] = 220;
                        $tab ++;

                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);

                        $esteCampo = 'vigencia_convenio';
                        $atributos ['columnas'] = 2;
                        $atributos ['nombre'] = $esteCampo;
                        $atributos ['id'] = $esteCampo;
                        $atributos ['evento'] = '';
                        $atributos ['deshabilitado'] = false;
                        $atributos ["etiquetaObligatorio"] = true;
                        $atributos ['tab'] = $tab;
                        $atributos ['tamanno'] = 1;
                        $atributos ['estilo'] = 'jqueryui';
                        $atributos ['validar'] = '';
                        $atributos ['limitar'] = true;
                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                        $atributos ['anchoEtiqueta'] = 170;

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }

                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("vigencia_convenios");
                        $matrizItems = $DBContractual->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                        $atributos ['matrizItems'] = $matrizItems;
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);

                        $esteCampo = "convenio_solicitante";
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
                        $atributos ['limitar'] = true;
                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                        $atributos ['anchoEtiqueta'] = 115;
                        if (isset($Orden['dependencia_solicitante'])) {
                            $atributos ['seleccion'] = $Orden['dependencia_solicitante'];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("convenios");
                        $matrizItems = $DBContractual->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                        $atributos ['matrizItems'] = $matrizItems;
                        $atributos ['validar'] = 'required';
                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        // $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
                        // $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);

                        $sqlNombreConvenio = $this->miSql->getCadenaSql("buscar_nombre_convenio", $Orden['dependencia_solicitante']);
                        $nombreConvenio = $DBContractual->ejecutarAcceso($sqlNombreConvenio, "busqueda");
                        $esteCampo = 'nombre_convenio_solicitante';
                        $atributos ['id'] = $esteCampo;
                        $atributos ['nombre'] = $esteCampo;
                        $atributos ['tipo'] = 'text';
                        $atributos ['estilo'] = 'jqueryui';
                        $atributos ['marco'] = true;
                        $atributos ['estiloMarco'] = '';
                        $atributos ["etiquetaObligatorio"] = true;
                        $atributos ['columnas'] = 160;
                        $atributos ['filas'] = 2;
                        $atributos ['dobleLinea'] = 0;
                        $atributos ['tabIndex'] = $tab;
                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                        $atributos ['validar'] = 'minSize[1]';
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = true;
                        $atributos ['tamanno'] = 20;
                        $atributos ['maximoTamanno'] = '';
                        $atributos ['anchoEtiqueta'] = 220;
                        $atributos ['valor'] = $nombreConvenio[0][0];

                        $tab ++;

                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoTextArea($atributos);
                        unset($atributos);
                    } else {

                        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                        $esteCampo = 'sede';
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
                        $atributos ['limitar'] = true;
                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                        $atributos ['anchoEtiqueta'] = 170;

                        if (isset($Orden['sede_solicitante'])) {
                            $atributos ['seleccion'] = $Orden['sede_solicitante'];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }

                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("sede");
                        $matrizItems = $DBContractual->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                        $atributos ['matrizItems'] = $matrizItems;


                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        // $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
                        // $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);

                        $esteCampo = "dependencia_solicitante";
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
                        $atributos ['limitar'] = true;
                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                        $atributos ['anchoEtiqueta'] = 115;
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("dependenciasConsultadas", $Orden['sede_solicitante']);
                        $matrizItems = $DBContractual->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                        $atributos ['matrizItems'] = $matrizItems;
                        if (isset($Orden['dependencia_solicitante'])) {
                            $atributos ['seleccion'] = $Orden['dependencia_solicitante'];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }



                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        // $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
                        // $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);
                    }
                }
                echo $this->miFormulario->agrupacion('fin');

                $esteCampo = "AgrupacionSupervisor";
                $atributos ['id'] = $esteCampo;
                $atributos ['leyenda'] = "Datos del Supervisor";
                echo $this->miFormulario->agrupacion('inicio', $atributos);
                {

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'sede_super';
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
                    $atributos ['limitar'] = true;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['anchoEtiqueta'] = 170;

                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['seleccion'] = - 1;
                    }

                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("sede");
                    $matrizItems = $DBContractual->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                    $atributos ['matrizItems'] = $matrizItems;

                    // Utilizar lo siguiente cuando no se pase un arreglo:
                    // $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
                    // $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
                    $tab ++;
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);

                    $esteCampo = 'dependencia_supervisor';
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
                    $atributos ['limitar'] = true;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['anchoEtiqueta'] = 115;
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['seleccion'] = - 1;
                    }
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("dependenciasConsultadas", $_REQUEST['sede_super']);
                    $matrizItems = $DBContractual->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");

                    $atributos ['matrizItems'] = $matrizItems;

                    // Utilizar lo siguiente cuando no se pase un arreglo:
                    // $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
                    // $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
                    $tab ++;
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'nombre_supervisor';
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['id'] = $esteCampo;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['tab'] = $tab ++;
                    $atributos ['anchoEtiqueta'] = 170;
                    $atributos ['evento'] = '';
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['seleccion'] = - 1;
                    }
                    $atributos ['deshabilitado'] = false;
                    $atributos ['columnas'] = 3;
                    $atributos ['tamanno'] = 1;
                    $atributos ['ajax_function'] = "";
                    $atributos ['ajax_control'] = $esteCampo;
                    $atributos ['estilo'] = "jqueryui";
                    $atributos ['validar'] = "required";
                    $atributos ['limitar'] = true;
                    $atributos ['anchoCaja'] = 52;
                    $atributos ['miEvento'] = '';
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("funcionarios");

                    $matrizItems = array(
                        array(
                            0,
                            ' '
                        )
                    );
                    $matrizItems = $DBContractual->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");

                    $atributos ['matrizItems'] = $matrizItems;
                    // $atributos['miniRegistro']=;
                    $atributos ['baseDatos'] = "contractual";
                    // $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "clase_entrada" );
                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);
                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------

                    $esteCampo = 'cargo_supervisor';
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
                    $atributos ['validar'] = 'required, minSize[1]';

                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 33;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 115;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    // ---------------- CONTROL: Cuadro Lista --------------------------------------------------------
                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'cargosExistentes';
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['id'] = $esteCampo;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ["etiquetaObligatorio"] = false;
                    $atributos ['tab'] = $tab ++;
                    $atributos ['anchoEtiqueta'] = 170;
                    $atributos ['evento'] = '';
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['seleccion'] = - 1;
                    }
                    $atributos ['deshabilitado'] = false;
                    $atributos ['columnas'] = 3;
                    $atributos ['tamanno'] = 1;
                    $atributos ['estilo'] = "jqueryui";
                    $atributos ['validar'] = "";
                    $atributos ['limitar'] = true;
                    $atributos ['anchoCaja'] = 52;
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("cargos_existentes");

                    $matrizItems = array(
                        array(
                            0,
                            ' '
                        )
                    );
                    $matrizItems = $DBContractual->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");

                    for ($i = 0; $i < count($matrizItems); $i++) {
                        $opciones[$i] = array($matrizItems[$i][0], $matrizItems[$i][0]);
                    }
                    $atributos ['matrizItems'] = $opciones;


                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);
                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    // -----------------CONTROL: Botón ----------------------------------------------------------------
                    echo "<center>";
                    $esteCampo = 'botonCargo';
                    $atributos ["id"] = $esteCampo;
                    $atributos ["tabIndex"] = $tab;
                    $atributos ["tipo"] = 'boton';
                    // submit: no se coloca si se desea un tipo button genérico
                    $atributos ['onClick'] = 'registrarNuevoCargo()';
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

                    $esteCampo = 'restablecerCargo';
                    $atributos ["id"] = $esteCampo;
                    $atributos ["tabIndex"] = $tab;
                    $atributos ["tipo"] = 'boton';
                    // submit: no se coloca si se desea un tipo button genérico
                    $atributos ['onClick'] = 'restCargoSuper()';
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
                    echo "</center>";
                }
                echo $this->miFormulario->agrupacion('fin');

//-------------- Se accede al Servicio de Agora para Consultar el Proveedor de la Orden de Compra -------------------------------------------------------------------

                $parametro = $_REQUEST ['proveedor'];
                $enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
                $url = "http://10.20.0.38/agora/index.php?data=";
                $data = "pagina=servicio&servicios=true&servicio=servicioArgoProveedor&Parametro1=$parametro";
                $url_servicio = $url . $this->miConfigurador->fabricaConexiones->crypto->codificar($data, $enlace);
                $cliente = curl_init();
                curl_setopt($cliente, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($cliente, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($cliente, CURLOPT_URL, $url_servicio);
                $repuestaWeb = curl_exec($cliente);
                curl_close($cliente);
                $repuestaWeb = explode("<json>", $repuestaWeb);
                $proveedor = json_decode($repuestaWeb[1]);
                $proveedor = (array) $proveedor;
                $proveedor = (array) $proveedor['datos'];

//----------------------------------------------------------------------------------------------------------------------------------------------------------------               

                $esteCampo = "AgrupacionContratista";
                $atributos ['id'] = $esteCampo;
                $atributos ['leyenda'] = "Información del Proveedor";
                echo $this->miFormulario->agrupacion('inicio', $atributos);
                {

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
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = ' ';
                    $atributos ['textoFondo'] = 'Ingrese el documento y de clic en el boton que aparece a continuación.';
                    $atributos ['valor'] = '';
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = false;
                    $atributos ['tamanno'] = 60;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 220;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
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

                    $esteCampo = 'cargo_inicial';
                    $atributos ["id"] = $esteCampo; // No cambiar este nombre
                    $atributos ["tipo"] = "hidden";
                    $atributos ['estilo'] = '';
                    $atributos ["obligatorio"] = false;
                    $atributos ['marco'] = true;
                    $atributos ["etiqueta"] = "";
                    $atributos ['valor'] = $_REQUEST ['cargo_supervisor'];
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);



                    $esteCampo = 'identificador_unidad';
                    $atributos ["id"] = $esteCampo; // No cambiar este nombre
                    $atributos ["tipo"] = "hidden";
                    $atributos ['estilo'] = '';
                    $atributos ["obligatorio"] = false;
                    $atributos ['marco'] = true;
                    $atributos ["etiqueta"] = "";
                    $atributos ['valor'] = $unidadEjecutora[0]['unidad_ejecutora'];
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    $esteCampo = 'id_proveedor';
                    $atributos ["id"] = $esteCampo; // No cambiar este nombre
                    $atributos ["tipo"] = "hidden";
                    $atributos ['estilo'] = '';
                    $atributos ["obligatorio"] = false;
                    $atributos ['marco'] = true;
                    $atributos ["etiqueta"] = "";
                    $atributos ['valor'] = '';
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'nombre_razon_proveedor';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'text';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = '';
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['columnas'] = 5;
                    $atributos ['dobleLinea'] = 0;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = 'required';

                    if (isset($proveedor['nomempresa'])) {
                        $atributos ['valor'] = $proveedor['nomempresa'];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 25;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 150;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'identifcacion_proveedor';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'text';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = '';
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['columnas'] = 5;
                    $atributos ['dobleLinea'] = 0;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = 'required,custom[onlyNumberSp]';

                    if (isset($proveedor['nit'])) {
                        $atributos ['valor'] = $proveedor['nit'];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 20;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 80;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    //-----Campo digito de verificacion
                    $esteCampo = 'digito_verificacion';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'text';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = '';
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['columnas'] = 5;
                    $atributos ['dobleLinea'] = 0;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = 'required, maxSize[15],minSize[1],custom[onlyNumberSp]';

                    if (isset($proveedor['digitoverificacion'])) {
                        $atributos ['valor'] = $proveedor['digitoverificacion'];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 5;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 180;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    //-----Campo digito de tipo persona


                    $esteCampo = 'tipo_persona';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'text';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = '';
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['columnas'] = 5;
                    $atributos ['dobleLinea'] = 0;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = 'required, maxSize[15],minSize[1]';

                    if (isset($proveedor['tipopersona'])) {
                        $atributos ['valor'] = $proveedor['tipopersona'];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 5;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 150;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);



                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'direccion_proveedor';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'text';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = '';
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['columnas'] = 5;
                    $atributos ['dobleLinea'] = 0;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = 'required';

                    if (isset($proveedor['direccion'])) {
                        $atributos ['valor'] = $proveedor['direccion'];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 25;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 130;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'telefono_proveedor';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'text';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = '';
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['columnas'] = 4;
                    $atributos ['dobleLinea'] = 0;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = 'required';

                    if (isset($proveedor['telefono'])) {
                        $atributos ['valor'] = $proveedor['telefono'];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 20;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 130;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'sitio_web';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'text';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = '';
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['columnas'] = 4;
                    $atributos ['dobleLinea'] = 0;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = 'required';

                    if (isset($proveedor['web'])) {
                        $atributos ['valor'] = $proveedor['web'];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 20;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 130;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);


                    $esteCampo = 'pais';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'text';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = '';
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['columnas'] = 4;
                    $atributos ['dobleLinea'] = 0;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = 'required';

                    if ($proveedor['pais'] == null) {
                        $atributos ['valor'] = "Colombia";
                    } else {
                        $atributos ['valor'] = $proveedor['pais'];
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 20;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 180;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    $esteCampo = 'ubicacion_proveedor';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'text';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = '';
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['columnas'] = 4;
                    $atributos ['dobleLinea'] = 0;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = 'required';

                    if (isset($proveedor['municipio'])) {
                        $atributos ['valor'] = $proveedor['municipio'];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 20;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 130;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    $esteCampo = 'nombre_acesor';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'text';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = '';
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['columnas'] = 4;
                    $atributos ['dobleLinea'] = 0;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = 'required, minSize[1]';

                    if (isset($proveedor['nomasesor'])) {
                        $atributos ['valor'] = $proveedor['nomasesor'];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 20;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 190;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'nombre_contratista';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'text';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = '';
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['columnas'] = 4;
                    $atributos ['dobleLinea'] = 0;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = 'required, minSize[1]';

                    if (isset($proveedor['primernombre'])) {
                        $nombreContratista = $proveedor['primernombre'] . " " . $proveedor['segundonombre'];
                        $apellidosConstratista = $proveedor['primerapellido'] . " " . $proveedor['segundoapellido'];
                        $atributos ['valor'] = $nombreContratista . " " . $apellidosConstratista;
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 20;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 190;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    //-----Campo  tipo dcoumento Representante persona

                    $esteCampo = 'tipo_documento';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'text';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = '';
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['columnas'] = 5;
                    $atributos ['dobleLinea'] = 0;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = 'required, maxSize[30],minSize[1]';

                    if ($proveedor['tipodocumento']) {
                        $atributos ['valor'] = $proveedor['tipodocumento'];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 16;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 150;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'identifcacion_contratista';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'text';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = '';
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['columnas'] = 4;
                    $atributos ['dobleLinea'] = 0;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = 'required,maxSize[10],custom[onlyNumberSp]';

                    if ($proveedor['numdocumento'] == null) {
                        $atributos ['valor'] = $proveedor['cedula_extranjeria'];
                    } else {
                        $atributos ['valor'] = $proveedor['numdocumento'];
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 20;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 150;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'procedencia';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'text';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = '';
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['columnas'] = 4;
                    $atributos ['dobleLinea'] = 0;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = 'required, minSize[1]';

                    if ($proveedor['tipo_doc_extranjero'] != null) {
                        $atributos ['valor'] = $proveedor['tipo_procedencia'] . " (" . $proveedor['tipo_doc_extranjero'] . ")";
                    } else {
                        $atributos ['valor'] = $proveedor['tipo_procedencia'];
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 28;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 130;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'cargo_contratista';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'text';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = '';
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['columnas'] = 4;
                    $atributos ['dobleLinea'] = 0;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = 'required, minSize[1]';

                    if (isset($proveedor['cargo'])) {
                        $atributos ['valor'] = "Cargo";
                    } else {
                        $atributos ['valor'] = "Cargo";
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = false;
                    $atributos ['tamanno'] = 28;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 130;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    $esteCampo = 'correo_proveedor';
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
                    $atributos ['validar'] = 'required, maxSize[70],minSize[5],custom[email]';

                    if (isset($proveedor['correo'])) {
                        $atributos ['valor'] = $proveedor['correo'];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = true;
                    $atributos ['tamanno'] = 28;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 150;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    //-----Hidden registro mercantil
                    $esteCampo = 'registro_mercantil';
                    $atributos ["id"] = $esteCampo; // No cambiar este nombre
                    $atributos ["tipo"] = "hidden";
                    $atributos ['estilo'] = '';
                    $atributos ["obligatorio"] = false;
                    $atributos ['marco'] = true;
                    $atributos ["etiqueta"] = "";
                    $atributos ['valor'] = '';
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);
                }
                echo $this->miFormulario->agrupacion('fin');

                $esteCampo = "AgrupacionObjetoContrato";
                $atributos ['id'] = $esteCampo;
                $atributos ['leyenda'] = "Información del Contrato";
                echo $this->miFormulario->agrupacion('inicio', $atributos);
                {

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'objeto_contrato';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'text';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = '';
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['columnas'] = 100;
                    $atributos ['filas'] = 15;
                    $atributos ['dobleLinea'] = 0;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = 'required, minSize[1]';
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = false;
                    $atributos ['tamanno'] = 20;
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

                    $sqlPolizasactivas = $this->miSql->getCadenaSql('obtenerPolizarOrden', $Orden['id_orden']);
                    $polizasActivas = $DBContractual->ejecutarAcceso($sqlPolizasactivas, "busqueda");
                     echo "<div id='myModal' class='modal'>
                            <div class='modal-content'>";

                    $esteCampo = "AgrupacionPoliza";
                    $atributos ['id'] = $esteCampo;
                    $atributos ["estilo"] = "jqueryui";
                    $atributos ['tipoEtiqueta'] = 'inicio';
                    $atributos ['leyenda'] = "Gestion de Pólizas";
                    echo $this->miFormulario->agrupacion('inicio', $atributos);
                    $cadenaSql = $this->miSql->getCadenaSql('polizas');
                    $resultado_polizas = $DBContractual->ejecutarAcceso($cadenaSql, "busqueda");
                    {
                        for ($i = 0; $i < count($resultado_polizas); $i ++) {

                            $esteCampo = "AgrupacionPoliza$i";
                            $atributos ['id'] = $esteCampo;
                            $atributos ['leyenda'] = "";
                            $atributos ["estilo"] = "jqueryui";
                            echo $this->miFormulario->agrupacion('inicio', $atributos);
                            // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                            $nombre = 'poliza' . $i;
                            $atributos ['id'] = $nombre;
                            $atributos ['nombre'] = $nombre;
                            $atributos ['estilo'] = 'campoCuadroSeleccionCorta';
                            $atributos ['marco'] = true;
                            $atributos ['estiloMarco'] = false;
                            $atributos ["etiquetaObligatorio"] = true;
                            $atributos ['columnas'] = 2;
                            $atributos ['dobleLinea'] = 1;
                            $atributos ['tabIndex'] = $tab;
                            $atributos ['etiqueta'] = $resultado_polizas [$i]['descripcion_poliza'];
                            $atributos ['validar'] = '';

                            for ($j = 0; $j < count($polizasActivas); $j++) {
                                if ($i + 1 == $polizasActivas[$j]['poliza']) {
                                    $atributos ['valor'] = 'TRUE';
                                    $atributos ['seleccionado'] = 'checked';
                                } else {
                                    $atributos ['valor'] = 'TRUE';
                                }
                            }
                            $atributos ['deshabilitado'] = false;
                            $tab ++;

                            // Aplica atributos globales al control
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroSeleccion($atributos);
                            unset($atributos);
                            
                            $estilo = "display:none";
                            for ($j = 0; $j < count($polizasActivas); $j++) {
                                if ($i + 1 == $polizasActivas[$j]['poliza']) {
                                    $estilo = "";
                                }
                              
                            }

                            $atributos ["id"] = "divisionPoliza$i";
                            $atributos ["estiloEnLinea"] = $estilo;
                            echo $this->miFormulario->division("inicio", $atributos);
                            unset($atributos);

                            // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                            $esteCampo = 'fecha_inicio_poliza' . $i;
                            $atributos ['id'] = $esteCampo;
                            $atributos ['nombre'] = $esteCampo;
                            $atributos ['tipo'] = 'fecha';
                            $atributos ['estilo'] = 'jqueryui';
                            $atributos ['marco'] = true;
                            $atributos ['estiloMarco'] = '';
                            $atributos ["etiquetaObligatorio"] = false;
                            $atributos ['columnas'] = 2;
                            $atributos ['dobleLinea'] = 0;
                            $atributos ['tabIndex'] = $tab;
                            $atributos ['etiqueta'] = "Fecha Inicio Poliza";
                            $atributos ['validar'] = '';

                            for ($j = 0; $j < count($polizasActivas); $j++) {
                                if ($i + 1 == $polizasActivas[$j]['poliza']) {
                                    $atributos ['valor'] = $polizasActivas[$j]['fecha_inicio'];
                                }
                            }
                            $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                            $atributos ['deshabilitado'] = false;
                            $atributos ['tamanno'] = 8;
                            $atributos ['maximoTamanno'] = '';
                            $atributos ['anchoEtiqueta'] = 147;
                            $tab ++;

                            // Aplica atributos globales al control
                            $atributos = array_merge($atributos, $atributosGlobales);

                            echo $this->miFormulario->campoCuadroTexto($atributos);
                            unset($atributos);

                            // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                            $esteCampo = 'fecha_final_poliza' . $i;
                            $atributos ['id'] = $esteCampo;
                            $atributos ['nombre'] = $esteCampo;
                            $atributos ['tipo'] = 'fecha';
                            $atributos ['estilo'] = 'jqueryui';
                            $atributos ['marco'] = true;
                            $atributos ['estiloMarco'] = '';
                            $atributos ["etiquetaObligatorio"] = false;
                            $atributos ['columnas'] = 2;
                            $atributos ['dobleLinea'] = 0;
                            $atributos ['tabIndex'] = $tab;
                            $atributos ['etiqueta'] = "Fecha Final Poliza:";
                            $atributos ['validar'] = '';

                            for ($j = 0; $j < count($polizasActivas); $j++) {
                                if ($i + 1 == $polizasActivas[$j]['poliza']) {
                                    $atributos ['valor'] = $polizasActivas[$j]['fecha_final'];
                                }
                            }
                            $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                            $atributos ['deshabilitado'] = false;
                            $atributos ['tamanno'] = 8;
                            $atributos ['maximoTamanno'] = '';
                            $atributos ['anchoEtiqueta'] = 147;
                            $tab ++;

                            // Aplica atributos globales al control
                            $atributos = array_merge($atributos, $atributosGlobales);

                            echo $this->miFormulario->campoCuadroTexto($atributos);
                            unset($atributos);

                            // ------------------Fin Division para las polizas-------------------------
                            echo $this->miFormulario->division("fin");
                            unset($atributos);
                            echo $this->miFormulario->agrupacion('fin');
                        }
                        $atributos ["id"] = "divisiobotonPolizas";
                        $atributos ["estilo"] = "marcoBotones";
                        echo $this->miFormulario->division("inicio", $atributos);
                        echo "<center><span class='close'>CONFIRMAR</span><center>";
                        echo $this->miFormulario->division('fin');
                    }
                    echo $this->miFormulario->agrupacion('fin');
                    echo " </div></div>";

                    $atributos ["id"] = "botones";
                    $atributos ["estilo"] = "marcoBotones";
                    echo $this->miFormulario->division("inicio", $atributos);
                    echo "<button id='myBtn' >Gestionar Polizas</button>";
                    echo $this->miFormulario->division('fin');
                }
                echo $this->miFormulario->agrupacion('fin');
                $esteCampo = "AgrupacionReferentePago";
                $atributos ['id'] = $esteCampo;
                $atributos ['leyenda'] = "Información Referente al Pago";
                echo $this->miFormulario->agrupacion('inicio', $atributos);
                {

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'fecha_inicio_pago';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'fecha';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = '';
                    $atributos ["etiquetaObligatorio"] = false;
                    $atributos ['columnas'] = 4;
                    $atributos ['dobleLinea'] = 0;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = 'custom[date]';

                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = false;
                    $atributos ['tamanno'] = 8;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 160;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);

                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'fecha_final_pago';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'fecha';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = '';
                    $atributos ["etiquetaObligatorio"] = false;
                    $atributos ['columnas'] = 4;
                    $atributos ['dobleLinea'] = 0;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = 'custom[date]';

                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = false;
                    $atributos ['tamanno'] = 8;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 160;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);

                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'unidad_ejecucion';
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['id'] = $esteCampo;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ["etiquetaObligatorio"] = false;
                    $atributos ['tab'] = $tab ++;
                    $atributos ['anchoEtiqueta'] = 150;
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['evento'] = '';
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['seleccion'] = - 1;
                    }
                    $atributos ['deshabilitado'] = false;
                    $atributos ['columnas'] = 3;
                    $atributos ['tamanno'] = 1;
                    $atributos ['estilo'] = "jqueryui";
                    $atributos ['validar'] = 'required';
                    $atributos ['limitar'] = true;
                    $atributos ['anchoCaja'] = 40;
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_unidad_ejecucion");
                    $matrizItems = array(
                        array(
                            0,
                            ' '
                        )
                    );
                    $matrizItems = $DBContractual->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                    $atributos ['matrizItems'] = $matrizItems;
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'plazo_ejecucion';
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
                    $atributos ['validar'] = 'required, minSize[1],maxSize[10],custom[onlyNumberSp]';

                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = false;
                    $atributos ['tamanno'] = 11;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 160;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);


                    // ---------------- CONTROL: Select Forma de Pago --------------------------------------------------------
                    $esteCampo = 'formaPago';
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['id'] = $esteCampo;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ["etiquetaObligatorio"] = false;
                    $atributos ['tab'] = $tab ++;
                    $atributos ['anchoEtiqueta'] = 170;
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['evento'] = '';
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['seleccion'] = - 1;
                    }
                    $atributos ['deshabilitado'] = false;
                    $atributos ['columnas'] = 3;
                    $atributos ['tamanno'] = 1;
                    $atributos ['estilo'] = "jqueryui";
                    $atributos ['validar'] = 'required';
                    $atributos ['limitar'] = true;
                    $atributos ['anchoCaja'] = 40;
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("forma_pago");
                    $matrizItems = array(
                        array(
                            0,
                            ' '
                        )
                    );
                    $matrizItems = $DBContractual->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                    $atributos ['matrizItems'] = $matrizItems;
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);
                    // ---------------- FIN CONTROL: Select Forma de Pago --------------------------------------------------------
                    //---------Campo de Seleccion Clausula Presupuestal-------------------------------

                    $esteCampo = 'clausula_presupuesto';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['estilo'] = 'campoCuadroSeleccionCorta';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = true;
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['columnas'] = 4;
                    $atributos ['dobleLinea'] = 1;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = '';

                    if (isset($_REQUEST [$esteCampo]) && $_REQUEST [$esteCampo] == 't') {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                        $atributos ['seleccionado'] = 'checked';
                    } else {
                        $atributos ['valor'] = 'TRUE';
                    }

                    $atributos ['deshabilitado'] = false;
                    $tab ++;
                    //Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroSeleccion($atributos);
                    unset($atributos);
                    //---------Fin Campo de Seleccion Clausula Presupuestal-------------------------------
                    // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------

                    $atributos ["id"] = "numero_dias"; // No cambiar este nombre
                    $atributos ["tipo"] = "hidden";
                    $atributos ['estilo'] = '';
                    $atributos ["obligatorio"] = false;
                    $atributos ['marco'] = true;
                    $atributos ["etiqueta"] = "";
                    $atributos ["valor"] = '';
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);




                    // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
                    // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
                }

                echo $this->miFormulario->agrupacion('fin');

                // $esteCampo = "Encargados";
                // $atributos ['id'] = $esteCampo;
                // $atributos ['leyenda'] = $this->lenguaje->getCadena ( $esteCampo );
                // echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
                // {

                $esteCampo = "ordenadorGasto";
                $atributos ['id'] = $esteCampo;
                $atributos ['leyenda'] = $this->lenguaje->getCadena($esteCampo);
                echo $this->miFormulario->agrupacion('inicio', $atributos);
                {

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'asignacionOrdenador';
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['id'] = $esteCampo;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ["etiquetaObligatorio"] = true;
                    $atributos ['tab'] = $tab ++;
                    $atributos ['anchoEtiqueta'] = 160;
                    $atributos ['evento'] = '';
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['seleccion'] = - 1;
                    }
                    $atributos ['deshabilitado'] = false;
                    $atributos ['columnas'] = 2;
                    $atributos ['tamanno'] = 1;
                    $atributos ['ajax_function'] = "";
                    $atributos ['ajax_control'] = $esteCampo;
                    $atributos ['estilo'] = "jqueryui";
                    $atributos ['validar'] = "required";
                    $atributos ['limitar'] = 1;
                    $atributos ['anchoCaja'] = 40;
                    $atributos ['miEvento'] = '';

                    if ($Orden ['unidad_ejecutora'] == 209) {
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("ordenadores_orden");
                    } else {
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("ordenadores_orden_idexud");
                    }
                    $matrizItems = array(
                        array(
                            0,
                            ' '
                        )
                    );
                    $matrizItems = $DBContractual->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                    $atributos ['matrizItems'] = $matrizItems;


                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------

                    $sqlNombreOrdenador = $this->miSql->getCadenaSql("informacion_ordenador", $_REQUEST['asignacionOrdenador']);
                    $nombreOrdenador = $DBContractual->ejecutarAcceso($sqlNombreOrdenador, "busqueda");


                    $esteCampo = 'nombreOrdenador';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['nombre'] = $esteCampo;
                    $atributos ['tipo'] = 'text';
                    $atributos ['estilo'] = 'jqueryui';
                    $atributos ['marco'] = true;
                    $atributos ['estiloMarco'] = '';
                    $atributos ["etiquetaObligatorio"] = false;
                    $atributos ['columnas'] = 2;
                    $atributos ['dobleLinea'] = 0;
                    $atributos ['tabIndex'] = $tab;
                    $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['validar'] = 'required, minSize[1],maxSize[2000]';

                    if ($nombreOrdenador != false) {
                        $atributos ['valor'] = $nombreOrdenador[0]['ORG_NOMBRE'];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    $atributos ['deshabilitado'] = false;
                    $atributos ['tamanno'] = 39;
                    $atributos ['maximoTamanno'] = '';
                    $atributos ['anchoEtiqueta'] = 95;
                    $tab ++;

                    // Aplica atributos globales al control
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    $esteCampo = 'id_ordenador';
                    $atributos ["id"] = $esteCampo; // No cambiar este nombre
                    $atributos ["tipo"] = "hidden";
                    $atributos ['estilo'] = '';
                    $atributos ["obligatorio"] = false;
                    $atributos ['marco'] = true;
                    $atributos ["etiqueta"] = "";

                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);

                    $esteCampo = 'tipo_ordenador';
                    $atributos ["id"] = $esteCampo; // No cambiar este nombre
                    $atributos ["tipo"] = "hidden";
                    $atributos ['estilo'] = '';
                    $atributos ["obligatorio"] = false;
                    $atributos ['marco'] = true;
                    $atributos ["etiqueta"] = "";

                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroTexto($atributos);
                    unset($atributos);
                }

                echo $this->miFormulario->agrupacion('fin');
                unset($atributos);

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
                $atributos ['submit'] = 'true';
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

                echo $this->miFormulario->division('fin');

                echo $this->miFormulario->marcoAgrupacion('fin');

                // ---------------- FIN SECCION: Controles del Formulario -------------------------------------------
                // ----------------FINALIZAR EL FORMULARIO ----------------------------------------------------------
                // Se debe declarar el mismo atributo de marco con que se inició el formulario.
            }

            // -----------------FIN CONTROL: Botón -----------------------------------------------------------
            // ------------------Fin Division para los botones-------------------------
            echo $this->miFormulario->division("fin");

            // ------------------- SECCION: Paso de variables ------------------------------------------------

            /**
             * En algunas ocasiones es útil pasar variables entre las diferentes páginas.
             * SARA permite realizar esto a través de tres
             * mecanismos:
             * (a). Registrando las variables como variables de sesión. Estarán dilesn de usuario. Requiere acceso a
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
            $valorCodificado .= "&opcion=modificarOrden";
            $valorCodificado .= "&id_orden=" . $_REQUEST ['id_orden'];
            $valorCodificado .= "&mensaje_titulo=" . $_REQUEST ['mensaje_titulo'];
            $valorCodificado .= "&numerocontrato=" . $_REQUEST ['numerocontrato'];
            $valorCodificado .= "&vigencia=" . $_REQUEST ['vigencia'];
            $valorCodificado .= "&arreglo=" . $_REQUEST ['arreglo'];
            $valorCodificado .= "&usuario=" . $_REQUEST ['usuario'];
            $valorCodificado .= "&seccion=" . $tiempo;

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

            return true;
        }
    }

}

$miSeleccionador = new registrarForm($this->lenguaje, $this->miFormulario, $this->sql);

$miSeleccionador->miForm();
?>
