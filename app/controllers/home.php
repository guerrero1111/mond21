<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller { 

	public function __construct(){ 
		parent::__construct();

		$this->load->model('admin/modelo', 'modelo'); 
		$this->load->model('admin/catalogo', 'catalogo');  
		$this->load->model('registros', 'modelo_registro'); 
		$this->load->library(array('email')); 
		$this->total_fichas = 91;
	
	}



///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
///////////juego//////////////////////////////////////////////////////////////////////////////////
  
   function tarjetas(){ //presentacion del juego, cdo refresque 
   	//print_r('aa');die;

   		//||  ( substr_count($this->session->userdata('tarjeta_participante'),';')>=5) )
   		
   		//si esta la session activa y esta registrado ticket
		if ( ($this->session->userdata( 'session_participante' ) == TRUE ) && ($this->session->userdata( 'registro_ticket' ) == TRUE )  ) { 

			$preg = $this->modelo_registro->get_datos();


			$mitarjeta = $preg->tarjeta;	
			$mitiempo=$preg->tiempo_juego;
			$data['jgo'] =1;


			//sino tiene todavía el total de fichas y el tiempo todavía no ha concluido(0:00)
			if ( ( substr_count($mitarjeta,';') < $this->total_fichas) && ($mitiempo!='0:00') ) {
				
				 $data['tarjeta'] = $mitarjeta;   //todas las tarjetas viradas
				 
				 $preg_cara= str_replace("[", "", $preg->cara);  //esto para quitar [
				 $preg_cara= str_replace("]", "", $preg_cara);   //esto para quitar ]

				 $data['cara'] = explode(",", $preg_cara);   // todas las cara


				 $preg_misdatos= str_replace("[", "", $preg->misdatos); //esto para quitar [
				 $preg_misdatos= str_replace("]", "", $preg_misdatos);  //esto para quitar ]

				 $data['misdatos'] = explode(",", $preg_misdatos); // todas misdatos

				//nuevo
				 $data['cada_tarjeta'] = explode(";", $data['tarjeta']); // sacar cada tarjeta por separado 
				 $data['tarj_marcada']=array();
				 for ($i = 0; $i <= count($data['cada_tarjeta'])-1; $i++) {
				 	$data['tarj_marcada'][]= explode("+", $data['cada_tarjeta'][$i])[0]; // sacar cada tarjeta por separado 
				 	
				 }	

				 $this->load->view( 'juegos/tarjetas', $data);
			} else {

				if ($this->session->userdata('abriendo_face')) {
						redirect('record/'.$this->session->userdata('id_participante'));	
				} else {

	 				 $data['tarjeta'] = $mitarjeta;   //todas las tarjetas viradas
					 
					 $preg_cara= str_replace("[", "", $preg->cara);  //esto para quitar [
					 $preg_cara= str_replace("]", "", $preg_cara);   //esto para quitar ]

					 $data['cara'] = explode(",", $preg_cara);   // todas las cara


					 $preg_misdatos= str_replace("[", "", $preg->misdatos); //esto para quitar [
					 $preg_misdatos= str_replace("]", "", $preg_misdatos);  //esto para quitar ]

					 $data['misdatos'] = explode(",", $preg_misdatos); // todas misdatos



					$this->load->view( 'juegos/tarjetas', $data);
				}
			}	 

			 
		} else {
			redirect('');
		}

	}

/*

select 
        AES_DECRYPT( cara,'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5') AS cara,
        AES_DECRYPT( misdatos,'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5') AS misdatos,
        AES_DECRYPT( tarjeta,'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5') AS tarjeta
      from 
        calimax_registro_participantes


select 
        
SUBSTR_COUNT( AES_DECRYPT( tarjeta,'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5') , '2;') +1,

SELECT 
(LENGTH(AES_DECRYPT( tarjeta,'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5')) - LENGTH(REPLACE(AES_DECRYPT( tarjeta,'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5'), '2;', '')) ) /2 AS occurrences,
AES_DECRYPT( tarjeta,'gtg5igLZasUC3xNfDlvTGBxxkoMuR6FaCYw5') AS tarjeta
      from 
        calimax_registro_participantes


*/

	//formato  fig+resp-tiempo;
	//cada vez que vire la tarjeta pues que guarde la "cadena [tarjeta] y el [tiempo]", 

   

	function respuesta_tarjeta(){ 

		if ( ($this->session->userdata( 'session_participante' ) == TRUE ) && ($this->session->userdata( 'registro_ticket' ) == TRUE )  ) { 
		$posicion =  $this->input->post( 'posicion' );  //posicion dentro de la matriz
		$numero =  $this->input->post( 'numero' );      //numeros que tocan de 1..90(maximo de tarjetas)
		$cara =  $this->input->post( 'cara' );          //cara 1..5 (tipos de tarjetas) 
		$tiempo =  $this->input->post( 'tiempo' );  //tiempo en que se viro esta tarjeta 
		$data['formato'] = $posicion.'+'.$numero.'+'.$tiempo.'|'.$cara.';';


		//$preg = $this->modelo_registro->get_datos();

		//if guarda bien entonces
		$data 		  		= $this->security->xss_clean( $data );

		$dato = $this->modelo_registro->checartiempo();		
			
			$fecha = date("Y-m-d h:i:s");
			
			
			$tiempo = $dato->fechainicial;
			$nuevafecha = strtotime ( '+10 second' , strtotime ( $tiempo ) ) ;
			$fechaf= date("Y-m-d h:i:s",$nuevafecha);

			$cuenta100 = $dato->cuenta100;
			$cuenta50 = $dato->cuenta50;
			$cuenta20 = $dato->cuenta20;
			$cuenta0 = $dato->cuenta0;

			switch ($cara) {
			    case 1:
			        if ($cara == 1 && $cuenta100 < 5) {
			        	print_r($cuenta100);
			        	if (true) {

							$guardar	 		= $this->modelo_registro->actualizar_respuesta_tarjeta( $data );
						
						}
					$this->modelo_registro->actualizar_cuenta100();
			        }
			        
			        break;
			    case 2:
			   	 	
			         if ($cara == 2 && $cuenta50 < 10) {
			        	print_r($cuenta50);

			        	if (true) {

							$guardar	 		= $this->modelo_registro->actualizar_respuesta_tarjeta( $data );
						
						}
						$this->modelo_registro->actualizar_cuenta50();
			        }
			       
			        break;
			    case 3:
			    	
			         if ($cara == 3 && $cuenta20 < 20) {
			         	print_r($cuenta20);
			        	if (true) {

							$guardar	 		= $this->modelo_registro->actualizar_respuesta_tarjeta( $data );
						
						}
						$this->modelo_registro->actualizar_cuenta20();
			        }
			        
			        break;
			    case 4:
			    	
			         if ($cara == 4 && $cuenta0 < 55) {
			         	print_r($cuenta0);
			        	if (true) {

							$guardar	 		= $this->modelo_registro->actualizar_respuesta_tarjeta( $data );
						
						}
						$this->modelo_registro->actualizar_cuenta0();
			        }
			        
			        break;
			}
			
			

		
		
		if  ( substr_count($guardar,';') < $this->total_fichas) {   //si la cantidad guardada es menor que el total(90) puede continuar
				$data['redireccion'] = 8888;  //continuar jugando la partida
		} else {
				$data['redireccion']= (int)$this->session->userdata( 'cant_repetir' );
				//$preg->redes; //tarjetas
		}	

		echo json_encode($data);   


		}
	}



	//este es cuando el tiempo se agota a 0:00
	function tiempo_juego(){ 
			$data['tiempo'] =  $this->input->post( 'tiempo' );
			$data 		  		= $this->security->xss_clean( $data );
			
			$this->modelo_registro->actualizar_tiempo( $data );
			$data['redireccion']= (int)$this->session->userdata( 'cant_repetir' );
			echo json_encode($data);

	}	


	function validatiempo(){ 
			
if ( ($this->session->userdata( 'session_participante' ) == TRUE ) && ($this->session->userdata( 'registro_ticket' ) == TRUE )  ) { 
			$dato = $this->modelo_registro->checartiempo();		
			
			$fecha = date("Y-m-d h:i:s");
			
			
			$tiempo = $dato->fechainicial;
			$nuevafecha = strtotime ( '+10 second' , strtotime ( $tiempo ) ) ;
			$fechaf= date("Y-m-d h:i:s",$nuevafecha);


			echo $fecha;
			echo "<br>";
			echo $fechaf;
			//ahora     fechainicial+7
			if ($fecha>$fechaf) {
				$data['redireccion']= (int)$this->session->userdata( 'cant_repetir' );
				echo json_encode($data);  
				
		} else {
				
				
		}	
}
			

	}


	function tiempoinicial(){ 

			
			$this->modelo_registro->actualizar_tiempoinicial();

	}

	function tiempofinal(){ 
						
			
			$this->modelo_registro->actualizar_tiempofinal();
			
			

	}







////////////////////////////////////////////////////////////////////////////////////
/////////////////////////juegos/////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////


   //self::configuraciones_imagenes();  //las imagenes





									/*
									//el valor que tiene en bd la tarjeta que se quedo cuando se cerro la session
									$this->session->set_userdata('tarjeta_participante', $element->tarjeta);
									$this->session->set_userdata('juego_participante', $element->juego);

									if   ( ( substr_count($element->tarjeta,';') <$this->total_fichas) && ($element->tiempo_juego!='0:00') ) {
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



///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////


	public function index(){
		$this->dashboard();
	}

	/////////////presentacion, filtro y paginador////////////	
	function dashboard(){ 
		//print_r($this->session->userdata( 'id_participante' ));die;
		self::configuraciones();
		$data['nodefinido_todavia']        = '';
		$this->load->view( 'dashboard/dashboard',$data );

	}


	function mecanica(){ 
		$this->load->view( 'dashboard/mecanica' );
	}





	function facebook(){ 
		
		$this->load->view( 'facebook' );

	}


	function aviso(){ 
		
		$this->load->view( 'dashboard/aviso' );

	}	
function legales(){ 
		
		$this->load->view( 'dashboard/legales' );

	}	

	function eleccion_premio(){ 
		if (( $this->session->userdata( 'session_participante' ) == TRUE ) && ($this->session->userdata('premiado_participante') == 1)  && ($this->session->userdata('id_premio_participante') == 0) ) {

			$data['premios']   = $this->catalogo->listado_premios();
			

			$this->load->view( 'premios/premios' ,$data);
		}	else {
			redirect('');
		}
	}	



////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
	public function configuraciones(){
			    $configuraciones = $this->modelo->listado_configuraciones();
				
				if ( $configuraciones != FALSE ){

					if (is_array($configuraciones))
						foreach ($configuraciones as $configuracion) {
							$this->session->set_userdata('c'.$configuracion->id, $configuracion->valor);
							$this->session->set_userdata('a'.$configuracion->id, $configuracion->activo);
						}
					
				} 

	}



function antitrampa(){ 
		$this->session->sess_destroy();
		$this->load->view( 'dashboard/antitrampa' );
	}


/////////////////validaciones/////////////////////////////////////////	


	public function valid_cero($str)
	{
		return (  preg_match("/^(0)$/ix", $str)) ? FALSE : TRUE;
	}

	function nombre_valido( $str ){
		 $regex = "/^([A-Za-z ñáéíóúÑÁÉÍÓÚ]{2,60})$/i";
		//if ( ! preg_match( '/^[A-Za-zÁÉÍÓÚáéíóúÑñ \s]/', $str ) ){
		if ( ! preg_match( $regex, $str ) ){			
			$this->form_validation->set_message( 'nombre_valido','<b class="requerido">*</b> La información introducida en <b>%s</b> no es válida.' );
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function valid_phone( $str ){
		if ( $str ) {
			if ( ! preg_match( '/\([0-9]\)| |[0-9]/', $str ) ){
				$this->form_validation->set_message( 'valid_phone', '<b class="requerido">*</b> El <b>%s</b> no tiene un formato válido.' );
				return FALSE;
			} else {
				return TRUE;
			}
		}
	}

	function valid_option( $str ){
		if ($str == 0) {
			$this->form_validation->set_message('valid_option', '<b class="requerido">*</b> Es necesario que selecciones una <b>%s</b>.');
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
				$this->form_validation->set_message('valid_date', '<b class="requerido">*</b> El campo <b>%s</b> debe tener una fecha válida con el formato DD-MM-YYYY.');
				return FALSE;
			}
		} else {
			$this->form_validation->set_message('valid_date', '<b class="requerido">*</b> El campo <b>%s</b> debe tener una fecha válida con el formato DD/MM/YYYY.');
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
