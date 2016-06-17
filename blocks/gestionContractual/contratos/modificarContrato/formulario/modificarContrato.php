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

        $_REQUEST ['tiempo'] = time();

        // -------------------------------------------------------------------------------------------------
        $conexion = "contractual";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
        $conexionFrameWork = "estructura";
        $DBFrameWork = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexionFrameWork);


        // Limpia Items Tabla temporal
        // ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
        $esteCampo = $esteBloque ['nombre'];

        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;

        /**
         * Nuevo a partir de la versión 1.0.0.2, se utiliza para crear de manera rápida el js asociado a
         * validationEngine.
         */
        $atributos ['validar'] = false;

        // Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
        $atributos ['tipoFormulario'] = 'multipart/form-data';
        // Si no se coloca, entonces toma el valor predeterminado 'POST'
        $atributos ['metodo'] = 'POST';
        // Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
        $atributos ['action'] = 'index.php';
        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo);
        // Si no se coloca, entonces toma el valor predeterminado.
        $atributos ['estilo'] = '';
        $atributos ['marco'] = false;
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
        $atributos ["leyenda"] = "Actualizar Contrato";
        echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);
        unset($atributos);
        {

            $cadena_sql_Temp = $this->miSql->getCadenaSql('Consultar_info_Temporal', $_REQUEST ['numero_contrato']);
            $infoTemporal = $esteRecursoDB->ejecutarAcceso($cadena_sql_Temp, "busqueda");


            if ($infoTemporal != false) {

                $ventanaClaseContratista = 'none';
                $ventanaConvenio = 'none';
                $informacioAlmacenada = array();
                for ($j = 0; $j < count($infoTemporal); $j++) {
                    $temp = array($infoTemporal[$j][0] => $infoTemporal[$j][1]);
                    $informacioAlmacenada = array_merge($informacioAlmacenada, $temp);
                }
                 $cadena_sql = $this->miSql->getCadenaSql('Consultar_Disponibilidad', $_REQUEST ['id_solicitud_necesidad']);
                $disponibilidad = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
                $registrosPresupuestales = array();
                for ($i = 0; $i < count($disponibilidad); $i++) {
                    $cadena_sql = $this->miSql->getCadenaSql('Consultar_Registro_Presupuestales', $disponibilidad[$i]['id_disponibilidad']);
                    $registrosP = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
                    if ($registrosP != false) {
                        $registrosPresupuestales = array_merge($registrosPresupuestales, $registrosP);
                    }
                }
                $cadena_sql = $this->miSql->getCadenaSql('Consultar_Contratista', $_REQUEST ['id_solicitud_necesidad']);
                $contratista = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
                $contratista = $contratista [0];
                $cadena_sql = $this->miSql->getCadenaSql('Consultar_Solicitud_Particular', $_REQUEST ['id_solicitud_necesidad']);
                $solicitud = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
                $solicitud = $solicitud [0];

                $_REQUEST = array_merge($_REQUEST, $informacioAlmacenada);
                
                

                if ($_REQUEST ['clase_contratista'] == '33' || $_REQUEST ['clase_contratista'] == '34') {

                    $ventanaClaseContratista = 'block';
                }
                if ($_REQUEST ['tipo_compromiso'] == '46') {

                    $ventanaConvenio = 'block';
                }
                $mensaje = "Proceso de Edición Iniciado Previamente.";
            } else {
                $ventanaClaseContratista = 'none';
                $ventanaConvenio = 'none';

                if (isset($_REQUEST ['opcion']) == 'modificarContrato') {
                    $datosContrato = array($_REQUEST ['numero_contrato'], $_REQUEST ['vigencia']);
                    $cadena_sql = $this->miSql->getCadenaSql('Consultar_Contrato_Particular', $datosContrato);
                    $contrato = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
                    $contrato = $contrato [0];
                    $arregloContrato = array(
                        "numero_contrato" => $contrato ['numero_contrato'],
                        "tipo_configuracion" => $contrato ['tipo_configuracion'],
                        "clase_contratista" => $contrato ['clase_contratista'],
                        "clase_contrato" => $contrato ['tipo_contrato'],
                        "tipo_compromiso" => $contrato ['clase_compromiso'],
                        "fecha_subcripcion" => $contrato ['fecha_sub'],
                        "plazo_ejecucion" => $contrato ['plazo_ejecucion'],
                        "unidad_ejecucion_tiempo" => $contrato ['unidad_ejecucion_tiempo'],
                        "fecha_inicio_poliza" => $contrato ['fecha_inicio'],
                        "fecha_final_poliza" => $contrato ['fecha_final'],
                        "tipologia_especifica" => $contrato ['tipologia_contrato'],
                        "numero_constancia" => $contrato ['numero_constancia'],
                        "modalidad_seleccion" => $contrato ['modalidad_seleccion'],
                        "procedimiento" => $contrato ['procedimiento'],
                        "regimen_contratación" => $contrato ['regimen_contratacion'],
                        "tipo_moneda" => $contrato ['tipo_moneda'],
                        "tipo_gasto" => $contrato ['tipo_gasto'],
                        "origen_recursos" => $contrato ['origen_recursos'],
                        "origen_presupuesto" => $contrato ['origen_presupuesto'],
                        "tema_gasto_inversion" => $contrato ['tema_corr_gst_inv'],
                        "valor_contrato_moneda_ex" => $contrato ['valor_moneda_ext'],
                        "tasa_cambio" => $contrato ['valor_tasa_cb'],
                        "observacionesContrato" => $contrato ['observacion_contr'],
                        "tipo_control" => $contrato ['tipo_control_ejecucion'],
                        "fecha_suscrip_super" => $contrato ['fecha_sub_super'],
                        "fecha_limite" => $contrato ['fecha_lim_ejec'],
                        "observaciones_interventoria" => $contrato ['observacion_inter'],
                        "supervisor" => $contrato ['supervisor'],
                        "identificacion_clase_contratista" => $contrato ['identificacion_clase_contratista'],
                        "digito_verificacion_clase_contratista" => $contrato ['digito_verificacion_clase_contratista'],
                        "porcentaje_clase_contratista" => $contrato ['porcentaje_clase_contratista'],
                        "numero_convenio" => $contrato ['numero_convenio'],
                        "vigencia_convenio" => $contrato ['vigencia_convenio'],
                        "digito_supervisor" => $contrato ['digito_verificacion_supervisor'],
                        "formaPago" => $contrato ['forma_pago'],
                        "clausula_presupuesto" => $contrato ['clausula_registro_presupuestal'],
                        "objeto_contrato" => $contrato ['objeto_contrato'],
                        "valor_contrato" => $contrato ['valor_contrato'],
                        "ordenador_gasto" => $contrato ['ordenador_gasto'],
                    );

                    $_REQUEST = array_merge($_REQUEST, $arregloContrato);


                    if ($contrato ['clase_contratista'] == '31' || $contrato ['clase_contratista'] == '32') {

                        $ventanaClaseContratista = 'block';
                    }


                    if ($_REQUEST ['tipo_compromiso'] == '34') {

                        $ventanaConvenio = 'block';
                    }
                }
                // var_dump($_REQUEST);
                $cadena_sql = $this->miSql->getCadenaSql('Consultar_Solicitud_Particular', $_REQUEST ['id_solicitud_necesidad']);
                $solicitud = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
                $solicitud = $solicitud [0];

                $arregloSolicitud = array(
                    "dependencia" => $solicitud ['dependencia_solicitante'],
                );
                $_REQUEST = array_merge($_REQUEST, $arregloSolicitud);

                $cadena_sql = $this->miSql->getCadenaSql('Consultar_Disponibilidad', $_REQUEST ['id_solicitud_necesidad']);
                $disponibilidad = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
            
                $registrosPresupuestales= array();
                for ($i = 0; $i < count($disponibilidad); $i++) {
                   $cadena_sql = $this->miSql->getCadenaSql('Consultar_Registro_Presupuestales', $disponibilidad[$i]['id_disponibilidad']);
                   $registrosP = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
                   if($registrosP != false){
                   $registrosPresupuestales = array_merge($registrosPresupuestales,$registrosP);
                   }
                  
                }
               
                              
                $cadena_sql = $this->miSql->getCadenaSql('Consultar_Contratista', $_REQUEST ['id_solicitud_necesidad']);
                $contratista = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

                if ($contratista) {
                    $contratista = $contratista [0];
                   
                    $arregloContratista = array(
                        "id_contratista" => $contratista ['id_contratista'],
                        "tipo_identificacion" => $contratista ['tipo_documento'],
                        "numero_identificacion" => $contratista ['identificacion'],
                        "digito_verificacion" => $contratista ['digito_verificacion'],
                        "genero" => $contratista ['genero'],
                        "direccion" => $contratista ['direccion'],
                        "telefono" => $contratista ['telefono'],
                        "correo" => $contratista ['correo'],
                        "tipo_cuenta" => $contratista ['tipo_cuenta'],
                        "tipo_persona" => $contratista ['tipo_naturaleza'],
                        "numero_cuenta" => $contratista ['numero_cuenta'],
                        "entidad_bancaria" => $contratista ['nombre_banco'],
                        "perfil" => $contratista ['perfil'],
                        "profesion" => $contratista ['profesion'],
                        "especialidad" => $contratista ['especialidad'],
                        "nombre_Razon_Social" => $contratista ['nombre_razon_social'],
                        "nacionalidad" => $contratista ['nacionalidad']
                    );
                    $_REQUEST = array_merge($_REQUEST, $arregloContratista);
                }
                $mensaje = "";
            }
            
            
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
            $atributos ["etiquetaObligatorio"] = false;
            $atributos ['columnas'] = 1;
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
            $atributos ['tamanno'] = 35;
            $atributos ['maximoTamanno'] = '';
            $atributos ['anchoEtiqueta'] = 180;
            $tab ++;

            // Aplica atributos globales al control
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroTexto($atributos);
            unset($atributos);
            // ------------------Division para los botones-------------------------
            $atributos ["id"] = "ventanaA";
            echo $this->miFormulario->division("inicio", $atributos);
            unset($atributos);
            {

                if ($mensaje != "") {
                    echo "<div name='mensajeEdicionPrevio' id='mensajeEdicionPrevio' class='information shadow textoCentrar' >" . $mensaje . "</div>";
                }
                echo "<h3>Datos Personales</h3>
							<section>";
                {

                    // ------------------Division para los botones-------------------------
                    $atributos ["id"] = "division";
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos);
                    {
                        $esteCampo = 'tipo_identificacion';
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

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }

                        $matrizItems = array(
                            array(
                                ' ',
                                'Sin Solicitud de Necesidad'
                            )
                        );

                        // $atributos ['matrizItems'] = $matrizItems;
                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        $atributos ['baseDatos'] = 'contractual';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_identificacion");
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);

                        $esteCampo = 'numero_identificacion';
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
                        $atributos ['validar'] = 'required,custom[onlyNumberSp]';

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = false;
                        $atributos ['tamanno'] = 20;
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

                    //
                    $atributos ["id"] = "division";
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos);
                    {

                        $esteCampo = 'digito_verificacion';
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
                        $atributos ['validar'] = 'required,custom[onlyNumberSp]';

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = false;
                        $atributos ['tamanno'] = 20;
                        $atributos ['maximoTamanno'] = '';
                        $atributos ['anchoEtiqueta'] = 213;
                        $tab ++;

                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);

                        $esteCampo = 'tipo_persona';
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
                        $atributos ['anchoEtiqueta'] = 213;

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }

                        $matrizItems = array(
                            array(
                                ' ',
                                'Sin Solicitud de Necesidad'
                            )
                        );

                        // $atributos ['matrizItems'] = $matrizItems;
                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        $atributos ['baseDatos'] = 'contractual';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_persona");
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);
                    }
                    // ------------------Fin Division para los botones-------------------------
                    echo $this->miFormulario->division("fin");
                    unset($atributos);




                    $atributos ["id"] = "divisionPersonaJuridica";
                    $atributos ["estiloEnLinea"] = "";
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos); {


                        $esteCampo = 'nombre_Razon_Social';
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

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = false;
                        $atributos ['tamanno'] = 20;
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



                    $atributos ["id"] = "divisionPersonaNatural";
                    $atributos ["estiloEnLinea"] = "";
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos); {

                        //
                        $atributos ["id"] = "division";
                        echo $this->miFormulario->division("inicio", $atributos);
                        unset($atributos);
                        {

//                        $esteCampo = 'primer_nombre';
//                        $atributos ['id'] = $esteCampo;
//                        $atributos ['nombre'] = $esteCampo;
//                        $atributos ['tipo'] = 'text';
//                        $atributos ['estilo'] = 'jqueryui';
//                        $atributos ['marco'] = true;
//                        $atributos ['estiloMarco'] = '';
//                        $atributos ["etiquetaObligatorio"] = true;
//                        $atributos ['columnas'] = 2;
//                        $atributos ['dobleLinea'] = 0;
//                        $atributos ['tabIndex'] = $tab;
//                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
//                        $atributos ['validar'] = 'required';
//
//                        if (isset($_REQUEST [$esteCampo])) {
//                            $atributos ['valor'] = $_REQUEST [$esteCampo];
//                        } else {
//                            $atributos ['valor'] = '';
//                        }
//                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
//                        $atributos ['deshabilitado'] = false;
//                        $atributos ['tamanno'] = 20;
//                        $atributos ['maximoTamanno'] = '';
//                        $atributos ['anchoEtiqueta'] = 213;
//                        $tab ++;
//
//                        // Aplica atributos globales al control
//                        $atributos = array_merge($atributos, $atributosGlobales);
//                        echo $this->miFormulario->campoCuadroTexto($atributos);
//                        unset($atributos);
//
//                        $esteCampo = 'segundo_nombre';
//                        $atributos ['id'] = $esteCampo;
//                        $atributos ['nombre'] = $esteCampo;
//                        $atributos ['tipo'] = 'text';
//                        $atributos ['estilo'] = 'jqueryui';
//                        $atributos ['marco'] = true;
//                        $atributos ['estiloMarco'] = '';
//                        $atributos ["etiquetaObligatorio"] = false;
//                        $atributos ['columnas'] = 2;
//                        $atributos ['dobleLinea'] = 0;
//                        $atributos ['tabIndex'] = $tab;
//                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
//                        $atributos ['validar'] = ' ';
//
//                        if (isset($_REQUEST [$esteCampo])) {
//                            $atributos ['valor'] = $_REQUEST [$esteCampo];
//                        } else {
//                            $atributos ['valor'] = '';
//                        }
//                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
//                        $atributos ['deshabilitado'] = false;
//                        $atributos ['tamanno'] = 20;
//                        $atributos ['maximoTamanno'] = '';
//                        $atributos ['anchoEtiqueta'] = 213;
//                        $tab ++;
//
//                        // Aplica atributos globales al control
//                        $atributos = array_merge($atributos, $atributosGlobales);
//                        echo $this->miFormulario->campoCuadroTexto($atributos);
//                        unset($atributos);
                        }
                        // ------------------Fin Division para los botones-------------------------
                        echo $this->miFormulario->division("fin");
                        unset($atributos);

                        $atributos ["id"] = "division";
                        echo $this->miFormulario->division("inicio", $atributos);
                        unset($atributos);
                        {

//                        $esteCampo = 'primer_apellido';
//                        $atributos ['id'] = $esteCampo;
//                        $atributos ['nombre'] = $esteCampo;
//                        $atributos ['tipo'] = 'text';
//                        $atributos ['estilo'] = 'jqueryui';
//                        $atributos ['marco'] = true;
//                        $atributos ['estiloMarco'] = '';
//                        $atributos ["etiquetaObligatorio"] = true;
//                        $atributos ['columnas'] = 2;
//                        $atributos ['dobleLinea'] = 0;
//                        $atributos ['tabIndex'] = $tab;
//                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
//                        $atributos ['validar'] = 'required';
//
//                        if (isset($_REQUEST [$esteCampo])) {
//                            $atributos ['valor'] = $_REQUEST [$esteCampo];
//                        } else {
//                            $atributos ['valor'] = '';
//                        }
//                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
//                        $atributos ['deshabilitado'] = false;
//                        $atributos ['tamanno'] = 20;
//                        $atributos ['maximoTamanno'] = '';
//                        $atributos ['anchoEtiqueta'] = 213;
//                        $tab ++;
//
//                        // Aplica atributos globales al control
//                        $atributos = array_merge($atributos, $atributosGlobales);
//                        echo $this->miFormulario->campoCuadroTexto($atributos);
//                        unset($atributos);
//
//                        $esteCampo = 'segundo_apellido';
//                        $atributos ['id'] = $esteCampo;
//                        $atributos ['nombre'] = $esteCampo;
//                        $atributos ['tipo'] = 'text';
//                        $atributos ['estilo'] = 'jqueryui';
//                        $atributos ['marco'] = true;
//                        $atributos ['estiloMarco'] = '';
//                        $atributos ["etiquetaObligatorio"] = false;
//                        $atributos ['columnas'] = 2;
//                        $atributos ['dobleLinea'] = 0;
//                        $atributos ['tabIndex'] = $tab;
//                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
//                        $atributos ['validar'] = ' ';
//
//                        if (isset($_REQUEST [$esteCampo])) {
//                            $atributos ['valor'] = $_REQUEST [$esteCampo];
//                        } else {
//                            $atributos ['valor'] = '';
//                        }
//                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
//                        $atributos ['deshabilitado'] = false;
//                        $atributos ['tamanno'] = 20;
//                        $atributos ['maximoTamanno'] = '';
//                        $atributos ['anchoEtiqueta'] = 213;
//                        $tab ++;
//
//                        // Aplica atributos globales al control
//                        $atributos = array_merge($atributos, $atributosGlobales);
//                        echo $this->miFormulario->campoCuadroTexto($atributos);
//                        unset($atributos);
                        }
                        // ------------------Fin Division para los botones-------------------------
                        echo $this->miFormulario->division("fin");
                        unset($atributos);
                    }
                    // ------------------Fin Division para los botones-------------------------
                    echo $this->miFormulario->division("fin");
                    unset($atributos);

                    $atributos ["id"] = "division";
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos);
                    {
                        $esteCampo = 'genero';
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
                        $atributos ['anchoEtiqueta'] = 213;

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }

                        $matrizItems = array(
                            array(
                                ' ',
                                'Sin Solicitud de Necesidad'
                            )
                        );

                        // $atributos ['matrizItems'] = $matrizItems;
                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        $atributos ['baseDatos'] = 'contractual';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_genero");
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);

                        $esteCampo = 'nacionalidad';
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
                        $atributos ['anchoEtiqueta'] = 213;

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }

                        $matrizItems = array(
                            array(
                                ' ',
                                'Sin Solicitud de Necesidad'
                            )
                        );

                        // $atributos ['matrizItems'] = $matrizItems;
                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        $atributos ['baseDatos'] = 'contractual';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_nacionalidad");
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);
                    }
                    // ------------------Fin Division para los botones-------------------------
                    echo $this->miFormulario->division("fin");
                    unset($atributos);

                    $atributos ["id"] = "division";
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos);
                    {

                        $esteCampo = 'direccion';
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

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = false;
                        $atributos ['tamanno'] = 20;
                        $atributos ['maximoTamanno'] = '';
                        $atributos ['anchoEtiqueta'] = 213;
                        $tab ++;

                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);

                        $esteCampo = 'telefono';
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

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = false;
                        $atributos ['tamanno'] = 20;
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

                    $atributos ["id"] = "division";
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos);
                    {

                        $esteCampo = 'correo';
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
                        $atributos ['validar'] = 'required, custom[email] ';

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = false;
                        $atributos ['tamanno'] = 20;
                        $atributos ['maximoTamanno'] = '';
                        $atributos ['anchoEtiqueta'] = 213;
                        $tab ++;

                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);

                        $esteCampo = 'perfil';
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

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }

                        $matrizItems = array(
                            array(
                                ' ',
                                'Sin Solicitud de Necesidad'
                            )
                        );

                        // $atributos ['matrizItems'] = $matrizItems;
                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        $atributos ['baseDatos'] = 'contractual';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_perfil");
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);
                    }
                    // ------------------Fin Division para los botones-------------------------
                    echo $this->miFormulario->division("fin");
                    unset($atributos);

                    $atributos ["id"] = "division";
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos);
                    {

                        $esteCampo = 'profesion';
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
                        $atributos ['validar'] = '';

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST [$esteCampo];
                            $atributos ['deshabilitado'] = false;
                        } else {
                            $atributos ['valor'] = '';
                            $atributos ['deshabilitado'] = true;
                        }
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['tamanno'] = 20;
                        $atributos ['maximoTamanno'] = '';
                        $atributos ['anchoEtiqueta'] = 213;
                        $tab ++;

                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);

                        $esteCampo = 'especialidad';
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
                        $atributos ['validar'] = '  ';

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST [$esteCampo];
                            $atributos ['deshabilitado'] = false;
                        } else {
                            $atributos ['valor'] = '';
                            $atributos ['deshabilitado'] = true;
                        }
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['tamanno'] = 20;
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

                    $atributos ["id"] = "division";
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos);
                    {

                        $esteCampo = 'tipo_cuenta';
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
                        $atributos ['anchoEtiqueta'] = 213;

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }

                        $matrizItems = array(
                            array(
                                ' ',
                                'Sin Solicitud de Necesidad'
                            )
                        );

                        // $atributos ['matrizItems'] = $matrizItems;
                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        $atributos ['baseDatos'] = 'contractual';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_cuenta");
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);

                        $esteCampo = 'numero_cuenta';
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
                        $atributos ['validar'] = 'required,custom[onlyNumberSp]';

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = false;
                        $atributos ['tamanno'] = 20;
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

                    $atributos ["id"] = "division";
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos);
                    {

                        $esteCampo = 'entidad_bancaria';
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

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = false;
                        $atributos ['tamanno'] = 20;
                        $atributos ['maximoTamanno'] = '';
                        $atributos ['anchoEtiqueta'] = 213;
                        $tab ++;

                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);

                        $esteCampo = 'tipo_configuracion';
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
                        $atributos ['anchoEtiqueta'] = 213;
                        $atributos ['anchoCaja'] = 28;
                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }

                        $matrizItems = array(
                            array(
                                ' ',
                                'Sin Solicitud de Necesidad'
                            )
                        );

                        // $atributos ['matrizItems'] = $matrizItems;
                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        $atributos ['baseDatos'] = 'contractual';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_configuracion");
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);
                    }
                    // ------------------Fin Division para los botones-------------------------
                    echo $this->miFormulario->division("fin");
                    unset($atributos);

                    $atributos ["id"] = "division";
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos);
                    {

                        $esteCampo = 'clase_contratista';
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
                        $atributos ['anchoCaja'] = 35;
                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }

                        $matrizItems = array(
                            array(
                                ' ',
                                'Sin Solicitud de Necesidad'
                            )
                        );

                        // $atributos ['matrizItems'] = $matrizItems;
                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        $atributos ['baseDatos'] = 'contractual';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_clase_contratista");
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);

                        $atributos ["id"] = "divisionClaseContratista";
                        $atributos ["estiloEnLinea"] = "display:" . $ventanaClaseContratista;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->division("inicio", $atributos);
                        unset($atributos);
                        {

                            $esteCampo = 'identificacion_clase_contratista';
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
                            $atributos ['validar'] = 'required,custom[onlyNumberSp]';

                            if (isset($_REQUEST [$esteCampo])) {
                                $atributos ['valor'] = $_REQUEST [$esteCampo];
                            } else {
                                $atributos ['valor'] = '';
                            }
                            $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                            $atributos ['deshabilitado'] = false;
                            $atributos ['tamanno'] = 20;
                            $atributos ['maximoTamanno'] = '';
                            $atributos ['anchoEtiqueta'] = 213;
                            $tab ++;

                            // Aplica atributos globales al control
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroTexto($atributos);
                            unset($atributos);

                            $esteCampo = 'digito_verificacion_clase_contratista';
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
                            $atributos ['validar'] = 'required,custom[onlyNumberSp]';

                            if (isset($_REQUEST [$esteCampo])) {
                                $atributos ['valor'] = $_REQUEST [$esteCampo];
                            } else {
                                $atributos ['valor'] = '';
                            }
                            $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                            $atributos ['deshabilitado'] = false;
                            $atributos ['tamanno'] = 20;
                            $atributos ['maximoTamanno'] = '';
                            $atributos ['anchoEtiqueta'] = 213;
                            $tab ++;

                            // Aplica atributos globales al control
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroTexto($atributos);
                            unset($atributos);

                            $esteCampo = 'porcentaje_clase_contratista';
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
                            $atributos ['validar'] = 'required,custom[number],max[1],min[0]';

                            if (isset($_REQUEST [$esteCampo])) {
                                $atributos ['valor'] = $_REQUEST [$esteCampo];
                            } else {
                                $atributos ['valor'] = '';
                            }
                            $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                            $atributos ['deshabilitado'] = false;
                            $atributos ['tamanno'] = 5;
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
                }

                echo "</section>
							<h3>Datos Contrato</h3>
							<section>";
                {

                    $atributos ["id"] = "division";
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos);
                    {

                        $esteCampo = 'clase_contrato';
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
                        $atributos ['anchoCaja'] = 29;
                        if (isset($_REQUEST [$esteCampo])) {

                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }

                        $matrizItems = array(
                            array(
                                ' ',
                                'Sin Solicitud de Necesidad'
                            )
                        );

                        // $atributos ['matrizItems'] = $matrizItems;
                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        $atributos ['baseDatos'] = 'contractual';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_clase_contrato");
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);

                        $esteCampo = 'tipo_compromiso';
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
                        $atributos ['anchoEtiqueta'] = 213;
                        $atributos ['anchoCaja'] = 20;
                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }

                        $matrizItems = array(
                            array(
                                ' ',
                                'Sin Solicitud de Necesidad'
                            )
                        );

                        // $atributos ['matrizItems'] = $matrizItems;
                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        $atributos ['baseDatos'] = 'contractual';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_compromiso");
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);

                        $atributos ["id"] = "divisionConvenio";
                        $atributos ["estiloEnLinea"] = "display:" . $ventanaConvenio;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->division("inicio", $atributos);
                        unset($atributos);
                        {

                            $esteCampo = 'numero_convenio';
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
                            $atributos ['validar'] = 'required,custom[onlyNumberSp]';

                            if (isset($_REQUEST [$esteCampo])) {
                                $atributos ['valor'] = $_REQUEST [$esteCampo];
                            } else {
                                $atributos ['valor'] = '';
                            }
                            $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                            $atributos ['deshabilitado'] = false;
                            $atributos ['tamanno'] = 20;
                            $atributos ['maximoTamanno'] = '';
                            $atributos ['anchoEtiqueta'] = 213;
                            $tab ++;

                            // Aplica atributos globales al control
                            $atributos = array_merge($atributos, $atributosGlobales);
                            echo $this->miFormulario->campoCuadroTexto($atributos);
                            unset($atributos);

                            $esteCampo = 'vigencia_convenio';
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
                            $atributos ['validar'] = 'required,custom[onlyNumberSp],max[2060],min[2000]';

                            if (isset($_REQUEST [$esteCampo])) {
                                $atributos ['valor'] = $_REQUEST [$esteCampo];
                            } else {
                                $atributos ['valor'] = '';
                            }
                            $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                            $atributos ['deshabilitado'] = false;
                            $atributos ['tamanno'] = 5;
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

                        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                        
                        $esteCampo = 'objeto_contrato';
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
                        $atributos ['validar'] = 'required, minSize[1]';
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

                        $esteCampo = 'fecha_subcripcion';
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

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
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
                    }
                    // ------------------Fin Division para los botones-------------------------
                    echo $this->miFormulario->division("fin");
                    unset($atributos);

                    $atributos ["id"] = "division";
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos);
                    {

                        $esteCampo = 'plazo_ejecucion';
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
                        $atributos ['validar'] = 'required,custom[onlyNumberSp]';

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = false;
                        $atributos ['tamanno'] = 20;
                        $atributos ['maximoTamanno'] = '';
                        $atributos ['anchoEtiqueta'] = 213;
                        $tab ++;

                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);
                        //---------Campo de Seleccion Clausula Presupuestal-------------------------------
                        $esteCampo = 'clausula_presupuesto';
                        $atributos ['id'] = $esteCampo;
                        $atributos ['nombre'] = $esteCampo;
                        $atributos ['estilo'] = 'campoCuadroSeleccionCorta';
                        $atributos ['marco'] = true;
                        $atributos ['estiloMarco'] = true;
                        $atributos ["etiquetaObligatorio"] = true;
                        $atributos ['anchoEtiqueta'] = 70;
                        $atributos ['columnas'] = 2;
                        $atributos ['dobleLinea'] = 1;
                        $atributos ['tabIndex'] = $tab;
                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                        $atributos ['validar'] = '';

                        if (isset($_REQUEST [$esteCampo]) && $_REQUEST [$esteCampo] == 't') {
                           $atributos ['seleccionado'] = 'checked';
                        }
                        $atributos ['valor'] = 'TRUE';
                        $atributos ['deshabilitado'] = false;
                        $tab ++;
                        //Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroSeleccion($atributos);
                        unset($atributos);
                        //---------Fin Campo de Seleccion Clausula Presupuestal-------------------------------


                        $esteCampo = 'unidad_ejecucion_tiempo';
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
                        $atributos ['anchoEtiqueta'] = 213;
                        $atributos ['anchoCaja'] = 29;
                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }

                        $matrizItems = array(
                            array(
                                ' ',
                                'Sin Solicitud de Necesidad'
                            )
                        );

                        // $atributos ['matrizItems'] = $matrizItems;
                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        $atributos ['baseDatos'] = 'contractual';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_ejecucion_tiempo");
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);

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
                        $atributos ['columnas'] = 2;
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
                        $matrizItems = $esteRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
                        $atributos ['matrizItems'] = $matrizItems;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);
                        // ---------------- FIN CONTROL: Select Forma de Pago --------------------------------------------------------
                    }
                    // ------------------Fin Division para los botones-------------------------
                    echo $this->miFormulario->division("fin");
                    unset($atributos);

                    $atributos ["id"] = "division";
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos);
                    {

                        $esteCampo = 'fecha_inicio_poliza';
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
                        $atributos ['validar'] = '';

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = true;
                        $atributos ['tamanno'] = 10;
                        $atributos ['maximoTamanno'] = '';
                        $atributos ['anchoEtiqueta'] = 213;
                        $tab ++;

                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroTexto($atributos);

                        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                        $esteCampo = 'fecha_final_poliza';
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
                        $atributos ['validar'] = 'custom[date]';

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
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
                    }
                    // ------------------Fin Division para los botones-------------------------
                    echo $this->miFormulario->division("fin");
                    unset($atributos);

                    $atributos ["id"] = "division";
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos);
                    {

                        $esteCampo = 'dependencia';
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
                        $atributos ['anchoCaja'] = 17;
                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }

                        $matrizItems = array(
                            array(
                                ' ',
                                'Sin Solicitud de Necesidad'
                            )
                        );

                        // $atributos ['matrizItems'] = $matrizItems;
                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        $atributos ['baseDatos'] = 'contractual';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("dependenciasConsultadas");
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);

                        $esteCampo = 'tipologia_especifica';
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
                        $atributos ['anchoCaja'] = 27;
                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }

                        $matrizItems = array(
                            array(
                                ' ',
                                'Sin Solicitud de Necesidad'
                            )
                        );

                        // $atributos ['matrizItems'] = $matrizItems;
                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        $atributos ['baseDatos'] = 'contractual';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipologia_contrato");
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);
                    }
                    // ------------------Fin Division para los botones-------------------------
                    echo $this->miFormulario->division("fin");
                    unset($atributos);

                    $atributos ["id"] = "division";
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos);
                    {

                        $esteCampo = 'numero_constancia';
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
                        $atributos ['validar'] = 'required,custom[onlyNumberSp]';

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = false;
                        $atributos ['tamanno'] = 20;
                        $atributos ['maximoTamanno'] = '';
                        $atributos ['anchoEtiqueta'] = 213;
                        $tab ++;

                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);

                        $esteCampo = 'modalidad_seleccion';
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
                        $atributos ['anchoCaja'] = 27;
                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }

                        $matrizItems = array(
                            array(
                                ' ',
                                'Sin Solicitud de Necesidad'
                            )
                        );

                        // $atributos ['matrizItems'] = $matrizItems;
                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        $atributos ['baseDatos'] = 'contractual';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("modalidad_seleccion");
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);
                    }
                    // ------------------Fin Division para los botones-------------------------
                    echo $this->miFormulario->division("fin");
                    unset($atributos);

                    $atributos ["id"] = "division";
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos);
                    {

                        $esteCampo = 'procedimiento';
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
                        $atributos ['anchoCaja'] = 30;
                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }

                        $matrizItems = array(
                            array(
                                ' ',
                                'Sin Solicitud de Necesidad'
                            )
                        );

                        // $atributos ['matrizItems'] = $matrizItems;
                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        $atributos ['baseDatos'] = 'contractual';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_procedimiento");
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);

                        $esteCampo = 'regimen_contratación';
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
                        $atributos ['anchoCaja'] = 30;
                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }

                        $matrizItems = array(
                            array(
                                ' ',
                                'Sin Solicitud de Necesidad'
                            )
                        );

                        // $atributos ['matrizItems'] = $matrizItems;
                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        $atributos ['baseDatos'] = 'contractual';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("regimen_contratacion");
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);
                    }
                    // ------------------Fin Division para los botones-------------------------
                    echo $this->miFormulario->division("fin");
                    unset($atributos);
                }

                echo "</section>
							<h3>Información Presupuestal</h3>
							<section>";
                {

                    $atributos ["id"] = "division";
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos);
                    {

                        $esteCampo = 'tipo_moneda';
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
                        $atributos ['anchoCaja'] = 27;
                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = 139;
                        }

                        $matrizItems = array(
                            array(
                                ' ',
                                'Sin Solicitud de Necesidad'
                            )
                        );

                        // $atributos ['matrizItems'] = $matrizItems;
                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        $atributos ['baseDatos'] = 'contractual';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_moneda");
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
                        $atributos ["etiquetaObligatorio"] = true;
                        $atributos ['columnas'] = 2;
                        $atributos ['dobleLinea'] = 0;
                        $atributos ['tabIndex'] = $tab;
                        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                        $atributos ['validar'] = 'required,custom[number]';

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = false;
                        $atributos ['tamanno'] = 20;
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

                    $esteCampo = "AgrupacionDisponibilidad";
                    $atributos ['id'] = $esteCampo;
                    $atributos ['leyenda'] = "Disponibilidades Presupuestales Asociadas";
                    echo $this->miFormulario->agrupacion('inicio', $atributos);
                    {
                        if ($disponibilidad) {
                            echo "<table id='tablaDisponibilidades'>";

                            echo 
                            "<thead>
                             <tr>
                                <th>Número</th>
                    		<th>Fecha </th>
                    		<th>Vigencia </th>
            			<th>Valor($)</th>
                                <th>Codigo - Nombre Rubro</th>
                                 
                             </tr>
                             </thead>
            		     <tbody>";

                            foreach ($disponibilidad as $valor) {
                                $mostrarHtml = "<tr>
						    <td><center>" . $valor ['numero_disp'] . "</center></td>
                                                    <td><center>" . $valor ['fecha_disp'] . "</center></td>
                                                    <td><center>" . $valor ['vigencia'] . "</center></td>
                                                    <td><center>$" . number_format($valor ['valor_disp'], 2, ",", ".") . "</center></td>
                                                    <td><center>" . "rubro" . "</center></td>
						</tr>";
                                echo $mostrarHtml;
                                unset($mostrarHtml);
                                unset($variable);
                            }

                            echo "</tbody>
									</table>";
                        } else {
                            echo "<center>No Existen Disponibilidades Asociadas</center>";
                        }
                    }
                    echo $this->miFormulario->agrupacion('fin');

                    $esteCampo = "AgrupacionRegistrosP";
                    $atributos ['id'] = $esteCampo;
                    $atributos ['leyenda'] = "Registros Presupuestales Asociados";
                    echo $this->miFormulario->agrupacion('inicio', $atributos);
                    {
                        if ($registrosPresupuestales) {
                            echo "<center><table id='tablaRegistros'>";

                            echo 
                            "<thead>
                                <tr>
                                <th>Número</th>
                    		<th>Fecha</th>
                    		<th>Vigencia</th>
            			<th>Valor($)</th>
                                <th>Codigo - Nombre Rubro</th>
                                </tr>
                            </thead>
                            <tbody>";

                            foreach ($registrosPresupuestales as $valor) {
                            $mostrarHtml = "<tr>
                                            <td><center>" . $valor ['numero_registro'] . "</center></td>
                                            <td><center>" . $valor ['fecha_rgs_pr'] . "</center></td>
                                            <td><center>" . $valor ['vigencia'] . "</center></td>
                                            <td><center>$" . number_format($valor ['valor_registro'], 2, ",", ".") . "</center></td>
                                            <td><center>" . "rubro" . "</center></td>
                                            </tr>";
                                echo $mostrarHtml;
                                unset($mostrarHtml);
                                unset($variable);
                            }

                            echo "</tbody>
									</table>";
                        } else {

                            echo "<center>No Existen Registros Presupuestales Asociads</center>";
                        }
                    }
                    echo $this->miFormulario->agrupacion('fin');
                    unset($atributos);

                    $esteCampo = 'ordenador_gasto';
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
                    $atributos ['anchoCaja'] = 26;
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['seleccion'] = - 1;
                    }

                    $matrizItems = array(
                        array(
                            ' ',
                            'Sin Solicitud de Necesidad'
                        )
                    );

                    // $atributos ['matrizItems'] = $matrizItems;
                    // Utilizar lo siguiente cuando no se pase un arreglo:
                    $atributos ['baseDatos'] = 'contractual';
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("ordenadorGasto");
                    $tab ++;
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);

                    $atributos ["id"] = "division";
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos);
                    {

                        $esteCampo = 'tipo_gasto';
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
                        $atributos ['anchoEtiqueta'] = 213;
                        $atributos ['anchoCaja'] = 100;
                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }

                        $matrizItems = array(
                            array(
                                ' ',
                                'Sin Solicitud de Necesidad'
                            )
                        );

                        // $atributos ['matrizItems'] = $matrizItems;
                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        $atributos ['baseDatos'] = 'contractual';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_gasto");
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);

                        $esteCampo = 'origen_recursos';
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
                        $atributos ['anchoEtiqueta'] = 213;
                        $atributos ['anchoCaja'] = 100;
                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }

                        $matrizItems = array(
                            array(
                                ' ',
                                'Sin Solicitud de Necesidad'
                            )
                        );

                        // $atributos ['matrizItems'] = $matrizItems;
                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        $atributos ['baseDatos'] = 'contractual';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("origen_recursos");
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);
                    }
                    // ------------------Fin Division para los botones-------------------------
                    echo $this->miFormulario->division("fin");
                    unset($atributos);

                    $atributos ["id"] = "division";
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos);
                    {

                        $esteCampo = 'origen_presupuesto';
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
                        $atributos ['anchoEtiqueta'] = 213;
                        $atributos ['anchoCaja'] = 100;
                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }

                        $matrizItems = array(
                            array(
                                ' ',
                                'Sin Solicitud de Necesidad'
                            )
                        );

                        // $atributos ['matrizItems'] = $matrizItems;
                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        $atributos ['baseDatos'] = 'contractual';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("origen_presupuesto");
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);

                        $esteCampo = 'tema_gasto_inversion';
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
                        $atributos ['anchoEtiqueta'] = 213;
                        $atributos ['anchoCaja'] = 100;
                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = 164;
                        }

                        $matrizItems = array(
                            array(
                                ' ',
                                'Sin Solicitud de Necesidad'
                            )
                        );

                        // $atributos ['matrizItems'] = $matrizItems;
                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        $atributos ['baseDatos'] = 'contractual';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tema_gasto");
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);
                    }
                    // ------------------Fin Division para los botones-------------------------
                    echo $this->miFormulario->division("fin");
                    unset($atributos);

                    $atributos ["id"] = "division";
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos);
                    {

                        $esteCampo = 'valor_contrato_moneda_ex';
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
                        $atributos ['validar'] = 'custom[number]';

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = false;
                        $atributos ['tamanno'] = 20;
                        $atributos ['maximoTamanno'] = '';
                        $atributos ['anchoEtiqueta'] = 213;
                        $tab ++;

                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);

                        $esteCampo = 'tasa_cambio';
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
                        $atributos ['validar'] = 'custom[number]';

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = false;
                        $atributos ['tamanno'] = 20;
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

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'observacionesContrato';
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
                    $atributos ['validar'] = '';
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
                }

                echo "</section>
							<h3>Supervisión del Contrato</h3>
							<section>";
                {

                    $esteCampo = 'tipo_control';
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
                    $atributos ['anchoCaja'] = 100;
                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['seleccion'] = 183;
                    }

                    $matrizItems = array(
                        array(
                            ' ',
                            'Sin Solicitud de Necesidad'
                        )
                    );

                    // $atributos ['matrizItems'] = $matrizItems;
                    // Utilizar lo siguiente cuando no se pase un arreglo:
                    $atributos ['baseDatos'] = 'contractual';
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("tipo_control");
                    $tab ++;
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);

                    $atributos ["id"] = "division";
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos);
                    {

                        $esteCampo = 'supervisor';
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
                        $atributos ['anchoCaja'] = 60;
                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['seleccion'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['seleccion'] = - 1;
                        }

                        $matrizItems = array(
                            array(
                                ' ',
                                'Sin Solicitud de Necesidad'
                            )
                        );

                        // $atributos ['matrizItems'] = $matrizItems;
                        // Utilizar lo siguiente cuando no se pase un arreglo:
                        $atributos ['baseDatos'] = 'contractual';
                        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("funcionarios");
                        $tab ++;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroLista($atributos);
                        unset($atributos);
                    }
                    // ------------------Fin Division para los botones-------------------------
                    echo $this->miFormulario->division("fin");
                    unset($atributos);

                    $atributos ["id"] = "division";
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos);
                    {

                        $esteCampo = 'digito_supervisor';
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
                        $atributos ['validar'] = 'require,custom[onlyNumberSp]';

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
                        $atributos ['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                        $atributos ['deshabilitado'] = false;
                        $atributos ['tamanno'] = 15;
                        $atributos ['maximoTamanno'] = '';
                        $atributos ['anchoEtiqueta'] = 213;
                        $tab ++;

                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);

                        $esteCampo = 'fecha_suscrip_super';
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

                        if (isset($_REQUEST [$esteCampo])) {
                            $atributos ['valor'] = $_REQUEST [$esteCampo];
                        } else {
                            $atributos ['valor'] = '';
                        }
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
                    }
                    // ------------------Fin Division para los botones-------------------------
                    echo $this->miFormulario->division("fin");
                    unset($atributos);

                    $esteCampo = 'fecha_limite';
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

                    if (isset($_REQUEST [$esteCampo])) {
                        $atributos ['valor'] = $_REQUEST [$esteCampo];
                    } else {
                        $atributos ['valor'] = '';
                    }
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

                    // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                    $esteCampo = 'observaciones_interventoria';
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
                    $atributos ['validar'] = '';
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
                }

                echo "</section>";

                // // ---------------- CONTROL: hidden Atributos Contrado--------------------------------------------------------
                $esteCampo = 'atributosContratoTempHidden';
                $atributos ['id'] = $esteCampo;
                $atributos ['nombre'] = $esteCampo;
                $atributos ['tipo'] = 'hidden';
                $atributos ['estilo'] = 'jqueryui';
                $atributos ['marco'] = true;
                $atributos ['columnas'] = 1;
                $atributos ['dobleLinea'] = false;
                $atributos ['tabIndex'] = $tab;
                $atributos ['valor'] = $_REQUEST ['numero_contrato'];
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

            // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        }

        switch ($_REQUEST ['opcion']) {
            case 'registroContrato' :

                $opcion = "RegistrarContrato";

                break;

            case 'modificarContratos' :

                $opcion = "ModificarContrato";

                break;
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
        // Paso 1: crear el listado de variables

        $valorCodificado = "action=" . $esteBloque ["nombre"];
        $valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
        $valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
        $valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
        $valorCodificado .= "&opcion=" . $opcion;
        $valorCodificado .= "&usuario=" . $_REQUEST ['usuario'];
        $valorCodificado .= "&id_solicitud_necesidad=" . $_REQUEST ['id_solicitud_necesidad'];
        $valorCodificado .= "&numero_contrato=" . $_REQUEST ['numero_contrato'];
        $valorCodificado .= "&vigencia=" . $_REQUEST ['vigencia'];
  
        if ($contratista) {

            $valorCodificado .= "&id_contratista=" . $contratista ['id_contratista'];
            $valorCodificado .= "&id_inf_bancaria=" . $contratista ['id_inf_bancaria'];
            $valorCodificado .= "&id_orden_contrato=" . $contratista ['id_orden_contr'];
            $valorCodificado .= "&id_contrato_normal=" . $contrato ['id_contrato_normal'];
        }

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
