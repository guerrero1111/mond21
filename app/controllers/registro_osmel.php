<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registro extends CI_Controller {

	public function __construct(){  
		parent::__construct();

		$this->load->model('admin/modelo', 'modelo'); 
		$this->load->model('registros', 'modelo_registro'); 
		$this->load->model('admin/catalogo', 'catalogo');  
		$this->load->library(array('email')); 
		$this->tiempo_comienzo      = "1:00";
	}




	// function correo(){  

	// 	$this->load->library('email');

	// 	$this->email->from('info@cinepremios.com', 'probando');
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

 // Creación de especialista o Administrador (Nuevo Colaborador)
	function nuevo_registro(){
		if($this->session->userdata('session_participante') === TRUE ){   //si esta logueado  ir al home
				  redirect('');
		} else {  //nuevo registro
			  //$data['premios']   = $this->catalogo->listado_premios();
			  $data['estados']   = $this->modelo_registro->listado_estados();
			  $this->load->view( 'registros/registro',$data );   
		}    
	}


function validar_registros(){
		if ($this->session->userdata('session_participante') == TRUE) {
			redirect('');
		} else {
			
				
			

			$this->form_validation->set_rules( 'nombre', 'Nombre', 'trim|required|callback_nombre_valido|min_length[3]|max_length[50]|xss_clean');
			$this->form_validation->set_rules( 'apellidos', 'Apellido(s)', 'trim|required|callback_nombre_valido|min_length[3]|max_length[50]|xss_clean');
			$this->form_validation->set_rules( 'email', 'Correo', 'trim|required|valid_email|xss_clean');
			$this->form_validation->set_rules( 'fecha_nac', 'Fecha de Nacimiento', 'trim|required|callback_valid_nacimiento[fecha_nac]|xss_clean');
			$this->form_validation->set_rules( 'calle', 'Calle', 'trim|required|min_length[3]|max_length[100]|xss_clean');
			$this->form_validation->set_rules( 'numero', 'Número', 'trim|required|min_length[1]|max_length[100]|xss_clean');
			$this->form_validation->set_rules( 'colonia', 'Colonia', 'trim|required|min_length[3]|max_length[100]|xss_clean');
			$this->form_validation->set_rules( 'municipio', 'Municipio', 'trim|required|min_length[3]|max_length[100]|xss_clean');
			
			$this->form_validation->set_rules( 'cp', 'CP', 'trim|required|min_length[2]|max_length[100]|xss_clean');
			$this->form_validation->set_rules('id_estado', 'Ciudad', 'required|callback_valid_option|xss_clean');
			$this->form_validation->set_rules( 'celular', 'Celular', 'trim|required|numeric|min_length[10]|callback_valid_phone|xss_clean');
			$this->form_validation->set_rules( 'telefono', 'Teléfono', 'trim|required|numeric|min_length[8]|callback_valid_phone|xss_clean');
			$this->form_validation->set_rules( 'id_estado_compra', 'Cd. de compra', 'required|callback_valid_option|xss_clean');
			$this->form_validation->set_rules( 'nick', 'NickName', 'trim|required|min_length[3]|max_length[50]|callback_cadena_noacepta|xss_clean');
			$this->form_validation->set_rules( 'pass_1', 'La contraseña', 'required|trim|min_length[8]|xss_clean');
			$this->form_validation->set_rules( 'pass_2', 'Confirmación de contraseña', 'required|trim|min_length[8]|xss_clean');

			$this->form_validation->set_rules('coleccion_id_aviso', 'Aviso de privacidad', 'callback_accept_terms[coleccion_id_aviso]');	
			$this->form_validation->set_rules('coleccion_id_base', 'Bases legales', 'callback_accept_terms[coleccion_id_base]');	
		

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
				    "id_estado" =>  '',
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
					$data['email']			=	$this->input->post('email');
					$data['email_invitado']			=	$this->input->post('email_invitado');
					$data['contrasena']		=	$this->input->post('pass_1');
					$data 				= 	$this->security->xss_clean($data);  



					//print_r($mis_errores); die;
					//$login_check = $this->modelo_registro->check_correo_existente($data);

					//if ( $login_check != FALSE ){		


    if ( $data['email'] != $data['email_invitado'] ) {
       if (  $this->modelo_registro->checando_correos($data['email'],'email') ) { 
           if (  $this->modelo_registro->checando_correos($data['email'],'email_invitado') ) { 


           		if (  $this->modelo_registro->checando_correos($data['email_invitado'],'email') ) { 
		           if (  $this->modelo_registro->checando_correos($data['email_invitado'],'email_invitado') ) { 
		           				//EXITO para que pueda pasar este es el exito



						$usuario['nombre']   			= $this->input->post( 'nombre' );
						$usuario['apellidos']   		= $this->input->post( 'apellidos' );

						$usuario['fecha_nac']   		= $this->input->post( 'fecha_nac' );
						//$usuario['id_estado']   		= $this->input->post( 'id_estado' );
						$usuario['ciudad']				= $this->input->post( 'ciudad' );

						$usuario['celular']   		= $this->input->post( 'celular' );
						$usuario['email']   			= $this->input->post( 'email' );

						$usuario['equipo']   			= $this->input->post('equipo');
						$usuario['email_invitado']   			= $this->input->post( 'email_invitado' );

						$usuario['contrasena']				= $this->input->post( 'pass_1' );

						$usuario['id_perfil']   		= 3; //significa participante

						$usuario 						= $this->security->xss_clean( $usuario );
						$guardar 						= $this->modelo_registro->anadir_registro( $usuario );

						//print_r($guardar);die;

						
						if ( $guardar !== FALSE ){  

									$dato['email']   			    = $usuario['email'];   			
									$dato['contrasena']				= $usuario['contrasena'];			

									
			
									
									//envio de correo para notificar alta en usuarios del sistema
									
									//$desde = $this->session->userdata('c1');
									$esp_nuevo = $usuario['email'];

									$login_checkeo = $this->modelo_registro->check_login($usuario);
									$dato['id_jefe'] = $login_checkeo[0]->id;
									

									
									//checar el loguin y recoger datos de usuario registrado

									
									//agrega al historico de acceso de participantes

									$this->modelo_registro->anadir_historico_acceso($login_checkeo[0]);  


									$this->session->set_userdata('session_participante', TRUE);
									$this->session->set_userdata('email_participante', $usuario['email']);
									$this->session->set_userdata('email_invitado_participante', $usuario['email_invitado']);

									
									
									if (is_array($login_checkeo))  //si existe el usuario
										foreach ($login_checkeo as $element) {
											$this->session->set_userdata('id_participante', $element->id);
											$this->session->set_userdata('nombre_participante', $element->nombre.' '.$element->apellidos);
											$this->session->set_userdata('tarjeta_participante', $element->tarjeta);
											$this->session->set_userdata('juego_participante', $element->juego);
										}


										//cantidad de ; para saber a donde redirigir
										if  ( substr_count($this->session->userdata('tarjeta_participante'),';')<5) {
											$mis_errores['redireccion'] = 'tarjetas';		
										} else if  ( strlen($this->session->userdata('juego_participante'))!=3){
											$mis_errores['redireccion'] = 'juegos';		
										} else {
											$mis_errores['redireccion'] = '';	
										}
										
										$mis_errores['exito'] = true;	



										//$mis_errores = true;
								
									/*} else {
										 $mis_errores["general"] = '<span class="error"><b>E01</b> - El nuevo participante no pudo ser agregado</span>';
									}*/
									
									/*
						} else {
							
							 	 $mis_errores["general"] = '<span class="error"><b>E01</b> - El nuevo participante no pudo ser agregado</span>';
							 
						}*/
						
					} else {  //if ( $guardar !== FALSE ){  
						
							 	 
							 //hubo un error al guardar
						
					}




				/*} else { //if ( $login_check != FALSE ){
					
					$mis_errores["general"] = '<span class="error">El <b>Correo electrónico</b> ya se encuentra registrado.</span>';		 	
							 
						
					
				}*/




 } else {
		              //2.1-Si ya fu invitado -> msg, ya el usuario ha sido invitado
		           	$mis_errores["email_invitado"] = '<span class="error">El <b>Correo electrónico</b> ya ha sido invitado.</span>';	
		           }
		       } else {
		       	  //2.2-Si ya es jefe -> el usuario invitado ya fue dado de alta
		       		$mis_errores["email_invitado"] = '<span class="error">El <b>Correo electrónico</b> ya se encuentra registrado.</span>';	
		       }





           } else {
              //3.1- si ya fue invitado ->msg, usted ya ha sido invitado "click para darse de alta"
           	//'/record/'.$this->session->userdata('id_participante')

           	

           	$url = 'nuevo_invitado/'.$this->modelo_registro->correo_id($data['email'],'email_invitado');
           	$url = '<a href="'.base_url().$url.'">Click Aqui</a>';

           	$mis_errores["email"] = '<span class="error">El <b>Correo electrónico</b> es invitado '.$url.'.</span>';	
           }
       } else {
       	  //3.2- si ya es jefe -->msg, usted ya ha sido dado de alta
       		$mis_errores["email"] = '<span class="error">El <b>Correo electrónico</b> ya se encuentra registrado.</span>';		 

       }

    } else {
    	//1- los 2 correos no coincidan

		$mis_errores["general"] = '<span class="error">Los Correos coinciden.</span>';		 	
							 
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
				  	"fecha_nac" => 'Fecha de Nacimiento',  

					//"id_estado" => 'Ciudad de compra',
					"ciudad" =>  'Cd.',
					"celular" => 'Celular',
					"email" => 'Correo',

					"equipo" =>'Equipo',
					"email_invitado"=>"Invitado",

				    'pass_1'=>'La Contraseña',
				    'pass_2'=>'Confirmación',
				    
				    "coleccion_id_aviso" => 'Aviso de privacidad',
				    "coleccion_id_base" => 'Bases legales',
				    "coleccion_id_newsletter" => 'Recibir Promociones',
				  
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

			//$mis_errores['datos'] = self::configuraciones_imagenes();
			echo json_encode($mis_errores);
			self::configuraciones_imagenes(true);
			

}		




 // Creación de especialista o Administrador (Nuevo Colaborador)
	function nuevo_invitado($id){
		if($this->session->userdata('session_participante') === TRUE ){   //si esta logueado  ir al home
				  redirect('');
		} else {  //nuevo registro
			  //$data['premios']   = $this->catalogo->listado_premios();
			  $data['estados']   = $this->modelo_registro->listado_estados();
			  $data['jefe_equipo']   = $this->modelo_registro->datos_jefe_equipo($id);
			  //print_r($data['jefe_equipo']);die;
			  $this->load->view( 'registros/registro_invitado',$data );   
		}    
	}


function validar_invitado(){
		if ($this->session->userdata('session_participante') == TRUE) {
			redirect('');
		} else {


			$this->form_validation->set_rules( 'nombre', 'Nombre', 'trim|required|callback_nombre_valido|min_length[3]|max_length[50]|xss_clean');
			$this->form_validation->set_rules( 'apellidos', 'Apellido(s)', 'trim|required|callback_nombre_valido|min_length[3]|max_length[50]|xss_clean');
			$this->form_validation->set_rules( 'fecha_nac', 'Fecha de Nacimiento', 'trim|required|callback_valid_nacimiento[fecha_nac]|xss_clean');
			//$this->form_validation->set_rules('id_estado', 'Ciudad de compra', 'required|callback_valid_option|xss_clean');
			$this->form_validation->set_rules( 'ciudad', 'Cd. de compra', 'trim|required|callback_nombre_valido|min_length[3]|max_length[50]|xss_clean');
			$this->form_validation->set_rules( 'celular', 'Celular', 'trim|required|numeric|min_length[10]|callback_valid_phone|xss_clean');
			$this->form_validation->set_rules( 'email', 'Correo', 'trim|required|valid_email|xss_clean');

			$this->form_validation->set_rules( 'equipo', 'Equipo', 'trim|required|min_length[3]|max_length[50]|xss_clean');
			//$this->form_validation->set_rules( 'email_invitado', 'Invitado', 'trim|required|valid_email|xss_clean');
			
			
			$this->form_validation->set_rules( 'pass_1', 'La contraseña', 'required|trim|min_length[8]|xss_clean');
			$this->form_validation->set_rules( 'pass_2', 'Confirmación de contraseña', 'required|trim|min_length[8]|xss_clean');
							
			
			$this->form_validation->set_rules('coleccion_id_aviso', 'Aviso de privacidad', 'callback_accept_terms[coleccion_id_aviso]');	
			$this->form_validation->set_rules('coleccion_id_base', 'Bases legales', 'callback_accept_terms[coleccion_id_base]');	
			$this->form_validation->set_rules('coleccion_id_newsletter', 'Recibir Promociones', 'callback_accept_terms[coleccion_id_base]');	
			
			
			$mis_errores=array(
						"exito" => false,
						"general" => '',
					    "nombre" =>  '',
					    "apellidos" =>  '',
					    "fecha_nac" =>  '',

					    //"id_estado" =>  '',
					   "ciudad"=>'',
					    "celular" =>  '',
					    "email" =>  '',
					    "equipo"=>'',
					   // "email_invitado"=>'',

					    'pass_1'=> '',
					    'pass_2'=>  '',

					    "coleccion_id_aviso" =>  '',
					    "coleccion_id_base" =>  '',
					    "coleccion_id_newsletter" =>  '',
				);
			


			if ($this->form_validation->run() === TRUE){

				if ($this->input->post( 'pass_1' ) === $this->input->post( 'pass_2' ) ){
					$data['email']			=	$this->input->post('email');
					//$data['email_invitado']			=	$this->input->post('email_invitado');
					$data['contrasena']		=	$this->input->post('pass_1');
					$data 				= 	$this->security->xss_clean($data);  
					//$login_check = $this->modelo_registro->check_correo_invitado($data);

					if ( true ){ //$login_check != FALSE
						$usuario['nombre']   			= $this->input->post( 'nombre' );
						$usuario['apellidos']   		= $this->input->post( 'apellidos' );

						$usuario['fecha_nac']   		= $this->input->post( 'fecha_nac' );
						//$usuario['id_estado']   		= $this->input->post( 'id_estado' );
						$usuario['ciudad']				= $this->input->post( 'ciudad' );

						$usuario['celular']   		= $this->input->post( 'celular' );
						$usuario['email']   			= $this->input->post( 'email' );

						$usuario['equipo']   			= $this->input->post('equipo');
					//	$usuario['email_invitado']   			= $this->input->post( 'email_invitado' );

						$usuario['contrasena']				= $this->input->post( 'pass_1' );

						$usuario['id']				= $this->input->post( 'id' );
						$usuario['id_perfil']   		= 4; //significa invitado

						$usuario 						= $this->security->xss_clean( $usuario );
						$guardar 						= $this->modelo_registro->anadir_invitado( $usuario );

						

						
						if ( $guardar !== FALSE ){  

									$dato['email']   			    = $usuario['email'];   			
									$dato['contrasena']				= $usuario['contrasena'];				

									
									//envio de correo para notificar alta en usuarios del sistema
									
									//$desde = $this->session->userdata('c1');
									$esp_nuevo = $usuario['email'];
/*
									$this->email->from('admin@cinepremios.com', 'Cine premios');
									$this->email->to( $esp_nuevo );
									$this->email->subject('Cine premios'); //.$this->session->userdata('c2')
									$this->email->message( $this->load->view('admin/correos/alta_usuario', $dato, TRUE ) );
									$this->email->send();

									*/

										 
									//if ($this->email->send()) 
										//{	//si se notifico al usuario, que envie a los administradores un correo
										/*
										$dato['email']   			    = $usuario['email'];   			
										$dato['contrasena']				= $usuario['contrasena'];				
										$dato['nombre']   			    = $usuario['nombre'];   			
										$dato['apellidos']				= $usuario['apellidos'];
										$dato['celular']   			    = $usuario['celular'];   			

											
										$this->load->library('email');
										$this->email->from('admin@cinepremios.com', 'Información Calimax');
										$this->email->to('guerreroadrian1111@gmail.com,carlos.ramirez@lostres.mx');	

										$this->email->subject('Nuevo usuario en Vamonos a España Calimax');
										$this->email->message( $this->load->view('admin/correos/alta_usuarios', $dato, TRUE ) );
										$this->email->send();*/

									
									//checar el loguin y recoger datos de usuario registrado

									$login_checkeo = $this->modelo_registro->check_login($usuario);
									//agrega al historico de acceso de participantes

									$this->modelo_registro->anadir_historico_acceso($login_checkeo[0]);  


									$this->session->set_userdata('session_participante', TRUE);
									$this->session->set_userdata('email_participante', $usuario['email']);
									//$this->session->set_userdata('email_jefe_participante', $usuario['email_invitado']);

									
									
									if (is_array($login_checkeo))  //si existe el usuario
										foreach ($login_checkeo as $element) {
											$this->session->set_userdata('id_participante', $element->id);
											$this->session->set_userdata('nombre_participante', $element->nombre.' '.$element->apellidos);
											$this->session->set_userdata('tarjeta_participante', $element->tarjeta);
											$this->session->set_userdata('juego_participante', $element->juego);
										}


										//cantidad de ; para saber a donde redirigir
										if  ( substr_count($this->session->userdata('tarjeta_participante'),';')<5) {
											$mis_errores['redireccion'] = 'tarjetas';		
										} else if  ( strlen($this->session->userdata('juego_participante'))!=3){
											$mis_errores['redireccion'] = 'juegos';		
										} else {
											$mis_errores['redireccion'] = '';	
										}
										
										$mis_errores['exito'] = true;	



										//$mis_errores = true;
								
									/*} else {
										 $mis_errores["general"] = '<span class="error"><b>E01</b> - El nuevo participante no pudo ser agregado</span>';
									}*/
									
									/*
						} else {
							
							 	 $mis_errores["general"] = '<span class="error"><b>E01</b> - El nuevo participante no pudo ser agregado</span>';
							 
						}*/
						
					} else {  //if ( $guardar !== FALSE ){  
						
							 	 
							 
						
					}
				} else { //if ( $login_check != FALSE ){
					
					$mis_errores["general"] = '<span class="error">El <b>Correo electrónico</b> ya se encuentra registrado.</span>';		 	
							 
						
					
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
				  	"fecha_nac" => 'Fecha de Nacimiento',  

					//"id_estado" => 'Ciudad de compra',
					"ciudad" =>  'Cd.',
					"celular" => 'Celular',
					"email" => 'Correo',

					"equipo" =>'Equipo',
					//"email_invitado"=>"Invitado",

				    'pass_1'=>'La Contraseña',
				    'pass_2'=>'Confirmación',
				    
				    "coleccion_id_aviso" => 'Aviso de privacidad',
				    "coleccion_id_base" => 'Bases legales',
				    "coleccion_id_newsletter" => 'Recibir Promociones',
				  
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

			//$mis_errores['datos'] = self::configuraciones_imagenes();
			echo json_encode($mis_errores);
			self::configuraciones_imagenes(true);

}		

 //instrucciones despues q se registre o se loguee	
 public function proc_modal_instrucciones(){
		  if ( $this->session->userdata('session_participante') !== TRUE ) {
		      redirect('');
		    } else {
		      
               $this->load->view( 'juegos/modal_instrucciones' );
		   }   			
}


  
 function ingresar_usuario(){
		if ($this->session->userdata( 'session_participante' ) == TRUE )    { //(no registrado) o (registrado y completado)
			 redirect('');
		} else {
			$this->load->view( 'registros/login');
		}
 }



	function validar_login_participante(){
				$mis_errores=array(
					"exito" => false,
				    "email" => '',
				    "contrasena" => '',
				    'general'=> '',
				    'jugo' => false,
				);

		$this->form_validation->set_rules( 'email', 'Correo', 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules( 'contrasena', 'Contraseña', 'required|trim|min_length[8]|xss_clean');

		if ( $this->form_validation->run() == TRUE ){
				$data['email']		=	$this->input->post('email');
				$data['contrasena']		=	$this->input->post('contrasena');
				$data 				= 	$this->security->xss_clean($data);  

				$login_checkeo = $this->modelo_registro->check_login($data);
				
				if ( $login_checkeo != FALSE ){

					$this->modelo_registro->anadir_historico_acceso($login_checkeo[0]);  //agrega al historico de acceso de participantes

					$this->session->set_userdata('session_participante', TRUE);
					$this->session->set_userdata('email_participante', $data['email']);


					if (is_array($login_checkeo))  //si existe el usuario
					
						foreach ($login_checkeo as $element) {
							$this->session->set_userdata('id_participante', $element->id);
							$this->session->set_userdata('nombre_participante', $element->nombre.' '.$element->apellidos);
							$this->session->set_userdata('tarjeta_participante', $element->tarjeta);
							$this->session->set_userdata('juego_participante', $element->juego);

							if   ( ( substr_count($element->tarjeta,';') <90) && ($element->tiempo_juego!='0:00') ) {
								$mis_errores['jugo'] = $element->tarjeta;	
							} else {
								$mis_errores['jugo'] = true;	
							}	
						}					

										
					//cantidad de ; para saber a donde redirigir
					if  ( substr_count($this->session->userdata('tarjeta_participante'),';')<5) {
						$mis_errores['redireccion'] = 'tarjetas';		
					} else if  ( strlen($this->session->userdata('juego_participante'))!=3){
						$mis_errores['redireccion'] = 'juegos';		
					} else {
						$mis_errores['redireccion'] = '';	
					}
					
					

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
				    "email" => 'Correo',
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
		//$mis_errores['datos'] = self::configuraciones_imagenes();
		echo json_encode($mis_errores);
		self::configuraciones_imagenes(true);//aqui hay q corregir
	}	





//recuperar constraseña OK

	function recuperar_invitado(){ //NO FUNCIONA ERA PARA RECUPERAR CONTRASEÑA
		$this->load->view('registros/recuperar_invitado');
	}
	
	function validar_recuperar_invitado(){  //NO FUNCIONA ERA PARA RECUPERAR CONTRASEÑA
		$mis_errores=array(
				    'general'=> '',
				    'exito' =>false,
		);

		$this->form_validation->set_rules( 'email', 'Email', 'trim|required|valid_email|xss_clean');

		if ( $this->form_validation->run() == FALSE ){
			$mis_errores["general"] =  validation_errors('<span class="error">','</span>');

		} else {
				$data['email_invitado']	=	$this->input->post('email');
				//$correo_enviar      =   $data['email'];
				$data 				= 	$this->security->xss_clean($data);  
				$usuario_check 		=   $this->modelo_registro->recuperar_invitado($data);
				//print_r($usuario_check);die;

				if ( $usuario_check != FALSE ){
						/*
						$data= $usuario_check[0]; 	
						//$desde = $this->session->userdata('c1');
						
						$this->email->from('admin@cinepremios.com', 'Cine premios');
						$this->email->to($correo_enviar);
						$this->email->subject('Recuperación de contraseña de Cine premios');
						$this->email->message($this->load->view('registros/correos/envio_contrasena', $data, true));

						
						if ($this->email->send()) {
							*/
						if (true) {	
						
							//$mis_errores = true;	
							$mis_errores['exito'] = true;
							$mis_errores['redireccion'] = 'nuevo_invitado/'.$usuario_check->id;
						
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

				if ( $usuario_check != FALSE ){
						$data= $usuario_check[0]; 	
						//$desde = $this->session->userdata('c1');
						
						$this->email->from('admin@promoscasaley.com.mx', 'Promos Casa Ley');
						$this->email->to($correo_enviar);
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



	public function desconectar_participante(){
		$this->session->sess_destroy();
		redirect('');
	}	




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
						$this->session->set_userdata('tiempo', $this->tiempo_comienzo);  //para poder ir descontando tiempo

						if ($booleano) {
					        $cant_fichas=90;
					        $cant_caritas= $this->session->userdata('numImage'); //5
					        
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


					        foreach ($misdatos as $key => $i) {  //dinamizar esto
					            $cara[]=($i<=$porciento[1])  ?  1 : ($i<=$porciento[1]+$porciento[2] ? 2 : ($i<=$porciento[1]+$porciento[2]+ $porciento[3] ? 3 : ($i<=$porciento[1]+$porciento[2]+ $porciento[3]+ $porciento[4] ? 4 : 5 )));
					        }


							$data['cara'] =  json_encode($cara);
							$data['misdatos'] =  json_encode($misdatos);

					        $checar         = $this->modelo_registro->agregar_datos( $data );
					    }    
				    

				       

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
               $this->load->view( 'registros/modal_face' );
		   }   			
}

 
//Si comparte la modal
function registrar_facebook($puntos){ //nuevo
	if ( $this->session->userdata( 'session_participante' ) == TRUE ){
		
		$ticket['redes'] = (int) ($puntos);
		$ticket 						= $this->security->xss_clean( $ticket );
		$guardar 						= $this->modelo_registro->actualizar_facebook( $ticket );        	
		 
		//redirect('/record/'.$this->session->userdata('id_participante'));
		//redirect('/tarjetas');

		redirect('tarjetas');
	}	

}





function record($id_participante){
	if ( $this->session->userdata( 'session_participante' ) == TRUE ){
		$data["id_participante"] = $id_participante;
		$dato 		=   $this->modelo_registro->record_personal($data);

		if ($dato->id_jefe=='') {

		  $datu['jefe'] = $dato;  
		  
		  $data['email'] = $dato->email_invitado;
		  $datu['invitado']	=   $this->modelo_registro->record_invitado($data);
		  
		} else {
		   $datu['invitado'] = $dato;
		   $data["id_participante"] = $dato->id_jefe;
		   $datu['jefe']	=   $this->modelo_registro->record_personal($data);
		}

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
			$this->form_validation->set_message( 'accept_terms',"<b class='requerido'>*</b> Favor lee y acepta tu <b>%s</b>." );
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
