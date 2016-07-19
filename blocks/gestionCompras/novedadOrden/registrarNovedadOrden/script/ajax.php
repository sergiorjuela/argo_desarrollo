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
$cadenaACodificar .= "&funcion=NumeroSolicitud";
$cadenaACodificar .= "&usuario=".$_REQUEST['usuario'];
$cadenaACodificar .="&tiempo=".$_REQUEST['tiempo'];


// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar, $enlace );

// URL definitiva
$urlVigencia= $url . $cadena;



// Variables
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar .= "&funcion=consultaContrato";
$cadenaACodificar .= "&usuario=".$_REQUEST['usuario'];
$cadenaACodificar .="&tiempo=".$_REQUEST['tiempo'];


// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar, $enlace );

// URL definitiva
$urlVigenciaContrato= $url . $cadena;


// Variables
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar .= "&funcion=consultaContratista";
$cadenaACodificar .= "&usuario=".$_REQUEST['usuario'];
$cadenaACodificar .="&tiempo=".$_REQUEST['tiempo'];


// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar, $enlace );

// URL definitiva
$urlContratista= $url . $cadena;



?>
<script type='text/javascript'>



function NumeroSolicitud(elem, request, response){
	  $.ajax({
	    url: "<?php echo $urlVigencia?>",
	    dataType: "json",
	    data: { valor:$("#<?php echo $this->campoSeguro('vigencia')?>").val()},
	    success: function(data){ 




	        if(data[0]!=" "){

	            $("#<?php echo $this->campoSeguro('num_solicitud')?>").html('');
	            $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('num_solicitud')?>");
	            $.each(data , function(indice,valor){

	            	$("<option value='"+data[ indice ].id +"'>"+data[ indice ].descripcion+"</option>").appendTo("#<?php echo $this->campoSeguro('num_solicitud')?>");
	            	
	            });
	            
	            
	            $('#<?php echo $this->campoSeguro('num_solicitud')?>').width(150);
	            $("#<?php echo $this->campoSeguro('num_solicitud')?>").select2();
	            $("#<?php echo $this->campoSeguro('num_solicitud')?>").removeAttr('disabled');
	            
	          
	            
		        }
	    			

	    }
		                    
	   });
	};

	$(function () {

		 		$( "#<?php echo $this->campoSeguro('vigencia_contrato')?>" ).keyup(function() {
				$('#<?php echo $this->campoSeguro('vigencia_contrato') ?>').val($('#<?php echo $this->campoSeguro('vigencia_contrato') ?>').val().toUpperCase());
				
			        });

				 $("#<?php echo $this->campoSeguro('vigencia_contrato') ?>").autocomplete({
			    	minChars: 2,
			    	serviceUrl: '<?php echo $urlVigenciaContrato; ?>',
			    	onSelect: function (suggestion) {
			        	
			    	        $("#<?php echo $this->campoSeguro('id_contrato') ?>").val(suggestion.data);
			    	    }
			                
			    });



						 $("#<?php echo $this->campoSeguro('contratista') ?>").autocomplete({
					    	minChars: 3,
					    	serviceUrl: '<?php echo $urlContratista; ?>',
					    	onSelect: function (suggestion) {
					        	
					    	        $("#<?php echo $this->campoSeguro('id_contratista') ?>").val(suggestion.data);
					    	    }
					                
					    });
						 


		});

</script>

