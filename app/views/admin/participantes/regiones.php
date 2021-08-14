<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view('admin/header'); ?>
<?php $this->load->view( 'admin/navbar' ); ?>

	<?php
	 	if (!isset($retorno)) {
	      	$retorno ="admin";
	    }
	?>    

	<div class="container">

		<div class="row">

			<br>
				<div class="col-xs-12 col-sm-12 col-md-12 marginbuttom">
				<div class="col-xs-12 col-sm-12 col-md-12"><h4>Regiones</h4></div>
			</div>	

			<div class="col-sm-3 col-md-3 marginbuttom">
				<a id="exportar_reportes" nombre="reportes_regiones" type="button" class="btn btn-success btn-block">Exportar</a>
			</div>

			<div class="col-xs-12 col-sm-4 col-md-3 marginbuttom">
				<a id="exportar_reportes" nombre="exportar_todo_regiones" type="button" class="btn btn-success btn-block">Exportar todo</a>
			</div>			

			<div class="col-xs-12 col-sm-6 col-md-2 bloq_id_medida" >
					<div class="form-group">
						<label for="id_region" class="col-sm-12 col-md-12">Regiones</label>
						<div class="col-sm-12 col-md-12">
							<select name="id_region" id="id_region" class="form-control">
									<?php foreach ( $regiones as $region ){ ?>
											<option value="<?php echo $region->id_region; ?>"><?php echo $region->region; ?></option>
									<?php } ?>
							</select>
						</div>
					</div>
			</div>					


		</div>
		<br>
		<div class="container row">
		<div class="panel panel-primary">
			<div class="panel-heading">Listado por Regiones</div>
			<div class="panel-body">
			<div class="col-md-12">
				
				<div class="table-responsive">

					<section>
						<table id="tabla_regiones" class="display table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
							<thead>
								<tr>
									
									<th class="text-center cursora" width="5%">Fecha Creación</th>
									
									<th class="text-center cursora" width="15%">Nombre</th>
									<th class="text-center cursora" width="7%">Usuario</th>
									<th class="text-center cursora" width="9%">Contraseña</th>
									<th class="text-center cursora" width="9%">Email </th>
									<th class="text-center cursora" width="9%">Celular</th>			
									
									<th class="text-center cursora" width="9%">Estado</th>
									<th class="text-center cursora" width="9%">Ciudades</th>
									<th class="text-center cursora" width="9%">total</th>
									<th class="text-center cursora" width="9%">Detalle</th>

								</tr>
							</thead>
						</table>
					</section>
				</div>
			</div>
		</div>
		</div>
		
		<div class="row">

			<div class="col-sm-8 col-md-9"></div>
			<div class="col-sm-4 col-md-3">
				<a href="<?php echo base_url(); ?><?php echo $retorno; ?>" class="btn btn-danger btn-block"><i class="glyphicon glyphicon-backward"></i> Regresar</a>
			</div>

		</div>
		<br/>
	</div>

<?php $this->load->view('admin/footer'); ?>


<div class="modal fade bs-example-modal-lg" id="modalMessage2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>	
	

<div class="modal fade bs-example-modal-lg" id="modalMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>	