<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>
<?php $this->load->view( 'navbar' ); ?>

<?php 
	//print_r((trim($record->tarjeta)));
	//die;
?>

<div class="row intro marcasu">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
		<img src="<?php echo base_url()?>img/mi-marcador.png" style="margin: 25px auto 25px;" class="img-responsive sinizquierdo">
	</div>
	<div class=" text-center mimarcador">
		<div class="col-md-offset-3 col-md-6">
			<h1 class="text-center" style="margin: 48px 0px;"><span class="nombreparticipante">@<?php echo $this->session->userdata( 'nick_participante' ); ?></span></h1>
							
							<div class="col-md-8 col-sm-8 col-xs-8 text-center"><span class="textosmarcador" style="text-decoration: underline;"><b>Ticket</b></span></div>
						
							<div class="col-md-4 col-sm-4 col-xs-4 text-center"><span class="textosmarcador" style="text-decoration: underline;"><b>Puntos</b></span></div>
							

				<?php 




						$total_con_doble =0;
						$suma_total1 =0;					
					 	if (($detalles)) {	
				 		foreach ($detalles as $key => $value) {
				 			//print_r($value->cant1);
				 			$valor1= ( ((int)$value->cant1) > 5 ? 5 : ((int)$value->cant1))*$this->session->userdata('ip1');
				 			$valor2= ( ((int)$value->cant2) > 10 ? 10 : ((int)$value->cant2))*$this->session->userdata('ip2');
							$valor3= ( ((int)$value->cant3) > 20 ? 20 : ((int)$value->cant3))*$this->session->userdata('ip3');
							$valor4= ( ((int)$value->cant4) > 55 ? 55 : ((int)$value->cant4))*$this->session->userdata('ip4');
							$valor5= ( ((int)$value->cant5) > 1 ? 1 : ((int)$value->cant5))*$this->session->userdata('ip5');

							
				 						 			
				 			$valor1a = ((int)$value->cant1);
				 			$valor2a = ((int)$value->cant2);
				 			$valor3a = ((int)$value->cant3);
				 			$valor4a = ((int)$value->cant4);
				 			$valor5a = ((int)$value->cant5);
				 		


				 			$suma_detalle = 
							$valor1+
							$valor2+
							$valor3+
							$valor4+
							$valor5;
							
							

							echo '<div class="col-md-12 col-xs-12">';
							//echo		'<div class="col-md-3 col-sm-3 col-xs-6 text-center"><span class="textosmarcador">'.$value->nick.'</span></div>';
							echo		'<div class="col-md-8 col-sm-8 col-xs-8 text-center"><span class="textosmarcador">'.$value->ticket.'</span></div>';

							echo		'<div class="col-md-4 col-sm-4  col-xs-4 text-center"><span class="textosmarcador">'.$suma_detalle.'</span></div>';
							
							// if ($value->total_redes<>100) {
							// 	echo '<div class="col-md-3 col-sm-3 col-xs-3 text-center"><span class="textosmarcador">NO</span></div>';
							// }else{
							// 	echo '<div class="col-md-3 col-sm-3 col-xs-3 text-center"><span class="textosmarcador">SI</span></div>';
							// }

							echo  '</div>';		
							echo '<br/>'	;
							$suma_total1 += $suma_detalle;
				 			
				 		}
				 		
				 	}	

			?>

			<?php 	
				$suma_total =0;
				$suma_actual =0;
				$total_redes = 0;

				
		

		if (($record)) {		



				// $suma_total = 
				// 		((int)$record->cant1)*$this->session->userdata('ip1') +
				// 		((int)$record->cant2)*$this->session->userdata('ip2') +
				// 		((int)$record->cant3)*$this->session->userdata('ip3') +
				// 		((int)$record->cant4)*$this->session->userdata('ip4') +
				// 		((int)$record->cant5)*$this->session->userdata('ip5');

				$total_redes = $record->total_redes ;		
			
				echo '<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1 col-xs-12"><div class="col-md-12 text-center"><span class="textosmarcador" style="margin-top:50px;font-size: 27px;">PUNTOS ACUMULADOS</div>
				<div class="col-md-12 text-center fondomarcador">'.($total_redes+$suma_total1).'</div></div>';
				
	 }	






			?>
			<div class="col-md-12">
				<img src="<?php echo base_url()?>img/marcardo2.png" class="img-responsive sinizquierdo" style="margin-top: 50px;display: inline-block;">
			</div>
			</div>
			
			
			

		



	</div>	
	<!-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
			<img src="../img/marcadorleche.png" class="" style="max-width:100%;">
		</div> -->

	
</div>


<?php $this->load->view( 'footer' ); ?>

