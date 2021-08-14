<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>
<?php $this->load->view( 'navbar' ); ?>

<?php 
	//print_r((trim($record->tarjeta)));
	//die;
?>

<div class="container intro">

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h2 class="text-center">@<?php echo $this->session->userdata( 'nick_participante' ); ?></h2>
		</div>
	</div>

	<div class="">								
		<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1 col-xs-12 mimarcador">
			<?php 	
				$suma_total =0;
				$suma_actual =0;
				$total_redes = 0;

				
			/*
			$suma_actual = 
					((int)$record->cant1_actual)*$this->session->userdata('ip1') +
					((int)$record->cant2_actual)*$this->session->userdata('ip2') +
					((int)$record->cant3_actual)*$this->session->userdata('ip3') +
					((int)$record->cant4_actual)*$this->session->userdata('ip4') +
					((int)$record->cant5_actual)*$this->session->userdata('ip5');
			*/

		if (($record)) {					
				$suma_total = 
						((int)$record->cant1)*$this->session->userdata('ip1') +
						((int)$record->cant2)*$this->session->userdata('ip2') +
						((int)$record->cant3)*$this->session->userdata('ip3') +
						((int)$record->cant4)*$this->session->userdata('ip4') +
						((int)$record->cant5)*$this->session->userdata('ip5');

				$total_redes = $record->total_redes ;		

				//echo $suma_actual;
				//echo '<div class="col-md-8"><span class="textosmarcador text-center">PUNTOS ACTUAL: </span><span class="textosmarcador2 text-center">'.$record->nombre.' '.$record->Apellidos.'</span></div><div class="col-md-4"><span class="marcadorconte">'.$suma_actual.'</span></div>';

				echo '<div class="col-md-8"><span class="textosmarcador">PUNTOS TOTALES:</span></div><div class="col-md-4"><span class="marcadorconte">'.($suma_total).'</span></div>';


				echo '<div class="col-md-8"><span class="textosmarcador">PUNTOS X REDES:</span></div><div class="col-md-4"><span class="marcadorconte">'.($total_redes).'</span></div>';

				
				echo '<div class="col-md-8"><span class="textosmarcador">TOTAL:</span></div><div class="col-md-4"><span class="marcadorconte">'.($total_redes+$suma_total).'</span></div>';
				
	 }			
			?>
			
		</div>
	</div>	

</div>


<?php $this->load->view( 'footer' ); ?>
