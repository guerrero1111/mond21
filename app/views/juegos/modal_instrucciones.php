<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
 	if (!isset($retorno)) {
      	$retorno ="registro_ticket";
    }
 $hidden = array('nada'=>'nada'); 

 ?>
<?php //echo form_open('validar_confirmar_juego', array('class' => 'form-horizontal','id'=>'form_sino','name'=>$retorno, 'method' => 'POST', 'role' => 'form', 'autocomplete' => 'off' ) ,   $hidden ); ?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>		
	</div>
	<div class="modal-body">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 instru">
			<h2 class="inst text-center">INSTRUCCIONES</h2>
			<p class="instrucciones text-center">
				Gira la mayor cantidad de fichas antes de que se agote el tiempo para acumular puntos
			</p>
			
			<!-- <p class="instrucciones text-center">
Podrás acumular puntos de la siguiente forma:
			</p>
			<p class="instrucciones text-left amarillo">
				- 50 Pts. Si haces coincidir las tres imágenes.<br>
				- 25 Pts. Si NO logras hacer coincidir las imágenes.<br>
				
			</p> -->
		</div>
	</div>
	<div class="modal-footer">
		<div class="cont">
			<button type="button" class="close continuar ingresar" data-dismiss="modal" aria-label="Close">
				
					COMENZAR
				
			</button>
		</div>
	</div>




	
	
<?php //echo form_close(); ?>
