<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>
<?php $this->load->view( 'navbar' ); ?>
 
 <?php 

	if (!isset($retorno)) {
      	$retorno ="tarjetas";
    }
 ?>   

	<div class="container ingresar">
		<div class="panel-body">
		
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h1 class="text-center">Entrar a mi cuenta</h1>
			</div>
		
		
		
			
			<div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12 fondoformularios loginfor" style="">				
				
				<div class="formulario-fondos">

					<?php
 					 $attr = array( 'id' => 'form_logueo_participante','name'=>$retorno, 'class' => 'form-horizontal', 'method' => 'POST', 'autocomplete' => 'off', 'role' => 'form' );
					 echo form_open('validar_login_participante', $attr);
					?>
						 <div class="form-group">
							
							
								<hr>
								<!--<input type="email" class="form-control" id="email" name="email" placeholder="CORREO ELECTRÓNICO"> -->
								<input type="text" class="form-control" id="nick" name="nick" placeholder="USUARIO"> 
								<span class="help-block" style="color:white;" id="msg_email"> </span> 
						
						</div>
					
						<div class="form-group">
							
								<input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="CONTRASEÑA">
								<span class="help-block" style="color:white;" id="msg_contrasena"> </span> 
								
								
						<hr>
							
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				           <span class="help-block" style="color:white;" id="msg_general"> </span>
				        </div>						
						<div class="form-group">

							
							
						
							<div class="col-md-12 text-center">								
								<button type="submit" class="ingresar">INGRESAR</button>
								<?php
if ($GLOBALS['open']==1) {
    #$date occurs in the future
?>	


      						<a href="<?php echo base_url(); ?>registro_usuario" class="ingresar">crear cuenta</a> 
										

<?php

} else {
?>




<?php
 }
?>	

							</div>
							</div>
							<div class="col-md-12 text-center" >
								<a class="olvidaste ingresarhome otroboton2" href="<?php echo base_url(); ?>recuperar_participante">¿Olvidaste tu contraseña?</a>
							</div>
						</div>
					<?php echo form_close(); ?>
				</div>
			</div>
			<div class="col-md-3"></div>
		</div>
	</div>
<?php $this->load->view( 'footer' ); ?>


<div class="modal fade bs-example-modal-lg" id="modalInstrucciones" ventana="instrucciones" valor="<?php echo $retorno; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>