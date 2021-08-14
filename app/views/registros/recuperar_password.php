<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>
<?php $this->load->view( 'navbar' ); ?>
<style>
	a, a:hover, a:focus{
		color: #002d3f;
	}
</style>
<?php 
	if (!isset($retorno)) {
      	$retorno ="registro_ticket";
    }
 ?>  
	<div class="container">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h1 class="text-center">¿No recuerdas tu contraseña?</h1>
		</div>
		

		<div class="row">			
			<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1 col-xs-12  fondoformularios">
				<div class="formulario-fondos">
					<?php echo form_open('validar_recuperar_participante', array( 'id' => 'form_logueo_participante', 'name' => $retorno, 'class' => 'form-horizontal', 'method' => 'POST', 'autocomplete' => 'off', 'role' => 'form' ) ); ?>
						
						<div class="col-lg-12  text-center">
							<p>Ingresa tu correo electrónico para recuperar tu contraseña</p>
						</div>

						<div class="form-group">
							<div class="col-lg-12">
								<input type="email" class="form-control" id="email" name="email" placeholder="Correo Electrónico">
								<span class="help-block" style="color:white;" id="msg_email"> </span> 
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				           <span class="help-block" style="color:white;" id="msg_general"> </span>
				        </div>
				        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
				        	<span class="recuperarspan" style="font-size: 20px;text-align: center;font-weight: bold">¿Necesitas ayuda? Comunícate al 667 333 00 00 o envía mensaje al correo <a class="recuperarspan" href="mailto:promociones@radioley.com">promociones@radioley.com</a></span>
				        </div>
				        <div class="form-group">
							<div class="col-lg-6 text-center">
								<a href="<?php echo base_url(); ?><?php echo $retorno; ?>" class="btn ingresar">REGRESAR</a>
							</div>
							<div class="col-lg-6 text-center">
								<button type="submit" class="btn ingresar">RECUPERAR</button>
							</div>
						</div>
					<?php echo form_close(); ?>
				</div>
			</div>			
		</div>

	</div>
<?php $this->load->view( 'footer' ); ?>