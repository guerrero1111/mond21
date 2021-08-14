<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php  $this->load->view( 'header' ); ?>
<?php $this->load->view( 'navbar' ); ?>
<style type="text/css">
	body {
   
  
    
}
</style>
<?php 

	if (!isset($retorno)) {
      	$retorno ="registro_ticket";
    }
?>
  
 <?php
								if ($GLOBALS['open']==1) {
								?>  
<?php
 $attr = array('class' => 'form-horizontal', 'id'=>'form_registro_ticket','name'=>$retorno,'method'=>'POST','autocomplete'=>'off','role'=>'form');
 echo form_open('/validar_tickets', $attr);
?>		

<input type="hidden" id="id_par" name="id_par" value="<?php echo $this->session->userdata('id_participante'); ?>">

<div class="container ingresar">
<div class="panel-body">
	
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
				<!-- <h3 class="text-center"><strong><?php echo $this->session->userdata('c2'); ?></strong></h3> -->
				<!-- <h1 class="text-center">REGISTRO DE TICKET</h1> -->
				<img src="<?php echo base_url()?>img/registro-ticket.png" style="margin: 25px auto 25px;" class="img-responsive sinizquierdo">
			</div>
		
		
		
	<div class="col-lg-10 col-md-10 col-lg-offset-1 col-sm-12 col-xs-12 text-center">		

			<div class="col-md-push-3 col-md-6 fondoformularios  registrof" id="formass" >	
					
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right" style="margin-bottom:15px">
						<a class="ver-ticket">Ver ejemplo de ticket</a>
					</div>
					<div class="form-group">
						
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							
							<input type="text" class="form-control" id="ticket" name="ticket" placeholder="Número de ticket">
							<span class="help-block" style="color:white;" id="msg_ticket"> </span> 
						</div>
					</div>


					<!-- <div class="form-group"> -->
					
					<!-- <label for="tipo" class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label">¿CUANTOS DÍGITOS TIENE TU FOLIO DE PARTICIPACIÓN?</label> -->
						 <!--<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<select id="tipo" name="tipo" class="form-control" style="width:100%;">
						        <option value="folio">Mi folio tiene 8 dígitos</option>
						        <option value="folio2">Mi folio tiene 8 dígitos</option> 
						    </select>
					    </div>	
				</div>-->


				<div class="form-group" id="foliocon">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<input type="text" class="form-control" id="folio" name="folio" placeholder="Folio">
						<span class="help-block msg_folio" style="color:white;" id="msg_folio"> </span> 
					</div> 
					
				</div>
				<!-- <div class="form-group"  id="foliocon2" style="display:none;">
				 	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<input type="text" class="form-control" id="folio2" name="folio2" placeholder="Si tu folio es de 7 dígitos regístralo aquí">
						<span class="help-block msg_folio" style="color:white;" id="msg_folio2"> </span> 
					</div>
					
				</div> -->

					

					<div class="form-group">
						
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							
							<input type="text" class="form-control" id="monto" name="monto" placeholder="Monto de la compra">
							<span class="help-block" style="color:white;" id="msg_monto"> </span> 
							<span class="help-block" style="color:white;" id="msg_monto"><b>Poner la cantidad exacta con pesos y centavos</b></span> 
						</div>
					</div>



					<div class="form-group">
						<!-- <label for="id_estado" class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Estado:</label> -->
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<select name="id_ciudad_compra" id="id_ciudad_compra" class="form-control">
									<option value="" disabled selected>CIUDAD DONDE HIZO LA COMPRA</option>
										<?php foreach ( $estados as $estado ){ ?>
												<option value="<?php echo $estado->id; ?>"><?php echo $estado->nombre; ?></option>
												
										<?php } ?>
								</select>
								 <span class="help-block" style="color:white;" id="msg_ciudad_compra"> </span>
							
						</div>
					</div>	


					<div class="form-group">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="input-group date compra col-lg-12 col-md-12 col-sm-12 col-xs-12">
						  <input id="compra" name="compra" type="text" class="form-control" placeholder="Fecha de compra"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span> 
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<span class="help-block" style="color:white;" id="msg_compra"> </span>
						</div>
					</div>
					</div>

					<div class="form-group text-center">
						<button type="submit" class="btn btn-info ingresar" value="REGISTRARME"/>
						REGISTRAR TICKETS
					</button>
					</div>

					

					


                   


				
					



		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
           <span class="help-block" style="color:white;" id="msg_general"> </span>
        </div>
					
					
					

				</div>
				

			
		
		</div>
		

	</div>
	</div>
</div> 
<?php echo form_close(); ?>

<?php

								} else {
									redirect(base_url()."record/".$this->session->userdata('id_participante'));
								}
								?>
								
<?php $this->load->view('footer'); ?>


<div class="modal fade bs-example-modal-lg" id="modalMessage"  ventana="redi_ticket" valor="<?php echo $retorno; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>

<div class="ventana-ejemplos">
	<div class="close">
		<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
	</div>
	<div class="img-ticket" style="height:88%;text-align:center">		
		<img src="<?php echo base_url()?>img/ticket.jpg" style="height: 100%;width: auto;">
	</div>

	<div class="text-center" style="color:#fff">
		*Imágen de referencia
	</div>
	<div class="text-center exp">
		<span>Folio</span> <span>Número de Ticket</span>  <span>Monto de la compra</span>  <span>Fecha de compra</span> <span>Ciudad de compra</span> </div>

</div>

<script type="text/javascript">
ya=0;

function cerrar(){	
	$('.ventana-ejemplos').animate({'opacity':0}, 1000, function(){
		$('.ventana-ejemplos').css({'z-index':'-100'});
	});
}
function abrir() {
	$('.ventana-ejemplos').css({'z-index':'1000'});
	$('.ventana-ejemplos').animate({'opacity':1}, 1000, function(){
		if (ya == 0) {
			tickets();
		};		
	});
}

$('a.ver-ticket').click(function() {
	abrir();
});

$('.ventana-ejemplos .close').click(function() {
	cerrar();
});

$(document).ready(function() {
	tickets();
});

</script>
