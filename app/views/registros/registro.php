<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>
<?php $this->load->view( 'navbar' ); ?> 
 
 <?php 

	if (!isset($retorno)) {
      	$retorno ="tarjetas"; //registro_ticket
    }

 $attr = array('class' => 'form-horizontal', 'id'=>'form_reg_participantes','name'=>$retorno,'method'=>'POST','autocomplete'=>'off','role'=>'form');
 echo form_open('validar_registros', $attr);
?>		


<?php
								if ($GLOBALS['open']==1) {
								?>  
<div class="container registro text-center">	
	<!-- <h1>Registro de Usuarios</h1> -->
	<img src="<?php echo base_url()?>img/registro-cuenta.png" style="margin: 25px auto 25px;" class="img-responsive sinizquierdo">
	<div class="panel-body">
	<div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12 fondoformularios">
			
			
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

						<div class="form-group">
						
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							
							<input type="text" class="form-control" id="nombre" name="nombre" placeholder="NOMBRE(S)">
							<span class="help-block" style="color:white;" id="msg_nombre"> </span> 
						</div>
					</div>

					<div class="form-group">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							
							<input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="APELLIDOS">
							<span class="help-block" style="color:white;" id="msg_apellidos"> </span> 
						</div>
					</div>

					<div class="form-group">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							
							<input type="email" class="form-control minuscula" id="email" name="email" placeholder="CORREO ELECTRÓNICO">
							<span class="help-block" style="color:white;" id="msg_email"> </span> 
						</div>
					</div>


					<div class="form-group">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<label for="fecha_nac" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 control-label">FECHA DE NACIMIENTO:</label>
							<div class="fecha_nac">
							  <input type="hidden" id="fecha_nac"  class="form-control">
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<span class="help-block" style="color:white;" id="msg_fecha_nac"> </span>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<input type="text" class="form-control" id="calle" name="calle" placeholder="CALLE">
							<span class="help-block" style="color:white;" id="msg_calle"> </span> 
						</div>
					</div>		

					<div class="form-group">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<input type="text" class="form-control" id="numero" name="numero" placeholder="NÚMERO">
							<span class="help-block" style="color:white;" id="msg_numero"> </span> 
						</div>
					</div>	

					<div class="form-group">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<input type="text" class="form-control" id="colonia" name="colonia" placeholder="COLONIA">
							<span class="help-block" style="color:white;" id="msg_colonia"> </span> 
						</div>
					</div>	
					
					<div class="form-group">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<input type="text" class="form-control" id="municipio" name="municipio" placeholder="MUNICIPIO">
							<span class="help-block" style="color:white;" id="msg_municipio"> </span> 
						</div>
					</div>	
					
					<div class="form-group">
					
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<input type="text" class="form-control" id="cp" name="cp" placeholder="CÓDIGO POSTAL">
							<span class="help-block" style="color:white;" id="msg_cp"> </span> 
						</div>
					</div>
					
					<div class="form-group">
						
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						
							
								<!-- <select name="id_estado" id="id_estado" class="form-control">
									<option value="" disabled selected>CIUDAD</option>
										<?php foreach ( $estados as $estado ){ ?>
												<option value="<?php echo $estado->id; ?>"><?php echo $estado->nombre; ?></option>
												
										<?php } ?>
								</select>
								-->
								 <input type="text" class="form-control" id="ciudad" name="ciudad" placeholder="CIUDAD DE RESIDENCIA">
								 <span class="help-block" style="color:white;" id="msg_ciudad"> </span>
							
						</div>
					</div>
					

		
				</div>


				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
						
					
					<div class="form-group">
						<!-- <label for="id_estado" class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Estado:</label> -->
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								 <select name="id_estado_compra" id="id_estado_compra" class="form-control">
									<option value="" disabled selected>ESTADO</option>
										<?php foreach ( $estados as $estado ){ ?>
												<option value="<?php echo $estado->id; ?>"><?php echo $estado->nombre; ?></option>
												
										<?php } ?>
								</select> 
								<!-- <input type="text" class="form-control" id="estado" name="estado" placeholder="ESTADO"> -->
								 <span class="help-block" style="color:white;" id="msg_estado"> </span>
							
						</div>
					</div>	
					
						
					<div class="form-group">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<input type="text" class="form-control" id="celular" name="celular" placeholder="TÉLEFONO CELULAR">
							<span class="help-block" style="color:white;" id="msg_celular"> </span> 
						</div>
					</div>

					<div class="form-group">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<input type="text" class="form-control" id="telefono" name="telefono" placeholder="TÉLEFONO FIJO O CELULAR 2">
							<span class="help-block" style="color:white;" id="msg_telefono"> </span> 
						</div>
					</div>

					

					<div class="form-group">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<input type="text" class="form-control" id="nick" name="nick" placeholder="NOMBRE DE USUARIO" placeholder="Nombre de usuario">
							<span class="help-block" style="color:white;" id="msg_nick"> </span> 
						</div>
					</div>
			
					<div class="form-group">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<input type="password" class="form-control" id="pass_1" name="pass_1" placeholder="CONTRASEÑA">
							<span class="help-block" style="color:white;" id="msg_pass_1"> </span> 
						</div>
					</div>

					<div class="form-group">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<input type="password" class="form-control" id="pass_2" name="pass_2" placeholder="CONFIRMAR CONTRASEÑA">
							<span class="help-block" style="color:white;" id="msg_pass_2"> </span> 
						</div>
					</div>			


					
					<div class="form-group" style="padding: 22px !important;">
						<input style="float:left;width:20px;" type="checkbox" id="coleccion_id_aviso" value="1"  checked name="coleccion_id_aviso" />
			              <label style="line-height: 26px;">
			              		Acepto <a href="<?php echo base_url().'legales'; ?>" class="linkaviso" target="_blank">términos y condiciones</a>
			              </label>
			              <span class="help-block" id="msg_coleccion_id_base"> </span> 


						  <input style="float:left;width:20px;" type="checkbox" id="coleccion_id_base" checked value="1"  name="coleccion_id_base" />
			              <label style="line-height: 26px;">
			              		Acepto <a href="<?php echo base_url().'aviso'; ?>" class="linkaviso" target="_blank">el aviso de privacidad</a>
			              </label>     
			              <span class="help-block" id="msg_coleccion_id_aviso"> </span> 

			                          
			              

					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
				<button type="submit" class="btn btn-info" value="REGISTRARME"/>
					<span class="registrarm ingresar"><img src="<?php echo base_url()?>img/registrarme.png"></span>
				</button>
		</div>
			
				</div>





<!--  -->


		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
           <span class="help-block" style="font-weight: bold;
    font-size: 18px;
    
    color: #ffffff !important;
    background-color: #eb1c2f;" id="msg_general"> </span>
        </div>			
		
		</div>

				
	</div>

	
</div>

<?php echo form_close(); ?>


<?php

								} else {
									redirect(base_url(), 'refresh');

								}
								?>  
								
<?php $this->load->view('footer'); ?>

<div class="modal fade bs-example-modal-lg" id="modalMessage" ventana="facebook" valor="<?php echo $retorno; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>



<div class="modal fade bs-example-modal-lg" id="modalInstrucciones" ventana="instrucciones" valor="<?php echo $retorno; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>