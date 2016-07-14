<?php
/**
 *
* Los datos del bloque se encuentran en el arreglo $esteBloque.
*/

// URL base
$url = $this->miConfigurador->getVariableConfiguracion ( "host" );
$url .= $this->miConfigurador->getVariableConfiguracion ( "site" );
$url .= "/index.php?";

// Variables
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar .= "&funcion=SeleccionTipoBien";
$cadenaACodificar .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar, $enlace );

// URL definitiva
$urlFinal = $url . $cadena;

// Variables
$cadenaACodificarProveedor = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
$cadenaACodificarProveedor .= "&procesarAjax=true";
$cadenaACodificarProveedor .= "&action=index.php";
$cadenaACodificarProveedor .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarProveedor .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarProveedor .= "&funcion=consultaProveedor";
$cadenaACodificarProveedor .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificarProveedor, $enlace );

// URL definitiva
$urlFinalProveedor = $url . $cadena;

// Variables
$cadenaACodificarNumeroOrden = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
$cadenaACodificarNumeroOrden .= "&procesarAjax=true";
$cadenaACodificarNumeroOrden .= "&action=index.php";
$cadenaACodificarNumeroOrden .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarNumeroOrden .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarNumeroOrden .= $cadenaACodificarNumeroOrden . "&funcion=consultarDependencia";
$cadenaACodificarNumeroOrden .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadena16 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificarNumeroOrden, $enlace );

// URL definitiva
$urlFinal16 = $url . $cadena16;



// Variables
$cadenaACodificarNumeroOrden = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
$cadenaACodificarNumeroOrden .= "&procesarAjax=true";
$cadenaACodificarNumeroOrden .= "&action=index.php";
$cadenaACodificarNumeroOrden .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarNumeroOrden .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarNumeroOrden .= $cadenaACodificarNumeroOrden . "&funcion=consultarNumeroOrden";
$cadenaACodificarNumeroOrden .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlaceNumeroOrden = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadenaNumeroOrden = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificarNumeroOrden, $enlace );

// URL definitiva
$urlFinalNumeroOrden = $url . $cadenaNumeroOrden;



// Variables
$cadenaACodificariva = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
$cadenaACodificariva .= "&procesarAjax=true";
$cadenaACodificariva .= "&action=index.php";
$cadenaACodificariva .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificariva .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificariva .= "&funcion=consultarIva";
$cadenaACodificariva .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadenaiva = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificariva, $enlace );

// URL definitiva
$urlFinaliva = $url . $cadenaiva;


$cadenaACodificarProveedorFiltro = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarProveedorFiltro .= "&procesarAjax=true";
$cadenaACodificarProveedorFiltro .= "&action=index.php";
$cadenaACodificarProveedorFiltro .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarProveedorFiltro .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarProveedorFiltro .= $cadenaACodificarProveedorFiltro . "&funcion=consultarProveedorFiltro";
$cadenaACodificarProveedorFiltro .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaACodificarProveedorFiltro = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarProveedorFiltro, $enlace);

// URL definitiva
$urlProveedorFiltro = $url . $cadenaACodificarProveedorFiltro;

// Variables
$cadenaACodificarDependencia = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificarDependencia .= "&procesarAjax=true";
$cadenaACodificarDependencia .= "&action=index.php";
$cadenaACodificarDependencia .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarDependencia .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarDependencia .= $cadenaACodificarDependencia . "&funcion=consultarDependencias";
$cadenaACodificarDependencia .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadenaDependencia = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificarDependencia, $enlace);

// URL definitiva
$urlFinalDependencia = $url . $cadenaDependencia;


?>
<script type='text/javascript'>


//--------------Inicio JavaScript y Ajax Sede y Dependencia elemento ---------------------------------------------------------------------------------------------    

   $("#<?php echo $this->campoSeguro('sede') ?>").change(function () {

        if ($("#<?php echo $this->campoSeguro('sede') ?>").val() != '') {
            consultarDependencia();
        } else {
            $("#<?php echo $this->campoSeguro('dependencia_solicitante') ?>").attr('disabled', '');
        }

    });

    function consultarDependencia(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinalDependencia ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('sede') ?>").val()},
            success: function (data) {



                if (data[0] != " ") {

                    $("#<?php echo $this->campoSeguro('dependencia_solicitante') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('dependencia_solicitante') ?>");
                    $.each(data, function (indice, valor) {

                        $("<option value='" + data[ indice ].ESF_CODIGO_DEP + "'>" + data[ indice ].ESF_DEP_ENCARGADA + "</option>").appendTo("#<?php echo $this->campoSeguro('dependencia_solicitante') ?>");

                    });

                    $("#<?php echo $this->campoSeguro('dependencia_solicitante') ?>").removeAttr('disabled');

                    $('#<?php echo $this->campoSeguro('dependencia_solicitante') ?>').width(350);
                    $("#<?php echo $this->campoSeguro('dependencia_solicitante') ?>").select2();



                }


            }

        });
    }
    ;

    //--------------Fin JavaScript y Ajax Sede y Dependencia elemento --------------------------------------------------------------------------------------------------   




function resetIva(elem, request, response){
	  $.ajax({
	    url: "<?php echo $urlFinaliva?>",
	    dataType: "json",
	    success: function(data){ 




	        if(data[0]!=" "){

	            $("#<?php echo $this->campoSeguro('iva')?>").html('');
	            $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('iva')?>");
	            $.each(data , function(indice,valor){

	            	$("<option value='"+data[ indice ].id_iva+"'>"+data[ indice ].descripcion+"</option>").appendTo("#<?php echo $this->campoSeguro('iva')?>");
	            	
	            });
	            
	            
	            $('#<?php echo $this->campoSeguro('iva')?>').width(150);
	            $("#<?php echo $this->campoSeguro('iva')?>").select2();
	            
	          
	            
		        }
	    			

	    }
		                    
	   });
	};




function numero_orden(elem, request, response){
	  $.ajax({
	    url: "<?php echo $urlFinalNumeroOrden?>",
	    dataType: "json",
	    data: { valor1:$("#<?php echo $this->campoSeguro('tipo_orden')?>").val(),valor2: $("#<?php echo $this->campoSeguro('unidad_ejecutora_hidden') ?>").val()},
	    success: function(data){ 




	        if(data[0]!=" "){

	            $("#<?php echo $this->campoSeguro('numero_orden')?>").html('');
	            $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('numero_orden')?>");
	            $.each(data , function(indice,valor){

	            	$("<option value='"+data[ indice ].value+"'>"+data[ indice ].orden+"</option>").appendTo("#<?php echo $this->campoSeguro('numero_orden')?>");
	            	
	            });
	            

	            $("#<?php echo $this->campoSeguro('numero_orden')?>").removeAttr('disabled');
	          
	            
		        }
	    			

	    }
		                    
	   });
	};


function consultarDependenciaConsultada(elem, request, response){
	  $.ajax({
	    url: "<?php echo $urlFinal16?>",
	    dataType: "json",
	    data: { valor:$("#<?php echo $this->campoSeguro('sedeConsulta')?>").val()},
	    success: function(data){ 
             if(data[0]!=" "){

	            $("#<?php echo $this->campoSeguro('dependenciaConsulta')?>").html('');
	            $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('dependenciaConsulta')?>");
	            $.each(data , function(indice,valor){

	            	$("<option value='"+data[ indice ].id_dependencia+"'>"+data[ indice ].ESF_DEP_ENCARGADA+"</option>").appendTo("#<?php echo $this->campoSeguro('dependenciaConsulta')?>");
	            	
	            });
	            
	            $("#<?php echo $this->campoSeguro('dependenciaConsulta')?>").removeAttr('disabled');
	            
	            $('#<?php echo $this->campoSeguro('dependenciaConsulta')?>').width(300);
	            $("#<?php echo $this->campoSeguro('dependenciaConsulta')?>").select2();
	            
	          
	            
		        }
	    			

	    }
		                    
	   });
	};



function tipo_bien(elem, request, response){
	  $.ajax({
	    url: "<?php echo $urlFinal?>",
	    dataType: "json",
	    data: { valor:$("#<?php echo $this->campoSeguro('nivel')?>").val()},
	    success: function(data){ 


	    			$("#<?php echo $this->campoSeguro('id_tipo_bien')?>").val(data[0]);
	    			$("#<?php echo $this->campoSeguro('tipo_bien')?>").val(data[1]);

	    			  switch($("#<?php echo $this->campoSeguro('id_tipo_bien')?>").val())
	    	            {
	    	                           
	    	                
	    	                case '2':


	    	                    $("#<?php echo $this->campoSeguro('devolutivo')?>").css('display','none');
	    	                    $("#<?php echo $this->campoSeguro('consumo_controlado')?>").css('display','block');   
                                    $("#<?php echo $this->campoSeguro('cantidad')?>").val('1');
                                    $('#<?php echo $this->campoSeguro('cantidad')?>').attr('disabled','');

	    	                break;
	    	                
	    	                case '3':

	    	                    $("#<?php echo $this->campoSeguro('devolutivo')?>").css('display','block');
	    	                    $("#<?php echo $this->campoSeguro('consumo_controlado')?>").css('display','none');
	    	                    $("#<?php echo $this->campoSeguro('tipo_poliza')?>").select2();
	    	                    $("#<?php echo $this->campoSeguro('cantidad')?>").val('1');
                                    $('#<?php echo $this->campoSeguro('cantidad')?>').attr('disabled','');
	    	                    
	    	                break;
	    	                                
	    	           
	    	                break;
	    	                

	    	                default:

	    	                    $("#<?php echo $this->campoSeguro('devolutivo')?>").css('display','none');
	    	                    $("#<?php echo $this->campoSeguro('consumo_controlado')?>").css('display','none');   
	    	                    
	    	                 
	    	                 $("#<?php echo $this->campoSeguro('cantidad')?>").val('');
	    	                 $('#<?php echo $this->campoSeguro('cantidad')?>').removeAttr('disabled');
	    	                 
	    	                break;
	    	                
	    	                }






	    			

	    }
		                    
	   });
	};


$(function() {


    $("#<?php echo $this->campoSeguro('sedeConsulta')?>").change(function(){
    	if($("#<?php echo $this->campoSeguro('sedeConsulta')?>").val()!=''){
    		consultarDependenciaConsultada();
		}else{
			$("#<?php echo $this->campoSeguro('dependenciaConsulta')?>").attr('disabled','');
			}

	      });
    

    $( "#<?php echo $this->campoSeguro('nitproveedor')?>" ).keyup(function() {

    	
	$('#<?php echo $this->campoSeguro('nitproveedor') ?>').val($('#<?php echo $this->campoSeguro('nitproveedor') ?>').val());

	
        });




    $("#<?php echo $this->campoSeguro('nitproveedor') ?>").autocomplete({
    	minChars: 3,
    	serviceUrl: '<?php echo $urlProveedorFiltro; ?>',
    	onSelect: function (suggestion) {
        	
    	        $("#<?php echo $this->campoSeguro('id_proveedor') ?>").val(suggestion.data);
    	    }
                
    });
    
	

	
    $("#<?php echo $this->campoSeguro('nivel')?>").change(function() {
    	
		if($("#<?php echo $this->campoSeguro('nivel')?>").val()!=''){

			tipo_bien();	

		}else{}


		

		

		

 });




    $("#<?php echo $this->campoSeguro('tipo_orden')?>").change(function() {
    	
		if($("#<?php echo $this->campoSeguro('tipo_orden')?>").val()!=''){

			numero_orden();	

		}else{}


    });
  
    
});

</script>

