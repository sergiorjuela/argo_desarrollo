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

        $rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
        $rutaBloque .= $this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
        $rutaBloque .= $esteBloque ['grupo'] . "/" . $esteBloque ['nombre'];

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
        $conexionFrameWork = "estructura";
        $DBFrameWork = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionFrameWork);
        $conexionSICA = "sicapital";
        $DBSICA = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionSICA);



        if (isset($_REQUEST ['vigencia_solicitud_consulta']) && $_REQUEST ['vigencia_solicitud_consulta'] != '') {
            $vigencia_solicitud = $_REQUEST ['vigencia_solicitud_consulta'];
        } else {
            $vigencia_solicitud = '';
        }

        if (isset($_REQUEST ['numero_solicitud']) && $_REQUEST ['numero_solicitud'] != '') {
            $numero_solicitud = $_REQUEST ['numero_solicitud'];
        } else {
            $numero_solicitud = '';
        }
        if (isset($_REQUEST ['numero_cdp']) && $_REQUEST ['numero_cdp'] != '') {
            $numero_cdp = $_REQUEST ['numero_cdp'];
        } else {
            $numero_cdp = '';
        }

        if (isset($_REQUEST ['dependencia_solicitud']) && $_REQUEST ['dependencia_solicitud'] != '') {
            $dependencia_solicitante = $_REQUEST ['dependencia_solicitud'];
        } else {
            $dependencia_solicitante = '';
        }

        if (isset($_REQUEST ['fecha_inicial']) && $_REQUEST ['fecha_inicial'] != '') {
            $fecha_inicial = $_REQUEST ['fecha_inicial'];
        } else {
            $fecha_inicial = '';
        }

        if (isset($_REQUEST ['fecha_final']) && $_REQUEST ['fecha_final'] != '') {
            $fecha_final = $_REQUEST ['fecha_final'];
        } else {
            $fecha_final = '';
        }


    
        $miSesion = Sesion::singleton();
        $id_usuario = $miSesion->idUsuario();
        $cadenaSqlUnidad = $this->miSql->getCadenaSql("obtenerUnidadUsuario", $id_usuario);
        $unidadEjecutora = $DBFrameWork->ejecutarAcceso($cadenaSqlUnidad, "busqueda");

      
        $arreglo_consulta = array(
            'vigencia_solicitud_consulta' => $vigencia_solicitud,
            'numero_solicitud' => $numero_solicitud,
            'dependencia_solicitud' => $dependencia_solicitante,
            'fecha_inicial' => $fecha_inicial,
            'fecha_final' => $fecha_final,
            'numero_cdp' => $numero_cdp,
            'unidad_ejecutora' => $unidadEjecutora[0]['unidad_ejecutora']
        );
      
        
     
        
        $cadenaSql = $this->miSql->getCadenaSql('obtenerSolicitudesCdp', $arreglo_consulta);
        
        $solicitudesCDPs = $DBSICA->ejecutarAcceso($cadenaSql, "busqueda");
        
       
        $arreglo_consulta = base64_encode(serialize($arreglo_consulta));
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
        unset($atributos);
        $miPaginaActual = $this->miConfigurador->getVariableConfiguracion('pagina');

        $directorio = $this->miConfigurador->getVariableConfiguracion("host");
        $directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
        $directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");

        $variable = "pagina=" . $miPaginaActual;
        $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);

        // ---------------- SECCION: Controles del Formulario -----------------------------------------------

        $esteCampo = "marcoDatosBasicos";
        $atributos ['id'] = $esteCampo;
        $atributos ["estilo"] = "jqueryui";
        $atributos ['tipoEtiqueta'] = 'inicio';
        $atributos ["leyenda"] = "Consulta de Solicitudes y CDPS";
        echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);
        unset($atributos);
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
        if ($solicitudesCDPs) {

            echo "<table id='tablaCDPs'>";
            echo "<thead>
                             <tr>
                                <th>Num. de Sol. de Necesidad</th>
                                <th>Vigencia</th>
                                <th>Dependencia Solicitante</th>
                    		<th>Estado Solicitud</th>            
            			<th>Numero de Disponibilidad (CDP)</th>
                                <th>Valor Contratacion</th>
                                <th>Estado CDP</th>
                                <th>Fecha de Registro del CDP</th>
                        	<th>Registrar Orden</th>
                             </tr>
                          </thead>
                          <tbody>";

            for ($i = 0; $i < count($solicitudesCDPs); $i ++) {
                $variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                $variable .= "&opcion=registroOrden";
                $variable .= "&numeroSolicitud=" . $solicitudesCDPs [$i] ['NUM_SOL_ADQ'];
                $variable .= "&numeroCdp=" . $solicitudesCDPs [$i] ['NUMERO_DISPONIBILIDAD'];
                $variable .= "&vigencia=" . $solicitudesCDPs [$i] ['VIGENCIA'];
                $variable .= "&objetoCDP=" . $solicitudesCDPs [$i] ['OBJETO'];
                $variable .= "&arreglo=" . $arreglo_consulta;
                $variable .= "&usuario=" . $_REQUEST ['usuario'];
                $variable .= "&mensaje_titulo= Numero Solicitud: ".$solicitudesCDPs [$i] ['NUM_SOL_ADQ']." | Numero CDP: ".$solicitudesCDPs [$i] ['NUMERO_DISPONIBILIDAD']." | VIGENCIA: " . $solicitudesCDPs [$i] ['VIGENCIA'];
                $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);

                $mostrarHtml = "<tr>
                                <td><center>" . $solicitudesCDPs [$i] ['NUM_SOL_ADQ'] . "</center></td>
                                <td><center>" . $solicitudesCDPs [$i] ['VIGENCIA'] . "</center></td>		
                                <td><center>" . $solicitudesCDPs [$i] ['NOMBRE_DEPENDENCIA'] . "</center></td>		
                                <td><center>" . $solicitudesCDPs [$i] ['ESTADO'] . "</center></td>
                                <td><center>" . $solicitudesCDPs [$i] ['NUMERO_DISPONIBILIDAD'] . "</center></td>
                                <td><center>" .  number_format($solicitudesCDPs [$i] ['VALOR_CONTRATACION'], 2, ",", ".") . "</center></td>
                                <td><center>" . $solicitudesCDPs [$i] ['ESTADOCDP'] . "</center></td>
                                <td><center>" . $solicitudesCDPs [$i] ['FECHA_REGISTRO'] . "</center></td>
                                <td><center>
                                    <a href='".$variable."'>
                                        <img src='" . $rutaBloque . "/css/images/contrato.png' width='20px'>
                                    </a>
                                </center> </td>
                	      		 
                                </tr>";
                echo $mostrarHtml;
                unset($mostrarHtml);
                unset($variable);
            }

            echo "</tbody>";

            echo "</table>";

            // Fin de Conjunto de Controles
            // echo $this->miFormulario->marcoAgrupacion("fin");
        } else {

            $mensaje = "No Se Encontraron<br>Solicitude con CDP aprobado.";

            // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
            $esteCampo = 'mensajeRegistro';
            $atributos ['id'] = $esteCampo;
            $atributos ['tipo'] = 'error';
            $atributos ['estilo'] = 'textoCentrar';
            $atributos ['mensaje'] = $mensaje;

            $tab ++;

            // Aplica atributos globales al control
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->cuadroMensaje($atributos);
            // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        }

        echo $this->miFormulario->marcoAgrupacion('fin');

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

        $valorCodificado = "actionBloque=" . $esteBloque ["nombre"];
        $valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
        $valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
        $valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
        $valorCodificado .= "&opcion=regresar";
        $valorCodificado .= "&redireccionar=regresar";
        /**
         * SARA permite que los nombres de los campos sean dinámicos.
         * Para ello utiliza la hora en que es creado el formulario para
         * codificar el nombre de cada campo. Si se utiliza esta técnica es necesario pasar dicho tiempo como una variable:
         * (a) invocando a la variable $_REQUEST ['tiempo'] que se ha declarado en ready.php o
         * (b) asociando el tiempo en que se está creando el formulario
         */
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
