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

        $conexion = "contractual";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);


        // -------------------------------------------------------------------------------------------------
        // Limpia Items Tabla temporal
        // $cadenaSql = $this->miSql->getCadenaSql ( 'limpiar_tabla_items' );
        // $resultado_secuancia = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "acceso" );
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
        $atributos ['marco'] = true;
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

            $datos = array(
                'id_orden' => $_REQUEST['id_orden'],
                'numero_contrato' => $_REQUEST['numero_contrato'],
                'vigencia' => $_REQUEST['vigencia'],
                'mensaje' => $_REQUEST['mensaje_titulo']
            );



            $cadenaSql = $this->miSql->getCadenaSql('consultarFechaparaSuscribir', $datos);

            $fecha_registro_sistema = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");


            $esteCampo = 'fecha_registro_validacion';
            $atributos ["id"] = $esteCampo; // No cambiar este nombre
            $atributos ["tipo"] = "hidden";
            $atributos ['estilo'] = '';
            $atributos ["obligatorio"] = false;
            $atributos ['marco'] = true;
            $atributos ["etiqueta"] = "";
            $atributos ['valor'] = $fecha_registro_sistema[0][0];
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroTexto($atributos);
            unset($atributos);

            $esteCampo = "marcoDatosBasicos";
            $atributos ['id'] = $esteCampo;
            $atributos ["estilo"] = "jqueryui";
            $atributos ['tipoEtiqueta'] = 'inicio';
            $atributos ["leyenda"] = $datos['mensaje'];
            echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);

            // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------


            $variable = "pagina=" . $miPaginaActual;
            $variable .= "&opcion=ConsultarOrden";
            $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);






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



            echo "<center><h3>Seleccione la Fecha de Suscripción:</h3>";

            $esteCampo = 'fecha_suscripcion';
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
            $atributos ['validar'] = 'required';
            $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
            $atributos ['deshabilitado'] = false;
            $atributos ['tamanno'] = 8;
            $atributos ['maximoTamanno'] = '';
            $atributos ['anchoEtiqueta'] = 200;
            $tab ++;

            // Aplica atributos globales al control
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroTexto($atributos);


            echo "</center><br><br><br>";

            $mensajeAlerta = "UNA VEZ REALIZADA ESTA ACTUALIZACION, BAJO NINGUNA CIRCUSTANCIA SE PODRA REVERSAR.";

            // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
            $esteCampo = 'mensajeAlerta';

            $atributos ['id'] = $esteCampo;
            $atributos ['tipo'] = 'error';
            $atributos ['estilo'] = 'textoCentrar';
            $atributos ['mensaje'] = $mensajeAlerta;

            $tab ++;

            // Aplica atributos globales al control
            $atributos = array_merge($atributos, $atributosGlobales);

            // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
            $mensaje = "<h2>SUSCRIPCIÓN DE CONTRATO</h2> <br> <h4>EL CONTRATO  DE ORDEN DE COMPRA <br> NUMERO: " . $datos['numero_contrato'] .
                    " CON VIGENCIA:  " . $datos['vigencia'] . " SE SUSCRIBIRA. </h4>. <br> <h4>" .
                    $this->miFormulario->cuadroMensaje($atributos) . "</h4>";

            // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
            $esteCampo = 'mensajeAprobacion';
            $atributos ['id'] = $esteCampo;
            $atributos ['tipo'] = 'information shadow';
            $atributos ['estilo'] = 'textoCentrar';
            $atributos ['mensaje'] = $mensaje;

            $tab ++;

            // Aplica atributos globales al control
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->cuadroMensaje($atributos);

            // ------------------Division para los botones-------------------------
            $atributos ["id"] = "botones";
            $atributos ["estilo"] = "marcoBotones";
            echo $this->miFormulario->division("inicio", $atributos);

            // -----------------CONTROL: Botón ----------------------------------------------------------------
            $esteCampo = 'botonAceptarSuscripcion';
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

            echo $this->miFormulario->marcoAgrupacion('fin');

            // ---------------- SECCION: División ----------------------------------------------------------
            $esteCampo = 'division1';
            $atributos ['id'] = $esteCampo;
            $atributos ['estilo'] = 'general';
            echo $this->miFormulario->division("inicio", $atributos);

            // ---------------- FIN SECCION: División ----------------------------------------------------------
            echo $this->miFormulario->division('fin');

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
        $valorCodificado .= "&opcion=aprobarContratoFuncion";
        $valorCodificado .= "&id_orden=" . $datos ['id_orden'];
        $valorCodificado .= "&numero_contrato=" . $datos ['numero_contrato'];
        $valorCodificado .= "&vigencia=" . $datos ['vigencia'];
        $valorCodificado .= "&usuario=" . $_REQUEST ['usuario'];

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
