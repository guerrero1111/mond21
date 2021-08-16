<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registro extends CI_Controller { 

	public function __construct(){  
		parent::__construct();

		$this->load->model('admin/modelo', 'modelo'); 
		$this->load->model('registros', 'modelo_registro'); 
		$this->load->model('admin/catalogo', 'catalogo');  
		$this->load->library(array('email')); 
		$this->tiempo_comienzo      = "0:10";
		$this->total_fichas = 91;
		$this->cant_fichas = 91;
		$this->modelo_fichas = 4;
		//$this->cant_repetir      = 1;  //cantidad minima a repetir

	}




	// function correo(){  

	// 	$this->load->library('email');

	// 	$this->email->from('info@promoscasaley.com.mx', 'Promos Casa Ley');
	// 	$this->email->to('osmel.calderon@gmail.com');
		
	// 	$this->email->subject('Email Test');
	// 	$this->email->message('Testing the email class.');

	// 	if ($this->email->send()) 
	// 	{
	// 		echo 'ok' ;
	// 	}
	// 	else {
	// 		echo 'bad';
	// 	}


	// }	

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////registro Usuario/////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


 // Creación de un jugador
	function nuevo_registro(){
		if($this->session->userdata('session_participante') === TRUE ){   //si esta logueado  ir al home
				  redirect('');
		} else {  //nuevo registro
			  //$data['premios']   = $this->catalogo->listado_premios();
			  $data['estados']   = $this->modelo_registro->listado_estadosregistro();
			  $this->load->view( 'registros/registro',$data );   
		}    
	}


//validar la creacion del nuevo jugador
function validar_registros(){
		if ($this->session->userdata('session_participante') == TRUE) {
			redirect('');
		} else {
			
				
			

			$this->form_validation->set_rules( 'nombre', 'Nombre', 'trim|required|callback_nombre_valido|min_length[3]|max_length[50]|xss_clean');
			$this->form_validation->set_rules( 'apellidos', 'Apellido(s)', 'trim|required|callback_nombre_valido|min_length[3]|max_length[50]|xss_clean');
			$this->form_validation->set_rules( 'email', 'Correo', 'trim|valid_email|xss_clean');
			$this->form_validation->set_rules( 'fecha_nac', 'Fecha de Nacimiento', 'trim|required|callback_valid_nacimiento[fecha_nac]|xss_clean');
			$this->form_validation->set_rules( 'calle', 'Calle', 'trim|required|min_length[3]|max_length[100]|xss_clean');
			$this->form_validation->set_rules( 'numero', 'Número', 'trim|required|min_length[1]|max_length[100]|xss_clean');
			$this->form_validation->set_rules( 'colonia', 'Colonia', 'trim|required|min_length[3]|max_length[100]|xss_clean');
			$this->form_validation->set_rules( 'municipio', 'Municipio', 'trim|required|min_length[3]|max_length[100]|xss_clean');
			
			$this->form_validation->set_rules( 'cp', 'CP', 'trim|required|min_length[2]|max_length[100]|xss_clean');

			//$this->form_validation->set_rules( 'id_estado', 'Ciudad', 'required|callback_valid_option|xss_clean');

			$this->form_validation->set_rules( 'ciudad', 'Ciudad', 'trim|required|min_length[2]|max_length[100]|xss_clean');

			//$this->form_validation->set_rules('id_estado', 'Ciudad', 'required|callback_valid_option|xss_clean');

			$this->form_validation->set_rules( 'celular', 'Celular', 'trim|required|numeric|min_length[10]|callback_valid_phone|xss_clean');
			$this->form_validation->set_rules( 'telefono', 'Teléfono', 'trim|numeric|min_length[8]|callback_valid_phone|xss_clean');
			$this->form_validation->set_rules( 'id_estado_compra', 'Estado', 'required|callback_valid_option|xss_clean');
			$this->form_validation->set_rules( 'nick', 'Usuario', 'trim|required|min_length[3]|max_length[50]|callback_cadena_noacepta|xss_clean');
			$this->form_validation->set_rules( 'pass_1', 'La contraseña', 'required|trim|min_length[8]|xss_clean');
			$this->form_validation->set_rules( 'pass_2', 'Confirmación de contraseña', 'required|trim|min_length[8]|xss_clean');

			$this->form_validation->set_rules('coleccion_id_aviso', 'Bases legales', 'callback_accept_terms[coleccion_id_aviso]');	
			$this->form_validation->set_rules('coleccion_id_base', 'Aviso de privacidad', 'callback_accept_terms[coleccion_id_base]');	
		

			$mis_errores=array(
					"exito" => false,
					"general" => '',

				    "nombre" =>  '',
				    "apellidos" =>  '',
				    "email" =>  '',
				    "fecha_nac" =>  '',
				    "calle" =>  '',
				    "numero" =>  '',
				    "colonia" =>  '',
				    "municipio" =>  '',

				    "cp" =>  '',
				    "ciudad" =>  '',
				    "celular" =>  '',
				    "telefono" =>  '',
				    "id_estado_compra" =>  '',
					"nick" =>  '',
				    'pass_1'=> '',
				    'pass_2'=>  '',

				    "coleccion_id_aviso" =>  '',
				    "coleccion_id_base" =>  '',
			);
		


		if ($this->form_validation->run() === TRUE){

				if ($this->input->post( 'pass_1' ) === $this->input->post( 'pass_2' ) ){
					$data['nick']   				= $this->input->post( 'nick' );
					$data 				= 	$this->security->xss_clean($data);  
					$login_check = $this->modelo_registro->check_nick_existente($data);
					

					if ( $login_check != FALSE ){		
						$usuario['nombre']   			= $this->input->post( 'nombre' );
						$usuario['apellidos']   		= $this->input->post( 'apellidos' );
						$usuario['email']   			= $this->input->post( 'email' );
						$usuario['fecha_nac']   		= $this->input->post( 'fecha_nac' );
						$usuario['calle']   			= $this->input->post( 'calle' );
						$usuario['numero']   			= $this->input->post( 'numero' );
						$usuario['colonia']   			= $this->input->post( 'colonia' );
						$usuario['municipio']   		= $this->input->post( 'municipio' );
						
						$usuario['cp']   					= $this->input->post( 'cp' );
						$usuario['ciudad']   			= $this->input->post( 'ciudad' );
						$usuario['celular']   				= $this->input->post( 'celular' );
						$usuario['telefono']   				= $this->input->post( 'telefono' );
						$usuario['contrasena']				= $this->input->post( 'pass_1' );
						$usuario['id_estado_compra']   		= $this->input->post( 'id_estado_compra' );
						$usuario['nick']   					= $this->input->post( 'nick' );

						$usuario['id_perfil']   		= 3; //significa participante

						$usuario 						= $this->security->xss_clean( $usuario );
						$guardar 						= $this->modelo_registro->anadir_registro( $usuario );

						
						if ( $guardar !== FALSE ){  




									if  ($usuario['email']) {  //si tiene email q envie correo
									
										$dato['email']   			    = $usuario['email'];   			
										$dato['contrasena']				= $usuario['contrasena'];				
										$dato['nombre']   			    = $usuario['nombre'];   			
										$dato['apellidos']				= $usuario['apellidos'];
										$dato['celular']   			    = $usuario['celular'];   			
										$dato['telefono']				= $usuario['telefono'];
										$dato['nick']   			    = $usuario['nick'];  

										$this->load->library('email');
										//envio de correo para notificar alta en usuarios del sistema
										
										$esp_nuevo = $usuario['email'];
										$this->email->from('admin@promoscasaley.com.mx', 'Promos Casaley');
										$this->email->to( $esp_nuevo );
										$this->email->subject('Registro en la promoción de Llevate un buen sabor'); //.$this->session->userdata('c2')
										$this->email->message( $this->load->view('admin/correos/alta_usuario', $dato, TRUE ) );
										$this->email->send();

									}


									//checar el loguin y recoger datos de usuario registrado
									$login_checkeo = $this->modelo_registro->check_login_nick($usuario);
									//agrega al historico de acceso de participantes
									$this->modelo_registro->anadir_historico_acceso($login_checkeo[0]);  

									$this->session->set_userdata('session_participante', TRUE);
									
									if (is_array($login_checkeo))  //si existe el usuario
										foreach ($login_checkeo as $element) {
											$this->session->set_userdata('id_participante', $element->id);
											$this->session->set_userdata('nombre_participante', $element->nombre.' '.$element->apellidos);
											$this->session->set_userdata('nick_participante', $element->nick);
											$this->session->set_userdata('tarjeta_participante', '');
											$this->session->set_userdata('juego_participante', '');
											
										}


										//cantidad de ; para saber a donde redirigir
										$mis_errores['redireccion'] = 'registro_ticket';	
										
										$mis_errores['exito'] = true;	



						
					} else {  //if ( $guardar !== FALSE ){  
						
								 	 
							 
						
					}
				} else { //if ( $login_check != FALSE ){
					
					$mis_errores["general"] = '<span class="error">El <b>Usuario</b> ya se encuentra registrado.</span>';		 	
							 
						
					
				}
			} else {	//if ($this->input->post( 'pass_1' ) === $this->input->post( 'pass_2' ) ){		
				
					$mis_errores["general"] = '<span class="error">No coinciden la Contraseña </b> y su <b>Confirmación</b> </span>';


		} ////if ($this->form_validation->run() === TRUE){

			//$mis_errores = true;


	} //fin del else if ($this->session->userdata('session_participante') == TRUE) {


//tratamiento de errores
				$error = validation_errors();
				
				$errores = explode("<b class='requerido'>*</b>", $error);
				$campos = array(
				    "nombre" => 'Nombre',
				    "apellidos" => 'Apellido(s)',
				    "email" => 'Correo',
				  	"fecha_nac" => 'Fecha de Nacimiento',  
				  	"calle" => 'Calle',
				    "numero" => 'Número',
				    "colonia" => 'Colonia',
				    "municipio" => 'Municipio',

					"cp" => 'CP',
					"ciudad" => 'Ciudad',
					"celular" => 'Celular',
					"telefono" => 'Teléfono',
					"id_estado_compra" =>  'Estado',
					"nick" => 'Usuario',
				    'pass_1'=>'La Contraseña',
				    'pass_2'=>'Confirmación',
				    
				    "coleccion_id_aviso" => 'Aviso de privacidad',
				    "coleccion_id_base" => 'Bases legales',
				    
				);




				    foreach ($errores as $elemento) {
				    	//echo $elemento.'<br/>';
						foreach ($campos as $clave => $valor) {
								
						        if (stripos($elemento, $valor) !== false) {
						        	if  ($valor=="requerido") {
						         		$mis_errores[$clave] = $elemento; //condiciones
						        	} else {
						        		$mis_errores[$clave] = '*';
						        	}						

						        	$mis_errores[$clave] = substr($elemento, 0, -5);   //condiciones 	
						        }
						}    	
				    }
				    
			}

			echo json_encode($mis_errores);
			

}		



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////logueo Usuario/////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


  //loguandose el usuario
 function ingresar_usuario(){
		if ($this->session->userdata( 'session_participante' ) == TRUE )    { //ya esta registrado
			 //self::configuraciones_imagenes(false);
			 redirect('/registro_ticket');
		} else {
			self::configuraciones_imagenes(false);
			$this->load->view( 'registros/login');
		}
 }




 	//validando el logueo del usuario
	function validar_login_participante(){
				$mis_errores=array(
					"exito" => false,
				    "nick" => '',
				    "contrasena" => '',
				    'general'=> '',
				);

		$this->form_validation->set_rules( 'nick', 'Usuario', 'trim|required|min_length[3]|max_length[50]|callback_cadena_noacepta|xss_clean');
		$this->form_validation->set_rules( 'contrasena', 'Contraseña', 'required|trim|min_length[8]|xss_clean');

		if ( $this->form_validation->run() == TRUE ){
				$data['nick']		=	$this->input->post('nick');
				$data['contrasena']		=	$this->input->post('contrasena');
				$data 				= 	$this->security->xss_clean($data);  

				$login_checkeo = $this->modelo_registro->check_login_nick($data);
				
				if ( $login_checkeo != FALSE ){

					$this->modelo_registro->anadir_historico_acceso($login_checkeo[0]);  //agrega al historico de acceso de participantes

					$this->session->set_userdata('session_participante', TRUE);
					$this->session->set_userdata('nick_participante', $data['nick'] );


					if (is_array($login_checkeo))  //si existe el usuario
						foreach ($login_checkeo as $element) {
							$this->session->set_userdata('id_participante', $element->id);
							$this->session->set_userdata('nombre_participante', $element->nombre.' '.$element->apellidos);
							$this->session->set_userdata('tarjeta_participante', '');
							$this->session->set_userdata('juego_participante', '');
						}					

										
					//cantidad de ; para saber a donde redirigir
					$mis_errores['redireccion'] = 'registro_ticket';	

					
					

					$mis_errores['exito'] = true;	
				} else {
					//$mis_errores['exito'] = true;	
					$mis_errores["general"] = '<span class="error">Tus datos no son correctos, verificalos e intenta nuevamente por favor.</span>';
				}
		} else {		
				//tratamiento de errores
				$error = validation_errors();
				$errores = explode("<b class='requerido'>*</b>", $error);
				$campos = array(
				    "nick" => 'Usuario',
				    "contrasena" => 'Contraseña',
				);
				    foreach ($errores as $elemento) {

						foreach ($campos as $clave => $valor) {
							
						        if (stripos($elemento, $valor) !== false) {
						        	if  ($valor=="Requerido") {
						         		$mis_errores[$clave] = $elemento; //condiciones
						        	} else {
						        		$mis_errores[$clave] = '*';
						        	}						

						        	$mis_errores[$clave] = substr($elemento, 0, -5);   //condiciones 	
						        }
						}    	
				    }

		}	

		echo json_encode($mis_errores);
		
	}	



	function recuperar_participante(){ //NO FUNCIONA ERA PARA RECUPERAR CONTRASEÑA
		$this->load->view('registros/recuperar_password');
	}
	

	
	function validar_recuperar_participante(){  //NO FUNCIONA ERA PARA RECUPERAR CONTRASEÑA
		$mis_errores=array(
				    'general'=> '',
				    'exito' =>false,
		);

		$this->form_validation->set_rules( 'email', 'Email', 'trim|required|valid_email|xss_clean');

		if ( $this->form_validation->run() == FALSE ){
			$mis_errores["general"] =  validation_errors('<span class="error">','</span>');

		} else {
				$data['email']		=	$this->input->post('email');
				$correo_enviar      =   $data['email'];
				$data 				= 	$this->security->xss_clean($data);  
				$usuario_check 		=   $this->modelo_registro->recuperar_contrasena($data);
				$correocasaley      =  'promociones@radioley.com';  
				if ( $usuario_check != FALSE ){
						$data= $usuario_check[0]; 	
						//$desde = $this->session->userdata('c1');
						
						$this->email->from('admin@promoscasaley.com.mx', 'Promos Casa Ley');
						$this->email->to($correo_enviar,$correocasaley);
						$this->email->subject('Recuperación de contraseña de Promos Casa Ley');
						$this->email->message($this->load->view('registros/correos/envio_contrasena', $data, true));
						
						if ($this->email->send()) {
						
							//$mis_errores = true;	
							$mis_errores['exito'] = true;
							$mis_errores['redireccion'] = 'ingresar_usuario';
						
						} else 
							//$mis_errores = false;
							$mis_errores["general"] = '<span class="error">Su correo no ha podido salir, error conexión.</span>';
				} else {
					//echo '<span class="error">Tus datos no son correctos, verificalos e intenta nuevamente por favor.</span>';
					$mis_errores["general"] = '<span class="error">Tus datos no son correctos, verificalos e intenta nuevamente por favor.</span>';
				}
		}

		echo json_encode($mis_errores);
	}		



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////ticket/////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



public function getModulo11($str) {
        $p = 0;
        $cont=0;
        $suma =0;
        for ($i = strlen($str)-1; $i >= 0; $i--) {
            $c = $str[$i];
            $p = (($cont % 7)==0) ? ($cont % 7)+2 : ($cont % 7)+1;
            $suma = $suma+($c*$p);
            $cont = (($cont % 7)==0) ? $cont+2 : $cont+1;
           // echo  $c.'*'.$p.'<br/>';
        }
        //echo "SUM: ".$suma.'<br/>';
        $modulo = $suma % 11;
        //echo "RES: ".$modulo.'<br/>';
       // echo "MOD11: ".(11-$modulo).'<br/>';
        $digito_control = ((11-$modulo)<10) ? (11-$modulo) : ( ((11-$modulo)==10) ? 1 : 0);
        
        return $digito_control;
}

/*

 $objeto = new Desencriptando();

    echo "DV: ".$objeto->getModulo11("031"); //11 -> 0 -> 11 -> 0
    //echo $objeto->getModulo11("118"); //23 -> 1 -> 10 -> 1
    //echo $objeto->getModulo11("001");  //2 -> 2 -> 9 -> 9
    //echo "DV: ".$objeto->getModulo11("123456789123456");
*/


function validando_encriptado($data){
	 $ticket=str_replace(" ", "", $data["ticket"]);
	 $cadena=str_replace(" ", "", '2424 3535 2424 3535 2424 353');
	 $llave=7585;
	 $primer_num=intval(substr($data["folio"], 0, 4)); //los 4primeros
	 

	 $segundo_num=substr($data["folio"],  -4); ////los 4ultimos

	 $str = substr($segundo_num, 0, 3); //los 3 primeros
	 //echo $str; die;
	 $digito_comparar = intval(substr($segundo_num,  -1)); //ultimo
	 //multiplicando por la cadena
	  $suma=0;
	  $total=0;
	
	 for  ($i = 0; $i < strlen($ticket); $i++){
	 	    $suma=$suma+intval($cadena[$i])*intval($ticket[$i]);
	 }	

	 $total = $suma+$llave;  //7583+235=7818 0019

	 //segundo analisis con mod11 

	 $digito_control=self::getModulo11($str);

	 return  ($total==$primer_num) && ($digito_control==$digito_comparar); 
	 //2248 1012 2417 4500 3302 167
	 //7818 0019

	 //substr('abcdef', 0, 4);
	 //substr("abcdef", -4); 

}


function conformar_folio($data){
	  $ticket=str_replace(" ", "", $data["ticket"]);
         $cadena=str_replace(" ", "", '2424 3535 2424 3535 2424 353');
         $llave=7585;
          $suma=0;
          $total=0;
        
         for  ($i = 0; $i < strlen($ticket); $i++){
                $suma=$suma+intval($cadena[$i])*intval($ticket[$i]);
         }  
         $total = $suma+$llave;  
         return  ((string)$total)."0019"; 

}



   function registro_ticket(){
  		if($this->session->userdata('session_participante') === TRUE ){
  			if ($this->session->userdata('registro_ticket')) {
  					redirect('/tarjetas');
  			} else {
  				$data['estados']   = $this->modelo_registro->listado_estados();
  				$this->load->view( 'tickes/dashboard_ticket',$data );
  			}
		  			
		}
		else { 
			
		  redirect('');
		}	
	}





function validar_tickets(){
		if ($this->session->userdata('session_participante') == FALSE) {
			redirect('');
		} else {

			$this->session->set_userdata('new_ticket', '' );
			$this->session->set_userdata('new_folio', '' );
			$this->session->set_userdata('new_compra', 0 );
			$this->session->set_userdata('new_total', 0 );

			$mis_errores=array(
				    "monto" => '',
				    "ticket" => '',
				    "compra" => '',
				    "id_ciudad_compra" => '',
 					"folio" => '',
				    "folio2" => '',				    
				    'general'=> '',
			);

			$ticket['tipo']			=	$this->input->post('tipo'); 

			$this->form_validation->set_rules( 'ticket', 'Núm de Ticket', 'trim|required|min_length[28]|min_length[28]|xss_clean');	//numeric|
			$this->form_validation->set_rules( 'monto', 'Monto de la compra', 'trim|required|numeric|min_length[1]|max_length[20]|xss_clean|greater_than[29]');				
			$this->form_validation->set_rules( 'compra', 'Fecha de Compra', 'trim|required|callback_valid_fecha[compra]|xss_clean');

			$this->form_validation->set_rules( 'id_ciudad_compra', 'Ciudad de compra', 'required|callback_valid_option|xss_clean');
		    if ($ticket['tipo']=='folio2') { //7carac
				$this->form_validation->set_rules( 'folio2', 'Núm de folio', 'trim|required|min_length[7]|max_length[7]|xss_clean');	//numeric|	
			} else {
				$this->form_validation->set_rules( 'folio', 'Núm de folio', 'trim|required|min_length[8]|max_length[8]|xss_clean');	//numeric|				
			}
			

		
			if ( ($this->form_validation->run() === TRUE)  ) {
					$ticket['ticket']			=	$this->input->post('ticket');					
					$ticket['folio']			=	($ticket['tipo']=='folio2') ? '7'.$this->input->post('folio2') : $this->input->post('folio');
					//$ticket['folio']			=	self::conformar_folio($ticket);
					
					//print_r($ticket['folio']); die;
					//($ticket['tipo']=='folio2') ? '7'.$this->input->post('folio2') : $this->input->post('folio');
					
					$ticket['compra']   		= $this->input->post( 'compra' );
					$ticket['monto']			= $this->input->post('monto');
					$ticket['id_ciudad_compra']   		= $this->input->post( 'id_ciudad_compra' );
					$ticket 				= 	$this->security->xss_clean($ticket);  

					// Validacion del ticket. Si cumple con los 2   
					//2248 1012 2417 4500 3302 167	//7818 0019
					$validacion_tickets = self::validando_encriptado($ticket);


				if ($validacion_tickets){ //validacion de la tarjeta


					// Aqui se debe verificar si ya el ticket fue registrado 
					//$cant_reg = $this->modelo_registro->check_tickets_existente($ticket);
					$cant_reg = $this->modelo_registro->check_tickets_existente_cero($ticket);
					//print_r($cant_reg);die;

					
					if (  ($cant_reg != FALSE) ) {	//si no existe ticket		 


						$ticket 						= $this->security->xss_clean( $ticket );
						$guardar 						= $this->modelo_registro->anadir_tickets( $ticket );


						if ( $guardar !== FALSE ){  //si guardo el ticket
			
									$this->session->set_userdata('new_ticket', $ticket['ticket'] );
									$this->session->set_userdata('new_folio',  $ticket['folio'] );
									$this->session->set_userdata('new_compra', $ticket['compra'] );
									$this->session->set_userdata('new_ciudad', $ticket['id_ciudad_compra'] );

									//indicar cantidad de ticket a jugar
									$this->session->set_userdata('cant_repetir', $cant_reg-1);
									//$this->session->set_userdata('new_total', $cant_reg );
									
									//indicar numero de ticket registrado				
									$this->session->set_userdata('num_ticket_participante', $ticket['ticket']);
									//indicar que ya registro su ticket						
									$this->session->set_userdata('registro_ticket', TRUE );
									 $this->session->set_userdata('abriendo_face', false );


									//tiempo comienzo
									//$this->session->set_userdata('comenzar', 0);



									



									/*
									//el valor que tiene en bd la tarjeta que se quedo cuando se cerro la session
									$this->session->set_userdata('tarjeta_participante', $element->tarjeta);
									$this->session->set_userdata('juego_participante', $element->juego);

									if   ( ( substr_count($element->tarjeta,';') < $this->total_fichas) && ($element->tiempo_juego!='0:00') ) {
										$mis_errores['jugo'] = $element->tarjeta;	
									} else {
										$mis_errores['jugo'] = true;	
									}	

									//cantidad de ; para saber a donde redirigir
									if  ( substr_count($this->session->userdata('tarjeta_participante'),';')<5) {
										$mis_errores['redireccion'] = 'tarjetas';		
									} else if  ( strlen($this->session->userdata('juego_participante'))!=3){
										$mis_errores['redireccion'] = 'juegos';		
									} else {
										$mis_errores['redireccion'] = '';	
									}

									*/


									$mis_errores = true;	

						} else {  //if ( $guardar !== FALSE ){  
							$mis_errores["general"] = '<span class="error"><b>E01</b> - El nuevo ticket no pudo ser agregado</span>';
						}
					} else { //if ( ( $ticket_check != FALSE ) && ($cant_reg != FALSE) ) {			
						$mis_errores["general"] = '<span class="error">El <b>ticket</b> ya se encuentra registrado.</span>';
					}
				} else {  //if ($validacion_tickets){
					$mis_errores["general"] = '<span class="error">Su ticket no es válido</b> </span>';
				}
			} else { //if ( ($this->form_validation->run() === TRUE)  ) {	
				

	//tratamiento de errores
				$error = validation_errors();
				$errores = explode("<b class='requerido'>*</b>", $error);
				$campos = array(
				    "monto" => 'Monto de la compra',
				    "ticket" => 'Núm de Ticket',
				    "compra" => 'Fecha de Compra',
				    "id_ciudad_compra" => 'Ciudad de compra',
				    "folio" => 'Núm de Folio',
				    "folio2" => 'Núm de Folio',
				);

				    foreach ($errores as $elemento) {

						foreach ($campos as $clave => $valor) {
							
						        if (stripos($elemento, $valor) !== false) {
						        	if  ($valor=="Requerido") {
						         		$mis_errores[$clave] = $elemento; //condiciones
						        	} else {
						        		$mis_errores[$clave] = '*';
						        	}						

						        	$mis_errores[$clave] = substr($elemento, 0, -5);   //condiciones 	
						        }
						}    	
				    }

				    if ($mis_errores["ticket"] !='') {
				    	$mis_errores["ticket"] =  '<span class="error">Su ticket no es <b>válido</b> </span>';	
				    }
				    
				    if ($mis_errores["folio"] !='') {
				    	$mis_errores["folio"] =  '<span class="error">Folio no <b>válido</b> </span>';	
				    }

			}

		    if ($mis_errores===true) {  //solo si es correcto el ticket entonces lee las configuraciones y conforma imagenes
				self::configuraciones_imagenes(true);	
			}			
			
			echo json_encode($mis_errores);	

			
		}
		
	}


//ver
public function proc_modal_reintentar(){
	
		  if ( $this->session->userdata('session_participante') !== TRUE ) {
		      redirect('');
		    } else {
			   $this->session->set_userdata('cant_repetir', ((int)$this->session->userdata( 'cant_repetir' ))-1 );	
			   $this->session->set_userdata('tiempo', $this->tiempo_comienzo);		


			   		//agregar nuevamente ticket con folio
					$ticket['ticket']= $this->session->userdata('new_ticket');
					$ticket['folio']= $this->session->userdata('new_folio');
					$ticket['compra']= $this->session->userdata('new_compra');
					$ticket['monto']= $this->session->userdata('monto');
					$ticket['id_ciudad_compra']= $this->session->userdata('new_ciudad');
					$ticket 				= 	$this->security->xss_clean($ticket);  
					$guardar 						= $this->modelo_registro->anadir_tickets( $ticket );

					self::configuraciones_imagenes(true);

			   //$this->session->set_userdata('comenzar', 0);	
               $this->load->view( 'tickes/modal_reintentar_jugar' );
		   }   			

}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////instrucciones despues q registre el ticket//////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


 
 public function proc_modal_instrucciones(){
		  if ( $this->session->userdata('session_participante') !== TRUE ) {
		      redirect('');
		    } else {
		      
               $this->load->view( 'juegos/modal_instrucciones' );
		   }   			
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	public function desconectar_participante(){
		$this->session->sess_destroy();
		redirect('');
	}	

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



	public function configuraciones_imagenes($booleano){
			    $configuraciones = $this->modelo_registro->listado_imagenes();
					if ( $configuraciones != FALSE ){
					if (is_array($configuraciones)){
						$this->session->set_userdata('cantimagen', count($configuraciones) ) ;	
						foreach ($configuraciones as $configuracion) {
							$this->session->set_userdata('i'.$configuracion->id, $configuracion->valor);
							$this->session->set_userdata('ip'.$configuracion->id, $configuracion->puntos);
							$this->session->set_userdata('ipor'.$configuracion->id, $configuracion->porciento);
						}

					}
				} 
						
						//cuando entra 3 posibilidades de barajear
						$this->session->set_userdata('numImage', count($configuraciones) );  //para poder ir descontando imagenes

						//tiempo comienzo
						$this->session->set_userdata('tiempo', $this->tiempo_comienzo);  //para poder ir descontando tiempo "1:00"

						if ($booleano) {
					        $cant_fichas=$this->total_fichas; //90
					        $cant_caritas= $this->modelo_fichas; //5
					        
					        $total = 0;	
					        for ($i = 1; $i <= $cant_caritas; $i++) {
						            $carita[$i] =  $this->session->userdata('ipor'.$i);
						            $porciento[$i]=($carita[$i]*$cant_fichas)/100;
						            $total = $total + $porciento[$i];
						    }   
					        
					        for ($i = 1; $i <= $total; $i++) {
					            $misdatos[]=$i;
					        }   

					        shuffle($misdatos);


					        // foreach ($misdatos as $key => $i) {  //dinamizar esto
					        //     $cara[]=($i<=$porciento[1])  ?  1 : ($i<=$porciento[1]+$porciento[2] ? 2 : ($i<=$porciento[1]+$porciento[2]+ $porciento[3] ? 3 : ($i<=$porciento[1]+$porciento[2]+ $porciento[3]+ $porciento[4] ? 4 : ($i<=$porciento[1]+$porciento[2]+ $porciento[3]+ $porciento[4]+ $porciento[5] ? 5 : 6 )));
					        // }

					        foreach ($misdatos as $key => $i) {  
					            $cara[]=($i<=$porciento[1])  ?  1 : ($i<=$porciento[1]+$porciento[2] ? 2 : ($i<=$porciento[1]+$porciento[2]+$porciento[3] ? 3 : ($i<=$porciento[1]+$porciento[2]+$porciento[3]+$porciento[4] ? 4 : ($i<=$porciento[1]+$porciento[2]+$porciento[3]+$porciento[4]+$porciento[5] ? 5 : ($i<=$porciento[1]+$porciento[2]+$porciento[3]+$porciento[4]+$porciento[5]+$porciento[6] ? 6 : ($i<=$porciento[1]+$porciento[2]+$porciento[3]+$porciento[4]+$porciento[5]+$porciento[6]+$porciento[7] ? 7 : ($i<=$porciento[1]+$porciento[2]+$porciento[3]+$porciento[4]+$porciento[5]+$porciento[6]+$porciento[7]+$porciento[8] ? 8 : ($i<=$porciento[1]+$porciento[2]+$porciento[3]+$porciento[4]+$porciento[5]+$porciento[6]+$porciento[7]+$porciento[8]+$porciento[9] ? 9 : ($i<=$porciento[1]+$porciento[2]+$porciento[3]+$porciento[4]+$porciento[5]+$porciento[6]+$porciento[7]+$porciento[8]+$porciento[9]+$porciento[10] ? 10 : 11 )))))))));
					        }

							$data['cara'] =  json_encode($cara); 

							 //orden de cara 1..5 (tipos de tarjetas)
							$data['misdatos'] =  json_encode($misdatos); //orden de  numeros que tocan de 1..90(maximo de tarjetas)
							
							//agregar las caras para un ticket y un folio de un determinado usuario
						
					        $checar         = $this->modelo_registro->agregar_datos( $data );

							//La pregunta					
								 
									$datos = $this->modelo_registro->listado_preguntas();

									$misdatos = array();
									foreach ($datos as $row) {
										$misdatos[]=$row->id;
									}	

									shuffle($misdatos);
									
									$this->session->set_userdata('pregunta', $misdatos[0] );
									
								



					    }    

	}

////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////	
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////



	 public function proc_modal_pregunta(){

		  if ( $this->session->userdata('session_participante') !== TRUE ) {
		      redirect('');
		    } else {
		      	$data['pregunta'] = $this->modelo_registro->get_preguntas();
		      	$data['acumulado'] = $this->modelo_registro->acumulado_puntos();
		      	
               $this->load->view( 'juegos/modal_pregunta',$data );
		   }   			
	}



//formato  fig+resp-tiempo;
	function respuesta_juego(){ 
		
		$data['respuesta'] =  $this->input->post( 'respuesta' );  //respuesta seleccionada
		$preg = $this->modelo_registro->get_preguntas();
		$data['responder'] = ($data['respuesta'] ==$preg->respuesta);  //si fue aceptada o no la respuesta seleccionada
		$acumulado = $this->modelo_registro->acumulado_puntos();

		$data['acumulado_pto'] = 0;
        if (($acumulado)) {  
                            foreach ($acumulado as $key => $value) {
                                $data['acumulado_pto']  = 
                                            ((int)$value->cant1)*$this->session->userdata('ip1') +
                                            ((int)$value->cant2)*$this->session->userdata('ip2') +
                                            ((int)$value->cant3)*$this->session->userdata('ip3') +
                                            ((int)$value->cant4)*$this->session->userdata('ip4') +
                                            ((int)$value->cant5)*$this->session->userdata('ip5');
                              }
        }           


        $data['acumulado_pto']  =  (int) $data['acumulado_pto'] + ( ((int) $data['acumulado_pto']) * ((int)$data['responder']) );

		
		//if guarda bien entonces
		$data 		  		= $this->security->xss_clean( $data );
		$guardar	 		= $this->modelo_registro->actualizar_respuesta_juego( $data );
		
		/*	
		if ( $guardar !== FALSE ){  
			$this->session->set_userdata('juego_participante', $data['formato']);
		}	
		*/
		

		$data['redireccion'] = 'record/'.$this->session->userdata('id_participante');	
		echo json_encode($data);        
		
                            
	}

////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////	
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////


//llama a la modal para presentar el facebook
 public function proc_modal_facebook(){ //nuevo
		  if ( $this->session->userdata('session_participante') !== TRUE ) {
		      redirect('');
		    } else {

				$data['total_puntos']	=   $this->modelo_registro->total_alcanzado();

		    	$this->session->set_userdata('abriendo_face', true );
		    	$data['total_facebook'] = $this->modelo_registro->total_facebook();
               $this->load->view( 'registros/modal_face',$data );
		   }   			
}

 
//Si comparte la modal
function registrar_facebook($puntos){ //nuevo
	if ( $this->session->userdata( 'session_participante' ) == TRUE ){
		
		$ticket['redes'] = (int) ($puntos);
		$ticket 						= $this->security->xss_clean( $ticket );
		$guardar 						= $this->modelo_registro->actualizar_facebook( $ticket );        	
		 
		redirect('/record/'.$this->session->userdata('id_participante'));
		//redirect('/tarjetas');

		//redirect('tarjetas');
	}	

}



//http://mamaypapa.dev.com/myp18/record/4f50675f-21b7-11e8-936e-a81e846a651f

function record($id_participante){
	if ( $this->session->userdata( 'session_participante' ) == TRUE ){

        

		//temporalmente porque esto va en la modal de facebook
		 $this->session->set_userdata('abriendo_face', false );
       $this->session->set_userdata('registro_ticket', false );
       $this->session->set_userdata('num_ticket_participante', '' );
       

       


		$datu['record']	=   $this->modelo_registro->record_personal();
		//print_r($datu['record']); die;
		$datu['detalles']	=   $this->modelo_registro->record_detalle();
//	print_r($datu['detalles']); die;

		$this->load->view( 'juegos/record',$datu );
	}	
}	

////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////

 public function compartir_imagen(){
		  if ( $this->session->userdata('session_participante') !== TRUE ) {
		      redirect('');
		    } else {
		      
               $this->load->view( 'imagen/imagen' );
		   }   			

}




 public function proc_modal_cero_puntos(){
		  if ( $this->session->userdata('session_participante') !== TRUE ) {
		      redirect('');
		    } else {
		    	//indicar que ya concluyo tarea con su ticket

		    	//actualizar ticket
				$data["num_ticket_participante"] =	$this->session->userdata( 'num_ticket_participante' );
				        $data["id_participante"] = $this->session->userdata( 'id_participante' );
				$data['total'] = 0;

				$data 						= $this->security->xss_clean( $data );
				$guardar 				    = $this->modelo_registro->actualizar_tickets( $data );

				//indicar que ya concluyo tarea con su ticket
				 $this->session->set_userdata('abriendo_face', false );
		       $this->session->set_userdata('registro_ticket', false );
               $this->load->view( 'tickes/modal_cero_puntos' );
		   }   			
}




function publico($puntos){
	if ( $this->session->userdata( 'session_participante' ) == TRUE ){
		
		$data["num_ticket_participante"] =	$this->session->userdata( 'num_ticket_participante' );
		        $data["id_participante"] = $this->session->userdata( 'id_participante' );

		$data['total'] = (int) ($puntos) ;

		$data 						= $this->security->xss_clean( $data );
		$guardar 				    = $this->modelo_registro->actualizar_tickets( $data );

		
        
		redirect('/record/'.$data["id_participante"]);
	}	

}	


function tabla_general(){
		$data["records"] 		=  $this->modelo_registro->record_general();
		$this->load->view( 'dashboard/tabla_general',$data );

}	




	public function num_conteo(){
		   if ( $this->session->userdata( 'session_participante' ) == TRUE ){
		   		$data['started']		=	$this->input->post('started');
		   		
		   		if  ( isset($_POST["started"]) ) {
		   			$this->session->set_userdata('numImage', $this->input->post('started') );
		   		} else {

		   			//no se establece 	numImage
		   		}

		   		// $data['cant_repetir']    = 	$this->session->userdata('cant_repetir'); 
		   		$data['tiempo'] = 	$this->session->userdata('tiempo'); 
		   		$data['tiempo_comienzo'] = $this->tiempo_comienzo; 
			   	$data['num'] = $this->session->userdata('numImage'); 

			   	//$data['registro_ticket'] = $this->session->userdata('registro_ticket'); 
			   	$this->session->set_userdata('tiempo', "0:00");
			   	echo  json_encode($data);
		   }	
			
    }	





    /*
		data.num
		data.registro_ticket
		data.tiempo
		data.tiempo_comienzo

    */

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function cadena_noacepta( $str ){
		$regex = "/(uefa|pepsi|champio)/i";
		if ( preg_match( $regex, $str ) ){			
			$this->form_validation->set_message( 'cadena_noacepta',"<b class='requerido'>*</b> La información introducida en <b>%s</b> no está permitida." );
			return FALSE;
		} else {
			return TRUE;
		}
	}



	function valid_fecha( $str, $campo ){
		if ($this->input->post($campo)){
			
			
			$fecha_inicial =  strtotime( date("Y-m-d", strtotime("03/15/2017") ) );
		    $fecha_compra  =  strtotime( date("Y-m-d", strtotime($this->input->post($campo)) ) );
			          $hoy =   strtotime(date("Y-m-d") );
			if ( ($fecha_compra>=$fecha_inicial) && ($fecha_compra<=$hoy) ) {
				return true;
			} else {
				$this->form_validation->set_message( 'valid_fecha',"<b class='requerido'>*</b> Su <b>%s</b> es incorrecta." );	
				return false;
			}

		} else {
			$this->form_validation->set_message( 'valid_fecha',"<b class='requerido'>*</b> Es obligatorio <b>%s</b>." );
			return false;
		}	

	}







	


/////////////////validaciones/////////////////////////////////////////	




	function accept_terms($str,$campo) {
        if ($this->input->post($campo)){
			return TRUE;
		} else {
			$this->form_validation->set_message( 'accept_terms',"<b class='requerido'>*</b> Favor lee y acepta <b>%s</b>." );
			return FALSE;
		}
	}

	function valid_phone( $str ){
		if ( $str ) {
			if ( ! preg_match( '/\([0-9]\)| |[0-9]/', $str ) ){
				$this->form_validation->set_message( 'valid_phone', "<b class='requerido'>*</b> El <b>%s</b> no tiene un formato válido." );
				return FALSE;
			} else {
				return TRUE;
			}
		}
	}

	function valid_nacimiento( $str, $campo ){
		if ($this->input->post($campo)){
			$hoy =  new DateTime (date("Y-m-d", strtotime(date("d-m-Y"))) );
			$fecha_nac = new DateTime ( date("Y-m-d", strtotime($this->input->post($campo)) ) );
			$fecha = date_diff($hoy, $fecha_nac);
			if ( ($fecha->y>=18) && ($fecha->y<=150) ) {
				return true;
			} else {
				$this->form_validation->set_message( 'valid_nacimiento',"<b class='requerido'>*</b> Su <b>%s</b> debe ser mayor a 18 años." );	
				return false;
			}

		} else {
			$this->form_validation->set_message( 'valid_nacimiento',"<b class='requerido'>*</b> Es obligatorio <b>%s</b>." );
			return false;
		}	

	}



	public function valid_cero($str) {
		return (  preg_match("/^(0)$/ix", $str)) ? FALSE : TRUE;
	}

	function nombre_valido( $str ){
		 $regex = "/^([A-Za-z ñáéíóúÑÁÉÍÓÚ]{2,60})$/i";
		//if ( ! preg_match( '/^[A-Za-zÁÉÍÓÚáéíóúÑñ \s]/', $str ) ){
		if ( ! preg_match( $regex, $str ) ){			
			$this->form_validation->set_message( 'nombre_valido',"<b class='requerido'>*</b> La información introducida en <b>%s</b> no es válida." );
			return FALSE;
		} else {
			return TRUE;
		}
	}



	function valid_option( $str ){
		if ($str == 0) {
			$this->form_validation->set_message('valid_option', "<b class='requerido'>*</b> Es necesario que selecciones una <b>%s</b>.");
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function valid_date( $str ){

		$arr = explode('-', $str);
		if ( count($arr) == 3 ){
			$d = $arr[0];
			$m = $arr[1];
			$y = $arr[2];
			if ( is_numeric( $m ) && is_numeric( $d ) && is_numeric( $y ) ){
				return checkdate($m, $d, $y);
			} else {
				$this->form_validation->set_message('valid_date', "<b class='requerido'>*</b> El campo <b>%s</b> debe tener una fecha válida con el formato DD-MM-YYYY.");
				return FALSE;
			}
		} else {
			$this->form_validation->set_message('valid_date', "<b class='requerido'>*</b> El campo <b>%s</b> debe tener una fecha válida con el formato DD/MM/YYYY.");
			return FALSE;
		}
	}

	public function valid_email($str)
	{
		return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
	}

	////Agregado por implementacion de registro insitu para evento/////
	public function opcion_valida( $str ){
		if ( $str == '0' ){
			$this->form_validation->set_message('opcion_valida',"<b class='requerido'>*</b>  Selección <b>%s</b>.");
			return FALSE;
		} else {
			return TRUE;
		}
	}


}

/* End of file main.php */
/* Location: ./app/controllers/main.php */
