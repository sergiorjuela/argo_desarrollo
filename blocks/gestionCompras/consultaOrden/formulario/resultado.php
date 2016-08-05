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


        if (isset($_REQUEST ['numero_orden']) && $_REQUEST ['numero_orden'] != '') {
            $numero_orden = explode("-", $_REQUEST ['numero_orden']);
        } else {
            $numero_orden = array('', '');
        }
        if (isset($_REQUEST ['tipo_orden']) && $_REQUEST ['tipo_orden'] != '') {
            $tipo_orden = $_REQUEST ['tipo_orden'];
        } else {
            $tipo_orden = '';
        }

        if (isset($_REQUEST ['id_proveedor']) && $_REQUEST ['id_proveedor'] != '') {
            $nit = $_REQUEST ['id_proveedor'];
        } else {
            $nit = '';
        }

        if (isset($_REQUEST ['sedeConsulta']) && $_REQUEST ['sedeConsulta'] != '') {
            $sede = $_REQUEST ['sedeConsulta'];
        } else {
            $sede = '';
        }

        if (isset($_REQUEST ['dependenciaConsulta']) && $_REQUEST ['dependenciaConsulta'] != '') {
            $dependencia = $_REQUEST ['dependenciaConsulta'];
        } else {
            $dependencia = '';
        }

        if (isset($_REQUEST ['fecha_inicio']) && $_REQUEST ['fecha_inicio'] != '') {
            $fecha_inicio = $_REQUEST ['fecha_inicio'];
        } else {
            $fecha_inicio = '';
        }

        if (isset($_REQUEST ['fecha_final']) && $_REQUEST ['fecha_final'] != '') {
            $fecha_final = $_REQUEST ['fecha_final'];
        } else {
            $fecha_final = '';
        }

        if (isset($_REQUEST ['convenio_solicitante']) && $_REQUEST ['convenio_solicitante'] != '') {
            $convenio = $_REQUEST ['convenio_solicitante'];
        } else {
            $convenio = '';
        }





        $id_usuario = $_REQUEST['usuario'];
        $cadenaSqlUnidad = $this->miSql->getCadenaSql("obtenerInfoUsuario", $id_usuario);
        $unidadEjecutora = $DBFrameWork->ejecutarAcceso($cadenaSqlUnidad, "busqueda");

        if ($unidadEjecutora[0]['unidad_ejecutora'] == 1) {
            $unidadEjecutora = 209;
            $arreglo = array(
                'tipo_orden' => $tipo_orden,
                'numero_contrato' => $numero_orden[0],
                'vigencia' => $numero_orden[1],
                'nit' => $nit,
                'fecha_inicial' => $fecha_inicio,
                'fecha_final' => $fecha_final,
                'unidad_ejecutora' => $unidadEjecutora,
                'sede' => $sede,
                'dependencia' => $dependencia,
            );
            $cadenaSql = $this->miSql->getCadenaSql('consultarOrdenGeneral', $arreglo);

            $Orden = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        } else {

            $unidadEjecutora = 208;
            $arreglo = array(
                'tipo_orden' => $tipo_orden,
                'numero_contrato' => $numero_orden[0],
                'vigencia' => $numero_orden[1],
                'nit' => $nit,
                'fecha_inicial' => $fecha_inicio,
                'fecha_final' => $fecha_final,
                'unidad_ejecutora' => $unidadEjecutora,
                'dependencia' => $convenio,
            );


            $cadenaSql = $this->miSql->getCadenaSql('consultarOrdenIdexud', $arreglo);

            $Orden = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        }
        

        $arreglo = base64_encode(serialize($arreglo));
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
        $atributos ["leyenda"] = "Consulta de Ordenes";
        echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);

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



        echo "<div id='myModal' class='modal'>
                 <div class='modal-content'>
                    <span class='close'>x</span>";

        $esteCampo = "marcoSeleccionMultiple";
        $atributos ['id'] = $esteCampo;
        $atributos ["estilo"] = "jqueryui";
        $atributos ['tipoEtiqueta'] = 'inicio';
        $atributos ["leyenda"] = "Aprobacion Multiple";
        echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);





        if ($Orden) {



            echo "<table id='tablaModalOrdenes'>";
            echo "<thead>
                             <tr>
                                <th>Tipo Orden</th>
                                <th>Número Orden</th>
                                <th>Numero CDP</th>
                    		<th>Vigencia</th>            
                    		<th>Estado</th>            
            			<th><center>Seleccione</center></th>
                             </tr>
                          </thead>
                          <tbody>";

            for ($i = 0; $i < count($Orden); $i ++) {


                $nombre = 'checkbox' . $i;
                $atributos ['id'] = $nombre;
                $atributos ['nombre'] = $nombre;
                $atributos ['estilo'] = 'campoCuadroSeleccionCorta';
                $atributos ['marco'] = true;
                $atributos ['estiloMarco'] = true;
                $atributos ["etiquetaObligatorio"] = true;
                $atributos ['columnas'] = 1;
                $atributos ['dobleLinea'] = 1;
                $atributos ['tabIndex'] = $tab;
                $atributos ['etiqueta'] = '';
                $atributos ['validar'] = '';
                $atributos ['valor'] = $Orden [$i] ['numero_contrato'] . "-" . $Orden [$i] ['vigencia'];
                $atributos ['deshabilitado'] = false;
                $tab ++;

                // Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);


                $mostrarHtml = "<tr>
                                <td><center>" . $Orden [$i] ['descripcion'] . "</center></td>
                                <td><center>" . $Orden [$i] ['numero_contrato'] . "</center></td>		
                                <td><center>" . $Orden [$i] ['numero_cdp'] . "</center></td>		
                                <td><center>" . $Orden [$i] ['vigencia'] . "</center></td>
                                <td><center>" . $Orden [$i] ['nombre_estado'] . "</center></td>
                                <td><center>" . $this->miFormulario->campoCuadroSeleccion($atributos) . " </center></td>         		
                                </tr>";
                echo $mostrarHtml;
                unset($mostrarHtml);
                unset($atributos);
                unset($variable);
            }

            echo "</tbody>";

            echo "</table>";
            echo "<br>";

            $atributos ["id"] = "botones";
            $atributos ["estilo"] = "marcoBotones";
            echo $this->miFormulario->division("inicio", $atributos);

            $esteCampo = 'botonAprobarMultiple';
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

            echo $this->miFormulario->division('fin');
        }
        unset($atributos);

        echo $this->miFormulario->marcoAgrupacion('fin');
        echo " </div></div>";




        if ($Orden) {

            echo "<table id='tablaTitulos'>";
            echo "<thead>
                             <tr>
                                <th>Tipo Orden</th>
                                <th>Número Orden</th>
                                <th>Solicitud de Necedidad</th>
                                <th>Numero CDP</th>
                    		<th>Vigencia</th>            
            			<th>Identificación<br>Nombre Contratista</th>
                                <th>Sede-Dependencia</th>
                                <th>Fecha de Registro</th>
                                <th>Estado</th>
                                <th>Modificar Orden</th>
                        	<th>Modificar Elementos <br>o Servicios</th>
				<th>Documento Orden</th>
				<th>Revisar<br>Aprobar Contrato</th>
                             </tr>
                          </thead>
                          
                          
                          


                          <tbody>";

            for ($i = 0; $i < count($Orden); $i ++) {
                $variable = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                $variable .= "&opcion=modificarOrden";
                $variable .= "&numerocontrato=" . $Orden [$i] ['numero_contrato'];
                $variable .= "&id_orden=" . $Orden [$i] ['id_orden'];
                $variable .= "&vigencia=" . $Orden [$i] ['vigencia'];
                $variable .= "&id_contratista=" . $Orden [$i] ['proveedor'];
                $variable .= "&arreglo=" . $arreglo;
                $variable .= "&usuario=" . $_REQUEST ['usuario'];
                $variable .= "&mensaje_titulo=" . $Orden [$i] ['descripcion'] . "   --> VIGENCIA: " . $Orden [$i] ['vigencia'] . " NÚMERO ORDEN : " . $Orden [$i] ['numero_contrato'];
                $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);

                $variable_elementos = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
                $variable_elementos .= "&opcion=consultaElementos";
                $variable_elementos .= "&numerocontrato=" . $Orden [$i] ['numero_contrato'];
                $variable_elementos .= "&id_orden=" . $Orden [$i] ['id_orden'];
                $variable_elementos .= "&vigencia=" . $Orden [$i] ['vigencia'];
                $variable_elementos .= "&id_contratista=" . $Orden [$i] ['proveedor'];
                $variable_elementos .= "&arreglo=" . $arreglo;
                $variable_elementos .= "&usuario=" . $_REQUEST ['usuario'];
                $variable_elementos .= "&mensaje_titulo=" . $Orden [$i] ['descripcion'] . "  --> VIGENCIA: " . $Orden [$i] ['vigencia'] . " NÚMERO ORDEN : " . $Orden [$i] ['numero_contrato'];
                $variable_elementos = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable_elementos, $directorio);


                $variable_documento = "action=" . $esteBloque ["nombre"];
                $variable_documento .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
                $variable_documento .= "&bloque=" . $esteBloque ['nombre'];
                $variable_documento .= "&bloqueGrupo=" . $esteBloque ["grupo"];
                $variable_documento .= "&opcion=generarDocumento";
                $variable_documento .= "&id_orden=" . $Orden [$i] ['id_orden'];
                $variable_documento .= "&usuario=" . $_REQUEST ['usuario'];
                $variable_documento .= "&mensaje_titulo=" . $Orden [$i] ['descripcion'] . " --> VIGENCIA: " . $Orden [$i] ['vigencia'] . " NÚMERO ORDEN : " . $Orden [$i] ['numero_contrato'];
                $variable_documento = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable_documento, $directorio);



                $variable_aprobacion = "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
                $variable_aprobacion .= "&opcion=aprobarContrato";
                $variable_aprobacion .= "&id_orden=" . $Orden [$i] ['id_orden'];
                $variable_aprobacion .= "&vigencia=" . $Orden [$i] ['vigencia'];
                $variable_aprobacion .= "&numero_contrato=" . $Orden [$i] ['numero_contrato'];
                $variable_aprobacion .= "&usuario=" . $_REQUEST ['usuario'];
                $variable_aprobacion .= "&mensaje_titulo=" . $Orden [$i] ['descripcion'] . " <br> --> VIGENCIA: " . $Orden [$i] ['vigencia'] . " NÚMERO ORDEN : " . $Orden [$i] ['numero_contrato'];
                $variable_aprobacion = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable_aprobacion, $directorio);

//				$elemento = (is_null ( $Orden [$i] ['validacion'] ) == true) ? '' : (($Orden [$i] ['estado_elementos'] == 't') ? "<a href='" . $variable_elementos . "'><img src='" . $rutaBloque . "/css/images/update.png' width='15px'></a>" : '');
//				$documento = (is_null ( $Orden [$i] ['validacion'] ) == true) ? '' : (($Orden [$i] ['estado_elementos'] == 't') ? "<a href='" . $variable_documento . "'><img src='" . $rutaBloque . "/css/images/documento.png' width='15px'></a>" : '');
//				
                $elemento = "<a href='" . $variable_elementos . "'><img src='" . $rutaBloque . "/css/images/update.png' width='15px'></a>";
                $documento = "<a href='" . $variable_documento . "'><img src='" . $rutaBloque . "/css/images/documento.png' width='15px'></a>";
                $aprobacion = "<a href='" . $variable_aprobacion . "'><img src='" . $rutaBloque . "/css/images/aprobar.png' width='15px'></a>";



                $mostrarHtml = "<tr>
                                <td><center>" . $Orden [$i] ['descripcion'] . "</center></td>
                                <td><center>" . $Orden [$i] ['numero_contrato'] . "</center></td>		
                                <td><center>" . $Orden [$i] ['numero_solicitud_necesidad'] . "</center></td>		
                                <td><center>" . $Orden [$i] ['numero_cdp'] . "</center></td>		
                                <td><center>" . $Orden [$i] ['vigencia'] . "</center></td>
                                <td><center>" . $Orden [$i] ['proveedor'] . "</center></td>
                                <td><center>" . $Orden [$i] ['sededependencia'] . "</center></td>
                                <td><center>" . $Orden [$i] ['fecha_registro'] . "</center></td>
                                <td><center> " . $Orden [$i] ['nombre_estado'] . "</center></td>
                                <td><center>
                                    <a href='" . $variable . "'>
                                        <img src='" . $rutaBloque . "/css/images/edit.png' width='15px'>
                                    </a>
                                </center> </td>
                		<td><center>" . $elemento . "</center> </td>        		
                                <td><center>" . $documento . "</center> </td>         		
                                <td><center>" . $aprobacion . "</center> </td>         		
                                </tr>";
                echo $mostrarHtml;
                unset($mostrarHtml);
                unset($variable);
            }

            echo "</tbody>";

            echo "</table>";
            echo "<br>";

            $atributos ["id"] = "botones";
            $atributos ["estilo"] = "marcoBotones";
            echo $this->miFormulario->division("inicio", $atributos);
            echo "<button id='myBtn'>Aprobación Multiple</button>";
            echo $this->miFormulario->division('fin');
        } else {

            $mensaje = "No Se Encontraron<br>Ordenes.";

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

        $valorCodificado = "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
        $valorCodificado .= "&opcion=aprobarContratoMultiple";

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
