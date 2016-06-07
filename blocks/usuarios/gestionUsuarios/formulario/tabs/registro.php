<?php

namespace usuarios\gestionUsuarios;

if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

class consultarForm {

    var $miConfigurador;
    var $lenguaje;
    var $miFormulario;
    var $miSql;
    var $miSesion;

    function __construct($lenguaje, $formulario, $sql) {
        $this->miConfigurador = \Configurador::singleton();

        $this->miConfigurador->fabricaConexiones->setRecursoDB('principal');

        $this->lenguaje = $lenguaje;

        $this->miFormulario = $formulario;

        $this->miSql = $sql;

        $this->miSesion = \Sesion::singleton();
    }

    function miForm() {

        // Rescatar los datos de este bloque
        $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

        $rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
        $rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
        $rutaBloque.= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];

        $directorio = $this->miConfigurador->getVariableConfiguracion("host");
        $directorio.= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
        $directorio.=$this->miConfigurador->getVariableConfiguracion("enlace");

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
        $conexion = "estructura";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
        
        $conexionArka = "contractual";
        $recursoArka =  $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionArka);
        

        $valorCodificado = "pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
        $valorCodificado .= "&opcion=nuevo";
        $valorCodificado .= "&usuario=" . $this->miSesion->getSesionUsuarioId();
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
        $variableNuevo = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($valorCodificado, $directorio);
        $miPaginaActual = $this->miConfigurador->getVariableConfiguracion('pagina');
        $variable = "pagina=" . $miPaginaActual;
        $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);

        //identifca lo roles para la busqueda de subsistemas
        $roles = $this->miSesion->RolesSesion();
        $aux = 0;
        $parametro = array();
        foreach ($roles as $key => $value) {
            if ($roles[$key]['cod_rol'] == 1 && $roles[$key]['cod_app'] > 1) {
                $app[$aux] = $roles[$key]['cod_app'];
                $rol[$aux] = $roles[$key]['cod_rol'];
                $aux++;
                $parametro['tipoAdm'] = 'subsistema';
            } elseif ($roles[$key]['cod_rol'] == 0 && $roles[$key]['cod_app'] == 1) {
                $app = '';
                $app[0] = $roles[$key]['cod_app'];
                $rol[0] = $roles[$key]['cod_rol'];
                $parametro['tipoAdm'] = 'general';
                break;
            }
        }



        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
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

        $atributos ['tipoEtiqueta'] = 'inicio';
        echo $this->miFormulario->formulario($atributos); {

            $esteCampo = "marcoDatosBasicos";
            $atributos ['id'] = $esteCampo;
            $atributos ["estilo"] = "jqueryui";
            $atributos ['tipoEtiqueta'] = 'inicio';
            $atributos ["leyenda"] = "<b>GESTIÓN DE USUARIOS</b>";
            echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);
            unset($atributos); {





                $esteCampo = 'identificacion';
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
                $atributos ['validar'] = "required, minSize[5], custom[integer]";
                //$atributos ['valor'] = $funcionario_informacion ['responsable_ante'];
                $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                //$atributos ['deshabilitado'] = true;
                $atributos ['tamanno'] = 60;
                $atributos ['maximoTamanno'] = '';
                $atributos ['anchoEtiqueta'] = 170;
                $tab ++;

                // Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoCuadroTexto($atributos);
                unset($atributos);
                // ---------------- FIN CONTROL: Cuadro de Texto --------------------------------------------------------
                // ---------------- CONTROL: Cuadro de Lista --------------------------------------------------------
                $esteCampo = 'tipo_identificacion';
                $atributos ['nombre'] = $esteCampo;
                $atributos ['id'] = $esteCampo;
                $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                $atributos ["etiquetaObligatorio"] = true;
                $atributos ['tab'] = $tab ++;
                $atributos ['seleccion'] = - 1;
                $atributos ['anchoEtiqueta'] = 170;
                $atributos ['evento'] = '';
                if (isset($_REQUEST [$esteCampo])) {
                    $atributos ['valor'] = $_REQUEST [$esteCampo];
                } else {
                    $atributos ['valor'] = '';
                }
                $atributos ['deshabilitado'] = false;
                $atributos ['columnas'] = 1;
                $atributos ['tamanno'] = 1;
                $atributos ['ajax_function'] = "";
                $atributos ['ajax_control'] = $esteCampo;
                $atributos ['estilo'] = "jqueryui";
                $atributos ['validar'] = "required";
                $atributos ['limitar'] = true;
                $atributos ['anchoCaja'] = 60;
                $atributos ['miEvento'] = '';
                $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipoIdentificacion");

                $matrizItems = array(array(0, ' '));
                $matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                $atributos ['matrizItems'] = $matrizItems;

                // $atributos['miniRegistro']=;
                // $atributos ['baseDatos'] = "inventarios";
                // $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "clase_entrada" );
                // Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoCuadroLista($atributos);
                unset($atributos);
                // ---------------- FIN CONTROL: Cuadro de Lista --------------------------------------------------------
                // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                $esteCampo = 'nombres';
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
                $atributos ['validar'] = "required, minSize[5]";
                $atributos ['valor'] = '';
                $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                $atributos ['deshabilitado'] = false;
                $atributos ['tamanno'] = 60;
                $atributos ['maximoTamanno'] = '';
                $atributos ['anchoEtiqueta'] = 170;
                $tab ++;
                // Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoCuadroTexto($atributos);
                unset($atributos);
                // ---------------- FIN CONTROL: Cuadro de Texto --------------------------------------------------------
                // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                $esteCampo = 'apellidos';
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
                $atributos ['validar'] = "required, minSize[5]";
                $atributos ['valor'] = '';
                $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                $atributos ['deshabilitado'] = false;
                $atributos ['tamanno'] = 60;
                $atributos ['maximoTamanno'] = '';
                $atributos ['anchoEtiqueta'] = 170;
                $tab ++;
                // Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoCuadroTexto($atributos);
                unset($atributos);
                // ---------------- FIN CONTROL: Cuadro de Texto --------------------------------------------------------
                //  // ---------------- CONTROL: Cuadro de Lista --------------------------------------------------------
                $esteCampo = 'dependencia';
                $atributos ['nombre'] = $esteCampo;
                $atributos ['id'] = $esteCampo;
                $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                $atributos ["etiquetaObligatorio"] = true;
                $atributos ['tab'] = $tab ++;
                $atributos ['seleccion'] = - 1;
                $atributos ['anchoEtiqueta'] = 170;
                $atributos ['evento'] = '';
                if (isset($_REQUEST [$esteCampo])) {
                    $atributos ['valor'] = $_REQUEST [$esteCampo];
                } else {
                    $atributos ['valor'] = '';
                }
                $atributos ['deshabilitado'] = false;
                $atributos ['columnas'] = 1;
                $atributos ['tamanno'] = 1;
                $atributos ['ajax_function'] = "";
                $atributos ['ajax_control'] = $esteCampo;
                $atributos ['estilo'] = "jqueryui";
                $atributos ['validar'] = "required";
                $atributos ['limitar'] = true;
                $atributos ['anchoCaja'] = 60;
                $atributos ['miEvento'] = '';
                $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("sede");
                $matrizItemsAdministrativo = $recursoArka->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                 for ($j = 0; $j < count($matrizItemsAdministrativo); $j++) {
                    $matrizItemsAdministrativo[$j]=array($matrizItemsAdministrativo[$j]["nombre"],$matrizItemsAdministrativo[$j]["nombre"]);
                }
                $matrizItemsIdexud = array(array('IDEXUD', 'IDEXUD'));
                $matrizItems = array_merge($matrizItemsIdexud,$matrizItemsAdministrativo);
                $atributos ['matrizItems'] = $matrizItems;
                

                // $atributos['miniRegistro']=;
                // $atributos ['baseDatos'] = "inventarios";
                // $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "clase_entrada" );
                // Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoCuadroLista($atributos);
                unset($atributos);
               
                // ---------------- FIN CONTROL: Cuadro de Lista --------------------------------------------------------
                // ---------------- CONTROL: Cuadro de Lista --------------------------------------------------------
                $esteCampo = 'dependencia_especifica';
                $atributos ['nombre'] = $esteCampo;
                $atributos ['id'] = $esteCampo;
                $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                $atributos ["etiquetaObligatorio"] = false;
                $atributos ['tab'] = $tab ++;
                $atributos ['seleccion'] = - 1;
                $atributos ['anchoEtiqueta'] = 180;
                $atributos ['evento'] = '';
                if (isset($_REQUEST [$esteCampo])) {
                    $atributos ['valor'] = $_REQUEST [$esteCampo];
                } else {
                    $atributos ['valor'] = '';
                }
                $atributos ['deshabilitado'] = true;
                $atributos ['columnas'] = 1;
                $atributos ['tamanno'] = 1;
                $atributos ['ajax_function'] = "";
                $atributos ['ajax_control'] = $esteCampo;
                $atributos ['estilo'] = "jqueryui";
                $atributos ['validar'] = "required";
                $atributos ['limitar'] = true;
                $atributos ['anchoCaja'] = 60;
                $atributos ['miEvento'] = '';
               // $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipoIdentificacion");

                $matrizItems = array(array(0,""));
                
                $atributos ['matrizItems'] = $matrizItems;

                // $atributos['miniRegistro']=;
                // $atributos ['baseDatos'] = "inventarios";
                // $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "clase_entrada" );
                // Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoCuadroLista($atributos);
                unset($atributos);
                // ---------------- FIN CONTROL: Cuadro de Lista --------------------------------------------------------
               
                // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                $esteCampo = 'correo';
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
                $atributos ['validar'] = "required, custom[email]";
                $atributos ['valor'] = '';
                $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                $atributos ['deshabilitado'] = false;
                $atributos ['tamanno'] = 60;
                $atributos ['maximoTamanno'] = '';
                $atributos ['anchoEtiqueta'] = 170;
                $tab ++;
                // Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoCuadroTexto($atributos);
                unset($atributos);

                // ---------------- FIN CONTROL: Cuadro de Texto --------------------------------------------------------
                // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                $esteCampo = 'telefono';
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
                $atributos ['validar'] = "required,minSize[7],custom[phone]";
                $atributos ['valor'] = '';
                $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                $atributos ['deshabilitado'] = false;
                $atributos ['tamanno'] = 60;
                $atributos ['maximoTamanno'] = '';
                $atributos ['anchoEtiqueta'] = 170;
                $tab ++;
                // Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoCuadroTexto($atributos);
                unset($atributos);
                // ---------------- FIN CONTROL: Cuadro de Texto --------------------------------------------------------
                // ---------------- CONTROL: Cuadro de Lista --------------------------------------------------------
                $esteCampo = 'subsistema';
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
                $atributos ['anchoEtiqueta'] = 150;
                $atributos ['anchoCaja'] = 60;
                if (isset($_REQUEST [$esteCampo])) {
                    $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                } else {
                    $atributos ['seleccion'] = - 1;
                }
                $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("subsistema", $app);
                $matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                $atributos ['matrizItems'] = $matrizItems;
                // Utilizar lo siguiente cuando no se pase un arreglo:
                // $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
                // $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
                $tab ++;
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoCuadroLista($atributos);
                unset($atributos);
                // ---------------- FIN CONTROL: Cuadro de Lista --------------------------------------------------------
                // ---------------- CONTROL: Cuadro de Lista --------------------------------------------------------
                $esteCampo = 'perfil';
                $atributos ['columnas'] = 2;
                $atributos ['nombre'] = $esteCampo;
                $atributos ['id'] = $esteCampo;
                $atributos ['evento'] = '';
                $atributos ['deshabilitado'] = true;
                $atributos ["etiquetaObligatorio"] = true;
                $atributos ['tab'] = $tab;
                $atributos ['tamanno'] = 1;
                $atributos ['estilo'] = 'jqueryui';
                $atributos ['validar'] = 'required';
                $atributos ['limitar'] = true;
                $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                $atributos ['anchoEtiqueta'] = 150;
                $atributos ['anchoCaja'] = 60;
                if (isset($_REQUEST [$esteCampo])) {
                    $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                } else {
                    $atributos ['seleccion'] = - 1;
                }
                $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("consultaPerfiles");
                $matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                $atributos ['matrizItems'] = $matrizItems;
                // Utilizar lo siguiente cuando no se pase un arreglo:
                // $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
                // $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
                $tab ++;
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoCuadroLista($atributos);
                unset($atributos);

                // ---------------- FIN CONTROL: Cuadro de Lista --------------------------------------------------------
                // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                $esteCampo = 'fechaFin';
                $atributos ['id'] = $esteCampo;
                $atributos ['nombre'] = $esteCampo;
                $atributos ['tipo'] = 'texto';
                $atributos ['estilo'] = 'jqueryui';
                $atributos ['marco'] = true;
                $atributos ['estiloMarco'] = '';
                $atributos ["etiquetaObligatorio"] = true;
                $atributos ['columnas'] = 1;
                $atributos ['dobleLinea'] = 0;
                $atributos ['tabIndex'] = $tab;
                $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                $atributos ['validar'] = "required";
                $atributos ['valor'] = '';
                $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                $atributos ['deshabilitado'] = true;
                $atributos ['tamanno'] = 60;
                $atributos ['maximoTamanno'] = '';
                $atributos ['anchoEtiqueta'] = 170;

                $tab ++;
                // Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoCuadroTexto($atributos);
                unset($atributos);
                // ---------------- FIN CONTROL: Cuadro de Texto --------------------------------------------------------


                /*
                  // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                  $esteCampo = 'observaciones';
                  $atributos ['id'] = $esteCampo;
                  $atributos ['nombre'] = $esteCampo;
                  $atributos ['tipo'] = 'text';
                  $atributos ['estilo'] = 'jqueryui';
                  $atributos ['marco'] = true;
                  $atributos ['estiloMarco'] = '';
                  $atributos ["etiquetaObligatorio"] = true;
                  $atributos ['columnas'] = 120;
                  $atributos ['filas'] = 5;
                  $atributos ['dobleLinea'] = 0;
                  $atributos ['tabIndex'] = $tab;
                  $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
                  $atributos ['validar'] = 'required, minSize[1]';
                  $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
                  $atributos ['deshabilitado'] = false;
                  $atributos ['tamanno'] = 20;
                  $atributos ['maximoTamanno'] = '';
                  $atributos ['anchoEtiqueta'] = 220;
                  if (isset ( $_REQUEST [$esteCampo] )) {
                  $atributos ['valor'] = $_REQUEST [$esteCampo];
                  } else {
                  $atributos ['valor'] = '';
                  }
                  $tab ++;

                  // Aplica atributos globales al control
                  $atributos = array_merge ( $atributos, $atributosGlobales );
                  echo $this->miFormulario->campoTextArea ( $atributos );
                  unset ( $atributos ); */

                // ------------------Division para los botones-------------------------
                $atributos ["id"] = "botones";
                $atributos ["estilo"] = "marcoBotones";
                echo $this->miFormulario->division("inicio", $atributos);
                unset($atributos); {
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

                    $esteCampo = 'botonRegresar';
                    $atributos ['id'] = $esteCampo;
                    $atributos ['enlace'] = $variable;
                    $atributos ['tabIndex'] = 1;
                    $atributos ['enlaceTexto'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos ['estilo'] = 'textoPequenno textoGris';
                    $atributos ['enlaceImagen'] = $rutaBloque . "/images/player_rew.png";
                    $atributos ['posicionImagen'] = "atras"; //"adelante";
                    $atributos ['ancho'] = '30px';
                    $atributos ['alto'] = '30px';
                    $atributos ['redirLugar'] = true;
                    echo $this->miFormulario->enlace($atributos);
                    unset($atributos);
                    // -----------------FIN CONTROL: Botón -----------------------------------------------------------
                }
                echo $this->miFormulario->division('fin');



                // ---------------- FIN SECCION: Controles del Formulario -------------------------------------------
                // ----------------FINALIZAR EL FORMULARIO ----------------------------------------------------------


                echo $this->miFormulario->marcoAgrupacion('fin');

                // ---------------- FIN SECCION: Controles del Formulario -------------------------------------------
                // ----------------FINALIZAR EL FORMULARIO ----------------------------------------------------------
                // Se debe declarar el mismo atributo de marco con que se inició el formulario.
            }

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

            $valorCodificado = "action=" . $esteBloque ["nombre"];
            $valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
            $valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
            $valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
            $valorCodificado .= "&opcion=guardarDatos";

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
            // ------------------Fin Division para los botones-------------------------
            echo $this->miFormulario->division("fin");


            $atributos ['marco'] = false;
            $atributos ['tipoEtiqueta'] = 'fin';
            echo $this->miFormulario->formulario($atributos);

            return true;
        }
    }

}

$miSeleccionador = new consultarForm($this->lenguaje, $this->miFormulario, $this->sql);

$miSeleccionador->miForm();
?>
