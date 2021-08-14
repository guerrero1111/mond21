<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){ 
		parent::__construct();

		$this->load->model('admin/modelo', 'modelo'); 
		$this->load->model('admin/catalogo', 'catalogo');  
		$this->load->model('registros', 'modelo_registro'); 
		$this->load->library(array('email')); 
	}



///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
///////////juego//////////////////////
   function tarjetas(){

		if ( ($this->session->userdata( 'session_participante' ) !== TRUE ) ||  ( substr_count($this->session->userdata('tarjeta_participante'),';')>=4) )   { //(no registrado) o (registrado y completado)
			 redirect('');
		} else {
			 $this->load->view( 'juegos/tarjetas');
		}

	}



	//formato  fig+resp-tiempo;
	function respuesta_tarjeta(){ 
		//$this->load->view( 'dashboard/tarjetas' );
		$figura =  $this->input->post( 'figura' );
		$respuesta =  $this->input->post( 'respuesta' );
		$tiempo =  $this->input->post( 'tiempo' );

		$data['formato'] = $this->session->userdata('tarjeta_participante').$figura.'+'.$respuesta.'-'.$tiempo.';';

		//if guarda bien entonces
		$data 		  		= $this->security->xss_clean( $data );
		$guardar	 		= $this->modelo_registro->actualizar_respuesta_tarjeta( $data );
			
		if ( $guardar !== FALSE ){  
			$this->session->set_userdata('tarjeta_participante', $data['formato']);
		}	


		if  ( substr_count($this->session->userdata('tarjeta_participante'),';')<4) {
				$data['redireccion']='tarjetas';
		} else if ( strlen($this->session->userdata('juego_participante'))!=3) {
				$data['redireccion']= 'juegos';		
				//$data['redireccion']= 'modal_tarjeta';		que esta redireccionará al juego
		} else {
				$data['redireccion'] = '';	
		}	

		//https://www.w3schools.com/jsref/tryit.asp?filename=tryjsref_win_clearinterval
		//A script on this page starts this clock php
		//https://www.sitepoint.com/build-javascript-countdown-timer-no-dependencies/

		
		echo json_encode($data);        
                            
	}



////////////////////////////////////////////////////////////////////////////////////
/////////////////////////juegos/////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
 function juegos(){

 	   //print_r($this->session->userdata('tarjeta_participante') );die;


		if  ($this->session->userdata( 'session_participante' ) !== TRUE )    { //(no registrado) o (registrado y completado)
			 redirect('');
		} else if  ( substr_count($this->session->userdata('tarjeta_participante'),';')<4){
			redirect('/tarjetas');
		} else if  ( strlen($this->session->userdata('juego_participante'))!=3){
			 $this->load->view( 'juegos/juegos');
		} else {
			redirect('');  //esta intentando jugar un juego q ya termino
		}

	}

   //self::configuraciones_imagenes();  //las imagenes




 public function proc_modal_juego($tiempo, $redes){
		  if ( $this->session->userdata('session_participante') !== TRUE ) {
		      redirect('');
		    } else {
		      
		       $data['tiempo'] 			= base64_decode($tiempo);	//tiempo restante
		       $data['redes'] 			= base64_decode($redes);   //redes
 			   $data['juego'] 			= base64_decode($this->session->userdata('cripto'));	 
 			   /*
	           $c1 =  (int) ($data['juego'] / 100);
	           $c2 =   (int) (($data['juego'] % 100) / 10 );
	           $c3 =   (int) (($data['juego'] % 10)  );*/

                $data["total_puntos"] = 25;

               $data 		  		= $this->security->xss_clean( $data );
			   $guardar	 		= $this->modelo_registro->actualizar_respuesta_juego( $data );

              
               $this->load->view( 'juegos/modal_juego',$data );
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